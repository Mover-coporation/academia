<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Describes an activity that can be added to a calculator for computation.
 * The activity is either an expense or an income.
 *
 */
 
class Activity extends GenericEntity {

	/**
	 * Constructor
	 *
	 * @param Array $newattributes Any new attributes that may be passed to the constructor
	 */
	function __construct($newattributes = array()) {
		$attributes = array(
			"id" => "",
			"effectivedate" => date('m/d/Y H:i:s'),	
			"name" => "",
			"type" => "",
			"category" => "",
			"subcategory" => "",
			"employeetype" => array(),
			"employeetypename" => "",
			"description" => "",
			"amount" => "",
			"active" => "Yes",
			"createdby" => "",
			"datecreated" => date('m/d/Y H:i:s'),
			"lastupdatedby" => "",
			"lastupdatedon" => "",
			"expirydate" => NULL,
			"noofemployees" => "0",
			"noofmonths" => "0",
			"employeetypeforcomputation" => "",
			"employeegross" => "0"
			);
			# load the attributes by calling the parent constructor. This is to prevent changing
			# attributes at run time
			parent::__construct(array_merge($attributes, $newattributes));
			$this->setTable("activity");
			$this->setDateFields(array("effectivedate", "datecreated","lastupdatedon", "expirydate"));
			$this->setIgnoreFields(array("id", "employeetype",  "employeetypename","noofemployees","noofmonths", "employeetypeforcomputation", "employeegross"));
			$this->setSlowChanging(true);
			$this->setUseViewForPopulate(true);
	}

	/**
	 * Save the activity then the employee types
	 */
	function save() {
		# first save the activity
		parent::save();
		# check whether any errors occured
		if ($this->hasError()) {
			return false;
		}

		# add the new employee types
		$query = "INSERT INTO activityemployeetypes (effectivedate, activityid, employeetypeid, datecreated, createdby) VALUES ";
		foreach($this->getEmployeeType() as $value) {
			# generate an SQL statement for the employee types for the activities
			$query .= "(NOW(), '".$this->getID()."', '".$value."', NOW(), '".$this->getCreatedBy()."'), ";
		}
		# remove the last comma and space
		$query = substr($query, 0,-2);
		$result = $this->getDB()->executeQuery($query);
		if (!$result) {
			# add the error message to the string
			$this->setError($this->getDB()->getError());
			return false;
		}
		# return the id of the activity
		return $this->getID();
	}
	/**
	 * Update the entity. First expire any existing activity employee types
	 *
	 * @return unknown
	 */
	function update() {
		# expire the existing employee types
		$expire_query = "UPDATE activityemployeetypes SET expirydate = NOW(), currentflag = 'N' WHERE currentflag = 'Y' AND activityid = '".$this->getID()."'";
		$expireresult = $this->getDB()->executeQuery($expire_query);
		if (!$expireresult) {
			# add the error message to the string
			$this->setError($this->getDB()->getError());
			return false;
		}
		# now update the activity
		return parent::update();
	}
	/**
	 * Validate the activity
	 *
	 * @return unknown
	 */
	function validate() {
		# check that the name is defined
		if (trim($this->getName()) == "") {
			$this->setError("Error: The Name must be defined.");
			return false;
		}

		# check that the type is defined
		if (trim($this->getType()) == "") {
			$this->setError("Error: The Type must be defined.");
			return false;
		}
		# check that the category is defined
		if (trim($this->getCategory()) == "") {
			$this->setError("Error: The Category must be defined.");
			return false;
		}

		# check that the employee types are defined
		if (count($this->getEmployeeType()) == 0) {
			$this->setError("Error: The Employee Type must be defined.");
			return false;
		}

		# check that the amount is defined
		if (trim($this->getAmount()) == "") {
			$this->setError("Error: The Amount must be defined.");
			return false;
		}

		# check that the amount is a number
		if (!is_numeric(trim($this->getAmount()))) {
			$this->setError("Error: The Amount '".$this->getAmount()."' is not a valid number.");
			return false;
		}
		# check that the amount is not zero
		if ($this->getAmount() == 0) {
			$this->setError("Error: The Amount cannot be zero.");
			return false;
		}
		# check that the following fields are unique i.e. name and current flag when updating
		$checksql = "SELECT * FROM ".$this->getTable()." WHERE name = '".$this->getName()."' AND currentflag = 'Y' AND ".$this->getIDColumn()." <> '".$this->getID()."'";
		#echo "<br><br>".$checksql;
		if ($this->getDB()->recordExists($checksql)) {
			# exists so return an error message
			$this->setError("Error: The Name that you have specified has already been assigned.");
			return false;
		} else {
			# record does not exist and meets all criteria so save a new record
			return true;
		}
	}
	/**
	 * Return the name from the category and sub category values
	 *
	 * @return String the displayed name of the activity from the category and subcategory values
	 */
	function getActivtyNameForDisplay() {
		$theamount = formatNumber($this->getAmount());
		if ($this->getCategory() == "Annual") {
			return $this->getName()." (".$theamount." - Annual)";
		} elseif ($this->getCategory() == "Per Month") {
			return $this->getName()." (".$theamount."/Month)";
		} elseif ($this->getCategory() == "Per Employee Per Month") {
			return $this->getName()." (".$theamount."/Month)";
		} elseif ($this->getCategory() == "Per Employee Earning Percentage") {
			if ($this->getSubCategory() == "Max Social") {
				return $this->getName()." (".$theamount."% of Gross -- Less or Equal to )".
				MAX_SOCIAL_SECURITY;
			} else {
				return $this->getName()." (".$theamount."% of Gross)";
			}
		} elseif ($this->getCategory() == "Per Employee") {
			return $this->getName()." (".$theamount."/per employee)";
		} elseif ($this->getCategory() == "One Off") {
			return $this->getName()." (".$theamount." - One Off)";
		}
		return $this->getName();
	}


	

	# Function to compute the total value of the activity based on its category
	function getTotalValue() {
		# first check if the employee type is allowed
		# if no employee type is specified assume that its allowed
		if (trim($this->getEmployeeTypeforComputation()) == "") {
			# not specified so the computation is allowed
		} else {
			if (in_array($this->getEmployeeTypeforComputation(), $this->getEmployeeType())) {
				# do nothing
				# all employees contribute to this expense
			} else {
				# the employee type is not all, therefore the employee type used for
				# the computation must match that specified for the
				return 0;
			}
		}

		switch (strtolower($this->getCategory())) {
			case strtolower("Annual"):
				return $this->getAmount();
				break;
			case strtolower("Per Employee"):
				return $this->getAmount() * $this->getNoOfEmployees();
				break;
			case strtolower("Per Month"):
				return $this->getAmount() * $this->getNoOfMonths();
				break;
			case strtolower("Per Employee Per Month"):
				return $this->getAmount() * $this->getNoOfMonths() * $this->getNoOfEmployees();
				break;
			case strtolower("Per Employee Earning Percentage"):
				if ($this->getSubCategory() == "Max Social") {
					if ($this->getAmount() > MAX_SOCIAL_SECURITY) {
						return $this->getAmount() * MAX_SOCIAL_SECURITY/100;
					} else {
						return $this->getAmount() * $this->getEmployeeGross()/100;
					}
				} else {
					return $this->getAmount() * $this->getEmployeeGross()/100;
				}
				break;
			case strtolower("One Off"):
				return $this->getAmount();
				break;
			default:
				return 0;
					
		}
	}

	function processPost($formvalues) { 
		# change the employee type to an array
		# first check if the employee type value exists in the formvalues, this gives an E_NOTICE warning
		# for PHP 5
		if (isset($formvalues['employeetype'])) {
			# check if the employee type value is an array
			if (!is_array($formvalues['employeetype'])) {
				# Do not add the employee type if its an empty string
				if (empty($formvalues['employeetype'])) {
					$formvalues['employeetype'] = array();
				} else {
					$formvalues['employeetype'] = explode(",", $formvalues['employeetype'] );
				}
			}
		}
		parent::processPost($formvalues);
	}

	/**
	 * Return whether or not the activity is an expense
	 *
	 * @return TRUE if the activity is an expense, and FALSE if its not an income
	 */
	function isExpense() {
		if (trim($this->getType()) == trim("Expense")) {
			return true;
		}
		return false;
	}
	/**
	 * Return whether or not an activity is an income
	 *
	 * @return TRUE if the activity is an income, and FALSE if its an Expense
	 */
	function isIncome() {
		if (trim($this->getType()) == trim("Income")) {
			return true;
		}
		return false;
	}

}
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* @desc This class contains database connection functionality and the following base attributes for an entity
* 
* (a) db - the Database Access class instance
* (b) datefields - an array containing the date fields. These are saved differently from the string and number fields
* (c) ignorevars - an array of the attributes to ignore when generating an insert statement
* (d) passwordfield - the password field if any, optional
* (e) table - the name of the table to which the data for the object is saved and loaded into
* (f) slowchanging - whether the table is slow changing or not. If the table is slow changing, the old row is expired before the current row is inserted.
* (g) idfield - the name of the column with the id values
* 
*/
class GenericEntity extends Generic {
	private $db = null;
	private $datefields   = array();
	private $ignorefields = array();
	private $passwordfield = array();
	private $table        = "";
	private $idcolumn     = "id"; 
    private $isactive     = "Y";
    private $foreignkeyfields = array(); 
    private $slowchanging = true;

	# whether or not to use the view when populating the object
	private $userviewforpopulate = false;
	private $viewprefix   = "c_";
			
	//constructor  - takes an array of attribute names
	function __construct($newattributes = array()){

	    if (!function_exists('get_instance')) return "Can't get CI instance";
	        $this->CI= &get_instance();
		# load the attributes by calling the parent constructor. This is to prevent changing
		# attributes at run time
		parent::__construct($newattributes );
		# the database connection object
		$this->CI->load->library('kernel/database');
		$this->db = $this->CI->database;
	}

	/**
	 * Return the database instance
	 *
	 * @return Database The database instance
	 */
	function getDB() {
		return $this->db;
	}

	/**
	 * Return the array of fields containing dates
	 * 
	 * @return Array array of the fields containing dates
	 */
	function getDateFields() {
		return $this->datefields;
	}

	/**
	 * Set the names of the fields containing date values
	 *
	 * @param Array $array Array of names of fields containing dates
	 */
	function setDateFields($array) { 
		$this->datefields = $array;
	}
	
	/**
	 * Add more date format fields to the registry
	 *
	 * @param Array $array array containing the name of the additional date fields
	 */
	function addDateFields($array) {
		$this->setDateFields(array_unique(array_merge($this->datefields, $array)));
	} 

	/**
	 * Return the array containing the names of the fields to be ignored
	 *
	 * @return Array array of the names of the fields to be ignored
	 */
	function getIgnoreFields() {
		return $this->ignorefields;
	}

	/**
	 * Set the names of the fields to be ignored
	 *
	 * @param Array $array Array of field names to be ignored
	 */
	function setIgnoreFields($array) {
		$this->ignorefields = $array;
	}
	/**
	 * Add more fields to be ignored when saving to the database
	 *
	 * @param Array $array array containing the names the additional fields to be ignored when saving to the database
	 */
	function addIgnoreFields($array) {
		$this->setIgnoreFields(array_unique(array_merge($this->ignorefields, $array)));
	} 

	function getPasswordField() {
		return $this->passwordfield;
	}

	function setPasswordField($newpasswordfield) {
		$this->passwordfield = $newpasswordfield;
	}

	/**
	 * Return the name of the table to which the data is to be saved
	 *
	 * @return String The name of the table to which the data is to be saved
	 */
	function getTable() {
		return $this->table;
	}

	/**
	 * Set the name of the table to which the data is to be saved
	 *
	 * @param String $newtable The name of the table to which the data is to be saved
	 */
	function setTable($newtable) {
		$this->table = $newtable;
	}

	function isSlowChanging() {
		return $this->slowchanging;
	} 

    function isActive() {
        return $this->isactive;
    }

	function setSlowChanging($newslowchanging) {
		$this->slowchanging = $newslowchanging;
	}
	
   /**
    * The name of the column containing the unique system identifier in the table. The default name is id
    *
    * @return String the name of the column containing the unique system identifier in the table
    */
	function getIDColumn() {
		return $this->idcolumn;
	}

	/**
	 * Set the name of the column containing the unique system identifier
	 *
	 * @param String $newidcolumn The name of the column containing the unique system identifier
	 */
	function setIDColumn($newidcolumn) { ///echo "sdfdsf";
		$this->idcolumn = $newidcolumn;
	}

	/**
	 * Whether or not to use a view when loading the details of the enitity from the database
	 *
	 * @return Boolean Whether or not a view is to be used when loading the details of the entity from the database
	 */
	function getUseViewForPopulate() {
		return $this->userviewforpopulate;
	}

	/**
	 * Set whether or not to use a view when loading the details of the enitity from the database
	 *
	 * @param Boolean $newuserviewforpopulate
	 */
	function setUseViewForPopulate($newuserviewforpopulate) {
		$this->userviewforpopulate = $newuserviewforpopulate;
	}

	/**
	 * The prefix added to the table name to get the name of the view
	 *
	 * @return String The prefix added to the table name to get the name of the view
	 */
	function getViewPrefix() {
		return $this->viewprefix;
	}

	/**
	 * Set the prefix added to the table name to get the name of the view
	 *
	 * @param String $newviewprefix The prefix added to the table name to get the name of the view
	 */
	function setViewPrefix($newviewprefix) {
		$this->viewprefix = $newviewprefix;
	}


	/** 
	 * Save the object to the database
	 *
	 * @return Integer the System Generated id for the object. FALSE if an error occurs while saving the object to the database
	 **/
	function save(){  
		return $this->insertFromArray($this->getTable(), 
															$this->getAllAttributes(), 
															$this->getIgnoreFields(), 
															$this->getDateFields(), 
															$this->getPasswordField(),
															$this->getForeignKeyFields());
	}

	/**
	 * Populate the object attributes form the database table
	 *
	 * @param Integer $id The system generated ID for the object
	 * @return boolean true if the population was sucessful, false if any errors occured
	 */
	function populate($id){  
		$query= $this->getQueryForPopulate($id);
		# load the data from the database
		$data = $this->CI->db->query($query);
		if (!$data) {
			# an error occured while selecting the information
			return false;
		}
		$data = $data->row_array();		
		//echo '<pre>';print_r($data);exit;
		# update the values of the object attributes
		return $this->processPost($data);
	}

	/**
	 * Build the query string to populate the object from the database table
	 *
	 * @param Integer $id The system generated ID for the object
	 * @return String The SQL query to populate the object from the database
	 */
	function getQueryForPopulate($id){
		$table_name=$this->getTable();

		if ($this->getUseViewForPopulate()) {
			# add the prefix to get the view from the table name
			$table_name = $this->viewprefix.$table_name;
		}	
		return "SELECT * FROM ".$table_name." WHERE ".$this->getIDColumn()." = '".$id."'";
	}

	/**
	 * Update the details of the object in the database
	 *
	 * @return Integer the number of rows affected by the update or false if an error occured
	 */
	function update(){
		# check if its slow changing
		if ($this->isSlowChanging()){ 
			# expire the current row
			#$query = "CALL sp_expirecurrentrecords('".$this->getTable()."', '".$this->getIDColumn()."',".$this->getID().")";        
			#echo "The query is ".$query;
			# $result = $this->getDB->executeStoredProcedure($query);
			$query = "UPDATE ".$this->getTable()." SET currentflag = 'N', expirydate = NOW() WHERE ".$this->getIDColumn()." = '".$this->getID()."' AND currentflag = 'Y'";
			$result=$this->CI->db->query($query);
			if (!$result){// echo $this->getDB()->getError();
				// an error occured while inserting the data
				return false;
			}
			//echo'-----';exit;
			# unset the id from the ignored fields, since it is usually ignored for basic inserts
			# the id field is in a numerically indexed array, so first find the key then unset the key
			$ignore = $this->getIgnoreFields();
			$id_key = array_search('id', $ignore);
			unset ($ignore[$id_key]);
			$this->setIgnoreFields($ignore);
			# set the effectvie date to the current date and time. This is to ensure that
			# this date is always current especially in cases of updates where the effective date for the
			# record being updated has to change to the current date and time
			$this->setEffectiveDate(date('m/d/Y H:i:s')); 
			# insert a new row, but the id of the current object shall be included in the insert statement to create a new unexpired row
			return $this->save();
		} else{  
			# otherwise just update the current row
			return $this->updateFromArray($this->getTable(), 
												$this->getAllAttributes(), 
												$this->getIDColumn(), 
												$this->getID(), 
												$this->getIgnoreFields(),  
												$this->getDateFields(), 
												$this->getPasswordField(),
												$this->getForeignKeyFields());
		}
	}  
      
   /**
    * Delete the record for the object from the database
    *
    * @return The number of records deleted, FALSE if an error occured
    */
	function delete() {  
		if (isEmptyString($this->getID())) { 
			$this->setError("There is no id value specified, cannot delete all the rows in the table");
			return false; 
		}
		$query = "DELETE FROM ".$this->getTable()." WHERE ".$this->getIDColumn()." = '".$this->getID()."'";
        # execute the delete query
        $result = $this->getDB()->executeQuery($query);
		
		
        if (!$result){
           	// an error occured while deleting the data
           	$this->setError($this->getDB()->getError());
           	return false;
        } else {
        	# return the number of rows updated
           	return $result;
        }
	}
	
	/**
	 * Function that sets the foreign key fields to NULL
	 * This is to fix a bug where by if an INT or BIGINT field has a value that is not an interger e.g. a string, it is set to 0 (zero) 
	 *
	 * @param An array containing all the fields that are INTs or BIGINTs
	 */
	function setForeignKeyFields($array) {
		$this->foreignkeyfields = $array;
	}
	
	/**
	 * Add more foreign key fields when saving to the database
	 *
	 * @param Array $array array containing the additional foreign key fields 
	 */
	function addForeignKeyFields($array) {
		$this->setForeignKeyFields(array_unique(array_merge($this->foreignkeyfields, $array)));
	}
	
	/**
	 * Function that returns the foreign key fields to NULL
	 * This is to fix a bug where by if an INT or BIGINT field has a value that is not an interger e.g. a string, it is set to 0 (zero) 
	 *
	 * @return An array containing all the fields that are INTs or BIGINTs
	 */
	function getForeignKeyFields() {
		return $this->foreignkeyfields;
	}
	
	/**
	 *
	 * Inserts the values of a $data array into a specified table,
	 * it also encrypts a password field if specified
	 *
	 * @param string $table The table in which the data is to be saved
	 * @param array $data The array containing the data to be saved
	 * @param array $fieldstoignore The array containing the fields to be ignored
	 * @param array $datefields The fields containing dates
	 * @param array $password_field The fields containing passwords, have to be hashed using a SHA1 function
	 * @param array $foreignkeyfields The fields containing foreign keys, have to be made null, in case of empty strings, 0 or NULL values
	 * 
	 * @return Integer The ID of the new row or FALSE if an error occurs
	 */
	function insertFromArray($table, $data, $fieldstoignore = array(), $datefields = array(), $password_field = array(), $foreignkeyfields = array())
	{  
		# check the table name
		
		
		if (trim($table) == ""){
			$this->setError("There is no table specified");
			return false;
		}

		# no data
		if (count($data) == 0){
			$this->setError("There is no data specified");
			return false;
		}

		foreach ($data as $field => $value){
			#check whether the field exists in the array of field to ignore.
			#If it does do not add it to the query fields
			if (!in_array($field, $fieldstoignore)){
				
				if($field!='iccompany'){
					$fields[]='`'.$field.'`';
					if (in_array($field, $datefields)) {
						$values[] = changeDateFromPageToMySQLFormat($value);
					} else if (in_array($field, $password_field)) {
						$values[] = "SHA1('".mysql_real_escape_string($value)."')";
					} else if (in_array($field, $foreignkeyfields)) {
						if (isEmptyString($value) or (strval($value) == "0") or strtolower($value) == "null"){
							$values[] = "NULL";
						} else {
							$values[] = "'".mysql_real_escape_string($value)."'";
						}
					} else {
						$values[] = "'".mysql_real_escape_string($value)."'";
					}
				}
			}
		}

		$field_list=join(',', $fields);
		$value_list=join(', ', $values); 

		 $query = "INSERT INTO `".$table."` (".$field_list.") VALUES (".$value_list.")"; 
			
		if ($this->CI->db->query($query)) { 
		

			# set the id of the entity
			$this->setID($this->CI->db->insert_id());  //echo $this->CI->db->insert_id();

			return $this->getID();
		} else { //echo $this->CI->db->_error_message();
			$this->setError("An error occured while updating the database. Please try again later. ".$this->CI->db->_error_message());

			# TODO: Log the query and error message
			return false;
		}
	}


	/*
	 *
	 * Updates a record in a table referenced by a specified id field-value pair
	 * using the values of $data array
	 *
	 * @param string $table The table in which the data is to be saved
	 * @param array $data The array containing the data to be saved
	 * @param array $fieldstoignore The array containing the fields to be ignored
	 * @param array $datefields The fields containing dates
	 * @param array $password_field The fields containing passwords, have to be hashed using a SHA1 function
	 * @param array $foreignkeyfields The fields containing foreign keys, have to be made null, in case of empty strings, 0 or NULL values
	 * 
	 * @return Integer The number of rows updated or FALSE if an error occurs
	 */
	function updateFromArray($table, $data, $id_field, $id_value, $fieldstoignore = array(), $datefields = array(), $password_field = array(), $foreignkeyfields = array()){
		# check the table name
		if (trim($table) == ""){
			$this->setError("There is no table specified");
			return false;
		}
		# no data
		if (count($data) == 0){
			$this->setError("There is no data specified");
			return false;
		}
		# no id field
		if (trim($id_field) == ""){
			$this->setError("There is no id field specified");
			return false;
		}
		# no id field
		if (trim($id_value) == ""){
			$this->setError("There is no id value specified, cannot update all the rows in the table");
			return false;
		} 
		foreach ($data as $field => $value){
			#check whether the field exists in the array of field to ignore.
			#If it does do not add it to the query fields
			if (!in_array($field, $fieldstoignore)){
				#check whether the field is a date field, if it is do not
				#escape it using the mysql escape characters or quotation marks
				if (in_array($field, $datefields)) {
					$fields[] = sprintf("`%s` = %s", $field, changeDateFromPageToMySQLFormat($value));
				} else if (in_array($field, $password_field)) {
					$fields[] = sprintf("`%s` = %s", $field, "SHA('".mysql_real_escape_string($value)."')");
				} else if (in_array($field, $foreignkeyfields)) {
					// possible values that result into a null foreign key
					if (isEmptyString($value) or (strval($value) == "0") or strtolower($value) == "null"){
						$fields[] = sprintf("`%s` = %s", $field, 'NULL');
					} else {
						$fields[] = sprintf("`%s` = '%s'", $field, mysql_real_escape_string($value));
					}
				} else {
					$fields[] = sprintf("`%s` = '%s'", $field, mysql_real_escape_string($value));
				}
			}
		}

		$field_list=join(',', $fields);

		$query = sprintf("UPDATE `%s` SET %s WHERE `%s` = %s", $table, $field_list, $id_field, intval($id_value));
		//echo "<br>Update query: <br>".$query."<br>";exit;
		$result = $this->CI->db->query($query);
		if (!$result){
			# error occured
			$this->setError("An error occured while updating the database. Please try again later".$this->CI->db->_error_message());

			return false;
		} else{
			# return the number of rows updated
			return $result;
		}
	}
}
?>
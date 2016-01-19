<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* Generic class used to managing the properties within a PHP application. It has the following
 * properties and behavior:
 * <ol><li> All the properties are stored in an array. The properties are initialized at the initialization of an object by passing it an array of name=value pairs which match to property=initial value</li>
 * <li>The properties are not accessed directly, but are accessed through their corresponding getter and setter methods</li>
 * <li>A special method - processPost($array) is used to update the properties with new values either from a post or from a database using key=value pairs from an array  </li>
*/
class Generic {

	# the varibales in the class
	var $vars;

	# an array containing the data to be used to populate the attributes
	# this may be required for processing 
	var $dataarray = array();
	# the error message attribute
	private $error_msg;

	/**
	* @desc Constructor
	* 
	* @param Array $array Array of attribute name-value pairs
	*/
	function __construct($array = array()) {
		$this->load($array);
	}
	/**
	 * Load an array of name value pairs into the object
	 * 
	 * @param Array $array The aray of atrribute name-value pairs
	 */
	private function load($array){ 
		if (is_array($array)){
			foreach ($array as $key => $value) {
				$this->vars[strtolower($key)] = $value;
			}
		}
	}

	/**
	 * Return all the attributes of the array that have been defined
	 *
	 * @return Array containing the attributes of the array
	 */
	function getAllAttributes() {
		return $this->vars;
	}

	/**
	 * Execute getters and setters on the instance if they do not exist
	 *
	 * @param String $method The method to execute
	 * @param Array $args The method arguments
	 * @return unknown
	 */
	function __call($method, $args){ 
		$attribute = strtolower(substr($method, 3, 1).substr($method, 4));
		$prefix = substr($method, 0, 3);
/*		if($attribute == 'idMw=='){
		echo "<br><br>The attribute is ".$attribute;
		print_r($this->vars);}*/
		switch ($prefix)  {
			 case "get":
				# return the value of the attribute
				if(isset($this->vars[$attribute]) && $this->vars[$attribute] != "")
					return $this->vars[$attribute];
				else
					return "";	

				break;
			 case "set": 
			 	# set the value of the attribute
            	$this->vars[$attribute] = $args[0];
								
            break; 
         default:
         	# do nothing
            break;
		}
	}

	/**
	 * Return a string representation of the object, this is a comma delimited name=value pairs string
	 * 
	 * @return a string of name=value pairs for the object attributes
	 */
	function __toString(){
		$string=array();

		foreach ($this->vars as $key => $value) {
			$string[] = $key."=".$value;
		}
		return implode(",", $string);
	}

	/**
	 * Populate the attributes of the object with the data
	 *
	 * @param Array $post_array The array of data values to populate the object attributes
	 * @return boolean true if the object validates after populaton, or false if there are any validation errors
	 */
	 function processPost($post_array){ //echo'palani'; echo'<pre>';print_r($_POST); exit;
		$this->dataarray = $post_array; 
		if (is_array($post_array)){
			# loop through all the attributes of the object and set only those
			# with data in the array
			//echo '<pre>';print_r($post_array);exit;
			foreach ($this->getAllAttributes() as $key => $value){
				# check if the object attribute is set in the POST array
				if (array_key_exists($key, $post_array)){
					$method="set".$key;
					//echo $method.'('.$post_array[$key].')<br />';
					$this->$method($post_array[$key]);
				}
			}//exit;
		}
        # execute custom validation code on the object
		return $this->validate();
	}

	/**
	 * Return the array of data used to populate the object attributes
	 *
	 * @return Array The array of data used to populate the object attributes
	 */
	function getDataArray() {
		return $this->dataarray;
	}

	/**
	 * Validate the class data
	 * 
	 * @return boolean true if the data is valid, otherwise false
	 */
	function validate() {
		# do nothing here
		return true; 
	}

	/**
	 * Return the error message
	 *
	 * @return String The error message
	 */
	function getError() {
		return $this->error_msg;
	}

	/**
	 * Set the error message
	 *
	 * @param String $newerror The error message
	 */
	function setError($newerror){ 
		$this->error_msg=$newerror;
	}
   
	/**
	 * Whether or not the object has an error
	 *
	 * @return boolean true if the object has an error, otherwise false
	 */
	function hasError(){ 
		if (trim($this->getError()) == "") {
			# there are no errors
			return false;
		} else {
			return true;
		}
	}
}
?>
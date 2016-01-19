<?php
/**
 * Encapsulates common database related functionality. This functionality was originally available in the commonfunctions.php
 * file, but is being moved here for better testability, maintenance and reusability.
 **/
class Database{
	private $error_msg;
    private $link;

    function __construct() {
        if (!function_exists('get_instance')) return "Can't get CI instance";
	        $this->CI= &get_instance();
    }
    
    
	/**
	 * Executes the specified query and returns a result set for processing.
	 * 
	 * @return resource The resultset identifier
	 **/
	function executeQuery($query){
		# save transaction details
		$result = $this->CI->db->query($query);
		if (!$result){
			$this->error_msg="An error occured while executing the query. Please try again later.<br>".$this->CI->db->_error_message();
			# TODO: Log the query and error message
			return false;
		}
		return $result;
	}

	# return the error message 
	function getError() {
		return $this->error_msg;
	}


	/**
	 * Executes the specified query and returns the results in an array for processing
	 *
	 * @return an array with the query results or FALSE if an error occured
	 */
	function getQueryResults($query, $limit = 0){ 
		$result=$this->executeQuery($query);

		if (!$result){
			# an error occured
			$this->error_msg="An error occured while executing the query. Please try again later.";
			# TODO: Log the query and error message
			return false;
		}
		$result = $result->result_array();		

		# no errors occured
		$data=array();

		# handle no rows returned, return an empty array
		if (count($result) == 0) {
			return array();
		}

		# fetch all the rows from the database
		foreach($result as $line ) {
			# TODO: Handle a limit to the number of rows returned
			$data[] = $line;
		}
		return $data;
	}


	/**
	 * Executes the specified query and returns the first row as an array with the column
	 * names as keys of the array.
	 * 
	 * If an error occurs while executing the query, an exception is thrown
	 *
	 * @param string $query The query to be executed
	 * 
	 * @return array containing the first row of the query
	 */
	function getRowAsArray($query){ //echo $query;
		if ($result = $this->CI->db->query($query)) {
			# turn the result into an array
			
			return $result->row_array();
		} else {
			$this->error_msg = "An error occured while executing the query. Please try again later.";
			# TODO: Log the query and error message    
			return false;
		}
	} 
	/**
	 * Returns the value of the specified setting from the database. 
	 * 
	 * If an error occurs while obtaining the value of the setting, an exception is thrown. 
	 * If the value does not exist, an empty string is returned. 
	 * 
	 * @param string $query The query to be executed
	 * 
	 * @return array containing the first row of the query
	 */
	function getSettingFromDatabase($setting){
		$query ="SELECT value FROM globalsettings WHERE setting ='".$setting."'";
		$result = $this->CI->db->query($query);

		if (!$result){
			$this->error_msg="An error occured while executing the query. Please try again later.";
			# TODO: Log the query and error message    
			# return a empty string instead of false because false shall be taken as an actual
			# value
			return "";
		}
		$result = $result->result_array();
		if (count($result) == 0) {
			// the setting does not exist
			return "";
		} else {
			// get the value of the setting
			$line = $result->row_array();
			return $line['value'];
		}
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
	 * @param string $password_field The password field, optional
	 */
	function insertFromArray($table, $data, $fieldstoignore = array(), $datefields = array(), $password_field = ""){
		# check the table name
		if (trim($table) == ""){
			$this->error_msg="There is no table specified";
			return false;
		}

		# no data
		if (count($data) == 0){
			$this->error_msg="There is no data specified";
			return false;
		}

		foreach ($data as $field => $value){
			#check whether the field exists in the array of field to ignore.
			#If it does do not add it to the query fields 
			if (!in_array($field, $fieldstoignore)){
				$fields[]='`'.$field.'`';
				if (in_array($field, $datefields)) {
					$values[] = changeDateFromPageToMySQLFormat($value);
				} else if ($field == $password_field) {
					$values[] = "SHA('".mysql_real_escape_string($value)."')";
				} else if (is_array($value)) {
					# change an array to a comma delimited string
					$values[] = "'".mysql_real_escape_string(getCommaDelimitedListFromArray($value))."'";
				} else {
					$values[] = "'".mysql_real_escape_string($value)."'";
				}
			}
		}

		$field_list=join(',', $fields);
		$value_list=join(', ', $values);

		$query = "INSERT INTO `".$table."` (".$field_list.") VALUES (".$value_list.")";
		# echo "<br><br>Insert query: ".$query."<br><br>";
		if ($this->CI->db->query($query)) {
			return $this->CI->db->insert_id();
		} else {
			$this->error_msg = "An error occured while updating the database. Please try again later. <br>".$this->CI->db->_error_message();
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
	* @param string $id_field The primary key field for the table optional
	* @param string $id_value The value of the primary key field for the row tobe updated
	* @param array $datefields The fields containing dates
	*/
	function updateFromArray($table, $data, $id_field, $id_value, $fieldstoignore = array(), $datefields = array()){
		# check the table name
		if (trim($table) == ""){
			$this->error_msg="There is no table specified";
			return false;
		}

		# no data
		if (count($data) == 0){
			$this->error_msg="There is no data specified";
			return false;
		}

		# no id field
		if (trim($id_field) == ""){
			$this->error_msg="There is no id field specified";
			return false;
		}

		# no id field
		if (trim($id_value) == ""){
			$this->error_msg="There is no id valued specified, cannot update all the rows in the table";
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
				} else {
					$fields[] = sprintf("`%s` = '%s'", $field, mysql_real_escape_string($value));
				}
			}
		}

		$field_list=join(',', $fields);

		$query     =sprintf("UPDATE `%s` SET %s WHERE `%s` = %s", $table, $field_list, $id_field, intval($id_value));
		$result    =$this->CI->db->query($query);
		if (!$result){
			# error occured
			$this->error_msg="An error occured while updating the database. Please try again later <br>".$this->CI->db->_error_message();
			return false;
		} else{
			# return the number of rows updated
			return $result;
		}
	}

	/*
	* Selects the values of a row in the database from the database returns an array
	* using the values of $data array 
	*
	* @param string $table The table in which the data is to be saved
	* @param string $id_field The primary key field for the table optional
	* @param string $id_value The value of the primary key field for the row tobe updated
	*/
	function selectIntoArray($table, $id_field, $id_value){
		$query=sprintf("SELECT * FROM `%s` WHERE `%s` = %s", $table, $id_field, intval($id_value));

		#echo "<br><br>".$query."<br><br>";
		if ($array = getRowAsArray($query)) {
			return $array;
		} else {
			return false;
		}
	}

	/**
	 * Executes the specified stored procedure.
	 *
	 * @param string $procedure The stored procedure to call
	 * 
	 * @return array $data The data from the stored procedure or FALSE if an error occured
	 **/
	function executeStoredProcedure($procedure){
		$mysqli = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DATABASE, MYSQL_PORT);
		if (mysqli_connect_errno()){
			// an error occured
			// printf("Connect failed: %s\n", mysqli_connect_error());
			$this->error_msg = printf("An error occured while connecting to the database, please try again later %s\n", mysqli_connect_error());
			return false;
		}
		# check that the stored procedure includes the word CALL
		if (substr(strtolower($procedure), 0, 4) != "call") {
			# error occured
			$this->error_msg = "The query for the stored procedure must include the CALL keyword";
			return false;
		}

		// execute the stored procedure
		// returns true if the query was sucessful
		//check if the query was successful
		if ($mysqli->multi_query($procedure)){
			
			// check if the result is an instance of the resultset class
			if ($result = $mysqli->store_result()){
				// do nothing
				//free the resultset
				$result->close();
			}

			//clear the other result(s) from buffer
			//loop through each result using the next_result() method
			while ($mysqli->next_result()){
				//free each result.
				$result = $mysqli->use_result();
				$result->close();
			}
			$mysqli->close();
			return true;
		} else{
			// error occured
			$this->error_msg = "An error occured while updating the database, please try again later ".$mysqli->error;
			# TODO: Log the query and error message 
			$mysqli->close();    
			return false;
		}

	} 
	/**
	 * Open a MYSQLI Database connection. This is used for executing stored procedures and all the
	 * connections will move to this
	 *
	 */
	function openMySQLIConnection(){
		// open a mysqli connection
		$mysqli = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DATABASE, MYSQL_PORT);

		if (mysqli_connect_errno()){
			// an error occured
			// printf("Connect failed: %s\n", mysqli_connect_error());
			$this->error_msg = printf("An error occured while connecting to the database, please try again later %s\n", mysqli_connect_error());
			return false;
		}
		return $mysqli;
	} 

	/**
* Whether or not a query has returned results
* 
* @param $data the query results
* 
* @return FALSE if the input parameter is false or an empty array, otherwise returns true if the input
* value is a resource or an array with data. 
* 
* TODO: SM - 13Nov07 - clean up the definition for this method
**/
	# 
	# 
	function queryHasResults($data){//print_r($data);exit;
		if (!$data) {
			# an error occured
			return false;
		}
		if (is_array($data)){
			if (count($data) == 0) {
				return false;
			} else {
				return true;
			}
		} else{
			# this is for result sets that are returned
			return true;
		}
	}   
	
	/**
	 * Check whether a record exists before you insert a new one
	 */
	function recordExists($query) { 
		return $this->queryHasResults($this->getRowAsArray($query));
		
		
	}
	
	/**
	 * Get the number of rows from the SQL query. Returns false if there are no results
	 *
	 * @param String $query The SQL query string to be executed	 
	 * @return  Integer The number of rows in the result set
	 */
	function getNumberOfRows($query) {
		$rowcount = $this->executeQuery($query);
    	if (!$rowcount){
    		return false;
    	}else {
    		return $rowcount->num_rows();
    	}			
	}	
}
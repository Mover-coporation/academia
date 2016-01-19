<?php

/*
CODE MOVERS
manage account creation deactiviation etc 
*/

class Account  extends CI_Model
{


	function __constructor()
	{
		 parent::__construct();
		 $this->load->model('Query_reader', 'Query_reader', TRUE);
		 $this->cur_school_details = $this->session->userdata('schoolinfo');
	}
	
	
	#New Account 
	function new_account($level = 'system_account'){
		$_POST = clean_form_data($_POST);		
		switch($level)
		{
			
			case 'system_account':
			
			
				$required_fields = array('account_name','account_email','account_username','account_password');		
				//validate more issues
				#validate form fields like emails and stuff like that 	
				$validation_results = validate_form('', $_POST, $required_fields);
				
				#$_POST['account_password'] = sha1($_POST['account_password']);
				if($validation_results['bool'])
				{
					
					$data = array(
					'account_name' => $_POST['account_name'],
					'account_email' => $_POST['account_email'],
					'account_username' => $_POST['account_username'],
					'account_password' => sha1($_POST['account_password']),
					'isactive'=>'Y'
					);
					
					
						#check if account exists ::
						$account = $this->db->query($this->Query_reader->get_query_by_code('search_academia_account',$data))->result_array();		
						
						if(count($account) > 0 )
						{
							$msg =  " ACCOUNT ALREADY EXISTS"; 
							$data['ERROR'] =  $msg;
							
						}
						else
						{
							#RUN QUERY TO INSERT RECORD	NEW ACADEMNUIA ACCOUNT
							$query = $this->db->query($this->Query_reader->get_query_by_code('new_system_account',$data));					 
							if($query)
							{
								//SESSION CREATION 
								$_SESSION['account_name'] = $_POST['account_name'];
								$_SESSION['account_email'] = $_POST['account_email'];
								$_SESSION['account_username'] = $_POST['account_username'];
								$_SESSION['account_password'] = $_POST['account_password'];
								$_SESSION['isactive'] = 'Y';	
								$msg =  " ACCOUNT CREATED SUCCESFULLY "; 
								$data['SUCCESS'] =  $msg;
								
							}					
							else 
							{
								$msg =  " SOMETHING HAPPENED, RECORD NOT SAVED SUCCESSFULLY <BR/> ".($this->db->last_query()); 
								$data['ERROR'] =  $msg;
							}				 
						
						}				
				
				}
				else
				{
					$data['validation_results'] = $validation_results;
					
				}
				return $data;
				
				
			
			break;
			
			
			default:
			break;
		}
		
	
	}
	
	
	function check_academia_account($data)
	{
		    $account = $this->db->query($this->Query_reader->get_query_by_code('search_academia_account',$data))->result_array();
		
			$data = array();
			
			if(count($account) > 0 )
			{
				$msg =  "ACCOUNT  EXISTS"; 
				$data['SUCCESS'] =  $msg;
				$data['academia_account'] = $account;
							
			}
			
			return $data;
						
	}
	
	#Fetch SCHOOLS ATTACHED TO ACADEMIA ACCOUNT
	/*
	IF SUPER ADMIN : LIST ALL  OTHERWIZE GET ME FOR THE ACADEMIA ACCOUNT 
	*/
   function get_academia_schools($academia_account_id = '',$data=array())
   {
	   
	   #GET SCHOOLS THAT BELONG TO A GIVEN ACCOUNT 
	   $searchstring = '';
	   if(!empty($academia_account_id))
	   $searchstring = ' AA.id = '.$academia_account_id.'';
	   
	   $data_array = array('searchstring'=>$searchstring);
	   
	   #GET THE RECORDS 
	   $school_accounts = paginate_list($this,$data,'search_acadmia_schools',$data_array);
	 	
	   return $school_accounts;
	  
		
	  
   }
	
	
	function register_scrhool($data)
	{
		
		 
		
	}
	
	
	
	

	 

	

	var $cur_school_details;

		

	#function to save a new school

	function add_school($termdetails)

	{

		$query = $this->Query_reader->get_query_by_code('add_term', $studentdetails);

		$result = $this->db->query($query);

		return $result;

	}

	

	#function to retrieve paginated list of schools

	function get_terms($school = '')

	{

		$termdetails = array();

		#By default get the current user's school terms

		if($school == '' && $this->session->userdata('usertype') == 'SCHOOL')

		{

			$schooldetails = $this->session->userdata('schoolinfo');

			$query = $this->Query_reader->get_query_by_code('get_terms_by_school', array('school' => $schooldetails['id']) );

			$result = $this->db->query($query);

			$termdetails = $result->result_array();

		}

		else

		{

			#Only system admins can see terms of other schools

			if($this->session->userdata('usertype') == 'MSR')

			{

				#Admins also have to specify the school whose terms they would like to view

				if($school == '')

				{

					$termdetails['msg'] = "No school was specified";

				}

				else

				{

					$query = $this->Query_reader->get_query_by_code('get_terms_by_school', array('school' => $school));

					$result = $this->db->query($query);

					$termdetails = $result->results_array();

				}

				

			}

		}

		

		return $termdetails;	

	}

	

}



?>
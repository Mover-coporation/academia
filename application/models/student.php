<?php



class Student  extends CI_Model
{

	

	#Constructor

	function Student()

	{

		 

		$this->load->model('Query_reader', 'Query_reader', TRUE);

	}

		

	#function to save a new student

	function add_student($studentdetails)

	{

		$query = $this->Query_reader->get_query_by_code('add_student', $studentdetails);

		$result = $this->db->query($query);			

		return array('result' => $result, 'studentid' => $this->db->insert_id()) ;

	}

	

	#function to save a student's leave details

	function add_student_leave($leavedetails)

	{

		$query = $this->Query_reader->get_query_by_code('add_student_leave', $leavedetails);

		$result = $this->db->query($query);

		return $result;

	}

	

	#function to save a student's leave details

	function update_student_leave($leavedetails)

	{

		$query = $this->Query_reader->get_query_by_code('update_student_leave', $leavedetails); 

		$result = $this->db->query($query);

		return $result;

	}

	

	#function to register a student to a class, term and add the subjects the student is going to do

	function register_student($registrationdetails)

	{

		$query = $this->Query_reader->get_query_by_code('register_student', $registrationdetails);

		$result = $this->db->query($query);

		return $result;

	}

	

	#Function to update a student's registration details

	function update_registration_details($registrationdetails)

	{

		$query = $this->Query_reader->get_query_by_code('update_register', $registrationdetails);

		$result = $this->db->query($query);

		return $result;

	}

	

	#function to calculate and add transactions to the students account

	function add_student_transaction($feesdetails, $multiple)

	{

		$query_code = ($multiple) ? 'add_multiple_transactions' : 'add_single_transaction'; 

		$query = $this->Query_reader->get_query_by_code($query_code, $feesdetails);

		$result = $this->db->query($query);

		return $result;

	}

	

	#function to update a new student

	function update_student_data($studentdetails)

	{

		$query = $this->Query_reader->get_query_by_code('update_student_bio', $studentdetails);

		$result = $this->db->query($query);

		return $result;

	}

	

	

	#function to update a student's basic data

	function update_basic_student_data($studentdetails)

	{

		$query = $this->Query_reader->get_query_by_code('update_student_bio', $studentdetails);

		$result = $this->db->query($query);

		return $result;

	}

		

	

	#Function to populate the user details array

	function populate_user_details($userdata)

	{

		$userdetails['userid'] = (empty($userdata[0]['userid']) && !empty($userdata[0]['id']))? $userdata[0]['id']: $userdata[0]['userid'];

		

		$userdetails['username'] = $userdata[0]['username'];

		$userdetails['isadmin'] = $userdata[0]['isadmin'];	

		$userdetails['usertype'] = $userdata[0]['usertype'];	

		$userdetails['emailaddress'] = $userdata[0]['emailaddress'];

		$userdetails['userexpirydate'] = $userdata[0]['enddate'];

		$userdetails['names'] = $userdata[0]['firstname']." ".$userdata[0]['middlename']." ".$userdata[0]['lastname'];

		$userdetails['firstname'] = $userdata[0]['firstname'];

		$userdetails['lastname'] = $userdata[0]['lastname'];

		$userdetails['speciality'] = $userdata[0]['speciality'];

		$userdetails['changedpassword'] = $userdata[0]['changedpassword'];

					

		$this->log_access_trail(replace_bad_chars($userdetails['username']), 'Success');

					

		$this->session->set_userdata($userdetails);

		$this->session->set_userdata('alluserdata', $userdetails);

		setcookie("loggedin","true", time()+$this->config->item('sess_time_to_update'));

	}

	

	#Check the password strength

	function check_password_strength($newpassword)

	{

		$error_msg = "";

		$bool = TRUE;

		$chars = '@#$%&!_';

		$uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

		$lowercase = 'abcdefghijklmnopqrstuvwxyz';

		$strike = 0;

		$newpassword = restore_bad_chars($newpassword);

		

		#password below length

		if(strlen($newpassword) < 6)

		{

			$error_msg = "Password is below minimum length.";

			$bool = FALSE;

			$strike++;

		}

		

		#contains number

		if(strcspn($newpassword, '0123456789') == strlen($newpassword))

		{

			$error_msg = "Password should to contain a number.";

			$bool = FALSE;

			$strike++;

		}

		

		#contains character

		if(strcspn($newpassword, $chars) == strlen($newpassword))

		{

			$error_msg = "Password should contain a character from ".$chars.".";

			$bool = FALSE;

			$strike++;

		}

		

		#contains lower case character

		if(strcspn($newpassword, $lowercase) == strlen($newpassword))

		{

			$error_msg = "Password should contain a lower case character.";

			$bool = FALSE;

			$strike++;

		}

		

		#contains upper case character

		if(strcspn($newpassword, $uppercase) == strlen($newpassword))

		{

			$error_msg = "Password should contain an upper case character.";

			$bool = FALSE;

			$strike++;

		}

		

		

		return array('bool'=>$bool, 'msg'=>$error_msg, 'strikecount'=>$strike);

	}

	

	

	#Function to determine the user's location

	function get_user_location($return_type = 'array', $default='')

	{

		$location_array = array('country'=>'', 'zipcode'=>'', 'city'=>'', 'region'=>'');

		

		#If the user is logged in

		if($this->session->userdata('emailaddress'))

		{ 

			#First check if the user specified another location

			$location = $this->Query_reader->get_row_as_array('get_saved_user_location', array('emailaddress'=>$this->session->userdata('emailaddress')));

			

			if(!empty($location))

			{

				$location_array =  array('country'=>$location['country'], 'zipcode'=>$location['zipcode'], 'city'=>$location['city'], 'region'=>$location['region']);

			}

			

			if(empty($location_array))

			{

				#Check the user's profile if the above was not met

				$userdetails = $this->Query_reader->get_row_as_array('get_user_by_email', array('emailaddress'=>$this->session->userdata('emailaddress'), 'isactive'=>'Y'));

				if(!empty($userdetails))

				{

					$location_array = array('country'=>$userdetails['country'], 'zipcode'=>$userdetails['zipcode'], 'city'=>$userdetails['city'], 'region'=>$userdetails['state']);

				}

			}

		}

		

		#If the user is not logged in

		else

		{

			#Get the user location

			$location = $this->get_ip_location($this->input->ip_address());

			if(!empty($location['zipcode']) && $location['zipcode'] != '-')

			{

				$location_array = array('country'=>$location['country'], 'zipcode'=>$location['zipcode'], 'city'=>$location['city'], 'region'=>$location['region']);

			}

			else

			{

				$this->session->set_userdata('resetlocation', 'Y');

			}

		}

		

		

		#return based on desired value

		if($return_type == 'locationid')

		{

			$loc = $this->Query_reader->get_row_as_array('get_region_id', array('condition'=>" country='".$location_array['country']."' AND region='".$location_array['region']."' "));

			if(!empty($loc))

			{

				return $loc['id'];

			}

			

			$loc = $this->Query_reader->get_row_as_array('get_region_id', array('condition'=>" country='".$location_array['country']."' AND region='' "));

			if(!empty($loc))

			{

				return $loc['id'];

			}

			

			$loc = $this->Query_reader->get_row_as_array('get_region_id', array('condition'=>" country='".$location_array['region']."' AND region='' "));

			if(!empty($loc))

			{

				return $loc['id'];

			}

			else

			{

				

				return $default;

			}

		}

		else

		{

			return $location_array;

		}

	}

	

	

	#get the current user identifier

	function get_current_user_identifier($identifier = "email")

	{

		$ipaddress = $this->input->ip_address();

		if($identifier == "email")

		{

			$id = ($this->session->userdata('emailaddress'))?$this->session->userdata('emailaddress'):$ipaddress;

			return $id;

		}

		else if($identifier == "userid")

		{

			$id = ($this->session->userdata('userid'))?$this->session->userdata('userid'):$ipaddress;

			return $id;

		}

		else if($identifier == "noip")

		{

			$id = ($this->session->userdata('userid'))?$this->session->userdata('userid'):"";

			return $id;

		}

	}

	

	

	

	

}



?>
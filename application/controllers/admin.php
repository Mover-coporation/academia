<?php 



#*********************************************************************************

# All users have to first hit this class before proceeding to whatever section 

# they are going to.

# 

# It contains the login and other access control functions.

#*********************************************************************************



class Admin extends CI_Controller {

	
	#Constructor to set some default values at class load
	public function __construct()
    {
		   parent::__construct();
		   
		//**********  Back button will not work, after logout  **********//
			header("cache-Control: no-store, no-cache, must-revalidate");

			header("cache-Control: post-check=0, pre-check=0", false);

			// HTTP/1.0
			header("Pragma: no-cache");
			// Date in the past
			header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
			// always modified
			header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
		//**********  Back button will not work, after logout  **********//
	 

		$this->load->library('form_validation'); 

		$this->load->model('users','user1');

		$this->load->model('sys_email','sysemail');

		$this->session->set_userdata('page_title','Login');

		date_default_timezone_set(SYS_TIMEZONE);

		$data = array();		

	}

	

	

	#Default to login 

	function index()

	{
		redirect('page/home');
	

	}

	

	#Handles login functionality

	function login()

	{

		# Get the passed details into the url data array if any
		$urldata = $this->uri->uri_to_assoc(3, array('m'));

		# Pick all assigned data
		$data = assign_to_data($urldata);

		

		# If user has clicked login button
		if($this->input->post('login'))

		{

			$required_fields = array('acadusername', 'acadpassword');

			$_POST = clean_form_data($_POST);

			#print_r($_POST);

			$validation_results = validate_form('', $_POST, $required_fields);

			$username = trim($this->input->post('acadusername'));

			$password = trim($this->input->post('acadpassword'));			

			# Enters here if there were no errors during validation.

			if($validation_results['bool'])

			{

				# Run the login details against the user's details stored in the database

				# Returns an array with the user details

				$chk_user = $this->user1->validate_login_user(array('username'=>$username, 'password'=>sha1($password)));				

				# No matching user details

				if(count($chk_user) == 0)

				{

					$data['msg'] = "WARNING: <b>Please re-enter your password.</b><br><br>The password entered is incorrect. Please try again (make sure your caps lock is off).<br><br>Forgot your password? <a href='".base_url()."admin/forgot_password' style='text-decoration:underline;font-size:17px;'>Request a new one.</a>";

					$this->user1->log_access_trail(replace_bad_chars($username), 'Fail');

				}

				else if(count($chk_user) > 0)	

				{ 

					# add session attributes

					# get the user id from the query results, since this is the unique ID for

					# the user

					$userdetails['userid'] = $chk_user[0]['userid'];

					$userdetails['username'] = $chk_user[0]['username'];

					$userdetails['isadmin'] = $chk_user[0]['isadmin'];	

					$userdetails['usertype'] = $chk_user[0]['usertype'];	

					//$userdetails['accessgroup'] = $chk_user[0]['accessgroup'];

					$userdetails['emailaddress'] = $chk_user[0]['emailaddress'];

					$userdetails['names'] = $chk_user[0]['firstname']." ".$chk_user[0]['middlename']." ".$chk_user[0]['lastname'];

					$userdetails['firstname'] = $chk_user[0]['firstname'];

					$userdetails['lastname'] = $chk_user[0]['lastname'];

					$userdetails['photo'] = $chk_user[0]['photo'];

					

					# get details for a school user

					if($userdetails['usertype'] == 'SCHOOL')

					{

						# Get the school details

						$userdetails['schoolinfo'] = $this->Query_reader->get_row_as_array('get_school_by_id', array('id'=>$chk_user[0]['school'] ));

						$userdetails['usergroup'] = $chk_user[0]['accessgroup'];

						$usergroupdetails = $this->Query_reader->get_row_as_array('get_group_by_id', array('id'=>$chk_user[0]['accessgroup'] ));

						$userdetails['usergroupname'] = (!empty($usergroupdetails))? $usergroupdetails['groupname'] : '';

						$userdetails['accessgroup'] =  (!empty($usergroupdetails))? $usergroupdetails['id'] : '';

						$userdetails['isschooladmin'] = $chk_user[0]['isschooladmin'];

					}			

										

					$this->user1->log_access_trail(replace_bad_chars($username), 'Success');

					

					//print_r($userdetails);

					$this->session->set_userdata($userdetails);

					$this->session->set_userdata('alluserdata', $userdetails);

					setcookie("loggedin","true", time()+$this->config->item('sess_time_to_update'));

					

					#Determine if the user needs to change the password, then overide the redirection to the dashboard

					if(!empty($userdetails['changedpassword']) && $userdetails['changedpassword'] == "N")

					{

						redirect('admin/change_password');

					}

					else

					{

						#Persist user details if specified "remember me" for future login

						if(!empty($_POST['rememberme']))

						{

							#Create cookie for the user details

							if(SECURE_MODE){

								/*

								* setcookie() variables

								* -----------------------

								* name		#Cookie Name

								* value		#Cookie value

								* expire	#Keep active for only 1 week (7 x 24 x 60 x 60 seconds)

								* domain	#Domain

								* secure	#Whether it requires to be secure cookie - set if operating in secure mode (with HTTPS)

								*/

								setcookie(

									get_user_cookie_name($this), 

									encryptValue($this->session->userdata('username')."||".sha1($password)), 

									time() + 604800,  

									".".$_SERVER['HTTP_HOST'],

									TRUE 

								);

							}

							else

							{

								setcookie(

									get_user_cookie_name($this), 

									encryptValue($this->session->userdata('username')."||".sha1($password)),

									time() + 604800,

									".".$_SERVER['HTTP_HOST']

								);

							}

						}

						

						redirect('admin/load_dashboard');

					}

				}#check user

			

				

			}

			#There were errors during validation

			else

			{

				$data['msg'] = "WARNING: Please enter the fields highlighted to continue.";

				$this->user1->log_access_trail(replace_bad_chars($username), 'Fail');

			}

			

			$data['formdata'] = $_POST;

			$data['requiredfields'] = $validation_results['requiredfields'];

		}

		

		

		$data = add_msg_if_any($this, $data);

		$this->load->view('login_view', $data);

	}

	

	

	# Shows the user's relevant dashboard with necessary infomation

	function load_dashboard()

	{	

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m', 'x'));

		# Pick all assigned data

		$data = assign_to_data($urldata);

		

		if(!empty($data['m'])){

			$addn = "/m/".$data['m'];

		} else {

			$addn = "";

		}

		

		#Unset navigation session settings

		$this->session->unset_userdata(array('from_search_results'=>''));

		

		

		#checks if the user's session expired

		if($this->session->userdata('userid') || ($this->input->cookie('loggedin') && $this->input->cookie('loggedin') == 'true' && empty($data['x'])))

    	{

        	if($this->session->userdata('fwdurl')){exit($this->session->userdata('fwdurl'));

				redirect($this->session->userdata('fwdurl'));

			}

			else

			{

				redirect($this->user1->get_dashboard().$addn);

			}

   		}

		else 

		{

        	setcookie("loggedin","false", time()+$this->config->item('sess_time_to_update'));

			#Consider passing on some messages even if the user is automatically logged out.

			if(!empty($data['m']) && in_array($data['m'], array('nmsg')))

			{

				$url = base_url().'admin/logout'.$addn;

			}

			else

			{

				$this->session->set_userdata('exp', 'Your session has expired.');

				$url = base_url().'admin/logout/m/exp';

			}

			

			redirect($url);

		}	

	}

	

	

	#Shows the user's relevant settings page

	function get_settings()

	{

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m'));

		# Pick all assigned data

		$data = assign_to_data($urldata);

		

		if(!empty($data['m'])){

			$addn = "/m/".$data['m'];

		} else {

			$addn = "";

		}

		

		redirect($this->user1->get_settings_page().$addn);

	}

	

	#Function to delete a school

	function delete_school()

	{

		access_control($this, array('admin'));

		

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i', 't'));

		# Pick all assigned data

		$data = assign_to_data($urldata);

		

		if(!empty($data['i'])){

			$result = $this->db->query($this->Query_reader->get_query_by_code('deactivate_school', array('id'=>decryptValue($data['i'])) ));

		}

		

		if(!empty($result) && $result){

			$this->session->set_userdata('duser', "The school data has been successfully deleted.");

		}

		else if(empty($data['msg']))

		{

			$this->session->set_userdata('duser', "ERROR: The school could not be deleted or was not deleted correctly.");

		}

		

		if(!empty($data['t']) && $data['t'] == 'super'){

			$tstr = "/t/super";

		}else{

			$tstr = "";

		}

		redirect("admin/dashboard/m/duser".$tstr);

	}

	

	#Save new school

	function save_school()

	{

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i', 'a', 't'));

		# Pick all assigned data

		$data = assign_to_data($urldata);		

		$data = restore_bad_chars($data);

		if($this->input->post('save') || $data['save'])

		{ 

			if(empty($_POST)) $_POST = $data;

			$data['schooldetails'] = $_POST;		

            $required_fields = array('schoolname', 'district', 'address', 'fromdate', 'todate', 'emailaddress*EMAILFORMAT');

			$_POST = clean_form_data($_POST);

			$validation_results = validate_form('', $_POST, $required_fields);

                        

			#set status as editing on destination if updating

            if($this->input->post('editid')) $data['editid'] = $_POST['editid'];

            

			#Check if adding a new school and the email added has already been used

			if(!empty($data['schooldetails']['emailaddress']) && empty($data['editid']))

			{

				$school_details  = $this->Query_reader->get_row_as_array('get_any_school_by_email', array('emailaddress'=>$data['schooldetails']['emailaddress']));

			}

			

			#Only proceed if the validation for required fields passes

			if($validation_results['bool'] && !(empty($data['editid']) && !empty($user_details)))

			{   

                if($this->input->post('editid'))

                {

					$result = $this->db->query($this->Query_reader->get_query_by_code('update_school_data', array_merge($_POST, array('updatecond'=> '')) ));

           	  	}

			 	else 

             	{

					#check if a similar school already exists

               	 	$schoolname_error = "";

                	$schools = $this->db->query($this->Query_reader->get_query_by_code('get_existing_schools_by_name', array('searchstring' => ' schoolname = "'.$_POST['schoolname'].'" AND isactive="Y"')));

                                    

                	if(count($schools->result_array()))

                	{

                    	$data['msg'] = "WARNING: A school with the same name already exists."; 

                	}

					else

					{

						$result = $this->db->query($this->Query_reader->get_query_by_code('add_school_data', $_POST ));

					}

        		}

				

           		#Format and send the errors

            	if(!empty($result) && $result)

				{

					$data['msg'] = "The school data has been successfully saved";

					$data['schooldetails'] = array();

            	 }

            	 else if(empty($data['msg']))

            	 {

				   	$data['msg'] = "ERROR: The school could not be saved or was not saved correctly.";

             	 }

            }

            

			#Prepare a message in case the user already exists for another school

			else if(empty($data['editid']) && !empty($user_details))

			{	 

				 $data['msg'] = "WARNING: The emailaddress has already been used by another school.<br />"; 

				 $data['schooldetails'] = array();

			}

			             

            if((empty($validation_results['bool']) || (!empty($validation_results['bool']) && !$validation_results['bool'])) 

			&& empty($data['msg']) )

			{

				$data['msg'] = "WARNING: The highlighted fields are required.";

			}

			

			$data['requiredfields'] = $validation_results['requiredfields'];

		}		

         

                

		$this->load->view('admin/new_school_view', $data);

	}

	

	#Function to save a school user's details

	function save_school_user()

	{

		access_control($this, array('admin'));

		

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i', 'a', 's'));

		

		# Pick all assigned data

		$data = assign_to_data($urldata);		

		#print_r($data);

		$data = restore_bad_chars($data);

		if($this->input->post('save') || $data['save'])

		{

			$data['userdetails'] = $_POST = $data;		

            $required_fields = array('firstname', 'lastname', 'school', 'address', 'emailaddress*EMAILFORMAT', 'telephone', 'username',  'isschooladmin');

			$_POST = clean_form_data($_POST);

			$validation_results = validate_form('', $_POST, $required_fields);



			#set status as editing on destination if updating

            if($this->input->post('editid')) $data['editid'] = $_POST['editid'];



			#Check if adding a new user and the email added has already been used

			if(!empty($data['userdetails']['emailaddress']) && empty($data['editid']))

			{

				$user_details  = $this->Query_reader->get_row_as_array('get_any_user_by_email', array('emailaddress'=>$data['userdetails']['emailaddress']));

			}

			

			#Only proceed if the validation for required fields passes

			if($validation_results['bool'])

			{

                #user is editing

				if(!empty($data['i']))

                {

					#Check if password has been changed and also meets minimum criteria

                    if(!empty($_POST['password']) || !empty($_POST['repeatpassword']))

                    {   

                        $passwordmsg = $this->user1->check_password_strength($_POST['password']);

                        if(!$passwordmsg['bool'])

                        {

                            $data['msg'] = $passwordmsg['msg'];

                        }

                        elseif($_POST['password'] == $_POST['repeatpassword'])

						{

							$update_string = ", password = '".sha1($_POST['password'])."'";

						}

						else

						{

							$data['msg'] = "WARNING: The passwords provided do not match.";

						}

					}

					else

					{

						$update_string = "";

					}



					  if((empty($_POST['password']) && empty($_POST['repeatpassword'])) || !empty($update_string)){

                          $resulta  = '';



                          if(((!empty($_POST['username1'])) &&( ($_POST['username1']) != ($_POST['username']))) || ((!empty($_POST['emailaddress'])))){



                         $resulta = $this->db->query($this->Query_reader->get_query_by_code('check_schoolusername', array_merge( array('username'=>$_POST['username'],'email'=>$_POST['emailaddress'], 'editid'=>decryptValue($data['i']))) ))->result_array();





                        if(count($resulta) > 0)

                        {



                            $data['msg'] = "WARNING:Username ".$_POST['username']." or Email ".$_POST['emailaddress']." Exists ";









                        }else{



                            $result = $this->db->query($this->Query_reader->get_query_by_code('update_school_user_data', array_merge($_POST, array('updatecond'=>$update_string,'username'=>$_POST['username'], 'editid'=>decryptValue($data['i']))) ));



                        }



                          }

                          else

                              $result = $this->db->query($this->Query_reader->get_query_by_code('update_school_user_data', array_merge($_POST, array('updatecond'=>$update_string,'username'=>$_POST['username1'], 'editid'=>decryptValue($data['i']))) ));







					}

           	  	} 

			 

			    #adding a new user

			 	else 

             	{



					#check if a similar username already exists in both users and school users tables

               	 	$username_error = "";

                	$usernames = $this->db->query($this->Query_reader->get_query_by_code('get_existing_usernames', array('searchstring' => ' username = "'.$_POST['username'].'"')));

					#school users

					$school_usernames = $this->db->query($this->Query_reader->get_query_by_code('search_schoolusers', array('searchstring' => ' username = "'.$_POST['username'].'"')));

					

                	#determine password strength

                	$passwordmsg = $this->user1->check_password_strength($_POST['password']);

                                    

                	if(strlen($_POST['username']) < 5)

                	{

                   		$data['msg'] = "WARNING: The username must be at least 5 characters long."; 

               		}

                	elseif(count($usernames->result_array()) || count($school_usernames->result_array()))

                	{

                    	$data['msg'] = "WARNING: The username is already being used by another user."; 

                	}                                    

                	elseif(!$passwordmsg['bool']){

                    	$data['msg'] = "WARNING: ".$passwordmsg['msg'];

                	}                                     

                	elseif($_POST['password'] == $_POST['repeatpassword'] && !empty($_POST['password']))

					{

						$_POST['newpass'] = $_POST['password'];

						$_POST['usertype'] = 'SCHOOL';

						$result = $this->db->query($this->Query_reader->get_query_by_code('add_school_user', array_merge($_POST, array('password'=>sha1($_POST['newpass'])) )));

					}

					else

					{

						$data['msg'] = "WARNING: The passwords provided do not match.";

					}

        		}

				

           		#Format and send the errors

            	if(!empty($result) && $result)

				{

					#Notify user by email on creation of an account

					if(empty($data['editid']))

					{

						/*$send_result = $this->sysemail->email_form_data(array('fromemail'=>NOREPLY_EMAIL), 

						get_confirmation_messages($this, array('emailaddress'=>$_POST['emailaddress'], 'username'=>$_POST['username'], 'password'=>$_POST['newpass']), 'registration_confirm')); */

					}

					

					$data['msg'] = "The user data has been successfully saved";

					$data['userdetails'] = array();

					#redirect("admin/school_users/m/usave/s/".encryptValue($_POST['school']));

            	 }

            	 else if(empty($data['msg']))

            	 {

                   	#Get access groups                

                   	$usergroupsResult = $this->db->query($this->Query_reader->get_query_by_code('get_user_groups',array('searchstr' => ' AND school = '.$_POST['school'])));

                 

                   	$data['usergroups'] = get_select_options($usergroupsResult->result_array(),'id','groupname','','Select');

				   	$data['msg'] = "ERROR: The user could not be saved or was not saved correctly.";

             	}

            }

            

			#Prepare a message in case the user already exists

			else if(empty($data['editid']) && !empty($user_details))

			{

				 $addn_msg = (!empty($user_details['isactive']) && $user_details['isactive'] == 'N')? "<a href='".base_url()."admin/load_user_form/i/".encryptValue($user_details['id'])."/a/".encryptValue("reactivate")."' style='text-decoration:underline;font-size:17px;'>Click here to  activate and  edit</a>": "<a href='".base_url()."admin/load_user_form/i/".encryptValue($user_details['id'])."' style='text-decoration:underline;font-size:17px;'>Click here to edit</a>";

				 

				 $data['msg'] = "WARNING: The emailaddress has already been used by another user.<br />".$addn_msg." this user instead."; 

			}

			             

            if((empty($validation_results['bool']) || (!empty($validation_results['bool']) && !$validation_results['bool'])) 

			&& empty($data['msg']) )

			{

				$data['msg'] = "WARNING: The highlighted fields are required.";

			}

			

			$data['requiredfields'] = $validation_results['requiredfields'];

		}		

        

		#get the school details

		$schoolid = $_POST['school'];

		$data['schooldetails'] = $this->Query_reader->get_row_as_array('get_school_by_id', array('id'=>$schoolid));

                

		$this->load->view('admin/new_school_user', $data);

	}

	

	#Load form to add a school user

	function add_school_user ()

	{

		access_control($this, array('admin'));

		

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('s', 'i','a'));

		

		# Pick all assigned data

		$data = assign_to_data($urldata);

                                

        #user is editing

		if(!empty($data['i']))

		{

			$userid = decryptValue($data['i']);

			

			#get the user's details

			$data['userdetails'] = $this->Query_reader->get_row_as_array('get_school_user_by_id', array('id'=>$userid));

                                    

            #Check if the user is simply viewing

            if(!empty($data['a']) && decryptValue($data['a']) == 'view')

            {

                $data['isview'] = "Y";

            }

		}

		

		#get the school details

		$schoolid = empty($data['i']) ? decryptValue($data['s']) : $data['userdetails']['school'];			

		$data['schooldetails'] = $this->Query_reader->get_row_as_array('get_school_by_id', array('id'=>$schoolid));

		

		#Get access groups                

        $usergroupsResult = $this->db->query($this->Query_reader->get_query_by_code('get_user_groups',array('searchstr' => ' AND school = '.$schoolid)));

        $data['usergroups'] = get_select_options($usergroupsResult->result_array(),'id','groupname','','Select');

		

		$this->load->view('admin/new_school_user', $data);

	}

	

	#Load list of school users

	function school_users()

	{

		access_control($this, array('admin'));

		

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m', 's'));

		

		# Pick all assigned data

		$data = assign_to_data($urldata);

		

		#Get the school id

		$schoolid = decryptValue($data['s']);

		

		#Get the school details

		$data['schooldetails'] = $this->Query_reader->get_row_as_array('get_school_by_id', array('id'=>$schoolid ));

		

		#Get the paginated list of the schools

		$data = paginate_list($this, $data, 'search_school_users', array('isactive'=>'Y', 'searchstring'=>' AND school ='.$schoolid));

		

		$data = add_msg_if_any($this, $data);

		$this->load->view('admin/school_users', $data);

	}

	

	#New school form

	function load_school_form()

	{

		access_control($this, array('admin'));

		

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i','a'));

		# Pick all assigned data

		$data = assign_to_data($urldata);

                                

        #user is editing

		if(!empty($data['i']))

		{

			$schoolid = decryptValue($data['i']);

			

			$data['schooldetails'] = $this->Query_reader->get_row_as_array('get_school_by_id', array('id'=>$schoolid ));

            

			#If the school is to be reactivated

			if(!empty($data['a']) && decryptValue($data['a']) == 'reactivate' && $this->session->userdata('isadmin') == 'Y')

			{

				$result = $this->db->query($this->Query_reader->get_query_by_code('reactivate_user', array('id'=>$schoolid)));

				if($result)

				{

					$send_result = $this->sysemail->email_form_data(array('fromemail'=>NOREPLY_EMAIL), 

							get_confirmation_messages($this, $data['schooldetails'], 'account_reactivated_notice'));

				}

				else

				{

					$data['msg'] = "ERROR: There was an error activating the school.";

				}

			}

			

                        

            #Check if the user is simply viewing

            if(!empty($data['a']) && decryptValue($data['a']) == 'view')

            {

                $data['isview'] = "Y";

            }

		}

		

		$this->load->view('admin/new_school_view', $data);

	}

	

	

	# Shows the admin dashboard

	function dashboard()

	{	

		access_control($this, array('admin'));

		

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m'));

		

		# Pick all assigned data

		$data = assign_to_data($urldata);

		

		if(!empty($data['au']) && decryptValue($data['au']) == 'true')

		$data['adduser'] = 'true';

		

		#Get the paginated list of the schools

		$data = paginate_list($this, $data, 'search_schools_list', array('isactive'=>'Y', 'searchstring'=>' AND isactive ="Y"'));

		

		$data = add_msg_if_any($this, $data);

		$this->load->view('admin/admin_dashboard_view', $data);

	}

	

	

	# gets list of schools

	function manage_schools()

	{

		access_control($this, array('admin'));

		

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m'));

		

		# Pick all assigned data

		$data = assign_to_data($urldata);

				

		#Get the paginated list of the schools

		$data = paginate_list($this, $data, 'search_schools_list', array('isactive'=>'Y', 'searchstring'=>' AND isactive ="Y"'));

		

		$data = add_msg_if_any($this, $data);

		$this->load->view('admin/manage_schools_view', $data);

	}

		

	

	#Function to show when the user forgot their password

	function forgot_password()

	{

		$this->load->model('sys_email','sysemail');

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m'));

		# Pick all assigned data

		$data = assign_to_data($urldata);

		

		if($this->input->post('sendpassword'))

		{

			$required_fields = array('emailaddress*EMAILFORMAT');

			

			$validation_results = validate_form('', $_POST, $required_fields);

			

			#validate the passed email address before sending a new password

			if($validation_results['bool'])

			{

				$user_details = $this->Query_reader->get_row_as_array('get_user_by_email', array('emailaddress'=>$_POST['emailaddress'], 'isactive'=>'Y'));

				

				if(!empty($user_details))

				{

					$new_pass = generate_standard_password();

					$update_result = $this->db->query($this->Query_reader->get_query_by_code('update_user_password', array('emailaddress'=>$_POST['emailaddress'], 'newpass'=>sha1($new_pass) )));

					

					if($update_result)

					{

						#Send a welcome message to the user's email address

						$send_result = $this->sysemail->email_form_data(array('fromemail'=>SITE_ADMIN_MAIL), 

							get_confirmation_messages($this, array('emailaddress'=>$_POST['emailaddress'], 'newpass'=>$new_pass, 'firstname'=>$user_details['firstname']), 'changed_password_notify'));

					}

					

					$msg = (!empty($send_result) && $send_result)? "A new password has been sent to your email address.": "ERROR: The new password could not be sent. Please contact our support team by phone for help.";

					

					$this->session->set_userdata('sres',$msg);

					redirect(base_url()."admin/login/m/sres");

				}

				else

				{

					$data['msg'] = "WARNING: The emailaddress provided does not match any active user on the system.";

				}

			}

			else

			{

				$data['msg'] = "WARNING: The highlighted fields are required.";

			}

			

			$data['requiredfields'] = $validation_results['requiredfields'];

			$data['formdata'] = $_POST;	

		}

		

		$data = add_msg_if_any($this, $data);

		$this->load->view('admin/forgot_password_view', $data);

	}

	

	

	

	# Clears the current user's session and redirects to the login page

	function logout()

	{	

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m'));

		# Pick all assigned data

		$data = assign_to_data($urldata);

		

		

		$this->user1->log_access_trail($this->session->userdata('username'), 'Success', 'logout');

		$this->session->set_userdata('lmsg', 'You have logged out.');

		

		#Clear/reset tracking cookies if present

		setcookie(get_user_cookie_name($this), "", time()+0);

		setcookie("loggedin","false", time()+$this->config->item('sess_time_to_update'));

		

		# Clear key session variables

		$this->session->unset_userdata(array(

			'alluserdata'=>'',

			'isadmin'=>'',

			'trackerids'=>'',

			'fwdurl'=>'',

			'userid'=>'',

			'isadmin'=>''

			));

		

		if(empty($data['m'])){

			$data['m'] = "lmsg";

		}

		

		redirect(base_url().'admin/login/m/'.$data['m']);

	}

	

	

	

	#Change Password before you proceed.

	function change_password()

	{

		access_control($this);

		

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m'));

		# Pick all assigned data

		$data = assign_to_data($urldata);

		

		if($this->input->post('updatepw'))

		{

			$required_fields = array('oldpassword', 'newpassword', 'repeatpassword*SAME<>newpassword');

			$validation_results = validate_form('', $_POST, $required_fields);

			$data['passwordmsg'] = $this->user1->check_password_strength($_POST['newpassword']);

			$pwstrength = 5 - $data['passwordmsg']['strikecount'];

			

			#Get the user details and compare with the entered password details

			$old_user_details = $this->Query_reader->get_row_as_array('user_login', array('username'=>$this->session->userdata('username'), 'password'=>sha1($_POST['oldpassword']) ));

			

			

			#Only proceed if the validation for required fields passes

			if(!empty($old_user_details) && $validation_results['bool'] && $pwstrength > 3)

			{

				$updateresult = $this->db->query($this->Query_reader->get_query_by_code('update_user_password', array('newpass'=>sha1($_POST['newpassword']), 'emailaddress'=>$this->session->userdata('emailaddress')) ));

				$flagupdateresult = $this->db->query($this->Query_reader->get_query_by_code('update_user_changedpassword_flag', array('flagvalue'=>'Y', 'emailaddress'=>$this->session->userdata('emailaddress')) ));

				

				

				if($updateresult && $flagupdateresult)

				{

					#Notify user of password change

					$send_result = $this->sysemail->email_form_data(array('fromemail'=>SECURITY_EMAIL), 

							get_confirmation_messages($this, array('emailaddress'=>$this->session->userdata('emailaddress'), 'firstname'=>$this->session->userdata('firstname')), 'password_change_notice'));

					

					$this->session->set_userdata('changedpassword', 'Y');

					$this->session->set_userdata('umsg', 'Your password has been updated');

					redirect('admin/logout/m/umsg');

				}

				else

				{

					$data['msg'] = "ERROR: There were errors updating your password. <BR>Please contact the administrator.";

				}

			}

			else if(empty($old_user_details))

			{

				$data['msg'] = "WARNING: The password entered does not match the old password.";

			}

			else if(!$validation_results['bool'])

			{

				$data['msg'] = "WARNING: The highlighted fields are required.";

			}

			else 

			{

				$data['msg'] = "WARNING: The password strength is low. Please update the password based on the instructions given.";

			}

			$data['requiredfields'] = $validation_results['requiredfields'];

			$data['formdata'] = $_POST;

		}

		

		$data = add_msg_if_any($this, $data);

		$this->load->view('account/change_password', $data);

	}

	

	

	

	

	#Check password for strength

	function password_strength()

	{

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m'));

		# Pick all assigned data

		$data = assign_to_data($urldata);

		

		if(!empty($data['newpassword']))

		{

			$data['passwordmsg'] = $this->user1->check_password_strength($data['newpassword']);

		}

		$data['area'] = "show_password_strength";

		$data = add_msg_if_any($this, $data);

		$this->load->view('incl/addons', $data);

	}

        

    #Manage Users

	function manage_users()

	{

		access_control($this, array('admin'));

		

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));

		# Pick all assigned data

		$data = assign_to_data($urldata);

                

		#Get the paginated list of users

		$data = paginate_list($this, $data, 'get_all_users', array());

         

		$data = add_msg_if_any($this, $data);

		$data = handle_redirected_msgs($this, $data);

		

		$this->load->view('admin/manage_users_view', $data);

	}

        

    #New User Form

	function load_user_form()

	{

		access_control($this, array('admin'));

		

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i','a'));

		# Pick all assigned data

		$data = assign_to_data($urldata);

                

        #Get access groups                

        $accessGroupsResult = $this->db->query($this->Query_reader->get_query_by_code('get_user_group_list',array()));

                

        #user is editing

		if(!empty($data['i']))

		{

			$userid = decryptValue($data['i']);

			

			$data['userdetails'] = $this->Query_reader->get_row_as_array('get_user_by_id', array('id'=>$userid ));

            

			#If the user is to be reactivated

			if(!empty($data['a']) && decryptValue($data['a']) == 'reactivate' && $this->session->userdata('isadmin') == 'Y')

			{

				$result = $this->db->query($this->Query_reader->get_query_by_code('reactivate_user', array('id'=>$userid)));

				if($result)

				{

					$send_result = $this->sysemail->email_form_data(array('fromemail'=>NOREPLY_EMAIL), 

							get_confirmation_messages($this, $data['userdetails'], 'account_reactivated_notice'));

				}

				else

				{

					$data['msg'] = "ERROR: There was an error activating the user.";

				}

			}

			

                        

            #Check if the user is simply viewing

            if(!empty($data['a']) && decryptValue($data['a']) == 'view')

            {

                $data['isview'] = "Y";

                           

                #get the access group name

                $data['access_group_info'] = $this->Query_reader->get_row_as_array('get_group_by_id', array('groupid'=> $data['userdetails']['accessgroup'] ));

            }

		}

		

		$this->load->view('admin/new_user_view', $data);

	}

        

    #Save new User

	function save_user()

	{

		access_control($this, array('admin'));

		

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i', 'a', 't'));

		

		# Pick all assigned data

		$data = assign_to_data($urldata);		

		

		if($this->input->post('save'))

		{ 

			$data['userdetails'] = $_POST;		

            $required_fields = array('firstname', 'lastname', 'addressline1', 'emailaddress*EMAILFORMAT', 'telephone', 'username');

			$_POST = clean_form_data($_POST);

			$validation_results = validate_form('', $_POST, $required_fields);

                        

			#set status as editing on destination if updating

            if($this->input->post('editid')) $data['editid'] = $_POST['editid'];

            

			#Check if adding a new user and the email added has already been used

			if(!empty($data['userdetails']['emailaddress']) && empty($data['editid']))

			{

				$user_details  = $this->Query_reader->get_row_as_array('get_any_user_by_email', array('emailaddress'=>$data['userdetails']['emailaddress']));

			}

			

			#Only proceed if the validation for required fields passes

			if($validation_results['bool'] && !(empty($data['editid']) && !empty($user_details)))

			{           

                if($this->input->post('editid'))

                { 

                    if(!empty($_POST['password']) || !empty($_POST['repeatpassword']))

                    {   

                        $passwordmsg = $this->user1->check_password_strength($_POST['password']);

                        if(!$passwordmsg['bool'])

                        {

                            $data['msg'] = $passwordmsg['msg'];

                        }

                        elseif($_POST['password'] == $_POST['repeatpassword'])

						{

							$update_string = ", password = '".sha1($_POST['password'])."'";

						}

						else

						{

							$data['msg'] = "WARNING: The passwords provided do not match.";

						}

					}

					else

					{

						$update_string = "";

					}

				

					if((empty($_POST['password']) && empty($_POST['repeatpassword'])) || !empty($update_string)){

						$result = $this->db->query($this->Query_reader->get_query_by_code('update_user_data', array_merge($_POST, array('updatecond'=>$update_string)) ));		

						echo $this->Query_reader->get_query_by_code('update_user_data', array_merge($_POST, array('updatecond'=>$update_string)) );		

					}

           	  	} 

			 

			 

			 	else 

             	{

					#check if a similar username already exists

               	 	$username_error = "";

                	$usernames = $this->db->query($this->Query_reader->get_query_by_code('get_existing_usernames', array('searchstring' => ' username = "'.$_POST['username'].'"')));

                                    

                	#determine password strength

                	$passwordmsg = $this->user1->check_password_strength($_POST['password']);

                                    

                	if(strlen($_POST['username']) < 5)

                	{

                   		$data['msg'] = "WARNING: The username must be at least 5 characters long."; 

               		}

                	elseif(count($usernames->result_array()))

                	{

                    	$data['msg'] = "WARNING: The username is already being used by another user."; 

                	}                                    

                	elseif(!$passwordmsg['bool']){

                    	$data['msg'] = "WARNING: ".$passwordmsg['msg'];

                	}                                     

                	elseif($_POST['password'] == $_POST['repeatpassword'] && !empty($_POST['password']))

					{

						$_POST['newpass'] = $_POST['password'];

						$result = $this->db->query($this->Query_reader->get_query_by_code('add_user_data', array_merge($_POST, array('password'=>sha1($_POST['newpass'])) )));						

					}

					else

					{

						$data['msg'] = "WARNING: The passwords provided do not match.";

					}

        		}

				

           		#Format and send the errors

            	if(!empty($result) && $result)

				{

					#Notify user by email on creation of an account

					if(empty($data['editid']))

					{

						#$send_result = $this->sysemail->email_form_data(array('fromemail'=>NOREPLY_EMAIL), 

						#get_confirmation_messages($this, array('emailaddress'=>$_POST['emailaddress'], 'username'=>$_POST['username'], 'password'=>$_POST['newpass']), 'registration_confirm'));

					}

					

					$this->session->set_userdata('usave', "The user data has been successfully saved.");

					redirect("admin/manage_users/m/usave");

            	 }

            	 else if(empty($data['msg']))

            	 {

				   	$data['msg'] = "ERROR: The user could not be saved or was not saved correctly.";

             	 }

            }

            

			#Prepare a message in case the user already exists

			else if(empty($data['editid']) && !empty($user_details))

			{

				 $addn_msg = (!empty($user_details['isactive']) && $user_details['isactive'] == 'N')? "<a href='".base_url()."admin/load_user_form/i/".encryptValue($user_details['id'])."/a/".encryptValue("reactivate")."' style='text-decoration:underline;font-size:17px;'>Click here to  activate and  edit</a>": "<a href='".base_url()."admin/load_user_form/i/".encryptValue($user_details['id'])."' style='text-decoration:underline;font-size:17px;'>Click here to edit</a>";

				 

				 $data['msg'] = "WARNING: The emailaddress has already been used by another user.<br />".$addn_msg." this user instead."; 

			}

			             

            if((empty($validation_results['bool']) || (!empty($validation_results['bool']) && !$validation_results['bool'])) 

			&& empty($data['msg']) )

			{

				$data['msg'] = "WARNING: The highlighted fields are required.";

			}

			

			$data['requiredfields'] = $validation_results['requiredfields'];

		}		

        

		$this->load->view('admin/new_user_view', $data);

	}

        

    #Function to delete the user

	function delete_user()

	{

		access_control($this, array('admin'));

		

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i', 't'));

		# Pick all assigned data

		$data = assign_to_data($urldata);

		

		if(!empty($data['i'])){

			$result = $this->db->query($this->Query_reader->get_query_by_code('deactivate_user', array('id'=>decryptValue($data['i'])) ));

		}

		

		if(!empty($result) && $result){

			$this->session->set_userdata('duser', "The user data has been successfully deleted.");

		}

		else if(empty($data['msg']))

		{

			$this->session->set_userdata('duser', "ERROR: The user could not be deleted or was not deleted correctly.");

		}

		

		if(!empty($data['t']) && $data['t'] == 'super'){

			$tstr = "/t/super";

		}else{

			$tstr = "";

		}

		redirect("admin/manage_users/m/duser".$tstr);

	}

	

	

	#Function to delete school user

	function delete_school_user()

	{

		access_control($this, array('admin'));

		

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i', 't'));

		# Pick all assigned data

		$data = assign_to_data($urldata);

		

		if(!empty($data['i'])){

			$result = $this->db->query($this->Query_reader->get_query_by_code('deactivate_item', array('item'=>'schoolusers', 'id'=>decryptValue($data['i']))));

		}

		

		if(!empty($result) && $result){

			$this->session->set_userdata('duser', "The user data has been successfully deleted.");

		}

		else if(empty($data['msg']))

		{

			$this->session->set_userdata('duser', "ERROR: The user could not be deleted or was not deleted correctly.");

		}

		

		if(!empty($data['t']) && $data['t'] == 'super'){

			$tstr = "/t/super";

		}else{

			$tstr = "";

		}

		redirect("admin/manage_users/m/duser".$tstr);

	}

	

        

    #Function to delete the user group

	function delete_user_group()

	{

		access_control($this, array('admin'));

		

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i', 't'));

		# Pick all assigned data

		$data = assign_to_data($urldata);

		

		if(!empty($data['i'])){

			$result = $this->db->query($this->Query_reader->get_query_by_code('delete_user_group', array('groupid'=>decryptValue($data['i'])) ));

		}

		

		if(!empty($result) && $result){

			$this->session->set_userdata('duser', "The access group has been successfully deleted.");

                        

                        #Delete the group permissions

                        $this->db->query($this->Query_reader->get_query_by_code('delete_group_permissions', array('groupid'=>decryptValue($data['i'])) ));

		}

		else if(empty($data['msg']))

		{

			$this->session->set_userdata('dusergroup', "ERROR: The access group could not be deleted or was not deleted correctly.");

		}

		

		if(!empty($data['t']) && $data['t'] == 'super'){

			$tstr = "/t/super";

		}else{

			$tstr = "";

		}

		redirect(base_url()."admin/manage_user_groups/m/duser".$tstr);

	}

        

    #Manage User groups

	function manage_access_groups()

	{

		access_control($this, array('admin'));

		

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));

		# Pick all assigned data

		$data = assign_to_data($urldata);

        

		$result = $this->db->query($this->Query_reader->get_query_by_code('get_user_group_list', array()));

		$data['access_group_list'] = $result->result_array();

		

		$data = handle_redirected_msgs($this, $data);

		$data = add_msg_if_any($this, $data);

		$this->load->view('admin/manage_access_groups', $data);

	}

        

    #Load User group form

	function access_group_form()

	{

		access_control($this, array('admin'));

		

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i', 'a'));

		# Pick all assigned data

		$data = assign_to_data($urldata);                

                

                #user is editing

		if(!empty($data['i']))

		{

			$groupid = decryptValue($data['i']);

			$data['groupdetails'] = $this->Query_reader->get_row_as_array('get_group_by_id', array('groupid'=>$groupid ));

            #Check if the user is simply viewing

            if(!empty($data['a']) && decryptValue($data['a']) == 'view') $data['isview'] = "Y";

		}

		

		$this->load->view('admin/add_access_group', $data);

	}

        

        #Insert an access group

	function save_access_group()

	{		

		access_control($this, array('admin'));

			

		if($this->input->post('save'))

		{

                    $required_fields = array('groupname', 'isadmin');

                    $_POST = clean_form_data($_POST);

                    $validation_results = validate_form('', $_POST, $required_fields);

		

                    #Only proceed if the validation for required fields passes

                    if($validation_results['bool'])

                    {

                        if($this->input->post('editid')){ 

				$result = $this->db->query($this->Query_reader->get_query_by_code('update_user_group', array_merge($_POST, array('groupid'=>$_POST['editid']))));

			

                                #Update the access group's member isadmin details

                                if($result)

                                    $result = $this->db->query($this->Query_reader->get_query_by_code('update_isadmin_status',array('isadmin' => $_POST['isadmin'],'accessgroup' => $_POST['editid'] )));

                        } 

			else 

			{

                            #Check if a group with a similar name already exists

                            $groupNameQuery = $this->Query_reader->get_query_by_code('get_user_group_by_name', $_POST);

                            $groupNameQueryResult = $this->db->query($groupNameQuery);

                            if($groupNameQueryResult->num_rows() < 1){

                                $_POST = array_merge($_POST, array('addedby' => $this->session->userdata('userid')));

                                $result = $this->db->query($this->Query_reader->get_query_by_code('insert_user_group', $_POST));

                                                            

                            }

                            else

                            {

                                $data['msg'] = "WARNING: An access group with a similar name already exists.";

                            }

				

			}

			

			#Format and send the errors

			if(!empty($result) && $result){

				$this->session->set_userdata('usave', "The access group data has been successfully saved.");

				redirect("admin/manage_access_groups/m/usave");

			}

			else if(empty($data['msg']))

			{

				$data['msg'] = "ERROR: The access group not be saved or was not saved correctly.";

			}

                    }#VALIDATION end

			

			

                    if((empty($validation_results['bool']) || (!empty($validation_results['bool']) && !$validation_results['bool'])) 

                    && empty($data['msg']) )

                    {

                    	$data['msg'] = "WARNING: The highlighted fields are required.";

                    }

			

                    $data['requiredfields'] = $validation_results['requiredfields'];

                    $data['groupdetails'] = $_POST;

                        

		}

		

		$this->load->view('admin/add_access_group', $data);

	}

        

        #Function to update the permissions of a user group

	function update_permissions()

	{

		access_control($this, array('admin'));

		

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i', 't'));

		# Pick all assigned data

		$data = assign_to_data($urldata);

		

		if(!empty($data['i'])){

			$result = $this->db->query($this->Query_reader->get_query_by_code('get_group_permissions', array('groupid'=>decryptValue($data['i'])) ));

			$the_permissions_list = $result->result_array();

			$data['permissions_list'] = array();

			foreach($the_permissions_list AS $permission_row){

				array_push($data['permissions_list'], $permission_row['permissionid']);

			}

			

			

			$data['groupdetails'] = $this->Query_reader->get_row_as_array('get_group_by_id', array('groupid'=>decryptValue($data['i']) ));

			$usertype = ($this->session->userdata('isadmin') == 'Y')? "admin": "";

			$result = $this->db->query($this->Query_reader->get_query_by_code('get_all_permissions', array('accesslist'=>"'".$usertype."'") ));

			$data['all_permissions'] = $result->result_array();

			

			#put all permissions in a manageable array

			$data['all_permissions_list'] = array();

			foreach($data['all_permissions'] AS $thepermission){

				array_push($data['all_permissions_list'], $thepermission['id']);

			}

		}

		

		if(!empty($data['t']) && $data['t'] == 'super'){

			$tstr = "/t/super";

		}else{

			$tstr = "";

		}

		

		if($this->input->post('updatepermissions'))

		{

			if(!empty($_POST['permissions'])){

				$result_array = array();

				#First delete all permissions from the access table

				$delresult = $this->db->query($this->Query_reader->get_query_by_code('delete_group_permissions', array('groupid'=>$_POST['editid']) ));

				

				array_push($result_array, $delresult);

				

				foreach($_POST['permissions'] AS $permissionid)

				{

					$insresult = $this->db->query($this->Query_reader->get_query_by_code('add_group_permission', array('groupid'=>$_POST['editid'], 'permissionid'=>$permissionid) ));

					array_push($result_array, $insresult);

				}

				

				if(get_decision($result_array)){

					$this->session->set_userdata('pgroup', "The Group permissions have been assigned.");

					redirect("admin/manage_access_groups/m/pgroup".$tstr);

				}

			}

		}

		

		if(empty($result) || !$result)

		{

			if(empty($_POST['permissions']))

			{

				$this->session->set_userdata('puser', "WARNING: No permissions are assigned to the group.");

			}

			else

			{

				$this->session->set_userdata('puser', "ERROR: The group permissions could not be assigned.");

			}

			redirect(base_url()."admin/manage_access_groups/m/pgroup".$tstr);

		}

		

		$this->load->view('admin/group_permissions', $data);

	

	}

	

	

	

	#Function to get user permissions

	function get_user_permissions()

	{

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i', 't'));

		# Pick all assigned data

		$data = assign_to_data($urldata);

		

		$accessgroup = '';

		

		#if the function is passed the access group id

		if(!empty($data['accessgroup']))

		{

			$this->session->set_userdata('this_access_group', $data['accessgroup']);

			$accessgroup = $data['accessgroup'];

		}

		#If the function is passed a user id

		else if(!empty($data['i']))

		{

			$userdetails = $this->Query_reader->get_row_as_array('get_user_by_id', array('id'=>decryptValue($data['i']) ));

			$accessgroup = $userdetails['accessgroup'];

			$this->session->set_userdata('this_access_group', $userdetails['accessgroup']);

		}

		#If no access group is passed

		else if($this->session->userdata('this_access_group'))

		{

			$accessgroup = $this->session->userdata('this_access_group');

		}

		

		$result = $this->db->query($this->Query_reader->get_query_by_code('get_group_permissions', array('groupid'=>$accessgroup) ));

        $data['page_list'] = $result->result_array();

		

		$data['area'] = 'view_user_group_permissions';

		$this->load->view('incl/addons', $data);

	}

	

	

	

	function test()

	{

		$this->load->view('test');

	}

}



/* End of file admin.php */

/* Location: ./system/application/controllers/admin.php */

?>
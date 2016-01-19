<?php 



#**************************************************************************************

# All account functions performed from third party websites are done here

#**************************************************************************************



class Account extends CI_Controller {

	

	# Constructor

		#Constructor to set some default values at class load
	public function __construct()
    {
		   parent::__construct();
		   

		parent::Controller();	

		$this->load->library('form_validation'); 

		$this->load->model('users','user1');

		$this->load->model('sys_email','sysemail');

		date_default_timezone_set(SYS_TIMEZONE);

	}

		

	# Default to nothing

	function index()

	{

		#Do nothing

	}

	

	function check_username() {

		$_POST = clean_form_data($_POST); 

		$query = $this->Query_reader->get_query_by_code('get_user_by_username', array('username'=>$_POST['username']));

		$result = $this->db->query($query);

		//if number of rows fields is bigger them 0 that means it's NOT available '  

		if($result->num_rows() > 0){  

			//and we send 0 to the ajax request  

			echo 0;  

		}else{  

			//else if it's not bigger then 0, then it's available '  

			//and we send 1 to the ajax request  

			echo 1;  

		}

	}

	

	#Function to confirm and get a new password

	function forgot_password()

	{

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('i'));

		# Pick all assigned data

		$data = assign_to_data($urldata);

		

		if($this->input->post('sendnewpass'))

		{

			$required_fields = array('youremail*EMAILFORMAT');

			$_POST = clean_form_data($_POST);



			$validation_results = validate_form('', $_POST, $required_fields);

			

			#Only proceed if the validation for required fields passes

			if($validation_results['bool'])

			{

				#Check if a user with the specified email exists

				$userdata = $this->Query_reader->get_row_as_array('get_user_by_email_ignore_status', array('emailaddress'=>$_POST['youremail']));	

				#Active user who just forgot their password

				if(!empty($userdata) && $userdata['isactive']=='Y')

				{

					$_POST['newpass'] = generate_new_password();

					$pass_result = $this->db->query($this->Query_reader->get_query_by_code('update_user_password', array('emailaddress'=>$_POST['youremail'], 'newpass'=>sha1($_POST['newpass']) )));

					$flag_result = $this->db->query($this->Query_reader->get_query_by_code('update_user_changedpassword_flag', array('emailaddress'=>$_POST['youremail'], 'flagvalue'=>'N' )));

					

					if(get_decision(array($pass_result, $flag_result)))

					{

						$send_result = $this->sysemail->email_form_data(array('fromemail'=>SITE_ADMIN_MAIL), array_merge($userdata, $_POST, get_confirmation_messages($this, array('emailaddress'=>$_POST['youremail'], 'newpass'=>$_POST['newpass'], 'firstname'=>$userdata['firstname']), 'changed_password_notify')));

						if($send_result)

						{

							$data['msg'] = "Your new password has been sent to your email address.";

							$data['issuccess'] = 'Y';

						}

					}

					

					if(empty($send_result) || (!empty($send_result) && !$send_result))

					{

						$data['msg'] = "ERROR: A new password could not be generated. <a href='javascript:void(0)'>Click here</a> to report this error.";

					}

					

					

				}

				#The user's account was forcefully closed

				else if(!empty($userdata) && $userdata['isactive']=='N' && $userdata['forcedclose']=='Y')

				{

					$data['msg'] = "WARNING: Your account was previously deactivated due to activities contrary <BR>to our terms of use.<BR><BR>Please <a href='javascript:void(0)'>contact us</a> if you want to <BR>reactivate your account.";

				

				

				}

				#The user's account was just deactivated

				else if(!empty($userdata) && $userdata['isactive']=='N' && $userdata['forcedclose']=='N')

				{

					$_POST['newpass'] = generate_new_password();

					$reactivate_result = $this->db->query($this->Query_reader->get_query_by_code('reactivate_old_user', array('emailaddress'=>$_POST['youremail'], 'password'=>sha1($_POST['newpass']), 'enddate'=>date('Y-m-d', mktime(0,0,0,date("m"),1,date("y")+2)) )));

					$flag_result = $this->db->query($this->Query_reader->get_query_by_code('update_user_changedpassword_flag', array('emailaddress'=>$_POST['youremail'], 'flagvalue'=>'N' )));

					

					if(get_decision(array($reactivate_result, $flag_result)))

					{

						$send_result = $this->sysemail->email_form_data(array('fromemail'=>SITE_ADMIN_MAIL), array_merge($userdata, $_POST, get_confirmation_messages($this, array('emailaddress'=>$_POST['youremail'], 'newpass'=>$_POST['newpass'], 'firstname'=>$userdata['firstname']), 'changed_password_notify')));

						

						if($send_result)

						{

							$data['msg'] = "Your new password has been sent to your email address.";

							$data['issuccess'] = 'Y';

						}

					}

					

					if(empty($send_result) || (!empty($send_result) && !$send_result))

					{

						$data['msg'] = "ERROR: A new password could not be generated. <a href='javascript:void(0)'>Click here</a> to report this error.";

					}

				}

			}

			

			if(empty($data['msg'])) 

			{

				$data['msg'] = "WARNING: The highlighted fields are required.";

			}

			

			$data['requiredfields'] = $validation_results['requiredfields'];

			$data['formdata'] = $_POST;

		}

		

		$data = add_msg_if_any($this, $data);

		$this->load->view('account/forgot_password', $data);

	}

	

	

	#Function to upload a user's profile pic

	function upload_profile_pic()

	{

		access_control($this);

		#Get the product details

		if($this->input->post('submit-photo'))

		{

			$_POST = clean_form_data($_POST);  

			

			#check if recover image has been specified

			if(!empty($_FILES['profile-photo']['tmp_name']))

			{

				$file_name = 'AC_'.strtotime('now').generate_random_letter();

				$new_file_url = $file_name.".".end(explode('.', $_FILES['profile-photo']['name']));

				if(copy($_FILES['profile-photo']['tmp_name'], UPLOAD_DIRECTORY."users/".$new_file_url)) 

				{

					#Create a thumb nail as well

					$config['image_library'] = 'gd2';

					$config['source_image'] = UPLOAD_DIRECTORY."users/".$new_file_url;

					$config['create_thumb'] = TRUE;

					$config['maintain_ratio'] = TRUE;

					$config['width'] = 100;

					$config['height'] = 70;

					$this->load->library('image_lib', $config);

					$this->image_lib->resize();

																

					$save_result = $this->db->query($this->Query_reader->get_query_by_code('update_schooluser_photo',array('photo' => $new_file_url,'editid' => $this->session->userdata('userid'))));

					

					if($save_result)

					{ 

						#To do: remove the previous image

						

						//update current session photo

						$this->session->set_userdata('photo', $new_file_url);

						

						$temp_array = explode('.', $new_file_url);

						$data['msg'] = base_url()."downloads/users/".$file_name.'_thumb.'.end(explode('.', $_FILES['profile-photo']['name']));

					}

				}

			}

						

			if(empty($data['msg']) )

				$data['msg'] = "ERROR";

			

			

		}		

			

		$data['area'] = 'upload_user_photo';

		$this->load->view('incl/addons', $data);

	}

	

	

	

	#Function to get the a user's settings

	function settings()

	{

		access_control($this);

		

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('i'));

		# Pick all assigned data

		$data = assign_to_data($urldata);

		

		#Get user settings

		$editid = $this->session->userdata('userid');

		

		if($this->session->userdata('usertype') == 'SCHOOL')

		{

			$data['formdata'] = $this->Query_reader->get_row_as_array('get_school_user_by_id', array('id'=>$editid));			

		}

		elseif($this->session->userdata('usertype') == 'MSR')

		{

			$data['formdata'] = $this->Query_reader->get_row_as_array('get_user_by_id', array('id'=>$editid));

		}

		

		$data['isview'] = (!empty($data['a']) && decryptValue($data['a']) == 'view')? "Y": "";		

		

		if($this->input->post('savesettings'))

		{

			$required_fields = array('firstname', 'lastname', 'address', 'emailaddress*EMAILFORMAT', 'telephone');

			$_POST = clean_form_data($_POST);

			$validation_results = validate_form('', $_POST, $required_fields);

			$update_string = '';

			#Only proceed if the validation for required fields passes

			if($validation_results['bool'])

			{	

				#Check if the password has been changed, is strong enough and the repeated value is the same

				if(!empty($_POST['password']) || !empty($_POST['repeatpassword']))

                {   

                    $passwordmsg = $this->user1->check_password_strength($_POST['password']);

                    if(!$passwordmsg['bool'])

                    {

                        $data['msg'] = "WARNING: ".$passwordmsg['msg'];

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

				

				#Check if a new photo has been uploaded

				if(!empty($_FILES['imageurl']['tmp_name']))

				{

					$new_file_url = 'ac_'.strtotime('now').generate_random_letter().".".end(explode('.', $_FILES['imageurl']['name']));

					if(copy($_FILES['imageurl']['tmp_name'], UPLOAD_DIRECTORY."users/".$new_file_url)) 

					{				

						#Create a thumb nail as well

						$config['image_library'] = 'gd2';

						$config['source_image'] = UPLOAD_DIRECTORY."users/".$new_file_url;

						$config['create_thumb'] = TRUE;

						$config['maintain_ratio'] = TRUE;

						$config['width'] = 100;

						$config['height'] = 80;

						$this->load->library('image_lib', $config);

						$this->image_lib->resize();

						

						#Delete the previous image from the server if it exists

						if(!empty($data['formdata']['photo']))

							@unlink(UPLOAD_DIRECTORY."users/".$data['formdata']['photo']);

						$update_string .= ',photo ="'.$new_file_url.'"';

					}

				}

				

				#Update or Save the new form data

				if(empty($data['msg']))

				{

					if($this->session->userdata('usertype') == 'SCHOOL')

					{

						$save_result = $this->db->query($this->Query_reader->get_query_by_code('update_school_user_data',  array_merge(array('editid'=>$editid, 'usertype'=> $this->session->userdata('usertype'), 'usergroup' => $this->session->userdata('usergroup'), 'isschooladmin' => $this->session->userdata('isschooladmin'), 'updatecond'=>$update_string), $_POST)));

					}

					elseif($this->session->userdata('usertype') == 'MSR')

					{

						$save_result = $this->db->query($this->Query_reader->get_query_by_code('update_user_data',  array('editid'=>$editid, 'firstname'=>$_POST['firstname'], 'lastname'=>$_POST['lastname'], 'middlename'=>$_POST['middlename'], 'addressline1'=>$_POST['addressline1'], 'emailaddress'=>$_POST['emailaddress'], 'telephone'=>$_POST['telephone'], 'usertype'=>$this->session->userdata('usertype'), 'isadmin'=>$_POST['isadmin'], 'updatecond'=>$update_string  ) ));

					}

					

					

					$msg = (!empty($save_result) && $save_result)? "Your settings have been saved.": "ERROR: Your settings were not saved.";

					$this->session->set_userdata('sres', $msg);

					redirect($this->user1->get_dashboard()."/m/sres");

				}

			} #VALIDATION end

			

			

			if((empty($validation_results['bool']) || (!empty($validation_results['bool']) && !$validation_results['bool'])) 

			&& empty($data['msg']) )

			{

				$data['msg'] = "WARNING: The highlighted fields are required.";

			}

			

			$data['requiredfields'] = $validation_results['requiredfields'];

			$data['formdata'] = $_POST;

		}

		

		

		if(empty($data['formdata'])) 

		{

			$this->session->set_userdata('suser', "ERROR: Your settings could not be resolved.");

			redirect($this->user1->get_dashboard()."/m/suser");

		}

		

		$data = add_msg_if_any($this, $data);

		$this->load->view('admin/settings_view', $data);

	}

	

	

	

	

	

	

	

	

	

	

}

?>
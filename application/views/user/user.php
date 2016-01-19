<?php 

#**************************************************************************************
# All user functions are passed through this controller
#**************************************************************************************

class User extends Controller {
	
	# Constructor
	function User() 
	{	
		parent::Controller();	
		$this->load->library('form_validation'); 
		$this->load->model('users','user1');
		$this->load->model('sys_email','sysemail');
		$this->load->model('file_upload','libfileobj');
		$this->load->model('sys_file','sysfile');
		date_default_timezone_set(SYS_TIMEZONE);
		$this->myschool = $this->session->userdata('schoolinfo');
	}
	
	var $myschool;
		
	# Default to nothing
	function index()
	{
		#Do nothing
	}	
	
	
	# manage users dashboard
	function manage_users()
	{
		access_control($this);
		
		# Get the passed details into the url data array if any
		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));
		
		# Pick all assigned data
		$data = assign_to_data($urldata);
								
		#Get the paginated list of users
		$data = paginate_list($this, $data, 'search_school_users', array('limittext' =>'', 'searchstring' => ' AND school ='.$this->myschool['id']));
         
		$data = add_msg_if_any($this, $data);
		
		$data = handle_redirected_msgs($this, $data);
				
		$this->load->view('user/manage_users_view', $data);
	}
	
	
	#User dashboard
	function dashboard()
	{
		access_control($this);
		
		# Get the passed details into the url data array if any
		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));
		
		# Pick all assigned data
		$data = assign_to_data($urldata);
		
		$data['limitrows'] = NUM_OF_ROWS_PER_PAGE;
				
		$data = add_msg_if_any($this, $data);
		$data['schoolinfo'] = $this->myschool;
		
		$this->load->view('user/client_dashboard_view', $data);
	}
	
	#Function to upload a user's profile-photo
	function upload_profile_photo()
	{
		# Get the passed details into the url data array if any
		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i', 'a', 't'));
		
		# Pick all assigned data
		$data = assign_to_data($urldata);	
		$data = restore_bad_chars($data);
		$new_image_url = 'ac_'.strtotime('now').generate_random_letter().".".end(explode('.', $data['upload-photo']));
		print_r($data); exit($new_image_url);				
		#First move the photo to the correct folder
		if(copy(str_replace("/kunden/", "/", $_FILES['imageurl']['tmp_name']), UPLOAD_DIRECTORY."students/".$new_image_url)) 
		{
			#Create a thumb nail as well
			$config['image_library'] = 'gd2';
			$config['source_image'] = UPLOAD_DIRECTORY."students/".$new_file_url;
			$config['create_thumb'] = TRUE;
			$config['maintain_ratio'] = TRUE;
			$config['width'] = 180;
			$config['height'] = 160;
			$this->load->library('image_lib', $config);
			$this->image_lib->resize();
			
			$_POST['photo'] = $new_image_url;
			$data['msg'] = 'SUCCESS';
			$data['photo_dir'] = UPLOAD_DIRECTORY."students/".$new_image_url;
		}
		else
		{
			$data['msg'] = 'ERROR: The file could not be uploaded.';
		}
	}
	
	#Function to manage staff
	function manage_staff_groups()
	{
		access_control($this);		
		
		# Get the passed details into the url data array if any
		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));
		
		# Pick all assigned data
		$data = assign_to_data($urldata);
                
		#Get the paginated list of users
		$data = paginate_list($this, $data, 'search_staff_groups', array('limittext' =>'', 'searchstring' => ' AND school ='.$this->myschool['id']));
         
		$data = add_msg_if_any($this, $data);
		$data = handle_redirected_msgs($this, $data);
		
		$this->load->view('user/manage_staff_groups_view', $data);
	}
	
	
	#Function to manage staff
	function manage_staff()
	{
		access_control($this);		
		
		# Get the passed details into the url data array if any
		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));
		
		# Pick all assigned data
		$data = assign_to_data($urldata);
                
		#Get the paginated list of users
		$data = paginate_list($this, $data, 'search_school_users', array('limittext' =>'', 'searchstring' => ' AND school ='.$this->myschool['id']));
         
		$data = add_msg_if_any($this, $data);
		$data = handle_redirected_msgs($this, $data);
		
		$this->load->view('user/manage_staff_view', $data);
	}
	
	#Function to add staff
	function save_staff()
	{
		access_control($this);
		
		# Get the passed details into the url data array if any
		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i', 'a', 's'));
		
		# Pick all assigned data
		$data = assign_to_data($urldata);		
		
		$data = restore_bad_chars($data);
		
		if($data['save'])
		{ 
			$data['formdata'] = $data;		
            $required_fields = array('firstname', 'lastname', 'address', 'emailaddress*EMAILFORMAT', 'telephone', 'username');
			$_POST = clean_form_data($data);
			$validation_results = validate_form('', $_POST, $required_fields);
                        
			#set status as editing on destination if updating
            if(!empty($_POST['editid'])) $data['editid'] = $_POST['editid'];
            			
			#Only proceed if the validation for required fields passes
			if($validation_results['bool'])
			{
				if(!empty($_POST['editid']))
                {
					$update_string = '';
					
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
							$config['width'] = 180;
							$config['height'] = 160;
							$this->load->library('image_lib', $config);
							$this->image_lib->resize();
							
							#Delete the previous image from the server if it exists
							if(!empty($data['formdata']['fileurl']))
								@unlink(UPLOAD_DIRECTORY."users/".$data['formdata']['imageurl']);
							$update_string .= ',photo ="'.$new_file_url.'"';
							$admission_result = $this->student_mod->update_student_data($_POST);
						}
					}					
				
					if((empty($_POST['password']) && empty($_POST['repeatpassword'])) || !empty($update_string))
					{
						#Attach school id to the data
						$_POST['school'] = $this->myschool['school'];
						$_POST['author'] = $this->session->userdata('userid');
						
						//set user type
						$_POST['usertype'] = 'SCHOOL';
						
						$result = $this->db->query($this->Query_reader->get_query_by_code('update_school_user_data', array_merge($_POST, array('updatecond'=>$update_string)) ));							
					}
           	  	} 
			 
			 
			 	else 
             	{
					#check if a similar username already exists in both users and school users tables
               	 	$username_error = "";
                	$usernames = $this->db->query($this->Query_reader->get_query_by_code('get_existing_usernames', array('searchstring' => ' username = "'.$_POST['username'].'"')));
					#school users
					$school_usernames = $this->db->query($this->Query_reader->get_query_by_code('search_schoolusers', array('searchstring' => ' username = "'.$_POST['username'].'"')));
					
					#Check if the email added has already been used by system user
					$system_user_email_details  = $this->Query_reader->get_row_as_array('get_any_user_by_email', array('emailaddress'=>$data['formdata']['emailaddress']));
					
					#Check if the email added has already been used by school user
					$school_user_email_details  = $this->Query_reader->get_row_as_array('search_school_users', array('limittext' => '', 'searchstring' => ' AND emailaddress = "'.$data['formdata']['emailaddress'].'"'));
					
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
					elseif(!empty($school_user_email_details) || !empty($system_user_email_details) )
					{
						$data['msg'] = "WARNING: The specified email address is already in use.";
					}                      
                	elseif(!$passwordmsg['bool']){
                    	$data['msg'] = "WARNING: ".$passwordmsg['msg'];
                	}                                     
                	elseif($_POST['password'] == $_POST['repeatpassword'] && !empty($_POST['password']))
					{
						$_POST['newpass'] = $_POST['password'];
						
						#Attach school id to the data
						$_POST['school'] = $this->myschool['id'];
						$_POST['author'] = $this->session->userdata('userid');
						
						//set the usertype
						$_POST['usertype'] = 'SCHOOL';
						
						#First move the photo to the correct folder and then add the user
						/*
						if(copy(str_replace("/kunden/", "/", $_FILES['imageurl']['tmp_name']), UPLOAD_DIRECTORY."users/".$new_image_url)) 
						{
							#Create a thumb nail as well
							$config['image_library'] = 'gd2';
							$config['source_image'] = UPLOAD_DIRECTORY."users/".$new_file_url;
							$config['create_thumb'] = TRUE;
							$config['maintain_ratio'] = TRUE;
							$config['width'] = 180;
							$config['height'] = 160;
							$this->load->library('image_lib', $config);
							$this->image_lib->resize();
							
							$_POST['photo'] = $new_image_url;
							$result = $this->db->query($this->Query_reader->get_query_by_code('add_school_user', array_merge($_POST, array('password'=>sha1($_POST['newpass'])) )));
						}
						else
						{
							$_POST['photo'] = '';
							$result = $this->db->query($this->Query_reader->get_query_by_code('add_school_user', array_merge($_POST, array('password'=>sha1($_POST['newpass'])) )));
						}
						*/
						
						$_POST['photo'] = '';
						$result = $this->db->query($this->Query_reader->get_query_by_code('add_school_user', array_merge($_POST, array('password'=>sha1($_POST['newpass'])))));
						
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
					
					$data['msg'] = "The user data has been successfully saved.";
					
					$data['formdata'] = array();
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
		
		#Get access groups                
        $usergroupsResult = $this->db->query($this->Query_reader->get_query_by_code('get_user_groups',array('searchstr' => ' AND school = '.$this->myschool['id'])));
        $data['usergroups'] = get_select_options($usergroupsResult->result_array(), 'id', 'groupname', ((empty($data['formdata']['usergroup'])) ? '' : $data['formdata']['usergroup']), 'Y', 'Select');	
                        
		$this->load->view('incl/staff_form', $data);
	}
	
	
	#Function to add a staff group
	function save_staff_group()
	{
		access_control($this);
		
		# Get the passed details into the url data array if any
		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i', 'a', 's'));
		
		# Pick all assigned data
		$data = assign_to_data($urldata);		
		
		if($data['save'])
		{ 
            $required_fields = array('groupname');
			
			$data = restore_bad_chars($data);
			
			$_POST = clean_form_data($data);
			
			$data['formdata'] = $_POST;	
			
			$validation_results = validate_form('', $_POST, $required_fields);
                        
			#set status as editing on destination if updating
            if($this->input->post('editid')) $data['editid'] = $_POST['editid'];
            			
			#Only proceed if the validation for required fields passes
			if($validation_results['bool'])
			{
				if(!empty($data['editid']))
                {
					#Attach school id to the data
					$_POST['school'] = $this->myschool['id'];
					$_POST['author'] = $this->session->userdata('userid');
						
					$result = $this->db->query($this->Query_reader->get_query_by_code('update_staff_group', array_merge($_POST, array('updatecond'=>'')) ));	
           	  	}
			 	else 
             	{
					#check if a similar group already exists for the current school
                	$staffgroup_details = $this->Query_reader->get_row_as_array('search_staff_groups', array('limittext'=>'', 'searchstring' => ' AND school = '.$this->myschool['id'].' AND groupname ="'.$data['formdata']['groupname'].'"'));
					
					if(empty($staffgroup_details)){
						#Attach school id to the data
						$_POST['school'] = $this->myschool['id'];
						$_POST['author'] = $this->session->userdata('userid');
						$result = $this->db->query($this->Query_reader->get_query_by_code('add_staff_group', $_POST));
					}
				}
				
           		#Format and send the errors
            	if(!empty($result) && $result)
				{
					#$this->session->set_userdata('usave', "The staff group data has been successfully created.");					
					if(empty($data['editid']))
					{
						$data['formdata'] = array();
						$data['msg'] = "SUCCESS: The staff group data has been successfully created.";	
					}
					else
					{
						$data['msg'] = "SUCCESS: The staff group data has been successfully updated.";
					}
					#redirect("user/manage_staff_groups/m/usave/s/".encryptValue($_POST['school']));
            	 }
            	 else if(empty($data['msg']))
            	 {                 
				   	$data['msg'] = "ERROR: The staff group could not be saved or was not saved correctly.";
             	}
            }
            
			#Prepare a message in case the user already exists
			else if(empty($data['editid']) && !empty($staffgroup_details))
			{				 
				 $data['msg'] .= "<br />WARNING: The staff group name has already been used"; 
			}
			             
            if((empty($validation_results['bool']) || (!empty($validation_results['bool']) && !$validation_results['bool'])) 
			&& empty($data['msg']) )
			{
				$data['msg'] = "WARNING: The highlighted fields are required.";
			}
			
			$data['requiredfields'] = $validation_results['requiredfields'];
		}		
                        
		$this->load->view('user/staff_groups_form_view', $data);
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
	
	#Function to load the stuff form
	function load_staff_form()
	{
		access_control($this);		
		
		# Get the passed details into the url data array if any
		$urldata = $this->uri->uri_to_assoc(3, array('s', 'i','a'));
		
		# Pick all assigned data
		$data = assign_to_data($urldata);
                                
        #user is editing
		if(!empty($data['i']))
		{
			$userid = decryptValue($data['i']);
			
			#get the user's details
			$data['formdata'] = $this->Query_reader->get_row_as_array('get_school_user_by_id', array('id'=>$userid));
                                    
            #Check if the user is simply viewing
            if(!empty($data['a']) && decryptValue($data['a']) == 'view')
            {
                $data['isview'] = "Y";
            }
		}
		
		#Get access groups                
        $usergroupsResult = $this->db->query($this->Query_reader->get_query_by_code('get_user_groups',array('searchstr' => ' AND school = '.$this->myschool['id'])));
        $data['usergroups'] = get_select_options($usergroupsResult->result_array(), 'id', 'groupname', ((empty($data['formdata']['usergroup'])) ? '' : $data['formdata']['usergroup']), 'Y', 'Select');
		
		$this->load->view('user/staff_form_view', $data);
	}
	
	
	#Function to load the staff groups form
	function load_staff_groups_form()
	{
		access_control($this);		
		
		# Get the passed details into the url data array if any
		$urldata = $this->uri->uri_to_assoc(3, array('s', 'i','a'));
		
		# Pick all assigned data
		$data = assign_to_data($urldata);
                                
        #user is editing
		if(!empty($data['i']))
		{
			$groupid = decryptValue($data['i']);
			
			#get the group details
			$data['formdata'] = $this->Query_reader->get_row_as_array('search_staff_groups', array('limittext' => '', 'searchstring' => ' AND school ='.$this->myschool['id'].' AND id ='.$groupid));
                                    
            #Check if the user is simply viewing
            if(!empty($data['a']) && decryptValue($data['a']) == 'view')
            {
                $data['isview'] = "Y";
            }
		}
		
		$this->load->view('user/staff_groups_form_view', $data);
	}
	
	
	
	#Function to add user to a group
	function add_user_to_group()
	{
		access_control($this);
		
		# Get the passed details into the url data array if any
		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));
		# Pick all assigned data
		$data = assign_to_data($urldata);
		
		if(!empty($data['a']) && decryptValue($data['a']) == 'adduser')
		{
			$result = $this->db->query($this->Query_reader->get_query_by_code('add_user_to_group', array('groupname'=>decryptValue($data['gn']), 'userid'=>$data['adduserid'], 'isactive'=>'Y')));
			
			$data['msg'] = ($result)? "The user has been added to the email group.": "ERROR: The user could not be added to the email group.";
			
			$userlist = $this->session->userdata('usergrouplist');
			array_push($userlist, $data['adduserid']);
			$this->session->set_userdata('usergrouplist', $userlist);
			
			$group = $this->db->query($this->Query_reader->get_query_by_code('get_group_by_name', array('groupname'=>decryptValue($data['gn']) ))); 
			$data['page_list'] = $group->result_array();
			
			$data['area'] = "user_email_group_list";
			$this->load->view('incl/addons', $data);
		}
		else
		{
			$data['gn'] = (!empty($data['groupname']))? encryptValue(restore_bad_chars($data['groupname'])): $data['gn'];
			
			$data['area'] = "add_user_to_group";
			$this->load->view('incl/addons', $data);
		}
	}
	
	#Function to load the rights of a school staff group
	function manage_staff_group_rights()
	{
		access_control($this);
		
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
			
			$data['groupdetails'] = $this->Query_reader->get_row_as_array('get_group_by_id', array('id'=>decryptValue($data['i']) ));
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
					redirect("user/manage_staff_groups/m/pgroup".$tstr);
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
			redirect(base_url()."user/manage_staff_groups/m/pgroup".$tstr);
		}
		
		$this->load->view('user/staff_group_permissions', $data);
	}
	
	#Function to delete a staff group
	function delete_staff_group()
	{
		access_control($this);
		
		# Get the passed details into the url data array if any
		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i', 't'));
		
		# Pick all assigned data
		$data = assign_to_data($urldata);
		
		if(!empty($data['i']))
			$result = delete_row($this, 'usergroups', decryptValue($data['i']));
		
		
		if(!empty($result) && $result){
			$this->session->set_userdata('dsg', "The staff group has been deleted.");
			
			#Delete the staff group's permissions as well
			$this->db->query($this->Query_reader->get_query_by_code('delete_group_permissions', array('groupid' => decryptValue($data['i']))));
		}
		else if(empty($data['msg']))
		{
			#$this->session->set_userdata('dsg', "ERROR: The staff group could not be deleted or was not deleted correctly.");
		}
		
		if(!empty($data['t']) && $data['t'] == 'super'){
			$tstr = "/t/super";
		}else{
			$tstr = "";
		}
		#redirect("user/manage_staff_groups/m/dsg".$tstr);
	}
	
	
	
	#Function to deactivate an organization
	function deactivate_organization()
	{
		access_control($this);
		
		# Get the passed details into the url data array if any
		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));
		# Pick all assigned data
		$data = assign_to_data($urldata);
		
		if(!empty($data['i']))
		{
			$result = $this->db->query($this->Query_reader->get_query_by_code('update_organization_status', array('id'=>decryptValue($data['i']), 'isactive'=>'N' )));
		}
		
		$msg = (!empty($result) && $result)? "The user has been removed.": "ERROR: The user was not removed.";
		$this->session->set_userdata('sres', $msg);
		
		redirect(base_url()."user/manage_organizations/m/sres");
	}
	
	
	
	
	#Function to add an organization
	function add_organization()
	{
		access_control($this);
		
		# Get the passed details into the url data array if any
		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));
		# Pick all assigned data
		$data = assign_to_data($urldata);
		$this->session->set_userdata('local_allowed_extensions', array('.jpg', '.jpeg', '.gif', '.png', '.tiff', '.bmp'));
		
		if(!empty($data['i']))
		{
			$data['formdata'] = $this->Query_reader->get_row_as_array('get_organization_by_id', array('id'=>decryptValue($data['i']) ));
			$data['isview'] = (!empty($data['a']) && decryptValue($data['a']) == 'view')? "Y": "";
		}
		
		
		#Save the document details
		if($this->input->post('saveorgn'))
		{
			$required_fields = array('organizationname', 'datestarted', 'contactperson', 'contactemail*EMAILFORMAT', 'contactphone', 'contactaddressline1', 'contactcity', 'contactzipcode', 'contactstate');
			$_POST = clean_form_data($_POST);
			$validation_results = validate_form('', $_POST, $required_fields);
			
			#Only proceed if the validation for required fields passes
			if($validation_results['bool'])
			{
				$_POST['datestarted'] = (empty($_POST['datestarted']))? "": date('Y-m-d', strtotime($_POST['datestarted']));
				
				$_POST['logourl'] = !empty($_FILES['logourl']['name'])? $this->sysfile->local_file_upload($_FILES['logourl'], 'Upload_'.strtotime('now'), 'images', 'filename'): '';
				$_POST['iconurl'] = !empty($_FILES['iconurl']['name'])? $this->sysfile->local_file_upload($_FILES['iconurl'], 'iUpload_'.strtotime('now'), 'images', 'filename'): '';
				
				#Use the old versions if no new ones are entered
				$_POST['logourl'] = (empty($_POST['logourl']) && !empty($data['formdata']['logourl']))? $data['formdata']['logourl']: $_POST['logourl'];
				$_POST['iconurl'] = (empty($_POST['iconurl']) && !empty($data['formdata']['iconurl']))? $data['formdata']['iconurl']: $_POST['iconurl'];
				
				#First remove the document record and file from the system
				if(!empty($data['formdata']) && !empty($data['i']))
				{
					$save_result = $this->db->query($this->Query_reader->get_query_by_code('update_organization', array_merge($_POST, array('editid'=>decryptValue($data['i']) )) ));
				}
				else
				{
					$save_result = $this->db->query($this->Query_reader->get_query_by_code('save_new_organization', $_POST ));
				}
			 
				$data['msg'] = ($save_result)? "The organization has been saved.": "ERROR: The organization was not saved. Please contact your administrator.";
				
				$this->session->set_userdata('sres', $data['msg']);
				redirect(base_url()."user/manage_organizations/m/sres");
			} #VALIDATION end
			
			
			if((empty($validation_results['bool']) || (!empty($validation_results['bool']) && !$validation_results['bool'])) 
			&& empty($data['msg']) )
			{
				$data['msg'] = "WARNING: The highlighted fields are required.";
			}
			
			$data['requiredfields'] = $validation_results['requiredfields'];
			$data['formdata'] = $_POST;
			
		}
		
		
		$data = add_msg_if_any($this, $data);
		$this->load->view('user/add_organization_view', $data);
	}
	
	
	
	
	#Function to get a list of users in a group
	function get_group_users()
	{
		access_control($this);
		
		# Get the passed details into the url data array if any
		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));
		# Pick all assigned data
		$data = assign_to_data($urldata);
		
		if(!empty($data['gn']))
		{
			$group_list = $this->db->query($this->Query_reader->get_query_by_code('get_group_by_name', array('groupname'=>decryptValue($data['gn']) )));
			
			$data['group_list'] = $group_list->result_array();
		}
		
		$data['area'] = "group_emails_list";
		$this->load->view('incl/addons', $data);
	}
	
	
	     
    #Function to delete the staff member
	function delete_staff()
	{
		access_control($this);
		
		# Get the passed details into the url data array if any
		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i', 't'));
		
		# Pick all assigned data
		$data = assign_to_data($urldata);
		
		if(!empty($data['i'])){
			$result = deactivate_row($this, 'schoolusers', decryptValue($data['i']));
		}
		
		if(!empty($result) && $result){
			$data['msg'] = "The user data has been successfully deleted.";
		}
		else if(empty($data['msg']))
		{
			$data['msg'] = "ERROR: The user could not be deleted or was not deleted correctly.";
		}
		
		if(!empty($data['t']) && $data['t'] == 'super'){
			$tstr = "/t/super";
		}else{
			$tstr = "";
		}
	}
	
}
?>
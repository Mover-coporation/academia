<?php 



#**************************************************************************************

# All normal website pages that do not require login are directed from this controller

#**************************************************************************************



class Page extends CI_Controller {

	#Constructor to set some default values at class load
	public function __construct()
    {
		   parent::__construct();	

		#$this->load->plugin('captcha');

		

		$this->load->model('users','user1');

		$this->load->model('sys_email','sysemail');

		$this->load->model('file_upload','libfileobj');

		$this->load->model('sys_file','sysfile');

		date_default_timezone_set(SYS_TIMEZONE);

	}

	

	

	

	# Default to nothing

	function index()

	{

		#Do nothing

	}

	

	

	# The search home

	function home()

	{

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m', 'p'));

		# Pick all assigned data

		$data = assign_to_data($urldata);

		

		#Unset navigation session settings

		$this->session->unset_userdata(array('from_search_results'=>''));

		

		if(!empty($data['r'])){

			$this->session->set_userdata('referredby', decryptValue($data['r']));

		}

		

		$this->load->view('login_view', $data);

		#$this->load->view('test', $data);

	}

	

	

	

	

	

	

	#Function to process the contact us page

	function process_contactus()

	{

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m'));

		# Pick all assigned data

		$data = assign_to_data($urldata);

		

		if($this->input->post('sendmessage'))

		{

			$required_fields = array('emailaddress*EMAILFORMAT', 'helptopic', 'subject', 'description', 'captcha');

			$_POST['attachmenturl'] = !empty($_FILES['attachmenturl']['name'])? $this->sysfile->local_file_upload($_FILES['attachmenturl'], 'Upload_'.strtotime('now'), 'attachments', 'filename'): '';

			

			$_POST = clean_form_data($_POST);

			$validation_results = validate_form('', $_POST, $required_fields);

			

			#Only proceed if the validation for required fields passes

			if($validation_results['bool'] && is_valid_captcha($this, $_POST['captcha']))

			{ 

				#Send the contact message to the administrator and 

				$send_result = $this->sysemail->email_form_data(array('fromemail'=>NOREPLY_EMAIL), 

						get_confirmation_messages($this, $_POST, 'website_feedback'));

				

				if($send_result)

				{

					$data['msg'] = "Your message has been sent. Thank you for your feedback.";

					$data['successful'] = 'Y';

				}

				else

				{

					$data['msg'] = "ERROR: Your message could not be sent. Please contact us using our phone line.";

				}

			}

			

			if(!$validation_results['bool'])

			{

				$data['msg'] = "WARNING: The highlighted fields are required.";

			}

			

			$data['requiredfields'] = array_merge($validation_results['requiredfields'], array('captcha'));

			$data['formdata'] = $_POST;

		

		}

		

		$data['pagedata'] = $this->Query_reader->get_row_as_array('get_page_by_section', array('section'=>'Support', 'subsection'=>'Contact Us'));

		if(count($data['pagedata']) > 0)

		{

			$data['pagedata']['details'] = str_replace("&amp;gt;", "&gt;", str_replace("&amp;lt;", "&lt;", $data['pagedata']['details']));

					

			$data['pagedata']['parsedtext'] = $this->wiki_manager->parse_text_to_HTML(htmlspecialchars_decode($data['pagedata']['details'], ENT_QUOTES));

			$result = $this->db->query($this->Query_reader->get_query_by_code('get_subsections_by_section', array('section'=>$data['pagedata']['section'])));

			$data['subsections'] = $result->result_array();

		}

		

		

		$data = add_msg_if_any($this, $data);

		$this->load->view('page/contactus_view', $data);

	}

	

	

	

	

	

	

	

	

	#Function to update user location

	function update_user_location()

	{

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i', 'd'));

		# Pick all assigned data

		$data = assign_to_data($urldata);

		

		#Get default location if none is given

		if(empty($_POST))

		{

			$data['default_location'] = $this->user1->get_user_location();

			$this->session->set_userdata('returnurl', base_url().'admin/load_dashboard');

		}

		

		if($this->input->post('updatelocation'))

		{

			$required_fields = array('city', 'state', 'zipcode', 'country', 'emailaddress*EMAILFORMAT', 'iagree');

			$_POST = clean_form_data($_POST);

			if(empty($_POST['iagree'])){

				$_POST['iagree'] = '';

			}

			$validation_results = validate_form('', $_POST, $required_fields);

			

			

			if($validation_results['bool'])

			{

				if($this->session->userdata('emailaddress') || !empty($_POST['emailaddress']))

				{

					$emailaddress = ($this->session->userdata('emailaddress'))? $this->session->userdata('emailaddress'): $_POST['emailaddress'];

					$userdetails = $this->Query_reader->get_row_as_array('get_user_by_email_ignore_status', array('emailaddress'=>$emailaddress));

				}

				

				#Get the current location of the user

				$location = $this->user1->get_ip_location($this->input->ip_address());

				

				#Just update the user location with a custom location if the account exists

				if($this->session->userdata('emailaddress') && !empty($userdetails))

				{

					$location_result = $this->db->query($this->Query_reader->get_query_by_code('save_user_location', array('useremail'=>$_POST['emailaddress'], 'country'=>$_POST['country'], 'region'=>$_POST['state'], 'city'=>$_POST['city'], 'zipcode'=>$_POST['zipcode'], 'isp'=>$location['isp'], 'latitude'=>$location['latitude'], 'longitude'=>$location['longitude'])));

				}

				#Account exists but user did not log in

				else if(!empty($userdetails))

				{

					$data['msg'] = "WARNING: An account with the provided emailaddress already exists. <BR><BR>Please first login and then update this account owner's location.";

				}

				#Create a user and a location

				else

				{

					$_POST['newpass'] = generate_new_password();

					$result = $this->db->query($this->Query_reader->get_query_by_code('add_user_data', array('firstname'=>'', 'lastname'=>'', 'username'=>$_POST['emailaddress'], 'password'=>sha1($_POST['newpass']), 'emailaddress'=>$_POST['emailaddress'], 'telephone'=>'',  'enddate'=>date('Y-m-d', mktime(0,0,0,date("m"),1,date("y")+2)) )));

					

					$location_result = $this->db->query($this->Query_reader->get_query_by_code('save_user_location', array('useremail'=>$_POST['emailaddress'], 'country'=>$_POST['country'], 'zipcode'=>$_POST['zipcode'], 'city'=>$_POST['city'], 'region'=>$_POST['state'], 'isp'=>$location['isp'], 'latitude'=>$location['latitude'], 'longitude'=>$location['longitude'])));

					

					

					#Notify user about creation of their account and new password

					if($result && $location_result)

					{

						$_POST['step1email'] = $_POST['emailaddress'];

						$send_result = $this->sysemail->email_form_data(array('fromemail'=>SITE_ADMIN_MAIL), array_merge($_POST, get_confirmation_messages($this, $_POST, 'registration_confirm')));

					}

				}

				

				#Check if the location was created

				if(!empty($result) && $result && $location_result)

				{

					$data['msg'] = "Your location has been updated.<BR><BR>In addition, an account with your emailaddress has been created. Login using the <BR>password sent to your email address.";

					$data['area'] = "show_close_btn";

					

					#login the new user

					$userdata = $this->Query_reader->get_row_as_array('get_user_by_email', array('emailaddress'=>$_POST['emailaddress'], 'isactive'=>'Y'));

					$userdata['userid'] = $userdata['id'];

					$this->user1->populate_user_details(array($userdata));

					

					$this->Users->create_new_trust_record(array('useremail'=>$_POST['emailaddress']));

					

					#Update the location tracker string

					$this->session->set_userdata('resetlocation', 'Y');

				}

				else if(!empty($location_result) && $location_result)

				{

					$data['msg'] = "Your location has been updated.";

					$data['area'] = "show_close_btn";

					#Update the location tracker string

					#$this->session->set_userdata('location_string', get_custom_location($this));

					$this->session->set_userdata('resetlocation', 'Y');

				}

				else if(empty($data['msg']))

				{

					$data['msg'] = "ERROR: Your location could not be updated. Please contact us about this issue.";

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

		$this->load->view('page/update_location', $data);

	}

	

	

	

	#Page to record a news read

	function record_news_read()

	{

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i', 'd'));

		# Pick all assigned data

		$data = assign_to_data($urldata);

		

		if(!empty($data['i']) && !empty($data['s']))

		{

			$result = $this->db->query($this->Query_reader->get_query_by_code('add_read_record', array('readby'=>$data['s'], 'messageid'=>$data['i'])));

		}

		

		if(!empty($result) && $result)

		{

			$data['msg'] = "The notification has been removed.";

		}

		else

		{

			$data['msg'] = "ERROR: The notification could not be <br>removed. Please contact the administrator.";

		}

		

		$data['area'] = "basic_result_notice";

		

		$data = add_msg_if_any($this, $data);

		$this->load->view('incl/addons', $data);

	}

	

	

	

	#Function to select a region

	function select_region()

	{

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i', 'd'));

		# Pick all assigned data

		$data = assign_to_data($urldata);

		#Check if a rule stamp is already set

		if(!empty($data['q']))

		{

			$stamp = decryptValue($data['q']);

		}

		else

		{

			$stamp = strtotime('now');

			#$this->session->set_userdata('rulestamp_'.decryptValue($data['i']), $stamp);

		}

		

		if(!$this->session->userdata('selected_regions_'.$stamp))

		{

			$this->session->set_userdata('selected_regions_'.$stamp, array());

		}

		$region_array = $this->session->userdata('selected_regions_'.$stamp);

		

		#All continents

		if(empty($data['continent']))

		{

			array_push($region_array, "All<>All<>All");

		}

		#All countries of a given continent

		else if(!empty($data['continent']) && empty($data['country']))

		{

			array_push($region_array, restore_bad_chars($data['continent'])."<>All<>All"); 

		}

		#All regions of a given country

		else if(!empty($data['continent']) && !empty($data['country']) && empty($data['state']))

		{

			array_push($region_array, restore_bad_chars($data['continent'])."<>".restore_bad_chars($data['country'])."<>All"); 

			

		}

		#All regions of the state

		else if(!empty($data['continent']) && !empty($data['country']) && !empty($data['state']))

		{

			array_push($region_array, restore_bad_chars($data['continent'])."<>".restore_bad_chars($data['country'])."<>".restore_bad_chars($data['state'])); 

		}

		

		$data['selectedstamp'] = $stamp;

		$data['page_list'] = array_unique($region_array);

		$this->session->set_userdata('selected_regions_'.$stamp, $data['page_list']);

		$data['area'] = "region_list";

		

		$data = add_msg_if_any($this, $data);

		$this->load->view('incl/addons', $data);

	}

	

	

	

	

	

	

	

	#Function to display a page list

	function page_list()

	{

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m', 's'));

		# Pick all assigned data

		$data = assign_to_data($urldata);

			

		$data = paginate_list($this, $data, 'get_page_list',  array('searchstring'=>''));

		$data = add_msg_if_any($this, $data);

		$this->load->view('wiki/page_list_view', $data);

	}

	

	

	

	#Function to create the catpcha word

	function create_captcha()

	{

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m', 's'));

		# Pick all assigned data

		$data = assign_to_data($urldata);

		

		$vals = array(

                    'img_path'   => './images/captcha/',

                    'img_url'    => IMAGE_URL.'captcha/',

					'img_width'	 => 150,

					'img_height' => 50

	                );

	    

		$cap = create_captcha($vals);

	 

	 	$data = array(

	      'captcha_id'    => '',

	      'captcha_time'  => $cap['time'],

	      'ip_address'    => $this->input->ip_address(),

	      'word'          => $cap['word']

       );

 

               		

        $this->db->query($this->Query_reader->get_query_by_code('insert_captcha_record', array('captcha_time'=>$data['captcha_time'], 'ip_address'=>$data['ip_address'], 'word'=>$data['word'])));

	    

		$data['capimage'] = $cap['image'];

		$data['area'] = 'catpcha_image_view';

		

		$data = add_msg_if_any($this, $data);

		$this->load->view('incl/addons', $data);

	}

	

	

	

	#Show this when javascript is not enabled

	function javascript_not_enabled()

	{

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m', 's'));

		# Pick all assigned data

		$data = assign_to_data($urldata);

		

		format_notication("WARNING: Javascript not enabled.<BR><BR><a href='".base_url()."'>&lsaquo;&lsaquo; GO BACK TO HOME</a>");

	}

	

	

	

	#Function to show the terms of use under different parts of the system

	function terms_of_use()

	{

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m', 's'));

		# Pick all assigned data

		$data = assign_to_data($urldata);

		

		$data = add_msg_if_any($this, $data);

		$this->load->view('page/terms_view', $data);

	}

	

	

	

	#Function to view video

	function view_video()

	{

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m', 's'));

		# Pick all assigned data

		$data = assign_to_data($urldata);

		

		

		$data['area'] = "view_video";

		$data = add_msg_if_any($this, $data);

		$this->load->view('incl/addons', $data);

	}

}

?>
<?php 



#**************************************************************************************

# All message functions (sending and receiving) are done here.

#**************************************************************************************



class Messages extends CI_Controller {

	#Constructor to set some default values at class load
	public function __construct()
    {
		   parent::__construct();	

		$this->load->library('form_validation'); 

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

	

	

	#Function to load the message inbox of the current user

	function load_inbox()

	{

		access_control($this);

		

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('s'));

		# Pick all assigned data

		$data = assign_to_data($urldata);

		$data = paginate_list($this, $data, 'get_message_list', array('isactive'=>'Y', 'userid'=>$this->session->userdata('userid'), 'searchstring'=>'' ));

		

		$data = add_msg_if_any($this, $data);

		$this->load->view('messages/inbox_view', $data);

	}

	

	

	#Function to load the message sent list of the current user

	function load_sent()

	{

		access_control($this);

		

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('s'));

		# Pick all assigned data

		$data = assign_to_data($urldata);

		

		if($this->session->userdata('userid'))

		{

			$data = paginate_list($this, $data, 'get_user_sent_messages', array('isactive'=>'Y', 'userid'=>$this->session->userdata('userid')));

		}

		else

		{

			$this->session->set_userdata('xmsg', "WARNING: Your user information could not be resolved.");

			redirect(base_url()."/admin/logout/m/xmsg");

		}

		

		$data = add_msg_if_any($this, $data);

		$this->load->view('messages/sent_view', $data);

	}

	

	

	

	

	

	

	

	#Function to load the archived received messages of the current user

	function load_archive()

	{

		access_control($this);

		

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('s'));

		# Pick all assigned data

		$data = assign_to_data($urldata);

		

		if($this->session->userdata('userid'))

		{

			$data = paginate_list($this, $data, 'get_user_archived_messages', array('userid'=>$this->session->userdata('userid')));

		}

		else

		{

			$this->session->set_userdata('xmsg', "WARNING: Your user information could not be resolved.");

			redirect(base_url()."/admin/logout/m/xmsg");

		}

		

		$data = add_msg_if_any($this, $data);

		$this->load->view('messages/archive_view', $data);

	}

	

	

	

	#Function to edit or view messages

	function load_form()

	{

		access_control($this);

		

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i', 'a'));

		# Pick all assigned data

		$data = assign_to_data($urldata);

		$this->session->set_userdata('local_allowed_extensions', array('.doc','.docx', '.xls', '.xlsx', '.pdf'));

		

		#Eliminate editing messages

		if(!empty($data['i']) && empty($data['a']))

		{

			$data['a'] = encryptValue('view');

		}

		

		#$data['r'] is for replying AND $data['i'] is for view only mode

		if((!empty($data['i']) && !empty($data['a']) && decryptValue($data['a']) == 'view') || !empty($data['r']))

		{

			$readid = (!empty($data['r']))? decryptValue($data['r']): decryptValue($data['i']);

			$data['formdata'] = $this->Query_reader->get_row_as_array('get_message_read_by_id', array('id'=>$readid ));

			#Mark message as read by this user and proceed to show if the message details are found

			if(!empty($data['formdata']))

			{

				#User is just viewing the message

				if(empty($data['r']))

				{

					$data['isview'] = 'Y';

					$result = $this->db->query($this->Query_reader->get_query_by_code('update_message_read_status', array('readip'=>get_ip_address(), 'isread'=>'Y', 'id'=>$readid)));

				}

				#Add a RE: for reply mode

				else

				{

					$data['formdata']['subject'] = (substr($data['formdata']['subject'], 0, 3) != "RE:")? "RE: ".$data['formdata']['subject']: $data['formdata']['subject'];

					$data['formdata']['details'] = "\n\n\n\n\nOn ".date('m/d/Y h:iA', strtotime($data['formdata']['messagedate']))." ".$data['formdata']['sentbydetails']." wrote\n------------------------------------------\n".reduce_string_by_chars($data['formdata']['details'], 500);

					

					$this->session->set_userdata('exclusers', array($data['formdata']['sentby']));

				}

				

				$recipients = $this->db->query($this->Query_reader->get_query_by_code('get_recipients_list', array('msgid'=>$data['formdata']['messageid'])));

				$data['recipients'] = $recipients->result_array();

			}

			else

			{

				$this->session->set_userdata('smsg', "WARNING: The message could not be loaded.");

				redirect(base_url()."messages/load_inbox/m/smsg");

			}

		}

		

		$this->load->view('messages/send_message_view', $data);

	}

	

	

	

	

	#Function to edit or view messages

	function process_message()

	{

		access_control($this);

		

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i', 'a'));

		# Pick all assigned data

		$data = assign_to_data($urldata);

	

		if($this->input->post('sendmessage'))

		{

			$required_fields = array('subject', 'details');

			

			#Include receipient IDs if no overall receipient id is selected

			if(empty($_POST['sendtoall']))

			{

				array_push($required_fields, 'recipientids*CHECKBOXES');

			}

			

			$_POST = clean_form_data($_POST);

			$validation_results = validate_form('', $_POST, $required_fields);

			

			#Only proceed if the validation for required fields passes

			if($validation_results['bool'])

			{ 

				$results = array();

				$recipients = (!empty($_POST['recipientids']))? implode(",", $_POST['recipientids']): "";

				

				#Save the message before sending it out

				$save_result = $this->db->query($this->Query_reader->get_query_by_code('save_new_message', array('subject'=>htmlentities($_POST['subject'], ENT_QUOTES), 'details'=>htmlentities($_POST['details'], ENT_QUOTES), 'sentby'=>$this->session->userdata('userid'), 'sendingip'=>get_ip_address() )));

				$_POST['messageid'] = mysql_insert_id();

				array_push($results, $save_result);

				

				if($save_result)

				{

					if(!empty($_POST['recipientids']))

					{

						#Send the message to each user as given in the list

						$user_emails = $this->Query_reader->get_row_as_array('get_userlist_emails', array('idlist'=>"'".implode("','", $_POST['recipientids'])."'"));

						$_POST['emailaddress'] = $user_emails['emaillist'];

					}

					else 

					{

						$user_emails = $this->Query_reader->get_row_as_array('get_active_user_emails', array('isactive'=>"Y"));

						$_POST['emailaddress'] = $user_emails['emaillist'];

					}

					

					$send_result = $this->sysemail->email_form_data(array('fromemail'=>$this->session->userdata('emailaddress')), get_confirmation_messages($this, array_merge($_POST, array('sendername'=>$this->session->userdata('names')) ), 'send_sys_msg_by_email'));

					array_push($results, $send_result);

					

					#Save the message notice send record for each user

					$email_list = explode(",", $_POST['emailaddress']);

					foreach($email_list AS $email)

					{

						$userdetails = $this->Query_reader->get_row_as_array('get_user_by_email', array('emailaddress'=>$email, 'isactive'=>'Y'));

						array_push($results, $this->db->query($this->Query_reader->get_query_by_code('add_msg_read_record', array('useremail'=>$email, 'messageid'=>$_POST['messageid'], 'userid'=>$userdetails['id']))));

					}

				}

				

				$msg = (get_decision($results))? "The message has been sent.": "WARNING: The message could not be sent.";

				$this->session->unset_userdata(array('exclusers'=>''));

				

				$this->session->set_userdata('mmsg', $msg);

				redirect(base_url()."messages/load_inbox/m/mmsg");

			}

			

			

			

			if((empty($validation_results['bool']) || (!empty($validation_results['bool']) && !$validation_results['bool'])) 

			&& empty($data['msg']) )

			{

				$data['msg'] = "WARNING: The highlighted fields are required.";

			}

			

			$data['requiredfields'] = $validation_results['requiredfields'];

			$data['formdata'] = $_POST;

			

		}

		

		$data = add_msg_if_any($this, $data);

		$this->load->view('messages/send_message_view', $data);

	}	

	

	

	

	

	

	#Add the users to the recipient list

	function pick_receiver()

	{

		access_control($this);

		

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m', 'p'));

		# Pick all assigned data

		$data = assign_to_data($urldata);

		

		#Add new id to list to exclude

		$excl_users = ($this->session->userdata('exclusers'))? $this->session->userdata('exclusers'): array();

		if(!empty($data['i']))

		{

			array_push($excl_users, decryptValue($data['i']));

		}

		$excl_users = array_unique($excl_users);

		$this->session->set_userdata('exclusers', $excl_users);

		

		$page_result = $this->db->query($this->Query_reader->get_query_by_code('get_users_in_list', array('idlist'=>"'".implode("','", $excl_users)."'")));

		$data['page_list'] = $page_result->result_array();

		

		$data['area'] = "selected_receiver_list";

		$data = add_msg_if_any($this, $data);

		$this->load->view('incl/addons', $data);

	}

	

	

	

	

	#Function to remove a user from a list of recipients

	function remove_receiver()

	{

		access_control($this);

		

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m', 'p'));

		# Pick all assigned data

		$data = assign_to_data($urldata);

		

		$excl_users = ($this->session->userdata('exclusers'))? $this->session->userdata('exclusers'): array();

		if(!empty($data['i']))

		{

			unset($excl_users[array_search(decryptValue($data['i']), $excl_users)]);

		}

		$this->session->set_userdata('exclusers', $excl_users);

		$data['msg'] = format_notice("Reciever removed.");

		

		$data['area'] = "remove_receiver_conf";

		$data = add_msg_if_any($this, $data);

		$this->load->view('incl/addons', $data);

		

	}

	

	

	

	

	#Function to deactivate the message view 

	function deactivate_message()

	{

		access_control($this);

		

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m', 'p'));

		# Pick all assigned data

		$data = assign_to_data($urldata);

		

		if(!empty($data['i']))

		{

			$result = $this->db->query($this->Query_reader->get_query_by_code('deactivate_message_view', array('id'=>decryptValue($data['i']) )));

		}

		

		#Send the appropriate message

		$msg = (!empty($result) && $result)? "The message has been removed.": "ERROR: The message could not be removed.";

		$this->session->set_userdata('smsg', $msg);

		redirect(base_url()."messages/load_inbox/m/smsg");

	}

	

	

	

	#Function to remove a read message from the user's view

	function remove_read_message()

	{

		access_control($this);

		

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m', 'p'));

		# Pick all assigned data

		$data = assign_to_data($urldata);

		

		if(!empty($data['i']))

		{

			$result = $this->db->query($this->Query_reader->get_query_by_code('set_read_message_status', array('canshow'=>'N', 'messageid'=>decryptValue($data['i']), 'readby'=>decryptValue($data['u']) )));

		}

		

		#Send the appropriate message

		if(!empty($result) && $result)

		{

			$msg = "The message has been removed.";

		}

		else

		{

			$msg = "ERROR: The message could not be removed.";

		}

		

		$this->session->set_userdata('rmsg', $msg);

		redirect(base_url()."messages/load_archive/m/rmsg");

		

	}

	

}

?>
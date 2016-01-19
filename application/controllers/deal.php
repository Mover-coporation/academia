<?php 



#**************************************************************************************

# All deals go through this controller

#**************************************************************************************



class Deal extends CI_Controller {

	#Constructor to set some default values at class load
	public function __construct()
    {
		   parent::__construct();	

		$this->load->model('sys_email','sysemail');

		date_default_timezone_set(SYS_TIMEZONE);

	}

		

	# Default to nothing

	function index()

	{

		#Do nothing

	}	

	

	#New deal

	function add_deal()

	{

		access_control($this);

		

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));

		# Pick all assigned data

		$data = assign_to_data($urldata);

		

		if(!check_user_access($this,'add_new_deal') && check_user_access($this,'add_new_issue'))

		{

			$data['t'] = encryptValue('issue');

		}

		

		

		if(!empty($data['i']))

		{

			$editid = decryptValue($data['i']);

			$data['formdata'] = $this->Query_reader->get_row_as_array('get_deal_by_id', array('id'=>$editid) );

			$data['formdata']['starthr'] = substr($data['formdata']['starttime'], 0, 2);

			$data['formdata']['startmins'] = substr($data['formdata']['starttime'], 2, 2);

			$data['formdata']['endhr'] = substr($data['formdata']['endtime'], 0, 2);

			$data['formdata']['endmins'] = substr($data['formdata']['endtime'], 2, 2);

			

			$userdetails = $this->Query_reader->get_row_as_array('get_user_by_id', array('id'=>$data['formdata']['generalpartner']));

			$data['formdata']['generalpartnerview'] = (!empty($userdetails))? $userdetails['firstname']." ".$userdetails['lastname']: "";

		}

		

		#Check if the user is simply viewing the deal

		#TODO: Add the force-users-without-other-permissions-to-view condition

		if(!empty($data['a']) && decryptValue($data['a']) == 'view')

		{

			$data['isview'] = "Y";

		}

		

		#Get the document details

		if($this->input->post('savedeal'))

		{

			$required_fields = array('dealtype', 'deskid', 'displaydealtype', 'dealdescription', 'dealamount', 'fundsymbol', 'startdate', 'enddate');

			$_POST = clean_form_data($_POST);

			$validation_results = validate_form('', $_POST, $required_fields);

			$_POST['startdate'] = (empty($_POST['startdate']))? "": date('Y-m-d', strtotime($_POST['startdate']));

			

			$_POST['enddate'] = (empty($_POST['enddate']))? "": date('Y-m-d', strtotime($_POST['enddate']));

			$_POST['keydate'] = (empty($_POST['keydate']))? "": date('Y-m-d', strtotime($_POST['keydate']));

			$_POST['lastrevised'] = (empty($_POST['lastrevised']))? "": date('Y-m-d', strtotime($_POST['lastrevised']));

					

			$_POST['starttime'] = str_pad($_POST['starthr'], 2, "0", STR_PAD_LEFT).str_pad($_POST['startmins'], 2, "0", STR_PAD_LEFT);

			$_POST['endtime'] = str_pad($_POST['endhr'], 2, "0", STR_PAD_LEFT).str_pad($_POST['endmins'], 2, "0", STR_PAD_LEFT);

			$_POST['dealamount'] = removeCommas($_POST['dealamount']);	

				

			#Only proceed if the validation for required fields passes

			if($validation_results['bool'])

			{

				#First remove the document record and file from the system

				if(!empty($data['formdata']) && !empty($data['i']))

				{

					$save_result = $this->db->query($this->Query_reader->get_query_by_code('update_deal', array_merge($_POST, array('editid'=>$editid)) ));

				}

				else

				{

					$save_result = $this->db->query($this->Query_reader->get_query_by_code('save_new_deal', array_merge($_POST, array('createdby'=>$this->session->userdata('userid'))) ));

				}

			 

				if($save_result)

				{

					$dealid = (!empty($editid))? $editid: mysql_insert_id();

					$docs = $this->db->query($this->Query_reader->get_query_by_code('get_deal_documents', array('dealid'=>$dealid)));

					$deal_docs = $docs->result_array();

					

					$data['msg'] = "The deal has been saved.";

					$data['msg'] .= (empty($deal_docs))? "<br><span class='error' style='padding:0px;'>Please add the deal documents before sending invitations.</span>": "";

					$this->session->set_userdata('sres', $data['msg']);

					

					redirect(base_url()."deal/manage_deals/m/sres");

				}

				else

				{

					$data['msg'] = "ERROR: The deal was not saved. Please contact your administrator.";

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

		

		

		

		$this->load->view('deals/new_deal_view', $data);

	}

	

	

	

	

	#Manage Deals

	function manage_deals()

	{

		access_control($this);

		

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));

		# Pick all assigned data

		$data = assign_to_data($urldata);

		

		#Get the paginated list of the deals

		$data = paginate_list($this, $data, 'get_deal_list', array('isactive'=>'Y', 'searchstring'=>''));

		

		$data = add_msg_if_any($this, $data);

		$this->load->view('deals/manage_deals_view', $data);

	}

	

	

	

	#Function to deactivate a deal

	function deactivate_deal()

	{

		access_control($this);

		

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));

		# Pick all assigned data

		$data = assign_to_data($urldata);

		

		if(!empty($data['i']))

		{

			$result = $this->db->query($this->Query_reader->get_query_by_code('deactivate_deal', array('dealid'=>decryptValue($data['i'])) ));

		}

		

		#Prepare appropriate message

		$msg = (!empty($result) && $result)? "The deal has been removed.": "ERROR: The deal could not be removed.";

		$this->session->set_userdata('sres', $msg);

		

		redirect(base_url()."deal/manage_deals/m/sres");

	}

	

	

	

	#Function to send invitations to clients

	function send_invitation()

	{

		access_control($this);

		

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));

		# Pick all assigned data

		$data = assign_to_data($urldata);

		

		if(!empty($data['i']))

		{

			$dealid = decryptValue($data['i']);

		} 

		else if( !empty($_POST['dealid']))

		{

			 $dealid = $_POST['dealid'];

			 $data['i'] = encryptValue($dealid);

		}

		

		if(!empty($data['i']))

		{

			$this->session->set_userdata('selecteddeal', $data['i']);

		} 

		else

		{

			$this->session->unset_userdata(array('selecteddeal'=>''));

		}

		#Remove selected user to enable selecting other users

		$this->session->unset_userdata(array('selecteduser'=>''));

		

		#Update any checked NDAs as checked

		if($this->input->post('updatenda'))

		{

			$nda_array = (!empty($_POST['nda']))? $_POST['nda']: array();

			#First clear all previously checked nda fields

			$result1 = $this->db->query($this->Query_reader->get_query_by_code('disable_invitation_status', array('fieldname'=>'dealid', 'fieldid'=>$dealid) ));

			$result2 = $this->db->query($this->Query_reader->get_query_by_code('update_invitation_status', array('dealid'=>$dealid, 'ndasigned'=>'Y', 'userlist'=>"'".implode("','", $nda_array)."'") ));

			

			$data['msg'] = ($result1 && $result2)? "NDA status has been updated": "ERROR: NDA status could not be updated";

		}

		

		if(!empty($dealid))

		{

			$data['deal_details'] = $this->Query_reader->get_row_as_array('get_deal_by_id', array('id'=>$dealid));

			

			$users = $this->db->query($this->Query_reader->get_query_by_code('get_deal_invitation_users', array('dealid'=>$dealid)));

			$data['page_list'] = $users->result_array();

		}

		

		$data = add_msg_if_any($this, $data);

		$this->load->view('deals/deal_invitation_view', $data);

	}

	

	

	

	

	#Function to select an invitation deal

	function select_invitation_user()

	{

		access_control($this);

		

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));

		# Pick all assigned data

		$data = assign_to_data($urldata);

		

		#Add the user to the list of users in the given deal

		if((!empty($data['i']) || !empty($data['gn'])) && !empty($data['dealid']))

		{

			#Get the users from a group or a single user

			if(!empty($data['gn']))

			{

				$result = $this->db->query($this->Query_reader->get_query_by_code('get_group_by_name', array('groupname'=>decryptValue($data['gn']) )));

				$group_list = $result->result_array();

				$results = array();

				

				#Add users one at a time if they do not already exist

				foreach($group_list AS $row)

				{

					$user_row = $this->Query_reader->get_row_as_array('check_user_invitation', array('userid'=>$row['userid'], 'dealid'=>$data['dealid']));

					if(empty($user_row))

					{

						array_push($results, $this->db->query($this->Query_reader->get_query_by_code('add_user_invitation', array('userid'=>$row['userid'], 'dealid'=>$data['dealid'], 'ndasigned'=>'N', 'issent'=>'N'))));

					}

				}

				

				$result = get_decision($results);

			}

			else 

			{

				$result = $this->db->query($this->Query_reader->get_query_by_code('add_user_invitation', array('userid'=>decryptValue($data['i']), 'dealid'=>$data['dealid'], 'ndasigned'=>'N', 'issent'=>'N')));

			}

		}

		

		if(!empty($data['t']) && decryptValue($data['t']) == 'viewonly')

		{

			$data['dealid'] = decryptValue($data['d']);

		}

		else

		{

			if(!empty($data['gn']))

			{

				$data['msg'] = (!empty($result) && $result)? "User invitations added.": "ERROR: All or some of the user invitations could not be added.";

			}

			else

			{

				$data['msg'] = (!empty($result) && $result)? "User invitation added.": "ERROR: User invitation could not be added.";

			}

		}

		

		#get the required info to properly display the user details

		$data['deal_details'] = $this->Query_reader->get_row_as_array('get_deal_by_id', array('id'=>$data['dealid']));

		$users = $this->db->query($this->Query_reader->get_query_by_code('get_deal_invitation_users', array('dealid'=>$data['dealid'])));

		$data['page_list'] = $users->result_array();

		

		$data['area'] = "selected_invitation_users";

		$this->load->view('incl/addons', $data);

	}

	

	

	

	#Function to remove a user from the invitation list

	function remove_invitation_user()

	{

		access_control($this);

		

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));

		# Pick all assigned data

		$data = assign_to_data($urldata);

		

		#Add the user to the list of users in the given deal

		if(!empty($data['i']) && !empty($data['dealid']))

		{

			$result = $this->db->query($this->Query_reader->get_query_by_code('remove_user_invitation', array('userid'=>decryptValue($data['i']), 'dealid'=>$data['dealid'] )));

		}

		

		$data['msg'] = (!empty($result) && $result)? "User invitation removed.": "ERROR: User invitation could not be removed.";

		#get the required info to properly display the user details

		$data['deal_details'] = $this->Query_reader->get_row_as_array('get_deal_by_id', array('id'=>$data['dealid']));

		$users = $this->db->query($this->Query_reader->get_query_by_code('get_deal_invitation_users', array('dealid'=>$data['dealid'] )));

		$data['page_list'] = $users->result_array();

		

		$data['area'] = "selected_invitation_users";

		$this->load->view('incl/addons', $data);

	}

	

	

	

	#Function to send a deal invitation to a user in the system

	function send_deal_invitation()

	{

		access_control($this);

		

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));

		# Pick all assigned data

		$data = assign_to_data($urldata);

		

		#Invite the user to participate in the deal

		if((!empty($data['i']) && !empty($data['dealid'])) || (!empty($data['u']) && !empty($data['d'])))

		{

			#FROM USER LIST

			if(!empty($data['i']) && !empty($data['dealid']))

			{

				$dealid = $data['dealid'];

				$userid = decryptValue($data['i']);

			}

			#FROM DEAL LIST

			else if(!empty($data['u']) && !empty($data['d']))

			{

				$dealid = decryptValue($data['d']);

				$userid = decryptValue($data['u']);

			}

			

			$deal_details = $this->Query_reader->get_row_as_array('get_deal_by_id', array('id'=>$dealid));

			$user_details = $this->Query_reader->get_row_as_array('get_user_by_id', array('id'=>$userid));

			$inv_details = $this->Query_reader->get_row_as_array('check_user_invitation', array('userid'=>$userid, 'dealid'=>$dealid));

			$invitation_details = array_merge($deal_details, array('firstname'=>$user_details['firstname'], 'userid'=>$user_details['userid'], 'emailaddress'=>$user_details['emailaddress'], 'invitationid'=>$inv_details['id']));

			

			$send_result = $this->sysemail->email_form_data(array('fromemail'=>NOREPLY_EMAIL), 

						get_confirmation_messages($this, $invitation_details, 'deal_invitation'));;

			

			if($send_result)

			{

				$result = $this->db->query($this->Query_reader->get_query_by_code('update_invitation_sent_status', array('issent'=>'Y', 'userid'=>$user_details['userid'], 'dealid'=>$deal_details['id'])));

			}

			else 

			{

				$result = FALSE;

			}

		}

		

		$data['msg'] = (!empty($result) && $result)? "<span class='littlegreentext'>SENT</span>": "<span class='redtext'><b>NOT SENT</b></span>";

		

		$data['area'] = "deal_sent_confirmation";

		$this->load->view('incl/addons', $data);

	}

	

	

	

	

	

	

	

	#Function to send invitations to clients based on the client

	function send_invitation_by_client()

	{

		access_control($this);

		

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));

		# Pick all assigned data

		$data = assign_to_data($urldata);

		

		#Clear id if instructed

		if(!empty($data['a']) && decryptValue($data['a']) == 'clear_id' && $this->session->userdata('selecteduser'))

		{

			$this->session->unset_userdata(array('selecteduser'=>''));

		}

		

		

		if(!empty($data['i']))

		{

			$userid = decryptValue($data['i']);

			$this->session->set_userdata('selecteduser', $data['i']);

		} 

		else if( !empty($_POST['invuserid']))

		{

			$userid = $_POST['invuserid'];

			$data['i'] = encryptValue($userid);

		}

		else if($this->session->userdata('selecteduser'))

		{

			$data['i'] = $this->session->userdata('selecteduser');

			$userid = decryptValue($data['i']);

		}

		

		

		#Update any checked NDAs as checked

		if($this->input->post('updatenda'))

		{

			$nda_array = (!empty($_POST['nda']))? $_POST['nda']: array();

			#First clear all previously checked nda fields

			$result1 = $this->db->query($this->Query_reader->get_query_by_code('disable_invitation_status', array('fieldname'=>'userid', 'fieldid'=>$userid) ));

			$result2 = $this->db->query($this->Query_reader->get_query_by_code('update_user_invitation_status', array('userid'=>$userid, 'ndasigned'=>'Y', 'deallist'=>"'".implode("','", $nda_array)."'") ));

			

			$data['msg'] = ($result1 && $result2)? "NDA status has been updated": "ERROR: NDA status could not be updated";

		}

		

		if(!empty($userid))

		{

			$data['user_details'] = $this->Query_reader->get_row_as_array('get_user_by_id', array('id'=>$userid));

			

			$deals = $this->db->query($this->Query_reader->get_query_by_code('get_user_deal_invitations', array('userid'=>$userid )));

			$data['page_list'] = $deals->result_array();

		}

		

		$data = add_msg_if_any($this, $data);

		$this->load->view('deals/deal_invitation_by_client_view', $data);

	}

	

	

	

	

	

	#Function to add a deal for the user

	function add_deal_to_invitation()

	{

		access_control($this);

		

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));

		# Pick all assigned data

		$data = assign_to_data($urldata);

		

		if(!empty($data['i']) && !empty($data['u']))

		{

			$result = $this->db->query($this->Query_reader->get_query_by_code('add_user_invitation', array('dealid'=>decryptValue($data['i']), 'userid'=>decryptValue($data['u']), 'ndasigned'=>'N', 'issent'=>'N')));

		}

		$data['msg'] = ($result)? "Deal added to invitation list": "ERROR: Deal could not be added to invitation list";

		

		$deals = $this->db->query($this->Query_reader->get_query_by_code('get_user_deal_invitations', array('userid'=>decryptValue($data['u']) )));

		$data['page_list'] = $deals->result_array();

		

		$data['area'] = "invitation_deal_list";

		$this->load->view('incl/addons', $data);

	}

	

	

	

	

	#Function to remove invitation deal

	function remove_invitation_deal()

	{

		access_control($this);

		

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));

		# Pick all assigned data

		$data = assign_to_data($urldata);

		

		#Add the user to the list of users in the given deal

		if(!empty($data['u']) && !empty($data['d']))

		{

			$result = $this->db->query($this->Query_reader->get_query_by_code('remove_user_invitation', array('userid'=>decryptValue($data['u']), 'dealid'=>decryptValue($data['d']) )));

		}

		

		$data['msg'] = (!empty($result) && $result)? "User invitation removed.": "ERROR: User invitation could not be removed.";

		$deals = $this->db->query($this->Query_reader->get_query_by_code('get_user_deal_invitations', array('userid'=>decryptValue($data['u']) )));

		$data['page_list'] = $deals->result_array();

		

		$data['area'] = "invitation_deal_list";

		$this->load->view('incl/addons', $data);

	}

	

	

	

	

	#Function to add documents to a deal 

	function add_documents()

	{

		access_control($this);

		

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));

		# Pick all assigned data

		$data = assign_to_data($urldata);

		

		if(!empty($data['a']) && decryptValue($data['a']) == 'clear_id')

		{

			$this->session->unset_userdata(array('dealdocid'=>''));

		}

		else if(!empty($data['a']) && $data['a'] == 'save' && $this->session->userdata('dealdocid') && !empty($data['sec']))

		{

			$unsaved = $this->db->query($this->Query_reader->get_query_by_code('get_unsaved_documents', array('uploadip'=>get_ip_address() )));

			$unsaveddocs = $unsaved->result_array();

			

			#Unsaved documents

			foreach($unsaveddocs AS $row)

			{

				$new_file_url = 'ny_'.get_deal_id().".".end(explode('.', $row['fileurl']));

				#First move the document to the correct folder and then update the doc record

				if(copy(str_replace("/kunden/", "/", $row['fileurl']), UPLOAD_DIRECTORY."documents/".$new_file_url)) 

				{

    				$result = $this->db->query($this->Query_reader->get_query_by_code('update_unsaved_document', array('fileurl'=>$new_file_url, 'dealid'=>$this->session->userdata('dealdocid'), 'fileunder'=>restore_bad_chars($data['sec']), 'uploadedby'=>$this->session->userdata('userid'), 'docid'=>$row['id'] )));

					if($result)

					{

						@unlink($row['fileurl']);

						$saved = "COMPLETE";

					}

				}

			}

			

			$msg = (!empty($saved) && $saved == "COMPLETE")? "Your documents have been saved. You may edit the document name where necessary.": "ERROR: Your documents could not be saved.";

			$this->session->set_userdata('sdoc', $msg);

			redirect(base_url()."deal/add_documents/m/sdoc");

		}

		

		

		if(!empty($data['i']) || $this->session->userdata('dealdocid'))

		{

			$dealid = (!empty($data['i']))? decryptValue($data['i']) : $this->session->userdata('dealdocid');

			$data['deal_details'] = $this->Query_reader->get_row_as_array('get_deal_by_id', array('id'=>$dealid ));

			

			$documents = $this->db->query($this->Query_reader->get_query_by_code('get_deal_documents', array('dealid'=>$dealid)));

			$data['document_list'] = $documents->result_array();

			

			$subjects = $this->db->query($this->Query_reader->get_query_by_code('get_document_subjects', array('dealid'=>$dealid)));

			$data['subject_list'] = $subjects->result_array();

			

			$this->session->set_userdata('dealdocid', $dealid);

		}

		

		

		$data = add_msg_if_any($this, $data);

		$this->load->view('deals/deal_documents_view', $data);

	}

	

	

	

	

	#Function to remove a document

	function remove_document()

	{

		access_control($this);

		

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));

		# Pick all assigned data

		$data = assign_to_data($urldata);

		

		if(!empty($data['i']))

		{

			$docid = decryptValue($data['i']);

			

			$doc_details = $this->Query_reader->get_row_as_array('get_document_by_id', array('docid'=>$docid));

			if(!empty($doc_details))

			{

				$result = $this->db->query($this->Query_reader->get_query_by_code('delete_deal_document', array('docid'=>$docid )));

				@unlink(UPLOAD_DIRECTORY."documents/".$doc_details['fileurl']);

			}

		}

		

		$msg = (!empty($result) && $result)? "The document has been removed.": "ERROR: Your document could not be removed.";

		$this->session->set_userdata('dmsg', $msg);

		redirect(base_url()."deal/add_documents/i/".$data['md']."/m/dmsg");

	}

	

	

	

	

	#Function to update file name

	function update_filename()

	{

		access_control($this);

		

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));

		# Pick all assigned data

		$data = assign_to_data($urldata);

		$data['docid'] = decryptValue($data['i']);

			

		if(!empty($data['i']) && !empty($data['filename_'.decryptValue($data['i'])]))

		{

			$result = $this->db->query($this->Query_reader->get_query_by_code('update_document_filename', array('docid'=>$data['docid'], 'filename'=>restore_bad_chars($data['filename_'.$data['docid']]) )));

		}

		else 

		{

			$data['action'] = (!empty($data['a']) && decryptValue($data['a']) == 'view')? "isviewing": "isediting";

		}

		

		$data['document_details'] = $this->Query_reader->get_row_as_array('get_document_by_id', array('docid'=>decryptValue($data['i'])));

		

		$data['area'] = "filename_update";

		$this->load->view('incl/addons', $data);

	}

	

	

	

	

	#Function to show the list of user invitations

	function user_invitations_list()

	{

		access_control($this);

		

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));

		# Pick all assigned data

		$data = assign_to_data($urldata);	

	

		if(!empty($data['t']) && decryptValue($data['t']) == 'archive')

		{

			$data['isarchive'] = "Y";

			$isactive = "N";

		}

		else

		{

			$isactive = "Y";

		}

		

		#Get the paginated list of users

		$data = paginate_list($this, $data, 'get_user_invitations_list', array('isactive'=>$isactive, 'userid'=>$this->session->userdata('userid'), 'searchstring'=>""));

        

		 

		$data = add_msg_if_any($this, $data);

		$this->load->view('deals/user_invitations_view', $data);

	

	}

	

	

	

	

	#Function to show the user invitation

	function view_invitation()

	{

		access_control($this);

		

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));

		# Pick all assigned data

		$data = assign_to_data($urldata);	

	

		if(!empty($data['i']))

		{

			$invid = decryptValue($data['i']);

			

			#Update that the user has signed the NDA 

			if(!empty($data['ndasigned']) && $data['ndasigned'] == 'Y')

			{

				$result = $this->db->query($this->Query_reader->get_query_by_code('update_ndasigned_by_id', array('invid'=>$invid, 'ndasigned'=>'Y')));

			}

			

			#Update that the user has read the invitation 

			if(!empty($data['a']) && decryptValue($data['a']) == 'isread')

			{

				$result = $this->db->query($this->Query_reader->get_query_by_code('update_invitation_isread', array('invid'=>$invid, 'isread'=>'Y')));

			}

			

			$data['invdetails'] = $this->Query_reader->get_row_as_array('get_detailed_invitation_by_id', array('invid'=>$invid ));

			

			#Get the NDA list

			$ndadocuments = $this->db->query($this->Query_reader->get_query_by_code('get_deal_documents_by_subject', array('dealid'=>$data['invdetails']['dealid'], 'subject'=>"Non-Disclosure Agreement")));  

			

			$data['nda_document_list'] = $ndadocuments->result_array(); 

			

			

			#If the user wants to view the deal details 

			#and the deal details are available in the database

			#and the NDA has been signed if required

			#Or the NDA has/has not been signed if not required

			#Then proceed to pick the rest of the deal details

			if(((!empty($data['sa']) && decryptValue($data['sa']) == 'submitinv') || $data['invdetails']['ndasigned'] == 'Y')

				&& !empty($data['invdetails']) 

				&& (($data['invdetails']['ndasigned'] == 'Y' && $data['invdetails']['needsnda'] == 'Y') 

						|| 

					(($data['invdetails']['ndasigned'] == 'N' || $data['invdetails']['ndasigned'] == 'Y') && $data['invdetails']['needsnda'] == 'N')

					)

			)

			{

				$documents = $this->db->query($this->Query_reader->get_query_by_code('get_deal_documents', array('dealid'=>$data['invdetails']['dealid'])));

				$data['document_list'] = $documents->result_array();

			

				$subjects = $this->db->query($this->Query_reader->get_query_by_code('get_document_subjects', array('dealid'=>$data['invdetails']['dealid'])));

				$data['subject_list'] = $subjects->result_array();

				$data['show_details'] = "Y";

			}

		}

		

		

		#The invitation details can not be resolved

		if(empty($data['invdetails']))

		{

			$this->session->set_userdata('minv', "ERROR: The invitation details can not be resolved.");

			redirect(base_url().'admin/load_dashboard/m/minv');

		}

	

		$data = add_msg_if_any($this, $data);

		$this->load->view('deals/invitation_view', $data);

	}

	

	

	

	

	

	

	#Function to enable making a single order 

	function add_single_order()

	{

		access_control($this);

		

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));

		# Pick all assigned data

		$data = assign_to_data($urldata);	

		

		if(!empty($data['i']))

		{

			$editid = decryptValue($data['i']);

			$data['formdata'] = $this->Query_reader->get_row_as_array('get_order_by_id', array('id'=>$editid ));

			if($data['formdata']['marketprice'] == 'CURRENT_PRICE')

			{

				$data['formdata']['price'] = 'CURRENT_PRICE';

			}

			else if(!empty($data['formdata']['percnavprice']))

			{

				$data['formdata']['price'] = 'PERCNAV';

			}

			else if(!empty($data['formdata']['dollaramountprice']))

			{

				$data['formdata']['price'] = 'DOLLARAMOUNT';

			}

			

			

			

			if(!empty($data['a']) && decryptValue($data['a']) == 'view')

			{

				$data['isview'] = 'Y';

			}

		}

		

		if(!empty($data['d']))

		{

			$data['dealdetails'] = $this->Query_reader->get_row_as_array('get_deal_by_id', array('id'=>decryptValue($data['d']) ));

		}

		

		#Edit order

		if($this->input->post('editorder'))

		{

			$data['formdata'] = $this->session->userdata('formdata');

		}

		

		#Preview order

		if($this->input->post('previeworder'))

		{

			$required_fields = array('accountnumber', 'ordertype', 'fundsymbol', 'orderaction', 'commitmentamount', 'fundedamount', 'price', 'period');

			$_POST = clean_form_data($_POST);

			$validation_results = validate_form('', $_POST, $required_fields);

			#Only proceed if the validation for required fields passes

			if($validation_results['bool'])

			{

				$this->session->set_userdata('formdata', $_POST);

			

				$data['isview'] = "Y";

				$data['ispreview'] = "Y";

			} #VALIDATION end

			

			

			if((empty($validation_results['bool']) || (!empty($validation_results['bool']) && !$validation_results['bool'])) 

			&& empty($data['msg']) )

			{

				$data['msg'] = "WARNING: The highlighted fields are required.";

			}

			

			$data['requiredfields'] = $validation_results['requiredfields'];

			$data['formdata'] = $_POST;

			

		}

		

		#Save order

		if($this->input->post('saveorder'))

		{

			$_POST = $this->session->userdata('formdata');

			

			$_POST['fundinfodate'] = (empty($_POST['fundinfodate']))? "": date('Y-m-d', strtotime($_POST['fundinfodate']));

			$_POST['capitalcalldate'] = (empty($_POST['capitalcalldate']))? "": date('Y-m-d', strtotime($_POST['capitalcalldate']));

			

			$_POST['capitalcalldue'] = removeCommas($_POST['capitalcalldue']);

			$_POST['minqtyamount'] = removeCommas($_POST['minqtyamount']);

			$_POST['commitmentamount'] = removeCommas($_POST['commitmentamount']);

			$_POST['fundedamount'] = removeCommas($_POST['fundedamount']);

			$_POST['unfundedamount'] = $_POST['commitmentamount'] - $_POST['fundedamount'];

			$_POST['netassetvalue'] = $_POST['fundedamount'];

			

			

			#Determine where to save the price

			if($_POST['price'] == 'CURRENT_PRICE')

			{

				$_POST['marketprice'] = 'CURRENT_PRICE';

				$_POST['percnavprice'] = $_POST['dollaramountprice'] = '';

			}

			else if($_POST['price'] == 'PERCNAV')

			{

				$_POST['marketprice'] = $_POST['dollaramountprice'] = '';

			}

			else if($_POST['price'] == 'DOLLARAMOUNT')

			{

				$_POST['marketprice'] = $_POST['percnavprice'] = '';

			}

				

			$_POST['period'] = ($_POST['period'] == 'OTHER')? $_POST['otherperiod']: $_POST['period'];

				

			#First remove the document record and file from the system

			if(!empty($data['formdata']) && !empty($data['i']))

			{

				$save_result = $this->db->query($this->Query_reader->get_query_by_code('update_deal_order', array_merge($_POST, array('editid'=>$editid)) ));

			}

			else

			{

				$_POST['orderedby'] = $this->session->userdata('userid');

				$save_result = $this->db->query($this->Query_reader->get_query_by_code('save_deal_order', $_POST ));

			}

			 	

			$msg = ($save_result)? "The order has been saved.": "ERROR: The order was not saved.";

			$this->session->set_userdata('sres', $msg);

			

			$type_str = ($_POST['ordertype'] == 'indication_only')? "/t/".encryptValue('indication_only'): "";

			redirect(base_url()."deal/manage_orders".$type_str."/m/sres");

		}

		

		$data = add_msg_if_any($this, $data);

		$this->load->view('deals/single_order_view', $data);

	}

	

	

	

	

	

	

	#Function to manage orders

	function manage_orders()

	{

		access_control($this);

		

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));

		# Pick all assigned data

		$data = assign_to_data($urldata);	

		

		#Get the paginated list of the orders

		if(!empty($data['t']) && decryptValue($data['t']) == 'indication_only')

		{

			$data = paginate_list($this, $data, 'get_order_list', array('isactive'=>'Y', 'ordertypes'=>"'indication_only'", 'userid'=>$this->session->userdata('userid'), 'searchstring'=>" AND orderstatus IN ('open', 'processing', 'closed') "));

			

			$data['indication_only'] = "Y";

		}

		else

		{

			$data = paginate_list($this, $data, 'get_order_list', array('isactive'=>'Y', 'ordertypes'=>"'firm'", 'userid'=>$this->session->userdata('userid'), 'searchstring'=>" AND orderstatus IN ('open', 'processing', 'closed') "));

		}

		

		$data = add_msg_if_any($this, $data);

		$this->load->view('deals/manage_orders_view', $data);

	}

	

	

	

	

	#Function to deactivate orders

	function deactivate_order()

	{

		access_control($this);

		

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));

		# Pick all assigned data

		$data = assign_to_data($urldata);	

		

		if(!empty($data['i']))

		{

			$del_result = $this->db->query($this->Query_reader->get_query_by_code('deactivate_order_ticket', array('id'=>decryptValue($data['i']) )));

		}

		

		$msg = (!empty($del_result) && $del_result)? "The order has been cancelled.": "ERROR: The order was not cancelled.";

		$this->session->set_userdata('sres', $msg);

		

		$type_str = (!empty($data['t']) && decryptValue($data['t']) == 'indication_only')? "/t/".encryptValue('indication_only'): "";

		redirect(base_url()."deal/manage_orders".$type_str."/m/sres");

	}

	

	

	

	

	

	#function to add a fund

	function add_a_fund()

	{

		access_control($this);

		

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));

		# Pick all assigned data

		$data = assign_to_data($urldata);	

		

		if(!empty($data['i']))

		{

			$editid = decryptValue($data['i']);

			$data['formdata'] = $this->Query_reader->get_row_as_array('get_fund_request_by_id', array('id'=>$editid) );

			

			$data['isview'] = (!empty($data['a']) && decryptValue($data['a']) == 'view')? "Y": "";

			#Mark that the admin has read the suggestion when they view it

			if($this->session->userdata('isadmin') == 'Y')

			{

				$sresult = $this->db->query($this->Query_reader->get_query_by_code('update_fund_suggestion_isread', array('isread'=>'Y', 'id'=>$editid )));

			}

		}

		

		

		#Save fund request information

		if($this->input->post('savefund'))

		{

			$required_fields = array('fundsymbol','funddescription');

			$_POST = clean_form_data($_POST);

			$validation_results = validate_form('', $_POST, $required_fields);

			

			

			#Only proceed if the validation for required fields passes

			if($validation_results['bool'])

			{

				$_POST['emailwhenadded'] = (!empty($_POST['emailwhenadded']))? 'Y': 'N';

				if(!empty($data['formdata']))

				{

					$save_result = $this->db->query($this->Query_reader->get_query_by_code('update_fund_request', array_merge($_POST, array('editid'=>$editid)) ));

				}

				else

				{

					$_POST['requestedby'] = $this->session->userdata('userid');

					$save_result = $this->db->query($this->Query_reader->get_query_by_code('save_fund_request', $_POST ));

				}

				

				$msg = ($save_result)? "The fund request has been saved.": "ERROR: The fund request was not saved.";

				$this->session->set_userdata('sres', $msg);

				redirect(base_url()."deal/manage_fund_requests/m/sres");

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

		$this->load->view('deals/add_fund_suggestion_view', $data);

	}

	

	

	

	

	

	

	#Function to manage fund requests

	function manage_fund_requests()

	{

		access_control($this);

		

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));

		# Pick all assigned data

		$data = assign_to_data($urldata);	

		

		$data = paginate_list($this, $data, 'get_fund_request_list', array('isactive'=>'Y', 'searchstring'=>" AND requestedby='".$this->session->userdata('userid')."' "));

		

		$data = add_msg_if_any($this, $data);

		$this->load->view('deals/fund_requests_view', $data);

	}

	

	

	

	

	#Function to remove fund request

	function remove_fund_request()

	{

		access_control($this);

		

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));

		# Pick all assigned data

		$data = assign_to_data($urldata);	

		

		if(!empty($data['i']))

		{

			$save_result = $this->db->query($this->Query_reader->get_query_by_code('delete_fund_request', array('id'=>decryptValue($data['i']) ) )); 

		}

		

		$msg = (!empty($save_result) && $save_result)? "The fund request has been removed.": "ERROR: The fund request was not removed.";

		$this->session->set_userdata('sres', $msg);

		redirect(base_url()."deal/manage_fund_requests/m/sres");

	}

	

	

	

	

	

	

	#Function to new portfolio order

	function new_portfolio_order()

	{

		access_control($this);

		

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));

		# Pick all assigned data

		$data = assign_to_data($urldata);	

		

		if(!empty($data['i']))

		{

			$editid = decryptValue($data['i']);

			$portfolio_list = $this->db->query($this->Query_reader->get_query_by_code('get_portfolio_by_account', array('accountnumber'=>$editid, 'searchstring'=>" AND orderstatus IN ('open', 'processing', 'closed') ")));

			$data['page_list'] = $portfolio_list->result_array();

			$data['formdata']['portfolioname'] = (!empty($data['page_list'][0]['portfolioname']))? $data['page_list'][0]['portfolioname']: "";

			$data['formdata']['accountnumber'] = (!empty($data['page_list'][0]['accountnumber']))? $data['page_list'][0]['accountnumber']: "";

			$data['isview'] = (!empty($data['a']) && decryptValue($data['a']) == 'view')? "Y": "";

		}

		

		

		$data = add_msg_if_any($this, $data);

		$this->load->view('deals/add_portfolio_view', $data);

	}

	

	

	

	

	

	

	#Function to add a deal based on the values passed through the JS

	function add_order_by_js()

	{

		access_control($this);

		

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));

		# Pick all assigned data

		$data = assign_to_data($urldata);	

		

		if(!empty($data['accountnumber']) && !empty($data['cmtamount']))

		{

			$data = restore_bad_chars_in_array($data);

			$data['orderstamp'] = get_deal_id('order');

			$data['fundinfodate'] = date('Y-m-d', strtotime('now'));

			$data['capitalcalldate'] = '0000-00-00';

			$data['capitalcalldue'] = $data['minqtyamount'] = '';

			$data['fillcondition'] = 'all_or_none';

			$data['commitmentamount'] = removeCommas($data['cmtamount']);

			$data['fundedamount'] = $data['netassetvalue'] = removeCommas($data['fundedamount']);

			$data['unfundedamount'] = $data['commitmentamount'] - $data['fundedamount'];

			

			#Determine where to save the price

			if(!empty($data['price']) && $data['price'] == 'market')

			{

				$data['marketprice'] = 'CURRENT_PRICE';

				$data['percnavprice'] = $data['dollaramountprice'] = '';

			}

			else if($data['price'] == 'perc_nav')

			{

				$data['marketprice'] = $data['dollaramountprice'] = '';

				$data['percnavprice'] = removeCommas($data['pricemore']);

			}

			else if($data['price'] == 'dollar_amt')

			{

				$data['marketprice'] = $data['percnavprice'] = '';

				$data['dollaramountprice'] = removeCommas($data['pricemore']);

			}

				

			$data['period'] = ($data['period'] == 'other')? $data['periodmore']: $data['period'];

			$data['orderedby'] = $this->session->userdata('userid');

			

			#orderstamp, accountnumber, orderedby, ordertype, fundsymbol, orderaction, commitmentamount, unfundedamount, fundedamount, netassetvalue, marketprice, percnavprice, dollaramountprice, period, fundinfodate, capitalcalldue, capitalcalldate, fillcondition, minqtyamount, dealid

			$result1 = $this->db->query($this->Query_reader->get_query_by_code('save_deal_order', $data ));

			#Update portfolio name if changed

			if(!empty($data['portfolioname']))

			{

				$result2 = $this->db->query($this->Query_reader->get_query_by_code('update_portfolio_name', array('portfolioname'=>restore_bad_chars($data['portfolioname']), 'accountnumber'=>restore_bad_chars($data['accountnumber']), 'orderedby'=>$this->session->userdata('userid') ) ));

			}

			else

			{

				$result2 = true;

			}

			$save_result = get_decision(array($result1, $result2));

		}

		

		$data['msg'] = (!empty($save_result) && $save_result)? "The order ticket has been added.": "ERROR: The order ticket has not been added.";

		

		$portfolio_list = $this->db->query($this->Query_reader->get_query_by_code('get_portfolio_by_account', array('accountnumber'=>$data['accountnumber'], 'searchstring'=>" AND orderstatus IN ('open', 'processing', 'closed') ")));

		$data['page_list'] = $portfolio_list->result_array();

		

		$data['area'] = "portfolio_order_tickets";

		$data = add_msg_if_any($this, $data);

		$this->load->view('incl/addons', $data);

	}

	

	

	

	

	#function to remove an order ticket

	function remove_order_ticket()

	{

		access_control($this);

		

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));

		# Pick all assigned data

		$data = assign_to_data($urldata);	

		

		

		if(!empty($data['i']) && !empty($data['d']))

		{

			$result = $this->db->query($this->Query_reader->get_query_by_code('delete_order_ticket', array('id'=>decryptValue($data['i']) )));

		}

		

		$data['msg'] = (!empty($result) && $result)? "The order ticket has been removed.": "ERROR: The order ticket was not removed.";

		

		$portfolio_list = $this->db->query($this->Query_reader->get_query_by_code('get_portfolio_by_account', array('accountnumber'=>decryptValue($data['d']), 'searchstring'=>" AND orderstatus IN ('open', 'processing', 'closed') ")));

		$data['page_list'] = $portfolio_list->result_array();

		

		$data['area'] = "portfolio_order_tickets";

		$data = add_msg_if_any($this, $data);

		$this->load->view('incl/addons', $data);

	}

	

	

	

	

	

	#Function to view the portfolio list

	function portfolio_list()

	{

		access_control($this);

		

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));

		# Pick all assigned data

		$data = assign_to_data($urldata);	

		

		$data = paginate_list($this, $data, 'get_portfolio_list', array('userid'=>$this->session->userdata('userid'), 'searchstring'=>''));

		

		$data = add_msg_if_any($this, $data);

		$this->load->view('deals/portfolio_list_view', $data);

	}

	

	

	

	

	#Function to let the user view the deal details while coming from an external source

	function user_view_deal_details()

	{

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));

		# Pick all assigned data

		$data = assign_to_data($urldata);	

		

		#The URL to forward to when the user is logged in

		$this->session->set_userdata('fwdurl', get_current_page_url());

		if($this->session->userdata('userid'))

		{

			if(!empty($data['d']))

			{

				redirect(base_url().'deal/view_invitation/i/'.$data['d'].'/a/'.encryptValue('isread'));

			}

			#Redirect to the dashboard if the deal id is not given

			else

			{

				$this->session->set_userdata('lmsg', 'ERROR: The deal invitation could not be resolved.');

				redirect(base_url().'admin/load_dashboard/m/lmsg');

			}

		}

		else

		{

			$this->session->set_userdata('lmsg', 'Please login to continue.');

			redirect(base_url().'admin/login/m/lmsg');

		}

	}

	

	

	

	

	

	#Function to get the invitation response

	function get_invitation_response()

	{

		access_control($this, array('admin'));

		

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));

		# Pick all assigned data

		$data = assign_to_data($urldata);	

		

		

		$data = paginate_list($this, $data, 'get_inv_response_list', array('isactive'=>'Y', 'searchstring'=>''));

		

		$data = add_msg_if_any($this, $data);

		$this->load->view('deals/invitation_response_view', $data);

	}

	

	

	

	

	#Function to view orders based on the invitation

	function view_orders_on_invitation()

	{

		access_control($this, array('admin'));

		

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));

		# Pick all assigned data

		$data = assign_to_data($urldata);	

		

		$orders_list = $this->db->query($this->Query_reader->get_query_by_code('get_invitation_orders', array('invid'=>decryptValue($data['i']) )));

		$data['page_list'] = $orders_list->result_array();

		

		$data = add_msg_if_any($this, $data);

		$this->load->view('deals/invitation_orders_view', $data);

	}

	

	

	

	#Function to show the NAV details

	function show_nav_details()

	{

		access_control($this);

		

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));

		# Pick all assigned data

		$data = assign_to_data($urldata);	

		

		if(!empty($data['fundedamount']) && !empty($data['commitmentamount']))

		{

			$fundedamount = removeCommas(restore_bad_chars($data['fundedamount']));

			$commitmentamount = removeCommas(restore_bad_chars($data['commitmentamount']));

			$fundedamt = (!empty($fundedamount))? $fundedamount: 0;

			$commitmentamt = (!empty($commitmentamount))? $commitmentamount: 0;

		}

		

		if(!empty($fundedamt) && !empty($commitmentamt))

		{

			$data['unfunded'] = $commitmentamt - $fundedamt;

		}

		

		$data['area'] = "nav_amt_details";

		$data = add_msg_if_any($this, $data);

		$this->load->view('incl/addons', $data);

	}

}

?>
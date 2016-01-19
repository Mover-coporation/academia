<?php 



#**************************************************************************************

# All system help

#**************************************************************************************



class Help extends CI_Controller {

	#Constructor to set some default values at class load
	public function __construct()
    {
		   parent::__construct();	

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

	

	

	

	#Function to view a help topic

	function view_help_topic()

	{

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('s', 'i'));

		# Pick all assigned data

		$data = restore_bad_chars_in_array(assign_to_data($urldata));

		

		#Only do this if the issue id is recognized

		if(!empty($data['i']))

		{

			$result = $this->db->query($this->Query_reader->get_query_by_code('view_help_topic', array('topiccode'=>decryptValue($data['i']) )));

			$data['page_list'] = $result->result_array();

		}

		

		if(empty($data['page_list']))

		{

			$data['page_list'] = array();

		}

		

		$data['area'] = "view_help_details";

		$this->load->view('incl/addons', $data);

	}

	

	

	

	#Function to add a help topic

	function add_help_topic()

	{

		access_control($this);

		

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('s', 'i'));

		# Pick all assigned data

		$data = restore_bad_chars_in_array(assign_to_data($urldata));

		$data['docexts'] = array('.doc','.docx', '.pdf', '.ppt', '.pptx');

		$data['imageexts'] = array('.gif', '.jpeg', '.jpg', '.tiff', '.png');

		$data['videoexts'] = array('.swf'); 

		$this->session->set_userdata('local_allowed_extensions', array_merge($data['docexts'], $data['imageexts'], $data['videoexts']));

		

		if(!empty($data['i']))

		{

			$topic_list = $this->db->query($this->Query_reader->get_query_by_code('view_help_topic', array('topiccode'=>decryptValue($data['i']) )));

			$data['page_list'] = $topic_list->result_array();

			

			if(!empty($data['page_list'][0]))

			{

				$data['formdata']['helptopic'] = $data['page_list'][0]['helptopic'];

				$data['formdata']['topiccode'] = $data['page_list'][0]['topiccode'];

			}

		}

		

		$topics = $this->db->query("SELECT * FROM help");

		$topics_list = $topics->result_array();

		foreach($topics_list AS $row)

		{

			$result = $this->db->query("UPDATE help SET helptopic='".ucwords(str_replace('_', ' ', $row['topiccode']))."' WHERE id='".$row['id']."'");

		}

		

		

		

		#The button has been clicked to update the order of the items

		if($this->input->post('save'))

		{

			if(!empty($_POST['helpitem']))

			{

				$results_array = array();

				$order = 1;

				foreach($_POST['helpitem'] AS $itemid)

				{

					array_push($results_array, $this->db->query($this->Query_reader->get_query_by_code('update_help_order', array('id'=>$itemid, 'helporder'=>$order))));

					

					$order++;

				}

				$result = get_decision($results_array);

			}

			

			$msg = (!empty($result) && $result)? "The help content order has been updated.": "ERROR: The help content order could not be updated.";

			$this->session->set_userdata('hmsg', $msg);

			

			$id_string = (!empty($data['i']))? "/i/".$data['i']: "";

			redirect(base_url()."help/add_help_topic".$id_string."/m/hmsg");

		}

		

		

		

		

		#The button has been clicked to add a new help content item

		if($this->input->post('addhelp'))

		{

			$_POST['fileurl'] = !empty($_FILES['fileurl']['name'])? $this->sysfile->local_file_upload($_FILES['fileurl'], 'Upload_'.strtotime('now'), 'documents', 'filename'): '';

			

			$required_fields = array('helptopic');

			if(empty($_POST['details']) && empty($_POST['helplink']) && empty($_POST['fileurl']))

			{

				array_push($required_fields, 'details');

			}

			#Make a new topic code if this is the first help item

			$_POST['topiccode'] = (empty($_POST['topiccode']))? str_replace(" ", "_", strtolower($_POST['helptopic'])): $_POST['topiccode']; 

			

			$_POST = clean_form_data($_POST);

			$validation_results = validate_form('', $_POST, $required_fields);

			 

			#Only proceed if the validation for required fields passes

			if($validation_results['bool'])

			{

				$_POST['helporder'] = count($_POST['helpitem'])+1;

				$result = $this->db->query($this->Query_reader->get_query_by_code('add_help_item', array_merge($_POST, array('details'=>htmlentities($_POST['details'], ENT_QUOTES))) ));  

				

				$msg = ($result)? "The help item has been added.": "ERROR: The help item could not be added.";

				$this->session->set_userdata('hmsg', $msg);

				

				$id_string = (!empty($data['i']))? "/i/".$data['i']: "";

				redirect(base_url()."help/add_help_topic".$id_string."/m/hmsg");

			} #VALIDATION end

			

			

			if((empty($validation_results['bool']) || (!empty($validation_results['bool']) && !$validation_results['bool'])) 

			&& empty($data['msg']) )

			{

				$data['msg'] = "WARNING: The highlighted fields are required.";

			}

		}

		

		$data = add_msg_if_any($this, $data);

		$this->load->view('help/add_help_view', $data);

	}

	

	

	

	#Function to remove the help item

	function remove_help_item()

	{

		access_control($this);

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('s', 'i'));

		# Pick all assigned data

		$data = restore_bad_chars_in_array(assign_to_data($urldata));

		

		if(!empty($data['i']))

		{

			$del_result = $this->db->query($this->Query_reader->get_query_by_code('remove_help_item', array('id'=>decryptValue($data['i']) )));

		}

		$t_string = (!empty($data['t']))? "/i/".$data['t']: "";

		

		$msg = (!empty($del_result) && $del_result)? "The help item has been removed.": "ERROR: The help item was not removed.";

		$this->session->set_userdata('sres', $msg);

		redirect(base_url()."help/add_help_topic".$t_string."/m/sres");

	}

	

	

	

	#Function to manage help items

	function manage_help()

	{

		access_control($this);

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('s', 'i'));

		# Pick all assigned data

		$data = restore_bad_chars_in_array(assign_to_data($urldata));

		

		#Get the paginated list of the help items

		$data = paginate_list($this, $data, 'get_help_list', array('searchstring'=>''));

		

		$data = add_msg_if_any($this, $data);

		$this->load->view('help/manage_help_view', $data);

	}

	

	

}

?>
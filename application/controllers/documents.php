<?php 



#*********************************************************************************

# All website pages are directed from in this controller

#*********************************************************************************



class Documents extends CI_Controller {

	#Constructor to set some default values at class load
	public function __construct()
    {
		   parent::__construct();	

		$this->load->library('form_validation'); 

		$this->load->model('users','user1');

		$this->load->model('file_upload','libfileobj');

		$this->load->model('sys_file','sysfile');

			

		date_default_timezone_set(SYS_TIMEZONE);

	}

	

	

	

	# Default to nothing

	function index()

	{

		#Do nothing

	}

	

	

	#Add document

	function add_document()

	{

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));

		# Pick all assigned data

		$data = assign_to_data($urldata);

		$this->session->set_userdata('local_allowed_extensions', array('.doc','.docx', '.pdf', '.ppt', '.pptx'));

		

		

		if(!empty($data['i']))

		{

			$_POST['editid'] = decryptValue($data['i']);

		}

		

		if($this->input->post('editid')){

			$data['formdata'] = $this->Query_reader->get_row_as_array('get_document_by_id', array('id'=>$_POST['editid']) );

		}

		

		#Get the document details

		if($this->input->post('adddocument'))

		{

			

			$_POST['documenturl'] = !empty($_FILES['documenturlupload']['name'])? $this->sysfile->local_file_upload($_FILES['documenturlupload'], 'Upload_'.strtotime('now'), 'documents', 'filename'): '';

			

			$required_fields = array('documentname', 'description', 'section');

			if(!$this->input->post('editid')){

				array_push($required_fields, 'documenturl');

			}

			

			$_POST = clean_form_data($_POST);

			$validation_results = validate_form('', $_POST, $required_fields);

			

			#Only proceed if the validation for required fields passes

			if($validation_results['bool'])

			{

				#First remove the document record and file from the system

				if(!empty($data['formdata']) && $this->input->post('editid')){

					if(!empty($data['formdata']['documenturl']) && !empty($_POST['documenturl'])){

						@unlink(UPLOAD_DIRECTORY."documents/".$data['formdata']['documenturl']);

					}

					#Only update the document if the user uploaded a new document

					if(!empty($_POST['documenturl'])){

						$_POST['urlscript'] = ", documenturl='".$_POST['documenturl']."'";

					}else{

						$_POST['urlscript'] = "";

					}

					$save_result = $this->db->query($this->Query_reader->get_query_by_code('update_document', $_POST));

				}

				else

				{

					$save_result = $this->db->query($this->Query_reader->get_query_by_code('save_new_document', $_POST));

				}

			 

				if($save_result){

					$data['msg'] = "The document has been saved.";

					$this->session->set_userdata('sres', $data['msg']);

		

					redirect(base_url()."documents/manage_documents/m/sres");

				}

				else

				{

					$data['msg'] = "ERROR: The document was not saved. Please contact your administrator.";

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

		

		#Get tabs and active links if given

		$data = get_tab_data_if_any($data);

		$this->load->view('documents/add_document_view', $data);

		

	}

	

	

	#Function to download documents

	function download_documents()

	{

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m', 'a'));

		# Pick all assigned data

		$data = assign_to_data($urldata);

		

		$documents = $this->db->query($this->Query_reader->get_query_by_code('get_documents_list', array('sections'=>"'library'", 'limittext'=>'')));

		$data['page_list'] = $documents->result_array();

		

		#Get tabs and active links if given

		$data = get_tab_data_if_any($data);

		$this->load->view('documents/download_documents_view', $data);

	}

	

	

	

	#Function to download ebooks

	function ebooks()

	{

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m', 'a'));

		# Pick all assigned data

		$data = assign_to_data($urldata);

		

		$documents = $this->db->query($this->Query_reader->get_query_by_code('get_documents_list', array('sections'=>"'ebook'", 'limittext'=>'')));

		$data['page_list'] = $documents->result_array();

		

		#Get tabs and active links if given

		$data = get_tab_data_if_any($data);

		$this->load->view('documents/ebooks_view', $data);

	}

	

	

	

	#Function to show links to existing files for an employee

	function manage_documents()

	{

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m', 'a'));

		# Pick all assigned data

		$data = assign_to_data($urldata);

		

		$section_result = $this->db->query($this->Query_reader->get_query_by_code('get_document_sections', array()));

		$sections = array();

		foreach($section_result->result_array() AS $row){

			array_push($sections, $row['value']);

		}

		

		$data = paginate_list($this, $data, 'get_documents_list', array('sections'=>"'".implode("','", $sections)."'" ));

		

		$data = add_msg_if_any($this, $data);

		$this->load->view('documents/documents_list_view', $data);

	}

	

	

	

	

	

	#Function to show links to existing files for an employee

	function delete_document()

	{

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('i', 'm'));

		# Pick all assigned data

		$data = assign_to_data($urldata);

		

		if(!empty($data['i'])){

			$document = $this->Query_reader->get_row_as_array('get_document_by_id', array('id'=>decryptValue($data['i'])) );

			$result = $this->db->query($this->Query_reader->get_query_by_code('delete_document', array('id'=>decryptValue($data['i'])) ));

			

			if($result){

				@unlink(UPLOAD_DIRECTORY."documents/".$document['documenturl']);

				

				$msg = "Document was deleted.";

			}

		}

		

		if(empty($result) || (!empty($result) && !$result)){

			$msg = "ERROR: Document was not deleted. Please contact your administrator.";

		}

		

		$this->session->set_userdata('dres', $msg);

		

		redirect(base_url()."documents/manage_documents/m/dres");

	}

	

	

	#Function to force download of file

	function force_download()

	{

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('i', 'f'));

		# Pick all assigned data

		$data = assign_to_data($urldata);

		

		if(!empty($data['f'])){

			$folder = decryptValue($data['f']);

		} else {

			$folder = "documents";

		}

		

		if(!empty($data['i'])){

			$document = $this->Query_reader->get_row_as_array('get_document_by_id', array('id'=>decryptValue($data['i'])) );

		} else {

			$document['documenturl'] = decryptValue($data['u']);

		}

		

		#only proceed if the file exists

		if(file_exists(UPLOAD_DIRECTORY.$folder."/".$document['documenturl']))

		{

			if(strtolower(strrchr($document['documenturl'],".")) == '.pdf')

			{

				header('Content-disposition: attachment; filename="'.$document['documenturl'].'"');

				header('Content-type: application/pdf');

				readfile(UPLOAD_DIRECTORY.$folder."/".$document['documenturl']);

			}

			if(strtolower(strrchr($document['documenturl'],".")) == '.pdf')

			{

				header('Expires: 0');

				header('Cache-Control: must-revalidate, post-check=0, pre-check=0');

				header('Pragma: public');

				header('Content-Description: File Transfer');

				header('Content-Disposition: attachment; filename="671fb8f80f5e94984c59e61c3c91bb70.zip"');

				header('Content-Transfer-Encoding: binary');

				header('Vary: Accept-Encoding');

				header('Content-Encoding: gzip');

				header('Keep-Alive: timeout=5, max=100');

				header('Connection: Keep-Alive');

				header('Transfer-Encoding: chunked');

				header('Content-Type: application/octet-stream');

				apache_setenv('no-gzip', '1');



			}

			else

			{

				redirect(base_url()."downloads/".$folder."/".$document['documenturl']);

			}

		}

		else

		{

			$data['msg'] = "<div style='background-color:#FFF; height:300px'>".format_notice("WARNING: The file does not exist.")."

			<br>

			<br>

			<input type='button' name='fileredirect' id='fileredirect' value='&laquo;Previous Page' onclick='javascript: history.go(-1)' class='button'/></div>";

			

			$data['area'] = 'document_doesnt_exist';

			$this->load->view('incl/addons', $data);

		}

		

	}

	

	

	#Function to view the actual image size

	function view_actual_image()

	{

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('u', 'f'));

		# Pick all assigned data

		$data = assign_to_data($urldata);

		

		#the folder

		if(!empty($data['f'])){

			$data['folder'] = decryptValue($data['f']);

		} else {

			$data['folder'] = "documents";

		}

		

		#the file url

		if(empty($data['u'])){

			$data['msg'] = "WARNING: The image details can not be resolved.";

		}

		else

		{

			$data['fileurl'] = decryptValue($data['u']);

		}

		

		$data['area'] = 'actual_image';

		

		$data = add_msg_if_any($this, $data);

		$this->load->view('incl/addons', $data);

	}

}

?>
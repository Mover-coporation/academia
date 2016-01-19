<?php 



#**************************************************************************************

# All account functions performed from third party websites are done here

#**************************************************************************************



class Photo extends CI_Controller {

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

	



	function add() {

			//print_r($_POST);

			//print_r($_FILES);

			$data['userstamp'] = $this->session->userdata('userid')."_".time();

			$this->session->set_userdata('local_allowed_extensions', array('.jpg','.jpeg', '.gif', '.tiff', '.png'));

			

			#If the user is uploading an image

			if($this->input->post('upload') || $this->input->post('saveandnew'))

			{

				$ipaddress = get_ip_address();

				if($this->session->userdata('searchstamp')){ 

					$searchstamp = $this->session->userdata('searchstamp');

				} else {

					$searchstamp = "";

				}

				if($this->session->userdata('searchemail')){ 

					$searchemail = $this->session->userdata('searchemail');

				} else {

					$searchemail = "";

				}

				

				

				#User is uploading from the camera

				if($this->input->post('upload') == 'Save Camera Photo' || $this->input->post('saveandnew') == 'Save Camera Photo & New')

				{

					$filename = HOME_URL."camcapture/images/".$ipaddress.".txt";

					if(file_exists($filename))

					{

						#$fp = fopen($filename, 'r');

						$content = file($filename);

						#details array from first line

						$content_array = explode("|", $content[0]);

						$imgfilename = HOME_URL."camcapture/images/".$content_array[0];

					

						$move_result = copy($imgfilename, HOME_URL."downloads/images/user_".$data['userstamp']."_".$ipaddress.".jpg");

						#record move and delete temp file if the move was successful

						if($move_result)

						{

							$db_save = $this->db->query($this->Query_reader->get_query_by_code('save_image_move_trace', array('contentstamp'=>$data['userstamp'], 'ipaddress'=>$ipaddress, 'imageurl'=>"user_".$data['userstamp']."_".$ipaddress.".jpg", 'searchstamp'=>$searchstamp, 'searchemail'=>$searchemail, 'contenttype'=>'user')));

						

							if($db_save){

								$imageurl = "user_".$data['userstamp']."_".$ipaddress.".jpg";

								@unlink($filename);

								@unlink($imgfilename);

							}

						}

					}

					

					

				}

				

				

				

				#User is uploading local photo

				else if($this->input->post('upload') == 'Save Local Photo' || $this->input->post('saveandnew') == 'Save Local Photo & New')

				{

					//echo "Here I am";

					#The image uploaded from the machine

					$imageurl = !empty($_FILES['imageurl']['name'])? $this->sysfile->local_file_upload($_FILES['imageurl'], "user_".$data['userstamp']."_".$ipaddress, 'images', 'filename'): '';

					//echo "Image URL ".$imageurl;

					if(!empty($imageurl))

					{

						$db_save = $this->db->query($this->Query_reader->get_query_by_code('save_image_move_trace', array('contentstamp'=>$data['userstamp'], 'ipaddress'=>$ipaddress, 'imageurl'=>$imageurl, 'searchstamp'=>$searchstamp, 'searchemail'=>$searchemail, 'contenttype'=>'user')));

					}

				}

				

				

				

				#User is uploading remote photo

				else if($this->input->post('upload') == 'Save Remote Photo' || $this->input->post('saveandnew') == 'Save Remote Photo & New')

				{

					

					if($_POST['remoteimageurl'] != 'http://' && @fopen($_POST['remoteimageurl'], "r"))

					{

						$ext = strtolower(strrchr($_POST['remoteimageurl'],"."));

						$imageurl = "user_".$data['userstamp']."_".$ipaddress.$ext;

						$copy_result = copy($_POST['remoteimageurl'], HOME_URL."downloads/images/".$imageurl);



						if($copy_result)

						{

							$db_save = $this->db->query($this->Query_reader->get_query_by_code('save_image_move_trace', array('contentstamp'=>$data['userstamp'], 'ipaddress'=>$ipaddress, 'imageurl'=>$imageurl, 'searchstamp'=>$searchstamp, 'searchemail'=>$searchemail, 'contenttype'=>'user')));

						}

					}

				}

				

				#Record a message for users

				if(!empty($db_save) && $db_save)

				{

					$folder_copy_result = copy(HOME_URL."downloads/images/".$imageurl, HOME_URL."images/user_images/".$imageurl);



						if($folder_copy_result)

						{

							//echo "Her4e I am";

							//echo $this->Query_reader->get_query_by_code('save_user_image', array('folder'=>'user_images','filename'=>$imageurl, 'alttext'=>$_POST['alttext'],'addedby'=>$this->session->userdata('userid'), 'uploadreason'=>'Uploaded to user album','imagecredit'=>$_POST['imagecredit'], 'isactive'=>'Y','referenceno'=>$_POST['referenceno'], 'isshown'=>'Y'));

							$db_save_image = $this->db->query($this->Query_reader->get_query_by_code('save_user_image', array('folder'=>'user_images','filename'=>$imageurl, 'alttext'=>$_POST['alttext'],'addedby'=>$this->session->userdata('userid'), 'uploadreason'=>'Uploaded to user album','imagecredit'=>$_POST['imagecredit'], 'isactive'=>'Y','identifier'=>$_POST['identifier'], 'isshown'=>'Y','referenceno'=>'')));

							//echo mysql_error();

							if(!empty($db_save_image) && $db_save_image) {

								$data['msg'] = "Thank you. Your photo has been uploaded successfully.";

								$this->session->set_userdata('lmsg', $data['msg']);

								if($this->input->post('upload')) {

									redirect(base_url()."photo/album/m/lmsg");

								} else {

									//echo "finally here";

									redirect(base_url()."photo/add/m/lmsg");

								}

							} else {

								$data['msg'] = "ERROR: There was a problem submitting your image.<br>Please try again or <a href='javascript:void(0)'>contact our technical team</a>.";

		

							}

						} else {

								$data['msg'] = "ERROR: There was a problem submitting your image.<br>Please try again or <a href='javascript:void(0)'>contact our technical team</a>.";



						}

				}

				else

				{

					$data['msg'] = "ERROR: There was a problem submitting your image.<br>Please try again or <a href='javascript:void(0)'>contact our technical team</a>.";

				}

			}

						

			//$data['area'] = $data['i'];

			$data = add_msg_if_any($this, $data);

			$this->load->view('photo/add_photo_view', $data);

		}

		

		

		function album() {

			# Get the passed details into the url data array if any

			$urldata = $this->uri->uri_to_assoc(3, array('m', 's'));

			# Pick all assigned data

			$data = assign_to_data($urldata);

				

			$data = paginate_list($this, $data, 'get_image_list',  array('searchstring'=>' AND isshown=\'Y\' AND addedby=\''.$this->session->userdata('userid').'\''), 5);

			$data = add_msg_if_any($this, $data);

			$this->load->view('photo/album_view', $data);

		}

		

				

		function manage() {

			# Get the passed details into the url data array if any

			$urldata = $this->uri->uri_to_assoc(3, array('m', 's'));

			# Pick all assigned data

			$data = assign_to_data($urldata);

				

			$data = paginate_list($this, $data, 'get_image_list',  array('searchstring'=>' AND isshown=\'Y\''));

			$data = add_msg_if_any($this, $data);

			$this->load->view('photo/manage_photos_view', $data);

		}

		

			#function to preview the disease while editing

	function preview_photo()

	{

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('i'));

		# Pick all assigned data

		$data = assign_to_data($urldata);

		//echo decryptValue($data['i']);

		

		#Get disease details

		if(!empty($data['i']))

		{

			$data['formdata'] = $this->Query_reader->get_row_as_array('get_image_by_id', array('id'=>decryptValue($data['i'])));

		}

		else

		{

			$this->session->set_userdata('fmsg', "WARNING: The photo details could not be obtained.");

			redirect(base_url()."photo/album/m/fmsg");

		}

		$data = add_msg_if_any($this, $data);

		$this->load->view('photo/preview_photo', $data);

	}

	

			#Function to delete a page

	function update_photo_status()

	{

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('i'));

		# Pick all assigned data

		$data = assign_to_data($urldata);

		

		if(!empty($data['i']))

		{

			#Delete an image

			if(!empty($data['a']) && decryptValue($data['a']) == 'delete')

			{

				$result = $this->db->query($this->Query_reader->get_query_by_code('delete_image', array('id'=>decryptValue($data['i']))));

			}

			#Activate an image

			if(!empty($data['a']) && decryptValue($data['a']) == 'activate')

			{

				$result = $this->db->query($this->Query_reader->get_query_by_code('activate_image', array('status'=>'Y', 'id'=>decryptValue($data['i']))));

			}

			#Deactivate an image

			if(!empty($data['a']) && decryptValue($data['a']) == 'deactivate')

			{

				$result = $this->db->query($this->Query_reader->get_query_by_code('deactivate_image', array('status'=>'N', 'id'=>decryptValue($data['i']))));

			}			

		}

		

		#Prepare appropriate message

		if(!empty($result) && $result)

		{

			$msg = "The photo has been ".decryptValue($data['a'])."d.";

		}

		else

		{

			$msg = "ERROR: The photo could not be ".decryptValue($data['a'])."d. Please contact your admin.";

		}

		

		$this->session->set_userdata('lmsg', $msg);

		redirect(base_url()."photo/album/m/lmsg/i/".$data['i']);

	}	

	

	#Function to load upload a photo

	function upload_photo()

	{

		access_control($this);

		

		#check if recover image has been specified

		if(!empty($_FILES['insert-image']['tmp_name']))

		{

			$_POST = clean_form_data($_POST);

			

			$new_file_url = 'ac_'.strtotime('now').generate_random_letter().".".end(explode('.', $_FILES['insert-image']['name']));

			if(copy($_FILES['insert-image']['tmp_name'], UPLOAD_DIRECTORY."temp/".$new_file_url)) 

			{

				#Create a thumb nail as well

				$config['image_library'] = 'gd2';

				$config['source_image'] = UPLOAD_DIRECTORY."temp/".$new_file_url;

				$config['create_thumb'] = TRUE;

				$config['maintain_ratio'] = TRUE;

				$config['width'] = 180;

				$config['height'] = 160;

				$this->load->library('image_lib', $config);

				$this->image_lib->resize();

				

				$temp_array = explode('.', $new_file_url);

				$data['msg'] = base_url()."downloads/temp/".$temp_array[0].'_thumb.'.$temp_array[1];				

			}

		}		

		

		if(empty($data['msg']))

				$data['msg'] = "ERROR";

		

		$data['area'] = 'upload_student_img';

		$this->load->view('incl/addons', $data);

	}

}

?>
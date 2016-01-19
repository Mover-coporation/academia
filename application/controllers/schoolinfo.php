<?php

#**************************************************************************************

# All school info actions go through this controller

#**************************************************************************************



class Schoolinfo extends CI_Controller {

	#Constructor to set some default values at class load
	public function __construct()
    {
		   parent::__construct();	

		$this->load->model('sys_email','sysemail');

		$this->load->model('class_mod','classobj');

		$this->load->model('term','terms');

		date_default_timezone_set(SYS_TIMEZONE);

		$this->myschool = $this->session->userdata('schoolinfo');

    }

	

	var $myschool;

    

    # Default to nothing

    function index()

    {

        #Do nothing

    }

    	

	

	#Function to load the manage settings view

	function manage_school_info()

	{

		access_control($this);

		

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));

		

		# Pick all assigned data

		$data = assign_to_data($urldata);

						

		$data = add_msg_if_any($this, $data);

		

		#get school info

		$data['schooldetails'] = $this->Query_reader->get_row_as_array('search_schools_list', array('limittext'=>'', 'searchstring' => ' AND id = '.$this->myschool['id']));

		

		$this->load->view('schoolinfo/school_info_view', $data);

	}

	

	

	#Function to save a class

	function update_school_info()

	{

		access_control($this);

		

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i', 'a', 't'));

		

		# Pick all assigned data

		$data = assign_to_data($urldata);	

		

		$data = restore_bad_chars($data);	

		

		if($data['save'])

		{ 

			$data['schooldetails'] = $data;		

            $required_fields = array('schoolname', 'emailaddress', 'telephone');

			$_POST = clean_form_data($data);

			$validation_results = validate_form('', $_POST, $required_fields);

			$classname_error = '';

			$rank_error = '';

                        

			#set status as editing on destination if updating

            if($this->input->post('editid')) $data['editid'] = $_POST['editid'];			

			

			#Only proceed if the validation for required fields passes

			if($validation_results['bool'] && !(empty($data['editid']) && !empty($user_details)))

			{ 

				#Update school info

				$result = $this->db->query($this->Query_reader->get_query_by_code('user_update_school_data', array_merge($_POST, array('editid'=>$this->myschool['id']))));

				

				$data['schooldetails'] = $this->Query_reader->get_row_as_array('search_schools_list', array('limittext'=>'', 'searchstring' => ' AND id = '.$this->myschool['id']));

				

           		#Format and send the errors

            	if(!empty($result) && $result)

				{

					$data['msg'] = "The school data has been successfully saved.";

					

					#Copy school badge to designated folder					

					if(!empty($_POST['photo']))

					{

						$copy_image_result = copy(UPLOAD_DIRECTORY."temp/".$_POST['photo'], UPLOAD_DIRECTORY."schools/".$_POST['photo']);

						

						#copy the thumb_nail as well

						$thumb_nail_ext = end(explode('.', $_POST['photo']));

						$copy_image_thumb_result = copy(UPLOAD_DIRECTORY."temp/" . str_replace('.' . $thumb_nail_ext, '_thumb.' . $thumb_nail_ext, $_POST['photo']), UPLOAD_DIRECTORY."schools/" . str_replace('.' . $thumb_nail_ext, '_thumb.' . $thumb_nail_ext, $_POST['photo']));

						

						if(!$copy_image_result && !$copy_image_thumb_result)

						{

							$data['msg'] = 'WARNING: ' & $data['msg'] . '<br />' . 'An error occured while saving the school badge'; 

						}

						else

						{

							@unlink(UPLOAD_DIRECTORY."temp/".$_POST['photo']);

							@unlink(UPLOAD_DIRECTORY."temp/". str_replace('.' . $thumb_nail_ext, '_thumb.' . $thumb_nail_ext, $_POST['photo']));

						}

					}

            	 }

            	 else if(empty($data['msg']))

            	 {

				   	$data['msg'] = "ERROR: The school data could not be saved or was not saved correctly.".$classname_error.$rank_error;

             	 }

            }

            			             

            if((empty($validation_results['bool']) || (!empty($validation_results['bool']) && !$validation_results['bool'])) 

			&& empty($data['msg']) )

			{

				$data['msg'] = "WARNING: The highlighted fields are required.";

			}

			

			$data['requiredfields'] = $validation_results['requiredfields'];

		}		

         

                

		$this->load->view('schoolinfo/school_info_view', $data);

	}

	

}



?>


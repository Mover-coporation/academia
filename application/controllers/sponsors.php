<?php

#**************************************************************************************

# All sponsor actions go through this controller

#**************************************************************************************



class Sponsors extends CI_Controller {

	#Constructor to set some default values at class load
	public function __construct()
    {
		   parent::__construct();	

		$this->load->model('sys_email','sysemail');

		$this->load->model('sponsor','sponsorobj');

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

    

	#Function to load the exam data form

	function load_sponsor_form()

	{

		access_control($this);

		

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i','a'));

		

		# Pick all assigned data

		$data = assign_to_data($urldata);

		

                                

        #user is editing

		if(!empty($data['i']))

		{

			$sponsorid = decryptValue($data['i']);

			

			$data['formdata'] = $this->Query_reader->get_row_as_array('search_sponsors', array('orderby'=>'sponsorid', 'limittext'=>'', 'searchstring' => ' AND isactive = "Y"  AND sponsorid = ' . $sponsorid));

			 

            #Check if the user is simply viewing

            if(!empty($data['a']) && decryptValue($data['a']) == 'view')

            {

                $data['isview'] = "Y";

            }

		}

		

		$this->load->view('sponsors/sponsor_form_view', $data);

	}

	

	#Function to save a sponsor's details

	function save_sponsor()

	{

		access_control($this);

		

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i', 'a', 't'));

		

		# Pick all assigned data

		$data = assign_to_data($urldata);		

		if($data['save'])

		{	

			$data['formdata'] = $data;		

            $required_fields = array('firstname', 'lastname');

			

			foreach($data as $key => $data_value)

				$data[$key] = restore_bad_chars($data_value);

			

			$_POST = clean_form_data($data);

			$validation_results = validate_form('', $_POST, $required_fields);

			$feename_error = '';

                        

			#Only proceed if the validation for required fields passes

			if($validation_results['bool'])

			{ 			

				#check if sponsor photo has changed

				if(!empty($_POST['photo']))

				{

					#move photo to designated folder and add value to query string						

					if(copy(UPLOAD_DIRECTORY."temp/".$_POST['photo'], UPLOAD_DIRECTORY."sponsors/".$_POST['photo'])) 

					{								

						#move the thumb nail as well

						$temp_photo_arr = explode('.', $_POST['photo']);

						

						if(copy(UPLOAD_DIRECTORY."temp/".$temp_photo_arr[0].'_thumb.'.$temp_photo_arr[1], UPLOAD_DIRECTORY."sponsors/".$temp_photo_arr[0].'_thumb.'.$temp_photo_arr[1]))

						{

							if(!empty($data['editid'])) $_POST['UPDATESTRING'] = ',photo ="'.$_POST['photo'].'"';

						}							

					}

				}

				else

				{

					$_POST['UPDATESTRING'] = '';

				}

										

                if(!empty($data['editid']))

                {					

					$result = $this->sponsorobj->update_sponsor(array_merge($_POST, array('editid'=> decryptValue($data['editid']))));

           	  	}

			 	else 

             	{

					#Add the school id and author to the data array

					$_POST = array_merge($_POST, array('school'=> $this->myschool['id'], 'author' => $this->session->userdata('userid')));

						

					$result = $this->sponsorobj->add_sponsor($_POST);

        		}

				

           		#Format and send the errors

            	if(!empty($result) && $result)

				{					

					$data['msg'] = (empty($data['editid']))? $data['firstname'].' '.$data['lastname'] . ' has been added to the sponsors list' : $data['firstname'].'\'s details have been updated.';

					$data['formdata'] = array();

            	 }

            	 else if(empty($data['msg']))

            	 {

				   	$data['msg'] = "ERROR: The sponsor could not be saved or was not saved correctly.";					

             	 }

            }

			

			$data['requiredfields'] = $validation_results['requiredfields'];

		}

        		

		$this->load->view('sponsors/sponsor_form_view', $data);

	}

	

	#Function to manage sponsors

	function manage_sponsors()

	{

		access_control($this);

		

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));

		

		# Pick all assigned data

		$data = assign_to_data($urldata);

		

		#Get the paginated list of the students

		$data = paginate_list($this, $data, 'search_sponsors', array('searchstring'=> ' AND school = '.$this->myschool['id'], 'orderby'=>'firstname'));

				

		$data = add_msg_if_any($this, $data);

		$this->load->view('sponsors/manage_sponsors_view', $data);

	}	

	

	

	#get student sponsors

	function manage_student_sponsors()

	{

		access_control($this);

		

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));

		

		# Pick all assigned data

		$data = assign_to_data($urldata);

		

		$data['student_info'] = get_db_object_details($this, 'students', decryptValue($data['i']));

		

		#Get the paginated list of the students

		$data = paginate_list($this, $data, 'student_sponsors', array('searchstring'=>' AND students.id=' . decryptValue($data['i']) , 'orderby'=>'fromdate DESC', 'student'=>decryptValue($data['i'])));

				

		$data = add_msg_if_any($this, $data);

		$this->load->view('students/manage_student_sponsors_view', $data);

	}

	

	#Function to delete a sponsor

	function delete_sponsor()

	{

		access_control($this);

		

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i', 't'));

		

		# Pick all assigned data

		$data = assign_to_data($urldata);

		

		if(!empty($data['i']))

			$result = deactivate_row($this, 'exams',decryptValue($data['i']));

		

		

		if(!empty($result) && $result){

			$this->session->set_userdata('dexam', "The exam data has been successfully deleted.");

		}

		else if(empty($data['msg']))

		{

			$this->session->set_userdata('dexam', "ERROR: The exam could not be deleted or was not deleted correctly.");

		}

		

		if(!empty($data['t']) && $data['t'] == 'super'){

			$tstr = "/t/super";

		}else{

			$tstr = "";

		}

		redirect("sponsors/manage_exams/m/dexam".$tstr);

	}

		

}



?>


<?php

#**************************************************************************************

# All exam actions go through this controller

#**************************************************************************************



class Exams extends CI_Controller {

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

    

	#Function to load the exam data form

	function load_exam_form()

	{

		access_control($this);

		

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i','a'));

		# Pick all assigned data

		$data = assign_to_data($urldata);

		

		$data['classes'] = $this->classobj->get_classes();

		

		$data['terms'] = $this->terms->get_terms();

                                

        #user is editing

		if(!empty($data['i']))

		{

			$examid = decryptValue($data['i']);

			

			$data['formdata'] = $examdetails = $this->Query_reader->get_row_as_array('search_exams', array('limittext'=>'', 'searchstring' => ' AND isactive = "Y"  AND id = '.$examid));

			

			#Check if the exam belongs to the current user's school

			if($examdetails['school'] != $this->myschool['id']){

				$data['msg'] = "ERROR: The exam details could not be loaded.";

				$data['formdata'] = $examdetails = array ();	

			}

			 

            #Check if the user is simply viewing

            if(!empty($data['a']) && decryptValue($data['a']) == 'view')

            {

                $data['isview'] = "Y";

            }

		}

		

		$this->load->view('exams/exam_form_view', $data);

	}

	

	#Function to save an exams details

	function save_exam()

	{

		access_control($this);

		

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i', 'a', 't'));

		

		# Pick all assigned data

		$data = assign_to_data($urldata);		

		if($data['save'] || $data['saveandnew'])

		{	

			$data['formdata'] = $data;		

            $required_fields = array('exam', 'term', 'contribution', 'classes');

			

			foreach($data as $key => $data_value)

				$data[$key] = restore_bad_chars($data_value);

			

			$_POST = clean_form_data($data);

			$validation_results = validate_form('', $_POST, $required_fields);

			$feename_error = '';

                        

			#Only proceed if the validation for required fields passes

			if($validation_results['bool'])

			{ 

				#Convert classes into strings

				if(is_array($_POST['classes']))

				{

					$_POST['classes'] = stringify_array($_POST['classes'], '|');

				}

				else

				{

					$_POST['classes'] = '|'.$_POST['classes'].'|';

				}

								

                if(!empty($data['editid']))

                {					

					$result = $this->db->query($this->Query_reader->get_query_by_code('update_exam',array_merge($_POST, array('id'=> $data['editid']))));

           	  	}

			 	else 

             	{

					#Add the school id and author to the data array

					$_POST = array_merge($_POST, array('school'=> $this->myschool['id'], 'author' => $this->session->userdata('userid')));

						

					$result = $this->db->query($this->Query_reader->get_query_by_code('add_exam',$_POST));

        		}

				

           		#Format and send the errors

            	if(!empty($result) && $result)

				{					

					$data['msg'] = (empty($data['editid']))? $data['exam'].' has been added.' : 'Details for '.$data['exam'].' have been updated.';

					$data['formdata'] = array();

            	 }

            	 else if(empty($data['msg']))

            	 {

				   	$data['msg'] = "ERROR: The exam could not be saved or was not saved correctly.";					

             	 }

            }

			

			$data['requiredfields'] = $validation_results['requiredfields'];

		}

        

		$data['classes'] = $this->classobj->get_classes();

		

		$data['terms'] = $this->terms->get_terms();

		

		$this->load->view('incl/exam_form', $data);

	}

	

	#Function to manage exams

	function manage_exams()

	{

		access_control($this);

		

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));

		

		# Pick all assigned data

		$data = assign_to_data($urldata);

		

		#Get the paginated list of the students

		$data = paginate_list($this, $data, 'search_exams', array('searchstring'=>' AND isactive = "Y" AND school = '.$this->myschool['id']));

				

		$data = add_msg_if_any($this, $data);

		$this->load->view('exams/manage_exams_view', $data);

	}

	

	#Function to delete a class

	function delete_exam()

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

		redirect("exams/manage_exams/m/dexam".$tstr);

	}

		

}



?>


<?php

#**************************************************************************************

# All grading actions go through this controller

#**************************************************************************************



class Grading extends CI_Controller {

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

    

	#Function to load the grading data form

	function load_grading_form()

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

			$gradingid = decryptValue($data['i']);

			

			$data['formdata'] = $gradingdetails = $this->Query_reader->get_row_as_array('search_grading', array('limittext'=>'', 'isactive' => 'Y', 'searchstring' => ' AND id = '.$gradingid));

			

			//get the grading details

			$data['grading_details'] = $this->db->query($this->Query_reader->get_query_by_code('search_grading_details', array('limittext'=>'', 'isactive' => 'Y', 'searchstring' => ' AND gradingscale = '.$gradingid)))

										->result_array();			

			

			#Check if the exam belongs to the current user's school

			if($gradingdetails['school'] != $this->myschool['id']){

				$data['msg'] = "ERROR: The grading scale details could not be loaded.";

				$data['formdata'] = $examdetails = array ();	

			}

			 

            #Check if the user is simply viewing

            if(!empty($data['a']) && decryptValue($data['a']) == 'view')

            {

                $data['isview'] = "Y";

            }

		}

		

		$this->load->view('grading/grading_form_view', $data);

	}

	

	#Function to save grading details

	function save_grading_scale()

	{

		access_control($this);

		

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i', 'a', 't'));

		

		# Pick all assigned data

		$data = assign_to_data($urldata);		

		if($data['save'] || $data['saveandnew'])

		{	

			$data['formdata'] = $data;		

            $required_fields = array('gradingname', 'classes');

			

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

					$result = $this->db->query($this->Query_reader->get_query_by_code('update_grading_scale',array_merge($_POST, array('id'=> $data['editid']))));

           	  	}

			 	else 

             	{

					#Add the school id and author to the data array

					$_POST = array_merge($_POST, array('school'=> $this->myschool['id'], 'author' => $this->session->userdata('userid')));

						

					$result = $this->db->query($this->Query_reader->get_query_by_code('add_grading_scale',$_POST));

					

					#Check if grades have been added

					if(!empty($_POST['gradingdetails']))

					{

						$grades = explode('|', trim($_POST['gradingdetails']));

						

						#Format the data for the query

						$query_data = '';

						foreach($grades as $grade)

						{	

							$grade_details = explode('^', $grade);

							$query_data .= ($query_data == '')? '('.$this->db->insert_id().', "'.$grade_details[0].'", "'.$grade_details[1].'"'.

																', "'.$grade_details[2].'", "'.$grade_details[3].'")' : 

																',('.$this->db->insert_id().', "'.$grade_details[0].'", "'.$grade_details[1].'"'.

																', "'.$grade_details[2].'", "'.$grade_details[3].'")';

						}

							

						

						$papers_result = $this->db->query($this->Query_reader->get_query_by_code('add_grading_details', array('rows' => $query_data)));

					}

        		}

				

           		#Format and send the errors

            	if(!empty($result) && $result)

				{					

					$data['msg'] = (empty($data['editid']))? $data['gradingname'].' has been added.' : 'Details for '.$data['gradename'].' have been updated.';

					$data['formdata'] = array();

            	 }

            	 else if(empty($data['msg']))

            	 {

				   	$data['msg'] = "ERROR: The grading scale could not be saved or was not saved correctly.";					

             	 }

            }

			

			$data['requiredfields'] = $validation_results['requiredfields'];

		}

        

		$data['classes'] = $this->classobj->get_classes();

		

		$data['terms'] = $this->terms->get_terms();

		

		$this->load->view('incl/grading_form', $data);

	}

	

	#Function to manage grading

	function manage_grading()

	{

		access_control($this);

		

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));

		

		# Pick all assigned data

		$data = assign_to_data($urldata);

		

		#Get the paginated list of the grading schemes

		$data = paginate_list($this, $data, 'search_grading', array('isactive'=>'Y', 'searchstring'=>' AND school = '.$this->myschool['id']));

								

		$data = add_msg_if_any($this, $data);

		$this->load->view('grading/manage_grading_view', $data);

	}

	

	#Function to delete a grading scheme

	function delete_grading_scheme()

	{

		access_control($this);

		

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i', 't'));

		

		# Pick all assigned data

		$data = assign_to_data($urldata);

		

		if(!empty($data['i']))

			$result = deactivate_row($this, 'grading',decryptValue($data['i']));

		

		

		if(!empty($result) && $result){

			$this->session->set_userdata('dgrading', "The grading scheme has been successfully deleted.");

		}

		else if(empty($data['msg']))

		{

			$this->session->set_userdata('dgrading', "ERROR: The grading scheme could not be deleted or was not deleted correctly.");

		}

		

		if(!empty($data['t']) && $data['t'] == 'super'){

			$tstr = "/t/super";

		}else{

			$tstr = "";

		}

		//redirect("grading/manage_grading/m/dgrading".$tstr);

	}

		

}



?>


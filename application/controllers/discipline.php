<?php

#**************************************************************************************

# All discipline actions go through this controller

#**************************************************************************************



class Discipline extends CI_Controller {

	#Constructor to set some default values at class load
	public function __construct()
    {
		   parent::__construct();

		$this->load->model('sys_email','sysemail');

		$this->load->model('discipline_mod','disciplineobj');

		date_default_timezone_set(SYS_TIMEZONE);

		$this->myschool = $this->session->userdata('schoolinfo');

    }

	

	var $myschool;

    

    # Default to nothing

    function index()

    {

        #Do nothing

    }

    

	#Function to load the class data form

	function load_incident_form()

	{

		access_control($this);

		

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i','s'));

		

		# Pick all assigned data

		$data = assign_to_data($urldata);

		

		#get the student info

		if(!empty($data['s'])):

			$data['student_details'] = $this->Query_reader->get_row_as_array('get_students_list', 

									array('isactive'=>'Y', 'searchstring'=>' AND id=\'' . decryptValue($data['s']) .'\'', 'limittext'=>''));

		endif;

		

                                

        #user is editing

		if(!empty($data['i']))

		{

			$classid = decryptValue($data['i']);

			

			$data['classdetails'] = $this->Query_reader->get_row_as_array('search_classes_list', array('isactive' => 'Y', 'limittext'=>'', 'searchstring' => ' AND id = '.$classid));

			

			#Check if the term belongs to the current user's school

			if($data['classdetails']['school'] != $this->myschool['id'])

				$data['classdetails'] = array ();	

                        

            #Check if the user is simply viewing

            if(!empty($data['a']) && decryptValue($data['a']) == 'view')

            {

                $data['isview'] = "Y";

            }

		}

		

		$this->load->view('discipline/incident_form_view', $data);

	}

	

	#Function to save an incident

	function save_incident()

	{

		access_control($this);

		

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i', 's', 't'));

		

		# Pick all assigned data

		$data = assign_to_data($urldata);	

		

		$data = restore_bad_chars($data);	

		

		if($_POST['save_incident'])

		{

			$data['formdata'] = $_POST;

            $required_fields = array('incidentdate', 'student', 'reportedby', 'response', 'incidentdetails', 'actiontaken');

			$_POST = clean_form_data($_POST);

			$validation_results = validate_form('', $_POST, $required_fields);

                        

			#set status as editing on destination if updating

            if($this->input->post('editid')) $data['editid'] = $_POST['editid'];			

			

			#Only proceed if the validation for required fields passes

			if($validation_results['bool'] && !(empty($data['editid']) && !empty($user_details)))

			{   

                if(!empty($_POST['editid']))

                {					

					#Add the school id and author to the data array

					$_POST = array_merge($_POST, array('author' => $this->session->userdata('userid')));

					

					$result = $this->disciplineobj->update_incident(array_merge($_POST, array('id'=> $data['editid'])));

           	  	}

			 	else 

             	{			                        

                	#Add the school id and author to the data array

					$_POST = array_merge($_POST, array('author' => $this->session->userdata('userid')));



                    #decrypt student and reported by values

                    $_POST['student'] = decryptValue($_POST['student']);

                    $_POST['reportedby'] = decryptValue($_POST['reportedby']);



					$result = $this->disciplineobj->add_incident($_POST );

        		}

				

           		#Format and send the errors

            	if(!empty($result) && $result)

				{					

					$data['msg'] = "The incident data has been successfully saved.";

					$data['formdata'] = array();

            	 }

            	 else if(empty($data['msg']))

            	 {

				   	$data['msg'] = "ERROR: The incident could not be saved or was not saved correctly.".$classname_error.$rank_error;

             	 }

            }

            

			#Prepare a message in case the user already exists for another school

			else if(empty($data['editid']) && !empty($class_details))

			{

				 #$addn_msg = (!empty($user_details['isactive']) && $user_details['isactive'] == 'N')? "<a href='".base_url()."admin/load_user_form/i/".encryptValue($user_details['id'])."/a/".encryptValue("reactivate")."' style='text-decoration:underline;font-size:17px;'>Click here to  activate and  edit</a>": "<a href='".base_url()."admin/load_user_form/i/".encryptValue($user_details['id'])."' style='text-decoration:underline;font-size:17px;'>Click here to edit</a>";

				 

				 $data['msg'] = "WARNING: A class with the same name already exists.<br />"; 

			}

			             

            if((empty($validation_results['bool']) || (!empty($validation_results['bool']) && !$validation_results['bool'])) 

			&& empty($data['msg']) )

			{

				$data['msg'] = "WARNING: The highlighted fields are required.";

			}

			

			$data['requiredfields'] = $validation_results['requiredfields'];

		}



        #get the student info

        if(!empty($data['s'])):

            $data['student_details'] = $this->Query_reader->get_row_as_array('get_students_list',

                array('isactive'=>'Y', 'searchstring'=>' AND id=\'' . decryptValue($data['s']) .'\'', 'limittext'=>''));

        endif;

                

		$this->load->view('discipline/incident_form_view', $data);

	}

	

	#Function to manage classes

	function manage_incidents()

	{

		access_control($this);

		

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));

		

		# Pick all assigned data

		$data = assign_to_data($urldata);

		

		$student_id = (!empty($data['i']))? decryptValue($data['i']) : '';

		

		#get the student info

		$data['student_details'] = $this->Query_reader->get_row_as_array('get_students_list', 

									array('isactive'=>'Y', 'searchstring'=>' AND id=\'' . $student_id .'\'', 'limittext'=>''));

		

		#Get the paginated list of incidents

		$data = paginate_list($this, $data, 'search_discipline', array('isactive'=>'Y',

							'searchstring'=>(!empty($student_id)? ' students.id=\'' . $student_id .'\'' : '1=1') . '  ORDER BY incidentdate DESC',

							'school'=> '\'' . $this->myschool['id'] . '\''));

				

		$data = add_msg_if_any($this, $data);

		$this->load->view('discipline/manage_incidents_view', $data);

	}

	

	#Function to delete a class

	function delete_class()

	{

		access_control($this);

		

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i', 't'));

		

		# Pick all assigned data

		$data = assign_to_data($urldata);

		

		if(!empty($data['i']))

			$result = deactivate_row($this, 'classes',decryptValue($data['i']));

		

		

		if(!empty($result) && $result){

			$this->session->set_userdata('dclass', "The class data has been successfully deleted.");

		}

		else if(empty($data['msg']))

		{

			$this->session->set_userdata('dclass', "ERROR: The class could not be deleted or was not deleted correctly.");

		}

		

		if(!empty($data['t']) && $data['t'] == 'super'){

			$tstr = "/t/super";

		}else{

			$tstr = "";

		}

		redirect("classes/manage_classes/m/dclass".$tstr);

	}

	

}



?>


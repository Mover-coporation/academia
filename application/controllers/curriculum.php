<?php

#**************************************************************************************

# All curriculum actions go through this controller

#**************************************************************************************



class Curriculum extends CI_Controller {

	#Constructor to set some default values at class load
	public function __construct()
    {
		 parent::__construct();

		$this->load->model('sys_email','sysemail');

		$this->load->model('class_mod','classobj');

		$this->load->model('term','terms');

		$this->load->model('finance','financeobj');

		$this->load->model('student','studentobj');

		date_default_timezone_set(SYS_TIMEZONE);

		$this->myschool = $this->session->userdata('schoolinfo');

    }

	

	var $myschool;

    

    # Default to nothing

    function index()

    {

        #Do nothing

    }

	

	#Function to load the subject-teacher assignment form

	function assign_teacher_form()

	{

		access_control($this);

		

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i','a'));

		

		# Pick all assigned data

		$data = assign_to_data($urldata);

		

		$subjectid = decryptValue($data['i']);

			

		$data['formdata'] = $this->Query_reader->get_row_as_array('search_subjects', array('isactive' => 'Y', 'limittext'=>'', 'searchstring' => ' AND id = '.$subjectid));

		$classes_array = explode('|', $data['formdata']['classes']);

		$classes_array = remove_empty_indices($classes_array);

		$classes_str = implode(',', $classes_array);

		

		$data['classes'] = $this->classobj->get_classes('', ' AND id IN ('.$classes_str.')');

		

		$data['papers'] = $this->db->query($this->Query_reader->get_query_by_code('search_papers', array('isactive' => 'Y', 'searchstring' => ' AND subject = '.$subjectid, 'limittext' => '')))

							->result_array();

		

		$data['staff'] = $this->db->query($this->Query_reader->get_query_by_code('search_school_users', array('limittext' =>'', 'searchstring' => ' AND school ='.$this->myschool['id'])))

							->result_array();

         

		#Check if the subject belongs to the current user's school

		if($data['formdata']['school'] != $this->myschool['id'])

				$data['formdata'] = array ();	

                        

		#Check if the user is simply viewing

		if(!empty($data['a']) && decryptValue($data['a']) == 'view')

			$data['isview'] = "Y";

		

		$this->load->view('curriculum/assign_teachers_view', $data);

	

	}

    

	#Function to load the subject data form

	function load_subject_form()

	{

		access_control($this);

		

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i','a'));

		# Pick all assigned data

		$data = assign_to_data($urldata);

		

		$data['classes'] = $this->classobj->get_classes();

                                

        #user is editing

		if(!empty($data['i']))

		{

			$subjectid = decryptValue($data['i']);

			

			$data['formdata'] = $this->Query_reader->get_row_as_array('search_subjects', array('isactive' => 'Y', 'limittext'=>'', 'searchstring' => ' AND id = '.$subjectid));

			

			#Get the subject papers if any

			$data['formdata']['papers'] = $this->db->query($this->Query_reader->get_query_by_code('search_papers', array('isactive' => 'Y', 'limittext'=>'', 'searchstring' => ' AND subject = '.$subjectid)))->result_array();

			

			#Check if the subject belongs to the current user's school

			if($data['formdata']['school'] != $this->myschool['id'])

				$data['formdata'] = array ();	

                        

            #Check if the user is simply viewing

            if(!empty($data['a']) && decryptValue($data['a']) == 'view')

            {

                $data['isview'] = "Y";

            }

		}

		

		$this->load->view('curriculum/subject_form_view', $data);

	}

	

	

	#function to assign a teacher a subject

	function assign_teacher()

	{

		access_control($this);

		

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i', 'a', 't'));

		

		# Pick all assigned data

		$data = assign_to_data($urldata);		

		if($data['save'])

		{	

			$data['formdata'] = $data;		

            $required_fields = array('subject', 'class', 'teacher');

			

			foreach($data as $key => $data_value)

				$data[$key] = restore_bad_chars($data_value);

			

			$_POST = clean_form_data($data);

			$validation_results = validate_form('', $_POST, $required_fields);

			$feename_error = '';

                        

			#Only proceed if the validation for required fields passes

			if($validation_results['bool'])

			{

                if(!empty($data['editid']))

                {

                 //   print_r('Entered'); exit();

					$result = $this->db->query($this->Query_reader->get_query_by_code('update_subject_teacher',array_merge($_POST, array('id'=> $data['editid']))));

           	  	}

			 	else 

             	{

					$result = $this->db->query($this->Query_reader->get_query_by_code('assign_subject_teacher',$_POST));

					if($result)

					{

						#Delete previous assignments

					#	$this->db->delete('subjectteacherassignments', 'class ='.$data['class'].' AND subject='.$data['subject'].' AND teacher !='.$data['teacher'].((!empty($data['paper']))? ' AND paper='.$data['paper'] : ''));

					}

        		}

				

           		#Format and send the errors

            	if(!empty($result) && $result)

				{					

					$user_details = get_db_object_details($this, 'schoolusers', $data['teacher']);

					$subject_details = get_db_object_details($this, 'subjects', $data['subject']);

					$data['msg'] = $user_details['firstname'].' '.$user_details['lastname'].' has been successfully assigned as <br />the '.$subject_details['subject'].' teacher for '.get_class_title($this, $data['class']);

					$data['formdata'] = array();

            	 }

            	 else if(empty($data['msg']))

            	 {

				   	$data['msg'] = "ERROR: The subject-teacher assignment could not be saved or was not saved correctly.";					

             	 }

            }

            

			$data['requiredfields'] = $validation_results['requiredfields'];

		}

        

		$subjectid = $data['subject'];

			

		$data['formdata'] = $this->Query_reader->get_row_as_array('search_subjects', array('isactive' => 'Y', 'limittext'=>'', 'searchstring' => ' AND id = '.$subjectid));

		$classes_array = explode('|', $data['formdata']['classes']);

		$classes_array = remove_empty_indices($classes_array);

		$classes_str = implode(',', $classes_array);

		

		$data['classes'] = $this->classobj->get_classes('', ' AND id IN ('.$classes_str.')');

		

		$data['papers'] = $this->db->query($this->Query_reader->get_query_by_code('search_papers', array('isactive' => 'Y', 'searchstring' => ' AND subject = '.$subjectid, 'limittext' => '')))

							->result_array();

		

		$data['staff'] = $this->db->query($this->Query_reader->get_query_by_code('search_school_users', array('limittext' =>'', 'searchstring' => ' AND school ='.$this->myschool['id'])))

							->result_array();

		

		$this->load->view('incl/subject_teacher_form', $data);

	}

	

	

	#function to save a subject's details

	function save_subject()

	{

		access_control($this);

		

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i', 'a', 't'));

		

		# Pick all assigned data

		$data = assign_to_data($urldata);		

		if($data['save'] || $data['saveandnew'])

		{	

			$data['formdata'] = $data;		

            $required_fields = array('subject', 'classes', 'code');

			

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

					#Check if papers have been added

					if(!empty($_POST['papers']))

					{

						$papers = explode(',', trim($_POST['papers']));

						

						#Format the data for the query

						$query_data = '';

						foreach($papers as $paper)

							$query_data .= ($query_data == '')? '('.$data['editid'].', "'.$paper.'")' : 

										    ',('.$data['editid'].', "'.$paper.'")' ;

						

						$papers_result = $this->db->query($this->Query_reader->get_query_by_code('add_papers', array('rows' => $query_data)));

					}

					

					$result = $this->db->query($this->Query_reader->get_query_by_code('update_subject',array_merge($_POST, array('id'=> $data['editid']))));

           	  	}

			 	else 

             	{

					#Add the school id and author to the data array

					$_POST = array_merge($_POST, array('school'=> $this->myschool['id'], 'author' => $this->session->userdata('userid')));

						

					$result = $this->db->query($this->Query_reader->get_query_by_code('add_subject',$_POST));

					

					#Check if papers have been added

					if(!empty($_POST['papers']))

					{

						$papers = explode(',', trim($_POST['papers']));

						

						#Format the data for the query

						$query_data = '';

						foreach($papers as $paper)

							$query_data .= ($query_data == '')? '('.$this->db->insert_id().', "'.$paper.'")' : 

										    ',('.$this->db->insert_id().', "'.$paper.'")' ;

						

						$papers_result = $this->db->query($this->Query_reader->get_query_by_code('add_papers', array('rows' => $query_data)));

					}

        		}

				

           		#Format and send the errors

            	if(!empty($result) && $result)

				{					

					$data['msg'] = (empty($data['editid']))? $data['subject'].' has been added to the curriculum.' : 'Details for '.$data['subject'].' have been updated.';

					$data['formdata'] = array();

            	 }

            	 else if(empty($data['msg']))

            	 {

				   	$data['msg'] = "ERROR: The subject could not be saved or was not saved correctly.";					

             	 }

            }

			

			$data['requiredfields'] = $validation_results['requiredfields'];

		}

        

		$data['classes'] = $this->classobj->get_classes();

		$this->load->view('incl/subject_form', $data);

	}

	

	#Function to manage subjects

	function manage_subjects()

	{

		access_control($this);

		

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));

		

		# Pick all assigned data

		$data = assign_to_data($urldata);

		

		#Get the paginated list of the students

		$data = paginate_list($this, $data, 'search_subjects', array('isactive'=>'Y', 'searchstring'=>' AND school = '.$this->myschool['id']));

				

		$data = add_msg_if_any($this, $data);

		$this->load->view('curriculum/manage_subjects_view', $data);

	}

	

	

	#Function to view subject-teacher assignments

	function manage_subject_teachers()

	{

		access_control($this);

		

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));

		

		# Pick all assigned data

		$data = assign_to_data($urldata);

		

		$subject = decryptValue($data['i']);

		

		#Get the paginated list of teachers

		$data['teachers'] = $this->db->query($this->Query_reader->get_query_by_code('get_subject_teachers', array('isactive'=>'Y', 'subject'=> $subject)))->result_array();

				

		$data['subject_details'] = get_db_object_details($this, 'subjects', $subject);

		

		$data = add_msg_if_any($this, $data);

		$this->load->view('curriculum/manage_subject_teachers', $data);

	}

	

	

	#Function to delete a paper

	function delete_paper()

	{

		access_control($this);

		

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i', 't'));

		

		# Pick all assigned data

		$data = assign_to_data($urldata);

		

		$paper_details = get_db_object_details($this, 'subjectpapers', decryptValue($data['i']));

		

		if(!empty($data['i']))

			$result = deactivate_row($this, 'subjectpapers',decryptValue($data['i']));

		

		

		if(!empty($result) && $result){

			$data['msg'] = $paper_details['paper']." has has been removed.";

		}

		else if(empty($data['msg']))

		{

			$data['msg'] = "ERROR: The paper could not be deleted or was not deleted correctly.";

		}

		

		$data['papers'] = $this->db->query($this->Query_reader->get_query_by_code('search_papers', array('isactive' => 'Y', 'limittext'=>'', 'searchstring' => ' AND subject = '.$paper_details['subject'])))->result_array();

		

		$data['area'] = 'subject_papers';

		$this->load->view('incl/addons', $data);

	}

	

	

	#Function to delete a subject

	function delete_subject()

	{

		access_control($this);

		

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i', 't'));

		

		# Pick all assigned data

		$data = assign_to_data($urldata);

		

		$subject_details = get_db_object_details($this, 'subjects', decryptValue($data['i']));

		

		if(!empty($data['i']))

			$result = deactivate_row($this, 'subjects',decryptValue($data['i']));

		

		

		if(!empty($result) && $result){

			$this->session->set_userdata('dsubject', $subject_details['subject']." has has been removed from the curriculum.");

			

			#Delete the papers as well

			$delete_papers_str = "UPDATE subjectpapers SET isactive = 'N' WHERE subject ='".decryptValue($data['i'])."'";

			$papers_result = $this->db->query($delete_papers_str);

		}

		else if(empty($data['msg']))

		{

			$this->session->set_userdata('dsubject', "ERROR: The subject could not be deleted or was not deleted correctly.");

		}

		

		if(!empty($data['t']) && $data['t'] == 'super'){

			$tstr = "/t/super";

		}else{

			$tstr = "";

		}

		redirect("curriculum/manage_subjects/m/dsubject".$tstr);

	}

	

	

	//function to load subjects for a particular class

	function get_subjects_by_class()

	{

		access_control($this);

		

		

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i', 'sc'));

		

		# Pick all assigned data

		$data = assign_to_data($urldata);

		

		$data['class'] = get_class_title($this, $data['sc']);

		$data['class'] = ($data['class'] == '') ? '[UNDEFINED CLASS]' : $data['class'];

		

		#Get the paginated list of the students

		$data['page_list'] = $this->db->query($this->Query_reader->get_query_by_code('search_subjects', array('limittext'=>'', 'isactive'=>'Y', 'searchstring'=>' AND classes like "%|'.$data['sc'].'|%" AND school = '.$this->myschool['id'])))->result_array();

				

		$data['area'] = 'class_subjects';

		$this->load->view('incl/addons', $data);

	}

	

}



?>


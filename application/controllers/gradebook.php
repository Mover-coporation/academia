<?php

#**************************************************************************************

# All gradebook actions go through this controller

#**************************************************************************************



class Gradebook extends CI_Controller {

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

	

	

	#function to load student list of a specified class, subject and term

	function grading_list()

	{

		access_control($this);

		

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));

		

		# Pick all assigned data

		$data = assign_to_data($urldata);

		

		#Get students doing the selected subject

		$data['page_list'] = $this->db->query($this->Query_reader->get_query_by_code('get_students_registered_by_subject', array('school'=>$this->myschool['id'], 'term'=>$data['t'], 'class'=>$data['c'], 'subjects'=>$data['s'])))

							->result_array();			

											

		#Get the subject info

		$data['subject'] =  get_db_object_details($this, 'subjects', $data['s']);

		

		#Get the class info

		$data['class'] =  get_db_object_details($this, 'classes', $data['c']);

		

		#Get the term info

		$data['term'] =  get_db_object_details($this, 'terms', $data['t']);

		

		#Get the term info

		//$data['exam'] =  get_db_object_details($this, 'exams', 5);

			

		#Get exams for the current term

		$data['exams'] = $this->db->query($this->Query_reader->get_query_by_code('search_exams', array('limittext'=>'', 'searchstring'=>' AND term="'.$data['t'].'" AND classes like"%|'.$data['c'].'|%" AND isactive="Y"')))

							->result_array();

		

		//get exam info if specified

		if(!empty($data['e']))

		{

			//get default class grading scales

			$data['grading_scale'] = $this->Query_reader->get_row_as_array('search_grading', array('limittext'=>'', 'isactive'=>'Y', 'searchstring'=>' AND classes like "%|'.$data['c'].'|%"'));

			

			//get the grading scale details

			if(!empty($data['grading_scale']))

			$data['grading_scale_details'] = $this->db->query($this->Query_reader->get_query_by_code('search_grading_details', array('limittext'=>'', 'searchstring'=>' AND gradingscale = "'.$data['grading_scale']['id'].'"')))

											->result_array();

			

			$data['exam'] = get_db_object_details($this, 'exams', $data['e']);

			$view_to_load = 'gradebook/mark_sheet_view';

			

			#Get marks if they've been submitted for this subject, exam and class

		$data['mark_sheet_data'] = 	$this->db->query($this->Query_reader->get_query_by_code('search_mark_sheet', array('limittext'=>'', 'searchstring'=>' subject="'.$data['s'].'" AND exam ="'.$data['e'].'" AND class="'.$data['c'].'"')))

							->result_array();

		}

		else

		{

			$view_to_load = 'gradebook/grading_list_view';

		}

		

		$data = add_msg_if_any($this, $data);

				

		$this->load->view($view_to_load, $data);

	}

	

	

	#function to save marks

	function save_marks()

	{

		access_control($this);

		

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));

		

		# Pick all assigned data

		$data = assign_to_data($urldata);

		

		$_POST = clean_form_data($_POST);

		

		if(!empty($_POST['sm']) && decryptValue($_POST['sm']) == 'true')

		{

			//test if marks have already been posted for selected exam, subject and class

			$submitted_marks = $this->db->query($this->Query_reader->get_query_by_code('search_mark_sheet', array('limittext'=>'', 'searchstring'=>' exam="'.decryptValue($_POST['e']).'" AND subject="'.decryptValue($_POST['s']).'" AND class="'.decryptValue($_POST['c']).'"')))

							->result_array();

			

			//format the data for the query

			$query_data = '';

			

			if(!count($submitted_marks))

			{

				foreach($_POST['students'] as $key => $val)

				{

					$student_id = explode('_', $key);

					$student_id = $student_id[count($student_id) - 1];

					

					$query_data_str = '("'.$this->myschool['id'].'", "'.$student_id.'", "'.decryptValue($_POST['s']).'", "'.decryptValue($_POST['c']).'", "'.decryptValue($_POST['e']).'", "'.$val['marks'].'", "'.$val['comments'].'",  "'.$this->session->userdata('userid').'")';

					

					$query_data .= ($query_data == '')? $query_data_str : ','.$query_data_str;

				}

			}

			else

			{

				//For every student, test if they exist in the already submitted marks sheet and update if any changes have been made

				$already_submitted = FALSE;

				

				foreach($_POST['students'] as $key => $val)

				{					

					$student_id = explode('_', $key);

					$student_id = $student_id[count($student_id) - 1];

					

					foreach($submitted_marks as $submitted_marks_key => $submitted_marks_row)

					{

						if($submitted_marks_row['student'] == $student_id && ($submitted_marks_row['mark'] != $val['marks'] || $submitted_marks_row['comment'] != $val['comments']))

						{

							$update_result = $this->db->query($this->Query_reader->get_query_by_code('update_student_mark', array('mark'=>$val['marks'], 'comment'=>$val['comments'], 'author'=>$this->session->userdata('userid'), 'editid'=>$submitted_marks_row['id'])));

							

							unset($submitted_marks[$submitted_marks_key]);

							$already_submitted = TRUE;

						}

						elseif($submitted_marks_row['student'] == $student_id)

						{

							$already_submitted = TRUE;

						}

					}

					

					if(!$already_submitted)

					{

						$query_data_str = '("'.$this->myschool['id'].'", "'.$student_id.'", "'.decryptValue($_POST['s']).'", "'.decryptValue($_POST['c']).'", "'.decryptValue($_POST['e']).'", "'.$val['marks'].'", "'.$val['comments'].'",  "'.$this->session->userdata('userid').'")';

					

						$query_data .= ($query_data == '')? $query_data_str : ','.$query_data_str;

					}

										

					$already_submitted = FALSE;

				}

			}

			

			#exit($this->Query_reader->get_query_by_code('add_multiple_marks', array('rows'=>$query_data)));

			

			if($query_data == '')

			{

				$data['msg'] = format_notice((!empty($update_result) && $update_result)? "The mark sheet data has been updated." : "WARNING: The submitted data was unchanged from the original mark sheet.<br /> No data was saved.");				

			}

			else

			{

				$result = $this->db->query($this->Query_reader->get_query_by_code('add_multiple_marks', array('rows'=>$query_data)));

				$data['msg'] = format_notice(($result)? 'The mark sheet has been updated' : 'ERROR: The mark sheet could not be updated');

			}

		}

		else

		{

			$data['msg'] = format_notice('ERROR: An error occured while updating the marksheet');

		}

		

		$data['area'] = 'update_mark_sheet';

		

		$this->load->view('incl/addons', $data);		

	}

	

	

	#Function to manage the gradebook

	function manage_gradebook()

	{

		access_control($this);

		

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));

		

		# Pick all assigned data

		$data = assign_to_data($urldata);

		

		#Get subjects assigned to the teacher

		

		#Get the school terms

		$data['terms'] = $this->terms->get_terms('', ' AND startdate<"' . date("Y-m-d") . '"', 'DESC');



        #print_r($data['terms']);

		

		//Concatenate years to the terms for the user

		foreach($data['terms'] as $key => $termdetails)

		 $data['terms'][$key]['term'] = $data['terms'][$key]['term'].' ['.$termdetails['year'].']';

		 

		//get the subjects assigned to the teacher

		$data['subjects'] = $this->db->query($this->Query_reader->get_query_by_code('get_teacher_subjects', array('teacher'=> $this->session->userdata('userid'))))

		->result_array();

		 

		//get the current term info

		$data['current_term'] = current_term($this, $this->myschool['id']);

						

		$data = add_msg_if_any($this, $data);

		

		$this->load->view('gradebook/manage_gradebook_view', $data);

	}

	

	

	#Function to delete mark

	function delete_mark()

	{

		access_control($this);

		

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i', 't'));

		

		# Pick all assigned data

		$data = assign_to_data($urldata);

		

		$paper_details = get_db_object_details($this, 'subjectpapers', decryptValue($data['i']));

		

		if(!empty($data['i']))

			$result = deactivate_row($this, 'subjectpapers',decryptValue($data['i']));

		

		

		if(!empty($result) && $result)

		{

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

}



?>


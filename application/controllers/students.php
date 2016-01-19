<?php
#**************************************************************************************
# All student actions go through this controller
#**************************************************************************************

class Students extends CI_Controller {

	#Constructor to set some default values at class load
	public function __construct()
    {
		   parent::__construct();	
		$this->load->model('sys_email','sysemail');
		$this->load->model('term','terms');
		$this->load->model('class_mod','class_mod');
		$this->load->model('student','student_mod');
		$this->load->model('sponsor','sponsorobj');		
		date_default_timezone_set(SYS_TIMEZONE);
		$this->schoolinfo = $this->session->userdata('schoolinfo');
    }
	var $schoolinfo ;
    
    # Default to nothing
    function index()
    {
        #Do nothing
    }
    
	
	function save_student_leave()
	{
		access_control($this);
		
		# Get the passed details into the url data array if any
		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));
		
		# Pick all assigned data
		$data = assign_to_data($urldata);
		
		
		#Get the student details
		if($this->input->post('save'))
		{
            $required_fields = array('startdate', 'expectedreturndate', 'comments');
			$_POST = clean_form_data($_POST);
			$validation_results = validate_form('', $_POST, $required_fields);
                        			
            #Only proceed if the validation for required fields passes
			if($validation_results['bool'])
			{
				#Attach school and author to post data
				$_POST['school'] = $this->schoolinfo['id'];
				$_POST['author'] = $this->session->userdata('userid');
				
            	if(!empty($data['i']))
                {
					$admission_result = $this->student_mod->update_student_leave($_POST);
                }
                else
                {
					$admission_result = $this->student_mod->add_student_leave($_POST);				
                }
				
				if($admission_result)
				{
					$data['msg'] = "The student leave data has been saved.";
					$this->session->set_userdata('sres', $data['msg']);
		
					redirect(base_url()."students/manage_student_leave/m/sres");
                }
                else
                {
					$data['msg'] = "ERROR: The student leave was not saved. Please contact your administrator.";
                }
           	}#VALIDATION end
			
			
			if((empty($validation_results['bool']) || (!empty($validation_results['bool']) && !$validation_results['bool'])) 
			&& empty($data['msg']) )
			{
				$data['msg'] = "WARNING: The highlighted fields are required.";
			}
			
			$data['requiredfields'] = $validation_results['requiredfields'];
			
			#Get the student details		
			$data['studentdetails'] = $this->Query_reader->get_row_as_array('get_students_list', array('isactive' => 'Y', 'limittext' =>'','searchstring'=> ' AND id = '.$_POST['student'] ));
			
			$data['formdata'] = $_POST;
			
		}		
		
		$this->load->view('students/student_leave_form', $data);
	}
	
	#Function to load the student profile page
	function student_profile()
	{
		access_control($this);
		
		# Get the passed details into the url data array if any
		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i','a'));
		# Pick all assigned data
		$data = assign_to_data($urldata);

		#Get the school terms
		$data['terms'] = $this->terms->get_terms();
		//Concatenate years to the terms for the user
		foreach($data['terms'] as $key => $termdetails)
		 $data['terms'][$key]['term'] = $data['terms'][$key]['term'].' ['.$termdetails['year'].']';
		
		#Get the school classes
		$data['classes'] = $this->class_mod->get_classes();
		
		$data['sponsors'] = $this->sponsorobj->get_sponsors();
				
		#Get the school streams
                                
        #user is editing
		if(!empty($data['i']))
		{
			$studentid = decryptValue($data['i']);
			
			$data['studentdetails'] = $this->Query_reader->get_row_as_array('get_students_list', array('isactive' => 'Y', 'limittext' =>'','searchstring'=> ' AND id = '.$studentid ));
			
			#Check if the student belongs to the current user's school
			if($data['studentdetails']['school'] != $this->schoolinfo['id'])
				$data['studentdetails'] = array ();	
                        
            #Check if the user is simply viewing
            if(!empty($data['a']) && decryptValue($data['a']) == 'view')
            {
                $data['isview'] = "Y";
            }
		}
		
		#Test if user is loading just an include
		$view_to_load = (!empty($data['incl']) && decryptValue($data['incl']) == 'True')? 'students/student_profile_form' : 'students/student_profile_view' ;
		
		$this->load->view($view_to_load, $data);

	}
		
	
	
    #save Student data
	function save_student()
	{
		access_control($this);
		
		# Get the passed details into the url data array if any
		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));
		
		# Pick all assigned data
		$data = assign_to_data($urldata);
		
		$data = restore_bad_chars($data);
		
		#Get the student details
		if($this->input->post('save') || $data['save'])
		{
			if(empty($_POST)) $_POST = $data;
			
			if(!empty($data['i']))
			{
				$required_fields = array('firstname', 'lastname', 'dob', 'gender', 'admissionterm', 'admissionclass');
			}
			else
			{
				$required_fields = array('firstname', 'lastname', 'dob', 'gender', 'admissionterm', 'admissionclass', 'studentno');
			}            
			
			$_POST = clean_form_data($_POST);
			$validation_results = validate_form('', $_POST, $required_fields);
                        			
            #Only proceed if the validation for required fields passes
			if($validation_results['bool'])
			{
				#Attach school and author to post data
				$_POST['school'] = $this->schoolinfo['id'];
				$_POST['author'] = $this->session->userdata('userid');
				
            	if(!empty($data['i']))
                {
					$_POST['editid'] = decryptValue($data['i']);
					#check if student photo has changed
					if(!empty($_POST['photo']))
					{
						#move photo to designated folder and add value to query string						
						if(copy(UPLOAD_DIRECTORY."temp/".$_POST['photo'], UPLOAD_DIRECTORY."students/".$_POST['photo'])) 
						{								
							#move the thumb nail as well
							$temp_photo_arr = explode('.', $_POST['photo']);
							
							if(copy(UPLOAD_DIRECTORY."temp/".$temp_photo_arr[0].'_thumb.'.$temp_photo_arr[1], UPLOAD_DIRECTORY."students/".$temp_photo_arr[0].'_thumb.'.$temp_photo_arr[1]))
							{
								$_POST['UPDATESTRING'] = ',photo ="'.$_POST['photo'].'"';
								$admission_result = $this->student_mod->update_basic_student_data($_POST);
							}							
						}
					}
					else
					{
						$_POST['UPDATESTRING'] = '';
						$admission_result = $this->student_mod->update_basic_student_data($_POST);	
					}
                }
                else
                {
					$new_image_url = '';
					#check if student photo
					if(!empty($_POST['photo']))
					{
						#move photo to designated folder and add value to query string						
						if(copy(UPLOAD_DIRECTORY."temp/".$_POST['photo'], UPLOAD_DIRECTORY."students/".$_POST['photo'])) 
						{								
							#move the thumb nail as well
							$temp_photo_arr = explode('.', $_POST['photo']);
							
							if(copy(UPLOAD_DIRECTORY."temp/".$temp_photo_arr[0].'_thumb.'.$temp_photo_arr[1], UPLOAD_DIRECTORY."students/".$temp_photo_arr[0].'_thumb.'.$temp_photo_arr[1]))
							{
								$_POST['photo'] = $_POST['photo'];
								$admission_result = $this->student_mod->add_student($_POST);
							}							
						}
					}	
					else
					{
						$admission_result = $this->student_mod->add_student($_POST);
					}
					
					
					if($admission_result['result'])
					{
						#add sponsor info if any
						$sponsor_info = $this->sponsorobj->add_student_sponsor(array('sponsor'=>$_POST['sponsor'], 'author'=> $this->session->userdata('userid'), 'fromdate'=>'', 'todate'=>'', 'student'=>$admission_result['studentid']));
						
						#Register the student for a class as well
						//First format the data for the registration table
						$register['class'] = $_POST['admissionclass'];
						$register['term'] = $_POST['admissionterm'];
						$register['student'] = $admission_result['studentid'];
						$register['school'] = $this->schoolinfo['id'];
						$register['author'] = $_POST['author'];
						$register['stream'] = '';
						$register['subjects'] = '';
						//$registration_result = $this->student_mod->register_student($register);
					
						#Add the financial details as well
						/*if($registration_result)
						{
							#Get the applicable fees
							$applicable_fees = $this->class_mod->get_class_fees($_POST['admissionclass'], $_POST['admissionterm']);
						
							if(!empty($applicable_fees))
							{
								#Format the data for the multiple transactions query
								$transaction_data = '';
								foreach($applicable_fees as $fee)
								{
									if($transaction_data != '')
									{
										$transaction_data .= ', ('.$this->schoolinfo['id'].','.$admission_result['studentid'].','.$fee['id'].', "",'.
														 '"DEBIT", '.$this->session->userdata('userid').',"'.$fee['fee'].'", "'.$fee['amount'].'")';
									}
									else
									{
										$transaction_data .= '('.$this->schoolinfo['id'].','.$admission_result['studentid'].','.$fee['id'].', "",'.
														 '"DEBIT", '.$this->session->userdata('userid').',"'.$fee['fee'].'", "'.$fee['amount'].'")';
									}						
								}
							
								$admission_fees_result = $this->student_mod->add_student_transaction(array('fees' => $transaction_data), TRUE);
							}
						} */
						
						#Set back expected admission result type
						$admission_result = $admission_result['result'];
                	}					
                }
				
				if(!empty($admission_result) && $admission_result)
				{
					$data['msg'] = "The student data has been saved.";
					$this->session->set_userdata('sres', $data['msg']);
					$data['status'] = 'SUCCESS';
					$data['msg'] = $_POST['firstname'].' '.$_POST['lastname']. ((!empty($data['i']))? '\'s details have been updated' : ' has been added to the student register');
					
                }
                else
                {
					$data['status'] = 'FAIL';
					$data['msg'] = "ERROR: The student was not saved. Please contact your administrator.";
                }
           	}#VALIDATION end
			
			
			if((empty($validation_results['bool']) || (!empty($validation_results['bool']) && !$validation_results['bool'])) 
			&& empty($data['msg']) )
			{
				$data['msg'] = "WARNING: The highlighted fields are required.";
			}
			
			$data['requiredfields'] = $validation_results['requiredfields'];
			if($data['status'] == 'FAIL' || !empty($data['i'])) $data['studentdetails'] = $_POST;
			
			#Get the school terms
			$data['terms'] = $this->terms->get_terms();
			//Concatenate years to the terms for the user
			foreach($data['terms'] as $key => $termdetails)
		 		$data['terms'][$key]['term'] = $data['terms'][$key]['term'].' ['.$termdetails['year'].']';
		
			#Get the school classes
			$data['classes'] = $this->class_mod->get_classes();
			
		}	
		
		$this->load->view((!empty($data['i'])? 'incl/student_profile_form' : 'incl/student_form'), $data);
	}
	
	
	#function to add a students financial data on registration or admission
	function save_student_reg_admission_finances($data, $fee_type = 'ALL')
	{
		#Get the applicable fees
		$applicable_fees = $this->class_mod->get_class_fees($data['class'], $data['term'], $fee_type);
	
		if(!empty($applicable_fees))
		{
			#Format the data for the multiple transactions query
			$transaction_data = '';
			foreach($applicable_fees as $fee)
			{
				if($transaction_data != '')
				{
					$transaction_data .= ', ('.$this->schoolinfo['id'].','.$data['studentid'].','.$fee['id'].', "",'.
									 '"DEBIT", '.$this->session->userdata('userid').',"'.$fee['fee'].'", "'.$fee['amount'].'")';
				}
				else
				{
					$transaction_data .= '('.$this->schoolinfo['id'].','.$data['studentid'].','.$fee['id'].', "",'.
									 '"DEBIT", '.$this->session->userdata('userid').',"'.$fee['fee'].'", "'.$fee['amount'].'")';
				}						
			}
		
			return $this->student_mod->add_student_transaction(array('fees' => $transaction_data), TRUE);
		}	
		else
		{
			return 0;
		}
	}
	
	
	#function to load the leave form
	function load_leave_form()
	{
		access_control($this);
		
		# Get the passed details into the url data array if any
		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i','s'));
		
		# Pick all assigned data
		$data = assign_to_data($urldata);
		
		#Get the student details
		$studentid = decryptValue($data['s']);			
		$data['studentdetails'] = $this->Query_reader->get_row_as_array('get_students_list', array('isactive' => 'Y', 'limittext' =>'','searchstring'=> ' AND id = '.$studentid ));
			
		#Check if the student belongs to the current user's school
		if($data['studentdetails']['school'] != $this->schoolinfo['id'])
		$data['studentdetails'] = array ();		
                                
        #user is editing
		if(!empty($data['i']))
		{
			$leaveid = decryptValue($data['i']);
			
			$data['formdata'] = $this->Query_reader->get_row_as_array('search_leave_list', array('isactive' => 'Y', 'limittext' =>'','searchstring'=> ' AND id = '.$leaveid ));
			
			#Check if the leave record belongs to the current user's school
			if($data['formdata']['school'] != $this->schoolinfo['id'])
				$data['formdata'] = array ();	
                        
            #Check if the user is simply viewing
            if(!empty($data['a']) && decryptValue($data['a']) == 'view')
            {
                $data['isview'] = "Y";
            }
		}
		
		$this->load->view('students/student_leave_form', $data);

	}
		
	
	#Manage students
	function manage_students()
	{
		access_control($this);
		
		# Get the passed details into the url data array if any
		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));
		
		# Pick all assigned data
		$data = assign_to_data($urldata);
		


		# print_r($urldata['p']);
		#Get the paginated list of the students
		$schooldetails = $this->session->userdata('schoolinfo');

       
       if(!empty($urldata['p']))
       {

       	if(!empty($_SESSION['student_search_str']))
        {


            $searchstring = (!empty($_SESSION['student_search_str']['searchstring']))? $_SESSION['student_search_str']['searchstring'] : '' ;
            $phrase = (!empty($_SESSION['student_search_str']['phrase']))? $_SESSION['student_search_str']['phrase'] : '';
            $data = paginate_list($this, $data, 'search_students_by_term_and_class',
                array('isactive' => 'Y',
                    'searchstring'=>$searchstring,
                    'school'=> $this->schoolinfo['id'],
                    'lastname'=>$phrase,
                    'firstname'=>$phrase,
                    'studentno'=>$phrase,
                    'sponsorfirstname'=>$phrase,
                    'sponsorlastname'=>$phrase), 30);
          //  $_SESSION['student_search_str'] =  $searchstring;
        }
        else
        {
        	if($this->session->userdata('student_search_str')) {
	        $this->session->unset_userdata('student_search_str');
	        }
        	$data = paginate_list($this, $data, 'get_student_sponsor_list', array('isactive'=>'Y', 'searchstring'=>' AND students.school = '.$schooldetails['id']),30);

        }

       }
       else
       {
       	 if($this->session->userdata('student_search_str')) {
	        $this->session->unset_userdata('student_search_str');
	        }

       	$data = paginate_list($this, $data, 'get_student_sponsor_list', array('isactive'=>'Y', 'searchstring'=>' AND students.school = '.$schooldetails['id']),30);

       }
		#$data = paginate_list($this, $data, 'get_students_list', array('isactive'=>'Y', 'searchstring'=>' AND school = '.$schooldetails['id']),30);
      //  unset_userdata('student_search_str');
        #Show only results from user search if list has been searched
       /* if(!empty($_SESSION['student_search_str']))
        {
            $searchstring = (!empty($_SESSION['student_search_str']['searchstring']))? $_SESSION['student_search_str']['searchstring'] : '' ;
            $phrase = (!empty($_SESSION['student_search_str']['phrase']))? $_SESSION['student_search_str']['phrase'] : '';
            $data = paginate_list($this, $data, 'search_students_by_term_and_class',
                array('isactive' => 'Y',
                    'searchstring'=>$searchstring,
                    'school'=> $this->schoolinfo['id'],
                    'lastname'=>$phrase,
                    'firstname'=>$phrase,
                    'studentno'=>$phrase,
                    'sponsorfirstname'=>$phrase,
                    'sponsorlastname'=>$phrase), 30);
        }
        else
        { */
        //    $data = paginate_list($this, $data, 'get_student_sponsor_list', array('isactive'=>'Y', 'searchstring'=>' AND students.school = '.$schooldetails['id']),30);
       # }

		
		if(!count($data['page_list']))
		{
			$data['num_of_terms'] = count($this->terms->get_terms());
			$data['num_of_classes'] = count($this->class_mod->get_classes());
			#Test if students have not been added because there are no terms or classes
			if(!$data['num_of_terms'])
			{
				$data['msg'] = 'WARNING: No students have been admitted because <b>NO ACADEMIC TERMS</b> have been added';
				
				#Only school admins can add terms
				if($this->session->userdata('isschooladmin') == 'Y')
				 $data['msg'] .= '<br /> Click <i><a class="fancybox fancybox.ajax" href="'.base_url().'terms/load_term_form" >here</a></i> to add a term now';
			}
			elseif(!$data['num_of_classes'])
			{
				$data['msg'] = 'WARNING: No students have been admitted because <b>NO CLASSES</b> have been added';
				
				#Only school admins can add classes
				if($this->session->userdata('isschooladmin') == 'Y')
				 $data['msg'] .= '<br /> Click <i><a class="fancybox fancybox.ajax" href="'.base_url().'classes/load_class_form" >here</a></i> to add a class now';
			}
			else
			{
				$data['msg'] = 'WARNING: No students have been admitted. <br />'.
							   'Click <i><a class="fancybox fancybox.ajax" href="'.base_url().'students/load_student_form" >here</a></i> to add a student now';
			}
			
		}
		
		
		#Get the school terms
		$data['terms'] = $this->terms->get_terms();
		//Concatenate years to the terms for the user
		foreach($data['terms'] as $key => $termdetails)
		   $data['terms'][$key]['term'] = $data['terms'][$key]['term'].' ['.$termdetails['year'].']';
	
		#Get the school classes
		$data['classes'] = $this->class_mod->get_classes();
		
		$data['view_leave'] = FALSE;
		$data = add_msg_if_any($this, $data);
		

		$this->load->view('students/manage_students_view', $data);
	}
	
	#function to list a students leave details
	function student_leave_list()
	{
		access_control($this);
		
		# Get the passed details into the url data array if any
		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));
		
		# Pick all assigned data
		$data = assign_to_data($urldata);
		
		#Get the student details
		$studentid = decryptValue($data['i']);			
		$data['studentdetails'] = $this->Query_reader->get_row_as_array('get_students_list', array('isactive' => 'Y', 'limittext' =>'','searchstring'=> ' AND id = '.$studentid ));
		
		#Get the paginated list of the student's leave
		$data = paginate_list($this, $data, 'search_leave_list', array('isactive'=>'Y', 'searchstring'=>' AND student ='.$studentid),30);
		
		$data = add_msg_if_any($this, $data);
		$this->load->view('students/student_leave_list', $data);
	
	}
	
	#Manage students leave
	function manage_student_leave()
	{
		access_control($this);
		
		# Get the passed details into the url data array if any
		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));
		
		# Pick all assigned data
		$data = assign_to_data($urldata);
		
		#Get the paginated list of the students
		$schooldetails = $this->session->userdata('schoolinfo');
		$data = paginate_list($this, $data, 'search_students_leave_summary', array('isactive'=>'Y', 'school' =>$schooldetails['id'],'searchstring'=>''),30);
		
		if(!count($data['page_list']))
		{
			#Test if students have not been added because there are no terms
			if(!count($this->terms->get_terms()))
			{
				$data['msg'] = 'No students have been admitted because <b>NO ACADEMIC TERMS</b> have been added.';
				
				#Only school admins can add terms
				if($this->session->userdata('isschooladmin') == 'Y')
				 $data['msg'] .= '<br /> Click <i><a href="'.base_url().'terms/load_term_form" >here</a></i> to add a term now.';
			}
			
		}
		
		$data['view_leave'] = TRUE;
		$data = add_msg_if_any($this, $data);
		$this->load->view('students/manage_students_view', $data);
	}
	
	
	#Function to deactivate a student
	function delete_student()
	{
		access_control($this);
		
		# Get the passed details into the url data array if any
		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));
		# Pick all assigned data
		$data = assign_to_data($urldata);
		
		if(!empty($data['i']))
		{
			$result = deactivate_row($this, 'students', decryptValue($data['i']));
		}
		
		#Prepare appropriate message
		$msg = (!empty($result) && $result)? "The student data has been removed.": "ERROR: The student data could not be removed.";
		$this->session->set_userdata('sres', $msg);
		
		redirect(base_url()."students/manage_students/m/sres");
	}
	
	#function to search student financial data
    function get_student_finances_search()
    {
        access_control($this);

        # Get the passed details into the url data array if any
        $urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));

        # Pick all assigned data
        $data = assign_to_data($urldata);

       #FETCH  SEARCH DETAILS FROM FRONT END
        $result = explode('@@',$data['i']);
        $search  = $result[1];
        $start_date  =  (strlen($result[2]) > 0)?$result[2]:0;
        $end_date =   (strlen($result[3]) > 0)?$result[3]:0;
        $dat_string = '';
        #DATE SEARCH MANIPULATION STRING
        if(($start_date > 0) && ($end_date > 0) )
        {

            $dat_string='AND( dateadded >= "'.$start_date.'" AND dateadded <= "'.$end_date.'" )';

        }
        else if(($start_date > 0))
        {
            $dat_string= 'AND(dateadded >= "'.$start_date.'")';

        }
        else if ($end_date > 0)
        {
            $dat_string= 'AND(dateadded >= "'.$end_date.'")';

        }
        else{
            $dat_string = '';

        }


        #Get the student's details
        $studentid = decryptValue($result[0]);
        $data['studentdetails'] = $this->Query_reader->get_row_as_array('get_students_list', array('isactive' => 'Y', 'limittext' =>'','searchstring'=> ' AND id = '.$studentid ));
        #Check if the student belongs to the current user's school

        if($data['studentdetails']['school'] != $this->schoolinfo['id']){
            $data['studentdetails'] = array ();
            $studentid = '';
            $data['msg'] = 'ERROR : The student data could not be found.';
        }
        #Get the paginated list of the students finances with Search
        $data = paginate_list($this, $data, 'search_student_accounts', array('isactive'=>'Y', 'limittext'=>'', 'searchstring'=>' AND (amount like "%'.$search.'%" or type like "%'.$search.'%"  or payer like "%'.$search.'%") '.$dat_string.'  AND student = '.$studentid), 50);

        $data = add_msg_if_any($this, $data);

        #LOAD VIEW
        $this->load->view('students/student_finances_view_search', $data);

    }
	#function to get a students financial data
	function get_student_finances()
	{
		access_control($this);
		
		# Get the passed details into the url data array if any
		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));
		
		# Pick all assigned data
		$data = assign_to_data($urldata);

		#Get the student's details
		$studentid = decryptValue($data['i']);
        #find out whether student isactive or not and fetch data accordiginly::
        if(isset($data['m'])){
        $isactiv  =$data['m'];
        $isactiv=($isactiv == 'N' ) ? $isactiv : 'Y';
        }
        else
        {
            $isactiv = 'Y';
        }

		$data['studentdetails'] = $this->Query_reader->get_row_as_array('get_students_list', array('isactive' =>'Y', 'limittext' =>'','searchstring'=> ' AND id = '.$studentid ));
			
		#Check if the student belongs to the current user's school

		if(@$data['studentdetails']['school'] != $this->schoolinfo['id']){
				$data['studentdetails'] = array ();
				$studentid = '';
				$data['msg'] = 'ERROR : The student data could not be found.';
		}
		
		#Get the paginated list of the students finances

		@$data = paginate_list($this, $data, 'search_student_accounts', array('isactive'=>$isactiv, 'limittext'=>'', 'searchstring'=>' AND student = '.$studentid), 50);
				
		$data = add_msg_if_any($this, $data);
		$this->load->view('students/student_finances_view', $data);
		
		
	}
	
	#function to get students academics data in a year
    function get_student_academics_year($student = 0, $term_id = 0)
    {
        access_control($this);

        # Get the passed details into the url data array if any
        $urldata = $this->uri->uri_to_assoc(3, array('m', 'i', 'term'));

        # Pick all assigned data
        $data = assign_to_data($urldata);


        #Get the student's details
        $studentid = (($student>0)? $student : decryptValue($data['i']));

        if($term_id>0) $data['term'] = encryptValue($term_id);

        $data['studentdetails'] = $this->Query_reader->get_row_as_array('get_students_list', array('isactive' => 'Y', 'limittext' =>'','searchstring'=> ' AND id = '.$studentid ));

        #Get terms for which the student has been registered
        $data['academic_periods'] = $this->db->query("SELECT * FROM terms WHERE id IN (SELECT term FROM register WHERE student=".$studentid.") AND isactive='Y' ORDER BY year DESC")->
            result_array();

        $view_to_load = 'students/student_academics_view';

        if(!empty($data['term']))
        {
            $view_to_load = 'students/term_academic_info';

            #Get the term details
            $termid = decryptValue($data['term']);

            $data['termdetails'] = $this->Query_reader->get_row_as_array('search_terms_list', array('isactive' => 'Y', 'limittext' =>'','searchstring'=> ' AND id = '.$termid ));

            #Check if the student belongs to the current user's school
            if($data['studentdetails']['school'] != $this->schoolinfo['id']){
                $data['studentdetails'] = array ();
                $studentid = '';
                $data['msg'] = 'ERROR: The student data could not be found.';
            }
            else
            {
                #Get subjects the student has registered for in the selected term
                $data['registration_data'] =  $registration_data = $this->Query_reader->get_row_as_array('search_register', array('limittext'=>'', 'searchstring'=> 'student='.$studentid.' AND term ="'.$termid.'"'));

                //Get the applicable exams for selected term
                if(!empty($registration_data))
                {
                    $data['exams'] = $this->db->query($this->Query_reader->get_query_by_code('search_exams', array('limittext'=>'', 'searchstring'=> ' AND classes like "%'.$registration_data['class'].'%" AND term ="'.$termid.'" AND isactive="Y"')))
                        ->result_array();

                    //get the subject details
                    $subject_arr = remove_empty_indices(explode('|', $registration_data['subjects']));
                    #print_r($registration_data);
                    #exit();
                    if(!empty($subject_arr))
                        $data['subjects'] = $this->db->query($this->Query_reader->get_query_by_code('search_subjects', array('limittext'=>'', 'searchstring'=>' AND id IN ('.implode(',', $subject_arr).')', 'isactive'=>'Y')))
                            ->result_array();

                    //Get class of registration details
                    $data['classdetails'] = get_db_object_details($this, 'classes', $registration_data['class']);
                }
            }
        }

       #GET STUDENT DETAILS
        $std   =  decryptValue($data['i']);

        $data['std'] = $std ;
        #GET CALENDAR YEARS DETAILS
        $this ->load->model('calendar_year');
        $school_id = $this->schoolinfo['id'];

        $year_array  = $this->calendar_year ->fetch_calendar_year($school_id);
        $data['year_calendar'] =  $year_array;
        $data['schoolinfo'] =$this-> $schoolinfo;
        $data = add_msg_if_any($this, $data);

        #LOAD VIEW
        $this->load->view($view_to_load, $data);

    }

    # Information regarding subject Information
    function get_student_academics_subject($student = 0, $exam = 0)
    {
        access_control($this);
        $view_to_load = 'students/subject_academic_info';

        #View to Load
        $this ->load->model('marks_view');

        $urldata = $this->uri->uri_to_assoc(3, array('m', 'i', 'exam'));
        # Pick all assigned data
        $data = assign_to_data($urldata);
        #Get the student's details
        $studentid = (($student>0)? $student : decryptValue($data['i']));
        $data['studentid'] = $studentid;
        $data['studentdetails'] = $this->Query_reader->get_row_as_array('get_students_list', array('isactive' => 'Y', 'limittext' =>'','searchstring'=> ' AND id = '.$studentid ));



        $exam_array = explode('@@',$data['subject']);
        $exam = decryptValue($exam_array[1]);
        $subject = $exam_array[0];
        $school_id = $this->schoolinfo['id'];


        #function to recall Student Marks per Subject
        $data['mark_per_subject']  = $this->marks_view ->mark_per_exam($exam,$school_id,$subject,$studentid);

        $data = add_msg_if_any($this, $data);
        $this->load->view($view_to_load, $data);


    }
    #function to get students Academic data based on an Exam..

    function get_student_academics_exam($student = 0, $exam = 0)
    {

    access_control($this);
    $urldata = $this->uri->uri_to_assoc(3, array('m', 'i', 'exam'));
    # Pick all assigned data
    $data = assign_to_data($urldata);
    #Get the student's details
    $studentid = (($student>0)? $student : decryptValue($data['i']));
    $data['studentid'] = $studentid;
    // Select * from students where term is that and year is that ::

    $data['studentdetails'] = $this->Query_reader->get_row_as_array('get_students_list', array('isactive' => 'Y', 'limittext' =>'','searchstring'=> ' AND id = '.$studentid ));

    // Exam
    $exam = decryptValue($data['exam']);

    $exams  = $data['exams'] = $this->db->query($this->Query_reader->get_query_by_code('search_exams', array('limittext'=>'', 'searchstring'=> ' AND id = "'.$exam.'"  AND isactive="Y"')))->result_array();
    foreach($exams as $esam)
    {

        #Get subjects the student has registered for in the selected term
        $data['registration_data'] =  $registration_data = $this->Query_reader->get_row_as_array('search_register', array('limittext'=>'', 'searchstring'=> 'student='.$studentid.' AND term ="'.$esam['term'].'"'));
        break;
    }
    //Get the applicable exams for selected term
    if(!empty($registration_data))
    {
        $data['exams'] = $this->db->query($this->Query_reader->get_query_by_code('search_exams', array('limittext'=>'', 'searchstring'=> ' AND classes like "%'.$registration_data['class'].'%" AND id ="'.$exam.'" AND isactive="Y"')))  ->result_array();

        //get the subject details
        $subject_arr = remove_empty_indices(explode('|', $registration_data['subjects']));
        #print_r($registration_data);
        #exit();
        if(!empty($subject_arr))
            $data['subjects'] = $this->db->query($this->Query_reader->get_query_by_code('search_subjects', array('limittext'=>'', 'searchstring'=>' AND id IN ('.implode(',', $subject_arr).')', 'isactive'=>'Y')))
                ->result_array();

        //Get class of registration details
        $data['classdetails'] = get_db_object_details($this, 'classes', $registration_data['class']);
    }

    $data['schoolid']  = $this->session->userdata('schoolinfo');
    $view_to_load = 'students/exam_academic_info';

    $data = add_msg_if_any($this, $data);
        $school_id = $this->schoolinfo['id'];
        #  $year_array  = $this->calendar_year ->fetch_calendar_year($school_id);
        $data['schoolid']  = $this->session->userdata('schoolinfo');
        # $data['year_calendar'] =  $year_array;
        $data = add_msg_if_any($this, $data);
        $data = add_msg_if_any($this, $data);
        $this->load->view($view_to_load, $data);


}
    #function to get a students academic data in a given year :
    function get_student_academics_years($student = 0, $year = 0)
    {
        access_control($this);

        # Get the passed details into the url data array if any
        $urldata = $this->uri->uri_to_assoc(3, array('m', 'i', 'year'));

        # Pick all assigned data
        $data = assign_to_data($urldata);

        #Get the student's details
        $studentid = (($student>0)? $student : decryptValue($data['i']));
        $data['studentid'] = $studentid;

        // Select * from students where term is that and year is that ::

        $data['studentdetails'] = $this->Query_reader->get_row_as_array('get_students_list', array('isactive' => 'Y', 'limittext' =>'','searchstring'=> ' AND id = '.$studentid ));

        if(!empty($data['year']))
        {
        #Get terms for which the student has been registered

            // Student Details
            #Check if the student belongs to the current user's school
            if($data['studentdetails']['school'] != $this->schoolinfo['id']){
                $data['studentdetails'] = array ();
                $studentid = '';
                $data['msg'] = 'ERROR: The student data could not be found.';
            }

            else
            {
                if(!empty($data['year']))
                {
                    $data['termdetails'] = $this->db->query("SELECT * FROM terms WHERE id IN (SELECT term FROM register WHERE student=".$studentid.") AND isactive='Y' AND year= ".$year." ORDER BY term DESC")->  result_array();

                }


            }
        $view_to_load = 'students/student_academinc_info_yearly';


        }
       #ADDING ADDITIONAL INFORMATION
        $data['schoolid']  = $this->session->userdata('schoolinfo');
        $data = add_msg_if_any($this, $data);
        $data = add_msg_if_any($this, $data);
        $this->load->view($view_to_load, $data);

    }
    function write_xml() {
        // Load XML writer library
        $this->load->library('MY_Xml_writer');

        // Initiate class
        $xml = new MY_Xml_writer;
        $xml->setRootName('my_store');
        $xml->setXmlVersion('1.0');
        $xml->setCharSet('UTF-8');
        $xml->setIndentStr(' ');
        $xml->initiate();

        // Start branch 1
        $xml->startBranch('cars');

        // Set branch 1-1 and its nodes
        $xml->startBranch('car', array('country' => 'usa')); // start branch 1-1
        $xml->addNode('make', 'Ford');
        $xml->addNode('model', 'T-Ford', array(), true);
        $xml->endBranch();

        // Set branch 1-2 and its nodes
        $xml->startBranch('car', array('country' => 'Japan')); // start branch
        $xml->addNode('make', 'Toyota');
        $xml->addNode('model', 'Corolla', array(), true);
        $xml->endBranch();

        // End branch 1
        $xml->endBranch();

        // Start branch 2
        $xml->startBranch('bikes'); // start branch

        // Set branch 2-1  and its nodes
        $xml->startBranch('bike', array('country' => 'usa')); // start branch
        $xml->addNode('make', 'Harley-Davidson');
        $xml->addNode('model', 'Soft tail', array(), true);
        $xml->endBranch();

        // End branch 2
        $xml->endBranch();

        // Print the XML to screen
        $xml->getXml(true);
    }

	#function to get a students academic data
	function get_student_academics($student = 0, $term_id = 0,$year_id = 0)
	{
		access_control($this);


   #   $this ->  write_xml();
        #exit();
		# Get the passed details into the url data array if any
		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i', 'term'));
		
		# Pick all assigned data
		$data = assign_to_data($urldata);

		
		#Get the student's details
		$studentid = (($student>0)? $student : decryptValue($data['i']));

        if($term_id>0) $data['term'] = encryptValue($term_id);

		$data['studentdetails'] = $this->Query_reader->get_row_as_array('get_students_list', array('isactive' => 'Y', 'limittext' =>'','searchstring'=> ' AND id = '.$studentid ));

		#Get terms for which the student has been registered
		$data['academic_periods'] = $this->db->query("SELECT * FROM terms WHERE id IN (SELECT term FROM register WHERE student=".$studentid.") AND isactive='Y' ORDER BY year DESC")->
				result_array();

		$view_to_load = 'students/student_academics_view';
		
		if(!empty($data['term']))
		{
			$view_to_load = 'students/term_academic_info';

			#Get the term details
			$termid = decryptValue($data['term']);

			$data['termdetails'] = $this->Query_reader->get_row_as_array('search_terms_list', array('isactive' => 'Y', 'limittext' =>'','searchstring'=> ' AND id = '.$termid ));

			#Check if the student belongs to the current user's school
			if($data['studentdetails']['school'] != $this->schoolinfo['id']){
					$data['studentdetails'] = array ();
					$studentid = '';
					$data['msg'] = 'ERROR: The student data could not be found.';
			}
			else
			{
				#Get subjects the student has registered for in the selected term
				$data['registration_data'] =  $registration_data = $this->Query_reader->get_row_as_array('search_register', array('limittext'=>'', 'searchstring'=> 'student='.$studentid.' AND term ="'.$termid.'"'));
				
				//Get the applicable exams for selected term
				if(!empty($registration_data))
				{
					$data['exams'] = $this->db->query($this->Query_reader->get_query_by_code('search_exams', array('limittext'=>'', 'searchstring'=> ' AND classes like "%'.$registration_data['class'].'%" AND term ="'.$termid.'" AND isactive="Y"')))
								->result_array();
								
					//get the subject details
					$subject_arr = remove_empty_indices(explode('|', $registration_data['subjects']));
                    #print_r($registration_data);
                    #exit();
					if(!empty($subject_arr))
					$data['subjects'] = $this->db->query($this->Query_reader->get_query_by_code('search_subjects', array('limittext'=>'', 'searchstring'=>' AND id IN ('.implode(',', $subject_arr).')', 'isactive'=>'Y')))
										->result_array();
										
					//Get class of registration details
					$data['classdetails'] = get_db_object_details($this, 'classes', $registration_data['class']);
				}
			}
		}


	# Fetching  Calendar Years::
     #Get the student's details
      $std   =  decryptValue($data['i']);
      $data['std'] = $std ;
      $this ->load->model('calendar_year');
      $school_id = $this->schoolinfo['id'];
      $year_array  = $this->calendar_year ->fetch_calendar_year($school_id);
      $data['schoolid']  = $this->session->userdata('schoolinfo');
      $data['year_calendar'] =  $year_array;
	  $data = add_msg_if_any($this, $data);
       // print_r($view_to_load); exit();
       # print_r($view_to_load);
      $this->load->view($view_to_load, $data);
		
	}
	

	#function to load the registration form
	function load_registration_form()
	{
		access_control($this);

		
		# Get the passed details into the url data array if any
		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i','a'));
		
		# Pick all assigned data
		$data = assign_to_data($urldata);
		
		#Get the school terms
		$data['terms'] = $this->terms->get_terms();
		//Concatenate years to the terms for the user
		foreach($data['terms'] as $key => $termdetails)
		 $data['terms'][$key]['term'] = $data['terms'][$key]['term'].' ['.$termdetails['year'].']';
		
		#Get the school classes
		$data['classes'] = $this->class_mod->get_classes();
		
		#Get the school subjects
		$subjects = $this->db->query($this->Query_reader->get_query_by_code('search_subjects', array('isactive'=>'Y', 'limittext'=>'', 'searchstring'=>' AND school = '.$this->schoolinfo['id'])));;
		$data['subjects'] = $subjects->result_array();
		
		#Get the school streams
                                
        #user is editing
		if(!empty($data['i']))
		{
			$registrationid = decryptValue($data['i']);
			
			#Get the registration details
			$data['formdata'] = $this->Query_reader->get_row_as_array('search_register', array('isactive' => 'Y', 'limittext' =>'','searchstring'=> ' id = '.$registrationid ));
			
			#Check if the record belongs to the current user's school
			if($data['formdata']['school'] != $this->schoolinfo['id'])
				$data['formdata'] = array ();
			
			#Get the student details			
			$data['studentdetails'] = $this->Query_reader->get_row_as_array('get_students_list', array('isactive' => 'Y', 'limittext' =>'','searchstring'=> ' AND id = '.$data['formdata']['student'] ));
			
			#Check if the student belongs to the current user's school
			if($data['studentdetails']['school'] != $this->schoolinfo['id'])
				$data['studentdetails'] = array ();
			
            #Check if the user is simply viewing
            if(!empty($data['a']) && decryptValue($data['a']) == 'view')
            {
                $data['isview'] = "Y";
            }
		}
		else
		{
			#Get the student details
           echo " Reached ";
			$studentid = decryptValue($data['s']);
			
			$data['studentdetails'] = $this->Query_reader->get_row_as_array('get_students_list', array('isactive' => 'Y', 'limittext' =>'','searchstring'=> ' AND id = '.$studentid ));
			
			#Check if the student belongs to the current user's school
			if($data['studentdetails']['school'] != $this->schoolinfo['id'])
				$data['studentdetails'] = array ();
		}

		$this->load->view('students/registration_form_view', $data);
	}
	
	#Function to register a student to a class,term and subjects
	function register_student()
	{
		access_control($this);
		
		# Get the passed details into the url data array if any
		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i', 'student'));
		
		# Pick all assigned data
		$data = assign_to_data($urldata);	



		$data = restore_bad_chars($data);


        if(!empty($data['student']) && $data['student'] == 'true')
        {

            $required_fields = array('term', 'class', 'selected-reg-subjects');
            $data['regstudents'] = 'regstudents';
        }
        else
        {

            $required_fields = array('reg-term', 'reg-class', 'selected-reg-students');
        }

		if(!empty($data['regstudents']))
		{
			#print_r($data); exit();
            $_POST = clean_form_data($data);
			$validation_results = validate_form('', $_POST, $required_fields);
            			
            #Only proceed if the validation for required fields passes
			if($validation_results['bool'])
			{
				#Attach school, student and author to post data
				$_POST['school'] = $this->schoolinfo['id'];
				$_POST['author'] = $this->session->userdata('userid');				
								
				#Initialise error variables
				$registered_class = $registered_term = array();
				$err_string = '';
				
				#initialise result
				$result = FALSE;
				
            	if(!empty($data['i']))
                {
					$registerid = decryptValue($data['i']);
					
					#Check if the student has already been registered for the selected term in another record besides the current one
					$registered_term = $this->Query_reader->get_row_as_array('search_register', array('limittext'=>'', 'isactive' => 'Y','searchstring' => ' term = "'.$_POST['term'].'" AND student = '.$registerid.' '));
					
					#Also check if the student has already been registered for the selected class in another record besides the current one.	
					if(empty($registered_term))
					{
						$registered_class = $this->Query_reader->get_row_as_array('search_register', array('limittext'=>'', 'isactive' => 'Y','searchstring' => ' class = '.$_POST['class'].' AND student = '.$registerid.''));
					}
                    $_POST['subjects'] = '|' . str_replace(',', '|', $_POST['selected-reg-subjects']) . '|';
                    $_POST['editid'] = $registerid;
                    # at the moment no update..
					//$result = $this->student_mod->update_registration_details($_POST);
                    $result = $this->db->query($this->Query_reader->get_query_by_code('register_student', array('school'=>$_POST['school'],'student'=>$registerid,'term'=> $_POST['term'],'class'=>$_POST['class'],'stream'=>'','author'=>'','subjects'=>$_POST['selected-reg-subjects'])));

                }
                else
                {
					$selected_reg_students = explode('^', $_POST['selected-reg-students']);
					
					 $reg_query_data = '';
					
					#check if any of the students has been registered for the term
					if(!empty($selected_reg_students))
						{
						/*
						*@MOVER []
						* THE PRINCIPLE IS CHECKING INDIVIDUAL STUDENTS FOR EXISTANCE IN THE REGISTER TABLE
						* IF FOUND UPDATE OR CANCEL OR OTHERWISE REGISTER THEM :: 
						*/

						foreach ($selected_reg_students as $key => $record) {	
						 
							/*SEARCH FOR  EACH INDIVIDUAL STUDENT  EXISTANCE IN REGISTER :: 
							*/
						 $registered_students = $this->db->query($this->Query_reader->get_query_by_code('search_register', array('limittext'=>'', 'isactive' => 'Y','searchstring' => ' term = '.$_POST['reg-term'].' AND student = '.$record.'')))->result_array();

						 $ww = $this -> Query_reader->get_query_by_code('search_register', array('limittext'=>'', 'isactive' => 'Y','searchstring' => ' term = '.$_POST['reg-term'].' AND student = '.$record.''));
						
						//print_r($ww.'<br/> <hr/> <br/>');



						if(!empty($registered_students))
						 {
								 foreach($registered_students as $registered_student)
								 {
								  	$regid = $registered_student['id'];
								//  print_r($regid.'<br/>');
								  	//$registered_students = $this->db->query($this->Query_reader->get_query_by_code('update_register2', array('term'=>$_POST['reg-term'], 'class' => $_POST['reg-class'],'subjects' => $_POST['selected-reg-subjects'],'searchstring'=>'student ='.$regid.'')));
		   		  					$registered_students = $this->db->query($this->Query_reader->get_query_by_code('update_register', array('term'=>$_POST['reg-term'], 'class' => $_POST['reg-class'],'subjects' => $_POST['selected-reg-subjects'],'editid'=>$regid)));
   			 						$ss  = $this->Query_reader->get_query_by_code('update_register', array('term'=>$_POST['reg-term'], 'class' => $_POST['reg-class'],'subjects' => $_POST['selected-reg-subjects'],'editid'=>$regid));
								 //	print_r($ss.'<br/>');
								 }

							// $registered_students = $this->db->query($this->Query_reader->get_query_by_code('update_register', array('term'=>$_POST['reg-term'], 'class' => $_POST['reg-class'],'subjects' => $_POST['selected-reg-subjects'],'id'=>$regid)));
   			 				
						}
						else
						{
							#INSERT NEW REGISTRY
				         
						
							//save finances for each student
							$this->save_student_reg_admission_finances(array('class'=>$_POST['reg-class'], 'term'=>$_POST['reg-class'], 'studentid'=>$record));
							
							// $reg_query_data .= ($reg_query_data == '')? '('.$this->schoolinfo['id'].', '.$selected_reg_student.', '.$_POST['reg-term'].', '.$_POST['reg-class'].', 0, '.$this->session->userdata('userid').', "'.$_POST['selected-reg-subjects'].'")' : 
							// ', ('.$this->schoolinfo['id'].', '.$selected_reg_student.', '.$_POST['reg-term'].', '.$_POST['reg-class'].', 0, '.$this->session->userdata('userid').', "'.$_POST['selected-reg-subjects'].'")';
						 		
						
						$result = $this->db->query($this->Query_reader->get_query_by_code('register_student', array('SCHOOL'=>$this->schoolinfo['id'],'STUDENT'=>$record,'TERM'=>$_POST['reg-term'],'CLASS'=>$_POST['reg-class'],'AUTHOR'=>$this->session->userdata('userid'),'SUBJECTS'=> $_POST['selected-reg-subjects'])));					
						$ss =  $this->Query_reader->get_query_by_code('register_student', array('SCHOOL'=>$this->schoolinfo['id'],'STUDENT'=>$record,'TERM'=>$_POST['reg-term'],'CLASS'=>$_POST['reg-class'],'AUTHOR'=>$this->session->userdata('userid'),'SUBJECTS'=> $_POST['selected-reg-subjects']));
						//print_r($ss.'<br/>');
							#END .....
						}

						}
					}
						//exit();
						$registered_students = $this->db->query($this->Query_reader->get_query_by_code('search_register', array('limittext'=>'', 'isactive' => 'Y','searchstring' => ' term = '.$_POST['reg-term'].' AND student IN ('.implode(',', $selected_reg_students).')')))
									->result_array();									
										 
					if(!empty($registered_students))
					{
						# if not empty run an update
						$temp_selected_students_array = $selected_reg_students;
						//$regid = '';
						//sieve out already registered students
						//print_r($registered_students);
						//exit();
						$ss  ='';
						foreach($registered_students as $registered_student)
						{
							//$registered_student_info = get_db_object_details($this, 'students', $registered_student['student']);
						$regid = $registered_student['id'];
						//print_r($regid.'/n');
							$registered_students = $this->db->query($this->Query_reader->get_query_by_code('update_register', array('term'=>$_POST['reg-term'], 'class' => $_POST['reg-class'],'subjects' => $_POST['selected-reg-subjects'],'id'=>$regid)));
   			 				$ss  .= $this->Query_reader->get_query_by_code('update_register', array('term'=>$_POST['reg-term'], 'class' => $_POST['reg-class'],'subjects' => $_POST['selected-reg-subjects'],'searchstring'=>'id = '.$regid.''));
							
							// $err_string .= '<tr>'.
							// '<td width="1%"><a onclick="javascript:alert(/"mover/");" href="javascript:alert(\'sdsdsds\'); updateFieldLayer(\''.base_url().'students/student_profile/i/'.encryptValue($registered_student['student']).'\', \'\', \'\', \'contentdiv\', \'\');" title="Click to edit '.$registered_student_info['firstname'].'\'s details.">
							// <img src="'.base_url().'images/edit.png" border=0 /></a>
							// </td>
							// <td>'.$registered_student_info['firstname'].' '.$registered_student_info['lastname'].'</td>
							// </tr>';
							// $registered_student_key = array_search($registered_student['student'], $temp_selected_students_array);
							// if($registered_student_key !== FALSE)
							// 	unset($temp_selected_students_array[$registered_student_key]);
						}
					}
				}
			}
		}

// print_r($ss);
// 						// foreach($registered_students as $registered_student)
// 						// {
// 						// 	$regid = $registered_student['id'];
// 						// 	$registered_students = $this->db->query($this->Query_reader->get_query_by_code('update_register2', array('term'=>$_POST['reg-term'], 'class' => $_POST['reg-class'],'subjects' => $_POST['selected-reg-subjects'],'searchstring'=>'student ='.$regid.'')));
//    			//  				$ss  = $this->Query_reader->get_query_by_code('update_register2', array('term'=>$_POST['reg-term'], 'class' => $_POST['reg-class'],'subjects' => $_POST['selected-reg-subjects'],'searchstring'=>'student = '.$regid.''));
// 						// 	print_r($ss);
// 						// }
// 						//time to update 
// 						//$selected_reg_students = explode('^', $_POST['selected-reg-students']);
					
// 						 exit();

// 						// $err_string = '<table cellpadding="5" cellspacing="0">'.
// 						// 			  '<tr><td colspan="2">The following students have already been registered for the selected term. <br />Click the edit icon to update their registration details instead.</td></tr>';	
									  					 
						
						
// 						// $err_string .= '</table>';
						
// 						// $selected_reg_students = $temp_selected_students_array;						
						
// 						//register the selected students
// 						#Format data for the query
// 						$reg_query_data = '';
// 						foreach($selected_reg_students as $selected_reg_student)
// 						{
// 							//save finances for each student
// 							$this->save_student_reg_admission_finances(array('class'=>$_POST['reg-class'], 'term'=>$_POST['reg-class'], 'studentid'=>$selected_reg_student));
							
// 							$reg_query_data .= ($reg_query_data == '')? '('.$this->schoolinfo['id'].', '.$selected_reg_student.', '.$_POST['reg-term'].', '.$_POST['reg-class'].', 0, '.$this->session->userdata('userid').', "'.$_POST['selected-reg-subjects'].'")' : 
// 							', ('.$this->schoolinfo['id'].', '.$selected_reg_student.', '.$_POST['reg-term'].', '.$_POST['reg-class'].', 0, '.$this->session->userdata('userid').', "'.$_POST['selected-reg-subjects'].'")';
// 						}		
						
// 						$result = $this->db->query($this->Query_reader->get_query_by_code('register_many_students', array('rows'=>$reg_query_data)));						
					
												
// 					}		
// 					else
// 					{
// 						//register the selected students
// 						#Format data for the query
// 						$reg_query_data = '';
// 						foreach($selected_reg_students as $selected_reg_student)
// 						{
// 							//save finances for each student
// 							$this->save_student_reg_admission_finances(array('class'=>$_POST['reg-class'], 'term'=>$_POST['reg-class'], 'studentid'=>$selected_reg_student));
							
// 							$reg_query_data .= ($reg_query_data == '')? '('.$this->schoolinfo['id'].', '.$selected_reg_student.', '.$_POST['reg-term'].', '.$_POST['reg-class'].', 0, '.$this->session->userdata('userid').', "'.$_POST['selected-reg-subjects'].'")' : 
// 							', ('.$this->schoolinfo['id'].', '.$selected_reg_student.', '.$_POST['reg-term'].', '.$_POST['reg-class'].', 0, '.$this->session->userdata('userid').', "'.$_POST['selected-reg-subjects'].'")';
// 						}		
						
// 						$result = $this->db->query($this->Query_reader->get_query_by_code('register_many_students', array('rows'=>$reg_query_data)));					
// 					}			
							
//                 }
				
// 				if($result)
// 				{
// 					$data['msg'] = "Students' registration data has been updated.";

// 					if(!empty($err_string))
// 						$data['msg'] = "WARNING: ".$err_string;

//                     if(!empty($data['student']) && $data['student'] == 'true')
//                     {
//                         #registration_info
//                         $registration_info = $this->Query_reader->get_row_as_array('search_register', array('limittext'=>'', 'isactive' => 'Y','searchstring' => ' id ='.$registerid));

//                         $this->get_student_academics($registration_info['student'], $registration_info['term']);
//                         return;
//                     }
//                 }
//                 else
//                 {
// 					$data['msg'] = "ERROR: The student's registration data was not saved.<br />".$err_string;
//                 }
           	
           	#VALIDATION end
			$data['msg'] = "Record Updated Successfully ";
			
		// 	if((empty($validation_results['bool']) || (!empty($validation_results['bool']) && !$validation_results['bool'])) 
		// 	&& empty($data['msg']) )
		// 	{
		// 		$data['msg'] = "WARNING: The highlighted fields are required.";
		// 	}
			
		// 	$data['requiredfields'] = $validation_results['requiredfields'];
			
		// 	#Get the school terms
		// 	$data['terms'] = $this->terms->get_terms();
			
		// 	//Concatenate years to the terms for the user
		// 	foreach($data['terms'] as $key => $termdetails)
		//  		$data['terms'][$key]['term'] = $data['terms'][$key]['term'].' ['.$termdetails['year'].']';
		
		// 	#Get the school classes
		// 	$data['classes'] = $this->class_mod->get_classes();
		
		// 	#Get the school subjects
		// 	$subjects = $this->db->query($this->Query_reader->get_query_by_code('search_subjects', array('isactive'=>'Y', 'limittext'=>'', 'searchstring'=>' AND school = '.$this->schoolinfo['id'])));
			
		// 	$data['subjects'] = $subjects->result_array();
						
		// 	$data['formdata'] = $_POST;
			
		// }	
		
		
		$this->load->view('students/registration_results', $data);
	}
	
	#function to list the student's for registration
	function manage_student_register()
	{
		access_control($this);
		
		# Get the passed details into the url data array if any
		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));
		
		# Pick all assigned data
		$data = assign_to_data($urldata);
		
		#Get the paginated list of the students
		$schooldetails = $this->session->userdata('schoolinfo');
		$data = paginate_list($this, $data, 'get_students_list', array('isactive'=>'Y', 'searchstring'=>' AND school = '.$schooldetails['id']),30);
		
		$data['registering'] = TRUE;
		
		if(!count($data['page_list']))
		{
			#Test if students have not been added because there are no terms
			if(!count($this->terms->get_terms()))
			{
				$data['msg'] = 'No students have been admitted because <b>NO ACADEMIC TERMS</b> have been added.';
				
				#Only school admins can add terms
				if($this->session->userdata('isschooladmin') == 'Y')
				 $data['msg'] .= '<br /> Click <i><a href="'.base_url().'terms/load_term_form" >here</a></i> to add a term now.';
			}
			
		}
		$data['view_leave'] = FALSE;
		$data = add_msg_if_any($this, $data);
		$this->load->view('students/register_students_view', $data);

	}
	
	#Function to load the student data form
	function load_student_form()
	{
		access_control($this);
		
		# Get the passed details into the url data array if any
		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i','a'));
		# Pick all assigned data
		$data = assign_to_data($urldata);
		
		#Get the school terms
		$data['terms'] = $this->terms->get_terms();
		//Concatenate years to the terms for the user
		foreach($data['terms'] as $key => $termdetails)
		 $data['terms'][$key]['term'] = $data['terms'][$key]['term'].' ['.$termdetails['year'].']';
		
		#Get the school classes
		$data['classes'] = $this->class_mod->get_classes();
		
		#get the sponsors
		$data['sponsors'] = $this->sponsorobj->get_sponsors();
		
		#Get the school streams
                                
        #user is editing
		if(!empty($data['i']))
		{
			$studentid = decryptValue($data['i']);
			
			$data['studentdetails'] = $this->Query_reader->get_row_as_array('get_students_list', array('isactive' => 'Y', 'limittext' =>'','searchstring'=> ' AND id = '.$studentid ));
			
			#Check if the student belongs to the current user's school
			if($data['studentdetails']['school'] != $this->schoolinfo['id'])
				$data['studentdetails'] = array ();	
                        
            #Check if the user is simply viewing
            if(!empty($data['a']) && decryptValue($data['a']) == 'view')
            {
                $data['isview'] = "Y";
            }
		}
		
		$this->load->view('students/student_form_view', $data);
	}
	
	
	#Function to load the add student sponsor form
	function load_add_sponsor_form()
	{
		access_control($this);
		
		# Get the passed details into the url data array if any
		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i','a'));
		
		# Pick all assigned data
		$data = assign_to_data($urldata);
		
		#get the sponsors
		$data['sponsors'] = $this->sponsorobj->get_sponsors();
		
		#get the student info
		$data['student_info'] = get_db_object_details($this, 'students', decryptValue($data['m']));
                                
        #user is editing
		if(!empty($data['i']))
		{
			$sponsorshipid = decryptValue($data['i']);
			
			$data['formdata'] = $this->Query_reader->get_row_as_array('student_sponsors', array('limittext'=>'', 'orderby'=>'sponsors.firstname', 'searchstring' => ' AND sponsorshipid = ' . $sponsorshipid));
			 
            #Check if the user is simply viewing
            if(!empty($data['a']) && decryptValue($data['a']) == 'view')
            {
                $data['isview'] = "Y";
            }
		}
		
		$this->load->view('students/add_sponsor_form_view', $data);
	}
	
	
	#Function to save a student's sponsor details
	function save_student_sponsor()
	{
		access_control($this);
		
		# Get the passed details into the url data array if any
		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i', 'a', 't'));
		
		# Pick all assigned data
		$data = assign_to_data($urldata);		
		if($data['save'])
		{	
			$data['formdata'] = $data;		
            $required_fields = array('student', 'sponsor');
			
			foreach($data as $key => $data_value)
				$data[$key] = restore_bad_chars($data_value);
			
			$_POST = clean_form_data($data);
			$validation_results = validate_form('', $_POST, $required_fields);
			
			#get the student info
			$data['student_info'] = get_db_object_details($this, 'students', decryptValue($data['m']));
                        
			#Only proceed if the validation for required fields passes
			if($validation_results['bool'])
			{										
                if(!empty($data['editid']))
                {					
					$result = $this->sponsorobj->update_student_sponsor(array_merge($_POST, array('id'=> $data['editid'])));
           	  	}
			 	else 
             	{
					#check if the sponsorship details already exist
					$sponsorship_count = count($this->db->query($this->Query_reader->get_query_by_code('student_sponsors', array('orderby'=>'sponsorlastname', 'limittext'=>'', 'searchstring'=>' AND sponsor=' . $_POST['sponsor'] . ' AND sponsors.isactive="Y" AND student =' . decryptValue($_POST['student']))))->result_array());
					if(!$sponsorship_count)
					{					
						#Add the school id and author to the data array
						$_POST['student'] = decryptValue($_POST['student']);
						$_POST = array_merge($_POST, array('author' => $this->session->userdata('userid')));
							
						$result = $this->sponsorobj->add_student_sponsor($_POST);
					}
        		}
				
           		#Format and send the errors
            	if(!empty($result) && $result)
				{					
					$data['msg'] = (empty($data['editid']))? 'The sponsorship details have been saved ' : 'The sponsorship details have been updated.';
					$data['formdata'] = array();
            	 }
            	 else if(empty($data['msg']))
            	 {
					$formdata = $data;
				   	
					$data['msg'] = "ERROR: The sponsorship details could not be saved or was not saved correctly.".
									(($sponsorship_count)? "<br />The sponsor has already been added to " . $data['student_info']['firstname'] . '\'s sponsors.' : '');					
             	 }
            }
			
			$data['requiredfields'] = $validation_results['requiredfields'];
		}
		
		#get the sponsors
		$data['sponsors'] = $this->sponsorobj->get_sponsors();
        		
		$this->load->view('students/add_sponsor_form_view', $data);
	}
	
	
	# save transaction data
	function load_miscelleneous_form()
	{
		access_control($this);
		$schooldetails = $this->session->userdata('schoolinfo');
		
		# Get the passed details into the url data array if any
		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));
		
		/*foreach($urldata as $key => $val)
			echo "$key -> $val<br>";
		die(); */
		# Pick all assigned data
		$data = assign_to_data($urldata);
		
		#Get the Student details
		if(!empty($data['s']))
		{
			#$studentid = $data['s'];
			$studentid = decryptValue($data['s']);
			$data['studentdetails'] = $this->Query_reader->get_row_as_array('get_student_by_id', array('id'=>$studentid) );			
		}
		
		#Get the transaction details
		if(!empty($data['i']))
		{
			$editid = decryptValue($data['i']);
			$data['formdata'] = $this->Query_reader->get_row_as_array('get_miscelleneous_by_id', array('id'=>$editid) );	
		}
		
		#Check if the user is simply viewing the deal
		#TODO: Add the force-users-without-other-permissions-to-view condition
		if(!empty($data['a']) && decryptValue($data['a']) == 'view')
		{
			$data['isview'] = "Y";
		}
		
		if(!empty($data['u']) && decryptValue($data['u']) == 'update')
		{
			$save_result = $this->db->query($this->Query_reader->get_query_by_code('set_read', array_merge($_POST, array('id'=>$editid)) ));
		}
		
		if($this->input->post('savemiscelleneous')){
			
			$required_fields = array('subject','message');
			$validation_results = validate_form('', $_POST, $required_fields); 
			if($validation_results['bool'])
			{
				if(!empty($data['formdata']) && !empty($data['i']))
				{
					$save_result = $this->db->query($this->Query_reader->get_query_by_code('update_miscelleneous', array_merge($_POST, array('id'=>$editid)) ));
				}
				else
				{
					#die($this->Query_reader->get_query_by_code('add_miscelleneous', array_merge($_POST, array('school' => $schooldetails['id'], 'student' => $_POST['student'], 'author'=>$this->session->userdata('userid'))) ));
					$save_result = $this->db->query($this->Query_reader->get_query_by_code('add_miscelleneous', array_merge($_POST, array('school' => $schooldetails['id'], 'student' => $_POST['student'], 'author'=>$this->session->userdata('userid'))) ));
				}
				
				if($save_result)
				{
					$data['msg'] = "The message has been saved.";
					#die($data['msg']);
					$this->session->set_userdata('sres', $data['msg']);
					
					redirect(base_url()."students/manage_miscelleneous/m/sres");
				}
				else
				{
					$data['msg'] = "ERROR: The message was not saved. Please contact your administrator.";
					//die($data['msg']);
				}
			} #Validation
			
			if((empty($validation_results['bool']) || (!empty($validation_results['bool']) && !$validation_results['bool'])) 
			&& empty($data['msg']) )
			{
				$data['msg'] = "WARNING: The highlighted fields are required.";
			}
			
			$data['requiredfields'] = $validation_results['requiredfields'];
			$data['formdata'] = $_POST;
		}
		
		$this->load->view('students/miscelleneous_view',$data);
	}
	
	
	function manage_miscelleneous(){
		access_control($this);
				$schooldetails = $this->session->userdata('schoolinfo');
		
		# Get the passed details into the url data array if any
		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));
		# Pick all assigned data
		$data = assign_to_data($urldata);
		
		#Get the paginated list of the deals
		$data = paginate_list($this, $data, 'get_miscelleneous_list', array('isactive'=>'Y', 'searchstring'=>'1'));
		
		$data = add_msg_if_any($this, $data);
		$this->load->view('students/manage_miscelleneous_view', $data);
	}
	
	
	#Function to load upload a students photo
	function upload_student_photo()
	{
		access_control($this);
		
		#check if recover image has been specified
		if(!empty($_FILES['insert-image']['tmp_name']))
		{
			$_POST = clean_form_data($_POST);
			
			$new_file_url = 'ac_'.strtotime('now').generate_random_letter().".".end(explode('.', $_FILES['insert-image']['name']));
			if(copy($_FILES['insert-image']['tmp_name'], UPLOAD_DIRECTORY."students/".$new_file_url)) 
			{
				#Create a thumb nail as well
				$config['image_library'] = 'gd2';
				$config['source_image'] = UPLOAD_DIRECTORY."students/".$new_file_url;
				$config['create_thumb'] = TRUE;
				$config['maintain_ratio'] = TRUE;
				$config['width'] = 180;
				$config['height'] = 160;
				$this->load->library('image_lib', $config);
				$this->image_lib->resize();
				
				$temp_array = explode('.', $new_file_url);
				$data['msg'] = base_url()."academiaimages/students/".$temp_array[0].'_thumb.'.$temp_array[1];
			}
		}		
		
		if(empty($data['msg']))
				$data['msg'] = "ERROR";
		
		$data['area'] = 'upload_student_img';
		$this->load->view('incl/addons', $data);
	}

function delete_miscelleneous(){
		access_control($this);
		
		# Get the passed details into the url data array if any
		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));
		# Pick all assigned data
		$data = assign_to_data($urldata);
		
		$save_result = $this->db->query($this->Query_reader->get_query_by_code('delete_row', array('tname' => "miscelleneous",'id' => decryptValue($data['i'])) ));
				
				
		if($save_result)
		{
			$data['msg'] = "The item has been deleted.";
			//die($data['msg']);
			$this->session->set_userdata('sres', $data['msg']);
			
			redirect(base_url()."students/manage_miscelleneous/m/sres");
		}
		else
		{
			$data['msg'] = "ERROR: The item was not deleted. Please contact your administrator.";
			die($data['msg']);
		}
	}




    ##################################################################################################
    # THE BELOW FUNCTION HELP IN AJAX CHANGING OF DROP DOWNS ON ACADEMIC VIEW @MOVER
    ##################################################################################################


    #FETCH SUBJECTS THAT STUDENT REGISTERED FOR IN A GIVEN EXAM
    function fetch_subject_ajax()
    {


       $school_id = $this->schoolinfo['id'];
        $termid  = $this -> uri -> segment(3);
        $termid = decryptValue($termid);
        $this ->load->model('marks_view');
        $subject_array  = $this->marks_view ->fetchsubject($termid,$school_id);
        $ary = "";
        foreach($subject_array as $subject)
        {

            $ary = $subject['subjects'];
        }
        # EXPLODE SUBJECTS INTO ARRAY THEN LOOP
        $subjects = explode('|',$ary);
        $subject_adds ='';
        foreach($subjects as $subjecta)
        {
            $subjects  = $this->marks_view ->fetchsubjects($subjecta,$school_id);
            foreach($subjects as $subj)
            {
              $subject_adds  .=''.$subj['subject']."@@".$subj['id']."##";
            }
        }
        echo $subject_adds;




    }
    # FETCH EXAMS AJAX
    function fetch_exams_ajax()
    {
        $school_id = $this->schoolinfo['id'];
        #GET SEGMENT
        $examid  = $this -> uri -> segment(3);
        $examid = decryptValue($examid);
        #LOAD MODEL
        $this ->load->model('marks_view');

        $exam_array  = $this->marks_view ->fetchexams($examid,$school_id);
        $ary = "";
        foreach($exam_array as $exam)
        {
            $ary .= $exam['exam']."@@".encryptValue($exam['id'])."##";
        }

        echo $ary;

    }
    #FETCH TERMS AJAX
    function fetch_terms_ajax()
    {

        $school_id = $this->schoolinfo['id'];

        #GET SEGMENT
        $yearid  = $this -> uri -> segment(3);

        #LOAD MODEL
        $this ->load->model('marks_view');
        $year_array  = $this->marks_view ->fetchaterms($yearid,$school_id);
        $ary = "";
        foreach($year_array as $term)
        {
            $ary .= $term['term']."@@".encryptValue($term['id'])."##";
        }
        echo $ary;
    }
}
## END
?>
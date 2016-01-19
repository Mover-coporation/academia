<?php
#**************************************************************************************
# All finance actions go through this controller
#**************************************************************************************

class Finances extends CI_Controller {

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
    
	#Function to load the class data form
	function load_fee_form()
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
			$classid = decryptValue($data['i']);
			
			$data['feedetails'] = $this->Query_reader->get_row_as_array('search_fees_structure', array('isactive' => 'Y', 'limittext'=>'', 'searchstring' => ' AND id = '.$classid));
			
			$data['feedetails']['classes'] = remove_empty_indices(explode('|', $data['feedetails']['classes']));
			
			#Check if the term belongs to the current user's school
			if($data['feedetails']['school'] != $this->myschool['id'])
				$data['feedetails'] = array ();	
                        
            #Check if the user is simply viewing
            if(!empty($data['a']) && decryptValue($data['a']) == 'view')
            {
                $data['isview'] = "Y";
            }
		}
		
		$this->load->view('finances/fee_form_view', $data);
	}
	#function to load debit form
    function load_debit_form()
    {
        access_control($this);

        # Get the passed details into the url data array if any
        $urldata = $this->uri->uri_to_assoc(3, array('m', 'i','a', 's'));
        # Pick all assigned data
        $data = assign_to_data($urldata);

        $studentid = decryptValue($data['s']);

        #Get student details
        $data['studentdetails'] = $this->Query_reader->get_row_as_array('get_students_list', array('isactive' => 'Y', 'limittext'=>'', 'searchstring' => ' AND id = '.$studentid));

        #Get applicable fees structure
        //First get the students current class
        $student_class = current_class($this, $studentid);

        $fee_result = $this->db->query($this->Query_reader->get_query_by_code('search_fees_structure', array('isactive' => 'Y', 'limittext'=>'', 'searchstring' => ' AND classes like "%'.$student_class['classid'].'%"')));
        $data['fees']  = $fee_result->result_array();
        #user is editing
        //TO DO : NO EDITING ALLOWED FOR NOW
        /*if(!empty($data['i']))
        {
            $classid = decryptValue($data['i']);

            $data['feedetails'] = $this->Query_reader->get_row_as_array('search_fees_structure', array('isactive' => 'Y', 'limittext'=>'', 'searchstring' => ' AND id = '.$classid));

            $data['feedetails']['classes'] = remove_empty_indices(explode('|', $data['feedetails']['classes']));

            #Check if the term belongs to the current user's school
            if($data['feedetails']['school'] != $this->myschool['id'])
                $data['feedetails'] = array ();

            #Check if the user is simply viewing
            if(!empty($data['a']) && decryptValue($data['a']) == 'view')
            {
                $data['isview'] = "Y";
            }
        } */

        $this->load->view('finances/debit_form_view', $data);
    }
	#Function to load the class data form
	function load_credit_form()
	{
		access_control($this);
		
		# Get the passed details into the url data array if any
		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i','a', 's'));
		# Pick all assigned data
		$data = assign_to_data($urldata);
		
		$studentid = decryptValue($data['s']);
		
		#Get student details
		$data['studentdetails'] = $this->Query_reader->get_row_as_array('get_students_list', array('isactive' => 'Y', 'limittext'=>'', 'searchstring' => ' AND id = '.$studentid));
		
		#Get applicable fees structure
		//First get the students current class
		$student_class = current_class($this, $studentid);
		
		$fee_result = $this->db->query($this->Query_reader->get_query_by_code('search_fees_structure', array('isactive' => 'Y', 'limittext'=>'', 'searchstring' => ' AND classes like "%'.$student_class['classid'].'%"')));
		 $data['fees']  = $fee_result->result_array();                               
        #user is editing
		//TO DO : NO EDITING ALLOWED FOR NOW
		/*if(!empty($data['i']))
		{
			$classid = decryptValue($data['i']);
			
			$data['feedetails'] = $this->Query_reader->get_row_as_array('search_fees_structure', array('isactive' => 'Y', 'limittext'=>'', 'searchstring' => ' AND id = '.$classid));
			
			$data['feedetails']['classes'] = remove_empty_indices(explode('|', $data['feedetails']['classes']));
			
			#Check if the term belongs to the current user's school
			if($data['feedetails']['school'] != $this->myschool['id'])
				$data['feedetails'] = array ();	
                        
            #Check if the user is simply viewing
            if(!empty($data['a']) && decryptValue($data['a']) == 'view')
            {
                $data['isview'] = "Y";
            }
		} */
		
		$this->load->view('finances/credit_form_view', $data);
	}
	
	
	#function to save a transaction
	function save_transaction()
	{
		access_control($this);
		
		# Get the passed details into the url data array if any
		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i', 'a', 't'));
		
		# Pick all assigned data
		$data = assign_to_data($urldata);


		if($this->input->post('save'))
		{


			$data['formdata'] = $_POST;		
            $required_fields = array('fee', 'amount', 'payer');
			$_POST = clean_form_data($_POST);
			$validation_results = validate_form('', $_POST, $required_fields);
			$feename_error = '';
                        
			#set status as editing on destination if updating
            if($this->input->post('editid')) $data['editid'] = $_POST['editid'];

			#Only proceed if the validation for required fields passes
			if($validation_results['bool'] && !(empty($data['editid']) && !empty($user_details)))
			{   
                if($this->input->post('editid'))
                {	
					#Add the school id and author to the data array
					$_POST = array_merge($_POST, array('school'=> $this->myschool['id'], 'author' => $this->session->userdata('userid')));
												
					$result = $this->studentobj->update_student_transaction(array_merge($_POST, array('id'=> $data['editid'])));
           	  	}
			 	else 
             	{
					#Add the school id and author to the data array
					$_POST = array_merge($_POST, array('school'=> $this->myschool['id'], 'author' => $this->session->userdata('userid')));
						
					$result = $this->studentobj->add_student_transaction($_POST, FALSE);
        		}
				
           		#Format and send the errors
            	if(!empty($result) && $result)
				{					
					$this->session->set_userdata('usave', "The transaction has been successfully saved.");
					redirect("students/get_student_finances/i/".encryptValue($_POST['student'])."/m/usave");
            	 }
            	 else if(empty($data['msg']))
            	 {
				   	$data['msg'] = "ERROR: The transaction could not be saved or was not saved correctly.";					
             	 }
            }
            
			#Prepare a message in case the user already exists for another school
			/*else if(empty($data['editid']) && !empty($fee_details))
			{
				 #$addn_msg = (!empty($user_details['isactive']) && $user_details['isactive'] == 'N')? "<a href='".base_url()."admin/load_user_form/i/".encryptValue($user_details['id'])."/a/".encryptValue("reactivate")."' style='text-decoration:underline;font-size:17px;'>Click here to  activate and  edit</a>": "<a href='".base_url()."admin/load_user_form/i/".encryptValue($user_details['id'])."' style='text-decoration:underline;font-size:17px;'>Click here to edit</a>";
				 
				 $data['msg'] = "WARNING: A fee with the same name already exists.<br />"; 
			}*/
			             
            if((empty($validation_results['bool']) || (!empty($validation_results['bool']) && !$validation_results['bool'])) 
			&& empty($data['msg']) )
			{
				$data['msg'] = "WARNING: The highlighted fields are required.";
			}
			
			$data['requiredfields'] = $validation_results['requiredfields'];
		}		
		
        #Get applicable fees structure
		//First get the students current class
		$student_class = current_class($this, $_POST['student']);
		
		$fee_result = $this->db->query($this->Query_reader->get_query_by_code('search_fees_structure', array('isactive' => 'Y', 'limittext'=>'', 'searchstring' => ' AND classes like "%'.$student_class['classid'].'%"')));
		 $data['fees']  = $fee_result->result_array();  
		
		#Get student details
		$data['studentdetails'] = $this->Query_reader->get_row_as_array('get_students_list', array('isactive' => 'Y', 'limittext'=>'', 'searchstring' => ' AND id = '.$_POST['student']));

		//$this->load->view('finances/credit_form_view', $data);
        //var_dump($data);
        echo "1";
	}
	
	
	#Function to save a fee
	function save_fee()
	{
		access_control($this);
		
		# Get the passed details into the url data array if any
		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i', 'a', 't'));
		# Pick all assigned data
		$data = assign_to_data($urldata);		
		
		if($this->input->post('save'))
		{ 
			$data['feedetails'] = $_POST;		
            $required_fields = array('fee', 'amount','classes*COMBOBOX', 'frequency','term');
			$_POST = clean_form_data($_POST);
			$validation_results = validate_form('', $_POST, $required_fields);
			$feename_error = '';
                        
			#set status as editing on destination if updating
            if($this->input->post('editid')) $data['editid'] = $_POST['editid'];			
			
			#Only proceed if the validation for required fields passes
			if($validation_results['bool'] && !(empty($data['editid']) && !empty($user_details)))
			{   
                if($this->input->post('editid'))
                {
					#Check if another fee other than the current one exists with the same name for the same term
					$fee_details  = $this->Query_reader->get_row_as_array('search_fees_structure', array('limittext' => '', 'isactive' => 'Y', 'searchstring' => ' AND term = "'.$data['feedetails']['term'].'" AND fee = "'.$data['feedetails']['fee'].'" AND id != '.$data['editid'].' AND school ='.$this->myschool['id']));
										
					if(empty($fee_details))
					{
						#Add the school id and author to the data array
						$_POST = array_merge($_POST, array('school'=> $this->myschool['id'], 'author' => $this->session->userdata('userid')));
						
						#Convert classes into strings
						$_POST['classes'] = stringify_array($_POST['classes'], '|');
						
						$result = $this->financeobj->update_fee(array_merge($_POST, array('id'=> $data['editid'])));
					}
					else
					{
						if (!empty($class_details)) $feename_error = "<br />WARNING: A fee with the same name for the same term already exists.";
					}
           	  	}
			 	else 
             	{
					#Check if fee name exists for the selected term 
					$fee_details  = $this->Query_reader->get_row_as_array('search_fees_structure', array('limittext' => '', 'isactive' => 'Y', 'searchstring' => ' AND term = "'.$data['feedetails']['term'].'" AND fee = "'.$data['feedetails']['fee'].'"'));
								                        
                	if(empty($fee_details))
                	{
						#Add the school id and author to the data array
						$_POST = array_merge($_POST, array('school'=> $this->myschool['id'], 'author' => $this->session->userdata('userid')));
						
						#Convert classes into strings
						$_POST['classes'] = stringify_array($_POST['classes'], '|');
						
						$result = $this->financeobj->add_fee($_POST );
					}
					else
					{
						if (!empty($fee_details)) 
							$feename_error = "<br />WARNING: A fee with the same name for the selected term already exists.";
					}
        		}
				
           		#Format and send the errors
            	if(!empty($result) && $result)
				{					
					$this->session->set_userdata('usave', "The fee data has been successfully saved.");
					redirect("finances/manage_fee_structure/m/usave");
            	 }
            	 else if(empty($data['msg']))
            	 {
				   	$data['msg'] = "ERROR: The fee could not be saved or was not saved correctly.".$feename_error;
             	 }
            }
            
			#Prepare a message in case the user already exists for another school
			else if(empty($data['editid']) && !empty($fee_details))
			{ 
				 $data['msg'] = "WARNING: A fee with the same name already exists.<br />"; 
			}
			             
            if((empty($validation_results['bool']) || (!empty($validation_results['bool']) && !$validation_results['bool'])) 
			&& empty($data['msg']) )
			{
				$data['msg'] = "WARNING: The highlighted fields are required.";
			}
			
			$data['requiredfields'] = $validation_results['requiredfields'];
		}		
        $data['classes'] = $this->classobj->get_classes(); 
		
		$data['terms'] = $this->terms->get_terms();
                
		$this->load->view('finances/fee_form_view', $data);
	}
	
	#Function to view student account summaries
	function student_accounts_overview()
	{
		access_control($this);
		
		# Get the passed details into the url data array if any
		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));
		
		# Pick all assigned data
		$data = assign_to_data($urldata);
		
		#Get the paginated list of the student accounts overview
		$data = paginate_list($this, $data, 'student_accounts_overview', array('school'=> $this->myschool['id']), 50);
				
		$data = add_msg_if_any($this, $data);
		$this->load->view('finances/student_accounts_overview', $data);
	}
	
	#Function to manage classes
	function manage_fee_structure()
	{
		access_control($this);
		
		# Get the passed details into the url data array if any
		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));
		
		# Pick all assigned data
		$data = assign_to_data($urldata);
		
		#Get the paginated list of the students
		$data = paginate_list($this, $data, 'search_fees_structure', array('isactive'=>'Y', 'searchstring'=>' AND school = '.$this->myschool['id']));
				
		$data = add_msg_if_any($this, $data);
		$this->load->view('finances/manage_fees_structure', $data);
	}
	
	
	#Function to view school accounts
	function school_accounts()
	{
		access_control($this);
		
		# Get the passed details into the url data array if any
		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));
		
		# Pick all assigned data
		$data = assign_to_data($urldata);
		
		#Get the paginated list of the school accounts
		$data = paginate_list($this, $data, 'school_accounts_overview', array('isactive'=>'Y', 'school'=>$this->myschool['id'], 'searchstring'=>''));
				
		$data = add_msg_if_any($this, $data);
		$this->load->view('finances/school_accounts_view', $data);
	}
	
	
	#Function to manage finances
	function manage_finances()
	{
		access_control($this);
		
		# Get the passed details into the url data array if any
		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));
		
		# Pick all assigned data
		$data = assign_to_data($urldata);
		
		#Get the paginated list of the students
		$data = paginate_list($this, $data, 'search_fees_structure', array('isactive'=>'Y', 'searchstring'=>' AND school = '.$this->myschool['id']));
				
		$data = add_msg_if_any($this, $data);
		$this->load->view('finances/manage_finances_view', $data);
	}
	
	
	#function to print out a students statement
	function print_student_statement()
	{
		access_control($this);
		
		# Get the passed details into the url data array if any
		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));
		
		# Pick all assigned data
		$data = assign_to_data($urldata);
		
		#Get the student's details
		$studentid = decryptValue($data['i']);
		$data['studentdetails'] = $this->Query_reader->get_row_as_array('get_students_list', array('isactive' => 'Y', 'limittext' =>'','searchstring'=> ' AND id = '.$studentid ));
			
		#Check if the student belongs to the current user's school
		if($data['studentdetails']['school'] != $this->myschool['id']){
				$data['studentdetails'] = array ();
				$studentid = '';
				$data['msg'] = 'ERROR : The student data could not be found.';
		}
		
		#Get student's finances
		$query = $this->Query_reader->get_query_by_code('search_student_accounts', array('isactive'=>'Y', 'limittext'=>'', 'searchstring'=>' AND student = '.$studentid));
		$query_results = $this->db->query($query);
		$financial_details = $query_results->result_array();
		
		#Format the statement
		$report_html = '';
		#$financial_details = array();
		if(!empty($financial_details))
		{
			$report_html = "<table width='100%' border='0' cellspacing='0' cellpadding='5'>
          		 `			<tr>
				 				<td class='listheader'>Date</td>
           		 				<td class='listheader' nowrap>Particulars</td>
				 				<td class='listheader' nowrap align='right'>Debit</td>
				 				<td class='listheader' nowrap align='right'>Credit</td>
           		 				<td class='listheader' nowrap align='right'>Balance</td>
				 		    </tr>";	
	
			$counter = 0;
			$balance = 0;
			$total_debit = 0;
			$total_credit = 0;
	
			foreach($financial_details AS $row)
			{		
				#Show one row at a time
				if($row['type'] == 'DEBIT'){
					$debit = $row['amount'];
					$credit = 0;
					$balance -= $debit;
					$total_debit += $debit;
				}
				else
				{
					$debit = 0;
					$credit = $row['amount'];
					$balance += $credit;
					$total_credit += $credit;
				}
		
				$fee = get_fee_lines($this, $row['fee']);
		
				$report_html .= "<tr style='".get_row_color($counter, 2)."'>		
		 						<td valign='top'>".date("j M, Y", GetTimeStamp($row['dateadded']))."</td>
								<td valign='top'>".$fee['fee']."</td>		
								<td valign='top' nowrap align='right'>".number_format($debit,0,'.',',')."</td>
								<td valign='top' nowrap align='right'>".number_format($credit,0,'.',',')."</td>				
								<td valign='top' nowrap align='right'>".number_format($balance,0,'.',',')."</td>	
								</tr>";
		
				$counter++;
			}
	
			$report_html .= "<tr>
		  					<td colspan='2'></td>
		  					<td nowrap align='right'><div>".number_format($total_debit,0,'.',',')."</div></td>
		  					<td nowrap align='right'><div>".number_format($total_credit,0,'.',',')."</div></td>
		  					<td style='padding-right:0' nowrap align='right'><div class='sum'>".number_format(-($total_debit - $total_credit),0,'.',',')."</div></td>
		 					</tr></table>";

			}
			else
			{
				$report_html .= "<div>No transactions have been added.</div";
			}
			
			$this->load->library('parser');  
			$data['report_html'] = $report_html;     
        	$output = $this->parser->parse('incl/print_data', $data, true);
            
			gen_pdf($this, $output);
			#$this->load->view('incl/print_data', $data);		
	}
	
	#function to print a transaction
	function print_transaction()
	{
		# Get the passed details into the url data array if any
		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));
		
		# Pick all assigned data
		$data = assign_to_data($urldata);
		
		#Get the transaction data
		$transactionid = decryptValue($data['i']);
		$transaction_details = $this->Query_reader->get_row_as_array('search_student_accounts', array('isactive' => 'Y', 'limittext' =>'','searchstring'=> ' AND id = '.$transactionid ));
		$data['transaction'] = $transaction_details;
		
		#Get the student's details
		$data['studentdetails'] = $this->Query_reader->get_row_as_array('get_students_list', array('isactive' => 'Y', 'limittext' =>'','searchstring'=> ' AND id = '.$transaction_details['student'] ));
		
		#Get the author details
		$data['author'] = $this->Query_reader->get_row_as_array('search_school_users', array('isactive' => 'Y', 'limittext' =>'','searchstring'=> ' AND id = '.$transaction_details['author'] ));
		
		#Get the fee lines
		$data['feedetails'] = $this->Query_reader->get_row_as_array('search_fees_structure', array('isactive' => 'Y', 'limittext' =>'','searchstring'=> ' AND id = '.$transaction_details['fee'] ));
		
		#Check if the student belongs to the current user's school
		if($data['studentdetails']['school'] != $this->myschool['id']){
				$data = array ();
				$studentid = '';
				$data['msg'] = 'ERROR : The student data could not be found.';
		}
		
		
		#Format the statement
		$report_html = '';
		#$financial_details = array();
			
		$this->load->library('parser');  
		$data['report_html'] = $report_html;     
        $output = $this->parser->parse('incl/transaction',$data,true);
            
		gen_pdf($this, $output);
		#$this->load->view('incl/print_data', $data);
	}
	
	#Function to delete a fee
	function delete_fee()
	{
		access_control($this);
		
		# Get the passed details into the url data array if any
		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i', 't'));
		
		# Pick all assigned data
		$data = assign_to_data($urldata);
		
		if(!empty($data['i']))
			$result = deactivate_row($this, 'fee_structure',decryptValue($data['i']));
		
		
		if(!empty($result) && $result){
			$this->session->set_userdata('dfee', "The fee has been successfully deleted.");
		}
		else if(empty($data['msg']))
		{
			$this->session->set_userdata('dfee', "ERROR: The fee could not be deleted or was not deleted correctly.");
		}
		
		if(!empty($data['t']) && $data['t'] == 'super'){
			$tstr = "/t/super";
		}else{
			$tstr = "";
		}
		redirect("finances/manage_fee_structure/m/dfee".$tstr);
	}
	
	#Function to manage petty cash book
	function manage_petty_cash_book() 
	{
		access_control($this);
		
		# Get the passed details into the url data array if any
		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));
		
		# Pick all assigned data
		$data = assign_to_data($urldata);
		
		#Get the paginated list of the students
		$data = paginate_list($this, $data, 'search_account_transactions', array('searchstring'=>' isactive = "Y" AND account IN (SELECT id FROM accounts WHERE school = '. $this->myschool['id'] .')'));
				
		$data = add_msg_if_any($this, $data);
		
		$this->load->view('finances/manage_petty_cash_book', $data);
	}
  
	#function add a new account
	function add_school_account() 
	{
	   	$sql = "SELECT max(account_id) as id from school_accounts";
		$query = $this->db->query($sql);
		$row = $query->row();
		$account = $this->input->post('account');
		$purpose = $this->input->post('purpose');
		$dbdata = array(
		  'account_id'=>($row->id+1),
		  'account_name' => $account,
		  'purpose' => $purpose
		);
		$this->db->insert('school_accounts', $dbdata);
		$data['data'] = "$row->id";
		$this->load->view('finances/petty_response', $data);
	}
  
	#Function to collect spend data
	function load_transaction_form() 
	{
		access_control($this);
		
		# Get the passed details into the url data array if any
		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i','a', 'tt'));
		
		# Pick all assigned data
		$data = assign_to_data($urldata);	
		
		#get the accounts
		$data['accounts'] = $this->db->query($this->Query_reader->get_query_by_code('search_accounts', array('isactive' => 'Y', 'limittext'=>'', 'searchstring' => ' AND isactive="Y" AND school = '.$this->myschool['id'])))
							->result_array();
                                
        #user is editing
		if(!empty($data['i']))
		{
			$transactionid = decryptValue($data['i']);
			
			$data['transactiondetails'] = $this->Query_reader->get_row_as_array('search_account_transactions', array('isactive' => 'Y', 'limittext'=>'', 'searchstring' => ' AND id = '.$transactionid));
			                        
            #Check if the user is simply viewing
            if(!empty($data['a']) && decryptValue($data['a']) == 'view')
            {
                $data['isview'] = "Y";
            }
		}
		
		$this->load->view('finances/petty_cash_transaction_form_view', $data);
	}
  
	function load_account_form() 
	{
		access_control($this);
		
		# Get the passed details into the url data array if any
		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i','a'));
		
		# Pick all assigned data
		$data = assign_to_data($urldata);	
		                      
        #user is editing
		if(!empty($data['i']))
		{
			$transactionid = decryptValue($data['i']);
			
			$data['accountdetails'] = $this->Query_reader->get_row_as_array('search_account_transactions', array('isactive' => 'Y', 'limittext'=>'', 'searchstring' => ' AND id = '.$transactionid));
			                        
            #Check if the user is simply viewing
            if(!empty($data['a']) && decryptValue($data['a']) == 'view')
            {
                $data['isview'] = "Y";
            }
		}
		
		$this->load->view('finances/load_account_form_view', $data);
	}
	
	
	#Function to save account
	function save_account() 
	{
		access_control($this);
		
		# Get the passed details into the url data array if any
		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i', 'a'));
		
		# Pick all assigned data
		$data = assign_to_data($urldata);	
		
		$data = restore_bad_chars($data);	
		
		if($data['save'])
		{ 
			$data['transactiondetails'] = $data;		
            $required_fields = array('title');
			$_POST = clean_form_data($data);
			$validation_results = validate_form('', $_POST, $required_fields);
                        
			#set status as editing on destination if updating
            if($this->input->post('editid')) $data['editid'] = $_POST['editid'];			
			
			#Only proceed if the validation for required fields passes
			if($validation_results['bool'])
			{   
				$title_error = '';
				
                if(!empty($_POST['editid']))
                {
					#Add the school id and author to the data array
					$_POST = array_merge($_POST, array('school'=> $this->myschool['id'], 'author' => $this->session->userdata('userid')));
					
					$result = $this->financeobj->update_petty_cash_transction(array_merge($_POST, array('id'=> $data['editid'])));
           	  	}
			 	else 
             	{ 
					#check if an account with a similar title exists
					$similar_accounts = $this->db->query($this->Query_reader->get_query_by_code('search_accounts', array('isactive' => 'Y', 'limittext'=>'', 'searchstring' => ' AND isactive="Y" AND title = "' . $_POST['title'] . '" AND school = '.$this->myschool['id'])))
							->result_array();
				
					if(!count($similar_accounts))
					{
						#Add author, type and other info to the data array
						$_POST = array_merge($_POST, array('school'=> $this->myschool['id'], 'author' => $this->session->userdata('userid')));
						
						$result = $this->financeobj->save_account($_POST);
					}
					else
					{
						$title_error = "An account with a similar name already exists";
					}					
        		}
				
           		#Format and send the errors
            	if(!empty($result) && $result)
				{					
					$data['msg'] = "The account data has been successfully created.";
					$data['transactiondetails'] = array();
            	 }
            	 else if(empty($data['msg']))
            	 {
				   	$data['msg'] = "ERROR: The account could not be saved or was not saved correctly. <br />".$title_error;
             	 }
            }
            			             
            if((empty($validation_results['bool']) || (!empty($validation_results['bool']) && !$validation_results['bool'])) 
			&& empty($data['msg']) )
			{
				$data['msg'] = "WARNING: The highlighted fields are required.";
			}
			
			$data['requiredfields'] = $validation_results['requiredfields'];
		}		
         
                
		$this->load->view('finances/load_account_form_view', $data);
	}
	
  
	#Function to load petty cash transaction
	function petty_cash_transaction_form_view() 
	{
		$query = $this->db->get('school_accounts');
		$result = $query->num_rows();
		$data['rows'] = $result;
		$data['data'] = $query->result_array();
		$this->load->view('finances/replenish_form_view', $data);
	}
  
	#Function to get petty cash transactions
	function get_petty_cash_book() 
	{
		access_control($this);
	
		# Get the passed details into the url data array if any
		//$urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));
		# Pick all assigned data
		//$data = assign_to_data($urldata);
		//$data = add_msg_if_any($this, $data);      
		$petty_from = $this->convertDate($this->input->post('petty-from'));
		$petty_to = $this->convertDate($this->input->post('petty-to'));
		$sql = "SELECT * FROM academia.accounts WHERE account_id=1 AND date>='" . $petty_from . "' and date<='" . $petty_to . "'";
		$query = $this->db->query($sql);
		$data['data'] = $query->result_array();
		$sql = 'SELECT account_id, account_name from school_accounts';
		$query = $this->db->query($sql);
		$data['accounts'] = $query->result_array();
		$account_id = '1';
		$cf = 0;
		$data['opening'] = $this->get_balance_on_day($account_id, $petty_from, $cf);
		$cf = 1;
		$data['closing'] = $this->get_balance_on_day($account_id, $petty_to, $cf);
		$this->load->view('finances/get_petty_cash_book', $data);
	}
  
	#get balances
	function get_balance_on_day($account, $day, $cf) 
	{
		access_control($this);
	
		if ($cf == 1) {
		  $day = "('" . $day . "' + INTERVAL 1 DAY)";
		}
		else {
		  $day = "('" . $day . "' + INTERVAL 0 DAY)";
		}
		$sql = "SELECT cr_dr,SUM(amount) as total from accounts where account_id=" . $account . " and date<" . $day . " group by cr_dr order by cr_dr";
		$query = $this->db->query($sql);
		$result = $query->result_array();
		$total = 0;
		foreach ($result as $row) {
		  $total = $total + $row['total'] * ($row['cr_dr'] == 0 ? 1 : -1);
		}
		$data = array();
		$data['amount_cr'] = 0;
		$data['amount_dr'] = 0;
		if ($total < 0) {
		  $data['amount_dr'] = -$total;
		}
		else {
		  $data['amount_cr'] = $total;
		}
		return $data;
	}
  
	#Function to save petty cash transactions
	function save_petty_cash_transaction() 
	{
		access_control($this);
		
		# Get the passed details into the url data array if any
		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i', 'a', 'tt'));
		
		# Pick all assigned data
		$data = assign_to_data($urldata);	
		
		$data = restore_bad_chars($data);	
		
		if($data['save'])
		{ 
			$data['transactiondetails'] = $data;		
            $required_fields = array('reference', 'date', 'account', 'amount');
			$_POST = clean_form_data($data);
			$validation_results = validate_form('', $_POST, $required_fields);
                        
			#set status as editing on destination if updating
            if($this->input->post('editid')) $data['editid'] = $_POST['editid'];			
			
			#Only proceed if the validation for required fields passes
			if($validation_results['bool'])
			{   
                if(!empty($_POST['editid']))
                {
					#Add the school id and author to the data array
					$_POST = array_merge($_POST, array('school'=> $this->myschool['id'], 'author' => $this->session->userdata('userid')));
					
					$result = $this->financeobj->update_petty_cash_transction(array_merge($_POST, array('id'=> $data['editid'])));
           	  	}
			 	else 
             	{ 
					#Add author, type and other info to the data array
					$_POST = array_merge($_POST, array('type'=> decryptValue($_POST['tt']), 'author' => $this->session->userdata('userid')));
					
					$result = $this->financeobj->save_petty_cash_transction($_POST);
        		}
				
           		#Format and send the errors
            	if(!empty($result) && $result)
				{					
					$data['msg'] = "The transaction data has been successfully saved.";
					$data['transactiondetails'] = array();
            	 }
            	 else if(empty($data['msg']))
            	 {
				   	$data['msg'] = "ERROR: The transaction could not be saved or was not saved correctly.".$classname_error.$rank_error;
             	 }
            }
            
			#Prepare a message in case the user already exists for another school
			else if(empty($data['editid']) && !empty($class_details))
			{
				 #$addn_msg = (!empty($user_details['isactive']) && $user_details['isactive'] == 'N')? "<a href='".base_url()."admin/load_user_form/i/".encryptValue($user_details['id'])."/a/".encryptValue("reactivate")."' style='text-decoration:underline;font-size:17px;'>Click here to  activate and  edit</a>": "<a href='".base_url()."admin/load_user_form/i/".encryptValue($user_details['id'])."' style='text-decoration:underline;font-size:17px;'>Click here to edit</a>";
				 
				 #$data['msg'] = "WARNING: A class with the same name already exists.<br />"; 
			}
			             
            if((empty($validation_results['bool']) || (!empty($validation_results['bool']) && !$validation_results['bool'])) 
			&& empty($data['msg']) )
			{
				$data['msg'] = "WARNING: The highlighted fields are required.";
			}
			
			$data['requiredfields'] = $validation_results['requiredfields'];
		}		
         
                
		$this->load->view('finances/petty_cash_transaction_form_view', $data);
	}
  	
  
	function convertDate($date) 
	{
		$data = explode("/", $date, 4);
		return $data[2] . "-" . $data[0] . "-" . $data[1];
	}

	#Function to manage donations
	function manage_donations() 
	{
		access_control($this);
	
		# Get the passed details into the url data array if any
		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));
		# Pick all assigned data
		$data = assign_to_data($urldata);
		$data = add_msg_if_any($this, $data);
		$this->load->view('finances/manage_donations', $data);
	}
	
	#Function to load the class stream data form
	function load_stream_form()
	{
		access_control($this);
	}
	
	#Function to save the class stream data
	function save_stream()
	{
		access_control($this);
	}
	
}

?>
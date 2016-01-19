<?php

#**************************************************************************************
# All Inventory actions go through this controller
#**************************************************************************************

class Library extends CI_Controller {

	#Constructor to set some default values at class load
	public function __construct()
    {
		   parent::__construct();	
		$this->load->model('library_mod', 'librarymodel');
		date_default_timezone_set(SYS_TIMEZONE);
		$this->load->library('excelexport','excelexport');
		$this->myschool = $this->session->userdata('schoolinfo');
		
		access_control($this);
    }
	var $schoolinfo ;
    
    # Default to nothing
    function index()
    {
        #Do nothing
    }

    function load_stock()
	{
		access_control($this);
		$schooldetails = $this->session->userdata('schoolinfo');
		# Get the passed details into the url data array if any
		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));
		
		# Pick all assigned data
		$data = assign_to_data($urldata);
		
		#Get the Item details
		if(!empty($data['i']))
		{
			$editid = decryptValue($data['i']);
			$data['formdata'] = $this->Query_reader->get_row_as_array('get_stock_by_id', array('id'=>$editid) );			
		}		
		
		#Check if the user is simply viewing the deal
		#TODO: Add the force-users-without-other-permissions-to-view condition
		if(!empty($data['a']) && decryptValue($data['a']) == 'view')
		{
			$data['stockdata'] = $data['formdata'];
			$data['isviewing'] = TRUE;
			$data['area'] = 'stock_details';
			$this->load->view('incl/new_stock_view', $data);
		}
		else
			$data['stock'] = $this->librarymodel->get_books();
			$data['sections'] = $this->librarymodel->get_sections();
			$this->load->view('library/new_stock_view',$data);
			
	}

	
	# edit Stock data
	function stock_title_form()
	{
		$schooldetails = $this->session->userdata('schoolinfo');
		# Get the passed details into the url data array if any
		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));
		
		# Pick all assigned data
		$data = assign_to_data($urldata);
		
		#Get the title information
		if(!empty($data['s']))
		{
			$title_id = decryptValue($data['s']);
			$data['title_info'] = $this->Query_reader->get_row_as_array('get_stock_by_id', array('id'=>$title_id));		
		}
		
		$this->load->view('library/stock_title_form_view',$data);
			
	}
	
	
	#load the return book form
	function return_book_form()
	{		
		# Get the passed details into the url data array if any
		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));
		
		# Pick all assigned data
		$data = assign_to_data($urldata);
		
		#Get the book info plus latest borrow details
		if(!empty($data['i']))
		{
			$editid = decryptValue($data['i']);		
				
			#Get last borrower info
			$data['formdata'] = $this->Query_reader->get_row_as_array('search_library_transactions', array('searchstring'=>'library.id=' . $editid, 'orderby'=>' ORDER BY librarytransactions.transactionid DESC', 'limittext'=>''));
						
			
		}
				
		$this->load->view('library/return_book_form_view',$data);
	}
	
	
	#load form to add/edit a title
	function load_title_form()
	{
		access_control($this);
		
		# Get the passed details into the url data array if any
		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));
		
		# Pick all assigned data
		$data = assign_to_data($urldata);
		
		#Get the Item details
		if(!empty($data['i']))
		{
			$editid = decryptValue($data['i']);
            #mover
            $data['formdata'] = $this->Query_reader->get_row_as_array('get_library_stock_by_id', array('id'=>$editid) );


		}
		
		$data['sections'] = $this->librarymodel->get_sections();
		
		$this->load->view('library/load_title_form_view',$data);
	}


	#load form to add/edit a title
	function save_title()
	{
		access_control($this);
		
		# Get the passed details into the url data array if any
		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));
		
		# Pick all assigned data
		$data = assign_to_data($urldata);
		
		
		if($data['save'])
		{

            $required_fields = array('sectionid', 'stocktitle', 'author');
			$_POST = restore_bad_chars(clean_form_data($data));
			$data['formdata'] = $_POST;
			$validation_results = validate_form('', $_POST, $required_fields);
			$bookAuthorname_error = '';


			#set status as editing on destination if updating
            if($this->input->post('editid')) $data['editid'] = $_POST['editid'];			
			
			#Only proceed if the validation for required fields passes
			if($validation_results['bool'] && !(empty($data['editid']) && !empty($user_details)))
			{

                if(!empty($_POST['editid']))
                {

					#Check if another book other than the current one exists with the same name 
					$book_details  = $this->Query_reader->get_row_as_array('search_titles', array('limittext' => '', 'searchstring' => ' stocktitle = "'.$_POST['stocktitle'].'" AND id != '.$data['editid'].' AND author = "' . $_POST['author'] . '" AND school ='.$this->myschool['id']));

					if(empty($book_details))
					{
						#Add the school id and author to the data array
						//$_POST = array_merge($_POST, array('school'=> $this->myschool['id'], 'author' => $this->session->userdata('userid')));

						$result = $this->librarymodel->update_book(array_merge($_POST, array('id'=> $data['editid'])));
					}
					else
					{
						if (!empty($book_details)) $bookAuthorname_error = "<br />WARNING: A book by the same author with the same title already exists.";
					}
           	  	}
			 	else 
             	{
					#Check if book name and title exists 
					$book_details  = $this->Query_reader->get_row_as_array('search_titles', array('limittext' => '', 'searchstring' => ' stocktitle = "'.$_POST['stocktitle'].'" AND author = "' . $_POST['author'] . '" AND school ='.$this->myschool['id']));
					
			                        
                	if(empty($book_details))
                	{
						#Add the school id and author to the data array
						$_POST = array_merge($_POST, array('school'=> $this->myschool['id'], 'createdby' => $this->session->userdata('userid')));
						
						$result = $this->librarymodel->add_book($_POST );
					}
					else
					{
						if (!empty($book_details)) $bookAuthorname_error = "<br />WARNING: A book by the same author with the same title already exists.";
					}
        		}
				
           		#Format and send the errors
            	if(!empty($result) && $result)
				{					
					$data['msg'] = "The book data has been successfully saved.";
					if(empty($data['i'])) $data['formdata'] = array();
            	 }
            	 else if(empty($data['msg']))
            	 {
				   	$data['msg'] = "ERROR: The book could not be saved or was not saved correctly.".$bookAuthorname_error;
             	 }
            }
            
			#Prepare a message in case the user already exists for another school
			else if(empty($data['editid']) && !empty($book_details))
			{				 
				 $data['msg'] = "WARNING: A book by the same author with the same title already exists.<br />"; 
			}
			             
            if((empty($validation_results['bool']) || (!empty($validation_results['bool']) && !$validation_results['bool'])) 
			&& empty($data['msg']) )
			{
				$data['msg'] = "WARNING: The highlighted fields are required.";
			}
			
			$data['requiredfields'] = $validation_results['requiredfields'];
		}
		
		$data['sections'] = $this->librarymodel->get_sections();
		
		$this->load->view('library/load_title_form_view', $data);
	}
	
	
	function manage_stock(){		
		# Get the passed details into the url data array if any
		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));
		
		# Pick all assigned data
		$data = assign_to_data($urldata);
		
		#Get the paginated list of the deals
		$data = paginate_list($this, $data, 'get_stock_list', array('isactive'=>'Y', 'searchstring'=>' school = '.$this->myschool['id']));
		
		$data = add_msg_if_any($this, $data);
		// $this->load->view('library/manage_stock_view', $data);
		$this->load->view('library/manage_library', $data);
	}
	
	function inventory_status(){
		# Get the passed details into the url data array if any
		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));
		
		# Pick all assigned data
		$data = assign_to_data($urldata);
		
		#Get the paginated list of the books
		$data = paginate_list($this, $data, 'search_library_transactions_with_titles', array('isactive'=>'Y', 'searchstring'=>'', 'author'=> '', 'school'=> $this->myschool['id'], 'stocktitle'=> '', 'isbnnumber'=> ''), 20);
		
		$data = add_msg_if_any($this, $data);
		$this->load->view('library/inventory_status_view', $data);
	}

	function manage_library(){
		access_control($this);
		$schooldetails = $this->session->userdata('schoolinfo');
		
		# Get the passed details into the url data array if any
		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));
		# Pick all assigned data
		$data = assign_to_data($urldata);
		
		#Get the paginated list of the deals
		$data = paginate_list($this, $data, 'get_stock_list', array('isactive'=>'Y', 'searchstring'=>' school = '.$schooldetails['id']));
		
		$data = add_msg_if_any($this, $data);
		$this->load->view('library/manage_stock_view', $data);
		// $this->load->view('library/manage_library', $data);
	}
	
	
	function borrow_books()
	{
		access_control($this);
		
		$schooldetails = $this->session->userdata('schoolinfo');
		
		# Get the passed details into the url data array if any
		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));
		# Pick all assigned data
		$data = assign_to_data($urldata);
		
		#Get the paginated list of the deals
		#$data = paginate_list($this, $data, 'get_stock_list', array('isactive'=>'Y', 'searchstring'=>' school = '.$schooldetails['id']));
		
		$data = add_msg_if_any($this, $data);
		$this->load->view('library/borrow_books_view', $data);
		// $this->load->view('library/manage_library', $data);
	}
	
	
	function manage_stock_items(){
		access_control($this);
		$schooldetails = $this->session->userdata('schoolinfo');
		
		# Get the passed details into the url data array if any
		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));
		# Pick all assigned data
		$data = assign_to_data($urldata);
		
		#Get the paginated list of the deals
		$data = paginate_list($this, $data, 'get_stock_items_list', array('isactive'=>'Y', 'searchstring'=>' s.school = '.$schooldetails['id']));
		
		$data = add_msg_if_any($this, $data);
		$this->load->view('library/manage_stock_item_view', $data);
	}
	
	function manage_returns(){
		access_control($this);
		$schooldetails = $this->session->userdata('schoolinfo');
		
		# Get the passed details into the url data array if any
		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));
		# Pick all assigned data
		$data = assign_to_data($urldata);
		
		#Get the paginated list of the deals
		$data = paginate_list($this, $data, 'get_borrower_list', array('isactive'=>'Y', 'searchstring'=>' b.school = '.$schooldetails['id']));
		
		$data = add_msg_if_any($this, $data);
		$this->load->view('library/manage_borrowers_view', $data);
	}
	
	function manage_borrowers(){
		access_control($this);
		$schooldetails = $this->session->userdata('schoolinfo');
		
		# Get the passed details into the url data array if any
		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));
		# Pick all assigned data
		$data = assign_to_data($urldata);
		
		#Get the paginated list of the returns
		$data = paginate_list($this, $data, 'get_return_list', array('isactive'=>'Y', 'searchstring'=>' b.school = '.$schooldetails['id']));
		
		$data['returned'] = $data['page_list'];
		
		$data = paginate_list($this, $data, 'get_borrower_list', array('isactive'=>'Y','school'=>$schooldetails['id'], 'searchstring'=>'1'));
		$data['all'] = $data['page_list'];
		
		$data = add_msg_if_any($this, $data);
		$this->load->view('library/manage_returns_view', $data);
	}
	
	function delete_borrower(){
		access_control($this);
		
		# Get the passed details into the url data array if any
		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));
		# Pick all assigned data
		$data = assign_to_data($urldata);
		
		$save_result = $this->db->query($this->Query_reader->get_query_by_code('delete_row', array('tname' => "borrowers",'id' => decryptValue($data['i'])) ));
				
				
		if($save_result)
		{
			$data['msg'] = "The borrower has been deleted.";
			//die($data['msg']);
			$this->session->set_userdata('sres', $data['msg']);
			
			redirect(base_url()."library/manage_borrowers/m/sres");
		}
		else
		{
			$data['msg'] = "ERROR: The borrower was not deleted. Please contact your administrator.";
			die($data['msg']);
		}
	}
	
	function delete_return(){
		access_control($this);
		
		# Get the passed details into the url data array if any
		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));
		# Pick all assigned data
		$data = assign_to_data($urldata);
		$data['table'] = "borroweditems";		
		if(delete_row($this, $data))
		{
			$save_result = $this->db->query($this->Query_reader->get_query_by_code('update_library',array('item' => $data['i'], 'isavailable' => '0')));
			if($save_result){
				$data['msg'] = "The return has been deleted.";
				//die($data['msg']);
				$this->session->set_userdata('sres', $data['msg']);
				
				redirect(base_url()."library/manage_returns/m/sres");
			}
			else
				$data['msg'] = "ERROR: The borrower was not deleted. Please contact your administrator.";
		}
		else
		{
			$data['msg'] = "ERROR: The borrower was not deleted. Please contact your administrator.";
		}
	}
	
	function delete_title(){
		access_control($this);
		
		# Get the passed details into the url data array if any
		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));
		# Pick all assigned data
		$data = assign_to_data($urldata);
		
		$delete_result = $this->db->query($this->Query_reader->get_query_by_code('delete_row', array('tname' => "librarystock",'id' => decryptValue($data['i'])) ));
				
				
		if($delete_result)
		{
			$data['msg'] = "The stock has been deleted.";
			//die($data['msg']);
			$this->session->set_userdata('sres', $data['msg']);
			
			#redirect(base_url()."library/manage_stock/m/sres");
		}
		else
		{
			$data['msg'] = "ERROR: The stock was not deleted. Please contact your administrator.";
			die($data['msg']);
		}
	}
	
	function delete_stock_item(){
		access_control($this);
		
		# Get the passed details into the url data array if any
		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));
		# Pick all assigned data
		$data = assign_to_data($urldata);
		
		die($this->Query_reader->get_query_by_code('delete_row', array('tname' => "library",'id' => decryptValue($data['i'])) ));
		$save_result = $this->db->query($this->Query_reader->get_query_by_code('delete_row', array('tname' => "library",'id' => decryptValue($data['i'])) ));
				
				
		if($save_result)
		{
			$data['msg'] = "The stock item has been deleted.";
			//die($data['msg']);
			$this->session->set_userdata('sres', $data['msg']);
			
			redirect(base_url()."library/manage_stock_items/m/sres");
		}
		else
		{
			$data['msg'] = "ERROR: The stock item was not deleted. Please contact your administrator.";
			die($data['msg']);
		}
	}
	
	function generate_report(){
		access_control($this);
		$schooldetails = $this->session->userdata('schoolinfo');
		# Get the passed details into the url data array if any
		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));
		# Pick all assigned data
		$data = assign_to_data($urldata);
		
		if($this->input->post('generatepdf') || $this->input->post('generateexcel')){
			$required_fields = array('type');
			$_POST = clean_form_data($_POST);
			$validation_results = validate_form('', $_POST, $required_fields);
			
			if($validation_results['bool'])
			{
				$_POST = clean_form_data($_POST);
				$searchstring='1';
				
				if($_POST['type'] == 7){
					
					if(isset($_POST['datefrom']) && isset($_POST['dateto']) && $_POST['datefrom'] != "" && $_POST['dateto'] != "")
						$searchstring .= " AND  UNIX_TIMESTAMP(b.datetaken) <= '".strtotime($_POST['dateto'].' 23:59:59')."' AND UNIX_TIMESTAMP(b.datetaken) >= '".(strtotime($_POST['datefrom']) - 86400)."'";
					if(isset($_POST['item']) && $_POST['item'] != "")
						$searchstring .= " AND b.stockid=".$_POST['item'];
						
					$data['dateto'] = $_POST['dateto'];
					$data['datefrom'] = $_POST['datefrom'];
					#Get the paginated list of the purchases
					$data = paginate_list($this, $data, 'get_borrower_list', array('isactive'=>'Y', 'searchstring'=>' b.school = '.$schooldetails['id'].' AND ('.$searchstring.')'));
					$report_type = 'borrowing_report';
					$report_name = "BORROWING REPORT";
					
					if($this->input->post('generateexcel')){
						$size = sizeof($data['page_list']);
						$maxdate = date("j M, Y", GetTimeStamp($data['page_list'][($size-1)]['datetaken']));
						$mindate = date("j M, Y", GetTimeStamp($data['page_list'][0]['datetaken']));
						if(!empty($data['datefrom'])) 
							$from = date("j M, Y", GetTimeStamp($data['datefrom'])); 
						else 
							$from = $maxdate;
							
						if(!empty($data['dateto'])) 
							$to = date("j M, Y", GetTimeStamp($data['dateto'])); 
						else 
							$to = $mindate;
						
						$mydata = array($schooldetails['schoolname']);
						$this->excelexport->addRow($mydata);
						$mydata = array($report_name, "", "", "From :", $from,"","To :", $to);
						$this->excelexport->addRow($mydata);
						$mydata = array("Date Borrowed","Title", "Returned / Borrowed", "Name", "Date Expected");
						$this->excelexport->addRow($mydata);
						foreach($data['page_list'] AS $row){
							#check expiry of rental period
							$currentdate = date("Y-m-d H:i:s");
							$borrower_status = check_borrower_status($this, $row['borrowerid']);
							
							$mydata = array(date("j M, Y", GetTimeStamp($row['datetaken'])), $row['stocktitle'], ($row['copiestaken'] - $borrower_status)."/".$row['copiestaken'], $row['firstname']." ".$row['lastname'], date("j M, Y", GetTimeStamp($row['returndate'])));
							$this->excelexport->addRow($mydata);
						}
					}
				}
								
				elseif($_POST['type'] == 5){
					
					if(isset($_POST['datefrom']) && isset($_POST['dateto']) && $_POST['datefrom'] != "" && $_POST['dateto'] != "")
						$searchstring .= " AND  UNIX_TIMESTAMP(l.createdon) <= '".strtotime($_POST['dateto'].' 23:59:59')."' AND UNIX_TIMESTAMP(l.createdon) >= '".(strtotime($_POST['datefrom']) - 86400)."'";
					if(isset($_POST['item']) && $_POST['item'] != "")
						$searchstring .= " AND i.itemid=".$_POST['item'];
					
					$data['dateto'] = $_POST['dateto'];
					$data['datefrom'] = $_POST['datefrom'];
					#Get the paginated list of the purchases
					$data = paginate_list($this, $data, 'get_stock_items_list', array('isactive'=>'Y', 'searchstring'=>' s.school = '.$schooldetails['id'].' AND ('.$searchstring.')'));
					$report_type = 'library_stock_report';
					$report_name = "LIBRARY STOCK REPORT";
					
					if($this->input->post('generateexcel')){
						$size = sizeof($data['page_list']);
						$maxdate = date("j M, Y", GetTimeStamp($data['page_list'][($size-1)]['datecreated']));
						$mindate = date("j M, Y", GetTimeStamp($data['page_list'][0]['datecreated']));
						if(!empty($data['datefrom'])) 
							$from = date("j M, Y", GetTimeStamp($data['datefrom'])); 
						else 
							$from = $maxdate;
							
						if(!empty($data['dateto'])) 
							$to = date("j M, Y", GetTimeStamp($data['dateto'])); 
						else 
							$to = $mindate;
						
						$mydata = array($schooldetails['schoolname']);
						$this->excelexport->addRow($mydata);
						$mydata = array($report_name, "", "", "From :", $from,"","To :", $to);
						$this->excelexport->addRow($mydata);
						$mydata = array("Date Added","Serial Number", "Title", "ISBN Number");
						$this->excelexport->addRow($mydata);
						foreach($data['page_list'] AS $row){
							$mydata = array(date("j M, Y", GetTimeStamp($row['datecreated'])), $row['serialnumber'], $row['stocktitle'], $row['isbnnumber']);
							$this->excelexport->addRow($mydata);
						}
					}
				}
				
				elseif($_POST['type'] == 4){
					#Get the paginated list of the inventory
					$data = paginate_list($this, $data, 'get_stock_list', array('isactive'=>'Y', 'searchstring'=>' school = '.$schooldetails['id']));
					$report_type = 'library_report';
					$report_name = "LIBRARY REPORT";
					
					if($this->input->post('generateexcel')){
						$mydata = array($schooldetails['schoolname']);
						$this->excelexport->addRow($mydata);
						$mydata = array($report_name, "", "", "", date("j M, Y", time()));
						$this->excelexport->addRow($mydata);
						$mydata = array("Date", "Title", "Stocked", "Available", "Out");
						$this->excelexport->addRow($mydata);
						foreach($data['page_list'] AS $row){
							$stocked = get_all_stock_items($this, $row['id']);
							$in = get_stock_items($this, $row['id'], 1);
							$out = get_stock_items($this, $row['id'], 0);
							
							$mydata = array(date("j M, Y", GetTimeStamp($row['createdon'])), $row['stocktitle'], $stocked, $in, $out);
							$this->excelexport->addRow($mydata);
						}
					}
				}
				
				elseif($_POST['type'] == 8){
					
					if(isset($_POST['datefrom']) && isset($_POST['dateto']) && $_POST['datefrom'] != "" && $_POST['dateto'] != "")
						$searchstring .= " AND  UNIX_TIMESTAMP(r.returndate) <= '".strtotime($_POST['dateto'].' 23:59:59')."' AND UNIX_TIMESTAMP(r.returndate) >= '".(strtotime($_POST['datefrom']) - 86400)."'";
					if(isset($_POST['item']) && $_POST['item'] != "")
						$searchstring .= " AND s.id=".$_POST['item'];
					
					$data['dateto'] = $_POST['dateto'];
					$data['datefrom'] = $_POST['datefrom'];
					#Get the paginated list of the purchases
					$data = paginate_list($this, $data, 'get_return_list', array('isactive'=>'Y', 'searchstring'=>' b.school = '.$schooldetails['id'].' AND ('.$searchstring.')'));
					
					$report_type = 'returning_report';
					
					$report_name = "RETURNING REPORT";
					
					if($this->input->post('generateexcel')){
						$size = sizeof($data['page_list']);
						$maxdate = date("j M, Y", GetTimeStamp($data['page_list'][($size-1)]['returndate']));
						$mindate = date("j M, Y", GetTimeStamp($data['page_list'][0]['returndate']));
						if(!empty($data['datefrom'])) 
							$from = date("j M, Y", GetTimeStamp($data['datefrom'])); 
						else 
							$from = $maxdate;
							
						if(!empty($data['dateto'])) 
							$to = date("j M, Y", GetTimeStamp($data['dateto'])); 
						else 
							$to = $mindate;
						
						$mydata = array($schooldetails['schoolname']);
						$this->excelexport->addRow($mydata);
						$mydata = array($report_name, "", "", "From :", $from,"","To :", $to);
						$this->excelexport->addRow($mydata);
						$mydata = array("Date Returned","Title", "Serial Number");
						$this->excelexport->addRow($mydata);
						foreach($data['page_list'] AS $row){
							
							$mydata = array(date("j M, Y", GetTimeStamp($row['returndate'])), $row['stocktitle'], $row['stocktitle'],$row['serialnumber']);
							$this->excelexport->addRow($mydata);
						}
					}
				}
				
				
					
					#Format the statement
				$report_html = '';
				#$financial_details = array();
					
				$this->load->library('parser');  
				
				$data['schoolname'] = $schooldetails['schoolname'];
				$data['report_html'] = $report_html;     
				$output = $this->parser->parse('reports/'.$report_type,$data,true);
					
				if($this->input->post('generatepdf'))
					gen_pdf($this, $output);
				else{
					
					$this->excelexport->download($report_type.'.xls');
				}
			}
			if((empty($validation_results['bool']) || (!empty($validation_results['bool']) && !$validation_results['bool'])) 
			&& empty($data['msg']) )
			{
				$data['msg'] = "WARNING: The highlighted fields are required.";
			}
			
			$data['requiredfields'] = $validation_results['requiredfields'];
			$data['formdata'] = $_POST;
		}
		$this->load->view('library/new_report_view');
		
	}

	
	#function to save a stock's details
	function save_stock()
	{
		access_control($this);
		
		# Get the passed details into the url data array if any
		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i', 'a', 't'));
		
		# Pick all assigned data
		$data = assign_to_data($urldata);

		// if($data['save'])
		if($this->input->post('bookid'))
		{	
			$title_id = decryptValue($_POST['bookid']);
			$data['title_info'] = $this->Query_reader->get_row_as_array('get_stock_by_id', array('id'=>$title_id));
		
			$data['formdata'] = $_POST;		
            $required_fields = array('bookid', 'isbnnumber');
						
			$_POST = clean_form_data($_POST);
			#print_r($_POST);
			$validation_results = validate_form('', $_POST, $required_fields);
			$feename_error = '';

                        
			#Only proceed if the validation for required fields passes
			if($validation_results['bool'])
			{					
                if(!empty($data['editid'])){
                	#check if a value with the stocknumber already exists
                	$stocknumber_details  = $this->Query_reader->get_row_as_array('search_stock_list', array('limittext' => '', 'searchstring' => ' AND stocknumber = "'.$data['bookdetails']['stocknumber'].'" AND id != '.$data['editid'].' AND school ='.$this->myschool['id']));
                			
					$result = $this->db->query($this->Query_reader->get_query_by_code('insert_stock',array_merge($_POST, array('id'=> $data['editid']))));
           	  	}
			 	else 
             	{
					#if multiple isbns
					$isbns = explode(",", $_POST['isbnnumber']);
					
					if(count($isbns)>1)
					{	
						$insert_query = "INSERT INTO library(isbnnumber,serialnumber,bookid,createdby) VALUES ";
						$values_str = "";
						$search_library_vals = "";
						
						#format datat for query
						foreach($isbns as $isbn_value)
						{
							$values_str .= (($values_str == "")? "" : "," ) . "('" . trim($isbn_value) . "', '', '" . $title_id . "', '" . $this->session->userdata('userid') . "')";
							
							$search_library_vals .= (($search_library_vals == "")? "" : "," ) . "'" .trim($isbn_value) . "'";
						}
						
						
						#check if any of the isbn numbers already exists for that title
						$search_library = $this->db->query($this->Query_reader->get_query_by_code('search_library',array('searchstring'=>'bookid=' . $title_id . ' AND isbnnumber IN (' . $search_library_vals  . ')')))->result_array();
						
						if(count($search_library))
						{
							$data['msg'] = "WARNING: The isbn number you are trying to add already exists for the selected title";
						}
						else
						{
							$result = $this->db->query($insert_query . $values_str);
						}
					}
					else
					{
						#check if the isbn number exists for that title
						$search_library = $this->db->query($this->Query_reader->get_query_by_code('search_library',array('searchstring'=>'bookid=' . $title_id . ' AND isbnnumber="' . trim($_POST['isbnnumber'])  . '"')))->result_array();
						
						
						if(count($search_library))
						{
							$data['msg'] = "WARNING: The isbn number you are trying to add already exists for the selected title";
						}
						else
						{
							$_POST = array_merge($_POST, array('school'=> $this->myschool['id'], 'bookid'=>$title_id, 'createdby'=>$this->session->userdata('userid')));
						
							$result = $this->db->query($this->Query_reader->get_query_by_code('add_stock_item',$_POST));
						}
					
					}			
        		}
				
           		#Format and send the errors
            	if(!empty($result) && $result)
				{			
					if(!empty($isbns) && count($isbns)>1):
						$data['msg'] = $_POST['isbnnumber'].' have been added to the library.';
					else:
						$data['msg'] = (empty($data['editid']))? $_POST['isbnnumber'].' has been added to the library.' : 'Details for '.$_POST['isbnnumber'].' have been updated.';
					endif;					
					
					$data['formdata'] = array();

            	 }
            	 else if(empty($data['msg']))
            	 {
				   	$data['msg'] = "ERROR: The stock could not be saved or was not saved correctly.";					
             	 }
            }
			else
			{
				$data['msg'] = "WARNING: The highlighted fields are required";
			}
			
			$data['requiredfields'] = $validation_results['requiredfields'];
		}
		
		$this->load->view('library/stock_title_form_view', $data);
	}

	#function to save a subject's details

	function update_stock()
	{
		access_control($this);
		
		$schooldetails = $this->session->userdata('schoolinfo');
		# Get the passed details into the url data array if any
		
		# Get the passed details into the url data array if any
		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i', 'a', 't'));
	
		// $urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));
		
		# Pick all assigned data
		$data = assign_to_data($urldata);

		$data = restore_bad_chars($data);

		#Get the Item details
		if(!empty($data['i']))
		{
			$editid = decryptValue($data['i']);
			$data['formdata'] = $this->Query_reader->get_row_as_array('get_stock_item_by_id', array('id'=>$editid) );			
			// $data['formdata']['search'] = $data['formdata']['isbnnumber'];

		}


		// if($data['save'])
		if(!empty($data['s']))
		// if (isset($data['s']))
		{
			$stockid = decryptValue($data['s']);
			#$stockid = $data['s'];
			$data['stockdata'] = $this->Query_reader->get_row_as_array('get_stock_by_id', array('id'=>$stockid) );			
			
		}		

		
		#Get the Item details
		
		if (isset($data['save'])) 
		
		{	
			
			$data['formdata'] = $data;		
        	//$required_fields = array('stockid', 'createdon', 'serialnumber', 'isbnnumber');
        	$required_fields = array('stockid', 'dateadded', 'serialnumber', 'isbnnumber');
		

			foreach($data as $key => $data_value)
				$data[$key] = restore_bad_chars($data_value);
			
			$_POST = clean_form_data($data);
			// print_r($_POST);
			$validation_results = validate_form('', $_POST, $required_fields);
			$feename_error = '';

            #set status as editing on destination if updating
            if($this->input->post('editid')) $data['editid'] = $_POST['editid'];

			#Only proceed if the validation for required fields passes
			// if($validation_results['bool'])
			if($validation_results['bool'] && !(empty($data['editid']) && !empty($user_details)))
			{ 

				
                if(!empty($data['editid']))
                {

                	#check if a value with the isbnnumber already exists
                	$isbnnumber_details  = $this->Query_reader->get_row_as_array('search_isbn_list', array('limittext' => '', 'searchstring' => ' AND isbnnumber = "'.$data['bookdetails']['isbnnumber'].'" AND id != '.$data['editid'].' AND school ='.$this->myschool['id']));

					$result = $this->db->query($this->Query_reader->get_query_by_code('update_stock_item',array_merge($_POST, array('id'=> $data['editid']))));
           	  	}
			 	else 
             	{	
             		$_POST ['stockid']= decryptValue($data['s']);
             		#echo ($this->Query_reader->get_query_by_code('insert_stock',$_POST));
             		#exit();
					#Add the school id and author to the data array
					$_POST = array_merge($_POST, array('school'=> $this->myschool['id'], 'createdby' => $this->session->userdata('userid')));
					
					
					$result = $this->db->query($this->Query_reader->get_query_by_code('insert_stock',$_POST));
					
					
        		}
				
           		#Format and send the errors
            	if(!empty($result) && $result)
				{					
					$data['msg'] = (empty($data['editid']))? 'Book number <i>'. $data['isbnnumber']. '</i> has been added to the library.' : 'Details for '.$data['stocktitle'].' have been updated.';
					$data['formdata'] = array();

            	 }
            	 else if(empty($data['msg']))
            	 {
				   	$data['msg'] = "ERROR: The stock could not be saved or was not saved correctly.";					
             	 }
            }
			
			$data['requiredfields'] = $validation_results['requiredfields'];
		}
        
		
		$data['stock'] = $this->librarymodel->get_books();
		

		$this->load->view('incl/new_stock_item_view', $data);
		
	}
	
	
	#Save a RETURN BOOK transaction
	function save_return_book_transaction()
	{		
		# Get the passed details into the url data array if any
		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));
		
		# Pick all assigned data
		$data = assign_to_data($urldata);
		#print_r($_POST);
		if($this->input->post('saveitem'))
		{	
            $required_fields = array('returndate', 'stockno');
			$data['formdata'] = $_POST;
			$validation_results = validate_form('', $_POST, $required_fields);
                        
			#set status as editing on destination if updating
            if($this->input->post('editid')) $data['editid'] = $_POST['editid'];			
			
			#Only proceed if the validation for required fields passes
			if($validation_results['bool'] && !(empty($data['editid']) && !empty($user_details)))
			{
                if(!empty($_POST['editid']))
                {	
					#TODO: Update borrow transaction logic
           	  	}
			 	else 
             	{						
					#insert the transaction details
					$trans_details_results = $this->librarymodel->add_transaction_details(array('author'=>$this->session->userdata('userid'), 'stockid'=>decryptValue($_POST['stockno']), 'returndate'=>$_POST['returndate'], 'comments'=>trim($_POST['comments']), 'transactiontype'=>'RETURN'));
						
					#Mark the books as IN
					if($trans_details_results)
					{
						$update_books_results = $this->librarymodel->update_library_books_status(array('status'=>'IN', 'books'=>decryptValue($_POST['stockno'])));
					}			
        		}
				
           		#Format and send the errors
            	if(!empty($trans_details_results) && $trans_details_results)
				{					
					$data['msg'] = "The transaction data has been successfully saved";
					$data['isview'] = true;
					#if(empty($data['i'])) $data['formdata'] = array();
            	 }
            	 else if(empty($data['msg']))
            	 {
				   	$data['msg'] = "ERROR: The transaction data has been was not saved or not saved properly";
             	 }
            }
            			             
            if((empty($validation_results['bool']) || (!empty($validation_results['bool']) && !$validation_results['bool'])) 
			&& empty($data['msg']))
			{
				$data['msg'] = "WARNING: The highlighted fields are required.";
			}
			
			$data['requiredfields'] = $validation_results['requiredfields'];
		}
		
		$editid = decryptValue($data['i']);		
				
		#Get last borrower info
		$data['formdata'] = $this->Query_reader->get_row_as_array('search_library_transactions', array('searchstring'=>'library.id=' . $editid, 'orderby'=>' ORDER BY librarytransactions.transactionid DESC', 'limittext'=>''));
		
		if(!empty($data['isview']) && $data['isview'] == true)
		{
			$data['formdata']['comments'] = $_POST['comments'];
			$data['formdata']['returndate'] = $_POST['returndate'];
		}
				
		$this->load->view('library/return_book_form_view', $data);
	}
	
	
	#Save a borrow transaction
	function save_transaction()
	{		
		# Get the passed details into the url data array if any
		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));
		
		# Pick all assigned data
		$data = assign_to_data($urldata);
		
		if($this->input->post('save'))
		{	
            $required_fields = array('borrower', 'borrower_identification', 'returndate');
			$data['formdata'] = $_POST;
			$validation_results = validate_form('', $_POST, $required_fields);
                        
			#set status as editing on destination if updating
            if($this->input->post('editid')) $data['editid'] = $_POST['editid'];			
			
			#Only proceed if the validation for required fields passes
			if($validation_results['bool'] && !(empty($data['editid']) && !empty($user_details)))
			{
                if(!empty($_POST['editid']))
                {	
					#TODO: Update borrow transaction logic
           	  	}
			 	else 
             	{
					#Add transaction headers if books selected
					if(!empty($_POST['selected_books']))
					{
						$header_results = $this->librarymodel->add_transaction_headers(array('author'=>$this->session->userdata('userid'),'school'=>$this->myschool['id'], 'borrowerid'=>decryptValue($_POST['borrower_identification']), 'borrowertype'=>decryptValue($_POST['borrower_type'])));
					
						$batchno = $this->db->insert_id();
						
						#insert the transaction details
						if($header_results)
						{
							#1.0 Format data for query
							$values_str = '';	
							$update_books_str = '';				
							foreach($_POST['selected_books'] as $selected_book_id)
							{
								if($values_str != '')
								{
									$values_str .= ',';
									$update_books_str .= ',';
								}
								
								$update_books_str .=  $selected_book_id;
								$values_str .= '(' . $batchno . ',' . $selected_book_id . ', "' . $_POST['returndate'].
												'", "BORROW")';
							}
							
							$trans_details_results = $this->librarymodel->add_transaction_details(array('values'=>$values_str));
							
							#Mark the books as OUT
							if($trans_details_results)
							{
								$update_books_results = $this->librarymodel->update_library_books_status(array('status'=>'OUT', 'books'=>$update_books_str));
							}
							
						}
					}					
        		}
				
           		#Format and send the errors
            	if(!empty($trans_details_results) && $trans_details_results)
				{					
					$data['msg'] = "The transaction data has been successfully saved";
					if(empty($data['i'])) $data['formdata'] = array();
            	 }
            	 else if(empty($data['msg']))
            	 {
				   	$data['msg'] = "ERROR: The transaction data has been was not saved or not saved properly";
             	 }
            }
            			             
            if((empty($validation_results['bool']) || (!empty($validation_results['bool']) && !$validation_results['bool'])) 
			&& empty($data['msg']))
			{
				$data['msg'] = "WARNING: The highlighted fields are required.";
			}
			
			$data['requiredfields'] = $validation_results['requiredfields'];
		}
				
		$this->load->view('library/borrow_books_view', $data);
	}

	
	#
	# save borrower data
	function save_borrower_form()
	{
		access_control($this);
		$schooldetails = $this->session->userdata('schoolinfo');
		
		# Get the passed details into the url data array if any
		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));
		
		# Pick all assigned data
		$data = assign_to_data($urldata);
		

		if(!empty($data['i']))
		{
			$editid = decryptValue($data['i']);
			$data['formdata'] = $this->Query_reader->get_row_as_array('get_borrower_by_id', array('id'=>$editid) );	
			$data['formdata']['search'] = $data['formdata']['firstname']." ".$data['formdata']['middlename']." ".$data['formdata']['lastname'];
		}
		// var_dump($data);
		#####comment out.. use model values
		#Get the Item details
			$stockid = decryptValue($data['s']);
			#$stockid = $data['s'];
			$data['stockdata'] = $this->Query_reader->get_row_as_array('get_stock_by_id', array('id'=>$stockid) );			
		#Get the Item details
		
		
		#Check if the user is simply viewing the deal
		#TODO: Add the force-users-without-other-permissions-to-view condition
		if(!empty($data['a']) && decryptValue($data['a']) == 'view')
		{
			$data['isview'] = "Y";
		}
		
		if($this->input->post('saveborrower')){
			
			$required_fields = array('name','type','dateborrowed', 'taken', 'libraryid');
			$_POST = clean_form_data($_POST);
			$validation_results = validate_form('', $_POST, $required_fields);
			$borrowerperiod = validate_borrower_period($_POST['dateborrowed'],$_POST['datereturned']);
			if($validation_results['bool'] && $borrowerperiod == "")
			{
				
				
					$_POST['copiestaken'] = sizeof($_POST['items']);
					if(!empty($data['formdata']) && !empty($data['i']))
					{
						$save_result = $this->db->query($this->Query_reader->get_query_by_code('update_borrower', array_merge($_POST, array('id'=>$editid)) ));
					}
					else
					{
						// echo($this->Query_reader->get_query_by_code('add_borrower', array_merge($_POST, array('school' => $schooldetails['id'], 'createdby'=>$this->session->userdata('userid'))) ));
						// exit();
						$save_result = $this->db->query($this->Query_reader->get_query_by_code('add_borrower', array_merge($_POST, array('school' => $schooldetails['id'], 'createdby'=>$this->session->userdata('userid'))) ));
					}
					
					if($save_result)
					{
						$borrowerid = $this->db->insert_id();
						for($i=0; $i<sizeof($_POST['items']); $i++){
							$save_result2 = $this->db->query($this->Query_reader->get_query_by_code('add_borroweditems',array('borrower'=> $borrowerid,'item' => $_POST['items'][$i])));
							$updateitem = $this->db->query($this->Query_reader->get_query_by_code('update_item_borrowed',array('id' => $_POST['items'][$i], 'isavailable' => 0)));
						}
						if($save_result2 && $updateitem){
							$data['msg'] = "The borrower has been saved.";
							#die($data['msg']);
							$this->session->set_userdata('sres', $data['msg']);
							
							redirect(base_url()."library/manage_borrowers/m/sres");
						}
						else
							$data['msg'] = "ERROR: The borrower was not saved. Please contact your administrator.";
					}
					else
					{
						$data['msg'] = "ERROR: The borrower was not saved. Please contact your administrator.";
						#die($data['msg']);
					}
				
			} #Validation
			
			if((empty($validation_results['bool']) || (!empty($validation_results['bool']) && !$validation_results['bool'])) 
			&& empty($data['msg']) )
			{
				$data['msg'] = "WARNING: The highlighted fields are required.";
			}
			
			if($borrowerperiod != "")
				$data['msg'] = "WARNING: ".$borrowerperiod;
			$data['requiredfields'] = $validation_results['requiredfields'];
			$data['formdata'] = $_POST;
		}

		
		
		if(!empty($data['a']) && decryptValue($data['a']) == 'view')
		{
			$data = paginate_list($this, $data, 'get_borrowed_items', array('isactive'=>'Y', 'searchstring'=>' AND b.borrower = '.$data['formdata']['id']));
			$data['isviewing'] = TRUE;
			$data['area'] = 'borrower_details';
			$this->load->view('incl/addons', $data);
		}
		else
			
			$this->load->view('library/new_borrower',$data);
			$data['students'] = $this->librarymodel->get_students();
	}
    #function to editbook
    function load_stock_form()
    {
        //get_library_stock_by_id  library_stock_id
       // echo "reached";
    }
    #function search library stock
    function search_library_stock()
    {

    }

}
?>
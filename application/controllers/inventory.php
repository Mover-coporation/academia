<?php

#**************************************************************************************

# All Inventory actions go through this controller

#**************************************************************************************



class Inventory extends CI_Controller {

	#Constructor to set some default values at class load
	public function __construct()
    {
		   parent::__construct();

		

		date_default_timezone_set(SYS_TIMEZONE);

		$this->schoolinfo = $this->session->userdata('schoolinfo');

		$this->load->library('excelexport','excelexport');

    }

	var $schoolinfo ;

    

    # Default to nothing

    function index()

    {

        #Do nothing

    }

	

	# save Item data

	function load_item_form()

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

			$data['formdata'] = $this->Query_reader->get_row_as_array('get_item_by_id', array('id'=>$editid) );			

		}

		

		#Check if the user is simply viewing the item

		#TODO: Add the force-users-without-other-permissions-to-view condition

		if(!empty($data['a']) && decryptValue($data['a']) == 'view')

		{

			$data['isview'] = "Y";

		}

		

		$this->load->view('inventory/new_item_view',$data);

	}

	

	

	function save_item()

	{

		access_control($this);

		$schooldetails = $this->session->userdata('schoolinfo');

		

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));

		

		# Pick all assigned data

		$data = assign_to_data($urldata);



		

		if($this->input->post('saveitem'))

		{			

			$required_fields = array('reorderlevel*NUMBER','itemname','unitspecification');

			$_POST = clean_form_data($_POST);

			$validation_results = validate_form('', $_POST, $required_fields);

			

			if($validation_results['bool'])

			{

				if(!empty($data['formdata']) && !empty($data['i']))

				{

					$save_result = $this->db->query($this->Query_reader->get_query_by_code('update_item', array_merge($_POST, array('id'=>$editid)) ));

				}

				else

				{

					$save_result = $this->db->query($this->Query_reader->get_query_by_code('add_item', array_merge($_POST, array('school' => $schooldetails['id'], 'school' => $schooldetails['id'], 'createdby'=>$this->session->userdata('userid'))) ));

				}

				

				if($save_result)

				{

					$data['msg'] = "The item has been saved.";

					

					$data['formdata'] = empty($i)? array() : $_POST;

					

					#$this->session->set_userdata('sres', $data['msg']);

					

					#redirect(base_url()."inventory/manage_inventory/m/sres");

				}

				else

				{

					$data['msg'] = "ERROR: The item was not saved. Please contact your administrator.";

					$data['formdata'] = $_POST;

				}

			} #Validation

			

			if((empty($validation_results['bool']) || (!empty($validation_results['bool']) && !$validation_results['bool'])) 

			&& empty($data['msg']) )

			{

				$data['msg'] = "WARNING: The highlighted fields are required.";

			}

			

			$data['requiredfields'] = $validation_results['requiredfields'];

		}

		

		$this->load->view('inventory/new_item_view',$data);

	}

	

	

	function in_inventory(){

		access_control($this);

			

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));

		

		# Pick all assigned data

		$data = assign_to_data($urldata);

		$result = $result = $this->db->query($this->Query_reader->get_query_by_code('get_item_inventory',array('searchstring'=>"itemid = ".decryptValue($data['i']))));

		$data['page_list'] = $result->result_array();

		$data['isviewing'] = TRUE;

		$data['area'] = 'in_inventory_details';

		$this->load->view('incl/addons', $data);

	}

	

	function out_inventory(){

		access_control($this);

			

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));

		

		# Pick all assigned data

		$data = assign_to_data($urldata);

		$result = $this->db->query($this->Query_reader->get_query_by_code('get_item_transaction', array_merge($_POST, array('itemid'=>decryptValue($data['i']))) ));

		$data['page_list'] = $result->result_array();

		$data['isviewing'] = TRUE;

		$data['area'] = 'out_inventory_details';

		$this->load->view('incl/addons', $data);

	}

	

	# save transaction data

	function load_transaction_form()

	{

		access_control($this);

		$schooldetails = $this->session->userdata('schoolinfo');

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));

		

		# Pick all assigned data

		$data = assign_to_data($urldata);

		

		#Get the Student details

		if(!empty($data['s']))

		{

			#$studentid = $data['s'];

			$itemid = decryptValue($data['s']);

			$data['itemdata'] = $this->Query_reader->get_row_as_array('get_item_by_id', array('id'=>$itemid) );			

		}

		

		#Get the transaction details

		if(!empty($data['i']))

		{

			$editid = decryptValue($data['i']);

			$data['formdata'] = $this->Query_reader->get_row_as_array('get_transaction_by_id', array('id'=>$editid, 'school'=>$schooldetails['id']) );	

			$data['formdata']['search'] = $data['formdata']['firstname']." ".$data['formdata']['middlename']." ".$data['formdata']['lastname'];

		}

		

		#Check if the user is simply viewing the deal

		#TODO: Add the force-users-without-other-permissions-to-view condition

		if(!empty($data['a']) && decryptValue($data['a']) == 'view')

		{

			$data['isview'] = "Y";

		}

		

		

		if($this->input->post('savetransaction')){

			

			$required_fields = array('quantity*NUMBER','studentid','datecreated');

			$validation_results = validate_form('', $_POST, $required_fields);

			if($validation_results['bool'])

			{

				#Determine selected

				$remaining = get_stocked($this, $itemid) - get_sold($this, $itemid);

				#die($_POST['itemid']." id ".$remaining." remaining");

				

				if($remaining >= $_POST['quantity'])

				{

					$_POST['itemid'] = $itemid;

					/*foreach($_POST as $key => $val)

						echo "$key -> $val<br>"; */

					if(!empty($data['formdata']) && !empty($data['i']))

					{

						$save_result = $this->db->query($this->Query_reader->get_query_by_code('update_transaction', array_merge($_POST, array('id'=>$editid)) ));

					}

					else

					{

						$save_result = $this->db->query($this->Query_reader->get_query_by_code('add_transaction', array_merge($_POST, array('school' => $schooldetails['id'], 'studentid' => $_POST['studentid'], 'itemid' => $_POST['itemid'], 'createdby'=>$this->session->userdata('userid'))) ));

					}

					

					if($save_result)

					{

						$data['msg'] = "The transaction has been saved.";

						#die($data['msg']);

						$this->session->set_userdata('sres', $data['msg']);

						

						redirect(base_url()."inventory/manage_items/m/sres");

					}

					else

					{

						$data['msg'] = "ERROR: The transaction was not saved. Please contact your administrator.";

						//die($data['msg']);

					}

				}

				else

				{

					$data['msg'] = "ERROR: The transaction was not saved. This Item is out of stock.";

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

		

		$this->load->view('inventory/new_transaction_view',$data);

	}

	

	# save Inventory data

	function load_inventory_form()

	{

		access_control($this);

		$schooldetails = $this->session->userdata('schoolinfo');

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));

		

		# Pick all assigned data

		$data = assign_to_data($urldata);

		

		#Get the item details

		if(!empty($data['a']))

		{

			//die('here');

			$itemid = decryptValue($data['a']);

			$data['itemdata'] = $this->Query_reader->get_row_as_array('get_item_by_id', array('id'=>$itemid) );			

		}

		

		#Get the student details

		if(!empty($data['i']))

		{

			#die('here2');

			$editid = decryptValue($data['i']);

			$data['formdata'] = $this->Query_reader->get_row_as_array('get_inventory_by_id', array('id'=>$editid) );			

		}

		#Check if the user is simply viewing the deal

		#TODO: Add the force-users-without-other-permissions-to-view condition

		if(!empty($data['a']) && decryptValue($data['a']) == 'view')

		{

			$data['isview'] = "Y";

		}

		

		

		if($this->input->post('saveinventory')){

			

			$required_fields = array('itemid','quantity*NUMBER','supplier','invoicenumber','price*NUMBER');

			$_POST = clean_form_data($_POST);

			$validation_results = validate_form('', $_POST, $required_fields);

			

			if($validation_results['bool'])

			{

				if(!empty($data['formdata']) && !empty($data['i']))

				{

					$save_result = $this->db->query($this->Query_reader->get_query_by_code('update_inventory', array_merge($_POST, array('id'=>$editid)) ));

				}

				else

				{

					$save_result = $this->db->query($this->Query_reader->get_query_by_code('add_inventory', array_merge($_POST, array('school' => $schooldetails['id'], 'itemid' => $_POST['itemid'], 'createdby'=>$this->session->userdata('userid'))) ));

				}

				

				if($save_result)

				{

					$data['msg'] = "The inventory has been saved.";

					#die($data['msg']);

					$this->session->set_userdata('sres', $data['msg']);

					

					redirect(base_url()."inventory/manage_inventory/m/sres");

				}

				else

				{

					$data['msg'] = "ERROR: The inventory was not saved. Please contact your administrator.";

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

		

		$this->load->view('inventory/new_inventory_view',$data);

	}

	

	function manage_items(){

		access_control($this);

		$schooldetails = $this->session->userdata('schoolinfo');

		

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));

		# Pick all assigned data

		$data = assign_to_data($urldata);

		

		$data = paginate_list($this, $data, 'get_transaction_list', array('isactive'=>'Y', 'searchstring'=>' t.school = '.$schooldetails['id']));

		$data['issued'] = $data['page_list'];

		

		#Get the paginated list of the deals

		$data = paginate_list($this, $data, 'get_inventory_list', array('isactive'=>'Y', 'searchstring'=>' i.school = '.$schooldetails['id']));

		

		

		$data = add_msg_if_any($this, $data);

		$this->load->view('inventory/manage_inventory_view', $data);

	}

	

	function manage_transactions(){

		access_control($this);

		$schooldetails = $this->session->userdata('schoolinfo');

		

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));

		# Pick all assigned data

		$data = assign_to_data($urldata);

		

		#Get the paginated list of the deals

		$data = paginate_list($this, $data, 'get_transaction_list', array('isactive'=>'Y', 'searchstring'=>' t.school = '.$schooldetails['id']));

		

		$data = add_msg_if_any($this, $data);

		$this->load->view('inventory/manage_transactions_view', $data);

	}

	

	function manage_inventory(){

		access_control($this);

		$schooldetails = $this->session->userdata('schoolinfo');

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));

		# Pick all assigned data

		$data = assign_to_data($urldata);

		

		#Get the paginated list of the deals

		$data = paginate_list($this, $data, 'get_item_list', array('isactive'=>'Y', 'searchstring'=>' school = '.$schooldetails['id']));

		

		$data = add_msg_if_any($this, $data);

		$this->load->view('inventory/manage_items_view', $data);

	}

	

	function delete_inventory(){

		access_control($this);

		

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));

		# Pick all assigned data

		$data = assign_to_data($urldata);

		

		$save_result = $this->db->query($this->Query_reader->get_query_by_code('delete_row', array('tname' => "inventory",'id' => decryptValue($data['i'])) ));

				

				

		if($save_result)

		{

			$data['msg'] = "The inventory has been deleted.";

			//die($data['msg']);

			$this->session->set_userdata('sres', $data['msg']);

			

			redirect(base_url()."inventory/manage_inventory/m/sres");

		}

		else

		{

			$data['msg'] = "ERROR: The inventory was not deleted. Please contact your administrator.";

			die($data['msg']);

		}

	}

	

	function delete_item(){

		access_control($this);

		

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));

		# Pick all assigned data

		$data = assign_to_data($urldata);

		

		$save_result = $this->db->query($this->Query_reader->get_query_by_code('delete_row', array('tname' => "items",'id' => decryptValue($data['i'])) ));

				

				

		if($save_result)

		{

			$data['msg'] = "The item has been deleted.";

			//die($data['msg']);

			$this->session->set_userdata('sres', $data['msg']);

			

			redirect(base_url()."inventory/manage_items/m/sres");

		}

		else

		{

			$data['msg'] = "ERROR: The item was not deleted. Please contact your administrator.";

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

				

				if($_POST['type'] == 1){

					

					if(isset($_POST['datefrom']) && isset($_POST['dateto']) && $_POST['datefrom'] != "" && $_POST['dateto'] != "")

						$searchstring .= " AND  UNIX_TIMESTAMP(i.datecreated) <= '".strtotime($_POST['dateto'].' 23:59:59')."' AND UNIX_TIMESTAMP(i.datecreated) >= '".strtotime($_POST['datefrom'])."'";

					if(isset($_POST['item']) && $_POST['item'] != "")

						$searchstring .= " AND i.itemid=".$_POST['item'];

						

					$querycode = 'get_inventory_list';

					$data['dateto'] = $_POST['dateto'];

					$data['datefrom'] = $_POST['datefrom'];

					#Get the paginated list of the purchases

					$data = paginate_list($this, $data, $querycode, array('isactive'=>'Y', 'searchstring'=>' i.school = '.$schooldetails['id'].' AND ('.$searchstring.')'));

					$report_type = 'purchases_report';

					$report_name = "PURCHASES REPORT";

					

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

						$mydata = array($report_name, "", "", "From :", $from,"" ,"","To :", $to);

						$this->excelexport->addRow($mydata);

						$mydata = array("Date","Item Name", "Supplier", "Invoice Number", "Quanity", "Price");

						$this->excelexport->addRow($mydata);

						$sum = 0;

						foreach($data['page_list'] AS $row){

							$price = $row['price'] * $row['quantity'];

							$sum += $price;

							$mydata = array(date("j M, Y", GetTimeStamp($row['datecreated'])), $row['itemname'], $row['supplier'], $row['invoicenumber'], $row['quantity'], number_format($price,0,'.',','));

							$this->excelexport->addRow($mydata);

						}

						$mydata = array("Total","", "", "", "", number_format($sum,0,'.',','));

						$this->excelexport->addRow($mydata);

					}

				}

				

				elseif($_POST['type'] == 3){

					

					if(isset($_POST['datefrom']) && isset($_POST['dateto']) && $_POST['datefrom'] != "" && $_POST['dateto'] != "")

						$searchstring .= " AND  UNIX_TIMESTAMP(i.datecreated) <= '".strtotime($_POST['dateto'].' 23:59:59')."' AND UNIX_TIMESTAMP(i.datecreated) >= '".strtotime($_POST['datefrom'])."'";

					if(isset($_POST['item']) && $_POST['item'] != "")

						$searchstring .= " AND i.itemid=".$_POST['item'];

						

					$querycode = 'get_inventory_list';

					$data['dateto'] = $_POST['dateto'];

					$data['datefrom'] = $_POST['datefrom'];

					#Get the paginated list of the deals

					$data = paginate_list($this, $data, 'get_transaction_list', array('isactive'=>'Y', 'searchstring'=>' t.school = '.$schooldetails['id'].' AND ('.$searchstring.')'));

					$report_type = 'issuing_report';

					$report_name = "ISSUING REPORT";

					

					if($this->input->post('generateexcel')){

						$size = sizeof($data['page_list']);

						$maxdate = date("j M, Y", GetTimeStamp($data['page_list'][($size-1)]['dateadded']));

						$mindate = date("j M, Y", GetTimeStamp($data['page_list'][0]['dateadded']));

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

						$mydata = array($report_name, "", "", "From :", $from,"" ,"","To :", $to);

						$this->excelexport->addRow($mydata);

						$mydata = array("Date","Item Name", "Quantity", "Issued To");

						$this->excelexport->addRow($mydata);

						foreach($data['page_list'] AS $row){

							$mydata = array(date("j M, Y", GetTimeStamp($row['dateadded'])), $row['itemname'], $row['quantity'], $row['firstname']." ".$row['lastname']);

							$this->excelexport->addRow($mydata);

						}

					}

				}

				

				elseif($_POST['type'] == 2){

					#Get the paginated list of the inventory

					$data = paginate_list($this, $data, 'get_item_list', array('isactive'=>'Y', 'searchstring'=>' school = '.$schooldetails['id']));

					$report_type = 'inventory_report';

					$report_name = "INVENTORY REPORT";

					

					if($this->input->post('generateexcel')){

						$mydata = array($schooldetails['schoolname']);

						$this->excelexport->addRow($mydata);

						$mydata = array($report_name, "", "", "", date("j M, Y", time()));

						$this->excelexport->addRow($mydata);

						$mydata = array("Item Name", "In", "Out", "Stocked", "Units");

						$this->excelexport->addRow($mydata);

						foreach($data['page_list'] AS $row){

							$stocked = get_stocked($this, $row['id']);

							$sold = get_sold($this, $row['id']);

							$remaining = $stocked - $sold;

							

							#Assign zeros to empty values	

							if(empty($stocked)) $stocked=0;

							if(empty($sold)) $sold=0;

							$mydata = array($row['itemname'], $remaining, $sold, $stocked, $row['unitspecification']);

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

		$this->load->view('inventory/new_report_view');

		

	}

	

	/* this function is used to create table and write that table into excel */

    function writeDataintoCSV($stringData) {

		

        //place where the excel file is created

        $myFile = base_url()."upload/testexcel.xls";

		

        //$fh = fopen($myFile, 'w') or die("can't open file");

        fwrite($myFile, $stringData);



        fclose($fh);

        //download excel file

        $this->downloadExcel();

    }



/* download created excel file */

    function downloadExcel() {

        $myFile = base_url()."/upload/testexcel.xls";

        header("Content-Length: " . filesize($myFile));

        header('Content-Type: application/vnd.ms-excel');

        header('Content-Disposition: attachment; filename=testexcel.xls');



        readfile($myFile);

    }

}

	

?>
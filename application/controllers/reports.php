<?php



#**************************************************************************************

# All reporting requests go through this controller

#**************************************************************************************



class Reports extends CI_Controller {

	#Constructor to set some default values at class load
	public function __construct()
    {
		   parent::__construct();	

		$this->load->model('sys_email','sysemail');

		date_default_timezone_set(SYS_TIMEZONE);

    }

    

    #function to show the add report form, save or update a report's details

	function add_report()

	{

		access_control($this);

		

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));

		# Pick all assigned data

		$data = assign_to_data($urldata);		

		

		#Get the report details if the user is editing

        if(!empty($data['i']))

		{

			$editid = decryptValue($data['i']);

			$data['formdata'] = $this->Query_reader->get_row_as_array('get_report_by_id', array('id'=> $editid) );

        }

		

		#Save the report details

		if($this->input->post('savereport'))

		{

			$required_fields = array('reportname');

			$_POST = clean_form_data($_POST);

			$validation_results = validate_form('', $_POST, $required_fields);

							

				

			#Only proceed if the validation for required fields passes

			if($validation_results['bool'])

			{

				$save_result = false;

				

				#Save/Update an existing report's details

				if(!empty($data['formdata']) && !empty($data['i']))

				{       

					$updateStr = '';

					#check if report has changed

					if(!empty($_FILES['fileurl']['tmp_name']))

					{

						$new_file_url = 'ny_'.strtotime('now').generate_random_letter().".".end(explode('.', $_FILES['fileurl']['name']));

						if(copy(str_replace("/kunden/", "/", $_FILES['fileurl']['tmp_name']), UPLOAD_DIRECTORY."reports/".$new_file_url)) 

						{				

							#Delete the previous report from the server if it exists

							if(!empty($data['formdata']['fileurl']))

								@unlink(UPLOAD_DIRECTORY."reports/".$data['formdata']['fileurl']);

							

							$save_result = $this->db->query($this->Query_reader->get_query_by_code('update_report', array('updatestring' => ', fileurl = \''.$new_file_url.'\' , uploadip = \''.get_ip_address().'\'', 'reportname' => $_POST['reportname'], 'id' => $editid)));

						}

					}

					else

					{

						$save_result = $this->db->query($this->Query_reader->get_query_by_code('update_report', array_merge($_POST, array('id' => $editid, 'updatestring' => '')) ));	

					}

					                                        

                }

				#Save a new report

				else

				{

					$new_file_url = 'ny_'.strtotime('now').generate_random_letter().".".end(explode('.', $_FILES['fileurl']['name']));

					

					#First move the report to the correct folder and then add the report

					if(copy(str_replace("/kunden/", "/", $_FILES['fileurl']['tmp_name']), UPLOAD_DIRECTORY."reports/".$new_file_url)) 

					{    					

						$save_result = $this->db->query($this->Query_reader->get_query_by_code('add_report', array('fileurl' => $new_file_url, 'reportname' => $_POST['reportname'], 'uploadip' => get_ip_address())));

					}

					

				}

			 

				if($save_result){

					$data['msg'] = "The report has been saved.";

					$this->session->set_userdata('sres', $data['msg']);

		

					redirect(base_url()."reports/manage_reports/m/sres");

				}

				else

				{

					$data['msg'] = "ERROR: The report was not saved. Please contact your administrator.";

				}

			} #VALIDATION end

			

			

			if((empty($validation_results['bool']) || (!empty($validation_results['bool']) && !$validation_results['bool'])) 

			&& empty($data['msg']) )

			{

				$data['msg'] = "WARNING: The highlighted fields are required.";

			}

			

			$data['requiredfields'] = $validation_results['requiredfields'];

			$data['formdata'] = $_POST;

			

		}

        

		

		$this->load->view('reports/add_report_view', $data);

	}

	

	#function to show the list of reports

	function manage_reports()

	{

		access_control($this);

		

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i', 'up'));

		# Pick all assigned data

		$data = assign_to_data($urldata);

		

		#Get the paginated list of the reports

		$data = paginate_list($this, $data, 'search_report_list', array('searchstring'=>' and isactive = \'Y\''));

	

		$data = add_msg_if_any($this, $data);

		$this->load->view('reports/manage_reports', $data);

	}

	

	#function to show the list of archived reports

	function report_archives()

	{

		access_control($this);

		

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i', 'up'));

		# Pick all assigned data

		$data = assign_to_data($urldata);

		

		#Get the paginated list of the reports

		$data = paginate_list($this, $data, 'search_report_list', array('searchstring'=>' and isactive = \'N\''));

	

		$data = add_msg_if_any($this, $data);

		$this->load->view('reports/report_archives', $data);

	}

	

	

	

	

	#function to show the access control list of a selected report

	function report_access_control()

	{

		access_control($this);

		

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i', 'up'));

		

		# Pick all assigned data

		$data = assign_to_data($urldata);

                

        if(!empty($data['i']))

		{

			$reportid = decryptValue($data['i']);

            $this->session->set_userdata('selectedreport', $data['i']);

                        

            $data['report_details'] = $this->Query_reader->get_row_as_array('get_report_by_id', array('id'=>$reportid));

			

            $users = $this->db->query($this->Query_reader->get_query_by_code('get_report_users', array('reportid'=>$reportid, 'searchstring' => '', 'limittext' => ' limit 0,'.NUM_OF_ROWS_PER_PAGE)));

			$data['page_list'] = $users->result_array();

		}

        else

		{

			$this->session->unset_userdata(array('selectedreport'=>''));

		}

		

        if( !empty($_POST['$reportid']))

		{

			$reportid = $_POST['dealid'];

			$data['i'] = encryptValue($reportid);

		}

		

		

		$data = add_msg_if_any($this, $data);

		$this->load->view('reports/report_access_control_view', $data);

	}

	

	#function to show authorized users of a selected report

	function report_access_list()

	{

		access_control($this);

		

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i', 'up'));

		

		# Pick all assigned data

		$data = assign_to_data($urldata);

		

		if(!empty($data['i']))

		{

			$reportid = decryptValue($data['i']);

            $this->session->set_userdata('selectedreport', $data['i']);

                        

            $data['report_details'] = $this->Query_reader->get_row_as_array('get_report_by_id', array('id'=>$reportid));

			

            $users = $this->db->query($this->Query_reader->get_query_by_code('get_report_users', array('reportid'=>$reportid, 'searchstring' => '', 'limittext' => ' limit 0,'.NUM_OF_ROWS_PER_PAGE)));

			$data['page_list'] = $users->result_array();

		}

        else

		{

			$this->session->unset_userdata(array('selectedreport'=>''));

		}

		

		$data['isviewing'] = TRUE;

		$data['area'] = 'selected_report_users';

		$this->load->view('incl/addons', $data);

		

	}

	

    #function to add a user to the report user list

    function select_report_user()

    {

    	access_control($this);

		

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));

		# Pick all assigned data

		$data = assign_to_data($urldata);

		

		#Add the user to the list of authorized report users

		if(!empty($data['i']) && !empty($data['reportid']))

		{	

			$result = $this->db->query($this->Query_reader->get_query_by_code('add_report_user', array('userid'=>decryptValue($data['i']), 'reportid'=>$data['reportid'])));

		}		

		

		$data['msg'] = (!empty($result) && $result)? "User added to the report list.": "ERROR: User could not be added to the report access list.";

				

		#get the required info to properly display the user details

		$data['report_details'] = $this->Query_reader->get_row_as_array('get_report_by_id', array('id'=>$data['reportid']));

		

        #Add user filter to query

        $report_user_str = "SELECT userid FROM reportaccess WHERE reportid =".$data['reportid'];

                

        $users = $this->db->query($this->Query_reader->get_query_by_code('get_report_user_list', array('reportid'=>$data['reportid'],'searchstring' => '', 'limittext' => 'limit 0,'.NUM_OF_ROWS_PER_PAGE, 'reportcond' => $report_user_str)));

		$data['page_list'] = $users->result_array();

		

		$data['area'] = "selected_report_users";

		$this->load->view('incl/addons', $data);

	}

        

        

    #Function to remove a user from the report access list

	function remove_report_user()

	{

		access_control($this);

		

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i',));

		

                # Pick all assigned data

		$data = assign_to_data($urldata);

		

		#Add the user to the list of users in the given report

		if(!empty($data['i']) && !empty($data['reportid']))

		{

			$result = $this->db->query($this->Query_reader->get_query_by_code('remove_user_report_access', array('userid'=>decryptValue($data['i']), 'reportid'=>$data['reportid'] )));

		}

		

		$data['msg'] = (!empty($result) && $result)? "User report access rights removed.": "ERROR: User report access rights could not be removed.";

		

    	#get the required info to properly display the user details

		$data['report_details'] = $this->Query_reader->get_row_as_array('get_report_by_id', array('id'=>$data['reportid']));

		

        #Add user filter to query

        $report_user_str = "SELECT userid FROM reportaccess WHERE reportid =".$data['reportid'];

                

        $users = $this->db->query($this->Query_reader->get_query_by_code('get_report_user_list', array('reportid'=>$data['reportid'],'searchstring' => '', 'limittext' => 'limit 0,'.NUM_OF_ROWS_PER_PAGE, 'reportcond' => $report_user_str)));

		$data['page_list'] = $users->result_array();

		$data['area'] = "selected_report_users";

		$this->load->view('incl/addons', $data);

	}

    

	

	

	#Function to delete a report

	function delete_report()

	{

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('i', 'm'));

		# Pick all assigned data

		$data = assign_to_data($urldata);

		

		if(!empty($data['i']))

		{

			$report = $this->Query_reader->get_row_as_array('get_report_by_id', array('id'=>decryptValue($data['i'])) );

			$result = $this->db->query($this->Query_reader->get_query_by_code('delete_report', array('id'=>decryptValue($data['i'])) ));

			

			if($result)

			{

				@unlink(UPLOAD_DIRECTORY."reports/".$report['fileurl']);

				

				$msg = "The report was deleted.";

			}

		}

		

		if(empty($result) || (!empty($result) && !$result))

		{

			$msg = "ERROR: The report was not deleted. Please contact your administrator.";

		}

		

		$this->session->set_userdata('rres', $msg);

		

		redirect(base_url()."reports/manage_reports/m/rres");

	}

	

	#Function to archive a report

	function archive_report()

	{

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('i', 'm'));

		# Pick all assigned data

		$data = assign_to_data($urldata);

		

		if(!empty($data['i']))

		{

			$result = $this->db->query($this->Query_reader->get_query_by_code('set_report_status', array('reportid'=>decryptValue($data['i']), 'status' => 'N') ));

			

			$msg = "The report was archived.";

		}

		

		if(empty($result) || (!empty($result) && !$result))

		{

			$msg = "ERROR: The report was not archived. Please contact your administrator.";

		}

		

		$this->session->set_userdata('rres', $msg);

		

		redirect(base_url()."reports/manage_reports/m/rres");

	}

	

	#Function to unarchive a report

	function unarchive_report()

	{

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('i', 'm'));

		# Pick all assigned data

		$data = assign_to_data($urldata);

		

		if(!empty($data['i']))

		{

			$result = $this->db->query($this->Query_reader->get_query_by_code('set_report_status', array('reportid'=>decryptValue($data['i']), 'status' => 'Y') ));

			

			$msg = "The report was unarchived.";

		}

		

		if(empty($result) || (!empty($result) && !$result)){

			$msg = "ERROR: The report was not unarchived. Please contact your administrator.";

		}

		

		$this->session->set_userdata('rres', $msg);

		

		redirect(base_url()."reports/report_archives/m/rres");

	}

    

	#function to show the list of reports for a user

	function report_list()

	{

		access_control($this);

		

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i', 'up'));

		# Pick all assigned data

		$data = assign_to_data($urldata);

		

		$isactive = (!empty($data['t']) && decryptValue($data['t']) == 'archive')? 'N': 'Y';

		#Get the paginated list of the reports

		$data = paginate_list($this, $data, 'get_user_report_list', array('userid'=>$this->session->userdata('userid'), 'isactive'=>$isactive, 'searchstring'=>''));

	

		$data = add_msg_if_any($this, $data);

		$this->load->view('reports/user_report_list_view', $data);

	

	}

}



?>
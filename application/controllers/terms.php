<?php

#**************************************************************************************

# All term actions go through this controller

#**************************************************************************************



class Terms extends CI_Controller {

	#Constructor to set some default values at class load
	public function __construct()
    {
		   parent::__construct();	

		$this->load->model('sys_email','sysemail');

		$this->load->model('school','myschool');

		$this->load->model('term','terms');

		date_default_timezone_set(SYS_TIMEZONE);

		$this->schoolinfo = $this->session->userdata('schoolinfo');

    }

	

	private $schoolinfo;

    	

    # Default to nothing

    function index()

    {

        #Do nothing

    }

    

	#Function to load the term data form

	function load_term_form()

	{		

		access_control($this);

		

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i','a'));

		# Pick all assigned data

		$data = assign_to_data($urldata);

                                

        #user is editing

		if(!empty($data['i']))

		{

			$termid = decryptValue($data['i']);

			

			$data['termdetails'] = $this->Query_reader->get_row_as_array('get_term_by_id', array('id'=>$termid ));

			

			#Check if the term belongs to the current user's school

			if($data['termdetails']['school'] != $this->schoolinfo['id'])

				$data['termdetails'] = array ();	

                        

            #Check if the user is simply viewing

            if(!empty($data['a']) && decryptValue($data['a']) == 'view')

            {

                $data['isview'] = "Y";

            }

		}

		

		$this->load->view('user/term_form_view', $data);

	}

	

	#Function to save a term

	function save_term()

	{

		access_control($this);

		

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i', 'a', 't'));

		

		# Pick all assigned data

		$data = assign_to_data($urldata);		

		

		$data = restore_bad_chars($data);

		

		if($data['save'])

		{ 

			$data['termdetails'] = $data;		

            $required_fields = array('term', 'year', 'startdate', 'enddate');

			$_POST = clean_form_data($data);

			$validation_results = validate_form('', $_POST, $required_fields);

                        

			#set status as editing on destination if updating

            //if($this->input->post('editid') || $data['editid']) $data['editid'] = $_POST['editid'];			

			

			#Only proceed if the validation for required fields passes

			if($validation_results['bool'])

			{   

                if(!empty($data['editid']))

                {

					#Check if another term other than the current one exists with the same name and year 

					$term_details  = $this->Query_reader->get_row_as_array('search_terms_list', array('limittext' => '', 'searchstring' => ' AND term = "'.$data['termdetails']['term'].'" AND id != '.$data['editid'].' AND school ='.$this->myschool->cur_school_details['id'].' AND year = "'.$data['termdetails']['year'].'"'));

					if(!count($term_details))

					{

						$result = $this->db->query($this->Query_reader->get_query_by_code('update_term', $_POST));

					}

					else

					{

						$termname_error = "WARNING: A term with the same name and year already exists.";

					}

           	  	}

			 	else 

             	{

					$term_details  = $this->Query_reader->get_row_as_array('search_terms_list', array('limittext' => '', 'searchstring' => ' AND isactive ="Y" AND term = "'.$data['termdetails']['term'].'" AND school ='.$this->myschool->cur_school_details['id'].' AND year = "'.$data['termdetails']['year'].'"'));

			                        

                	if(empty($term_details))

                	{

						#Add the school id

						$_POST = array_merge($_POST, array('school'=> $this->myschool->cur_school_details['id']));

						

						$result = $this->terms->add_term($_POST );

					}

        		}

				

           		#Format and send the errors

            	if(!empty($result) && $result)

				{					

					$data['msg'] = "The term data has been successfully saved";

					$data['termdetails'] = array();

            	 }

				 #Prepare a message in case the term already exists for this school

				 elseif(empty($data['editid']) && !empty($term_details))

            	 {

				 	$data['msg'] = "WARNING: A term with the same name and year already exists.<br />"; 

				 }

				 else if(empty($data['msg']))

            	 {

				   	$data['msg'] = "ERROR: The term could not be saved or was not saved correctly.";

             	 }

            }

            

			             

            if((empty($validation_results['bool']) || (!empty($validation_results['bool']) && !$validation_results['bool'])) 

			&& empty($data['msg']) )

			{

				$data['msg'] = "WARNING: The highlighted fields are required.";

			}

			

			$data['requiredfields'] = $validation_results['requiredfields'];

		}

		$this->load->view('incl/term_form', $data);

	}

	

	

	#Function to manage terms

	function manage_terms()

	{

		access_control($this);

		

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));

		

		# Pick all assigned data

		$data = assign_to_data($urldata);

		

		#Get the paginated list of the students

		$data = paginate_list($this, $data, 'search_terms_list', array('isactive'=>'Y', 'searchstring'=>' AND isactive=\'Y\' AND school = '.$this->schoolinfo['id']));

				

		$data = add_msg_if_any($this, $data);

		$this->load->view('user/manage_terms_view', $data);

	}

	

	#Function to delete a term

	function delete_term()

	{

		access_control($this);

		

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i', 't'));

		

		# Pick all assigned data

		$data = assign_to_data($urldata);

		

		if(!empty($data['i']))

			$result = deactivate_row($this, 'terms', decryptValue($data['i']));

		

		

		if(!empty($result) && $result){

			$this->session->set_userdata('dterm', "The term data has been successfully deleted.");

		}

		else if(empty($data['msg']))

		{

			$this->session->set_userdata('dterm', "ERROR: The term could not be deleted or was not deleted correctly.");

		}

		

		if(!empty($data['t']) && $data['t'] == 'super'){

			$tstr = "/t/super";

		}else{

			$tstr = "";

		}

		

	}

	

}



?>


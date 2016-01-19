<?php

#**************************************************************************************

# All student actions go through this controller

#**************************************************************************************



class Classes extends CI_Controller {

	#Constructor to set some default values at class load
	public function __construct()
    {
		   parent::__construct();

		parent::Controller();	

		$this->load->model('sys_email','sysemail');

		$this->load->model('class_mod','classobj');

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

	function load_class_form()

	{

		access_control($this);

		

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i','a'));

		

		# Pick all assigned data

		$data = assign_to_data($urldata);

		

                                

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

		

		$this->load->view('classes/class_form_view', $data);

	}

	

	#Function to save a class

	function save_class()

	{

		access_control($this);

		

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i', 'a', 't'));

		

		# Pick all assigned data

		$data = assign_to_data($urldata);	

		

		$data = restore_bad_chars($data);	

		

		if($data['save'])

		{ 

			$data['classdetails'] = $data;		

            $required_fields = array('class', 'rank');

			$_POST = clean_form_data($data);

			$validation_results = validate_form('', $_POST, $required_fields);

			$classname_error = '';

			$rank_error = '';

                        

			#set status as editing on destination if updating

            if($this->input->post('editid')) $data['editid'] = $_POST['editid'];			

			

			#Only proceed if the validation for required fields passes

			if($validation_results['bool'] && !(empty($data['editid']) && !empty($user_details)))

			{   

                if(!empty($_POST['editid']))

                {

					#Check if another class other than the current one exists with the same name 

					$class_details  = $this->Query_reader->get_row_as_array('search_classes_list', array('limittext' => '', 'searchstring' => ' AND class = "'.$data['classdetails']['class'].'" AND id != '.$data['editid'].' AND school ='.$this->myschool['id']));

					

					#Also check for the same rank

					$rank_details  = $this->Query_reader->get_row_as_array('search_classes_list', array('limittext' => '', 'searchstring' => ' AND id != '.$data['editid'].' AND rank ='.$data['classdetails']['rank'].' AND school ='.$this->myschool['id']));

					

					if(empty($term_details) && empty($rank_details))

					{

						#Add the school id and author to the data array

						$_POST = array_merge($_POST, array('school'=> $this->myschool['id'], 'author' => $this->session->userdata('userid')));

						

						$result = $this->classobj->update_class(array_merge($_POST, array('id'=> $data['editid'])));

					}

					else

					{

						if (!empty($class_details)) $classname_error = "<br />WARNING: A class with the same name already exists.";

						if (!empty($rank_details)) $rank_error = "<br />WARNING: A class (".$rank_details['class'].") with the same rank already exists.";

					}

           	  	}

			 	else 

             	{

					#Check if class name exists 

					$class_details  = $this->Query_reader->get_row_as_array('search_classes_list', array('limittext' => '', 'searchstring' => ' AND class = "'.$data['classdetails']['class'].'" AND school ='.$this->myschool['id']));

					

					#Also check for the same rank

					$rank_details  = $this->Query_reader->get_row_as_array('search_classes_list', array('limittext' => '', 'searchstring' => ' AND rank ='.$data['classdetails']['rank'].' AND school ='.$this->myschool['id']));

			                        

                	if(empty($class_details) && empty($rank_details))

                	{

						#Add the school id and author to the data array

						$_POST = array_merge($_POST, array('school'=> $this->myschool['id'], 'author' => $this->session->userdata('userid')));

						

						$result = $this->classobj->add_class($_POST );

					}

					else

					{

						if (!empty($class_details)) $classname_error = "<br />WARNING: A class with the same name already exists.";

						if (!empty($rank_details)) $rank_error = "<br />WARNING: A class (".$rank_details['class'].") with the same rank already exists.";

					}

        		}

				

           		#Format and send the errors

            	if(!empty($result) && $result)

				{					

					$data['msg'] = "The class data has been successfully saved.";

					$data['classdetails'] = array();

            	 }

            	 else if(empty($data['msg']))

            	 {

				   	$data['msg'] = "ERROR: The class could not be saved or was not saved correctly.".$classname_error.$rank_error;

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

         

                

		$this->load->view('incl/class_form', $data);

	}

	

	#Function to manage classes

	function manage_classes()

	{

		access_control($this);

		

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));

		

		# Pick all assigned data

		$data = assign_to_data($urldata);

		

		#Get the paginated list of the students

		$current_term_arr = current_term($this, $this->myschool['id']);

		$current_term_id = (!empty($current_term_arr))? $current_term_arr['id'] : 0;

		

		$data = paginate_list($this, $data, 'search_classes_register', array('isactive'=>'Y', 'term'=>$current_term_id, 'school'=> $this->myschool['id']));

				

		$data = add_msg_if_any($this, $data);

		$this->load->view('classes/manage_classes_view', $data);

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


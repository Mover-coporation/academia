<?php

#**************************************************************************************

# All school setting actions go through this controller

#**************************************************************************************



class Schoolsettings extends CI_Controller {

	#Constructor to set some default values at class load
	public function __construct()
    {
		 parent::__construct();	
		 
		$this->load->model('sys_email','sysemail');

		$this->load->model('class_mod','classobj');

		$this->load->model('term','terms');

		date_default_timezone_set(SYS_TIMEZONE);

		$this->myschool = $this->session->userdata('schoolinfo');

    }

	

	var $myschool;

    

    # Default to nothing

    function index()

    {

        #Do nothing

    }

    	

	

	#Function to load the manage settings view

	function manage_settings()

	{

		access_control($this);

		

		# Get the passed details into the url data array if any

		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));

		

		# Pick all assigned data

		$data = assign_to_data($urldata);

						

		$data = add_msg_if_any($this, $data);

		

		#default to curriculum settings

		$data = paginate_list($this, $data, 'search_subjects', array('isactive'=>'Y', 'searchstring'=>' AND school = '.$this->myschool['id']));

		

		$this->load->view('settings/manage_settings_view', $data);

	}

	

}



?>


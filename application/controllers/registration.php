<?php

#**************************************************************************************

# All school setting actions go through this controller

#**************************************************************************************



class Registration extends CI_Controller {

	#Constructor to set some default values at class load
	public function __construct()
    {
		parent::__construct();	
		$this->load->model('sys_email','sysemail');
		$this->load->model('class_mod','classobj');
		$this->load->model('term','terms');
		$this->load->model('account','account');
		date_default_timezone_set(SYS_TIMEZONE);

    }
	
	function index()
	{
		redirect('registration/register_user_account');
	}
 
	
	#Register User Account
	public function register_user_account(){
		
		#$data = filter_forwarded_data($this);
		#check_access($this, 'add_new_school');
		$urldata = $this->uri->uri_to_assoc(3, array('m', 'p'));
		# Pick all assigned data
		$data = assign_to_data($urldata);
		
		#When creating new Account 
		if(isset($_POST['register_account']))
		{
			$data = $this->account->new_account();
			if(!empty($data['ERROR']))
			{
				echo $data['ERROR'];
				$this->load->view('account/register',$data);
			}
			elseif($data['SUCCESS'])
			{
				redirect('registration/register_school_account');
				//redirect("register_school_account");				
			}
			
			//print_r($result);	
		  
		}
		else
		{
		#load acouunt  register form :: 
		$this->load->view('account/register');
		}
	 
	
	}
	
	
	#Register User Account
	public function view_user_account(){}
	
	
	#Edit Delete User Account(s)
	public function manage_user_account(){}
	
	
	#Register School Account
	public function register_school_account(){
	
	#save school account
    if(isset($_POST['register_school_account']))
	{
		$data = $this->account->register_scrhool();	
		  $this->load->view('account/schoolregistration',$data);
	}
	
	#step 2 : load school account
	else if(!empty($_SESSION['account_email']) && !empty($_SESSION['account_name']) && !empty($_SESSION['account_password']) )
	{
		$data = array(
		'account_email'=>$_SESSION['account_email'],
		'account_name'=>$_SESSION['account_name'],
		'account_password'=>$_SESSION['account_password']
		 );
		 
		 $result = $this->account->check_academia_account($data);
		 
		 if(!empty($result))
		 {
			 #success
			 if($result['SUCCESS'] == "ACCOUNT  EXISTS")
			 {
				  #print_r($result['academia_account']);
				  $data =  $result['academia_account'];	
				  $account_id =  $data[0]['id'];
				
				  #get schools under this Account 				
				  $data['schools_associated'] =  $this->account->get_academia_schools($account_id);
				  
			
				  
				  
				  $this->load->view('account/schoolregistration',$data);
				  
				  
				 
				 			  
				  
			 }
			 else
			 {
				  $this->load->view('account/register');
			 }
		 }
		
    #check academia account 
	}
	#Go Back to Level 1
	else
	{ 
		   $this->load->view('account/register');
	}
	
	}
	
	
	#Register School Account
	public function view_school_account(){}
	
	
	#REdit Delete School Account(s)
	public function manage_school_account(){}
	
	
	
	#Register School Package
	public function register_school_package(){}
	
	
	#REdit Delete School Package(s)
	public function manage_school_package(){}
	
	
	
 
	

}



?>


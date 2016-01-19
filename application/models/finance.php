<?php



class Finance  extends CI_Model
{

	

	#Constructor

	function Finance()

	{

		 

		$this->load->model('Query_reader', 'Query_reader', TRUE);

	}

		

	#function to save a new fee

	function add_fee($feedetails)

	{

		#TO DO : always make sure the school key exists and is not empty

		$query = $this->Query_reader->get_query_by_code('add_fee', $feedetails);

		$result = $this->db->query($query);

		return $result;

	}

	

	#function to update a fee

	function update_fee($feedetails)

	{

		#TO DO : always make sure the school key exists and is not empty

		$query = $this->Query_reader->get_query_by_code('update_fee', $feedetails);

		$result = $this->db->query($query);

		return $result;

	}

	

	#function to list of fees

	function get_fees_structure($school = '')

	{

		$termdetails = array();

		#By default get the current user's school fee structure

		if($school == '' && $this->session->userdata('usertype') == 'SCHOOL')

		{

			$schooldetails = $this->session->userdata('schoolinfo');

			$query = $this->Query_reader->get_query_by_code('get_terms_by_school', array('school' => $schooldetails['id']) );

			$result = $this->db->query($query);

			$termdetails = $result->result_array();

		}

		else

		{

			#Only system admins can see terms of other schools

			if($this->session->userdata('usertype') == 'MSR')

			{

				#Admins also have to specify the school whose terms they would like to view

				if($school == '')

				{

					$termdetails['msg'] = "No school was specified";

				}

				else

				{

					$query = $this->Query_reader->get_query_by_code('get_terms_by_school', array('school' => $school));

					$result = $this->db->query($query);

					$termdetails = $result->results_array();

				}				

			}

		}

		

		return $termdetails;	

	}

	

	

	#function to update an account

	function update_account($accountdetails)

	{

		#TO DO : always make sure the school key exists and is not empty

		$query = $this->Query_reader->get_query_by_code('update_account', $accountdetails);

		$result = $this->db->query($query);

		return $result;

	}

	

	

	#function to save a petty cash transaction

	function save_account($accountdetails)

	{

		#TO DO : always make sure the school key exists and is not empty

		$query = $this->Query_reader->get_query_by_code('save_account', $accountdetails);

		$result = $this->db->query($query);

		return $result;

	}

	

	

	#function to save a petty cash transaction

	function save_petty_cash_transction($transactiondetails)

	{

		#TO DO : always make sure the school key exists and is not empty

		$query = $this->Query_reader->get_query_by_code('save_petty_cash_transaction', $transactiondetails);

		$result = $this->db->query($query);

		return $result;

	}

}



?>
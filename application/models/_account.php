<?php



class Account  extends CI_Model
{

	

	#Constructor
	function account(){
		$this->load->model('Query_reader', 'Query_reader', TRUE);
		$this->cur_school_details = $this->session->userdata('schoolinfo');
	}

	

	var $cur_school_details;

		

	#function to save a new school

	function add_school($termdetails)

	{

		$query = $this->Query_reader->get_query_by_code('add_term', $studentdetails);

		$result = $this->db->query($query);

		return $result;

	}

	

	#function to retrieve paginated list of schools

	function get_terms($school = '')

	{

		$termdetails = array();

		#By default get the current user's school terms

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

	

}



?>
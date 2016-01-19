<?php



class Term  extends CI_Model
{

	

	#Constructor

	function Term()

	{

		 
		$this->load->model('Query_reader', 'Query_reader', TRUE);

	}

		

	#function to save a new term

	function add_term($termdetails)

	{

		#TO DO : always make sure the school key exists and is not empty

		$query = $this->Query_reader->get_query_by_code('add_term', $termdetails);

		$result = $this->db->query($query);

		return $result;

	}

	

	#function to list of terms

	function get_terms($school = '', $searchstring='', $order_by = 'ASC')

	{

		$termdetails = array();

		#By default get the current user's school terms

		if($school == '' && $this->session->userdata('usertype') == 'SCHOOL')

		{

			$schooldetails = $this->session->userdata('schoolinfo');

			$query = $this->Query_reader->get_query_by_code('get_terms_by_school', array('school' => $schooldetails['id'], 'searchstring'=>$searchstring, 'orderby'=>$order_by));

            $result = $this->db->query($query);

            #exit($query);

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

					$query = $this->Query_reader->get_query_by_code('get_terms_by_school', array('school' => $school, 'searchstring'=>$searchstring, 'orderby'=>$order_by));

					$result = $this->db->query($query);

					$termdetails = $result->results_array();

				}

				

			}

		}

		

		return $termdetails;	

	}

	

	#function to get current term details

	function current_term()

	{

		

	}

	

}



?>
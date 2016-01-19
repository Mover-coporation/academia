<?php



class Sponsor  extends CI_Model
{

	

	#Constructor

	function Sponsor()

	{

		 

		$this->load->model('Query_reader', 'Query_reader', TRUE);

	}

		

	#function to save a new sponsor

	function add_sponsor($sponsordetails)

	{

		#TO DO : always make sure the school key exists and is not empty

		$query = $this->Query_reader->get_query_by_code('add_sponsor', $sponsordetails);

		$this->db->query($query);

		return $this->db->affected_rows();	

	}

	

	#function to list of sponsors

	function get_sponsors($school = '', $limittext = '', $order_by ='firstname')

	{

		$termdetails = array();

		#By default get the current user's school terms

		if($school == '' && $this->session->userdata('usertype') == 'SCHOOL')

		{

			$schooldetails = $this->session->userdata('schoolinfo');

			$query = $this->Query_reader->get_query_by_code('search_sponsors', array('searchstring' => ' AND school =' . $schooldetails['id'], 'limittext'=>$limittext, 'orderby'=>$order_by));

			$result = $this->db->query($query);

			$sponsors = $result->result_array();

		}

		else

		{

			#Only system admins can see all sponsors

			if($this->session->userdata('usertype') == 'MSR')

			{

				#Admins also have to specify the school whose terms they would like to view

				if($school == '')

				{

					$termdetails['msg'] = "No school was specified";

				}

				else

				{

					$query = $this->Query_reader->get_query_by_code('search_sponsors', array('school' => $school));

					$result = $this->db->query($query);

					$sponsors = $result->results_array();

				}

				

			}

		}



		return $sponsors;	

	}

	

	

	#function to save a student's sponsor

	function add_student_sponsor($studentsponsordetails)

	{

		#TO DO : always make sure the school key exists and is not empty

		$query = $this->Query_reader->get_query_by_code('add_student_sponsor', $studentsponsordetails);

		$this->db->query($query);

		return $this->db->affected_rows();	

	}



	

	#function to update a sponsor's details

	function update_sponsor($sponsordetails)

	{

		#TO DO : always make sure the school key exists and is not empty

		$query = $this->Query_reader->get_query_by_code('update_sponsor_info', $sponsordetails);

		$this->db->query($query);

		return $this->db->affected_rows();	

	}

	

	#function to delete a sponsor

	function delete($sponsordetails)

	{

	

	}

	

}



?>
<?php



class Discipline_mod  extends CI_Model
{

	

	#Constructor

	function Discipline_mod()

	{

	 

		$this->load->model('Query_reader', 'Query_reader', TRUE);

	}

		

	#function to save an incident

	function add_incident($incidentdetails)

	{

		$query = $this->Query_reader->get_query_by_code('add_incident', $incidentdetails);

		$result = $this->db->query($query);

		return $result;

	}

	

	#function to update an incident

	function update_incident($incidentdetails)

	{

		$query = $this->Query_reader->get_query_by_code('update_class_details', $classdetails); 

		$result = $this->db->query($query);

		return $result;

	}

	

	#function to save a new stream

	function add_stream($streamdetails)

	{

		$query = $this->Query_reader->get_query_by_code('add_stream', $streamdetails);

		$result = $this->db->query($query);

		return $result;

	}

	

	#function to save a deactivate a class

	function deactivate_class($streamdetails)

	{

		

	}

	

	#function to get list of classes

	function get_classes($school = '', $searchstr = '')

	{

		$classes = array();

		#By default get the current user's school classes

		if($school == '' && $this->session->userdata('usertype') == 'SCHOOL')

		{

			$schooldetails = $this->session->userdata('schoolinfo');

			$query = $this->Query_reader->get_query_by_code('get_classes_list', array('limittext' => '', 'searchstring' => ' AND school ='.$schooldetails['id'].$searchstr, 'isactive' => 'Y') );

			$result = $this->db->query($query);

			$classes = $result->result_array();

		}

		else

		{

			#Only system admins can see terms of other schools

			if($this->session->userdata('usertype') == 'MSR')

			{

				#Admins also have to specify the school whose terms they would like to view

				if($school == '')

				{

					$classes['msg'] = "No school was specified";

				}

				else

				{

					$query = $this->Query_reader->get_query_by_code('get_terms_by_school', array('school' => $school));

					$result = $this->db->query($query);

					$classes = $result->results_array();

				}

				

			}

		}

		

		return $classes;	

	}

	

	

	#function to get fees structure of a class for a particular term

	function get_class_fees($class, $term, $school='', $fee_type='ALL')

	{

		$classes = array();

		$fees = array();

		#By default get the current user's school class fees

		if($school == '' && $this->session->userdata('usertype') == 'SCHOOL')

		{

			$schooldetails = $this->session->userdata('schoolinfo');

			$query = $this->Query_reader->get_query_by_code('search_fees_list', array('limittext' => '', 'searchstring' => ' AND school ='.$schooldetails['id'].' AND classes like "%|'.$class.'|%" AND term ='.$term.(($fee_type == 'ALL')? '' : ' AND frequency ="Termly"' ), 'isactive' => 'Y'));

			$result = $this->db->query($query);

			$fees = $result->result_array();

		}

		else

		{

			#Only system admins can see class fees structure of other schools

			if($this->session->userdata('usertype') == 'MSR')

			{

				#Admins also have to specify the school whose terms they would like to view

				if($school == '')

				{

					$fees['msg'] = "No school was specified";

				}

				else

				{

					$query = $this->Query_reader->get_query_by_code('search_fees_list', array('limittext' => '', 'searchstring' => ' AND school ='.$schooldetails['id'].' AND class like "%'.$class.'% AND term ='.$term, 'isactive' => 'Y'));

					$result = $this->db->query($query);

					$fees = $result->results_array();

				}				

			}

		}

		

		return $fees;	

	}

	

}



?>
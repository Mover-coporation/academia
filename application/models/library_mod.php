<?php

/**

* 

*/

class library_mod  extends CI_Model
{

	

	// function library()

	function __construct()

	{

		# code... 

		$this->load->model('Query_reader', 'Query_reader', TRUE);

	}

	

	#function to save a new book

	function add_book($bookdetails)

	{

		$query = $this->Query_reader->get_query_by_code('add_stock', $bookdetails);

		$result = $this->db->query($query);

		return $result;

	}



	#function to stock a new book

	function update_book($bookdetails)

	{

		$query = $this->Query_reader->get_query_by_code('insert_stock', $bookdetails);

		$result = $this->db->query($query);

		return $result;

	}

	

	function add_transaction_headers($headerdetails)

	{

		$query = $this->Query_reader->get_query_by_code('add_library_transaction_headers', $headerdetails);

		$result = $this->db->query($query);

		return $result;

	}

	

	function add_transaction_details($values)

	{

		#if argument array contains index values then multiple transaction details

		if(!empty($values['values']))

		{

			$query = $this->Query_reader->get_query_by_code('add_library_transaction_details', $values);

		}

		else

		{

			$query = $this->Query_reader->get_query_by_code('add_single_library_transaction', $values);

		}		 

				

		$result = $this->db->query($query);

		return $result;

	}

	

	function update_library_books_status($data)

	{

		$query = $this->Query_reader->get_query_by_code('update_library_stock_status', $data);

		$result = $this->db->query($query);

		return $result;

	}





	

	#function to get a list of stock items

	function list_stock()

	{

		#empty

	}



	#function to get list of classes

	function get_books($school = '', $searchstr = '')

	{

		$stock = array();

		#By default get the current user's school classes

		if($school == '' && $this->session->userdata('usertype') == 'SCHOOL')

		{

			$schooldetails = $this->session->userdata('schoolinfo');

			$query = $this->Query_reader->get_query_by_code('get_stock_list', array('limittext' => '', 'searchstring' => ' school ='.$schooldetails['id'].$searchstr, 'isactive' => 'Y') );

			$result = $this->db->query($query);

			$stock = $result->result_array();

		}

		else

		{

			#Only system admins can see terms of other schools

			if($this->session->userdata('usertype') == 'MSR')

			{

				#Admins also have to specify the school whose terms they would like to view

				if($school == '')

				{

					$stock['msg'] = "No stock was specified";

				}

				else

				{

					$query = $this->Query_reader->get_query_by_code('get_stock_by_school', array('school' => $school));

					$result = $this->db->query($query);

					$stock = $result->results_array();

				}

				

			}

		}

		

		return $stock;	

	}



	function get_sections($school = '')

	{

		$sectiondetails = array();

		#By default get the current user's school classes

		if($school == '' && $this->session->userdata('usertype') == 'SCHOOL')

		{

			$schooldetails = $this->session->userdata('schoolinfo');

			$query = $this->Query_reader->get_query_by_code('get_sections', array('school ='.$schooldetails['id']) );

			$result = $this->db->query($query);

			$sectiondetails = $result->result_array();

		}



		else

		{

			#Only system admins can see terms of other schools

			if($this->session->userdata('usertype') == 'MSR')

			{

				#Admins also have to specify the school whose terms they would like to view

				if($school == '')

				{

					$sectiondetails['msg'] = "No section was specified";

				}

				else

				{

					$query = $this->Query_reader->get_query_by_code('get_sections', array('school' => $school));

					$result = $this->db->query($query);

					$sectiondetails = $result->results_array();

				}				

			}

		}

		

		return $sectiondetails;	

	}



		#function to get list of classes

	function get_authors($school = '', $searchstr = '')

	{

		$author = array();

		#By default get the current user's school classes

		if($school == '' && $this->session->userdata('usertype') == 'SCHOOL')

		{

			$schooldetails = $this->session->userdata('schoolinfo');

			$query = $this->Query_reader->get_query_by_code('get_stock', array('limittext' => '', 'searchstring' => ' school ='.$schooldetails['id'].$searchstr, 'isactive' => 'Y') );

			$result = $this->db->query($query);

			$author = $result->result_array();

		}

		else

		{

			#Only system admins can see terms of other schools

			if($this->session->userdata('usertype') == 'MSR')

			{

				#Admins also have to specify the school whose terms they would like to view

				if($school == '')

				{

					$author['msg'] = "No stock was specified";

				}

				else

				{

					$query = $this->Query_reader->get_query_by_code('get_stock_by_school', array('school' => $school));

					$result = $this->db->query($query);

					$author = $result->results_array();

				}

				

			}

		}

		

		return $author;	

	}



	// #get the names of students for autocompletion on the form



    function Autocomplete( $term )

      {

        

        // $query = $this->CI->db

        $query = $this->db

            ->select( " firstname, 

                        lastname,

                        studentno, 

                        id", 

                        FALSE)

            ->from('students')

            // ->group_by('studentno')

            ->like('firstname', $term, 'both');

            

        return $query->get()->result();

    } 



    // #get the names of students for autocompletion on the form



    function Autocompleteisbn( $term )

      {

        

        // $query = $this->CI->db

        $query = $this->db

            ->select( " isbnnumber,

            			

                        stocktitle", 

                         

                        FALSE)

            ->from('library, librarystock')

            // ->group_by('studentno')

            ->like('isbnnumber', $term, 'both');

            

        return $query->get()->result();

        // SELECT stocktitle,isbnnumber FROM library,librarystock where librarystock.id = library.stockid;

    } 



	

 }



?>
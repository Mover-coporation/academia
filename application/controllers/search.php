<?php 

#*********************************************************************************
# Performs search functions for the system
#*********************************************************************************

class Search extends CI_Controller {

	#Constructor to set some default values at class load
	public function __construct()
    {
		   parent::__construct();
		$this->load->model('users','user1');
		$this->load->model('sys_email','sysemail');
		$this->load->model('users','user1');
		$this->session->set_userdata('page_title','Settings');
		date_default_timezone_set(SYS_TIMEZONE);
		$this->schoolinfo = $this->session->userdata('schoolinfo');
	}
	
	var $schoolinfo;
	
	var $paginate_result;
		
	# Default to nothing
	function index()
	{
		#Do nothing
	}
	
	
	#Shows the search home page
	function home()
	{
		# Get the passed details into the form data array if any
		$urldata = $this->uri->uri_to_assoc(3, array('p'));
		
		# Pick all assigned data
		$data = assign_to_data($urldata);		
		
		$this->load->view('search/search_home_view', $data);
	}
	
	
	#Shows the search result page
	function search_result()
	{
		# Get the passed details into the form data array if any
		$urldata = $this->uri->uri_to_assoc(3, array('d'));
		# Pick all assigned data
		$data = assign_to_data($urldata);
		
		$this->session->set_userdata('diseaseid', decryptValue($data['d']));
		$data['disease'] = $this->wikimanager->get_active_disease_version(decryptValue($data['d']), 30);
		
		$data = add_msg_if_any($this, $data);
		$this->load->view('search/search_result_view', $data);
	}
	
	
	#Searches database based on passed values and returns a list of appropriate items that qualify
	function load_results()
	{	
		# Get the passed details into the form data array if any
		$urldata = $this->uri->uri_to_assoc(3, array('searchfield', 'phrase', 'type'));
		
		# Pick all assigned data
		$data = assign_to_data($urldata);


        #print_r($data);
        #echo "<br/>";
        # exit();
		#Pick Student data
		$schooldetails = $this->session->userdata('schoolinfo');


		# user has just clicked submit
		if(isset($_POST) && $this->input->post('searchbutton'))
		{
			$urldata['searchfield'] = $this->input->post('searchby');
			$urldata['phrase'] = $this->input->post('search');
			$data = assign_to_data($urldata);
			$data['userdetails'] = $this->session->userdata('alluserdata');
		}
		
		$urldata['phrase'] = addslashes(restore_bad_chars($urldata['phrase']));
        #print_r($urldata);
        #exit();
		#Searching for students
		if(isset($data['type']) && (in_array($data['type'], array('students', 'classes', 'register_student', 'student_leave','admission'))))
		{
           /* if(isset($_SESSION['searchstring'])){
                unset($_SESSION['searchstring']);
                echo "like it"; exit();
            } */

           # unset( $_SESSION['student_search_str']['searchstring']);
			$search_string = '';
            if(!empty($data['searchfield']))
            {
                $search_field_array = explode('__', $data['searchfield']);
                $count = 0;
                foreach($search_field_array AS $field)
                {
                    if($count != 0)
                    {
                        $search_string .= " OR ";
                    }
                    $search_string .= $field." LIKE '%".trim($urldata['phrase'])."%'";
                    $count++;
                }
            }

            $data['view_leave'] = ($data['type'] == 'student_leave')? TRUE : FALSE;

            #Determine which query to use to search
            #$query = $this->Query_reader->get_query_by_code('get_student_sponsor_list', array('isactive' => 'Y','searchstring'=>' AND students.school='.$this->schoolinfo['id']." AND (".$search_string.")", 'limittext'=>" LIMIT 0, 30"));
            #echo $query ."<br />";
            #$data = paginate_list($this, $data, 'get_student_sponsor_list', array('isactive'=>'Y', 'searchstring'=>' AND students.school = '.$schooldetails['id']),30);

            switch($data['type'])
            {
                case 'register_student':
                    $data['area'] = 'register_student';
                    break;

                default:
                    $data['area'] = 'student_list';
                    break;
            }

            if($data['type'] == 'classes')
            {
                $search_string = ($data['class'] != 'null')? ' AND classes.id = "' . $data['class'] .'" ' : '' ;
                $search_string .= ($data['term'] != 'null')? ' AND register.term = "' . $data['term'] .'" ' : '' ;
                $data = paginate_list($this, $data, 'search_students_by_term_and_class',
                    array('isactive' => 'Y',
                        'searchstring'=>$search_string,
                        'school'=> $this->schoolinfo['id'],
                        'lastname'=>($urldata['phrase'] == 'null'? '' : $urldata['phrase']),
                        'firstname'=>($urldata['phrase'] == 'null'? '' : $urldata['phrase']),
                        'studentno'=>($urldata['phrase'] == 'null'? '' : $urldata['phrase']),
                        'sponsorfirstname'=>($urldata['phrase'] == 'null'? '' : $urldata['phrase']),
                        'sponsorlastname'=>($urldata['phrase'] == 'null'? '' : $urldata['phrase'])), 30);

                $_SESSION['student_search_str']['searchstring'] = $search_string;
                $_SESSION['student_search_str']['phrase'] = ($urldata['phrase'] == 'null'? '' : $urldata['phrase']);
            }
            else  if($data['type'] == 'admission')
            {
                $search_string = ($data['class'] != 'null')? ' AND  students.admissionclass = "' . $data['class'] .'" ' : '' ;
                $search_string .= ($data['term'] != 'null')? ' AND  register.term= "' . $data['term'] .'" ' : '' ;
                $data = paginate_list($this, $data, 'search_students_by_term_and_class',
                    array('isactive' => 'Y',
                        'searchstring'=>$search_string,
                        'school'=> $this->schoolinfo['id'],
                        'lastname'=>($urldata['phrase'] == 'null'? '' : $urldata['phrase']),
                        'firstname'=>($urldata['phrase'] == 'null'? '' : $urldata['phrase']),
                        'studentno'=>($urldata['phrase'] == 'null'? '' : $urldata['phrase']),
                        'sponsorfirstname'=>($urldata['phrase'] == 'null'? '' : $urldata['phrase']),
                        'sponsorlastname'=>($urldata['phrase'] == 'null'? '' : $urldata['phrase'])), 30);

                $_SESSION['student_search_str']['searchstring'] = $search_string;
                $_SESSION['student_search_str']['phrase'] = ($urldata['phrase'] == 'null'? '' : $urldata['phrase']);
            }
            else
            {
                if($this->session->userdata('student_search_str')) {
               $var = $this->session->userdata('student_search_str');


                if (strpos($var['searchstring'],'classes') !== false) {

                    $data = paginate_list($this, $data, 'search_students_by_term_and_class',
                        array('isactive' => 'Y',
                            'searchstring'=>$var['searchstring'],
                            'school'=> $this->schoolinfo['id'],
                            'school'=> $this->schoolinfo['id'],
                            'lastname'=>($urldata['phrase'] == 'null'? '' : $urldata['phrase']),
                            'firstname'=>($urldata['phrase'] == 'null'? '' : $urldata['phrase']),
                            'studentno'=>($urldata['phrase'] == 'null'? '' : $urldata['phrase']),
                            'sponsorfirstname'=>($urldata['phrase'] == 'null'? '' : $urldata['phrase']),
                            'sponsorlastname'=>($urldata['phrase'] == 'null'? '' : $urldata['phrase'])), 30);
                }
                else if (strpos($var['searchstring'],'admission') !== false) {
                  #  print_r($search_string);
                  $sear = '';
                 #   exit();
                 #   $search_string = 'e';
                    $data = paginate_list($this, $data, 'search_students_by_term_and_class',
                        array('isactive' => 'Y',
                            'searchstring'=>$var['searchstring'],
                            'school'=> $this->schoolinfo['id'],
                            'school'=> $this->schoolinfo['id'],
                            'lastname'=>($urldata['phrase'] == 'null'? '' : $urldata['phrase']),
                            'firstname'=>($urldata['phrase'] == 'null'? '' : $urldata['phrase']),
                            'studentno'=>($urldata['phrase'] == 'null'? '' : $urldata['phrase']),
                            'sponsorfirstname'=>($urldata['phrase'] == 'null'? '' : $urldata['phrase']),
                            'sponsorlastname'=>($urldata['phrase'] == 'null'? '' : $urldata['phrase'])), 30);
                   # print_r($var);
                  #  exit;
                }
                }
                else{

//                print_r($var['searcstring']);
                $data = paginate_list($this, $data, 'get_student_sponsor_list', array('isactive' => 'Y','searchstring'=>' AND students.school='.$this->schoolinfo['id']." AND (".$search_string.")"),30);
                     }
            }

            $this->paginate_result = 1;
        }



		#Searching for borrowers
		else if(isset($data['type']) && $data['type'] == 'borrowers')
		{
			$search_string = '';
			$search_field_array = explode('__', $data['searchfield']);
			$count = 0;			
			
			$query = $this->Query_reader->get_query_by_code('search_students_users', array('isactive'=>'Y', 'school'=> $schooldetails['id'], 'firstname'=> trim($urldata['phrase']), 'lastname'=> trim($urldata['phrase']), 'limittext'=>" LIMIT 0,".NUM_OF_ROWS_PER_PAGE." "));
			
			#echo $query."<BR><BR>";
			$data['area'] = 'borrower_list';
		}
		
		#Searching for books
		else if(isset($data['type']) && $data['type'] == 'library_books')
		{
			$search_string = '';
			$count = 0;			
			
			#exclude already added books
			$selected_books = !empty($urldata['selectedBooks']) ? explode('_', $urldata['selectedBooks']) : '';
			$selected_books_str = '()';
			
			if(!empty($selected_books))
			{
				$selected_books_str = ' AND `library`.`id` NOT IN ("' . str_replace('_', '","', $urldata['selectedBooks']) . '")';
			}else{
				$selected_books_str = '';
			}
			
			$query = $this->Query_reader->get_query_by_code('search_library_with_titles', array('isactive'=>'Y', 'school'=> $schooldetails['id'], 'author'=> trim($urldata['phrase']),'searchstring'=> $selected_books_str, 'stocktitle'=> trim($urldata['phrase']), 'isbnnumber'=> trim($urldata['phrase']), 'limittext'=>" LIMIT 0,".NUM_OF_ROWS_PER_PAGE." "));
			#print_r ($urldata);
			#echo $query."<BR><BR>";
			#print $urldata['selectedBooks'];
			$data['area'] = 'library_books';
		}
		
		
		#Searching inventory status
		else if(isset($data['type']) && $data['type'] == 'inventory_status')
		{	
			$data = paginate_list($this, $data, 'search_library_transactions_with_titles', array('isactive'=>'Y', 'school'=> $schooldetails['id'], 'author'=> trim($urldata['phrase']), 'stocktitle'=> trim($urldata['phrase']), 'isbnnumber'=> trim($urldata['phrase'])), 20);
			
			$this->paginate_result = 1;
			
			#print_r ($urldata);
			#echo $query."<BR><BR>";
			#print $urldata['selectedBooks'];
			$data['area'] = 'inventory_status';
			
			$this->paginate_result = 1;
		}
		
		
		#Searching for item list
		else if(isset($data['type']) && $data['type'] == 'in_inventory_list')
		{
			$search_string = '';
			$search_field_array = explode('__', $data['searchfield']);
			$count = 0;
			foreach($search_field_array AS $field)
			{
				if($count != 0)
				{
					$search_string .= " OR ";
				}
				$search_string .= $field." LIKE '%".$urldata['phrase']."%'";
				$count++;
			}
			
			#Determine which query to use to search
			
				$query = $this->Query_reader->get_query_by_code('get_item_list', array('isactive'=>'Y', 'searchstring'=>"school = ".$schooldetails['id']." AND (".$search_string.")", 'limittext'=>" LIMIT 0,".NUM_OF_ROWS_PER_PAGE." "));
			
			#echo $query."<BR><BR>";
			$data['area'] = (!empty($data['area']))? $data['area']: 'select_items';
		}  
		
		#Searching for student list for selecting
		else if(isset($data['type']) && $data['type'] == 'student_list')
		{
			$search_string = '';
			$search_field_array = explode('__', $data['searchfield']);
			$count = 0;
			foreach($search_field_array AS $field)
			{
				if($count != 0)
				{
					$search_string .= " OR ";
				}
				$search_string .= $field." LIKE '%".$urldata['phrase']."%'";
				$count++;
			}
			
			#Determine which query to use to search
			
				$query = $this->Query_reader->get_query_by_code('get_students_school_users', array('isactive'=>'Y', 'searchstring'=>"  AND school=".$schooldetails['id']." AND (".$search_string.")", 'limittext'=>" LIMIT 0,".NUM_OF_ROWS_PER_PAGE." "));
			
			#echo $query."<BR><BR>";
			$data['area'] = (!empty($data['area']))? $data['area']: 'select_student';
		}
		
		#Searching for stock list
		else if(isset($data['type']) && $data['type'] == 'stock_list')
		{
			$search_string = '';
			$search_field_array = explode('__', $data['searchfield']);
			$count = 0;
			foreach($search_field_array AS $field)
			{
				if($count != 0)
				{
					$search_string .= " OR ";
				}
				$search_string .= $field." LIKE '%".$urldata['phrase']."%'";
				$count++;
			}
			
			#Determine which query to use to search
			
				$query = $this->Query_reader->get_query_by_code('get_stock_list', array('isactive'=>'Y', 'searchstring'=>"school = ".$schooldetails['id']." AND (".$search_string.")", 'limittext'=>" LIMIT 0,".NUM_OF_ROWS_PER_PAGE." "));
			
			#echo $query."<BR><BR>";
			$data['area'] = (!empty($data['area']))? $data['area']: 'select_stock';
		}  
		
		#Searching for inventory list
		else if(isset($data['type']) && $data['type'] == 'inventory_list')
		{
			$search_string = '';
			$search_field_array = explode('__', $data['searchfield']);
			$count = 0;
			foreach($search_field_array AS $field)
			{
				if($count != 0)
				{
					$search_string .= " OR ";
				}
				$search_string .= $field." LIKE '%".$urldata['phrase']."%'";
				$count++;
			}
			
			#Determine which query to use to search
			
			$query = $this->Query_reader->get_query_by_code('get_inventory_list', array('isactive'=>'Y', 'searchstring'=>" i.school = ".$schooldetails['id']." AND (".$search_string.")", 'limittext'=>" LIMIT 0,".NUM_OF_ROWS_PER_PAGE." "));
			
			#echo $query."<BR><BR>";
			$data['area'] = (!empty($data['area']))? $data['area']: 'inventory_list';
		}  

		#Searching for item list
		else if(isset($data['type']) && $data['type'] == 'search_item_list')
		{
			$search_string = '';
			$search_field_array = explode('__', $data['searchfield']);
			$count = 0;
			foreach($search_field_array AS $field)
			{
				if($count != 0)
				{
					$search_string .= " OR ";
				}
				$search_string .= $field." LIKE '%".$urldata['phrase']."%'";
				$count++;
			}
			
			#Determine which query to use to search
			
				$query = $this->Query_reader->get_query_by_code('get_item_list', array('isactive'=>'Y', 'searchstring'=>"school = ".$schooldetails['id']." AND (".$search_string.")", 'limittext'=>" LIMIT 0,".NUM_OF_ROWS_PER_PAGE." "));
			
			#echo $query."<BR><BR>";
			$data['area'] = (!empty($data['area']))? $data['area']: 'item_list';
		}  
				
		#Searching for stock list
		else if(isset($data['type']) && $data['type'] == 'search_stock_list')
		{
			$search_string = '';
			$search_field_array = explode('__', $data['searchfield']);
			$count = 0;
			foreach($search_field_array AS $field)
			{
				if($count != 0)
				{
					$search_string .= " OR ";
				}
				$search_string .= $field." LIKE '%".$urldata['phrase']."%'";
				$count++;
			}
			
			#Determine which query to use to search
			
				$query = $this->Query_reader->get_query_by_code('get_stock_list', array('isactive'=>'Y', 'searchstring'=>"school = ".$schooldetails['id']." AND (".$search_string.")", 'limittext'=>" LIMIT 0,".NUM_OF_ROWS_PER_PAGE." "));
			
			#echo $query."<BR><BR>";
			$data['area'] = (!empty($data['area']))? $data['area']: 'stock_list';
		} 
		
		#Searching for stock items list
		else if(isset($data['type']) && $data['type'] == 'search_stock_items_list')
		{
			$search_string = '';
			$search_field_array = explode('__', $data['searchfield']);
			$count = 0;
			foreach($search_field_array AS $field)
			{
				if($count != 0)
				{
					$search_string .= " OR ";
				}
				$search_string .= $field." LIKE '%".$urldata['phrase']."%'";
				$count++;
			}
			
			#Determine which query to use to search
			
				$query = $this->Query_reader->get_query_by_code('get_stock_items_list', array('isactive'=>'Y', 'searchstring'=>"school = ".$schooldetails['id']." AND (".$search_string.")", 'limittext'=>" LIMIT 0,".NUM_OF_ROWS_PER_PAGE." "));
			
			#echo $query."<BR><BR>";
			$data['area'] = (!empty($data['area']))? $data['area']: 'stock_items_list';
		} 
		
		#Searching for borrowers list
		else if(isset($data['type']) && $data['type'] == 'search_borrowers_list')
		{
			$search_string = '';
			$search_field_array = explode('__', $data['searchfield']);
			$count = 0;
			foreach($search_field_array AS $field)
			{
				if($count != 0)
				{
					$search_string .= " OR ";
				}
				$search_string .= $field." LIKE '%".$urldata['phrase']."%'";
				$count++;
			}
			
			#Determine which query to use to search
			
			$query = $this->Query_reader->get_query_by_code('get_borrower_list', array('isactive'=>'Y', 'school'=>$schooldetails['id'], 'searchstring'=>"(".$search_string.")", 'limittext'=>" LIMIT 0,".NUM_OF_ROWS_PER_PAGE." "));
			
			#echo $query."<BR><BR>"."dd"."layer[".$data['layer']."]";
			if($data['layer'] == "searchresults")
				$data['area'] = (!empty($data['area']))? $data['area']: 'borrower_list';
			elseif($data['layer'] == "searchresults2")
				$data['area'] = (!empty($data['area']))? $data['area']: 'borrower_due_list';
			else
				$data['area'] = (!empty($data['area']))? $data['area']: 'borrower_defaulter_list';
		} 
		
		#Searching for returns list
		else if(isset($data['type']) && $data['type'] == 'search_returns_list')
		{
			$search_string = '';
			$search_field_array = explode('__', $data['searchfield']);
			$count = 0;
			foreach($search_field_array AS $field)
			{
				if($count != 0)
				{
					$search_string .= " OR ";
				}
				$search_string .= $field." LIKE '%".$urldata['phrase']."%'";
				$count++;
			}
			
			#Determine which query to use to search
			
			$query = $this->Query_reader->get_query_by_code('get_return_list', array('isactive'=>'Y', 'searchstring'=>"(".$search_string.")", 'limittext'=>" LIMIT 0,".NUM_OF_ROWS_PER_PAGE." "));
			
			echo $query."<BR><BR>"."dd";
			$data['area'] = (!empty($data['area']))? $data['area']: 'returns_list';
		} 
		
		#Searching for transactions list
		else if(isset($data['type']) && $data['type'] == 'search_transactions_list')
		{
			$search_string = '';
			$search_field_array = explode('__', $data['searchfield']);
			$count = 0;
			foreach($search_field_array AS $field)
			{
				if($count != 0)
				{
					$search_string .= " OR ";
				}
				$search_string .= $field." LIKE '%".$urldata['phrase']."%'";
				$count++;
			}
			
			#Determine which query to use to search
			
			$query = $this->Query_reader->get_query_by_code('get_transaction_list', array('isactive'=>'Y', 'searchstring'=>" t.school = ".$schooldetails['id']." AND (".$search_string.")", 'limittext'=>" LIMIT 0,".NUM_OF_ROWS_PER_PAGE." "));
			
			#echo $query."<BR><BR>"."dd";
			$data['area'] = (!empty($data['area']))? $data['area']: 'transactions_list';
		} 
		
        #Searching for users list
		else if(isset($data['type']) && $data['type'] == 'userlist')
		{
			$search_string = '';
			$search_field_array = explode('__', $data['searchfield']);
			$count = 0;
			foreach($search_field_array AS $field)
			{
				if($count != 0)
				{
					$search_string .= " OR ";
				}
				$search_string .= $field." LIKE '%".$urldata['phrase']."%'";
				$count++;
			}
			$exclusers = ($this->session->userdata('exclusers'))? $this->session->userdata('exclusers'): array();
			$extra_cond = (!empty($data['msubarea']) && !empty($exclusers))? " AND U.id NOT IN ('".implode("','", $exclusers)."') ": "";
			
			#Determine which query to use to search
			$query = $this->Query_reader->get_query_by_code('get_user_list', array('isactive'=>'Y', 'searchstring'=>" AND (".$search_string.")".$extra_cond, 'limittext'=>" LIMIT 0,".NUM_OF_ROWS_PER_PAGE." "));
			#echo $query."<BR><BR>";
			$data['area'] = (!empty($data['msubarea']))? $data['msubarea']: 'search_user_details_list';
		}
		
		#Searching for news item
		else if(isset($data['type']) && $data['type'] == 'newslist')
		{
			$search_string = '';
			$search_field_array = explode('__', $data['searchfield']);
			$count = 0;
			foreach($search_field_array AS $field)
			{
				if($count != 0)
				{
					$search_string .= " OR ";
				}
				$search_string .= $field." LIKE '%".$urldata['phrase']."%'";
				$count++;
			}
			
			$isactive = (!empty($data['isarchive']))? "N": "Y";

			
			#Determine which query to use to search
			$query = $this->Query_reader->get_query_by_code('get_news_list', array('isactive'=>$isactive, 'searchstring'=>" AND (".$search_string.")", 'limittext'=>" LIMIT 0,".NUM_OF_ROWS_PER_PAGE." "));
			#echo $query."<BR><BR>";
			$data['area'] = 'search_news_list';
		}


		#Searching for group permissions
		else if(isset($data['type']) && $data['type'] == 'permissions')
		{
			$search_string = '';
			$search_field_array = explode('__', $data['searchfield']);
			$count = 0;
			foreach($search_field_array AS $field)
			{
				if($count != 0)
				{
					$search_string .= " OR ";
				}
				$search_string .= $field." LIKE '%".$urldata['phrase']."%'";
				$count++;
			}
                        
			$query = $this->Query_reader->get_query_by_code('get_group_permissions', array('groupid'=>$urldata['phrase']) );
                        $result = $this->db->query($query);
			$the_permissions_list = $result->result_array();
			
			$data['groupdetails'] = $this->Query_reader->get_row_as_array('get_group_by_id', array('groupid'=>$urldata['phrase'] ));
			
			$usertype = ($this->session->userdata('isadmin') == 'Y')? "admin": "";
			$result = $this->db->query($this->Query_reader->get_query_by_code('get_all_permissions', array('accesslist'=>"'".$usertype."'") ));
			$data['all_permissions'] = $result->result_array();
			
			$data['permissions_list'] = array();
			foreach($the_permissions_list AS $permission_row){
				array_push($data['permissions_list'], $permission_row['permissionid']);
			}
			
			$data['all_permissions_list'] = array();
			foreach($data['all_permissions'] AS $thepermission){
				array_push($data['all_permissions_list'], $thepermission['id']);
			}

			
			#echo $query."<BR><BR>";
			$data['area'] = 'get_group_permissions';
		}
		



		#Searching for user list
		else if(isset($data['type']) && $data['type'] == 'invitation_user_list')
		{
			$search_string = '';
			$search_field_array = explode('__', $data['searchfield']);
			$count = 0;
			foreach($search_field_array AS $field)
			{
				if($count != 0)
				{
					$search_string .= " OR ";
				}
				$search_string .= $field." LIKE '%".$urldata['phrase']."%'";
				$count++;
			}
			
			#Determine which query to use to search
			if(!empty($data['subarea']) && $data['subarea'] == 'deals')
			{
				$deal_cond = "''";
			}
			else
			{
				$deal_cond = "SELECT userid FROM invitations WHERE dealid='".$data['dealid']."'";
			}
			$query = $this->Query_reader->get_query_by_code('get_invitation_user_list', array('dealcond'=>$deal_cond, 'searchstring'=>" AND (".$search_string.")", 'limittext'=>" LIMIT 0,".NUM_OF_ROWS_PER_PAGE." "));
			
			$groups = $this->db->query($this->Query_reader->get_query_by_code('get_email_groups', array('searchstring'=>" AND G.groupname LIKE '%".$urldata['phrase']."%' ", 'limittext'=>" LIMIT 0,".NUM_OF_ROWS_PER_PAGE." ")));
			$data['group_list'] = $groups->result_array();
			
			#echo $query."<BR><BR>";
			$data['area'] = 'invitation_user_list';
		}		
		
                
                
        #Searching in or out of report user list
		else if(isset($data['type']) && $data['type'] == 'report_user_list' || $data['type'] == 'outside_report_user_list')
		{
			$search_string = '';
			$search_field_array = explode('__', $data['searchfield']);
			$count = 0;
			foreach($search_field_array AS $field)
			{
				if($count != 0)
				{
					$search_string .= " OR ";
				}
				$search_string .= $field." LIKE '%".$urldata['phrase']."%'";
				$count++;
			}
			
			#Determine which query to use to search
            $report_cond = "SELECT userid FROM reportaccess WHERE reportid='".$data['reportid']."'";
                        
            if($data['type'] == 'outside_report_user_list')
            {
            	$query = $this->Query_reader->get_query_by_code('search_outside_report_user_list', array('reportcond'=>$report_cond, 'searchstring'=>" AND (".$search_string.")", 'limittext'=>" LIMIT 0,".NUM_OF_ROWS_PER_PAGE." "));
			
                #echo $query."<BR><BR>";
                $data['area'] = 'outside_report_user_list';
            }
            else if($data['type'] == 'selected_report_users')
            {                            
            	$query = $this->Query_reader->get_query_by_code('get_report_user_list', array('reportcond'=>$report_cond, 'searchstring'=>" AND (".$search_string.")", 'limittext'=>" LIMIT 0,".NUM_OF_ROWS_PER_PAGE." "));
			
                #echo $query."<BR><BR>";
                $data['area'] = 'selected_report_users';
            }
		}



		#Searching for file under
		else if(isset($data['type']) && $data['type'] == 'file_under')
		{
			$search_string = '';
			$search_field_array = explode('__', $data['searchfield']);
			$count = 0;
			foreach($search_field_array AS $field)
			{
				if($count != 0)
				{
					$search_string .= " OR ";
				}
				$search_string .= $field." LIKE '%".$urldata['phrase']."%'";
				$count++;
			}
			
			#Determine which query to use to search
			$query = $this->Query_reader->get_query_by_code('search_file_under', array('searchstring'=>" AND (".$search_string.")", 'limittext'=>" LIMIT 0,".NUM_OF_ROWS_PER_PAGE." "));
			
			#echo $query."<BR><BR>";
			$data['area'] = 'file_under_list';
		}	
		

		#Searching for usernames
		else if(isset($data['type']) && $data['type'] == 'username')
		{
			$search_string = '';
			$search_field_array = explode('__', $data['searchfield']);
			$count = 0;
			foreach($search_field_array AS $field)
			{
				if($count != 0)
				{
					$search_string .= " OR ";
				}
				$search_string .= $field." = '".$urldata['phrase']."'";
				$count++;
			}
			

			
			#Determine which query to use to search
			$query = $this->Query_reader->get_query_by_code('get_existing_usernames', array('searchstring'=> $search_string." ", 'limittext'=>" LIMIT 0,".NUM_OF_ROWS_PER_PAGE." "));
			#echo $query."<BR><BR>";
            $data['uname'] = $urldata['phrase'];
			$data['area'] = 'username_list';
		}
                
                #show password strength
		else if(isset($data['type']) && $data['type'] == 'pwdstrength')
		{			
			$data['passwordmsg'] = $this->user1->check_password_strength($urldata['phrase']);		
			
			$data['area'] = 'show_password_strength';
		}
		



		#Searching for trading holidays
		else if(isset($data['type']) && $data['type'] == 'trading_holidays')
		{
			$search_string = '';
			$search_field_array = explode('__', $data['searchfield']);
			$count = 0;
			foreach($search_field_array AS $field)
			{
				if($count != 0)
				{
					$search_string .= " OR ";
				}
				$search_string .= $field." LIKE '%".$urldata['phrase']."%'";
				$count++;
			}
			
			#Determine which query to use to search
			$query = $this->Query_reader->get_query_by_code('get_trading_days', array('isactive'=>"'Y'", 'searchstring'=>" AND (".$search_string.")", 'limittext'=>" LIMIT 0,".NUM_OF_ROWS_PER_PAGE." "));
			
			#echo $query."<BR><BR>";
			$data['area'] = 'holiday_list';
		}
		



		#Searching for only the holiday name
		else if(isset($data['type']) && $data['type'] == 'holiday_list')
		{
			$search_string = '';
			$search_field_array = explode('__', $data['searchfield']);
			$count = 0;
			foreach($search_field_array AS $field)
			{
				if($count != 0)
				{
					$search_string .= " OR ";
				}
				$search_string .= $field." LIKE '%".$urldata['phrase']."%'";
				$count++;
			}
			
			#Determine which query to use to search
			$query = $this->Query_reader->get_query_by_code('get_holiday_names', array('isactive'=>"'Y'", 'searchstring'=>" AND (".$search_string.")", 'limittext'=>" LIMIT 0,".NUM_OF_ROWS_PER_PAGE." "));
			
			#echo $query."<BR><BR>";
			$data['area'] = 'select_holiday';
		}
		



		#Searching for the news distribution
		else if(isset($data['type']) && $data['type'] == 'news_distribution')
		{
			$search_string = '';
			$search_field_array = explode('__', $data['searchfield']);
			$count = 0;
			foreach($search_field_array AS $field)
			{
				if($count != 0)
				{
					$search_string .= " OR ";
				}
				$search_string .= $field." LIKE '%".$urldata['phrase']."%'";
				$count++;
			}
			
			#Determine which query to use to search
			$query = $this->Query_reader->get_query_by_code('get_distribution_settings', array('searchstring'=>" AND (".$search_string.")", 'limittext'=>" LIMIT 0,".NUM_OF_ROWS_PER_PAGE." "));
			
			#echo $query."<BR><BR>";
			$data['area'] = 'news_distribution';
		}
		



		#Searching for email groups
		else if(isset($data['type']) && $data['type'] == 'email_groups')
		{
			$search_string = '';
			$search_field_array = explode('__', $data['searchfield']);
			$count = 0;
			foreach($search_field_array AS $field)
			{
				if($count != 0)
				{
					$search_string .= " OR ";
				}
				$search_string .= $field." LIKE '%".$urldata['phrase']."%'";
				$count++;
			}
			
			#Determine which query to use to search
			$query = $this->Query_reader->get_query_by_code('get_email_groups', array('searchstring'=>" AND (".$search_string.")", 'limittext'=>" LIMIT 0,".NUM_OF_ROWS_PER_PAGE." "));
			
			#echo $query."<BR><BR>";
			$data['area'] = 'email_groups';
		}
		



		#Searching for group name
		else if(isset($data['type']) && $data['type'] == 'groupname')
		{
			$search_string = '';
			$search_field_array = explode('__', $data['searchfield']);
			$count = 0;
			foreach($search_field_array AS $field)
			{
				if($count != 0)
				{
					$search_string .= " OR ";
				}
				$search_string .= $field." LIKE '%".$urldata['phrase']."%'";
				$count++;
			}
			
			#Determine which query to use to search
			$query = $this->Query_reader->get_query_by_code('search_group_name', array('searchstring'=>" AND (".$search_string.")", 'limittext'=>" LIMIT 0,".NUM_OF_ROWS_PER_PAGE." "));
			
			#echo $query."<BR><BR>";
			$data['area'] = 'group_name_select';
		}
		


		#Searching for user
		else if(isset($data['type']) && $data['type'] == 'user_search')
		{
			$search_string = '';
			$search_field_array = explode('__', $data['searchfield']);
			$count = 0;
			foreach($search_field_array AS $field)
			{
				if($count != 0)
				{
					$search_string .= " OR ";
				}
				$search_string .= $field." LIKE '%".$urldata['phrase']."%'";
				$count++;
			}
			
			#Determine which query to use to search
			$idlist = ($this->session->userdata('usergrouplist'))? $this->session->userdata('usergrouplist'): array();
			$idcond = (!empty($data['layer']) && $data['layer'] == 'adduser_searchresults')? " AND id NOT IN ('".implode("','", $idlist)."') ": "";
			
			$query = $this->Query_reader->get_query_by_code('search_user_list', array('searchstring'=>" AND (".$search_string.")", 'idcond'=>$idcond, 'limittext'=>" LIMIT 0,".NUM_OF_ROWS_PER_PAGE." "));
			
			#echo $query."<BR><BR>";
			$data['area'] = 'general_user_list';
		}
		



		#Searching for organizations
		else if(isset($data['type']) && $data['type'] == 'organizations_list')
		{
			$search_string = '';
			$search_field_array = explode('__', $data['searchfield']);
			$count = 0;
			foreach($search_field_array AS $field)
			{
				if($count != 0)
				{
					$search_string .= " OR ";
				}
				$search_string .= $field." LIKE '%".$urldata['phrase']."%'";
				$count++;
			}
			
			#Determine which query to use to search
			$query = $this->Query_reader->get_query_by_code('get_organizations_list', array('isactive'=>"'Y'", 'searchstring'=>" AND (".$search_string.")", 'limittext'=>" LIMIT 0,".NUM_OF_ROWS_PER_PAGE." "));
			
			#echo $query."<BR><BR>";
			$data['area'] = 'organizations_list';
		}
		
		
		#Searching for user news item
		else if(isset($data['type']) && $data['type'] == 'user_news_list')
		{
			$search_string = '';
			$search_field_array = explode('__', $data['searchfield']);
			$count = 0;
			foreach($search_field_array AS $field)
			{
				if($count != 0)
				{
					$search_string .= " OR ";
				}
				$search_string .= $field." LIKE '%".$urldata['phrase']."%'";
				$count++;
			}
			
			if(!empty($data['t']) && decryptValue($data['t']) == 'archive')
			{
				$data['isarchive'] = "Y";
				$isactive = "N";
			}
			else
			{
				$isactive = "Y";
			}
			
			#Determine which query to use to search
			$query = $this->Query_reader->get_query_by_code('get_users_news_list', array('isactive'=>$isactive, 'userid'=>$this->session->userdata('userid'), 'searchstring'=>" AND (".$search_string.")", 'limittext'=>" LIMIT 0,".NUM_OF_ROWS_PER_PAGE." "));
			#echo $query."<BR><BR>";
			$data['area'] = 'search_user_news_list';
		}
		
		
		
		
		
		#Searching for a user invitation item
		else if(isset($data['type']) && $data['type'] == 'user_invitations_list')
		{
			$search_string = '';
			$search_field_array = explode('__', $data['searchfield']);
			$count = 0;
			foreach($search_field_array AS $field)
			{
				if($count != 0)
				{
					$search_string .= " OR ";
				}
				$search_string .= $field." LIKE '%".$urldata['phrase']."%'";
				$count++;
			}
			
			if(!empty($data['t']) && decryptValue($data['t']) == 'archive')
			{
				$data['isarchive'] = "Y";
				$isactive = "N";
			}
			else
			{
				$isactive = "Y";
			}
			
			#Determine which query to use to search
			$query = $this->Query_reader->get_query_by_code('get_user_invitations_list', array('isactive'=>$isactive, 'userid'=>$this->session->userdata('userid'), 'searchstring'=>" AND (".$search_string.")", 'limittext'=>" LIMIT 0,".NUM_OF_ROWS_PER_PAGE." "));
			#echo $query."<BR><BR>";
			$data['area'] = 'search_user_invitations_list';
		}
		
		
		
		
		
		#Searching for an order account number
		else if(isset($data['type']) && $data['type'] == 'order_accountnumber')
		{
			$search_string = '';
			$search_field_array = explode('__', $data['searchfield']);
			$count = 0;
			foreach($search_field_array AS $field)
			{
				if($count != 0)
				{
					$search_string .= " OR ";
				}
				$search_string .= $field." LIKE '%".$urldata['phrase']."%'";
				$count++;
			}
			
			#Determine which query to use to search
			$query = $this->Query_reader->get_query_by_code('get_order_account_number', array('orderedby'=>$this->session->userdata('userid'), 'searchstring'=>" AND (".$search_string.")", 'limittext'=>" LIMIT 0,".NUM_OF_ROWS_PER_PAGE." "));
			#echo $query."<BR><BR>";
			$data['area'] = 'order_accountnumber_list';
		}
		
		
		
		
		
		#Searching for an order
		else if(isset($data['type']) && $data['type'] == 'order_list')
		{
			$search_string = '';
			$search_field_array = explode('__', $data['searchfield']);
			$count = 0;
			foreach($search_field_array AS $field)
			{
				if($count != 0)
				{
					$search_string .= " OR ";
				}
				$search_string .= $field." LIKE '%".$urldata['phrase']."%'";
				$count++;
			}
			
			#Determine which query to use to search
			if(!empty($data['t']) && decryptValue($data['t']) == 'indication_only')
			{
				$query = $this->Query_reader->get_query_by_code('get_order_list', array('isactive'=>'Y', 'ordertypes'=>"'indication_only'", 'userid'=>$this->session->userdata('userid'), 'searchstring'=>" AND orderstatus IN ('open', 'processing', 'closed') AND (".$search_string.")", 'limittext'=>" LIMIT 0,".NUM_OF_ROWS_PER_PAGE." "));
			}
			else
			{
				$query = $this->Query_reader->get_query_by_code('get_order_list', array('isactive'=>'Y', 'ordertypes'=>"'firm'", 'userid'=>$this->session->userdata('userid'), 'searchstring'=>" AND orderstatus IN ('open', 'processing', 'closed') AND (".$search_string.")", 'limittext'=>" LIMIT 0,".NUM_OF_ROWS_PER_PAGE." "));
			}
			
			#echo $query."<BR><BR>";
			$data['area'] = 'order_list';
		}
		
		
		
		
		
		#Searching for fund requests
		else if(isset($data['type']) && $data['type'] == 'fund_requests_list')
		{
			$search_string = '';
			$search_field_array = explode('__', $data['searchfield']);
			$count = 0;
			foreach($search_field_array AS $field)
			{
				if($count != 0)
				{
					$search_string .= " OR ";
				}
				$search_string .= $field." LIKE '%".$urldata['phrase']."%'";
				$count++;
			}
			
			$user_cond = ($this->session->userdata('isadmin') == 'Y')? "": " AND requestedby='".$this->session->userdata('userid')."' ";
			
			#Determine which query to use to search
			$query = $this->Query_reader->get_query_by_code('get_fund_request_list', array('isactive'=>'Y', 'searchstring'=>$user_cond." AND (".$search_string.") ", 'limittext'=>" LIMIT 0,".NUM_OF_ROWS_PER_PAGE." "));
			#echo $query."<BR><BR>";
			$data['area'] = 'fund_requests_list';
		}
		
		
		
		
		
		#Searching for a portfolio entry
		else if(isset($data['type']) && $data['type'] == 'portfolio_list')
		{
			$search_string = '';
			$search_field_array = explode('__', $data['searchfield']);
			$count = 0;
			foreach($search_field_array AS $field)
			{
				if($count != 0)
				{
					$search_string .= " OR ";
				}
				$search_string .= $field." LIKE '%".$urldata['phrase']."%'";
				$count++;
			}
			
			#Determine which query to use to search
			$query = $this->Query_reader->get_query_by_code('get_portfolio_list', array('isactive'=>'Y', 'userid'=>$this->session->userdata('userid'), 'searchstring'=>" AND (".$search_string.")", 'limittext'=>" LIMIT 0,".NUM_OF_ROWS_PER_PAGE." "));
			#echo $query."<BR><BR>";
			$data['area'] = 'portfolio_list';
		}
		
		
		
		
		
		#Searching for a user report list
		else if(isset($data['type']) && $data['type'] == 'user_report_list')
		{
			$search_string = '';
			$search_field_array = explode('__', $data['searchfield']);
			$count = 0;
			foreach($search_field_array AS $field)
			{
				if($count != 0)
				{
					$search_string .= " OR ";
				}
				$search_string .= $field." LIKE '%".$urldata['phrase']."%'";
				$count++;
			}
			
			$isactive = (!empty($data['t']) && decryptValue($data['t']) == 'archive')? 'N': 'Y';
			
			#Determine which query to use to search
			$query = $this->Query_reader->get_query_by_code('get_user_report_list', array('userid'=>$this->session->userdata('userid'), 'searchstring'=>" AND (".$search_string.") ", 'isactive'=>$isactive, 'limittext'=>" LIMIT 0,".NUM_OF_ROWS_PER_PAGE." "));
			#echo $query."<BR><BR>";
			$data['area'] = 'user_report_list';
		}
		
		
		
		
		
		#Searching for a invitations response
		else if(isset($data['type']) && $data['type'] == 'invitations_response_list')
		{
			$search_string = '';
			$search_field_array = explode('__', $data['searchfield']);
			$count = 0;
			foreach($search_field_array AS $field)
			{
				if($count != 0)
				{
					$search_string .= " OR ";
				}
				$search_string .= $field." LIKE '%".$urldata['phrase']."%'";
				$count++;
			}
			
			$isactive = (!empty($data['t']) && decryptValue($data['t']) == 'archive')? 'N': 'Y';
			
			#Determine which query to use to search
			$query = $this->Query_reader->get_query_by_code('get_inv_response_list', array('searchstring'=>" AND (".$search_string.") ", 'isactive'=>$isactive, 'limittext'=>" LIMIT 0,".NUM_OF_ROWS_PER_PAGE." "));
			#echo $query."<BR><BR>";
			$data['area'] = 'invitations_response_list';
		}
		
		
		
		
		
		#Searching for a help topic
		else if(isset($data['type']) && $data['type'] == 'help_topic')
		{
			$search_string = '';
			$search_field_array = explode('__', $data['searchfield']);
			$count = 0;
			foreach($search_field_array AS $field)
			{
				if($count != 0)
				{
					$search_string .= " OR ";
				}
				$search_string .= $field." LIKE '%".str_replace(' ', '_', strtolower($urldata['phrase']))."%'";
				$count++;
			}
			
			#Determine which query to use to search
			$query = $this->Query_reader->get_query_by_code('get_help_topic', array('searchstring'=>" AND (".$search_string.") ",  'limittext'=>" LIMIT 0,".NUM_OF_ROWS_PER_PAGE." "));
			#echo $query."<BR><BR>";
			$data['area'] = 'help_list';
		}
		
		
		
		
		
		#Searching for a manage help topic
		else if(isset($data['type']) && $data['type'] == 'manage_help_list')
		{
			$search_string = '';
			$search_field_array = explode('__', $data['searchfield']);
			$count = 0;
			foreach($search_field_array AS $field)
			{
				if($count != 0)
				{
					$search_string .= " OR ";
				}
				$search_string .= $field." LIKE '%".$urldata['phrase']."%'";
				$count++;
			}
			
			#Determine which query to use to search
			$query = $this->Query_reader->get_query_by_code('get_help_list', array('searchstring'=>" AND (".$search_string.") ",  'limittext'=>" LIMIT 0,".NUM_OF_ROWS_PER_PAGE." "));
			#echo $query."<BR><BR>";
			$data['area'] = 'manage_help_list';
		}
		
		
		
		
		
		#Searching for a message list
		else if(isset($data['type']) && $data['type'] == 'message_list')
		{
			$search_string = '';
			$search_field_array = explode('__', $data['searchfield']);
			$count = 0;
			foreach($search_field_array AS $field)
			{
				if($count != 0)
				{
					$search_string .= " OR ";
				}
				$search_string .= $field." LIKE '%".$urldata['phrase']."%'";
				$count++;
			}
			
			#Determine which query to use to search
			$query = $this->Query_reader->get_query_by_code('get_message_list', array('isactive'=>'Y', 'userid'=>$this->session->userdata('userid'), 'searchstring'=>" AND (".$search_string.") ",  'limittext'=>" LIMIT 0,".NUM_OF_ROWS_PER_PAGE." "));
			#echo $query."<BR><BR>";
			$data['area'] = 'message_list';
		}
		
		
		
		
		
		#Searching for a fund sector
		else if(isset($data['type']) && $data['type'] == 'fund_sector')
		{
			$search_string = '';
			$search_field_array = explode('__', $data['searchfield']);
			$count = 0;
			foreach($search_field_array AS $field)
			{
				if($count != 0)
				{
					$search_string .= " OR ";
				}
				$search_string .= $field." LIKE '%".$urldata['phrase']."%'";
				$count++;
			}
			
			#Determine which query to use to search
			$query = $this->Query_reader->get_query_by_code('get_fund_sector_list', array('searchstring'=>" AND (".$search_string.") ",  'limittext'=>" LIMIT 0,".NUM_OF_ROWS_PER_PAGE." "));
			#echo $query."<BR><BR>";
			$data['area'] = 'fund_sector';
		}
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		#*************************************************************************************************
		#Process for all
		#*************************************************************************************************
		if(isset($query)){
			if(!$this->paginate_result)
			{
				$result = $this->db->query($query);
				$data['page_list'] = $result->result_array();
			}				
		}	
			
			
		# Send results to addon if no view to load is specified (in the case on instant search)
		if(empty($view_to_load))
		{
			$view_to_load = 'incl/addons';
		}
		
		#Set the query for download
		if(isset($query) && isset($data['area'])){
			$this->session->set_userdata($data['area'].'_query', $query);
		}
		
		$this->load->view($view_to_load, $data);
	}
	
	
	
	
	#Function to download a list of search results
	function download_list()
	{
		# Get the passed details into the form data array if any
		$urldata = $this->uri->uri_to_assoc(4, array('section', 'action'));
		
		# Pick all assigned data
		$data = assign_to_data($urldata);
		
		if(isset($data['section']))
		{
			$this->load->view('incl/listdownload_view', $data);
		}
	}
	
	
	
	
	
	
	
	
	#Function to send a report or list by email
	function send_email_data()
	{
		#Add tracking info for reference
		if(isset($_POST['message']))
		{
			$_POST['message'] .= "<br>-----------------------------------------------"
								 ."<br> ".generate_email_tracking_string($this);
		}
		
		# Display appropriate message based on the results
		if($this->input->post('sendemail') && $this->sysemail->email_form_data(array(), $_POST, $this->input->post('section')))
		{
			$data['msg'] = "The email was successfully sent.<br>TO: ".$_POST['emailto'];
			if(trim($_POST['emailcc']) != ''){
				$data['msg'] .= "<br>CC: ".$_POST['emailcc'];
			}
			$data['log_result'] = 'Success';
		}
		else
		{
			# For each error to be displayed as an error, it should start with "ERROR:"
			$data['msg'] = "ERROR: The email was not sent or may not be sent correctly. Please check your email list and try again.<br>TO: ".$_POST['emailto'];
			if(trim($_POST['emailcc']) != ''){
				$data['msg'] .= "<br>CC: ".$_POST['emailcc'];
			}
			$data['log_result'] = 'Fail';
		}
		
		$this->Users->log_access_trail($this->session->userdata('username'), $data['log_result'], $this->input->post('section').' - DETAILS: '.$data['msg']);
		
		
		$data['userdetails'] = $this->session->userdata('alluserdata');
		$this->load->view('settings/email_report_view', $data);
	}
	
	
	
	
	#FUnction to manage words entered in the system
	function manage_words()
	{
		access_control($this);
		
		# Get the passed details into the form data array if any
		$urldata = $this->uri->uri_to_assoc(3, array('d'));
		# Pick all assigned data
		$data = assign_to_data($urldata);
		
		$data = paginate_list($this, $data, 'get_word_list',  array('searchstring'=>''), 200);
		
		$data = add_msg_if_any($this, $data);
		$this->load->view('search/manage_words', $data);
	}
	
	
	
	
	#Function to add a word
	function add_word()
	{
		access_control($this);
		
		# Get the passed details into the form data array if any
		$urldata = $this->uri->uri_to_assoc(3, array('d'));
		# Pick all assigned data
		$data = assign_to_data($urldata);
		
		if(!empty($data['i']) || $this->input->post('editid'))
		{
			$editid = ($this->input->post('editid'))? $this->input->post('editid'): decryptValue($data['i']);
			
			$data['formdata'] = $this->Query_reader->get_row_as_array('get_word_by_id', array('wordid'=>$editid));
			$data['formdata']['synonyms'] = explode(',', $data['formdata']['synonyms']);
			$data['formdata']['wordtype'] = $data['formdata']['type'];
			$data['i'] = encryptValue($editid);
		}
		
		if($this->input->post('addword'))
		{
			$required_fields = array('word', 'wordtype');
			$_POST = clean_form_data($_POST);
			$validation_results = validate_form('', $_POST, $required_fields);
			
			if($validation_results['bool'])
			{
				if(!empty($editid))
				{
					$result = $this->db->query($this->Query_reader->get_query_by_code('update_word_data', array('type'=>$_POST['wordtype'], 'synonyms'=>implode(",", $_POST['synonyms']), 'wordid'=>$editid )));
				}
				else
				{
					$result = $this->db->query($this->Query_reader->get_query_by_code('save_new_word', array('word'=>htmlentities($_POST['word'], ENT_QUOTES), 'type'=>$_POST['wordtype'], 'synonyms'=>implode(",", $_POST['synonyms']) )));
				}
				
				#Called from a popup
				#Show the appropriate message
				if($result)
				{
					$this->session->set_userdata('smsg', "The word data has been saved.");
					$data['msg'] = "The word data has been saved.";
				}
				else
				{
					$data['msg'] = "ERROR: The word data could not be saved.";
				}
			}
			
			if((empty($validation_results['bool']) || (!empty($validation_results['bool']) && !$validation_results['bool'])) 
			&& empty($data['msg']) )
			{
				$data['msg'] = "WARNING: The word data could not be saved because of some missing information.";
			}
			
			$this->session->set_userdata('wmsg', $data['msg']);
			redirect(base_url()."search/manage_words/m/wmsg");
		}
		
		$data = add_msg_if_any($this, $data);
		$this->load->view('search/add_word', $data);
	}
	
	
	
	
	
	#Function to delete a word
	function delete_word()
	{
		access_control($this, array('admin'));
		
		# Get the passed details into the form data array if any
		$urldata = $this->uri->uri_to_assoc(3, array('d'));
		# Pick all assigned data
		$data = assign_to_data($urldata);
		
		if(!empty($data['i']))
		{
			$result = $this->db->query($this->Query_reader->get_query_by_code('delete_word_by_id', array('id'=>decryptValue($data['i'])) ));
		}
		
		if(!empty($result) && $result)
		{
			$msg = "The word has been removed.";
		}
		else
		{
			$msg = "ERROR: There were problems removing the word.";
		}
		
		$this->session->set_userdata('dmsg', $msg);
		redirect(base_url()."search/manage_words/m/dmsg");
	}
	
	
	
	
	
	
}

/* End of file search.php */
/* Location: ./system/application/controllers/settings/ */
?>
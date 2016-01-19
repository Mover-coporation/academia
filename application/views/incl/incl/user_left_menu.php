<div style="border-right:1px solid #EEEEEE; border-top:7px solid #C14543">
<ul class="nav">
	<?php
		//configure the link styles
		$students = config_left_menu_item ($mselected, 'students', 'students/manage_students');
		$staff = config_left_menu_item ($mselected, 'staff', 'user/manage_users');
		$finances = config_left_menu_item ($mselected, 'finances', 'finances/manage_fee_structure'); 
		$library = config_left_menu_item ($mselected, 'library', 'library/manage_stock'); 
		$inventory = config_left_menu_item ($mselected, 'inventory', 'inventory/manage_inventory'); 
		$school_settings = config_left_menu_item ($mselected, 'school_settings', 'schoolsettings/manage_settings');
		$gradebook = config_left_menu_item ($mselected, 'gradebook', 'gradebook/manage_gradebook');
		$sponsors = config_left_menu_item ($mselected, 'manage_sponsors', 'sponsor/manage_sponsors'); 
		
		
		//The links
		#Manage Students
		if($this->session->userdata('isschooladmin') == 'Y' || check_user_access($this,'view_students'))
		{
			$menu['students'] = $students['open_link'].
					   '<li '.$students['selected'].' >
					   <table id="table_students">
						<tr>
						<td width="50"><img src="'.base_url().'images/student.jpg" /></td>
						<td class="menu_vertical_separator"><img src="'.base_url().'images/menu_vertical_separator.jpg" /></td>
						<td>STUDENT MANAGEMENT</td>
						</tr>
					  </table>';
					  
			$menu['students'] .=  '</li>'.
				 $students['close_link'];
		}
			 
		
		#Manage Sponsors
		if($this->session->userdata('isschooladmin') == 'Y' || check_user_access($this,'view_sponsors'))
		{
			$menu['manage_sponsors'] = $sponsors['open_link'].
					   '<li '.$sponsors['selected'].' >  
					 <table id="table_manage_sponsors">
						<tr>
						<td width="50"><img src="'.base_url().'images/icon-sponsor.jpg" /></td>
						<td class="menu_vertical_separator"><img src="'.base_url().'images/menu_vertical_separator.jpg" /></td>
						<td>MANAGE SPONSORS</td>
						</tr>
					  </table>';         
			$menu['manage_sponsors'] .=  '</li>'.
				 $sponsors['close_link'];
		}
		
		
		#Manage Settings
		if($this->session->userdata('isschooladmin') == 'Y' || check_user_access($this,'access_school_settings'))
		{
			$menu['school_settings'] = $school_settings['open_link'].
					   '<li '.$school_settings['selected'].' >  
					 <table id="table_school_settings">
						<tr>
						<td width="50"><img src="'.base_url().'images/school_settings.jpg" /></td>
						<td class="menu_vertical_separator"><img src="'.base_url().'images/menu_vertical_separator.jpg" /></td>
						<td>SCHOOL SETTINGS</td>
						</tr>
					  </table>';         
			$menu['school_settings'] .=  '</li>'.
				 $school_settings['close_link'];
		}
		
		
		#Manage Gradebook
		if($this->session->userdata('isschooladmin') == 'Y' || check_user_access($this,'access_grade_book'))
		{
			$menu['gradebook'] = $gradebook['open_link'].
					   '<li '.$gradebook['selected'].' >  
					 <table id="table_gradebook">
						<tr>
						<td width="50"><img src="'.base_url().'images/gradebook.jpg" /></td>
						<td class="menu_vertical_separator"><img src="'.base_url().'images/menu_vertical_separator.jpg" /></td>
						<td>GRADEBOOK</td>
						</tr>
					  </table>';         
			$menu['gradebook'] .=  '</li>'.
				 $gradebook['close_link'];
		}
		
		
		#Manage Staff
		if($this->session->userdata('isschooladmin') == 'Y' || check_user_access($this,'view_staff'))
		{
			$menu['staff'] =  $staff['open_link'].
				 '<li '.$staff['selected'].' > 
					 <table id="table_staff">
						<tr id="students_menu">
						<td width="50"><img src="'.base_url().'images/user.jpg" /></td>
						<td class="menu_vertical_separator"><img src="'.base_url().'images/menu_vertical_separator.jpg" /></td>
						<td>USER MANAGEMENT</td>
						</tr>
					  </table>';
				 
			$menu['staff'] .=  '</li>'.
				 $staff['close_link'];
		}
			 	
				
		#Manage finances
		if($this->session->userdata('isschooladmin') == 'Y' || check_user_access($this,'access_finances_page'))
		{
			$menu['finances'] =  $finances['open_link'].
				 '<li '.$finances['selected'].' > 
					 <table id="table_finances">
						<tr>
						<td width="50"><img src="'.base_url().'images/finances.jpg" /></td>
						<td class="menu_vertical_separator"><img src="'.base_url().'images/menu_vertical_separator.jpg" /></td>
						<td>FINANCES</td>
						</tr>
					  </table>';
				
			$menu['finances'] .=  '</li>'.
				 $finances['close_link'];
		}
        
		
		#Manage library
		if($this->session->userdata('isschooladmin') == 'Y' || check_user_access($this,'access_library'))
		{
			$menu['library'] =  $library['open_link'].
				 '<li '.$library['selected'].' > 
					 <table id="table_library">
						<tr>
						<td width="50"><img src="'.base_url().'images/library.jpg" /></td>
						<td class="menu_vertical_separator"><img src="'.base_url().'images/menu_vertical_separator.jpg" /></td>
						<td>LIBRARY</td>
						</tr>
					  </table>';
				 
			$menu['library'] .=  '</li>'.
				 $library['close_link'];		
		}

		
		#Manage Inventory
		if($this->session->userdata('isschooladmin') == 'Y' || check_user_access($this,'access_inventory'))
		{
			$menu['inventory'] =  $inventory['open_link'].
				'<li '.$inventory['selected'].' > 
					 <table id="table_inventory">
						<tr>
						<td width="50"><img src="'.base_url().'images/store.jpg" /></td>
						<td class="menu_vertical_separator"><img src="'.base_url().'images/menu_vertical_separator.jpg" /></td>
						<td>STORE</td>
						</tr>
					  </table>';
			
			$menu['inventory'] .=  '</li>'.
				 $inventory['close_link'];
		}
		
		#Remove selected link from main stack
		if(!empty($mselected) && $mselected != 'schools')
		{
			#store menu items in temp array
			//$temp_array = array();
			//$temp_array[$mselected] = $menu[$mselected];
			unset($menu[$mselected]);
			
			#Merge arrays
			//$menu = array_merge($temp_array, $menu);
			
			foreach($menu as $menu_data)
				echo $menu_data;
		}
		else
		{
			if(!empty($menu))
			  foreach($menu as $menu_data)
				  echo $menu_data;
		}
			 
		?>
    </ul>
</div>
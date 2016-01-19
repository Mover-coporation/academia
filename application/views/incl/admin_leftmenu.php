<div style="border-right:1px solid #EEEEEE; border-top:7px solid #C14543">
<ul class="nav">
	<?php
		$schools = config_left_menu_item ($mselected, 'schools', 'admin/dashboard'); 
		$users = config_left_menu_item ($mselected, 'users', 'admin/manage_users'); 
		
		
		#Manage schools
		$menu['schools'] = $schools['open_link'].
        		   '<li '.$schools['selected'].' >
				   <table id="table_schools">
					<tr>
					<td width="50"><img src="'.base_url().'images/school_settings.jpg" /></td>
					<td class="menu_vertical_separator"><img src="'.base_url().'images/menu_vertical_separator.jpg" /></td>
					<td>SCHOOL ACCOUNTS</td>
					</tr>
    			  </table>';
                  
        $menu['schools'] .=  '</li>'.
			 $schools['close_link'];
		
		#Manage users
		$menu['users'] = $users['open_link'].
        		   '<li '.$users['selected'].' >  
            	 <table id="table_users">
					<tr>
					<td width="50"><img src="'.base_url().'images/student.jpg" /></td>
					<td class="menu_vertical_separator"><img src="'.base_url().'images/menu_vertical_separator.jpg" /></td>
					<td>SYSTEM USERS</td>
					</tr>
    			  </table>';         
        $menu['users'] .=  '</li>'.
			 $users['close_link'];
		
		foreach($menu as $menu_data)
			echo $menu_data;
		
	?>
</ul>
</div>
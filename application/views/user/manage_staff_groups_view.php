<div id="user-groups-results">
        <table border="0" cellspacing="0" cellpadding="10" width="100%" id='contenttable'>            
 <?php   
if(isset($msg)){
	echo "<tr><td colspan='4'>".format_notice($msg)."</td></tr>";
}
?>           
            
          <tr>
            <td valign="top">
            
            
            <?php  
			#$page_list = array();
			if(!empty($page_list))
			{
				echo "<table width='100%' border='0' cellspacing='0' cellpadding='5'>
          	<tr>
			<td class='listheader' width='1%'>&nbsp;</td>
           	<td class='listheader' nowrap>Group &nbsp;<a class='fancybox fancybox.ajax' href='".base_url()."user/load_staff_groups_form')' title='Click to add a user'><img src='".base_url()."images/add_item.png' border='0'/></a></td>
			<td class='listheader' nowrap>Comments</td>
			<td class='listheader' nowrap>Staff</td>
			<td class='listheader' nowrap>Date Added</td>
			</tr>";	
	$counter = 0;	
	foreach($page_list AS $row)
	{
		#Get number of users in each group
		$staff = get_group_members($this, $row['id']);
		
		#Show one row at a time
		echo "<tr id='listrow-" . $row['id'] . "' class='listrow' style='".get_row_color($counter, 2)."'>
		<td class='leftListCell rightListCell' valign='top' nowrap>";
		
			#if(check_user_access($this,'delete_deal')){
				echo "<a href='javascript:void(0)' onclick=\"asynchDelete('".base_url()."user/delete_staff_group/i/".encryptValue($row['id'])."', 'Are you sure you want to remove this staff group? \\nThis operation can not be undone. \\nClick OK to confirm, \\nCancel to cancel this operation and stay on this page.','listrow-" . $row['id'] . "');\" title=\"Click to remove this staff group.\"><img src='".base_url()."images/delete.png' border='0'/></a>";
			#}
		
			#if(check_user_access($this,'update_deals')){
				echo " &nbsp;&nbsp; <a class='fancybox fancybox.ajax' href='".base_url()."user/load_staff_groups_form/i/".encryptValue($row['id'])."' title=\"Click to edit this group's details.\"><img src='".base_url()."images/edit.png' border='0'/></a>";
			#}
			
			#if(check_user_access($this,'update_deals')){
				echo " &nbsp;&nbsp; <a class='fancybox fancybox.ajax' href='".base_url()."user/manage_staff_group_rights/i/".encryptValue($row['id'])."' title=\"Click to edit this group's rights.\"><img src='".base_url()."images/user_group_settings.png' border='0'/></a>";
			#}
		
		
		 echo "</td>		
				<td valign='top'>".$row['groupname']."</td>		
				<td valign='top'>".substr($row['comments'],0,20)."..</td>
				<td valign='top'>".$staff->num_rows()."</td>
				<td class='rightListCell' valign='top'>".date("j M, Y", GetTimeStamp($row['dateadded']))."</td>		
			</tr>";
		
		$counter++;
	}
	
		
	echo "<tr>
		<td colspan='5' align='right'  class='layer_table_pagination'>".
		pagination($this->session->userdata('search_total_results'), $rows_per_page, $current_list_page, base_url()."user/manage_staff_groups/p/%d", "user-groups-results")
		."</td></tr></table>";	
	}
	else
	{
		echo "<div>No staff groups have been created.<br />Click <a class='fancybox fancybox.ajax' href='".base_url()."user/load_staff_groups_form')' title='Click to add a user'><i>here</i></a> to create a staff group</div>";
	}
?>
            
   
        </td>
        </tr>
      
    </table>
</div>	
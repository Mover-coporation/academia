<div class="content">
        <table border="0" cellspacing="0" cellpadding="10" width="100%" id='contenttable'>            
 <?php   
if(isset($msg)){
	echo "<tr><td colspan='4'>".format_notice($msg)."</td></tr>";
}
?>           
            
          <tr>
            <td valign="top">
            <div style="display:none">
            <a href="javascript:void(0)" id="manage-staff" onclick="updateFieldLayer('<?php echo base_url().'user/manage_staff';?>','','','results','');">&nbsp;</a>
            </div>
            
            <div id="results">
            <?php  
			#$page_list = array();
			if(!empty($page_list))
			{
				echo "<table width='100%' border='0' cellspacing='0' cellpadding='5'>
          	<tr>
			<td class='listheader' width='1%'>&nbsp;</td>
           	<td class='listheader' nowrap>User &nbsp;<a class='fancybox fancybox.ajax' href='".base_url()."user/load_staff_form')' title='Click to add a user'><img src='".base_url()."images/add_item.png' border='0'/></a></td>
			<td class='listheader' nowrap>Username</td>
			<td class='listheader' nowrap>Staff Group</td>
           	<td class='listheader' nowrap>Phone</td>
			<td class='listheader' nowrap>Email</td>
			<td class='listheader' nowrap>Date Added</td>
			</tr>";	
	$counter = 0;	
	foreach($page_list AS $row)
	{
		#User group details
		$usergroup = get_user_group_details($this, $row['usergroup']);
		if(empty($usergroup)) $usergroup ['groupname'] = '';
		
		#Show one row at a time
		echo "<tr id='tr_".$row['id']."' class='listrow' style='".get_row_color($counter, 2)."'>
		<td class='leftListCell rightListCell' valign='top' nowrap>";
		
			#if(check_user_access($this,'delete_deal')){
				echo "<a href='javascript:void(0)' onclick=\"asynchDelete('".base_url()."user/delete_staff/i/".encryptValue($row['id'])."', 'Are you sure you want to remove this user? \\nThis operation can not be undone. \\nClick OK to confirm, \\nCancel to cancel this operation and stay on this page.', 'tr_".$row['id']."');\" title=\"Click to remove this user.\"><img src='".base_url()."images/delete.png' border='0'/></a>";
			#}
		
			#if(check_user_access($this,'update_deals')){
				echo " &nbsp;&nbsp; <a class='fancybox fancybox.ajax' href='".base_url()."user/load_staff_form/i/".encryptValue($row['id'])."' title=\"Click to edit this user details.\"><img src='".base_url()."images/edit.png' border='0'/></a>";
			#}
		
		
		 echo "</td>
		
		<td valign='top'>". ucwords(strtolower($row['firstname']." ".$row['lastname']))."</td>		
		<td valign='top'>".$row['username']."</td>
		<td valign='top'>".check_empty_value($usergroup['groupname'], 'N/A')."</td>		
		<td valign='top' nowrap>".$row['telephone']."</td>		
		<td valign='top'>".$row['emailaddress']."</td>
		<td valign='top' class='rightListCell'>".date("j M, Y", GetTimeStamp($row['dateadded']))."</td>		
		</tr>";
		
		$counter++;
	}
	
		
	echo "<tr>
	<td colspan='5' align='right'  class='layer_table_pagination'>".
	pagination($this->session->userdata('search_total_results'), $rows_per_page, $current_list_page, base_url()."user/manage_staff/p/%d", 'results')
	."</td>
	</tr>
	</table>";	
			}
			else
			{
				echo "<div>No users have been registered.</div";
			}
		
		?>
            
            </div>
            </td>
            </tr>
          
        </table>
    </div>

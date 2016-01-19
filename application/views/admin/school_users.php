<div>
	<table border="0" cellspacing="0" cellpadding="10" width="100%" id='contenttable'>
          <tr>
            <td colspan="2" style="padding-top:0px;" class="pageheader">
            <table>
          		<tr>
            		<td valign="middle"><div class="page-title">Manage School Users</div></td>
            		<td valign="middle"><?php echo "<div class='page-section'>(".$schooldetails['schoolname'].")</div>"; ?></td>
            	</tr>
          </table>
			</td>
          </tr>
          <tr>
            <td colspan="2" style="padding-top:0px;" class="pageheader">
            	<div class="grey_ruler"></div>
			</td>
          </tr>
            
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
			<td class='listheader'>&nbsp;</td>
           	<td class='listheader' nowrap>Name&nbsp;<a class='fancybox fancybox.ajax' href='".base_url()."admin/add_school_user/s/".encryptValue($schooldetails['id'])."' title='Click to add a school user'><img src='".base_url()."images/add_item.png' border='0'/></a></td>
			<td class='listheader' nowrap>Username</td>
           	<td class='listheader' nowrap>Phone No</td>
			<td class='listheader' nowrap>Email Address</td>
			<td class='listheader' nowrap>Is Admin ?</td>
			<td class='listheader' nowrap>Date Added</td>
			</tr>";	
	$counter = 0;	
	foreach($page_list AS $row)
	{
		#Show one row at a time
		echo "<tr style='".get_row_color($counter, 2)."'>
		<td valign='top' nowrap>";		
		
		echo "<a href='javascript:void(0)' onclick=\"confirmDeleteEntity('".base_url()."admin/delete_school_user/i/".encryptValue($row['id'])."', 'Are you sure you want to remove this user? \\nThis operation can not be undone. \\nClick OK to confirm, \\nCancel to cancel this operation and stay on this page.');\" title=\"Click to remove this user.\"><img src='".base_url()."images/delete.png' border='0'/></a>";		
		
		echo " &nbsp;&nbsp; <a class='fancybox fancybox.ajax' href='".base_url()."admin/add_school_user/i/".encryptValue($row['id'])."' title=\"Click to edit this user details.\"><img src='".base_url()."images/edit.png' border='0'/></a>";
		
		 echo "</td>
		
		<td valign='top'>".$row['firstname']." ".$row['lastname']."</td>
		
		<td valign='top'>".$row['username']."</td>
				
		<td valign='top' nowrap>".$row['telephone']."</td>
		
		<td valign='top'>".$row['emailaddress']."</td>
		<td valign='top'>".$row['isschooladmin']."</td>
		<td valign='top'>".date("j M, Y", GetTimeStamp($row['dateadded']))."</td>		
		</tr>";
		
		$counter++;
	}
	
		
	echo "<tr>
	<td colspan='5' align='right'  class='layer_table_pagination'>".
	pagination($this->session->userdata('search_total_results'), $rows_per_page, $current_list_page, base_url()."deal/manage_deals/p/%d")
	."</td>
	</tr>
	</table>";	
			}
			else
			{
				echo "<div>No users have been registered for <b>".$schooldetails['schoolname'].".</b><br />Click <i><a class='fancybox fancybox.ajax' href='".base_url()."admin/add_school_user/s/".encryptValue($schooldetails['id'])."'>here</a></i> to add a user.</div";
			}
		
		?>
            
            
            </td>
            </tr>
          
        </table>
</div>
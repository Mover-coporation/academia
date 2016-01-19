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
			<td class='listheader'>&nbsp;</td>
			<td class='listheader'>Date Added</td>
           	<td class='listheader' nowrap>Sponsor&nbsp;<a class='fancybox fancybox.ajax' href='".base_url()."students/load_add_sponsor_form/m/" . $i . "' title='Click to add a sponsor'><img src='".base_url()."images/add_item.png' border='0'/></a></td>
			<td class='listheader' nowrap align='right'>From</td>
			<td class='listheader' nowrap align='right'>To</td>
			</tr>";	
	$counter = 0;
	$balance = 0;
	$total_debit = 0;
	$total_credit = 0;
	foreach($page_list AS $row)
	{		
		echo "<tr class='listrow' style='".get_row_color($counter, 2, 'row_borders')."'>
		<td valign='top' class='leftListCell rightListCell' nowrap>";
		
			#if(check_user_access($this,'delete_deal')){
				echo "<a href='javascript:void(0)' onclick=\"confirmDeleteEntity('".base_url()."students/delete_sponsorship/i/".encryptValue($row['sponsorshipid'])."', 'Are you sure you want to remove this sponsorship? \\nThis operation can not be undone. \\nClick OK to confirm, \\nCancel to cancel this operation and stay on this page.');\" title=\"Click to remove this fee.\"><img src='".base_url()."images/delete.png' border='0'/></a>";
			#}	
			
			echo " &nbsp;&nbsp; <a class='fancybox fancybox.ajax' href='".base_url()."students/load_add_sponsor_form/i/".encryptValue($row['sponsorshipid'])."/m/" . encryptValue($student_info['id']) . "' title=\"Click to the sponsorship details.\"><img src='".base_url()."images/edit.png' border='0'/></a>";
		
		 echo "</td>		
		 		<td valign='top'>".date("j M, Y", GetTimeStamp($row['dateadded']))."</td>
				<td valign='top'>".$row['sponsorfirstname']. " " . $row['sponsorlastname'] . "</td>		
				<td valign='top' nowrap align='right'>". (($row['fromdate'] != '0000-00-00')? date("j M, Y", GetTimeStamp($row['todate'])) : '<i>N/A</i>') . "</td>
				<td valign='top' class='rightListCell' nowrap align='right'>".(($row['todate'] != '0000-00-00')? date("j M, Y", GetTimeStamp($row['todate'])) : '<i>N/A</i>') . "</td>	
			</tr>";
		
		$counter++;
	}
			
	echo "<tr>
	<td colspan='6' align='right'  class='layer_table_pagination'>".
	pagination($this->session->userdata('search_total_results'), $rows_per_page, $current_list_page, base_url()."classes/manage_classes/p/%d")
	."</td>
	</tr>
	</table>";	
			}
			else
			{
				echo "<div id='no-sponsor-msg'>". 
						format_notice("WARNING:" .((!empty($student_info))? $student_info['firstname'].
									  ' has no sponsor.' : 'No sponsor has been added.'). 
					 " Click <a class='fancybox fancybox.ajax' href='".base_url()."students/load_add_sponsor_form/m/" . $i . "')' title='Click to add a sponsor'><i>here</i></a> to add a sponsor")."</div>";
					 
			}
		
		?>  
            </td>
            </tr>
          
        </table>
    
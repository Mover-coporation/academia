
 <?php  
			#$page_list = array();
			if(!empty($page_list))
			{
				echo "<table width='100%' border='0' cellspacing='0' cellpadding='5'>
          	<tr>
			<td class='listheader'>&nbsp;</td>
           	<td class='listheader' nowrap>Date &nbsp;<a class='fancybox fancybox.ajax' href='".base_url()."discipline/load_incident_form/s/" . $i . "')' title='Click to add a class'><img src='".base_url()."images/add_item.png' border='0'/></a></td>
			<td class='listheader' nowrap>Incident detail</td>
           	<td class='listheader' nowrap>Response</td>
			<td class='listheader' nowrap>Action taken</td>
			</tr>";	
	$counter = 0;	
	foreach($page_list AS $row)
	{
		#Show one row at a time
		echo "<tr id='tr_".$row['incidentid']."' class='listrow ".(($counter%2)? '' : 'grey_list_row')."'>
		<td class='leftListCell rightListCell' valign='bottom' width='1%' nowrap>";
		
			#if(check_user_access($this,'delete_deal')){
				echo "<a href='javascript:void(0)' onclick=\"asynchDelete('".base_url()."classes/delete_class/i/".encryptValue($row['incidentid'])."', 'Are you sure you want to delete this incident? \\nThis operation can not be undone. \\nClick OK to confirm, \\nCancel to cancel this operation and stay on this page.', 'tr_".$row['incidentid']."');\" title=\"Click to remove this class.\"><img src='".base_url()."images/delete.png' border='0'/></a>";
			#}
		
			#if(check_user_access($this,'update_deals')){
				echo " &nbsp;&nbsp; <a href='".base_url()."classes/load_class_form/i/".encryptValue($row['incidentid'])."' title=\"Click to edit this class details.\"><img src='".base_url()."images/edit.png' border='0'/></a>";
			#}
		
		
		 echo "</td>		
				<td valign='top'>".date("j M, Y", GetTimeStamp($row['incidentdate']))."</td>		
				<td valign='top'>".trimStr($row['incidentdetails'], 80)."</td>				
				<td valign='top' nowrap>" . ucwords($row['response']) . "</td>		
				<td valign='top' class='rightListCell'>" . trimStr($row['actiontaken'], 50) . "</td>		
			</tr>";
		
		$counter++;
	}
	
		
	echo "<tr>
	<td colspan='5' align='right'  class='layer_table_pagination'>".
	pagination($this->session->userdata('search_total_results'), $rows_per_page, $current_list_page, base_url()."classes/manage_classes/p/%d", 'results')
	."</td>
	</tr>
	</table>";	
			}
			else
			{
				if(!empty($student_details))
				{
					echo "<div>" . $student_details['firstname'] . " has not had any disciplinary incidents so far. Click <a class='fancybox fancybox.ajax' href='".base_url()."discipline/load_incident_form/s/" . $i . "')' title='Click to add a class'><i>here</i></a> to add an incident</div>";
				}
				else
				{
					echo "<div>No disciplinary incidents have been registered so far. Click <a class='fancybox fancybox.ajax' href='".base_url()."discipline/load_incident_form')' title='Click to add a class'><i>here</i></a> to add a new incident</div>";
				}				
			}
		
		?>
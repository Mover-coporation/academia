
 <?php  
			#$page_list = array();
			if(!empty($page_list))
			{
				echo "<table width='100%' border='0' cellspacing='0' cellpadding='5'>
          	<tr>
			<td class='listheader'>&nbsp;</td>
           	<td class='listheader' nowrap>Class &nbsp;<a class='fancybox fancybox.ajax' href='".base_url()."classes/load_class_form')' title='Click to add a class'><img src='".base_url()."images/add_item.png' border='0'/></a></td>
			<td class='listheader' nowrap>Rank</td>
           	<td class='listheader' nowrap>Students</td>
			<td class='listheader' nowrap>Streams</td>
			<td class='listheader' nowrap>Date Added</td>
			</tr>";	
	$counter = 0;	
	foreach($page_list AS $row)
	{
		#Show one row at a time
		echo "<tr id='tr_".$row['classid']."' class='listrow' style='".get_row_color($counter, 2)."'>
		<td class='leftListCell rightListCell' valign='bottom' width='1%' nowrap>";
		
			#if(check_user_access($this,'delete_deal')){
				echo "<a href='javascript:void(0)' onclick=\"asynchDelete('".base_url()."classes/delete_class/i/".encryptValue($row['classid'])."', 'Are you sure you want to remove this class? \\nThis operation can not be undone. \\nClick OK to confirm, \\nCancel to cancel this operation and stay on this page.', 'tr_".$row['classid']."');\" title=\"Click to remove this class.\"><img src='".base_url()."images/delete.png' border='0'/></a>";
			#}
		
			#if(check_user_access($this,'update_deals')){
				echo " &nbsp;&nbsp; <a href='".base_url()."classes/load_class_form/i/".encryptValue($row['classid'])."' title=\"Click to edit this class details.\"><img src='".base_url()."images/edit.png' border='0'/></a>";
			#}
		
		
		 echo "</td>		
				<td valign='top'>".$row['classname']."</td>		
				<td valign='top'>".$row['rank']."</td>				
				<td valign='top' nowrap>" . $row['numOfStudents'] . "</td>		
				<td valign='top'>0 | <a href=\"#\">Add stream</a></td>
				<td class='rightListCell'  valign='top'>".date("j M, Y", GetTimeStamp($row['classdateadded']))."</td>		
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
				echo "<div>No classes have been added. Click <a class='fancybox fancybox.ajax' href='".base_url()."classes/load_class_form')' title='Click to add a class'><i>here</i></a> to add a class</div>";
			}
		
		?>
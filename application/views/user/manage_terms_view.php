
            
            <?php  
			#$page_list = array();
			if(!empty($page_list))
			{
				echo "<table width='100%' border='0' cellspacing='0' cellpadding='5'>
          	<tr>
			<td class='listheader'>&nbsp;</td>
           	<td class='listheader' nowrap>Term &nbsp;<a class='fancybox fancybox.ajax' href='".base_url()."terms/load_term_form')' title='Click to add a term'><img src='".base_url()."images/add_item.png' border='0'/></a></td>
			<td class='listheader' nowrap>Start date</td>
           	<td class='listheader' nowrap>End date</td>
			<td class='listheader' nowrap>Days left</td>
			<td class='listheader' nowrap>Date Added</td>
			</tr>";	
	$counter = 0;	
	foreach($page_list AS $row)
	{
		#Show one row at a time
		echo "<tr id='tr_".$row['id']."' class='listrow' style='".get_row_color($counter, 2)."'>
		<td class='leftListCell rightListCell' valign='bottom' width='1%' nowrap>";
		
			#if(check_user_access($this,'delete_deal')){
				echo "<a href='javascript:void(0)' onclick=\"asynchDelete('".base_url()."terms/delete_term/i/".encryptValue($row['id'])."', 'Are you sure you want to remove this term? \\nThis operation can not be undone. \\nClick OK to confirm, \\nCancel to cancel this operation and stay on this page.', 'tr_".$row['id']."');\" title=\"Click to remove this term.\"><img src='".base_url()."images/delete.png' border='0'/></a>";
			#}
		
			#if(check_user_access($this,'update_deals')){
				echo " &nbsp;&nbsp; <a class='fancybox fancybox.ajax' href='".base_url()."terms/load_term_form/i/".encryptValue($row['id'])."' title=\"Click to edit this term's details.\"><img src='".base_url()."images/edit.png' border='0'/></a>";
			#}
		
		 $days_left = get_date_diff(date('m/d/Y h:i:s a', time()),  $row['enddate'], 'days');
         $days_left_str = (($days_left < 0)? '<i>Term ended</i>' : $days_left);

         if(get_date_diff(date('m/d/Y h:i:s a', time()),  $row['startdate'], 'days') > 14)
         {
             $days_left_str = "Term not started";
         }
        elseif(get_date_diff(date('m/d/Y h:i:s a', time()),  $row['startdate'], 'days') < 14 && get_date_diff(date('m/d/Y h:i:s a', time()),  $row['startdate'], 'days') > 0)
        {
            $days_left_str = "Term starts in " . get_date_diff(date('m/d/Y h:i:s a', time()),  $row['startdate'], 'days') . " days";
        }

		 echo "</td>		
				<td valign='top'>".$row['term']." [".$row['year']."]</td>		
				<td valign='top'>".date("j M, Y", GetTimeStamp($row['startdate']))."</td>				
				<td valign='top' nowrap>".date("j M, Y", GetTimeStamp($row['enddate']))."</td>		
				<td valign='top'>". $days_left_str . "</td>
				<td class='rightListCell' valign='top'>".date("j M, Y", GetTimeStamp($row['dateadded']))."</td>		
			</tr>";
		
		$counter++;
	}
	
		
	echo "<tr>
	<td colspan='5' align='right'  class='layer_table_pagination'>".
	pagination($this->session->userdata('search_total_results'), $rows_per_page, $current_list_page, base_url()."terms/manage_terms/p/%d", 'results')
	."</td>
	</tr>
	</table>";	
			}
			else
			{
				echo "<div>No terms have been added.<br />Click <a class='fancybox fancybox.ajax' href='".base_url()."terms/load_term_form')' title='Click to add a term'><i>here</i></a> to add a term</div>";
			}
		
		?>


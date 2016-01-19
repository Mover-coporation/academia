<div class="content" id="fees-structure-content">
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
           	<td class='listheader' nowrap>Fee &nbsp;<a class='fancybox fancybox.ajax' href='".base_url()."finances/load_fee_form' title='Click to add a student'><img src='".base_url()."images/add_item.png' border='0'/></a></td>
			<td class='listheader' nowrap>Amount</td>
			<td class='listheader' nowrap>Payment</td>
           	<td class='listheader' nowrap>Term</td>
			<td class='listheader' nowrap>Classes</td>
			<td class='listheader' nowrap>Date Added</td>
			</tr>";	
	$counter = 0;	
	foreach($page_list AS $row)
	{
		#Get the term title and year
		$terminfo = get_term_name_year($this, $row['term']);
		
		#Get applicable classes
		$class_str = '';
		$classids = explode('|', $row['classes']);
		$classids = remove_empty_indices($classids);
		
		#Show in drop down if more than 1 class
		if(count($classids) > 1){
			foreach ($classids AS $key => $classid)
				$class_str .= '<option>'.get_class_title($this, $classid).'</option>';
				$class_str = '<select class="selectfield">'.$class_str.'</select>';
		}
		elseif(count($classids) > 0)
		{
			$class_str = get_class_title($this, $classids[1]);
		}
		
		#Show one row at a time
		echo "<tr class='listrow' style='".get_row_color($counter, 2)."'>
		<td class='leftListCell rightListCell' valign='top' nowrap>";
		
			#if(check_user_access($this,'delete_deal')){
				echo "<a href='javascript:void(0)' onclick=\"confirmDeleteEntity('".base_url()."finances/delete_fee/i/".encryptValue($row['id'])."', 'Are you sure you want to remove this fee? \\nThis operation can not be undone. \\nClick OK to confirm, \\nCancel to cancel this operation and stay on this page.');\" title=\"Click to remove this fee.\"><img src='".base_url()."images/delete.png' border='0'/></a>";
			#}
		
			#if(check_user_access($this,'update_deals')){
				echo " &nbsp;&nbsp; <a href='".base_url()."finances/load_fee_form/i/".encryptValue($row['id'])."' title=\"Click to edit this fee details.\"><img src='".base_url()."images/edit.png' border='0'/></a>";
			#}
		
		
		 echo "</td>		
				<td valign='top'>".$row['fee']."</td>		
				<td valign='top'>".$row['amount']."</td>
				<td valign='top'>".$row['frequency']."</td>				
				<td valign='top' nowrap>".$terminfo['term']." [".$terminfo['year']."]</td>		
				<td valign='top'>".$class_str."</td>
				<td class='rightListCell' valign='top'>".date("j M, Y", GetTimeStamp($row['dateadded']))."</td>		
			</tr>";
		
		$counter++;
	}
	
		
	echo "<tr>
	<td colspan='5' align='right'  class='layer_table_pagination'>".
	pagination($this->session->userdata('search_total_results'), $rows_per_page, $current_list_page, base_url()."finances/manage_fee_structure/p/%d", "fees-structure-content")
	."</td>
	</tr>
	</table>";	
			}
			else
			{
				echo "<div>No fee types have been created. Click <a class='fancybox fancybox.ajax' href='".base_url()."finances/load_fee_form' title='Click to add a fee type'><i>here</i></a> to create a fee type.</div>";
			}
		
		?>
            
            
            </td>
            </tr>
          
        </table>
    </div>
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
           	<td class='listheader' nowrap>Fee</td>
			<td class='listheader' align='right' nowrap>Total Debit</td>
			<td class='listheader' align='right' nowrap>Total Credit</td>
           	<td class='listheader' align='right' nowrap>Balance</td>
			</tr>";	
	$counter = 0;	
	foreach($page_list AS $row)
	{	
		#Show one row at a time
		echo "<tr class='listrow' style='".get_row_color($counter, 2)."'>
		<td class='leftListCell rightListCell' valign='top' nowrap>";
		
			#if(check_user_access($this,'delete_deal')){
				echo "<a href='javascript:void(0)' onclick=\"confirmDeleteEntity('".base_url()."finances/delete_fee/i/".encryptValue($row['feeid'])."', 'Are you sure you want to remove this fee? \\nThis operation can not be undone. \\nClick OK to confirm, \\nCancel to cancel this operation and stay on this page.');\" title=\"Click to remove this fee.\"><img src='".base_url()."images/delete.png' border='0'/></a>";
			#}
		
			#if(check_user_access($this,'update_deals')){
				echo " &nbsp;&nbsp; <a href='".base_url()."finances/load_fee_form/i/".encryptValue($row['feeid'])."' title=\"Click to edit this fee details.\"><img src='".base_url()."images/edit.png' border='0'/></a>";
			#}
		
		
		 echo "</td>		
				<td valign='top'>".$row['feename']."</td>		
				<td valign='top' class='number_format' align='right'>". number_format($row['totalDebit'], 0, '.', ',')."</td>
				<td valign='top' class='number_format' align='right'>". number_format($row['totalCredit'], 0, '.', ',')."</td>				
				<td valign='top' class='number_format rightListCell' align='right'>". number_format(($row['totalCredit'] - $row['totalDebit']), 0, '.', ',')."</td>
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
				echo "<div>No transactions have been made.</div>";
			}
		
		?>
            
            
            </td>
            </tr>
          
        </table>
    </div>
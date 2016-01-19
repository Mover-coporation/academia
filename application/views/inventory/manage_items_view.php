<table border="0" cellspacing="0" cellpadding="10" width="100%" id='contenttable'>
          <tr>
            <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="5" align="left">
              <td><table border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><b>Search:</b></td>
    <td>&nbsp;</td>
    <td><input name="search" type="text" id="search" size="35" class="textfield" value="" onkeyup="startInstantSearch('search', 'searchby', '<?php echo base_url();?>search/load_results/type/search_item_list/layer/searchresults');showPartLayer('searchresults', 'fast');" onkeypress="return handleEnter(this, event)"/></td>
    <td>&nbsp;<input name="searchby" type="hidden" id="searchby" value="itemname" /></td>
              </tr>
</table>
</td>
              </tr>
            <tr>
              <td>
<div id="searchresults">
<?php             
#Show search results
if(!empty($page_list))
{
	echo "<table width='100%' border='0' cellspacing='0' cellpadding='5'>
          	<tr>
			<td class='listheader'>&nbsp;</td>
			<td class='listheader' nowrap>Item Name</td>
			
			<td class='listheader' nowrap>In</td>
			<td class='listheader' nowrap>Out</td>
			<td class='listheader' nowrap>Remaining</td>			
			<td class='listheader' nowrap>Units</td>
			</tr>";	
	$counter = 0;	
	foreach($page_list AS $row)
	{
		$stocked = get_stocked($this, $row['id']);
		$sold = get_sold($this, $row['id']);
		$remaining = $stocked - $sold;
		
		#Assign zeros to empty values	
		if(empty($stocked)) $stocked=0;
		if(empty($sold)) $sold=0;
		
		#Show one row at a time
		if($row['reorderlevel'] >= $remaining)
			echo "<tr style='color:red;".get_row_color($counter, 2)."'><td valign='top' nowrap>";
		else
			echo "<tr style='".get_row_color($counter, 2)."'>
		<td valign='top' nowrap>";
		
		if(1){
		echo "<a href='javascript:void(0)' onclick=\"confirmDeleteEntity('".base_url()."inventory/delete_item/i/".encryptValue($row['id'])."', 'Are you sure you want to remove this item? \\nThis operation can not be undone. \\nClick OK to confirm, \\nCancel to cancel this operation and stay on this page.');\" title=\"Click to remove this item.\"><img src='".base_url()."images/delete.png' border='0'/></a>";
		}
		
		if(1){
		echo " <a href='".base_url()."inventory/load_item_form/i/".encryptValue($row['id'])."' title=\"Click to edit this item.\"><img src='".base_url()."images/edit.png' border='0'/></a>";
		}
		
		if(1){
		echo " <a href='".base_url()."inventory/load_inventory_form/a/".encryptValue($row['id'])."' title=\"Click to add purchase for this item.\"><img src='".base_url()."images/add_icon.png' border='0'/></a>";
		}
		
		if(1){
		echo "&nbsp;&nbsp; <a href='".base_url()."inventory/load_transaction_form/s/".encryptValue($row['id'])."' title=\"Click to issue out for this item.\">Issue out</a>";
		}
		
		 echo "</td>
		
		<td valign='top'><a href='".base_url()."inventory/load_item_form/i/".encryptValue($row['id'])."/a/".encryptValue("view")."' title=\"Click to view this item.\">".$row['itemname']."</a></td>
		
		
		
		<td valign='top'>".$stocked."</td>
		
		<td valign='top'>".$sold."</td>
		
		<td valign='top'>".($stocked - $sold)."</td>
		
		<td valign='top'>".$row['unitspecification']."</td>
		
		</tr>";
		
		$counter++;
	}
	
		
	echo "<tr>
	<td colspan='5' align='right'  class='layer_table_pagination'>".
	pagination($this->session->userdata('search_total_results'), $rows_per_page, $current_list_page, base_url()."inventory/manage_inventory/p/%d")
	."</td>
	</tr>
	</table>";	
		
} else {
	echo format_notice("There are no items at the moment.");
	
}
?></div>
              </td>
              </tr>

        </table></td>
            </tr>
          
        </table>

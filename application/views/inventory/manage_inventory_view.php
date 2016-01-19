<table width="100%" border="0" cellspacing="0" cellpadding="5" align="left">
              <td><table border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><b>Search:</b></td>
    <td>&nbsp;</td>
    <td><input name="search" type="text" id="search" size="35" class="textfield" value="" onkeyup="startInstantSearch('search', 'searchby', '<?php echo base_url();?>search/load_results/type/inventory_list/layer/searchresults');showPartLayer('searchresults', 'fast');" onkeypress="return handleEnter(this, event)"/></td>
    <td>&nbsp;<input name="searchby" type="hidden" id="searchby" value="supplier__itemname__invoicenumber" /></td>
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
			<td class='listheader' nowrap>Date Added</td>
           	<td class='listheader' nowrap>Item Name</td>
			<td class='listheader' nowrap>Supplier</td>
			<td class='listheader' nowrap>Invoice Number</td>
			<td class='listheader' nowrap>Quantity</td>
			</tr>";	
	$counter = 0;	
	foreach($page_list AS $row)
	{
		
		#Show one row at a time
		echo "<tr style='".get_row_color($counter, 2)."'>
		<td valign='top' nowrap>";
		
		if(1){
		echo "<a href='javascript:void(0)' onclick=\"confirmDeleteEntity('".base_url()."inventory/delete_inventory/i/".encryptValue($row['inventoryid'])."', 'Are you sure you want to remove this inventory? \\nThis operation can not be undone. \\nClick OK to confirm, \\nCancel to cancel this operation and stay on this page.');\" title=\"Click to remove this inventory.\"><img src='".base_url()."images/delete.png' border='0'/></a>";
		}
		
		if(1){
		echo " <a href='".base_url()."inventory/load_inventory_form/i/".encryptValue($row['inventoryid'])."/a/".encryptValue($row['itemid'])."' title=\"Click to edit this inventory.\"><img src='".base_url()."images/edit.png' border='0'/></a>";
		}
		
		 echo "</td>
		
		<td valign='top'>".date("j M, Y", GetTimeStamp($row['datecreated']))."</td>		
		
		<td valign='top'><a href='".base_url()."inventory/load_item_form/i/".encryptValue($row['itemid'])."/a/".encryptValue("view")."' title=\"Click to view this item.\">".$row['itemname']."</a></td>
		
		<td valign='top'>".$row['supplier']."</td>
		
		<td valign='top'>".$row['invoicenumber']."</td>
		
		<td valign='top'>".$row['quantity']."</td>
		
		
		
		</tr>";
		
		$counter++;
	}
	
		
	echo "<tr>
	<td colspan='5' align='right'  class='layer_table_pagination'>".
	pagination($this->session->userdata('search_total_results'), $rows_per_page, $current_list_page, base_url()."deal/manage_deals/p/%d")
	."</td>
	</tr>
	</table>";	
		
} else {
	echo format_notice("There are no inventory at the moment.");
	
}
?></div>
              </td>
              </tr>

        </table>
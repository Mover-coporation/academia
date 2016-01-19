<?php
if(empty($requiredfields)){
  $requiredfields = array();
}

$indicator = (!empty($isview))? "": "<span class='redtext'>*</span>";?>

<table width="100%" border="0" cellspacing="0" cellpadding="5" align="left">
              <td><table border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><b>Search:</b></td>
    <td>&nbsp;</td>
    <td><input name="search" type="text" id="search" size="35" class="textfield" value="" onkeyup="startInstantSearch('search', 'searchby', '<?php echo base_url();?>search/load_results/type/search_borrowers_list/layer/searchresults');showPartLayer('searchresults', 'fast');" onkeypress="return handleEnter(this, event)"/></td>
    <td>&nbsp;<input name="searchby" type="hidden" id="searchby" value="stocktitle__firstname__lastname" /></td>
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
			<td class='listheader' nowrap>Date Returned</td>
			<td class='listheader' nowrap>Title</td>
			<td class='listheader' nowrap>Serial Number</td>
			</tr>";	
	$counter = 0;	
	foreach($page_list AS $row)
	{
		#check expiry of rental period
		$currentdate = date("Y-m-d H:i:s");
		#Show one row at a time
		
			echo "<tr style='".get_row_color($counter, 2)."'>
			<td valign='top' nowrap>";
		
		if(1){
		echo "<a href='javascript:void(0)' onclick=\"confirmDeleteEntity('".base_url()."library/delete_return/i/".encryptValue($row['returnid'])."', 'Are you sure you want to remove this borrower? \\nThis operation can not be undone. \\nClick OK to confirm, \\nCancel to cancel this operation and stay on this page.');\" title=\"Click to remove this borrower.\"><img src='".base_url()."images/delete.png' border='0'/></a>";
		}
		
		if(1){
		echo " <a href='".base_url()."library/return_rental/i/".encryptValue($row['returnid'])."/s/".encryptValue($row['stockid'])."' title=\"Click to edit this return.\"><img src='".base_url()."images/edit.png' border='0'/></a>";
		}		
		 echo "</td>
		
		<td valign='top'>".date("j M, Y", GetTimeStamp($row['returndate']))."</td>
		
		<td valign='top'><a class=\"fancybox fancybox.ajax\" href='".base_url()."library/load_stock_form/i/".encryptValue($row['stockid'])."/a/".encryptValue("view")."' title=\"Click to view this stock item.\">".$row['stocktitle']."</a></td>
		
		<td valign='top'><a class=\"fancybox fancybox.ajax\" href='".base_url()."library/load_stock_item_form/i/".encryptValue($row['item'])."/a/".encryptValue("view")."/s/".encryptValue($row['stockid'])."' title=\"Click to view this item.\">".$row['serialnumber']."</a></td>
		
		</tr>";
		
		$counter++;
	}
	
		
	echo "<tr>
	<td colspan='5' align='right'  class='layer_table_pagination'>".
	pagination($this->session->userdata('search_total_results'), $rows_per_page, $current_list_page, base_url()."library/manage_borrowers/p/%d")
	."</td>
	</tr>
	</table>";	
		
} else {
	echo format_notice("There is no return at the moment.");
	
}
?></div>
              </td>
              </tr>

        </table>
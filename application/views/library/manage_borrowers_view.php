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
// if(!empty($page_list))
// {
	echo "<table width='100%' border='0' cellspacing='0' cellpadding='5'>
          	<tr>
			<td class='listheader'>&nbsp;</td>
			<td class='listheader' nowrap>Date Borrowed</td>
           	<td class='listheader' nowrap>Title &nbsp;<a class='fancybox fancybox.ajax' href='".base_url()."library/load_borrower_form' title='Click to add a Book'><img src='".base_url()."images/add_item.png' border='0'/></a></td>
			<td class='listheader' nowrap>Returned / Borrowed</td>
			<td class='listheader' nowrap>Student</td>
			
			<td class='listheader' nowrap>Date Expected</td>
			</tr>";	
	$counter = 0;	
	foreach($page_list AS $row)
	{
		#check expiry of rental period
		$currentdate = date("Y-m-d H:i:s");
		$borrower_status = check_borrower_status($this, $row['borrowerid']);
		#Show one row at a time
		if(($borrower_status != 0) && $currentdate > $row['returndate'])
			echo "<tr style='color:red;".get_row_color($counter, 2)."'>
			<td valign='top' nowrap>";
		else
			echo "<tr style='".get_row_color($counter, 2)."'>
			<td valign='top' nowrap>";
		
		if(1){
		echo "<a href='javascript:void(0)' onclick=\"confirmDeleteEntity('".base_url()."library/delete_borrower/i/".encryptValue($row['borrowerid'])."', 'Are you sure you want to remove this borrower? \\nThis operation can not be undone. \\nClick OK to confirm, \\nCancel to cancel this operation and stay on this page.');\" title=\"Click to remove this borrower.\"><img src='".base_url()."images/delete.png' border='0'/></a>";
		}
		
		if(1 == 0){
		echo " <a href='".base_url()."library/load_borrower_form/i/".encryptValue($row['borrowerid'])."/s/".encryptValue($row['stockid'])."' title=\"Click to edit this borrower.\"><img src='".base_url()."images/edit.png' border='0'/></a>";
		}
		
		if(1 && $borrower_status != 0){
		echo "&nbsp;&nbsp;<a href='".base_url()."library/return_rental/i/".encryptValue($row['borrowerid'])."' title=\"Click to return items for this rental.\"><img src='".base_url()."images/returns.png' border='0'/></a>";
		}
		else{
			echo "&nbsp;&nbsp;";
		}
		
		 echo "</td>
		
		<td valign='top'>".date("j M, Y", GetTimeStamp($row['datetaken']))."</td>
		
		<td valign='top'><a href='".base_url()."library/load_stock_form/i/".encryptValue($row['stockid'])."/a/".encryptValue("view")."' title=\"Click to view this stock item.\">".$row['stocktitle']."</a></td>'
		
		<td valign='top'><a href='".base_url()."library/load_borrower_form/i/".encryptValue($row['borrowerid'])."/s/".encryptValue($row['stockid'])."/a/".encryptValue("view")."' title=\"Click to view borrower details.\">".($row['copiestaken'] - $borrower_status)."/".$row['copiestaken']."</a></td>
		
		<td valign='top'>".$row['firstname']." ".$row['lastname']."</td>
		
		
		
		<td valign='top'>".date("j M, Y", GetTimeStamp($row['returndate']))."</td>
		
		</tr>";
		
		$counter++;
	}
	
		
	echo "<tr>
	<td colspan='5' align='right'  class='layer_table_pagination'>".
	pagination($this->session->userdata('search_total_results'), $rows_per_page, $current_list_page, base_url()."library/manage_borrowers/p/%d")
	."</td>
	</tr>
	</table>";	
		
// } else {
// 	echo format_notice("There is no borrower at the moment.");
	
// }
?></div>
              </td>
              </tr>

        </table>
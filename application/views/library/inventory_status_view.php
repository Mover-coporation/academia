<?php
if(empty($requiredfields)){
  $requiredfields = array();
}

$indicator = (!empty($isview))? "": "<span class='redtext'>*</span>";?>
<table width="100%" border="0" cellspacing="0" cellpadding="5" align="left">
<tr>
	<td>
    	<table border="0" cellspacing="0" cellpadding="0">
        	<tr>
             	<td><b>Search:</b></td>
                <td>&nbsp;</td>
                <td><div id="block"><input title="Type: Title, Stock Number" name="search" type="text" id="search" size="35" class="textfield" value="" onkeyup="startInstantSearch('search', 'searchby', '<?php echo base_url();?>search/load_results/type/inventory_status/layer/searchresults');showPartLayer('searchresults', 'fast');" onkeypress="return handleEnter(this, event)"/></div></td>
                <td>&nbsp;<input name="searchby" type="hidden" id="searchby" value="stocknumber__stocktitle_isbn" />
                    <div id="add-image" class="button     hover" style="width:50px;  text-align:center; float:left; margin-top:-22px;" onclick="javascript:mailed();">
                        PRINT
                    </div>
                </td>
            </tr>
        </table>
    </td>
</tr>
<tr>
    <td><div id="printreport">
<div id="searchresults">
<?php             
#Show search results
if(!empty($page_list))
{
	echo "<table width='100%' border='0' cellspacing='0' cellpadding='5'>
          	<tr>
			<td width='1%' class='listheader'>&nbsp;</td>
			<td width='1%' class='listheader'>ISBN</td>
			<td class='listheader' nowrap>Title</td>
			<td class='listheader' nowrap>Author</td>
			<td class='listheader' nowrap>Status</td>
			<td class='listheader' nowrap>Date Taken</td>
			<td class='listheader' nowrap>Date Returned</td>
			</tr>";	
			
	#print_r($page_list);
	$counter = 0;	
	
	foreach($page_list AS $row)
	{
		$row_color_class = '';
		
		if($row['bookStatus'] == 'OUT'):
			$row_color_class = 'red_list_row';
			
		else:
			$row_color_class = (($counter%2)? '' : 'grey_list_row');
		endif;
		
		#Show one row at a time
		print "<tr id='list-row-" . $row['booklibraryId'] . "' class='listrow ".$row_color_class."'>
		<td class='leftListCell rightListCell' valign='top' nowrap>";
		
		
		print "<a href='javascript:void(0)' onclick=\"asynchDelete('".base_url()."library/delete_title/i/".encryptValue($row['booklibraryId'])."', 'Are you sure you want to remove this book? \\nThis operation can not be undone. \\nClick OK to confirm, \\nCancel to cancel this operation and stay on this page.','list-row-" . $row['booklibraryId'] . "');\" title=\"Click to remove the item.\"><img src='".base_url()."images/delete.png' border='0'/></a>&nbsp;&nbsp";
		
		if($row['bookStatus'] == 'OUT')
			print "&nbsp;&nbsp<a class=\"fancybox fancybox.ajax\" href='".base_url()."library/return_book_form/i/".encryptValue($row['booklibraryId'])."' title=\"Click to view return this book.\" class='fancybox fancybox.ajax contentlink'><img src='".base_url()."images/return_item.png' border='0'/></a>&nbsp;&nbsp";
		
		 print "</td>
		 <td><a class=\"fancybox fancybox.ajax\" href='".base_url()."library/load_stock_form/i/".encryptValue($row['booklibraryId'])."/a/".encryptValue("view")."' title=\"Click to view this item.\" class='fancybox fancybox.ajax contentlink'>".$row['isbnnumber']."</a></td>
		
		<td valign='top'>".$row['bookTitle']."</td>
		
		<td valign='top'>".$row['bookAuthor']."</td>
		
		<td  align='left' valign='top'>".$row['bookStatus']."</td>
		
		<td  align='left' valign='top'>".((!empty($row['lastBorrowTransDate']))? date("j M, Y", GetTimeStamp($row['lastBorrowTransDate'])) : 'N/A')."</td>
		
		<td  align='left' class='rightListCell' valign='top'>".((!empty($row['lastBorrowTransDate']) && $row['lastBorrowTransDate'] < $row['lastReturnTransDate'])? date("j M, Y", GetTimeStamp($row['lastReturnTransDate'])) : '')."</a></td>
		
		</tr>";
		
		$counter++;
	}
	
		
	echo "<tr>
	<td colspan='5' align='right'  class='layer_table_pagination'>".
	pagination($this->session->userdata('search_total_results'), $rows_per_page, $current_list_page, base_url()."library/inventory_status/p/%d", 'results')
	."</td>	
	</table>";	
		
} else {
	echo format_notice("WARNING: No books have been added<br />Click &nbsp;<a class='fancybox fancybox.ajax' href='".base_url()."library/load_title_form' title='Click to add a Book'>here</a> to add book titles");
	
}
?>
</div>
              </td>
              </tr>

        </table>
</div> </div>
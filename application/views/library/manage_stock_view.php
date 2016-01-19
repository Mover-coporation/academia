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
                <td><div id="block"><input title="Type: Title, Stock Number" name="search" type="text" id="search" size="35" class="textfield" value="" onkeyup="startInstantSearch('search', 'searchby', '<?php echo base_url();?>search/load_results/type/search_stock_list/layer/searchresults');showPartLayer('searchresults', 'fast');" onkeypress="return handleEnter(this, event)"/></div></td>
                <td>&nbsp;<input name="searchby" type="hidden" id="searchby" value="stocknumber__stocktitle" />
                    <div id="add-image" class="button     hover" style="width:50px;  text-align:center; float:left; margin-top:-22px;" onclick="javascript:mailed();">
                        PRINT
                    </div></td>
            </tr>
        </table>
    </td>
</tr>
<tr>

    <td>

        <div id="printreport">
<div id="searchresults">

<?php             
#Show search results
if(!empty($page_list))
{
	echo "<table width='100%' border='0' cellspacing='0' cellpadding='5'>
          	<tr>
			<td width='1%' class='listheader leftListCell'>&nbsp;</td>
			<td class='listheader' nowrap>Title &nbsp;<a class='fancybox fancybox.ajax' href='".base_url()."library/load_title_form' title='Click to add a Book'><img src='".base_url()."images/add_item.png' border='0'/></a>
			&nbsp;<a class='fancybox fancybox.ajax' href='".base_url()."library/borrow_books' title='Click to issue multiple books'><img src='".base_url()."images/book.png' border='0'/></a>
			</td>
			<td class='listheader' nowrap>Author</td>
			<td class='listheader' align='right' nowrap>In</td>
			<td class='listheader' align='right' nowrap>Out</td>
			<td class='listheader' align='right' nowrap>Stocked</td>
			</tr>";	
	$counter = 0;
    echo '<span  id="printreport"> ';
	foreach($page_list AS $row)
	{

		#$stocked = get_all_stock_items($this, $row['id']);
		#$in = get_stock_items($this, $row['id'], 1);
		#$out = get_stock_items($this, $row['id'], 0);
		#Show one row at a time
		echo "<tr id='list-row-" . $row['id'] . "' class='listrow ".(($counter%2)? '' : 'grey_list_row')."'>
		<td class='leftListCell rightListCell' valign='top' nowrap>";

		// if(1==0){
		if(1){
		//echo "<a href='javascript:void(0)' onclick=\"confirmDeleteEntity('".base_url()."library/delete_stock/i/".encryptValue($row['id'])."', 'Are you sure you want to remove this item? \\nThis operation can not be undone. \\nClick OK to confirm, \\nCancel to cancel this operation and stay on this page.');\" title=\"Click to remove this item.\"><img src='".base_url()."images/delete.png' border='0'/></a>&nbsp;&nbsp;";
		echo "<a href='javascript:void(0)' onclick=\"asynchDelete('".base_url()."library/delete_title/i/".encryptValue($row['id'])."', 'Are you sure you want to remove this book? \\nThis operation can not be undone. \\nClick OK to confirm, \\nCancel to cancel this operation and stay on this page.','list-row-" . $row['id'] . "');\" title=\"Click to remove the item.\"><img src='".base_url()."images/delete.png' border='0'/></a>&nbsp;&nbsp";
		// echo "<a href='javascript:void(0)' onclick=\"asynchDelete('".base_url()."curriculum/delete_subject/i/".encryptValue($row['id'])."', 'Are you sure you want to remove this subject? \\nThis operation can not be undone. \\nClick OK to confirm, \\nCancel to cancel this operation and stay on this page.', 'tr_".$row['id']."');\" title=\"Click to remove ".$row['subject']." from the school curriculum.\"><img src='".base_url()."images/delete.png' border='0'/></a>";
		}

		if(1){
		echo " <a class=\"fancybox fancybox.ajax\" href='".base_url()."library/load_title_form/i/".encryptValue($row['id'])."' title=\"Click to edit this item.\"><img src='".base_url()."images/edit.png' border='0'/></a>&nbsp;&nbsp;";
		}

		if(1){

		echo " <a class=\"fancybox fancybox.ajax\" href='".base_url()."library/stock_title_form/s/".encryptValue($row['id'])."' title=\"Click to stock this item.\"><img src='".base_url()."images/box-icon.png' border='0'/></a>&nbsp;&nbsp;";
		}

		if($row['availableBooks'] > 0){
		echo " <a class=\"fancybox fancybox.ajax\" href='".base_url()."library/load_borrower_form/s/".encryptValue($row['id'])."' title=\"Click to lend out this item.\"><img src='".base_url()."images/book.png' border='0'/></a>";
		}

		// if($in > 0){
		// echo " <a class=\"fancybox fancybox.ajax\" href='".base_url()."library/load_borrower_form/s/".encryptValue($row['id'])."' title=\"Click to borrow this item.\"><img src='".base_url()."images/book.png' border='0'/></a>&nbsp;&nbsp;";
		// }

		 echo "</td>

		<td valign='top'>
		<a class=\"fancybox fancybox.ajax\" href='".base_url()."library/load_stock_form/i/".encryptValue($row['id'])."/a/".encryptValue("view")."' title=\"Click to view this item.\" class='fancybox fancybox.ajax contentlink'>".$row['stocktitle']."</a>
		</td>

		<td valign='top'>".$row['author']."</td>

		<td  align='right' class='number_format' valign='top'>".number_format($row['availableBooks'], 0, '.', ',')."</td>

		<td  align='right' class='number_format' valign='top'>".number_format($row['unavailableBooks'], 0, '.', ',')."</td>

		<td  align='right' class='rightListCell number_format' valign='top'>".($row['availableBooks'] + $row['unavailableBooks'])."</a></td>

		</tr>";

		$counter++;
	}
	
		
	echo "</span><tr>
	<td colspan='5' align='right'  class='layer_table_pagination'>".
	pagination($this->session->userdata('search_total_results'), $rows_per_page, $current_list_page, base_url()."library/manage_library/p/%d", 'results')
	."</td>
	</table>";
		
} else {
	echo format_notice("WARNING: No books have been added<br />Click &nbsp;<a class='fancybox fancybox.ajax' href='".base_url()."library/load_title_form' title='Click to add a Book'>here</a> to add book titles");
	
}
?>
</div>
</div>
              </td>
              </tr>

        </table>

<!-- </div> -->
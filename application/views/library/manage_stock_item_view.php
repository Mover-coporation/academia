<?php
if(empty($requiredfields)){
  $requiredfields = array();
}

$indicator = (!empty($isview))? "": "<span class='redtext'>*</span>";?>

        <table border="0" cellspacing="0" cellpadding="10" width="100%" id='contenttable'>
          <tr>
            <td colspan="2" style="padding-top:0px;" class="pageheader">
            	<table>
          		<tr>
            		<td valign="middle"><div class="page-title">Manage Library Stock</div></td>
            		<td valign="middle">&nbsp;</td>
                    <td valign="middle">&nbsp;</td>
            	</tr>
          </table>
			</td>
          </tr>
 <?php   
if(isset($msg)){
	echo "<tr><td colspan='4'>".format_notice($msg)."</td></tr>";
}
?>           
            
          <tr>
            <td valign="top">
        <form id="form1" name="form1" method="post" action="">
          <tr>
            <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="5" align="left">
              <td><table border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><b>Search:</b></td>
    <td>&nbsp;</td>
    <td><div id="block"><input name="search" type="text" title="Type: Title, Serial Number, ISBN Number" id="search" size="35" class="textfield" value="" onkeyup="startInstantSearch('search', 'searchby', '<?php echo base_url();?>search/load_results/type/search_stock_items_list/layer/searchresults');showPartLayer('searchresults', 'fast');" onkeypress="return handleEnter(this, event)"/></div></td>
    <td>&nbsp;<input name="searchby" type="hidden" id="searchby" value="serialnumber__isbnnumber__stocktitle" /></td>
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
           	<td class='listheader' nowrap>Serial Number</td>
			<td class='listheader' nowrap>Title</td>
			<td class='listheader' nowrap>ISBN Number</td>
			</tr>";	
	$counter = 0;	
	foreach($page_list AS $row)
	{
		#Show one row at a time
		echo "<tr  class='".(($counter%2)? '' : 'grey_list_row')."'>
		<td valign='top' nowrap>";
		
		if(1){
		echo "<a href='javascript:void(0)' onclick=\"confirmDeleteEntity('".base_url()."library/delete_stock_item/i/".encryptValue($row['itemid'])."', 'Are you sure you want to remove this item? \\nThis operation can not be undone. \\nClick OK to confirm, \\nCancel to cancel this operation and stay on this page.');\" title=\"Click to remove this item.\"><img src='".base_url()."images/delete.png' border='0'/></a>";
		}
		
		if(1){
		echo " <a href='".base_url()."library/load_stock_item_form/i/".encryptValue($row['itemid'])."/s/".encryptValue($row['stockid'])."' title=\"Click to edit this item.\"><img src='".base_url()."images/edit.png' border='0'/></a>";
		}
		
		 echo "</td>
		
		<td valign='top'>".date("j M, Y", GetTimeStamp($row['datecreated']))."</td>
		
		<td valign='top'><a href='".base_url()."library/load_stock_item_form/i/".encryptValue($row['itemid'])."/a/".encryptValue("view")."/s/".encryptValue($row['stockid'])."' class='fancybox fancybox.ajax contentlink' title=\"Click to view this item.\">".$row['serialnumber']."</a></td>
		
		<td valign='top'><a href='".base_url()."library/load_stock_form/i/".encryptValue($row['stockid'])."/a/".encryptValue("view")."' title=\"Click to view this item.\" class='fancybox fancybox.ajax contentlink'>".$row['stocktitle']."</a></td>
		
		<td valign='top'>".$row['isbnnumber']."</td>
		
		</tr>";
		
		$counter++;
	}
	
		
	echo "<tr>
	<td colspan='5' align='right'  class='layer_table_pagination'>".
	pagination($this->session->userdata('search_total_results'), $rows_per_page, $current_list_page, base_url()."library/manage_stock_items/p/%d")
	."</td>
	</tr>
	</table>";	
		
} else {
	echo format_notice("There is no at the moment.");
	
}
?></div>
              </td>
              </tr>

        </table></td>
            </tr>
          
        </table>
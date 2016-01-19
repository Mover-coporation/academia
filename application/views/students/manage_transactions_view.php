<?php
if(empty($requiredfields)){
	$requiredfields = array();
}

$indicator = (!empty($isview))? "": "<span class='redtext'>*</span>";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">

<meta name="description" content="">
<meta name="keywords" content="">
<title><?php echo SITE_TITLE." : Inventory Item";?></title>
<link rel="shortcut icon" type="image/x-icon" href="<?php echo BASE_URL;?>favicon.ico">
<?php
echo "<script src='".base_url()."js/jquery.min.js' type='text/javascript'></script>";
echo minimize_code($this, 'javascript');
echo get_AJAX_constructor(TRUE);
?>
<?php echo minimize_code($this, 'stylesheets');?>
<style type="text/css">@import "<?php echo base_url();?>css/jquery.datepick.css";</style>
<script language="JavaScript" type="text/javascript" src="<?php echo base_url();?>js/jquery.datepick.js"></script>
<script>
$(document).ready(function() {
	// date picker fields for many years
	$(".manyyearsdatefield").datepick({dateFormat: 'yyyy-mm-dd'});
});
</script>
</head>

<body>
<table border="0" cellspacing="0" width="100%" cellpadding="5" align="center">
  <tr>
    <td colspan="2" style="padding-top:10px;" align="left" bordercolor="#FFC926"><img src="<?php echo base_url();?>images/sims_login.png" /></td>
  </tr>
  <tr>
    <td colspan="2" style="padding:0;" align="left" bordercolor="#FFC926"><div class="yellow_ruler"></div></td>
  </tr>
  <tr>
    <td valign="top" style="padding:0"><div id='leftmenu' style="">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td valign="top">
          <?php $this->load->view('incl/userprofile'); ?>
          </td>
          
        </tr>
        <tr>
          <td valign="top" style="padding:0;">
		  <?php  
$this->load->view('incl/user_left_menu', array('mselected' => 'inventory' ));?>
           </td>
        </tr>
        </table>
<br />
<img src="<?php echo base_url();?>images/spacer.gif" width="255" height="1" />
	</div>
	</td>
    <td valign="top" style="padding:0">
    <div class="tabBox" id="contentdiv">
    	<div class="content">
        <table border="0" cellspacing="0" cellpadding="10" width="100%" id='contenttable'>
          <tr>
            <td colspan="2" style="padding-top:0px;" class="pageheader">
            	<table>
          		<tr>
            		<td valign="middle"><div class="page-title">Manage Inventory</div></td>
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

 </td>
            </tr>
          <tr>
            <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="5" align="left">
              <td><table border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><b>Search:</b></td>
    <td>&nbsp;</td>
    <td><input name="search" type="text" id="search" size="35" class="textfield" value="" onkeyup="startInstantSearch('search', 'searchby', '<?php echo base_url();?>search/load_results/type/search_transactions_list/layer/searchresults');showPartLayer('searchresults', 'fast');" onkeypress="return handleEnter(this, event)"/></td>
    <td>&nbsp;<input name="searchby" type="hidden" id="searchby" value="itemname__firstname__lastname" /></td>
    <td><input type="button" name="dsearch" id="dsearch" value="Search" class="bodybutton"/></td>
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
			<td class='listheader' nowrap>Quantity</td>
			<td class='listheader' nowrap>Amount</td>
			<td class='listheader' nowrap>Student Name</td>	
			</tr>";	
	$counter = 0;	
	foreach($page_list AS $row)
	{
		
		#Show one row at a time
		echo "<tr style='".get_row_color($counter, 2)."'>
		<td valign='top' nowrap>";
		
		if(1){
		echo "<a href='javascript:void(0)' onclick=\"confirmDeleteEntity('".base_url()."students/delete_transaction/i/".encryptValue($row['transactionid'])."', 'Are you sure you want to remove this transaction? \\nThis operation can not be undone. \\nClick OK to confirm, \\nCancel to cancel this operation and stay on this page.');\" title=\"Click to remove this transaction.\"><img src='".base_url()."images/delete.png' border='0'/></a>";
		}
		
		if(1){
		echo " <a href='".base_url()."students/load_transaction_form/i/".encryptValue($row['transactionid'])."/s/".encryptValue($row['studentid'])."' title=\"Click to edit this transaction.\"><img src='".base_url()."images/edit.png' border='0'/></a>";
		}
		
		 echo "</td>
		
		<td valign='top'>".$row['datecreated']."</td>		
		
		<td valign='top'><a href='".base_url()."inventory/load_item_form/i/".encryptValue($row['itemid'])."/a/".encryptValue("view")."' title=\"Click to view this item.\">".$row['itemname']."</a></td>
		
		<td valign='top'>".$row['quantity']."</td>
		
		<td valign='top'>".$row['amount']."</td>
		
		<td valign='top'><a href='".base_url()."students/load_student_form/i/".encryptValue($row['studentid'])."/a/".encryptValue("view")."' title=\"Click to view this student.\">".$row['firstname']." ".$row['lastname']."</a></td>
		
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
	echo format_notice("There are no transactions at the moment.");
	
}
?></div>
              </td>
              </tr>

        </table></td>
            </tr>
          
        </table>
      </form>
            
            </td>
            </tr>
          
        </table>
    
	</div>
	</td>
  </tr>
  <tr>
    <td colspan="2" valign="top" align="center"><?php $this->load->view('incl/footer');?></td>
  </tr>
</table>
</body>
</html>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">

<meta name="description" content="">
<meta name="keywords" content="">
<title><?php echo SITE_TITLE." : Manage Student Leave";?></title>
<link rel="shortcut icon" type="image/x-icon" href="<?php echo BASE_URL;?>favicon.ico">
<?php
echo "<script src='".base_url()."js/jquery.min.js' type='text/javascript'></script>";
echo minimize_code($this, 'javascript');
echo get_AJAX_constructor(TRUE);
?>
<?php echo minimize_code($this, 'stylesheets');?>
<style>

</style>
</head>

<body>
<table border="0" cellspacing="0" width="100%" cellpadding="5" align="center">
  <tr><?php $this->load->view('incl/header'); ?></tr>
  <tr>
    <td colspan="2" style="padding:0;" align="left" bordercolor="#FFC926"><div class="yellow_ruler"></div></td>
  </tr>
  <tr>
    <td valign="top" style="padding:0"><div id='leftmenu' style="height:auto">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td valign="top">
          <?php $this->load->view('incl/userprofile'); ?>
          </td>
          
        </tr>
        <tr>
          <td valign="top" style="padding:0;">
		  <?php  
$this->load->view('incl/user_left_menu', array('mselected' => 'students' ));?>
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
            		<td valign="middle"><div class="page-title"> <?php echo 'Leave list for '.$studentdetails['firstname'].' '.$studentdetails['lastname']; ?></div></td>
            		<td valign="middle">&nbsp;</td>
                    <td valign="middle">&nbsp;</td>
            	</tr>
          </table>
			</td>
          </tr>
          <tr>
            <td colspan="2" style="padding-top:0px;" class="pageheader">
            	<div class="grey_ruler"></div>
			</td>
          </tr>
            
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
			<td class='listheader'>&nbsp;</td>
           	<td class='listheader' nowrap>Start date</td>
			<td class='listheader' nowrap>Expected return date</td>
           	<td class='listheader' nowrap>Days left</td>
			<td class='listheader' nowrap>Issued by</td>
			<td class='listheader' nowrap>Return date</td>
			<td class='listheader' nowrap>Received by</td>
			<td class='listheader' nowrap>Date added</td>
			</tr>";	
	$counter = 0;	
	foreach($page_list AS $row)
	{
		#Get author names
		$author = get_school_user_fullname($this, $row['author']);
		$author = $author['firstname'].' '.$author['lastname'];
		
		#Get received by name
		if(empty($row['receivedby']))
		{
			$receivedby = $returndate = '<i>N/A</i>';			
		}
		else
		{
			$receivedby = get_school_user_fullname($this, $row['receivedby']);
			$receivedby = $receivedby['firstname'].' '.$receivedby['lastname'];
			$returndate = date("j M, Y", GetTimeStamp($row['returndate']));
		}		
		
		#Show one row at a time
		echo "<tr style='".get_row_color($counter, 2)."'>
		<td valign='top' nowrap>";
		
			#if(check_user_access($this,'delete_deal')){
				echo "<a href='javascript:void(0)' onclick=\"confirmDeleteEntity('".base_url()."terms/delete_term/i/".encryptValue($row['id'])."', 'Are you sure you want to remove this term? \\nThis operation can not be undone. \\nClick OK to confirm, \\nCancel to cancel this operation and stay on this page.');\" title=\"Click to remove this term.\"><img src='".base_url()."images/delete.png' border='0'/></a>";
			#}
		
			#if(check_user_access($this,'update_deals')){
				echo " &nbsp;&nbsp; <a href='".base_url()."terms/load_term_form/i/".encryptValue($row['id'])."' title=\"Click to edit this term's details.\"><img src='".base_url()."images/edit.png' border='0'/></a>";
			#}
		
		
		 echo "</td>		
				<td valign='top'>".date("j M, Y", GetTimeStamp($row['startdate']))."</td>		
				<td valign='top'>".date("j M, Y", GetTimeStamp($row['expectedreturndate']))."</td>				
				<td valign='top' nowrap>".get_date_diff(date('m/d/Y h:i:s a', time()),  $row['expectedreturndate'], 'days')."</td>		
				<td valign='top'>".$author."</td>
				<td valign='top'>".$returndate."</td>
				<td valign='top'>".$receivedby."</td>
				<td valign='top'>".date("j M, Y", GetTimeStamp($row['dateadded']))."</td>	
			</tr>";
		
		$counter++;
	}
	
		
	echo "<tr>
	<td colspan='5' align='right'  class='layer_table_pagination'>".
	pagination($this->session->userdata('search_total_results'), $rows_per_page, $current_list_page, base_url()."deal/manage_deals/p/%d")
	."</td>
	</tr>
	</table>";	
			}
			else
			{
				echo "<div>No terms have been added.</div";
			}
		
		?>
            
            
            </td>
            </tr>
          
        </table>
    </div>
	</div>
	</td>
  </tr>
  <tr>
    <td colspan="2" valign="top" align="center"><?php $this->load->view('incl/footer');?></td>
  </tr>
</table>
</body>
</html>

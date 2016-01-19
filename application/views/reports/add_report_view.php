<?php
if(empty($requiredfields)){
	$requiredfields = array();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">

<meta name="description" content="NYPPEX Transfer Administration is one of the world's leading private equity secondary agents for private funds and companies">
<meta name="keywords" content="NYPPEX, private equity, secondary market, private companies">
<title><?php echo SITE_TITLE.": ";

if(!empty($i)){
	echo "Update ";
} else {
	echo "Add New ";
}
echo " Report";
?></title>
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
	$(".manyyearsdatefield").datepick({dateFormat: 'mm/dd/yyyy'});
});
</script>
</head>

<body>
<table border="0" cellspacing="0" cellpadding="5" align="center">
  <tr>
    <td colspan="2" style="padding-top:10px;">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><img src="<?php echo base_url();?>images/spacer.gif" width="320" height="1" /></td>
  </tr>
  <tr>
    <td valign="top"><div id='leftmenu' class="lightgreybg shadow" style="height:272px; text-align:left;">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td valign="top" style="padding:20px; padding-right:20px;"><img src="<?php echo base_url();?>images/logo.png" /></td>
          
        </tr>
        <tr>
          <td valign="top">
<?php  
$this->load->view('incl/leftmenu', array('subsection'=>'add_a_new_report', 'section'=>'reports'));?>
          
          </td>
        </tr>
        </table>
<br />
<img src="<?php echo base_url();?>images/spacer.gif" width="255" height="1" /></div></td>
    <td valign="top"><div class="tabBox" id="contentdiv">
    <?php $this->load->view('incl/admin_top_menu', array('mselected'=>'reports'));?>
    <div class="content">
        <form id="form1" enctype="multipart/form-data" name="form1" method="post" action="<?php echo base_url()."reports/add_report";
		if(!empty($i))
		{
			echo "/i/".$i;
		}
		?>">
        <table border="0" cellspacing="0" cellpadding="10" width="100%" id='contenttable'>
          <tr>
            <td colspan="2" style="padding-top:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="pageheader"><a href="<?php echo base_url()."reports/manage_reports"; ?>" class="pageheader"/>Manage Reports</a> &raquo; <?php 
		if(!empty($i) && empty($isview)){
			echo "Update ";
			
		} else {
			echo "Add New ";			
			
		}
		$code = 'add_new_report';
		?>Report</td>
    <td align="right"><a href="javascript:void(0)" onclick="updateFieldLayer('<?php echo base_url();?>help/view_help_topic/i/<?php echo encryptValue($code);?>', '', '', '_', '')"><img src="<?php echo base_url();?>images/help_icon.png" border="0" /></a></td>
  </tr>
</table>
 </td>
            </tr>

<?php 
if(!empty($msg))
{
	echo "<tr><td>".format_notice($msg)."</td></tr>";
}
?>

          <tr>
            <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="5">
              <tr>
                <td width="1%" nowrap class="label">Report Name :<span class="redtext">*</span></td>
                <td width="99%" nowrap>
                <?php  
				echo get_required_field_wrap($requiredfields, 'reportname');?>                
                <input type="text" name="reportname" id="reportname" size="30" class="textfield" value="<?php if(!empty($formdata['reportname'])) echo $formdata['reportname'];?>" tabindex="1" />
                <?php echo get_required_field_wrap($requiredfields, 'reportname', 'end');?>
                </td>
              </tr>
              <tr>
                <td class="label" nowrap>Report File :<span class="redtext">*</span></td>
                <td nowrap><table border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>
    <?php echo get_required_field_wrap($requiredfields, 'fileurl');?>
    <input type="file" name="fileurl" id="fileurl" class="textfield" style="height:35px;" tabindex="2" />
                <?php echo get_required_field_wrap($requiredfields, 'fileurl','end');?>
                </td>
    <td style="padding-left:10px;"></td>
  </tr>
</table>

                </td>
                </tr>
              
              <tr>
                <td nowrap>&nbsp;</td>
                <td nowrap>&nbsp;</td>
              </tr>
              <tr>
                <td nowrap>&nbsp;</td>
                <td nowrap><input type="submit" name="savereport" id="savereport" value="Save" class="button"/></td>
              </tr>
            </table></td>
            </tr>
          
        </table>
      </form>
    </div>
</div></td>
  </tr>
  <tr>
    <td colspan="2" valign="top" align="center"><?php $this->load->view('incl/footer');?></td>
  </tr>
</table>
</body>
</html>

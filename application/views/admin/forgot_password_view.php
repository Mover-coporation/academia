<?php
if(empty($requiredfields)){
	$requiredfields = array();
}?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">

<meta name="description" content="">
<meta name="keywords" content="">
<title><?php echo SITE_TITLE.": Forgot Password";?></title>
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

          
          </td>
        </tr>
        </table>
<br />
<img src="<?php echo base_url();?>images/spacer.gif" width="255" height="1" /></div></td>
    <td valign="top"><div class="tabBox" id="contentdiv">
    <div class="content" style="min-height:312px;">
        <form id="form1" name="form1" method="post" action="<?php echo base_url();?>admin/forgot_password">
        <table border="0" width="100%" cellspacing="0" cellpadding="5" id='contenttable'>
          <tr>
            <td colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td class="pageheader">Forgot Password</td>
                <td align="right">&nbsp;</td>
                </tr>
            </table></td>
            <td width="1%" rowspan="5" style="padding:0px;"><img src="<?php echo base_url();?>images/spacer.gif" width="1" height="260" /></td>
          </tr>
          <?php
		    if(!empty($msg)){
			  echo "<tr><td colspan='2'>".format_notice($msg)."</td></tr>";
			}
		    ?>
          <tr>
            <td width="1%" nowrap="nowrap" class="label" style="text-align:left;">Enter Your Email:</td>
            <td width="99%"><?php echo get_required_field_wrap($requiredfields, 'emailaddress', 'start', 'Wrong email format.');?>
                    <input type="text" name="emailaddress" id="emailaddress" class="textfield" size="45" value=""/>
                    <?php echo get_required_field_wrap($requiredfields, 'emailaddress', 'end');?></td>
            </tr>
          <tr>
            <td>&nbsp;</td>
            <td><input type="submit" name="sendpassword" id="sendpassword" value="Send New Password &raquo; " class="button"/>
</td>
            </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
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
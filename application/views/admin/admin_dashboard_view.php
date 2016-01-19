<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">

<meta name="description" content="">
<meta name="keywords" content="">
<title><?php echo SITE_TITLE." : Admin Dashboard";?></title>
<link rel="shortcut icon" type="image/x-icon" href="<?php echo BASE_URL;?>favicon.ico">
<?php
echo "<script src='".base_url()."js/jquery.min.js' type='text/javascript'></script>";
echo minimize_code($this, 'javascript');
echo get_AJAX_constructor(TRUE);
?>
<?php echo minimize_code($this, 'stylesheets');?>
<script type="text/javascript">	 
   $(document).ready(initClientDashboard);
</script>
<style>
.fancybox-opened .fancybox-title {
    visibility: hidden;
	display:none;
}
</style>
</head>

<body>
<table border="0" cellspacing="0" width="100%" cellpadding="5" align="center">
	<tr bgcolor="#F8F8F1"><?php $this->load->view('incl/header'); ?></tr>
  	<tr>
    <td colspan="3" style="padding:0;" align="left"><div class="yellow_ruler"></div></td>
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
          <td>
          	<div id="selected_menu" style="margin-left:50px; padding:2em 0; font-weight:bold">
            	<table id="table_school_settings" style="position:relative; left:0px" width="100%">
					<tr>
					<td width="50"><img src="<?php echo base_url().'images/school_settings.jpg' ?>" /></td>
                    <td class="menu_vertical_separator"><img src="<?php echo base_url().'images/menu_vertical_separator.jpg'; ?>" /></td>					
					<td>DASHBOARD</td>
                    <td align="right"><img src="<?php echo base_url().'images/red_arrow.jpg' ?>" /></td>
					</tr>
    			 </table>
            </div>
          </td>
        </tr>
        <tr>
          <td valign="top" style="padding:0;">
		  <?php $this->load->view('incl/admin_leftmenu', array('mselected'=>''));?>
          </td>
        </tr>
        </table>
	<br />
	<img src="<?php echo base_url();?>images/spacer.gif" width="255" height="1" />
	</div>
	</td>
    <td valign="top" style="padding:0">
    <div class="tabBox">
    	<div class="content" id="contentdiv"></div>
	</div>
	</td>
  </tr>
  <tr>
    <td colspan="2" valign="top" align="center"><?php $this->load->view('incl/footer');?></td>
  </tr>
</table>
</body>
</html>

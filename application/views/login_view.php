<?php

if(empty($requiredfields)){

	$requiredfields = array();

}?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<META HTTP-EQUIV="Pragma" CONTENT="no-cache">



<meta name="description" content="School Management Solutions">

<meta name="keywords" content="Academia, Academy, School, Curriculum">

<title><?php echo SITE_TITLE." : ".SITE_SLOGAN;?> - Login</title>

<link rel="shortcut icon" type="image/x-icon" href="<?php echo BASE_URL;?>favicon.ico">

<?php

 
echo "<script src='".base_url()."js/jquery.min.js' type='text/javascript'></script>";

echo minimize_code($this, 'javascript');

echo get_AJAX_constructor(TRUE);

?>

<?php echo minimize_code($this, 'stylesheets');?>

</head>



<body>

<table border="0" cellspacing="0" cellpadding="5" align="center">

  <tr>

    <td colspan="2" style="padding-top:20px;">&nbsp;</td>

  </tr>

  <tr>

    

    <td valign="top" align="center">

        <form id="form1" name="form1" method="post" action="<?php echo base_url();?>admin/login">

        <table border="0" width="469" cellspacing="0" cellpadding="10" id='contenttable'>

          <tr>

          <td align="center" colspan="2"><img src="<?php echo base_url();?>images/sims_login.png" /><br><br></td>

          </tr>

            

            <tr>

          <td height="28" ><fieldset class="coolfieldset" id="menu_container"><legend align="center">SIGN IN</legend><table width="100%" border="0" cellspacing="10">

            <tr>

              <td align="center">

              	<?php  echo get_required_field_wrap($requiredfields, 'acadusername');?><input type="text" name="acadusername" id="acadusername" size="45" placeholder="Username" class="textfield" style="width:220px;" value="<?php 

				if(!empty($formdata['acadusername'])){ echo $formdata['acadusername'];}

				?>" tabindex="1"/><?php echo get_required_field_wrap($requiredfields, 'acadusername', 'end');?>

              </td>

            </tr>

            <tr>

              <td align="center">

			  <?php echo get_required_field_wrap($requiredfields, 'acadpassword');?><input type="password" name="acadpassword" id="acadpassword" size="45" placeholder="Password" class="textfield" style="width:220px;" value="" tabindex="2"/><?php echo get_required_field_wrap($requiredfields, 'acadpassword', 'end');?>

              </td>

              </tr>

            <tr>

              <td align="center">

                <table width="58%" border="0">

                  <tr>

                    <td width="10%"><input type="hidden" name="login" value="login" />

                    <input style="border:none" value="login_btn" name="login_btn" type="image" src="<?php echo base_url();?>images/login_button.png" /></td>

                    <td width="46%"></td>

                    <td width="5%"></td>

                    <td width="39%" nowrap="nowrap"><a href="<?php echo base_url();?>admin/forgot_password" class="login">Forgot Password?</a></td>

                  </tr>

                </table>

           </td>

              </tr>

              <tr>

              	<td colspan="" height="50">&nbsp;

                	<?php if(!empty($msg)) echo format_notice($msg); ?>

                </td>

              </tr>

            

          </table>   

          </fieldset>      </td>

          </tr>

           

        </table>

      </form>

      </td>

  </tr>

  <tr>

    <td colspan="2" valign="top" align="center"><?php $this->load->view('incl/footer', array('ignore_resize'=>'Y'));?></td>

  </tr>

</table>

</body>

</html>


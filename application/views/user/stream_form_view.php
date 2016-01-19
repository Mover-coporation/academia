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
<title><?php echo SITE_TITLE." : Stream Data";?></title>
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
  <tr><?php $this->load->view('incl/header'); ?></tr>
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
$this->load->view('incl/admin_leftmenu', array('mselected' => 'schools' ));?>
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
            		<td valign="middle"><div class="page-title">New Student Details</div></td>
            		<td valign="middle"><?php echo "<div class='page-section'>(".$schooldetails['schoolname']." )</div>"; ?></td>
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
            <form id="form1" name="form1" method="post" action="<?php echo base_url();?>admin/save_school_user<?php 
		if(!empty($i))
		{
			echo "/i/".$i;
		}
		?>" >
            
            <table width="100" border="0" cellspacing="0" cellpadding="8">
				  <tr>
                    <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">First Name :<?php echo $indicator;?></td>
                    <td class="field" nowrap>
                      <?php  
			if(!empty($isview))
			{
				echo "<span class='viewtext'>".$userdetails['firstname']."</span>";
			}else{
					echo get_required_field_wrap($requiredfields, 'firstname');
					?>
                      <input type="text" name="firstname" id="firstname" class="textfield" size="30" value="<?php 
				  if(!empty($userdetails['firstname'])){
				 	 echo $userdetails['firstname'];
				  }?>"/>
                      <?php  echo get_required_field_wrap($requiredfields, 'firstname', 'end');
			}
				  ?>
                    </td>
                    <td rowspan="6" nowrap class="field" valign="top">
                    	<table>
                        <tr>
                          <td colspan="2" class="label">Guardian Details</td></tr>
                        <tr>
                          <td class="label" style="padding-top:13px">Gender : </td><td>
            <?php if(!empty($isview))
			{
				echo "<span class='viewtext'>".$userdetails['username']."</span>";
			}
			else
			{
				 echo get_required_field_wrap($requiredfields, 'username');?>
                        <input type="text" name="username" id="fromdate" class="textfield" size="30" value="<?php 
				  if(!empty($userdetails['username'])){
				 	 echo $userdetails['username'];
				  }?>"/>
                  <?php  echo get_required_field_wrap($requiredfields, 'username', 'end');
			}
				  ?>
                  </td></tr>
                        <tr>
                          <td class="label" style="padding-top:13px">Relationship : </td><td>
                        <?php if(empty($isview))
			{
				?>
                        <input type="password" name="password" id="password" class="textfield" size="30"/>
                  <?php } ?>
                  </td></tr>
                        <tr>
                          <td class="label" style="padding-top:13px">Occupation : </td><td>
                        <?php if(empty($isview))
			{
				?>
                        <input type="password" name="repeatpassword" id="repeatpassword" class="textfield" size="30"/>
                  <?php } ?>
                  </td></tr>
                        <tr>
                          <td class="label" style="padding-top:13px">Phone No : </td><td>
                        <?php if(empty($isview))
			{
				?>
                        <input type="password" name="repeatpassword" id="repeatpassword" class="textfield" size="30"/>
                  <?php } ?>
                  </td></tr>
                        <tr>
                          <td class="label" style="padding-top:13px">Address : </td><td>
                        <?php if(empty($isview))
			{
				?>
                        <input type="password" name="repeatpassword" id="repeatpassword" class="textfield" size="30"/>
                  <?php } ?>
                  </td></tr>
                        </table>
                    </td>
                  </tr>
                  <tr>
                    <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">Middle Name :</td>
                    <td class="field" nowrap>
                      <?php if(!empty($isview))
			{
				echo "<span class='viewtext'>".$userdetails['middlename']."</span>";
			}else{
                    ?>
                      <input type="text" name="middlename" id="middlename" class="textfield" size="30" value="<?php 
				  if(!empty($userdetails['middlename'])){
				 	 echo $userdetails['middlename'];
				  }?>"/>
                      <?php } ?>
                    </td>
                  </tr>
                  <tr>
                    <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">Last Name :<?php echo $indicator;?></td>
                    <td class="field" nowrap>
                      <?php  
			if(!empty($isview))
			{
				echo "<span class='viewtext'>".$userdetails['lastname']."</span>";
			}else{
					echo get_required_field_wrap($requiredfields, 'lastname');
					?>
                      <input type="text" name="lastname" id="lastname" class="textfield" size="30" value="<?php 
				  if(!empty($userdetails['lastname'])){
				 	 echo $userdetails['lastname'];
				  }?>"/>
                      <?php  echo get_required_field_wrap($requiredfields, 'lastname', 'end');
			}
				  ?>
                    </td>
                  </tr>
                  <tr>
                    <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">Date of Birth :<?php echo $indicator;?></td>
                    <td class="field" nowrap>
                      <?php  
			if(!empty($isview))
			{
				echo "<span class='viewtext'>".$userdetails['lastname']."</span>";
			}else{
					echo get_required_field_wrap($requiredfields, 'lastname');
					?>
                      <input type="text" name="lastname" id="lastname" class="textfield" size="30" value="<?php 
				  if(!empty($userdetails['lastname'])){
				 	 echo $userdetails['lastname'];
				  }?>"/>
                      <?php  echo get_required_field_wrap($requiredfields, 'lastname', 'end');
			}
				  ?>
                    </td>
                  </tr>
                  <tr>
                    <td nowrap="nowrap" class="label">Gender :<?php echo $indicator;?></td>
                    <td class="field" nowrap>
                       <?php  
			if(!empty($isview))
			{
				echo "<span class='viewtext'>".$user_group_info['groupname']."</span>";
			}else{
						?>
                    <select name="gender" id="gender"  class="selectfield"> <option value="Male">Male</option>
               <option value="Female">Female</option>
                    </select>
                    <?php
						}
					?>
                    </td>
                  </tr>
                  <tr>
                    <td nowrap="nowrap" class="label">Term of Admission :<?php echo $indicator;?> </td>
                    <td class="field" nowrap>
                      <?php  
					 if(!empty($isview))
			{
				echo "<span class='viewtext'>".$schooldetails['emailaddress']."</span><input type='hidden' name='emailaddress' id='emailaddress' value='".$schooldetails['emailaddress']."' />";
			}else{
					 echo get_required_field_wrap($requiredfields, 'emailaddress');?>
                      <input type="text" name="emailaddress" id="emailaddress" class="textfield" size="30" value="<?php 
				  if(!empty($userdetails['emailaddress'])){
				 	 echo $userdetails['emailaddress'];
				  }?>"/>
                      <?php  echo get_required_field_wrap($requiredfields, 'emailaddress', 'end');
			}
				  ?>
                    </td>
                  </tr>
                  
                  <tr>
                    <td nowrap="nowrap" class="label"> Class of Admission :<?php echo $indicator;?> </td>
                    <td class="field" nowrap>
                      <?php  
					 if(!empty($isview))
			{
				echo "<span class='viewtext'>".$userdetails['address']."</span><input type='hidden' name='address' id='address' value='".$userdetails['address']."' />";
			}else{
					 echo get_required_field_wrap($requiredfields, 'emailaddress');?>
                      <input type="text" name="address" id="address" class="textfield" size="30" value="<?php 
				  if(!empty($userdetails['address'])){
				 	 echo $userdetails['address'];
				  }?>"/>
                      <?php  echo get_required_field_wrap($requiredfields, 'address', 'end');
			}
				  ?>
                    </td>
                  </tr>
                  
                  <tr>
                    <td nowrap="nowrap" class="label">Photo :<?php echo $indicator;?> </td>
                    <td class="field" nowrap>
                      <?php  
					 if(!empty($isview))
			{
				echo "<span class='viewtext'>".$userdetails['telephone']."</span><input type='hidden' name='telephone' id='telephone' value='".$userdetails['telephone']."' />";
			}else{
					 echo get_required_field_wrap($requiredfields, 'telephone');?>
                      <input type="file" name="telephone" id="telephone" class="textfield" size="30" value="<?php 
				  if(!empty($userdetails['telephone'])){
				 	 echo $userdetails['telephone'];
				  }?>"/>
                      <?php  echo get_required_field_wrap($requiredfields, 'telephone', 'end');
			}
				  ?>
                  <input name="usertype" type="hidden" id="usertype" value="SCHOOL"/>
                    </td>
                  </tr>
                  <tr>
                    <td nowrap="nowrap">&nbsp;</td>
                    <td>&nbsp;<?php if(!empty($i) || !empty($editid)){?><input name="editid" type="hidden" id="editid" value="<?php 
					if(!empty($i)){
						echo decryptValue($i);
					} else {
						echo $editid;
					}?>"/><?php }
					
					
					?></td>
                    <td>&nbsp;</td>
                  </tr>
                  <?php  if(empty($isview)){ ?>
				  <tr>
                    <td>&nbsp;</td>
                    <td><input type="submit" name="save" id="login" value="Save" class="button"/></td>
                    <td>&nbsp;</td>
                  </tr>
                  <?php } ?>
                </table>
            
            </form>
            
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

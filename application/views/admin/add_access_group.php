<?php
if(empty($requiredfields)){
	$requiredfields = array();
}?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">

<meta name="description" content="NYPPEX Transfer Administration is one of the world's leading private equity secondary agents for private funds and companies">
<meta name="keywords" content="NYPPEX, private equity, secondary market, private companies">
<title><?php echo SITE_TITLE.": Add User Group";?></title>
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
<?php  
$this->load->view('incl/leftmenu', array('subsection'=>'add_access_group', 'section'=>'users'));?>
          
          </td>
        </tr>
        </table>
<br />
<img src="<?php echo base_url();?>images/spacer.gif" width="255" height="1" /></div></td>
    <td valign="top"><div class="tabBox" id="contentdiv">
    <?php $this->load->view('incl/admin_top_menu', array('mselected'=>'users'));?>
    <div class="content">
        <form id="form1" name="form1" method="post" action="<?php echo base_url();?>admin/save_access_group">
        <table border="0" cellspacing="0" cellpadding="10" width="100%" id='contenttable'>
         
         <tr>
            <td colspan="2" style="padding-top:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="pageheader" nowrap><a href="<?php echo base_url()."admin/manage_access_groups"; ?>" class="pageheader"/>Access Groups</a> &raquo; <?php 
		if(!empty($i)){
			echo "Update ";
			$code = 'update_access_group';
			
		} else if(!empty($isview)){
			echo "View ";
			$code = 'view_access_group';
			
		} else {
			echo "Add New ";
			$code = 'add_new_access_group';
			
		}?> Access Group</td>
    <td align="right"><a href="javascript:void(0)" onclick="updateFieldLayer('<?php echo base_url();?>help/view_help_topic/i/<?php echo encryptValue($code);?>', '', '', '_', '')"><img src="<?php echo base_url();?>images/help_icon.png" border="0" /></a></td>
  </tr>
</table>
 </td>
</tr>   
            
            
            <?php   
				if(isset($msg)){
			  	echo "<tr><td height='10'></td>".
						"<tr><td>".format_notice($msg)."</td></tr>";
			  	}
				?>
          <tr>
            <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="5">
              <tr>
                <td colspan="2" nowrap>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">			  
              <tr>
                <td><table width="100" border="0" cellspacing="0" cellpadding="5">
				  <tr>
                    <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">Group Name: </td>
                    <td class="field" nowrap>
                    <?php  
					
					if(!empty($isview))
			{
				echo "<span class='viewtext'>".$groupdetails['groupname']."</span>";
			}
			else
			{
					echo get_required_field_wrap($requiredfields, 'groupname');?>
                    <input type="text" name="groupname" id="groupname" class="textfield" size="30" value="<?php 
				  if(!empty($groupdetails['groupname'])){
				 	 echo $groupdetails['groupname'];
				  }?>"/>
                  <?php  echo get_required_field_wrap($requiredfields, 'groupname', 'end');
			}
				  ?>
                    </td>
                  </tr>
                  
                  <tr>
                    <td nowrap="nowrap" class="label">&nbsp;</td>
                    <td class="field">&nbsp;</td>
                  </tr>
                  
                  <tr>
                    <td nowrap="nowrap" class="label">Is Admin: </td>
                    <td class="field">
                    <?php  
					
					if(!empty($isview))
					{
						echo "<span class='viewtext'>".		((!empty($groupdetails['isadmin']) && $groupdetails['isadmin'] == 'Y')? "Yes" : "No") ."</span>";
					}
					else
					{
					?>
                    <table border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td><input name="isadmin_select" id='isadmin_y' type="radio" value="Y" onclick="passFormValue('isadmin_y', 'isadmin', 'radio')" <?php 
				  if(!empty($groupdetails['isadmin']) && $groupdetails['isadmin'] == 'Y')
				 	 echo "checked=\"checked\"";
				  ?>/></td>
                          <td>Yes</td>
                          <td>&nbsp;</td>
                          <td><input name="isadmin_select" id='isadmin_n' type="radio" value="N" onclick="passFormValue('isadmin_n', 'isadmin', 'radio')" <?php 
				  if((!empty($groupdetails['isadmin']) && $groupdetails['isadmin'] == 'N') || empty($groupdetails['isadmin'])) echo " checked";
				  ?>/></td>
                          <td>No</td>
                          <td><input name="isadmin" type="hidden" id="isadmin" value="<?php 
				  if(!empty($groupdetails['isadmin'])){
				 	 echo $groupdetails['isadmin'];
				  } else {
				  	 echo 'N';
				  }?>"/></td>
                        </tr>
                      </table>
                    <?php } ?>
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
                  </tr>
                  
				  <tr>
                    <td>&nbsp;</td>
                    <td>
                    <?php 
					if(empty($isview)){
					?>
                    <input type="submit" name="save" id="save" value="Save" class="button"/>
                        <?php } ?>
                     
                     </td>
                  </tr>
				  
                </table></td>
              </tr>
			  <tr>
			  	<td>&nbsp;</td>
              </tr>
            </table>
                </td>
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
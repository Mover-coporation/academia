<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">

<meta name="description" content="NYPPEX Transfer Administration is one of the world's leading private equity secondary agents for private funds and companies">
<meta name="keywords" content="NYPPEX, private equity, secondary market, private companies">
<title><?php echo SITE_TITLE.": Access Group Permissions";?></title>
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
          <td valign="top"><?php  
$this->load->view('incl/leftmenu', array('subsection'=>'manage_access_groups', 'section'=>'users'));?></td>
        </tr>
        </table>
<br />
<img src="<?php echo base_url();?>images/spacer.gif" width="255" height="1" /></div></td>
    <td valign="top"><div class="tabBox" id="contentdiv">
    <?php $this->load->view('incl/admin_top_menu', array('mselected'=>'users'));?>
    <div class="content">
        <form id="form1" name="form1" method="post" action="<?php echo base_url();?>admin/update_permissions">
        <table border="0" cellspacing="0" cellpadding="10" width="100%" id='contenttable'>
          
          <tr>
            <td colspan="2" style="padding-top:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="pageheader" nowrap><a href="<?php echo base_url()."admin/manage_access_groups"; ?>" class="pageheader"/>Access Groups</a> &raquo; Manage Group Permissions</td>
    <td align="right"><a href="javascript:void(0)" onclick="updateFieldLayer('<?php echo base_url();?>help/view_help_topic/i/<?php echo encryptValue('manage_access_group_permissions');?>', '', '', '_', '')"><img src="<?php echo base_url();?>images/help_icon.png" border="0" /></a></td>
  </tr>
</table>
 </td>
</tr>
            
          <tr>
            <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:13px;">
                  <?php   
				if(!empty($msg)){
			  	echo "<tr><td>".format_notice($msg)."</td></tr>";
			  	}
				
				if(!empty($all_permissions)){
				?>
				<tr>
						<td style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td width="99%" style="padding:5px;
	font-weight:bold;	 
	background-color: #000000;
	text-align:left;
	color: #FFFFFF;padding-left:10px; font-size:13px;">Updating permissions for access group <?php echo $groupdetails['groupname'];?></td>
                        </tr>
                    </table>						</td>
						</tr>
                <tr>
                    <td style="padding-top: 0px;
	padding-bottom: 5px;
	text-align: left;font-size: 13px;">
					
					  <table width="100%" border="0" cellspacing="0" cellpadding="3">
                      	
					    <tr>
                          <td colspan="2" style="background-color:#E6E6E6;
	font-style:italic;font-size: 13px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
						  <tr>
                          <td width="1%" style="padding-right:5px"><input name="selectall" id="selectall"  type="checkbox" onclick="selectCheckBoxList('selectall', '<?php echo implode(",", $all_permissions_list);?>', 'permission_')" value=""/></td>
                          <td style="background-color:#E6E6E6;
	font-style:italic;font-size: 13px;" width="99%"><b>Select All Permissions</b></td>
                        </tr>
						</table>
						</td></tr>
						
						<tr>
                          <td colspan="2" height="10"></td></tr>
						<tr>
                          <td colspan="2">
                <?php /*$peek_counter = 0;
				foreach($all_permissions AS $row){
					if(($userdetails['isadmin'] == 'Y' && $row['accessfor'] == 'admin') || ($userdetails['isadmin'] == 'N' && $row['accessfor'] == ''))
					{
						$peek_counter++;
					}
				}
				*/
				$counter = 0;
				$oldsection = "";
					  
				foreach($all_permissions AS $row){
					  
					  $section = $row['section'];
					  
					  if($section != $oldsection){
					  	if($oldsection != ''){
							echo "</table></div><br>";
						}
						
						 echo "<a href=\"javascript:showHideLayer('".$row['section']."_div')\" class='bluelink'>".ucfirst($row['section'])."</a><hr><div id='".$row['section']."_div' style='display:none'>
						 
						 <table width='100%' border='0' cellspacing='0' cellpadding='3'>";
					  }
					  
					  
					  echo "<tr style='".get_row_color($counter, 2)."'>
                          <td style='font-size: 13px;' width='1%' nowrap><input name='permissions[]' id='permission_".$row['id']."' onClick=\"selectCheckBoxListWithUncheck('permission_".$row['id']."', '".get_related_permissions($this, $row['id'])."', '".get_related_permissions($this, $row['id'],'uncheck')."', 'permission_')\" type='checkbox' value='".$row['id']."'";
						if(in_array($row['id'], $permissions_list)){ 
						echo " checked";
						}
					  echo "/></td>
                          <td style='font-size: 13px;' width='99%' nowrap>".$row['permission']."</td>
                        </tr>";
					  
					  	if($counter == (count($all_permissions) - 1)){
					  		echo "</table></div>"; 	
						}
						
						$oldsection = $row['section'];
						$counter++;
				
			} ?>
					  </td></tr>
                      </table>					</td>
                  </tr>
				 <?php
					}
					else 
					{
						echo 'There are no permissions accessed by this user group.';
					}
					?>
				  
				  
				  
				  
                  
                  <tr>
                    <td nowrap="nowrap" style="padding-left:15px; padding-top:10px"><table border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td colspan="2" nowrap><input name="editid" type="hidden" value="<?php echo decryptValue($i);?>" />&nbsp;</td>
                        <td><input type="submit" name="updatepermissions" id="updatepermissions" value="Save Permissions" class="button"/></td>
                      </tr>
                    </table>                      </td>
                  </tr>
                  <tr>
                    <td nowrap="nowrap">&nbsp;</td>
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

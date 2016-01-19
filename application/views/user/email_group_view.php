<?php
if(empty($requiredfields)){
	$requiredfields = array();
}

$indicator = (!empty($isview))? "": "<span class='redtext'>*</span>";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">

<meta name="description" content="NYPPEX Transfer Administration is one of the world's leading private equity secondary agents for private funds and companies">
<meta name="keywords" content="NYPPEX, private equity, secondary market, private companies">
<title><?php echo SITE_TITLE.": ";

if(!empty($i) && empty($isview)){
	echo "Update ";
} else if(!empty($isview)){
	echo "View ";
} else {
	echo "Add New ";
}
echo " Email Group";
?></title>
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
$this->load->view('incl/leftmenu', array('subsection'=>'add_email_group', 'section'=>'users'));?>
          
          </td>
        </tr>
        </table>
<br />
<img src="<?php echo base_url();?>images/spacer.gif" width="255" height="1" /></div></td>
    <td valign="top"><div class="tabBox" id="contentdiv">
    <?php $this->load->view('incl/admin_top_menu', array('mselected'=>'users'));?>
    <div class="content">
        <form id="form1" name="form1" method="post" action="<?php echo base_url()."user/add_email_group";
		if(!empty($i))
		{
			echo "/i/".$i;
		}
		?>">
        <table border="0" cellspacing="0" cellpadding="10" width="100%" id='contenttable'>
          <tr>
            <td colspan="2" style="padding-top:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="pageheader"><a href="<?php echo base_url()."user/manage_email_groups"; ?>" class="pageheader"/>Email Groups</a> &raquo; <?php 
		if(!empty($i) && empty($isview)){
			echo "Update ";
			$code = 'update_email_group';
			
		} else if(!empty($isview)){
			echo "View ";
			$code = 'view_email_group';
			
		} else {
			echo "Add New ";
			$code = 'add_new_email_group';
			
		}?>Email Group</td>
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
                <td class="label" nowrap>Group Name:<?php echo $indicator;?></td>
                <td nowrap><?php if(!empty($isview))
			{
				echo "<span class='viewtext'>".$formdata['groupname']."</span>";
			}
			else
			{
				 echo get_required_field_wrap($requiredfields, 'groupname');?><input type="text" name="groupname" id="groupname" size="40" class="textfield" value="<?php 
				if(!empty($formdata['groupname'])){ echo $formdata['groupname'];}
				?>" tabindex="2" onkeyup="startInstantSearch('groupname', 'searchby', '<?php echo base_url();?>search/load_results/type/groupname/layer/groupname_searchresults');ShowContent('groupname_searchresults','');"/><input name="searchby" type="hidden" id="searchby" value="groupname" /><div id='groupname_searchresults' style='max-height: 380px; overflow:hidden; position:absolute;border: 1px solid #98CBFF; background-color: #F7F7F7; display:none;'></div><?php echo get_required_field_wrap($requiredfields, 'groupname', 'end');
				
			}?></td>
              </tr>
              <tr>
                <td width="1%" class="label"  valign="top" style='padding-top:15px;' nowrap>Email List:<?php echo $indicator;?></td>
                <td width="99%" style="padding:0px;" nowrap><?php
                
				echo "<table border='0' cellspacing='0' cellpadding='5'>
					<tr><td><div id='addtogroup'></div></td></tr>
					<tr><td>
					
					<table border='0' cellspacing='0' cellpadding='5'>
					<tr><td class='lightgreybg'><b>Users in this Group:</b></td>
					<td align='right' class='lightgreybg'><a href='javascript:void(0)' onClick=\"updateFieldLayer('".base_url()."user/add_user_to_group/layer/addtogroup";
				
				#If the user is editing
				if(!empty($formdata['groupname']))
				{
					echo "/gn/".encryptValue($formdata['groupname'])."',''";
				}
				#if the user is adding a new group	
				else
				{
					echo "','groupname'";
				}
				
				echo ",'','addtogroup','Enter a group name.');\" title=\"Click to add a user to the email list.\"><img src='".base_url()."images/add_icon.png' border='0'/></a></td></tr>
					
					<tr><td colspan='2' style='padding:0px;'>
					<div id='emailgrouplist'>";
				
				
				$userlist = array();
				if(!empty($page_list))
				{
					echo "<table width='100%' border='0' cellspacing='0' cellpadding='5'>
					<tr>
			<td class='listheader'>&nbsp;</td>
           	<td class='listheader' nowrap>Name</td>
			<td class='listheader' nowrap>Email</td>
			</tr>";
					$counter = 0;
					foreach($page_list AS $row)
					{
						array_push($userlist, $row['userid']);
						echo "<tr style='".get_row_color($counter, 2)."'>
		<td valign='top' nowrap><a href='javascript:void(0)' onclick=\"confirmDeleteEntity('".base_url()."user/remove_user_from_group/i/".encryptValue($row['id'])."/gn/".encryptValue($row['groupname'])."', 'Are you sure you want to remove this user from the group? \\nThis operation can not be undone. \\nClick OK to confirm, \\nCancel to cancel this operation and stay on this page.');\" title=\"Click to remove this user from the group.\"><img src='".base_url()."images/delete.png' border='0'/></a></td>
		
							<td valign='top'>".$row['firstname']." ".$row['lastname']."</td>
		
							<td valign='top'>".$row['emailaddress']."</td>
						</tr>";
						$counter++;
					}
					
					echo "</table>";
				}
				else
				{
					echo format_notice("There are no users in this email group yet.");
				}
				
				#Add the user to the user group list
				$this->session->set_userdata('usergrouplist', $userlist);
				
				echo "</div>
					</td></tr></table>
					</td></tr></table>";
				?></td>
                </tr>
 
              <tr>
                <td nowrap>&nbsp;</td>
                <td nowrap>&nbsp;</td>
              </tr>
              <tr>
                <td nowrap>&nbsp;</td>
                <td nowrap><input type="submit" name="savegroup" id="savegroup" value="Save" class="button"/></td>
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

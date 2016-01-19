<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">

<meta name="description" content="NYPPEX Transfer Administration is one of the world's leading private equity secondary agents for private funds and companies">
<meta name="keywords" content="NYPPEX, private equity, secondary market, private companies">
<title><?php echo SITE_TITLE.": Manage Organizations";?></title>
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
          <td valign="top"><?php  
$this->load->view('incl/leftmenu', array('subsection'=>'manage_organizations', 'section'=>'users'));?></td>
        </tr>
        </table>
<br />
<img src="<?php echo base_url();?>images/spacer.gif" width="255" height="1" /></div></td>
    <td valign="top"><div class="tabBox" id="contentdiv">
    <?php $this->load->view('incl/admin_top_menu', array('mselected'=>'users'));?>
    <div class="content">
        <form id="form1" name="form1" method="post" action="">
        <table border="0" cellspacing="0" cellpadding="10" width="100%" id='contenttable'>
          <tr>
            <td colspan="2" style="padding-top:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="pageheader" nowrap>Manage Organizations</td>
    <td align="right"><a href="javascript:void(0)" onclick="updateFieldLayer('<?php echo base_url();?>help/view_help_topic/i/<?php echo encryptValue('manage_organizations');?>', '', '', '_', '')"><img src="<?php echo base_url();?>images/help_icon.png" border="0" /></a></td>
  </tr>
</table>
 </td>
            </tr>
          <tr>
            <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="5" align="left">
			<?php
		   if(!empty($msg)){
			  echo "<tr><td>".format_notice($msg)."</td></tr>";
			}
		?>
            
            
            <tr>
              <td><table border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><b>Search:</b></td>
    <td>&nbsp;</td>
    <td><input name="search" type="text" id="search" size="35" class="textfield" value="" onkeyup="startInstantSearch('search', 'searchby', '<?php echo base_url();?>search/load_results/type/organizations_list/layer/searchresults')" onkeypress="return handleEnter(this, event)"/></td>
    <td>&nbsp;<input name="searchby" type="hidden" id="searchby" value="organizationname__symbol" /></td>
    <td><input type="button" name="search" id="search" value="Search" class="bodybutton"/></td>
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
           	<td class='listheader' nowrap>Organization</td>
			<td class='listheader' nowrap>Symbol</td>
			<td class='listheader' nowrap>Contact Email</td>
			<td class='listheader' nowrap>Contact Phone</td>
			</tr>";	
	$counter = 0;	
	foreach($page_list AS $row)
	{
		#Show one row at a time
		echo "<tr style='".get_row_color($counter, 2)."'>
		<td valign='top' nowrap>";
		
		if(check_user_access($this,'delete_organization')){
		echo "<a href='javascript:void(0)' onclick=\"confirmDeleteEntity('".base_url()."user/deactivate_organization/i/".encryptValue($row['id'])."', 'Are you sure you want to remove this organization? \\nThis operation can not be undone. \\nClick OK to confirm, \\nCancel to cancel this operation and stay on this page.');\" title=\"Click to remove this organization.\"><img src='".base_url()."images/delete.png' border='0'/></a> ";
		}
		
		if(check_user_access($this,'update_organization')){
		echo "<a href='".base_url()."user/add_organization/i/".encryptValue($row['id'])."' title=\"Click to edit this organization.\"><img src='".base_url()."images/edit.png' border='0'/></a>";
		}
		
		echo "</td>
		
		<td valign='top'><a href='".base_url()."user/add_organization/i/".encryptValue($row['id'])."/a/".encryptValue('view')."' title=\"Click to view this organization's details.\" class='contentlink'>".wordwrap($row['organizationname'], 50, "<BR>")."</a></td>
		
		<td valign='top'>".$row['symbol']."</td>
		
		<td valign='top'>".$row['contactemail']."</td>
		
		<td valign='top'>(".substr_replace(substr_replace($row['contactphone'], ') ', 3, 0), '-', 8, 0)."</td>
		
		</tr>";
		
		$counter++;
	}
	
		
	echo "<tr>
	<td colspan='5' align='right'  class='layer_table_pagination'>".
	pagination($this->session->userdata('search_total_results'), $rows_per_page, $current_list_page, base_url()."user/manage_organizations/p/%d")
	."</td>
	</tr>
	</table>";	
		
} else {
	echo format_notice("There are no organizations at the moment.");
	
}
?></div>
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

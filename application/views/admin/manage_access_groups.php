<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">

<meta name="description" content="NYPPEX Transfer Administration is one of the world's leading private equity secondary agents for private funds and companies">
<meta name="keywords" content="NYPPEX, private equity, secondary market, private companies">
<title><?php echo SITE_TITLE.": Manage Access Groups";?></title>
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
        <form id="form1" name="form1" method="post" action="">
        <table border="0" cellspacing="0" cellpadding="10" width="100%" id='contenttable'>
          <tr>
            <td colspan="2" style="padding-top:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="pageheader" nowrap>Manage Access Groups</td>
    <td align="right"><a href="javascript:void(0)" onclick="updateFieldLayer('<?php echo base_url();?>help/view_help_topic/i/<?php echo encryptValue('manage_access_groups');?>', '', '', '_', '')"><img src="<?php echo base_url();?>images/help_icon.png" border="0" /></a></td>
  </tr>
</table>
 </td>
            </tr>
            <?php   
				  
				if(!empty($msg)){
			  	echo "<tr><td>".format_notice($msg)."</td></tr>";
			  	}
				
				?>
          <tr>
            <td valign="top">
            
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
	
				
                  
				
					
				<?php 
				if(!empty($access_group_list)){
				?>
				
                <tr>
                    <td style="padding-top: 5px;
	padding-right: 5px;
	padding-bottom: 5px;
	text-align: left;padding-left:10px;font-size: 13px;">
					<table width="100%" border="0" cellspacing="0" cellpadding="5">
                      	
					    <tr>
						<?php if(empty($a)){?>
                          <td class="listheader" width="1%">&nbsp;</td>
						<?php }?>
                          <td class="listheader" nowrap>Group Name</td>
                          <td class="listheader" nowrap>Is Admin?</td>
						  <td class="listheader" nowrap>Added By</td>
						  <td class="listheader" nowrap>Date Added</td>
                        </tr>
                        <?php 
					  $counter = 0;
					  foreach($access_group_list AS $row){
					  ?>
                        <tr style='<?php echo get_row_color($counter, 2);?>'>
						<?php if(empty($a)){?>
						
						
                          <td style="font-size: 13px;" nowrap="nowrap">
						<?php if(check_user_access($this,'delete_access_group')){?>
                          <a  href="javascript:void(0)" onclick="confirmDeleteEntity('<?php echo base_url();?>admin/delete_user_group/i/<?php echo encryptValue($row['groupid']);?>', 'Are you sure you want to delete this access group? All the user\'s under this group will no longer be able to access the application.\nClick OK to confirm, \nCancel to cancel this operation and stay on this page.')" title="Click to delete this access group"><img src="<?php echo base_url();?>images/delete.png" border="0"/></a>
                          <?php  }?>
						  
						  <?php if(check_user_access($this,'update_access_group')){?>
						  <a href="<?php echo base_url();?>admin/access_group_form/i/<?php echo encryptValue($row['groupid']);?>" title="Click to update this access group."><img src="<?php echo base_url();?>images/edit.png" border="0"/></a> 
						 <?php }
						
if(check_user_access($this,'manage_access_permissions')){?>
						  <a href="<?php echo base_url();?>admin/update_permissions/i/<?php echo encryptValue($row['groupid']);?>" title="Click to update this access group's permissions"><img src="<?php echo base_url();?>images/patient_history.png" border="0" height="18"/></a>
						  <?php  }?>
                          
  
						</td>
						<?php }?>
                          <td nowrap="nowrap"><?php echo $row['groupname'];?></td>
                          <td nowrap="nowrap"><?php echo $row['isadmin'];?></td>
						  <td style="font-size: 13px;" nowrap="nowrap"><?php echo $row['firstname'].' '.$row['lastname'];?></td>
						  <td style="font-size: 13px;" nowrap="nowrap"><?php echo date('m/d/Y h:iA', strtotime($row['dateadded']));?></td>
                        </tr>
                        <?php $counter++;
					  } ?>
                      </table></td>
                  </tr>
				 <?php
					}
					else 
					{
						echo '<tr><td>No access groups have been created yet.</td></tr>';
					}
					?>
				  
				  
                </table>
            
            </td>
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

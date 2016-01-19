<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">

<meta name="description" content="NYPPEX Transfer Administration is one of the world's leading private equity secondary agents for private funds and companies">
<meta name="keywords" content="NYPPEX, private equity, secondary market, private companies">
<title><?php echo SITE_TITLE.": Report Access Control";?></title>
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
$this->load->view('incl/leftmenu', array('subsection'=> 'report_access_control', 'section'=>'reports'));?></td>
        </tr>
        </table>
<br />
<img src="<?php echo base_url();?>images/spacer.gif" width="255" height="1" /></div></td>
    <td valign="top">
    <div class="tabBox" id="contentdiv">
    <?php $this->load->view('incl/admin_top_menu', array('mselected'=>'reports'));?>
    
    <div class="content">
        <form id="form1" name="form1" method="post" action="">
        <table border="0" cellspacing="0" cellpadding="10" width="100%" id='contenttable'>        
          <tr>
            <td colspan="2" style="padding-top:0px;">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
  			<tr>
    			<td class="pageheader" nowrap>Report Access Control</td>
    			<td align="right">
                	<a href="javascript:void(0)" onclick="updateFieldLayer('<?php echo base_url();?>help/view_help_topic/i/<?php echo encryptValue('manage_trading_days');?>', '', '', '_', '')"><img src="<?php echo base_url();?>images/help_icon.png" border="0" /></a>
                </td>
  			</tr>
			</table>
 			</td>
          </tr>
          
          <tr>
            <td valign="top">
            	<table width="100%" border="0" cellspacing="0" cellpadding="5" align="left">
			<?php
		   if(!empty($msg)){
			  echo "<tr><td>".format_notice($msg)."</td></tr>";
			}
			?>  
                <tr>
                  <td>
                  <table border="0" cellspacing="0" cellpadding="5">
                <?php
				#show the report search if no report has been selected yet
				if(empty($report_details))
				{
				?>  
                  <tr>
                    <td><b>Search Report:</b></td>
                    <td>&nbsp;</td>
                    <td><input name="search" type="text" id="search" size="35" class="textfield" value="" onkeyup="startInstantSearch('search', 'searchby', '<?php echo base_url();?>search/load_results/type/selectedreports/layer/searchresults');showPartLayer('searchresults', 'fast');" onkeypress="return handleEnter(this, event)"/>
                    <div id="searchresults" style='max-height: 380px; overflow:hidden; position:absolute;border: 1px solid #98CBFF; background-color: #F7F7F7; display:none;'></div>
                    </td>
                    <td>&nbsp;<input name="searchby" type="hidden" id="searchby" value="reportname" /></td>
                    <td><input type="button" name="search" id="search" value="Search" class="bodybutton"/></td>
                  </tr>
                  
                <?php
                }
                #show the user search only when a report has been selected
                elseif(!empty($report_details))
                {
                ?>  
                 <tr>
                    <td><b>Search Users:</b></td>
                    <td>&nbsp;</td>
                    <td><input name="searchuser" type="text" id="searchuser" size="35" class="textfield" value="" onkeyup="startInstantSearch('searchuser', 'user_searchby', '<?php echo base_url();?>search/load_results/type/outside_report_user_list/layer/user_searchresults/reportid/'+document.getElementById('reportid').value);showLayerSet('user_searchresults');" onkeypress="return handleEnter(this, event)"/>
                    <div id="user_searchresults" style='max-height: 380px; overflow:hidden; position:absolute;border: 1px solid #98CBFF; background-color: #F7F7F7; display:none;'></div>
                    </td>
                    <td>&nbsp;<input name="user_searchby" type="hidden" id="user_searchby" value="U.firstname__U.lastname__U.username__U.emailaddress__O.organizationname" /></td>
                    <td><input type="button" name="search" id="search" value="Search" class="bodybutton"/></td>
                  </tr>
                  
                <?php
                }
                ?>
                  
                  <tr>
                    <td colspan="5">
                        <div id="contentdiv">
    <?php
        echo "<div id='report_search_result'> ";
                if(!empty($report_details))
                {
        
         echo "<table width='100%' border='0' cellspacing='0' cellpadding='5' class='lightorangebg'>
            <tr>
            <td width='1%' nowrap><b>Users For:</b></td>
            <td width='98%' valign='top'> ".wordwrap($report_details['reportname'], 30, "<BR>").
			"<input type='hidden' name='reportid' id='reportid' value='".$report_details['id']."' />";
            
        echo "</td>
            <td width='1%' valign='top'><a  href='".base_url()."reports/report_access_control' title='Click to start over'><img src='".base_url()."images/delete_icon.png' border='0'/></a></td>
            </tr>
            </table>";
     }
    
    echo "</div> ";
    ?>
    
    
    
    <div id='searchuserlist'>
	<?php 
if(!empty($msg))
{
	echo format_notice($msg)."<BR>";
}
		
		#Show any users if some are already selected
if(!empty($page_list))
{
	foreach($page_list AS $row)
	{
		#Show one row at a time
		echo "<div id='user_".$row['id']."_layer' style='border-top: solid 1px #EEE;'>
			<table width='100%' border='0' cellspacing='0' cellpadding='5' style='background-color:#FFF;'>
			<tr>
		<td valign='top' width='1%' nowrap><div id='user_action_".$row['id']."_layer'>";
		

		
		echo "<a href='javascript:void(0)' onClick=\"confirmRemoveUserReportAccessAction('".base_url()."reports/remove_report_user/i/".encryptValue($row['id'])."', 'user_".$row['id']."_layer', 'searchuserlist', 'remove this user')\" title=\"Click to remove this user from the access list.\"><img src='".base_url()."images/delete.png' border='0'/></a> </div></td>
		
		<td width='97%' valign='top'>".wordwrap("<b>".$row['firstname']." ".$row['lastname']."</b> (User Name: <i>".$row['username']."</i> &nbsp; Email: <i>".$row['emailaddress']."&nbsp; Organization: <i>".check_empty_value($row['organizationname'],'N/A')."</i>", 90, "<BR>").")</td><td valign='top' width='1%' nowrap></td>".
		"</tr>
		</table></div>";
		
	}	
		
} 
elseif(empty($page_list) && !empty($report_details) )
{
	echo format_notice("No users have been added yet.");	
}


?></div>
    
    
    
    
                        </div>
                    </td>
                  </tr>
    
                </table>
                </td>
               </tr>
          
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

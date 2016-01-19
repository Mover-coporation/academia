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
	echo "Add ";
}
echo " Help";
?></title>
<link rel="shortcut icon" type="image/x-icon" href="<?php echo BASE_URL;?>favicon.ico">
<?php
echo "<script src='".base_url()."js/jquery.min.js' type='text/javascript'></script>";
echo minimize_code($this, 'javascript');
echo get_AJAX_constructor(TRUE);
?>
<?php echo minimize_code($this, 'stylesheets');?>



 <link rel="stylesheet" href="<?php echo base_url();?>css/jquery-ui.css" />
    <script src="<?php echo base_url();?>js/jquery-1.8.3.min.js"></script>
    <script src="<?php echo base_url();?>js/jquery-ui.min.js"></script>
    
    
    <style>
    #sortable { list-style-type: none; margin: 0; padding: 0; width: 60%; }
    #sortable li { margin: 0 3px 3px 3px; padding: 0.4em; padding-left: 1.5em; font-size: 1.4em; height: 18px; }
    #sortable li span { position: absolute; margin-left: -1.3em; }
    </style>
    <script>
    $(function() {
        $( "#sortable" ).sortable();
        $( "#sortable" ).disableSelection();
    });
    </script>
	
	
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
$this->load->view('incl/leftmenu', array('subsection'=>'add_help_topic', 'section'=>'system_data'));?>
          
          </td>
        </tr>
        </table>
<br />
<img src="<?php echo base_url();?>images/spacer.gif" width="255" height="1" /></div></td>
    <td valign="top"><div class="tabBox" id="contentdiv">
    <?php $this->load->view('incl/admin_top_menu', array('mselected'=>'system_data'));?>
    <div class="content">
        <form id="form1" enctype="multipart/form-data" name="form1" method="post" action="<?php echo base_url()."help/add_help_topic";
		if(!empty($i))
		{
			echo "/i/".$i;
		}
		?>">
        <table border="0" cellspacing="0" cellpadding="10" width="100%" id='contenttable'>
          <tr>
            <td colspan="2" style="padding-top:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="pageheader"><a href="<?php echo base_url();?>help/manage_help" class="pageheader"/>Manage Help</a> &raquo; <?php 
		if(!empty($i) && empty($isview)){
			echo "Update ";
			$code = 'update_help';
			
		} else if(!empty($isview)){
			echo "View ";
			$code = 'view_help';
			
		} else {
			echo "Add ";
			$code = 'add_help';
			
		}?>Help</td>
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
                <td width="1%" class="label" style="text-align:left; padding-right:0px;" nowrap>Help Topic:</td>
                <td width="1%" nowrap><?php if(!empty($isview) || !empty($formdata['helptopic']))
			{
				echo "<span class='viewtext'>".$formdata['helptopic']."</span><input name='helptopic' type='hidden' id='helptopic' value='".$formdata['helptopic']."' /><input name='topiccode' type='hidden' id='topiccode' value='".$formdata['topiccode']."' />";
			}
			else
			{
				 echo get_required_field_wrap($requiredfields, 'helptopic');?><input type="text" name="helptopic" id="helptopic" size="40" class="textfield" value="<?php 
				if(!empty($formdata['helptopic'])){ echo $formdata['helptopic'];}
				?>" tabindex="2" onkeyup="startInstantSearch('helptopic', 'searchby', '<?php echo base_url();?>search/load_results/type/help_topic/layer/helptopic_searchresults/fieldname/helptopic/hiddenfieldname/topiccode');ShowContent('helptopic_searchresults','');"/><input name="searchby" type="hidden" id="searchby" value="topiccode" /><input name="topiccode" type="hidden" id="topiccode" value="<?php 
				if(!empty($formdata['topiccode'])){ echo $formdata['topiccode'];}
				?>" /><div id='helptopic_searchresults' style='max-height: 380px; overflow:hidden; position:absolute;border: 1px solid #98CBFF; background-color: #F7F7F7; display:none;'></div><?php echo get_required_field_wrap($requiredfields, 'helptopic', 'end');
				
			}?></td>
                <td width="98%" nowrap><?php 
				if(!empty($page_list)){
				?><div style="color:#999; font-size:12px; font-weight:bold;" id="instructiondiv">[To add a new item, scroll to the bottom of the content list.]</div><?php }?></td>
              </tr>
               
<?php
if(!empty($page_list))
{
?>  
              <tr>
                <td colspan="3" nowrap>
<b>Content List:</b><br />
<div id="sortable" class='selectfield' style='background: #F2F4F4;width:100%;'> 
<?php
	$counter = 0;
	foreach($page_list AS $row)
	{
		#Show one row at a time
		echo "<div class='ui-state-default'>
		<table style='".get_row_color($counter, 2)."' width='100%'>
		<tr>
    	<td valign='top' width='1%'>
		<a href='javascript:void(0)' onclick=\"confirmDeleteEntity('".base_url()."help/remove_help_item/i/".encryptValue($row['id'])."/t/".encryptValue($row['topiccode'])."', 'Are you sure you want to remove this help item? \\nThis operation can not be undone. \\nClick OK to confirm, \\nCancel to cancel this operation and stay on this page.');\" title='Click to remove this help item.'><img src='".base_url()."images/delete.png' border='0'/></a>
		<input type='hidden' name='helpitem[]' value='".$row['id']."' />
		</td>
	
    	<td width='98%' align='left'>";
		if(!empty($row['fileurl']))
		{
			if(strtolower(strrchr($row['fileurl'],".")) == '.swf')
			{
				
				echo "<a href=\"javascript:void(0)\" onclick=\"updateFieldLayer('".base_url()."page/view_video/f/".encryptValue('documents')."/u/".encryptValue($row['fileurl'])."', '', '', '_', '')\" class='bluelink'>View Larger Video</a>
				<br>
				<object id=\"movie\" type=\"application/x-shockwave-flash\" data=\"".base_url()."downloads/documents/".$row['fileurl']."\" style=\"width: 400px; height: 250px;\">
	<embed src=\"".base_url()."downloads/documents/".$row['fileurl']."\" type=\"application/x-shockwave-flash\" width=\"400\" height=\"100%\" allowScriptAccess=\"sameDomain\" pluginspage=\"http://get.adobe.com/de/flashplayer/\"></embed>
</object>
<br>";
			}
			else if(is_file_an_image(UPLOAD_DIRECTORY."documents/".$row['fileurl']))
			{
				$WIDTH  = 600; 
				$img_properties = minimize_image(UPLOAD_DIRECTORY."documents/".$row['fileurl'], '', $WIDTH);
				$imgwidth = ($img_properties['actualwidth'] < $WIDTH)? $img_properties['actualwidth']: $WIDTH;
				echo "<a href='javascript:void(0)' onclick=\"updateFieldLayer('".base_url()."downloads/documents/".$row['fileurl']."','','','_','')\"><img src='".base_url()."downloads/documents/".$row['fileurl']."' width='".$imgwidth."' border='0'></a>
					 <br>";
			}
			else
			{
				echo "<br><a href='".base_url()."documents/force_download/u/".encryptValue($row['fileurl'])."/f/".encryptValue('documents')."' class='bluelink'><img src='".base_url()."images/".get_doc_logo($row['fileurl'])."' border='0'>
			&nbsp;
			Download Document</a><br>";
			}
		}
		if(!empty($row['helplink']))
		{
			echo "<a href='".$row['helplink']."' class='contentlink' target='_blank'>".$row['helplink']."</a>";
		}
		echo stripslashes(html_entity_decode(html_entity_decode($row['details'])));
		
		echo "</td>
		<td width='1%' valign='top' align='right'><span class='ui-icon ui-icon-arrowthick-2-n-s'></span></td> 
    	</tr></table></div>";
		$counter++;
	}  
?>  
                

</td>
                </tr>
                
                <tr>
        <td colspan="3" nowrap><input type="submit" name="save" id="save" value="Save" class="button"/></td>
    </tr>

<?php }?>

    <tr>
        <td colspan="3" nowrap>&nbsp;</td>
    </tr>
    
    
    <tr>
       <td colspan="3" nowrap>
<?php echo get_required_field_wrap($requiredfields, 'details');?>
<table class="selectfield" style="background: #F2F4F4;" width="100%">
 		  <tr>
 		    <td colspan="2" nowrap><b>Add Content Item:</b></td>
 		    </tr>
 		  <tr>
			<td class='label' valign="top" style="padding-top:5px;" width="1%" nowrap>Upload: <br /><span class='smalltxt'>(Video/Image/Document)</span></td>
    		<td nowrap>
			<table cellpadding="0" cellspacing="0" border="0">
			<tr><td>
	<input name='fileurl' type='file' id='fileurl' size='30' class='textfield' style="height: 35px;"/><br /><span class='smalltxt'><b>Allowed Extensions:</b>
<br />Image Extensions: <?php echo implode(", ", $imageexts);?>
<br />Document Extensions: <?php echo implode(", ", $docexts);?>
<br />Video Extensions: <?php echo implode(", ", $videoexts);?>
</span></td></tr>
	</table>
	</td>
  </tr>
  
  <tr>
  <td class='label'>Paragraph Link:</td>
  <td><input type='text' name='helplink' id='helplink' value='' size='45' class='textfield' style="padding-right:2px;"></td>
  </tr>
  
  <tr>
  <td class='label' valign='top'>Paragraph Text:</td>
  <td><textarea name='details' id='details' class='selectfield' cols='36' rows='5'></textarea></td>
  </tr>
  <tr>
    <td class='label' valign='top'>&nbsp;</td>
    <td><input type="submit" name="addhelp" id="addhelp" value="Add Content" class="bodybutton"/></td>
  </tr>
        </table>               
<?php echo get_required_field_wrap($requiredfields, 'details', 'end');?>            
                
                
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

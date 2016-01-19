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
<title><?php echo SITE_TITLE." : Student Leave Details";?></title>
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
$this->load->view('incl/user_left_menu', array('mselected' => 'students' ));?>
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
            		<td valign="middle"><div class="page-title"><?php 
		if(!empty($i) && empty($isview)){
			echo "Update ";
			
		} else if(!empty($isview)){
			echo "View ";
			
		} else {
			echo "Add New ";			
		}?> Student Leave Details</div></td>
            		<td valign="middle">&nbsp;</td>
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
            <form id="form1" name="form1" method="post" action="<?php echo base_url();?>students/save_student_leave<?php 
		if(!empty($i))
		{
			echo "/i/".$i;
		}
		?>" >
            
            <table width="100" border="0" cellspacing="0" cellpadding="8">
				  <tr>
                    <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">Student :<?php echo $indicator;?></td>
                    <td class="field" nowrap>
                      <?php  
				echo "<span class='viewtext'>".$studentdetails['firstname']." ".$studentdetails['lastname']."</span><input type='hidden' name='student' value='".((empty($formdata)) ? $studentdetails['id'] : $formdata['student'])."'";
				  ?>
                    </td>
                    <td rowspan="6" nowrap class="field" valign="top">
                    	<table>
                        <tr>
                          <td colspan="2" class="label">Comments</td></tr>
                        <tr>
                          <td colspan="2" class="label" valign="top">
                          <?php  
			if(!empty($isview))
			{
				echo "<span class='viewtext'>".$formdata['comments']."</span>";
			}else{
					echo get_required_field_wrap($requiredfields, 'comments');
					?>
                      <textarea name="comments" id="comments" class="richtextfield" cols="40" rows="3">
					  <?php 
				  if(!empty($formdata['comments']))
				 	 echo $formdata['comments'];
				  ?>
                  </textarea>
                      <?php  echo get_required_field_wrap($requiredfields, 'comments', 'end');
			}
				  ?>
                          </td></tr>
                        </table>
                    </td>
                  </tr>
                  <tr>
                    <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">Start date :<?php echo $indicator;?></td>
                    <td class="field" nowrap>
                      <?php if(!empty($isview))
			{
				echo "<span class='viewtext'>".$formdata['startdate']."</span>";
			}else{
				echo get_required_field_wrap($requiredfields, 'startdate');
                    ?>
                      <input type="text" name="startdate" id="startdate" class="textfield manyyearsdatefield" size="30" value="<?php 
				  if(!empty($formdata['startdate'])){
				 	 echo $formdata['startdate'];
				  }?>"/>
                      <?php 
					  echo get_required_field_wrap($requiredfields, 'startdate', 'end');
					  } 
					  ?>
                    </td>
                  </tr>
                  <tr>
                    <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">Expected Return date :<?php echo $indicator;?></td>
                    <td class="field" nowrap>
                      <?php  
			if(!empty($isview))
			{
				echo "<span class='viewtext'>".$formdata['expectedreturndate']."</span>";
			}else{
					echo get_required_field_wrap($requiredfields, 'expectedreturndate');
					?>
                      <input type="text" name="expectedreturndate" id="expectedreturndate" class="textfield manyyearsdatefield" size="30" value="<?php 
				  if(!empty($formdata['expectedreturndate'])){
				 	 echo $formdata['expectedreturndate'];
				  }?>"/>
                      <?php  echo get_required_field_wrap($requiredfields, 'expectedreturndate', 'end');
			}
				  ?>
                    </td>
                  </tr>
                  <tr>
                    <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">Assigned by :<?php echo $indicator;?></td>
                    <td class="field" nowrap>
                      <?php 
				echo "<span class='viewtext'>".$this->session->userdata('names')."</span>";
				  ?>
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
                    <td><input type="submit" name="save" id="savestudent" value="Save" class="button"/></td>
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

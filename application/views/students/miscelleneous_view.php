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
<title><?php echo SITE_TITLE." : Inventory Item";?></title>
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
	$("#savestock").click(function(){
	$("#stocknumber").removeAttr("disabled");
	});
});

$(document).ready(function() {
	// date picker fields for many years
	$(".manyyearsdatefield").datepick({dateFormat: 'yyyy-mm-dd'});
});
</script>
</head>

<body>
<table border="0" cellspacing="0" width="100%" cellpadding="5" align="center">
  <tr>
    <td colspan="2" style="padding-top:10px;" align="left" bordercolor="#FFC926"><img src="<?php echo base_url();?>images/sims_login.png" /></td>
  </tr>
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
            		<td valign="middle"><div class="page-title">Miscelleneous Details</div></td>
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
            <form id="form1" name="form1" method="post" action="<?php echo base_url();?>students/load_miscelleneous_form<?php 
		if(!empty($i))
		{
			echo "/i/".$i;
		}
		echo "/s/".encryptValue($studentdetails['id']);
		?>" >
            
            <table width="100" border="0" cellspacing="0" cellpadding="8">
            	   <tr>
                    <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">Student :<?php echo $indicator;?></td>
                    <td class="field" nowrap>
                      <?php
				echo "<span class='viewtext'>".$studentdetails['firstname']." ".$studentdetails['lastname']."</span>";
				  ?>
                    </td>
                  </tr> 
            	  <tr>
                          <td class="label" style="padding-top:13px">Evaluation :</td>
                          <td class="field">
                    <?php  
					
					if(!empty($isview))
					{
						echo "<span class='viewtext'>".		((!empty($formdata['eval']) && $formdata['eval'] == 1)? "Positive" : "Negative") ."</span>";
					}
					else
					{
					?>
                    <table border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td><input name="eval_select" id='eval_p' type="radio" value="1" onclick="passFormValue('eval_p', 'eval', 'radio')" <?php 
				  if(!empty($formdata['eval']) && $formdata['eval'] == 1)
				 	 echo "checked=\"checked\"";
				  ?>/></td>
                          <td>Positive</td>
                          <td>&nbsp;</td>
                          <td><input name="eval_select" id='eval_n' type="radio" value="0" onclick="passFormValue('eval_n', 'eval', 'radio')" <?php 
				  if((!empty($formdata['eval']) && $formdata['eval'] == 0) || empty($formdata['eval'])) echo " checked";
				  ?>/></td>
                          <td>Negative</td>
                          <td><input name="eval" type="hidden" id="eval" value="<?php 
				  if(!empty($formdata['eval'])){
				 	 echo $formdata['eval'];
				  } else {
				  	 echo '0';
				  }?>"/></td>
                        </tr>
                      </table>
                    <?php } ?>
                    </td>
                        </tr>
                    </td>
                  </tr> 
				  <tr>
                    <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">Subject :<?php echo $indicator;?></td>
                    <td class="field" nowrap>
                      <?php  
			if(!empty($isview))
			{
				echo "<span class='viewtext'>".$formdata['subject']."</span>";
			}else{
					echo get_required_field_wrap($requiredfields, 'subject');
					?>
                      <input type="text" name="subject" id="subject" class="textfield" size="30" value="<?php 
				  if(!empty($formdata['subject'])){
				 	 echo $formdata['subject'];
				  }?>"/>
                      <?php  echo get_required_field_wrap($requiredfields, 'subject', 'end');
			}
				  ?>
                    </td>
                  </tr> 
                  <input type="hidden" name="student" value="<?php echo $studentdetails['id']; ?>" />       
                  <tr>
                    <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">Message :<?php echo $indicator;?></td>
                    <td class="field" nowrap>
                      <?php  
			if(!empty($isview))
			{
				echo "<span class='viewtext'>".$formdata['message']."</span>";
			}else{
					echo get_required_field_wrap($requiredfields, 'message');
					?>
                    <textarea name="message" id="message" class="" cols="31" rows="6">
                    	<?php 
				  if(!empty($formdata['message'])){
				 	 echo $formdata['message'];
				  }?>
                    </textarea>
                      <?php  echo get_required_field_wrap($requiredfields, 'message', 'end');
			}
				  ?>
                    </td>
                  </tr>
                  
              
                  
                  <?php  if(empty($isview)){ ?>
				  <tr>
                    <td>&nbsp;</td>
                    <td><input type="submit" name="savemiscelleneous" id="savemiscelleneous" value="Save" class="button"/></td>
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

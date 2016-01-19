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
            		<td valign="middle"><div class="page-title">Transaction Details</div></td>
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
                    <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">Student Name :<?php echo $indicator;?></td>
                    <td class="field" nowrap>
                      <?php  
				echo "<span class='viewtext'>".$studentdata['firstname']." ".$studentdata['lastname']."</span>";
				  ?>
                    </td>
                  </tr>
              
              <tr>
                    <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">
                    <form id="form1" name="form1" method="post" action="<?php echo base_url();?>students/load_transaction_form<?php 
		if(!empty($i))
		{
			echo "/i/".$i;
		}
			echo "/s/".encryptValue($studentdata['id']) ;
		?>" >
                    Date of transaction :<?php echo $indicator;?></td>
                    <td class="field" nowrap>
                      <?php  
			if(!empty($isview))
			{
				echo "<span class='viewtext'>".$formdata['datecreated']."</span>";
			}else{
					echo get_required_field_wrap($requiredfields, 'datecreated');
					?>
                      <input type="text" name="datecreated" id="dob" class="textfield manyyearsdatefield" size="30" value="<?php 
				  if(!empty($formdata['datecreated'])){
				 	 echo $formdata['datecreated'];
				  }?>"/>
                      <?php  echo get_required_field_wrap($requiredfields, 'datecreated', 'end');
			}
				  ?>
                    </td>
                  </tr>
                  
                  <tr>
    <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">Item :<?php echo $indicator;?></td>
    <td class="field" nowrap>
    <?php
		echo get_required_field_wrap($requiredfields, 'search');
	?>
    <input name="search" type="text" id="search" size="35" class="textfield" value="<?php 
				  if(!empty($formdata['search'])){
				 	 echo $formdata['search'];
				  }?>" onkeyup="startInstantSearch('search', 'searchby', '<?php echo base_url();?>search/load_results/type/item_list/layer/searchresults/area/select_items');showPartLayer('searchresults', 'fast');" onkeypress="return handleEnter(this, event)"/>
    <?php  echo get_required_field_wrap($requiredfields, 'search', 'end');?>
    <div id="searchresults" style='max-height: 380px; overflow:hidden; position:absolute;border: 1px solid #98CBFF; background-color: #F7F7F7; display:none;'></div></td>
    <td>&nbsp;<input name="searchby" type="hidden" id="searchby" value="itemname__price" /></td>
              </tr>
                  <input id="itemid" type="hidden" name="itemid" value="<?php 
				  if(!empty($formdata['itemid'])){
				 	 echo $formdata['itemid'];
				  }; ?>" />
				  <tr>
                    <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">Quanity :<?php echo $indicator;?></td>
                    <td class="field" nowrap>
                      <?php  
			if(!empty($isview))
			{
				echo "<span class='viewtext'>".$formdata['quantity']."</span>";
			}else{
					echo get_required_field_wrap($requiredfields, 'quantity');
					?>
                      <input type="text" name="quantity" id="quantity" class="textfield" size="30" value="<?php 
				  if(!empty($formdata['quantity'])){
				 	 echo $formdata['quantity'];
				  }?>"/>
                      <?php  echo get_required_field_wrap($requiredfields, 'quantity', 'end');
			}
				  ?>
                    </td>
                  </tr>
                  
                  <input type="hidden" name="studentid" value="<?php echo $studentdata['id']; ?>"/>
                  <?php  if(empty($isview)){ ?>
				  <tr>
                    <td>&nbsp;</td>
                    <td><input type="submit" name="savetransaction" id="login" value="Save" class="button"/></td>
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

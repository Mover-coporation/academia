<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">

<meta name="description" content="">
<meta name="keywords" content="">
<title><?php echo SITE_TITLE." : Register Students";?></title>
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
<table border="0" cellspacing="0" width="100%" cellpadding="5" align="center">
  <tr><?php $this->load->view('incl/header'); ?></tr>
  <tr>
    <td colspan="3" style="padding:0;" align="left" bordercolor="#FFC926"><div class="yellow_ruler"></div></td>
  </tr>
  <tr>
    <td valign="top" class="leftpod">
    <div id='leftmenu'>
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
    
    <td width="1%" class="leftShadow" valign="bottom"></td>
    
    <td valign="top" class="rightPod">
    <div class="tabBox" id="contentdiv">
    	<div class="content">
        <table border="0" cellspacing="0" cellpadding="10" width="100%" id='contenttable'>
          <tr>
            <td colspan="2" style="padding-top:0px;" class="pageheader">
            	<table>
          		<tr>
            		<td valign="middle"><div class="page-title"> <?php echo 'Register students : select a student '; ?></div></td>
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
          <td colspan="2">
          <table><tr>
    <td><b>Search:</b></td>
    <td>&nbsp;</td>
    <td><input name="search" type="text" id="search" size="35" class="textfield" value="" onkeyup="startInstantSearch('search', 'searchby', '<?php echo base_url();?>search/load_results/type/register_student/layer/searchresults')" onkeypress="return handleEnter(this, event)"/></td>
    <td>&nbsp;<input name="searchby" type="hidden" id="searchby" value="firstname__lastname__studentno" /></td>
    <td><input type="button" name="search" id="search" value="Search" class="bodybutton"/></td>
    </tr>
    </table>
    </td>
              </tr>
            
          <tr>
            <td valign="top">
            
            <div id="searchresults">
            <?php  
			#$page_list = array();
			if(!empty($page_list))
			{
				echo "<table width='100%' border='0' cellspacing='0' cellpadding='5'>
          	<tr>
			<td class='listheader'>&nbsp;</td>
           	<td class='listheader' nowrap>Student</td>
			<td class='listheader' nowrap>Student No</td>
           	<td class='listheader' nowrap>Age</td>
			<td class='listheader' nowrap>Current Class</td>
			<td class='listheader' nowrap>Date Added</td>
			</tr>";
				
	$counter = 0;	
	foreach($page_list AS $row)
	{
		#Show one row at a time
				
		#Get the current class details
		$current_class = current_class($this, $row['id']);
		
		echo "<tr style='".get_row_color($counter, 2)."'>
		<td valign='top' nowrap>";
		
			echo " &nbsp;&nbsp; <a href='".base_url()."students/load_registration_form/s/".encryptValue($row['id'])."' title=\"Click to register ".$row['firstname'].".\">Register student</a>";
		
		 echo "</td>		
		<td valign='top'>".$row['firstname']." ".$row['lastname']."</td>		
		<td valign='top'>".$row['studentno']."</td>
		<td valign='top' nowrap>".number_format(get_date_diff($row['dob'], date('m/d/Y h:i:s a', time()), 'days')/365,0)."</td>".
		"<td valign='top' nowrap>".$current_class['class'].", ".$current_class['term']." [".$current_class['year']."]</td>
		<td valign='top'>".date("j M, Y", GetTimeStamp($row['dateadded']))."</td>		
		</tr>";
		
		$counter++;
	}
	
		
	echo "<tr>
	<td colspan='5' align='right'  class='layer_table_pagination'>".
	pagination($this->session->userdata('search_total_results'), $rows_per_page, $current_list_page, base_url()."students/manage_student_register/p/%d")
	."</td>
	</tr>
	</table>";	
			}
			else
			{
				echo "<div>No student admissions have been made.</div";
			}
		
		?>
            
            </div>
            </td>
            </tr>
          
        </table>
    </div>
	</div>
	</td>
  </tr>
  <tr>
    <td colspan="3" valign="top" align="center"><?php $this->load->view('incl/footer');?></td>
  </tr>
</table>
</body>
</html>

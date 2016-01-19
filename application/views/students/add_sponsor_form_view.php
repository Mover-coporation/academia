<?php if(empty($save)) : ?>
<div id="sponsorship-form-results" class="content has_photo_upload">
<?php endif; ?>

<script type="text/javascript">
$(document).ready(function() {
	
	$(function() {
	uploadPhotoViaAjax();
    $("#dob").datepicker({
      changeMonth: true,
      changeYear: true,
      yearRange: "-50:+50",
	  dateFormat: "yy-mm-dd"
    });
  });
	
});

</script>

<?php
if(empty($requiredfields)) $requiredfields = array();

$indicator = (!empty($isview))? "": "<span class='redtext'>*</span>";
?>

<form id="upload-image" method="post" action="" name="upload-image" enctype="multipart/form-data">
        <div style="display:none">
        <input type="file" id="profile-photo" onchange="clickElement('submit-photo')" name="profile-photo" />
        <input type="submit" name="submit-photo" id="submit-photo" value="submit" />
        </div>
</form>

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
			echo "Add ";			
		}?> Sponsorship details</div></td>
            		<td valign="middle">&nbsp;</td>
                    <td valign="middle">&nbsp;</td>
            	</tr>
          </table>
			</td>
          </tr>            
 <?php   
if(isset($msg)){
	echo "<tr><td colspan='4'>".format_notice($msg)."</td></tr>";
}
?>           
            
          <tr>
            <td valign="top">
            <form id="add-student-sponsor" name="add_student_sponsor" method="post" action="<?php echo base_url();?>students/save_student<?php 
		if(!empty($i))
		{
			echo "/i/".$i;
		}
		?>" >                
                <table width="100" border="0" cellspacing="0" cellpadding="8">
                <tr>
                    <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">Student:<?php echo $indicator;?></td>
                    <td class="field" nowrap>
                    <?php
					echo $student_info['firstname'] . " " . $student_info['lastname'] . '<input type="hidden" name="student" id="student" value="' . encryptValue($student_info['id']) . '" />';
					?></td>
                  </tr>
                  <tr>
                    <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">Sponsor:</td>
                    <td class="field" nowrap>
                      <?php if(!empty($isview))
			{
				echo "<span class='viewtext'>".$studentdetails['middlename']."</span>";
			}else{
                    ?>
                      <select name="sponsor" id="sponsor"  class="selectfield"> <?php echo get_select_options($sponsors, 'sponsorid', 'fullname',(!empty($formdata['sponsor'])) ? $formdata['sponsor'] : '','Y','Select Sponsor') ?>
                        </select>
                      <?php } ?>
                      </td>
                    </tr>
                  <tr>
                    <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">Start Date:<?php echo $indicator;?></td>
                    <td class="field" nowrap>
                      <?php  
			if(!empty($isview))
			{
				echo "<span class='viewtext'>".$studentdetails['dob']."</span>";
			}else{
					echo get_required_field_wrap($requiredfields, 'dob');
					?>
                      <input type="text" name="fromdate" id="fromdate" class="textfield datepicker" size="30" value="<?php 
				  if(!empty($formdata['fromdate'])){
				 	 echo $formdata['fromdate'];
				  }?>"/>
                      <?php  echo get_required_field_wrap($requiredfields, 'dob', 'end');
			}
				  ?>
                    </td>
                  </tr>
                  <tr>
                    <td nowrap="nowrap" class="label">End Date :<?php echo $indicator;?></td>
                    <td class="field" nowrap>
                      <?php  
			if(!empty($isview))
			{
				echo "<span class='viewtext'>".$studentdetails['groupname']."</span>";
			}else{
						?>
                      <input type="text" name="todate" id="todate" class="textfield datepicker" size="30" value="<?php 
				  if(!empty($formdata['todate'])){
				 	 echo $formdata['todate'];
				  }?>"/>
                      <?php
						}
					?>
                    </td>
                  </tr>
                  <?php  if(empty($isview)){ ?>
                  <tr>
                    <td>&nbsp;</td>
                    <td><input type="button" name="save" id="save" onclick="saveStudentSponsor('<?php echo ((!empty($student_info['id']))? '/m/'.encryptValue($student_info['id']) : '');?>', 'student<>sponsor<>fromdate<>*todate<>save<?php if(!empty($i) || !empty($editid)) echo '<>editid' ?>');" value="Save" class="button"/></td>
                    <td>&nbsp;</td>
                    </tr>
                  <?php } ?>
                  </table>
                
</form>
            
            </td>
            </tr>
          
        </table>
    <?php if(empty($save)) print  '</div>'; ?>
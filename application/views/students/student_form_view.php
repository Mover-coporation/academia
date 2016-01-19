<script type="text/javascript">
$(document).ready(function() {
	
	$(function() {
	uploadPhotoViaAjax();
    $("#dob").datepicker({
      changeMonth: true,
      changeYear: true,
      yearRange: "-50:+0",
	  dateFormat: "yy-mm-dd"
    });
  });
	
});

</script>

<div id="results" class="content has_photo_upload">
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
			echo "Add New ";			
		}?> Student Details</div></td>
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
            <form id="form1" name="form1" enctype="multipart/form-data" method="post" action="<?php echo base_url();?>students/save_student<?php 
		if(!empty($i))
		{
			echo "/i/".$i;
		}
		?>" >
            
            <table width="100" border="0" cellspacing="0" cellpadding="8">
				  <tr>
                    <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">First Name :<?php echo $indicator;?></td>
                    <td class="field" nowrap>
                      <?php  
			if(!empty($isview))
			{
				echo "<span class='viewtext'>".$userdetails['firstname']."</span>";
			}else{
					echo get_required_field_wrap($requiredfields, 'firstname');
					?>
                      <input type="text" name="firstname" id="firstname" class="textfield" size="30" value="<?php 
				  if(!empty($studentdetails['firstname'])){
				 	 echo $studentdetails['firstname'];
				  }?>"/>
                      <?php  echo get_required_field_wrap($requiredfields, 'firstname', 'end');
			}
				  ?>
                    </td>
                    <td rowspan="9" nowrap class="field" valign="top">
                    	<table>
                        <tr>
                          <td colspan="2" align="right">
                          <div id="image-upload-status">Uploading photo..</div>
                          <div id="image-upload-error"><?php echo format_notice('ERROR: The file could not be uploaded.'); ?></div>
                          <img id="profile-pic" src="<?php echo base_url().((empty($studentdetails['photo']))? 'images/no-photo.jpg' : 'downloads/students/'.$studentdetails['photo']);?>" class="profile-pic" />
                          
                          
                          	<?php  
					 if(!empty($isview))
			{
				echo "<span class='viewtext'>".$userdetails['telephone']."</span><input type='hidden' name='telephone' id='telephone' value='".$userdetails['telephone']."' />";
			}else{
					?>
                      <div id="add-image" class="button" style="width:100px; margin-top:10px">
                        Upload Photo
                      </div>
                      <?php } ?>                          </td>
                          </tr>
                        <tr>
                          <td colspan="2" class="label">&nbsp;</td>
                        </tr>
                        <tr>
                          <td colspan="2" class="label">Guardian Details</td></tr>
                        <tr>
                          <td class="label" style="padding-top:13px">Guardian : </td><td>
            <?php if(!empty($isview))
			{
				echo "<span class='viewtext'>".$studentdetails['guardianone']."</span>";
			}
			else{
			?>
                        <input type="text" name="guardianone" id="guardianone" class="textfield" size="30" value="<?php 
				  if(!empty($studentdetails['guardianone'])){
				 	 echo $studentdetails['guardianone'];
				  }?>"/>
                  <?php } ?>
                  </td></tr>
                        <tr>
                          <td class="label" style="padding-top:13px">Relationship : </td><td>
            <?php if(!empty($isview))
			{
				echo "<span class='viewtext'>".$studentdetails['guardianonerelationship']."</span>";
			}
			else{
			?>
                        <input type="text" name="guardianonerelationship" id="guardianonerelationship" class="textfield" size="30" value="<?php 
				  if(!empty($studentdetails['guardianonerelationship'])){
				 	 echo $studentdetails['guardianonerelationship'];
				  }?>"/>
                  <?php } ?>
                  </td></tr>
                        <tr>
                          <td class="label" style="padding-top:13px">Occupation : </td><td>
            <?php if(!empty($isview))
			{
				echo "<span class='viewtext'>".$studentdetails['guardianoneoccupation']."</span>";
			}
			else{
			?>
                        <input type="text" name="guardianoneoccupation" id="guardianoneoccupation" class="textfield" size="30" value="<?php 
				  if(!empty($studentdetails['guardianoneoccupation'])){
				 	 echo $studentdetails['guardianoneoccupation'];
				  }?>"/>
                  <?php } ?>
                  </td></tr>
                        <tr>
                          <td class="label" style="padding-top:13px">Phone No : </td><td>
            <?php if(!empty($isview))
			{
				echo "<span class='viewtext'>".$studentdetails['guardianonetelephone']."</span>";
			}
			else{
			?>
                        <input type="text" name="guardianonetelephone" id="guardianonetelephone" class="textfield" size="30" value="<?php 
				  if(!empty($studentdetails['guardianonetelephone'])){
				 	 echo $studentdetails['guardianonetelephone'];
				  }?>"/>
                  <?php } ?>
                  </td></tr>
                        <tr>
                          <td class="label" style="padding-top:13px">Address : </td><td>
            <?php if(!empty($isview))
			{
				echo "<span class='viewtext'>".$studentdetails['guardianoneaddress']."</span>";
			}
			else{
			?>
                        <input type="text" name="guardianoneaddress" id="guardianoneaddress" class="textfield" size="30" value="<?php 
				  if(!empty($studentdetails['guardianoneaddress'])){
				 	 echo $studentdetails['guardianoneaddress'];
				  }?>"/>
                  <?php } ?>
                  </td></tr>
                        </table>
                    </td>
                  </tr>
                  <tr>
                    <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">Middle Name :</td>
                    <td class="field" nowrap>
                      <?php if(!empty($isview))
			{
				echo "<span class='viewtext'>".$studentdetails['middlename']."</span>";
			}else{
                    ?>
                      <input type="text" name="middlename" id="middlename" class="textfield" size="30" value="<?php 
				  if(!empty($studentdetails['middlename'])){
				 	 echo $studentdetails['middlename'];
				  }?>"/>
                      <?php } ?>
                    </td>
                  </tr>
                  <tr>
                    <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">Last Name :<?php echo $indicator;?></td>
                    <td class="field" nowrap>
                      <?php  
			if(!empty($isview))
			{
				echo "<span class='viewtext'>".$studentdetails['lastname']."</span>";
			}else{
					echo get_required_field_wrap($requiredfields, 'lastname');
					?>
                      <input type="text" name="lastname" id="lastname" class="textfield" size="30" value="<?php 
				  if(!empty($studentdetails['lastname'])){
				 	 echo $studentdetails['lastname'];
				  }?>"/>
                      <?php  echo get_required_field_wrap($requiredfields, 'lastname', 'end');
			}
				  ?>
                    </td>
                  </tr>
                  <tr>
                    <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">Date of Birth :<?php echo $indicator;?></td>
                    <td class="field" nowrap>
                      <?php  
			if(!empty($isview))
			{
				echo "<span class='viewtext'>".$studentdetails['dob']."</span>";
			}else{
					echo get_required_field_wrap($requiredfields, 'dob');
					?>
                      <input type="text" name="dob" id="dob" class="textfield manyyearsdatefield" size="30" value="<?php 
				  if(!empty($studentdetails['dob'])){
				 	 echo $studentdetails['dob'];
				  }?>"/>
                      <?php  echo get_required_field_wrap($requiredfields, 'dob', 'end');
			}
				  ?>
                    </td>
                  </tr>
                  <tr>
                    <td nowrap="nowrap" class="label">Gender :<?php echo $indicator;?></td>
                    <td class="field" nowrap>
                       <?php  
			if(!empty($isview))
			{
				echo "<span class='viewtext'>".$studentdetails['groupname']."</span>";
			}else{
						?>
                    <select name="gender" id="gender"  class="selectfield"> <option>Select</option>
               <option <?php if(!empty($studentdetails['gender']) && $studentdetails['gender'] == 'Male') echo 'selected="selected"'; ?> value="Male">Male</option>
               <option <?php if(!empty($studentdetails['gender']) && $studentdetails['gender'] == 'Female') echo 'selected="selected"'; ?> value="Female">Female</option>
                    </select>
                    <?php
						}
					?>
                    </td>
                  </tr>
                  <tr>
                    <td nowrap="nowrap" class="label">
                    	Sponsor
                    </td>
                    <td class="field" nowrap>
                      <?php  
					 if(!empty($isview))
			{
				echo "<span class='viewtext'>".$studentdetails['term']." [".$studentdetails['year']."]</span>";
			}else{
					 ?>
                      <select name="sponsor" id="sponsor"  class="selectfield"> <?php echo get_select_options($sponsors, 'sponsorid', 'fullname',(!empty($studentdetails['sponsor'])) ? $studentdetails['sponsor'] : '','Y','Select Sponsor') ?>
                    </select>
                      <?php } ?>
                    </td>
                  </tr>
                  <tr>
                    <td nowrap="nowrap" class="label">Term of Admission :<?php echo $indicator;?> </td>
                    <td class="field" nowrap>
                      <?php  
					 if(!empty($isview) || !empty($i))
			{$admitterminfo = get_term_name_year($this, $studentdetails['admissionterm']);
				echo "<span class='viewtext'>".$admitterminfo['term']." [".$admitterminfo['year']."]</span><input name='admissionterm' type='hidden' value='".$studentdetails['admissionterm']."' />";
			}else{
					 echo get_required_field_wrap($requiredfields, 'admissionterm');?>
                      <select name="admissionterm" id="admissionterm"  class="selectfield"> <?php echo get_select_options($terms, 'id', 'term',(!empty($studentdetails['admissionterm'])) ? $studentdetails['admissionterm'] : '','Y','Select Term') ?>
                    </select>
                      <?php  echo get_required_field_wrap($requiredfields, 'admissionterm', 'end');
			}
				  ?>
                    </td>
                  </tr>
                  
                  <tr>
                    <td nowrap="nowrap" class="label"> Class of Admission :<?php echo $indicator;?> </td>
                    <td class="field" nowrap>
                      <?php  
					 if(!empty($isview) || !empty($i))
			{		
				echo "<span class='viewtext'>".get_class_title($this, $studentdetails['admissionclass'])."</span><input name='admissionclass' type='hidden' value='".$studentdetails['admissionclass']."' />";
			}else{
					 echo get_required_field_wrap($requiredfields, 'admissionclass');?>
                      <select name="admissionclass" id="admissionclass"  class="selectfield"> <?php echo get_select_options($classes, 'id', 'class',(!empty($studentdetails['admissionclass'])) ? $studentdetails['admissionclass'] : '','Y','Select Class') ?>
                    </select>
                      <?php  echo get_required_field_wrap($requiredfields, 'admissionclass', 'end');
			}
				  ?>
                    </td>
                  </tr>
                  
                  <tr>
                    <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">Student No. :<?php echo $indicator;?></td>
                    <td class="field" valign="top" nowrap>
                      <?php  
			if(!empty($isview))
			{
				echo "<span class='viewtext'>".$studentdetails['studentno']."</span>";
			}else{
					echo get_required_field_wrap($requiredfields, 'studentno');
					?>
                      <input type="text" name="studentno" id="studentno" class="textfield" size="30" value="<?php 
				  if(!empty($studentdetails['studentno'])){
				 	 echo $studentdetails['studentno'];
				  }?>"/>
                      <?php  echo get_required_field_wrap($requiredfields, 'studentno', 'end');
			}
				  ?>
                  <input type="hidden" name="photo" id="photo" value="" />
                    </td>
                  </tr>
                  <tr style="display:none">
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
                    <td><input type="button" onclick="updateFieldLayer('<?php echo base_url().'students/save_student';?>','firstname<>lastname<>*dob<>*middlename<>gender<>admissionterm<>admissionclass<>*photo<>*studentno<>*guardianone<>*guardianonerelationship<>*guardianoneoccupation<>*sponsor<>*guardianonetelephone<>*guardianoneaddress<>save','','results','Please enter the required fields.');" name="save" id="save" value="Save" class="button"/></td>
                    <td>&nbsp;</td>
                  </tr>
                  <?php } ?>
                </table>
            
            </form>
            
            </td>
            </tr>
          
        </table>
    </div>
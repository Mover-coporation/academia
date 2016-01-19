<?php if(empty($save)) : ?>
<div id="sponsor-form-results" class="content has_photo_upload">
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
		}?> Sponsor Details</div></td>
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
            <form id="form1" name="form1" method="post" action="#" >
            
            <table width="100" border="0" cellspacing="0" cellpadding="8">
				  <tr>
                    <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">First Name :<?php echo $indicator;?></td>
                    <td class="field" nowrap>
                      <?php  
			if(!empty($isview))
			{
				echo "<span class='viewtext'>".$formdata['firstname']."</span>";
			}else{
					echo get_required_field_wrap($requiredfields, 'firstname');
					?>
                      <input type="text" name="firstname" id="firstname" class="textfield" size="30" value="<?php 
				  if(!empty($formdata['firstname'])){
				 	 echo $formdata['firstname'];
				  }?>"/>
                      <?php  echo get_required_field_wrap($requiredfields, 'firstname', 'end');
			}
				  ?>
                    </td>
                    <td rowspan="7" nowrap class="field" valign="top">
                    	<table>
                        <tr>
                          <td colspan="2" align="right">
                          <div id="image-upload-status">Uploading photo..</div>
                          <div id="image-upload-error"><?php echo format_notice('ERROR: The file could not be uploaded.'); ?></div>
                          <img id="profile-pic" src="<?php echo base_url().((empty($formdata['photo']))? 'images/no-photo.jpg' : 'downloads/sponsors/'.str_replace('.','_thumb.', $formdata['photo']));?>" class="profile-pic" />
                          
                          
                          	<?php  
					 if(!empty($isview))
			{
				echo "<span class='viewtext'>".$formdata['telephone']."</span><input type='hidden' name='telephone' id='telephone' value='".$formdata['telephone']."' />";
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
                          <td colspan="2" class="label">Contact Information</td></tr>
                        <tr>
                          <td class="label" style="padding-top:13px">Email address : </td>
                          <td>
            <?php if(!empty($isview))
			{
				echo "<span class='viewtext'>".$formdata['emailaddress']."</span>";
			}
			else{
			?>
                        <input type="text" name="emailaddress" id="emailaddress" class="textfield" size="30" value="<?php 
				  if(!empty($formdata['emailaddress'])){
				 	 echo $formdata['emailaddress'];
				  }?>"/>
                  <?php } ?>
                  </td></tr>
                        <tr>
                          <td class="label" style="padding-top:13px">Telephone : </td>
                          <td>
            <?php if(!empty($isview))
			{
				echo "<span class='viewtext'>".$formdata['emailaddress']."</span>";
			}
			else{
			?>
                        <input type="text" name="telephone" id="telephone" class="textfield" size="30" value="<?php 
				  if(!empty($formdata['telephone'])){
				 	 echo $formdata['telephone'];
				  }?>"/>
                  <?php } ?>
                  </td></tr>
                        <tr>
                          <td class="label" style="padding-top:13px">Address line 1: </td>
                          <td>
            <?php if(!empty($isview))
			{
				echo "<span class='viewtext'>".$studentdetails['address']."</span>";
			}
			else{
			?>
                        <input type="text" name="address" id="address" class="textfield" size="30" value="<?php 
				  if(!empty($formdata['address'])){
				 	 echo $formdata['address'];
				  }?>"/>
                  <?php } ?>
                  </td></tr>
                      
                        <tr>
                          <td class="label" style="padding-top:13px">Address line 2: </td>
                          <td>
            <?php if(!empty($isview))
			{
				echo "<span class='viewtext'>".$formdata['address2']."</span>";
			}
			else{
			?>
                        <input type="text" name="address2" id="address2" class="textfield" size="30" value="<?php 
				  if(!empty($formdata['address2'])){
				 	 echo $formdata['address2'];
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
				echo "<span class='viewtext'>".$formdata['middlename']."</span>";
			}else{
                    ?>
                      <input type="text" name="middlename" id="middlename" class="textfield" size="30" value="<?php 
				  if(!empty($formdata['middlename'])){
				 	 echo $formdata['middlename'];
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
				  if(!empty($formdata['lastname'])){
				 	 echo $formdata['lastname'];
				  }?>"/>
                      <?php  echo get_required_field_wrap($requiredfields, 'lastname', 'end');
			}
				  ?>
                    </td>
                  </tr>
                  <tr>
                    <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">Date of Birth :</td>
                    <td class="field" nowrap>
                      <?php  
			if(!empty($isview))
			{
				echo "<span class='viewtext'>".$formdata['dob']."</span>";
			}else{
					?>
                      <input type="text" name="dob" id="dob" class="textfield datepicker" size="30" value="<?php 
				  if(!empty($formdata['dob'])){
				 	 echo $formdata['dob'];
				  }?>"/>
                      <?php } ?>
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
               <option <?php if(!empty($formdata['gender']) && $formdata['gender'] == 'Male') echo 'selected="selected"'; ?> value="Male">Male</option>
               <option <?php if(!empty($formdata['gender']) && $formdata['gender'] == 'Female') echo 'selected="selected"'; ?> value="Female">Female</option>
                    </select>
                    <?php
						}
					?>
                    </td>
                  </tr>
                  <tr>
                    <td nowrap="nowrap" class="label">Nationality :<?php echo $indicator;?> </td>
                    <td class="field" nowrap>
                      <?php  
					 if(!empty($isview))
			{
				echo "<span class='viewtext'>".$formdata['nationality']."</span>";
			}else{
					 ?>
                      <select name="nationality" id="nationality" class="selectfield">
                      <?php 
			  
			  if(!empty($formdata['nationality']) && $formdata['nationality'] != 'Others Not Listed Above'){ 
			  	$selected = $formdata['nationality'];
			  } else {
			  	$selected = 'Uganda';
			  }
			  $allcountries = get_all_countries($this);
			  $drop_list = array();
			  foreach($allcountries AS $country) 
			  {
				  array_push($drop_list, array('value'=>$country['name'], 'display'=>$country['name']));
			  }
			  
			  echo get_select_options($drop_list, 'value', 'display', $selected);
			  ?>                     
                    </select>
                      <?php	} ?>
                    </td>
                  </tr>
                  
                  <tr>
                    <td colspan="2" nowrap="nowrap" class="label">
					<input name="photo" type="hidden" id="photo" value=""/>
                    
					<?php if(!empty($i) || !empty($editid)){?><input name="editid" type="hidden" id="editid" value="<?php 
					if(!empty($i)){
						echo $i;
					} else {
						echo $editid;
					}?>"/><?php }
					
					
					?></td>
                  </tr>
                  
                  <tr style="display:none">
                    <td>&nbsp;</td>
                  </tr>
                  <?php  if(empty($isview)){ ?>
				  <tr>
                    <td>&nbsp;</td>
                    <td><input type="button" onclick="saveSponsor('<?php echo ((!empty($i))? '/i/'.$i : '');?>', 'firstname<>*middlename<>lastname<>*dob<>gender<>nationality<>*photo<>emailaddress<>telephone<>*address<>*address2<>save<?php if(!empty($i) || !empty($editid)) echo '<>editid' ?>')" name="save" id="save" value="Save" class="button"/></td>
                    <td>&nbsp;</td>
                  </tr>
                  <?php } ?>
                </table>
            
            </form>
            
            </td>
            </tr>
          
        </table>
    <?php if(empty($save)) print  '</div>'; ?>
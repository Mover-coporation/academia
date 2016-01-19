
<script type="text/javascript">
    uploadAjaxImageFound = false;
</script>
<div id="results" class="content  has_photo_upload">
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
            		<td valign="middle"><div class="page-title">Manage School Information</div></td>
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
            <form id="form1" name="form1" enctype="multipart/form-data" method="post" action="<?php echo base_url();?>schoolinfo/update_school_info<?php 
		if(!empty($i))
		{
			echo "/i/".$i;
		}
		?>" >
            
            <table width="100" border="0" cellspacing="0" cellpadding="8">
				  <tr>
                    <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">School Name :<?php echo $indicator;?></td>
                    <td class="field" nowrap>
                      <?php  
						if(!empty($isview))
						{
							echo "<span class='viewtext'>".$schooldetails['schoolname']."</span>";
						}else{
								echo get_required_field_wrap($schooldetails, 'schoolname');
								?>
								  <input type="text" name="schoolname" id="schoolname" class="textfield" size="30" value="<?php 
							  if(!empty($schooldetails['schoolname'])) echo $schooldetails['schoolname']; ?>"/>
								  <?php  echo get_required_field_wrap($requiredfields, 'schoolname', 'end');
						}
				  	?>
                    </td>
                    <td rowspan="9" nowrap class="field" valign="top">&nbsp;</td>
                    <td rowspan="9" nowrap class="field" valign="top">
                    	<table>
                        <tr>
                          <td colspan="2" align="right">
                          <div id="image-upload-status">Uploading photo..</div>
                          <div id="image-upload-error"><?php echo format_notice('ERROR: The file could not be uploaded.'); ?></div>
                              <?php

                              function imgsplitter($imga)
                              {
                                  $img = explode('.', $imga);
                                  $imgurl = $img[0].'_thumb.'.$img[1];
                                  return  $imgurl;
                              }

                              ?>
                          <img id="profile-pic" src="<?php echo base_url().((empty($schooldetails['logourl']))? 'images/no-photo.jpg' : 'downloads/schools/'.imgsplitter($schooldetails['logourl']));?>" class="profile-pic" />
                          
                          
                          	<?php  
					 if(!empty($isview))
			{
				echo "<span class='viewtext'>".$userdetails['telephone']."</span><input type='hidden' name='telephone' id='telephone' value='".$userdetails['telephone']."' />";
			}else{
					?>
                         <div id="add-image" class="button" style="width:110px; margin-top:10px">
                             Upload Badge
                         </div>
                         <input type="hidden" name="photo" id="photo" value="" />

                  <!--    <div id="add-image" class="button" style="width:100px; margin-top:10px">
                        Upload Badge
                      </div> -->
                      <?php } ?>                          </td>
                          </tr>
                        <tr>
                          <td colspan="2" class="label">&nbsp;</td>
                        </tr>
                   
                        </table>
                    </td>
                  </tr>
                  <tr>
                    <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">District :</td>
                    <td class="field" nowrap>
                      <?php if(!empty($isview))
			{
				echo "<span class='viewtext'>".$schooldetails['district']."</span>";
			}else{
                    ?>
                      <input type="text" name="district" id="district" class="textfield" size="30" value="<?php 
				  if(!empty($schooldetails['district'])) echo $schooldetails['district'];
				  ?>"/>
                      <?php } ?>
                    </td>
                  </tr>
                  <tr>
                    <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">Phone No:<?php echo $indicator;?></td>
                    <td class="field" nowrap>
                      <?php  
			if(!empty($isview))
			{
				echo "<span class='viewtext'>".$schooldetails['telephone']."</span>";
			}else{
					echo get_required_field_wrap($requiredfields, 'telephone');
					?>
                      <input type="text" name="telephone" id="telephone" class="textfield" size="30" value="<?php 
				  if(!empty($schooldetails['telephone'])) echo $schooldetails['telephone']; ?>"/>
                      <?php  echo get_required_field_wrap($requiredfields, 'telephone', 'end');
			}
				  ?>
                    </td>
                  </tr>
                  <tr>
                    <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">Email:<?php echo $indicator;?></td>
                    <td class="field" nowrap>
                      <?php  
			if(!empty($isview))
			{
				echo "<span class='viewtext'>".$schooldetails['emailaddress']."</span>";
			}else{
					echo get_required_field_wrap($requiredfields, 'emailaddress');
					?>
                      <input type="text" name="emailaddress" id="emailaddress" class="textfield" size="30" value="<?php 
				  if(!empty($schooldetails['emailaddress'])){
				 	 echo $schooldetails['emailaddress'];
				  }?>"/>
                      <?php  echo get_required_field_wrap($requiredfields, 'emailaddress', 'end');
			}
				  ?>
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
					
					
					?>
                    <input type="hidden" name="photo" id="photo" value="" /></td>
                    <td>&nbsp;</td>
                  </tr>
                  <?php  if(empty($isview)){ ?>
				  <tr>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
		      </tr>
				  <tr>
                    <td>&nbsp;</td>
                    <td>

                        <input type="button" onclick="updateFieldLayer('<?php echo base_url().'schoolinfo/update_school_info';?>','schoolname<>*district<>telephone<>emailaddress<>*photo<>save','','results','Please enter the required fields.');" name="save" id="save" value="Save" class="button"/>

                    </td>
                    <td>&nbsp;</td>
                  </tr>
                  <?php } ?>
                </table>
            
            </form>
            
            </td>
            </tr>
          
        </table>
    </div>
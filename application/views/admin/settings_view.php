<?php
if(empty($requiredfields)) $requiredfields = array();

$indicator = (!empty($isview))? "": "<span class='redtext'>*</span>";?>
<div class="content has_photo_upload">
        <form id="upload-image" method="post" action="" name="upload-image" enctype="multipart/form-data">
        <div style="display:none">
        <input type="file" id="profile-photo" onchange="clickElement('submit-photo')" name="profile-photo" />
        <input type="submit" name="submit-photo" id="submit-photo" value="submit" />
        </div>
        </form>
        
        <form id="form1" name="form1" enctype="multipart/form-data" method="post" action="<?php echo $this->user1->get_settings_page();?>" >
        <table border="0" cellspacing="0" cellpadding="10" width="100%" id='contenttable'>
          <tr>
            <td colspan="2" style="padding-top:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="pageheader" nowrap>My Settings</td>
    <td align="right">&nbsp;</td>
  </tr>
</table>
 </td>
            </tr>
          <tr>
            <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="5">
              <tr>
                <td colspan="2" nowrap>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
             <?php   
				if(isset($msg)){
			  	echo "<tr><td height='10'></td></tr>".
						"<tr><td>".format_notice($msg)."</td></tr>";
			  	}
				?>
			  
              <tr>
                <td><table width="100%" border="0" cellspacing="0" cellpadding="8">
				  <tr>
				    <td colspan="3" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="5" class="lightergreybg toptablecurves">
                     <tr>
                <td colspan="2" class="sectiontitle" style="padding:8px;">Profile Details:</td>
                </tr>
                    </table></td>
				    </tr>
				  <tr>
                    <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px" width="1%">First Name:<?php echo $indicator;?> </td>
                    <td class="field" width="59%" nowrap>
<?php if(!empty($isview))
			{
				echo "<span class='viewtext'>".$formdata['firstname']."</span>";
			}
			else
			{
				 echo get_required_field_wrap($requiredfields, 'deskid');?>
                    <input type="text" name="firstname" id="firstname" class="textfield" size="30" value="<?php 
				  if(!empty($formdata['firstname'])){
				 	 echo $formdata['firstname'];
				  }?>"/>
                  <?php  echo get_required_field_wrap($requiredfields, 'firstname', 'end');
			}
				  ?>
                    </td>
                    <td width="45%" align="right" valign="top" rowspan="6" nowrap>
                    <div id="profile-pic-wrap">
                    <img id="profile-pic" src="<?php echo base_url().(($formdata['usertype'] == '')? 'images/no-photo.jpg' : 'academiaimages/users/'.$formdata['photo']);?>" class="profile-pic" />
                    </div>      
           <div class="button" onclick="clickElement('profile-photo')" style="width:50px; margin-top:10px">
                    UPLOAD
           </div>
                    
                    </td>
                  </tr>
                  <tr>
                    <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">Last Name:<?php echo $indicator;?></td>
                    <td class="field" nowrap>
                      <?php  
			if(!empty($isview))
			{
				echo "<span class='viewtext'>".$formdata['lastname']."</span>";
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
                    <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">Middle Name:</td>
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
                    <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">Address:<?php echo $indicator;?></td>
                    <td class="field" nowrap>
                      <?php  
			if(!empty($isview))
			{
				echo "<span class='viewtext'>".$formdata['address']."</span>";
			}else{
					echo get_required_field_wrap($requiredfields, 'address');
					?>
                      <input type="text" name="address" id="address" class="textfield" size="30" value="<?php 
				  if(!empty($formdata['address'])){
				 	 echo $formdata['address'];
				  }?>"/>
                      <?php  echo get_required_field_wrap($requiredfields, 'address', 'end');
			}
				  ?>
                    </td>
                    </tr>
                  <tr>
                    <td nowrap="nowrap" class="label">Email: </td>
                    <td class="field" nowrap>
                      <?php  
					 if(!empty($i))
			{
				echo "<span class='viewtext'>".$formdata['emailaddress']."</span><input type='hidden' name='emailaddress' id='emailaddress' value='".$formdata['emailaddress']."' />";
			}else{
					 echo get_required_field_wrap($requiredfields, 'emailaddress');?>
                      <input type="text" name="emailaddress" id="emailaddress" class="textfield" size="30" value="<?php 
				  if(!empty($formdata['emailaddress'])){
				 	 echo $formdata['emailaddress'];
				  }?>"/>
                      <?php  echo get_required_field_wrap($requiredfields, 'emailaddress', 'end');
			}
				  ?>
                    </td>
                    </tr>
                  <tr>
                    <td nowrap="nowrap" class="label">Telephone:<?php echo $indicator;?></td>
                    <td class="field" nowrap>
                      <?php  
					if(!empty($isview))
			{
				echo "<span class='viewtext'>".$formdata['telephone']."</span>";
			}else{
					echo get_required_field_wrap($requiredfields, 'telephone');
					
					?>
                      <input type="text" name="telephone" id="telephone" class="textfield" size="30" value="<?php 
				  if(!empty($formdata['telephone'])){
				 	 echo $formdata['telephone'];
				  }?>"/>
                      <?php  echo get_required_field_wrap($requiredfields, 'telephone', 'end');
			}
				  ?>
                    </td>
                    </tr>
                  <tr>
				    <td colspan="3" style="padding:0px; padding-top:30px;"><table width="100%" border="0" cellspacing="0" cellpadding="5" class="lightergreybg toptablecurves">
                     <tr>
                <td colspan="2" class="sectiontitle" style="padding:8px;">Access Details:</td>
                </tr>
                    </table></td>
				    </tr>
                  <tr>
                    <td nowrap="nowrap" class="label">User Name:</td>
                    <td class="field">
                    <?php echo "<span class='viewtext'>".$formdata['username']."</span>".
				"<input type=\"hidden\" name=\"username\" id=\"username\" value=\"".$formdata['username']."\" />";
				  ?>
                  </td>
                    <td class="field">&nbsp;</td>
                  </tr>
                  
                  
                  
				  <tr>
                    <td nowrap="nowrap" class="label">Staff Group:</td>
                    <td class="field" nowrap="nowrap">
                    <table>
                    	<tr>
                        <td>
                        <?php  
		#User group details
		if($this->session->userdata('usertype') == 'SCHOOL')
		{
			$usergroup = get_user_group_details($this, check_empty_value($this->session->userdata('usergroup'), 0));
		if(empty($usergroup)) $usergroup ['groupname'] = '<i>N/A</i>';
		}
		else
		{
			$usergroup ['groupname'] = '<i>Administrator</i>';
		}				
						echo "<span class='viewtext'>".$usergroup ['groupname']."</span>";
					?>
                        </td>
                        <td>                        
                        </td>
                        </tr>
                    </table>
                    </td>
                    <td class="field" nowrap="nowrap">&nbsp;</td>
                  </tr>
                    
                    <?php
					if(empty($isview)){
					?>
                             
				  <tr>
                    <td nowrap="nowrap" class="label">New Password:<?php if(empty($i))
	  {
	     echo $indicator; 				
	  } else {
		 echo "<BR><span class='smalltext'>(Optional)</span>";  
	  }
					
					?></td>
                    <td class="field">
                    <table cellpadding="0" cellspacing="0" border="0">
                    <tr>
                    	<td><input type="password" name="password" id="password" class="textfield" size="30" value="" onkeyup="startInstantSearch('password', 'password_searchby', '<?php echo base_url();?>search/load_results/type/pwdstrength/layer/password_strength_results');ShowContent('password_strength_results','');" /></td>
                        <td valign="top">
                        <div id='password_strength_results' style='max-height: 380px; overflow:hidden; position:absolute;border: 1px solid #98CBFF; background-color: #F7F7F7; display:none;'></div>
                    <input name="password_searchby" type="hidden" id="password_searchby" value="password" />
                        </td>
                    </tr>
                    </table>
                    </td>
                    <td class="field">&nbsp;</td>
                  </tr>
                  <tr>
                    <td nowrap="nowrap" class="label">Repeat Password:<?php if(empty($i))
	  {
	     echo $indicator; 				
	  }
					
					?></td>
                    <td class="field"><input type="password" name="repeatpassword" id="repeatpassword" class="textfield" size="30" value="" /></td>
                    <td class="field">&nbsp;</td>
                  </tr>
				  <?php } ?>
         
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
                    <td><input type="submit" name="savesettings" id="savesettings" value="Save" class="button"/></td>
                    <td>&nbsp;</td>
                  </tr>
                  <?php } ?>
                </table></td>
              </tr>
			  <tr>
			  	<td>&nbsp;</td>
              </tr>
            </table>
                </td>
              </tr>
              </table></td>
            </tr>
          
        </table>
      </form>
    </div>
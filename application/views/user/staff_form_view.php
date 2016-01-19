<div id="staff-results">
<?php
if(empty($requiredfields)){
	$requiredfields = array();
}

$indicator = (!empty($isview))? "": "<span class='redtext'>*</span>";
?>

        <table border="0" cellspacing="0" cellpadding="10" width="100%" id='contenttable'>
          <tr>
            <td colspan="2" style="padding-top:0px;" class="pageheader">
            	<table>
          		<tr>
            		<td valign="middle"><div class="page-title">Staff Details</div></td>
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
            <form id="form1" name="form1">
            
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
                    <td rowspan="6" nowrap class="field" valign="top">
                    	<table>
                        <tr>
                          <td colspan="2" class="label">Login Details</td></tr>
                        <tr>
                          <td class="label" style="padding-top:13px">Username : </td><td>
            <?php if(!empty($isview))
			{
				echo "<span class='viewtext'>".$formdata['username']."</span>";
			}
			else
			{
				 echo get_required_field_wrap($requiredfields, 'username');?>
                        <input type="text" name="username" id="username" class="textfield" size="30" value="<?php 
				  if(!empty($formdata['username'])){
				 	 echo $formdata['username'];
				  }?>"/>
                  <?php  echo get_required_field_wrap($requiredfields, 'username', 'end');
			}
				  ?>
                  </td></tr>
                        <tr>
                          <td class="label" style="padding-top:13px">Password : </td><td>
                        <?php if(empty($isview))
			{
				?>
                        <input type="password" name="password" id="password" class="textfield" size="30"/>
                  <?php } ?>
                  </td></tr>
                        <tr>
                          <td class="label" style="padding-top:13px">Repeat Password : </td><td>
                        <?php if(empty($isview))
			{
				?>
                        <input type="password" name="repeatpassword" id="repeatpassword" class="textfield" size="30"/>
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
                    <td nowrap="nowrap" class="label">Email Address :<?php echo $indicator;?> </td>
                    <td class="field" nowrap>
                      <?php  
					 if(!empty($isview))
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
                    <td nowrap="nowrap" class="label">User Group :</td>
                    <td class="field" nowrap>
                       <?php  
			if(!empty($isview))
			{
				echo "<span class='viewtext'>".$user_group_info['groupname']."</span>";
			}else{
						?>
                    <select name="usergroup" id="usergroup"  class="selectfield"> <?php echo $usergroups; ?>
                    </select>
                    <?php
						}
					?>
                    </td>
                  </tr>
                  
                  <tr>
                    <td nowrap="nowrap" class="label"> Address :<?php echo $indicator;?> </td>
                    <td class="field" nowrap>
                      <?php  
					 if(!empty($isview))
			{
				echo "<span class='viewtext'>".$userdetails['address']."</span><input type='hidden' name='address' id='address' value='".$formdata['address']."' />";
			}else{
					 echo get_required_field_wrap($requiredfields, 'address');?>
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
                    <td nowrap="nowrap" class="label">Phone No :<?php echo $indicator;?> </td>
                    <td class="field" nowrap>
                      <?php  
					 if(!empty($isview))
			{
				echo "<span class='viewtext'>".$userdetails['telephone']."</span><input type='hidden' name='telephone' id='telephone' value='".$formdata['telephone']."' />";
			}else{
					 echo get_required_field_wrap($requiredfields, 'telephone');?>
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
                    <td><input onClick="saveStaff('<?php echo ((!empty($i))? '/i/'.$i : '');?>', 'firstname<>*middlename<>*telephone<>lastname<>emailaddress<>*usergroup<>address<>username<>save<?php echo (!empty($i) || !empty($editid))? '<>editid<>*password<>*repeatpassword' : '<>password<>repeatpassword'; ?>')" type="button" name="save" id="save" value="Save" class="button"/></td>
                    <td>&nbsp;</td>
                  </tr>
                  <?php } ?>
                </table>
            
            </form>
            
            </td>
          </tr>
          
        </table>
    </div>
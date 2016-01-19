<script type="text/javascript">
$(document).ready(function() {
	$(function() {
    $( "#dob" ).datepicker({
      changeMonth: true,
      changeYear: true,
      yearRange: "-50:0",
	  dateFormat: "yy-mm-dd"
    });
  });
	
});
</script>

<div id="results" class="content">
<?php
if(empty($requiredfields)) $requiredfields = array();

$indicator = (!empty($isview))? "": "<span class='redtext'>*</span>";?>
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
		}?> User Details</div></td>
            		<td valign="middle">&nbsp;</td>
                    <td valign="middle">&nbsp;</td>
            	</tr>
          </table>
			</td>
          </tr>
          <tr>
            <td colspan="2" style="padding-top:0px;">
			</td>
          </tr>
            
 <?php   
if(isset($msg)){
	echo "<tr><td colspan='4'>".format_notice($msg)."</td></tr>";
}
?>           
            
          <tr>
            <td valign="top">
            	<form id="form1" name="form1" method="post" action="<?php echo base_url();?>admin/save_school_user<?php if(!empty($i)) echo "/i/".$i;
		?>" >
            
            <table width="100" border="0" cellspacing="0" cellpadding="8">
				  <tr>
                    <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">School :<?php echo $indicator;?> </td>
                    <td class="field" nowrap>
<?php echo "<span class='viewtext'>".$schooldetails['schoolname']."</span>";?>
                    <input type="hidden" name="school" id="school" value="<?php echo $schooldetails['id']; ?>"/>
                    </td>
                    <td rowspan="6" nowrap class="field" valign="top">
                    	<table>
                        <tr>
                          <td colspan="2" class="label">Login Details</td></tr>
                        <tr>
                          <td class="label" style="padding-top:13px">Username : </td><td>
            <?php if(!empty($isview))
			{
				echo "<span class='viewtext'>".$userdetails['username']."</span>";
			}
			else
			{
				 echo get_required_field_wrap($requiredfields, 'username');?>
                        <input type="text" name="username" id="username" class="textfield" size="30" value="<?php 
				  if(!empty($userdetails['username'])){
				 	 echo $userdetails['username'];
				  }?>"/>
                <input type="hidden" name="username1" id="username1"   value="<?php
                if(!empty($userdetails['username'])){
                    echo $userdetails['username'];
                }?>" />
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
                        <tr>
                          <td class="label" style="padding-top:13px">Is School Admin ?</td>
                          <td class="field">
                    <?php  
					
					if(!empty($isview))
					{
						echo "<span class='viewtext'>".		((!empty($userdetails['isschooladmin']) && $userdetails['isschooladmin'] == 'Y')? "Yes" : "No") ."</span>";
					}
					else
					{
					?>
                    <table border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td><input name="isadmin_select" id='isadmin_y' type="radio" value="Y" onclick="passFormValue('isadmin_y', 'isschooladmin', 'radio')" <?php 
				  if(!empty($userdetails['isschooladmin']) && $userdetails['isschooladmin'] == 'Y')
				 	 echo "checked=\"checked\"";
				  ?>/></td>
                          <td>Yes</td>
                          <td>&nbsp;</td>
                          <td><input name="isadmin_select" id='isadmin_n' type="radio" value="N" onclick="passFormValue('isadmin_n', 'isschooladmin', 'radio')" <?php 
				  if((!empty($userdetails['isadmin']) && $userdetails['isschooladmin'] == 'N') || empty($userdetails['isschooladmin'])) echo " checked";
				  ?>/>

                  </td>
                          <td>No</td>
                          <td><input name="isschooladmin" type="hidden" id="isschooladmin" value="<?php 
				  if(!empty($userdetails['isschooladmin'])){
				 	 echo $userdetails['isschooladmin'];
				  } else {
				  	 echo 'N';
				  }?>"/></td>
                        </tr>
                      </table>
                    <?php } ?>
                    </td>
                        </tr>
                        </table>
                    </td>
                  </tr>
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
				  if(!empty($userdetails['firstname'])){
				 	 echo $userdetails['firstname'];
				  }?>"/>
                      <?php  echo get_required_field_wrap($requiredfields, 'firstname', 'end');
			}
				  ?>
                    </td>
                  </tr>
                  <tr>
                    <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">Middle Name :</td>
                    <td class="field" nowrap>
                      <?php if(!empty($isview))
			{
				echo "<span class='viewtext'>".$userdetails['middlename']."</span>";
			}else{
                    ?>
                      <input type="text" name="middlename" id="middlename" class="textfield" size="30" value="<?php 
				  if(!empty($userdetails['middlename'])){
				 	 echo $userdetails['middlename'];
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
				echo "<span class='viewtext'>".$userdetails['lastname']."</span>";
			}else{
					echo get_required_field_wrap($requiredfields, 'lastname');
					?>
                      <input type="text" name="lastname" id="lastname" class="textfield" size="30" value="<?php 
				  if(!empty($userdetails['lastname'])){
				 	 echo $userdetails['lastname'];
				  }?>"/>
                      <?php  echo get_required_field_wrap($requiredfields, 'lastname', 'end');
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
                    <td nowrap="nowrap" class="label">Email Address :<?php echo $indicator;?> </td>
                    <td class="field" nowrap>
                      <?php  
					 if(!empty($isview))
			{
				echo "<span class='viewtext'>".$schooldetails['emailaddress']."</span><input type='hidden' name='emailaddress1' id='emailaddress1' value='".$schooldetails['emailaddress']."' />";
			}else{
					 echo get_required_field_wrap($requiredfields, 'emailaddress');?>
                      <input type="text" name="emailaddress" id="emailaddress" class="textfield" size="30" value="<?php 
				  if(!empty($userdetails['emailaddress'])){
				 	 echo $userdetails['emailaddress'];
				  }?>"/>
                      <?php  echo get_required_field_wrap($requiredfields, 'emailaddress', 'end');
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
				echo "<span class='viewtext'>".$userdetails['address']."</span><input type='hidden' name='address' id='address' value='".$userdetails['address']."' />";
			}else{
					 echo get_required_field_wrap($requiredfields, 'emailaddress');?>
                      <input type="text" name="address" id="address" class="textfield" size="30" value="<?php 
				  if(!empty($userdetails['address'])){
				 	 echo $userdetails['address'];
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
				echo "<span class='viewtext'>".$userdetails['telephone']."</span><input type='hidden' name='telephone' id='telephone' value='".$userdetails['telephone']."' />";
			}else{
					 echo get_required_field_wrap($requiredfields, 'telephone');?>
                      <input type="text" name="telephone" id="telephone" class="textfield" size="30" value="<?php 
				  if(!empty($userdetails['telephone'])){
				 	 echo $userdetails['telephone'];
				  }?>"/>
                      <?php  echo get_required_field_wrap($requiredfields, 'telephone', 'end');
			}
				  ?>
                  <input name="usertype" type="hidden" id="usertype" value="SCHOOL"/>
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
                    
                    <td><input type="button" onclick="updateFieldLayer('<?php echo base_url().'admin/save_school_user';if(!empty($i)) echo "/i/".$i;?>','school<>firstname<>lastname<>*middlename<>emailaddress<>*usergroup<>*address<>*telephone<>username<><?php if(!empty($i)) echo '*'; ?>password<><?php if(!empty($i)) echo '*'; ?>repeatpassword<>*isschooladmin<>save<>*username1','','results','Please enter the required fields.');" name="save" id="save" value="Save" class="button"/></td>
                    <td>&nbsp;</td>
                  </tr>
                  <?php } ?>
                </table>
            
            </form>            
            </td>
          </tr>
        </table>
    </div>
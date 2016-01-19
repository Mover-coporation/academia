<?php
if(empty($requiredfields)){
	$requiredfields = array();
}

$indicator = (!empty($isview))? "": "<span class='redtext'>*</span>";?>
<div id="staff-group-form-results">

        <table border="0" cellspacing="0" cellpadding="10" width="100%" id='contenttable'>
          <tr>
            <td colspan="2" style="padding-top:0px;" class="pageheader">
            	<table>
          		<tr>
            		<td valign="middle"><div class="page-title">Staff Group Details</div></td>
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
	echo "<tr><td colspan='2'>".format_notice($msg)."</td></tr>";
}
?>           
            
          <tr>
            <td valign="top">
            <form id="form1" name="form1" method="post" action="<?php echo base_url();?>user/save_staff_group<?php 
		if(!empty($i))
		{
			echo "/i/".$i;
		}
		?>" >
            
            <table width="100" border="0" cellspacing="0" cellpadding="8">
				  <tr>
                    <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">Group Name  :<?php echo $indicator;?></td>
                    <td class="field" nowrap>
                      <?php  
			if(!empty($isview))
			{
				echo "<span class='viewtext'>".$formdata['groupname']."</span>";
			}else{
					echo get_required_field_wrap($requiredfields, 'groupname');
					?>
                      <input type="text" name="groupname" id="groupname" class="textfield" size="30" value="<?php 
				  if(!empty($formdata['groupname'])){
				 	 echo $formdata['groupname'];
				  }?>"/>
                      <?php  echo get_required_field_wrap($requiredfields, 'groupname', 'end');
			}
				  ?>
                    </td>
                    </tr>
                  <tr>
                    <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">Comments :</td>
                    <td class="field" nowrap>
                      <?php if(!empty($isview))
			{
				echo "<span class='viewtext'>".$formdata['comments']."</span>";
			}else{
                    ?>
                      <input type="text" name="comments" id="comments" class="textfield" size="30" value="<?php 
				  if(!empty($formdata['comments'])){
				 	 echo $formdata['comments'];
				  }?>"/>
                      <?php } ?>
                    </td>
                  </tr>
                  <?php  if(empty($isview)){ ?>
				  <tr>
                    <td><?php if(!empty($i) || !empty($editid)){?><input name="editid" type="hidden" id="editid" value="<?php 
					if(!empty($i)){
						echo decryptValue($i);
					} else {
						echo $editid;
					}?>"/><?php }
					
					
					?></td>
                    <td><input onClick="saveStaffGroup('<?php echo ((!empty($i))? '/i/'.$i : '');?>', 'groupname<>*comments<>save<?php echo (!empty($i) || !empty($editid))? '<>editid' : ''; ?>')" type="button" name="save" id="save" value="Save" class="button"/></td>
                    </tr>
                  <?php } ?>
                </table>
            
            </form>
            
            </td>
            </tr>
          
        </table>
</div>
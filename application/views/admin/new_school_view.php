<script type="text/javascript">
$(document).ready(function() {
	$(function() {
    $("#fromdate, #todate").datepicker({
      changeMonth: true,
      changeYear: true,
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
		}?> School Details</div></td>
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
            <form id="form1" name="form1" method="post" action="<?php echo base_url();?>admin/save_school<?php 
		if(!empty($i))
		{
			echo "/i/".$i;
		}
		?>" >
            
            <table width="100" border="0" cellspacing="0" cellpadding="8">
				  <tr>
                    <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">School :<?php echo $indicator;?> </td>
                    <td class="field" nowrap>
<?php if(!empty($isview))
			{
				echo "<span class='viewtext'>".$schooldetails['schoolname']."</span>";
			}
			else
			{
				 echo get_required_field_wrap($requiredfields, 'schoolname');?>
                    <input type="text" name="schoolname" id="schoolname" class="textfield" size="30" value="<?php 
				  if(!empty($schooldetails['schoolname'])){
				 	 echo $schooldetails['schoolname'];
				  }?>"/>
                  <?php  echo get_required_field_wrap($requiredfields, 'schoolname', 'end');
			}
				  ?>
                    </td>
                    <td rowspan="5" nowrap class="field" valign="top">
                    	<table>
                        <tr><td colspan="2" class="label">License Duration</td></tr>
                        <tr><td class="label" style="padding-top:13px">Start : </td><td>
            <?php if(!empty($isview))
			{
				echo "<span class='viewtext'>".$schooldetails['fromdate']."</span>";
			}
			else
			{
				 echo get_required_field_wrap($requiredfields, 'fromdate');?>
                        <input type="text" name="fromdate" id="fromdate" class="textfield manyyearsdatefield" size="30" value="<?php 
				  if(!empty($schooldetails['fromdate'])){
				 	 echo $schooldetails['fromdate'];
				  }?>"/>
                  <?php  echo get_required_field_wrap($requiredfields, 'fromdate', 'end');
			}
				  ?>
                  </td></tr>
                        <tr><td class="label" style="padding-top:13px">End : </td><td>
                        <?php if(!empty($isview))
			{
				echo "<span class='viewtext'>".$schooldetails['todate']."</span>";
			}
			else
			{
				 echo get_required_field_wrap($requiredfields, 'todate');?>
                        <input type="text" name="todate" id="todate" class="textfield manyyearsdatefield" size="30" value="<?php 
				  if(!empty($schooldetails['todate'])){
				 	 echo $schooldetails['todate'];
				  }?>"/>
                  <?php  echo get_required_field_wrap($requiredfields, 'todate', 'end');
			}
				  ?>
                  </td></tr>
                        </table>
                    </td>
                  </tr>
                  <tr>
                    <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">District :<?php echo $indicator;?></td>
                    <td class="field" nowrap>
                      <?php  
			if(!empty($isview))
			{
				echo "<span class='viewtext'>".$schooldetails['district']."</span>";
			}else{
					echo get_required_field_wrap($requiredfields, 'district');
					?>
                      <input type="text" name="district" id="district" class="textfield" size="30" value="<?php 
				  if(!empty($schooldetails['district'])){
				 	 echo $schooldetails['district'];
				  }?>"/>
                      <?php  echo get_required_field_wrap($requiredfields, 'district', 'end');
			}
				  ?>
                    </td>
                  </tr>
                  <tr>
                    <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">Phone No:</td>
                    <td class="field" nowrap>
                      <?php if(!empty($isview))
			{
				echo "<span class='viewtext'>".$schooldetails['telephone']."</span>";
			}else{
                    ?>
                      <input type="text" name="telephone" id="telephone" class="textfield" size="30" value="<?php 
				  if(!empty($schooldetails['telephone'])){
				 	 echo $schooldetails['telephone'];
				  }?>"/>
                      <?php } ?>
                    </td>
                  </tr>
                  <tr>
                    <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">Address :<?php echo $indicator;?></td>
                    <td class="field" nowrap>
                      <?php  
			if(!empty($isview))
			{
				echo "<span class='viewtext'>".$userdetails['addressline1']."</span>";
			}else{
					echo get_required_field_wrap($requiredfields, 'addressline1');
					?>
                      <input type="text" name="address" id="address" class="textfield" size="30" value="<?php 
				  if(!empty($schooldetails['address'])){
				 	 echo $schooldetails['address'];
				  }?>"/>
                      <?php  echo get_required_field_wrap($requiredfields, 'address', 'end');
			}
				  ?>
                    </td>
                  </tr>
                  <tr>
                    <td nowrap="nowrap" class="label">Email:<?php echo $indicator;?> </td>
                    <td class="field" nowrap>
                      <?php  
					 if(!empty($isview))
			{
				echo "<span class='viewtext'>".$schooldetails['emailaddress']."</span><input type='hidden' name='emailaddress' id='emailaddress' value='".$schooldetails['emailaddress']."' />";
			}else{
					 echo get_required_field_wrap($requiredfields, 'emailaddress');?>
                      <input type="text" name="emailaddress" id="emailaddress" class="textfield" size="30" value="<?php 
				  if(!empty($schooldetails['emailaddress'])){
				 	 echo $schooldetails['emailaddress'];
				  }?>"/>
                      <?php  echo get_required_field_wrap($requiredfields, 'emailaddress', 'end');
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
                    <td><input type="button" onclick="updateFieldLayer('<?php echo base_url().'admin/save_school';?>','schoolname<>district<>*telephone<>*address<>fromdate<>todate<>emailaddress<>save','','results','Please enter the required fields.');" name="save" id="save" value="Save" class="button"/></td>
                    <td>&nbsp;</td>
                  </tr>
                  <?php } ?>
                </table>
            </form>            
            </td>
            </tr>
          
        </table>
    </div>
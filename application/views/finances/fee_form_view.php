<?php
if(empty($requiredfields)){
	$requiredfields = array();
}

$indicator = (!empty($isview))? "": "<span class='redtext'>*</span>";?>
<div id="fee-type-form-wrapper">
        <table border="0" cellspacing="0" cellpadding="10" width="100%" id='contenttable'>
          <tr>
            <td colspan="2" style="padding-top:0px;" class="pageheader">
            	<table>
          		<tr>
            		<td valign="middle"><div class="page-title">New Fee Details</div></td>
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
            <td valign="top">
            <form id="form1" name="form1" method="post" action="<?php echo base_url();?>finances/save_fee<?php 
		if(!empty($i))
		{
			echo "/i/".$i;
		}
		?>" >
            
            <table width="100" border="0" cellspacing="0" cellpadding="8">
				  <tr>
                    <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">Fee :<?php echo $indicator;?></td>
                    <td class="field" nowrap>
                      <?php  
			if(!empty($isview))
			{
				echo "<span class='viewtext'>".$feedetails['fee']."</span>";
			}else{
					echo get_required_field_wrap($requiredfields, 'fee');
					?>
                      <input type="text" name="fee" id="fee" class="textfield" size="30" value="<?php 
				  if(!empty($feedetails['fee'])){
				 	 echo $feedetails['fee'];
				  }?>"/>
                      <?php  echo get_required_field_wrap($requiredfields, 'fee', 'end');
			}
				  ?>
                    </td>
                    <td rowspan="5" nowrap class="field" valign="top">
                    	<table>
                        <tr>
                          <td class="label">Notes</td></tr>
                        <tr>
                          <td valign="top" class="label" style="padding-top:0px"><?php if(!empty($isview))
			{
				echo "<span class='viewtext'>".$feedetails['notes']."</span>";
			}
			else
			{
			?>
                        <textarea name="notes" id="notes" rows="3" cols="40" class="richtextfield" ><?php 
				  if(!empty($feedetails['notes']))
				 	 echo $feedetails['notes'];
				  ?></textarea>
                  <?php } ?>
                  		</td></tr>
                        </table>
                    </td>
                  </tr>
                  <tr>
                    <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">Frequency :</td>
                    <td class="field" nowrap>
                      <?php if(!empty($isview))
			{
				echo "<span class='viewtext'>".$feedetails['frequency']."</span>";
			}else{
				echo get_required_field_wrap($requiredfields, 'frequency');
                    ?>
                      <select name="frequency" id="frequency"  class="selectfield"> <option value="">-Select-</option>
               <option <?php 
				  if(!empty($feedetails['frequency']) && $feedetails['frequency'] == 'Termly' )
				 	 echo ' selected="selected" ';
				  ?> value="Termly">Termly</option>
               <option <?php 
				  if(!empty($feedetails['frequency']) && $feedetails['frequency'] == 'Admission' )
				 	 echo ' selected="selected" ';
				  ?> value="Admission">Admission</option>
                    </select>
                      <?php 
					  echo get_required_field_wrap($requiredfields, 'frequency', 'end');
					  } ?>
                    </td>
                  </tr>
                  <tr>
                    <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">Term :<?php echo $indicator;?></td>
                    <td class="field" nowrap>
                      <?php  
			if(!empty($isview))
			{
				echo "<span class='viewtext'>".$feedetails['term']."</span>";
			}else{
					echo get_required_field_wrap($requiredfields, 'term');
					?>
                      <select name="term" id="term"  class="selectfield"> <?php echo get_select_options($terms, 'id', 'term',(!empty($feedetails['term']))? $feedetails['term'] : '','Y','Select Term') ?>
                    </select>
                      <?php  echo get_required_field_wrap($requiredfields, 'term', 'end');
			}
				  ?>
                    </td>
                  </tr>
                  <tr>
                    <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">Classes :<?php echo $indicator;?></td>
                    <td class="field" nowrap>
                      <?php  
			if(!empty($isview))
			{
				echo "<span class='viewtext'>".$feedetails['classes']."</span>";
			}else{
					echo get_required_field_wrap($requiredfields, 'classes');
					?>
                      <select multiple="multiple" name="classes[]" id="classes"  class="selectfield"> <?php echo get_select_options($classes, 'id', 'class',(!empty($feedetails['classes']))? $feedetails['classes'] : '','Y','Select Class') ?>
                    </select>
                      <?php  echo get_required_field_wrap($requiredfields, 'classes', 'end');
			}
				  ?>
                    </td>
                  </tr>
                  
                  <tr>
                    <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">Amount :<?php echo $indicator;?></td>
                    <td class="field" nowrap>
                      <?php  
			if(!empty($isview))
			{
				echo "<span class='viewtext'>".$feedetails['amount']."</span>";
			}else{
					echo get_required_field_wrap($requiredfields, 'amount');
					?>
                      <input type="text" name="amount" id="amount" class="textfield" size="30" value="<?php 
				  if(!empty($feedetails['amount'])){
				 	 echo $feedetails['amount'];
				  }?>"/>
                      <?php  echo get_required_field_wrap($requiredfields, 'amount', 'end');
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
                    <td><input type="submit" name="save" id="login" value="Save" class="button"/></td>
                    <td>&nbsp;</td>
                  </tr>
                  <?php } ?>
                </table>
            
            </form>
            
            </td>
            </tr>
          
        </table>
</div>
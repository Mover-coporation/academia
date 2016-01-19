<?php
	if(empty($requiredfields)){
		$requiredfields = array();
	}
	$indicator = (!empty($isview))? "": "<span class='redtext'>*</span>";
?>
<table border="0" cellspacing="0" width="100%" cellpadding="5" align="center">
  <tr>
    <td valign="top" style="padding:0">&nbsp;</td>
    <td valign="top" style="padding:0">
        <table border="0" cellspacing="0" cellpadding="10" width="100%" id='contenttable'>
          <tr>
            <td colspan="2" style="padding-top:0px;" class="pageheader">
            	<table>
          		<tr>
            		<td valign="middle"><div class="page-title">Subject Details</div></td>
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
            <form id="form1" name="form1" method="post" action="<?php echo base_url();?>curriculum/save_subject<?php 
		if(!empty($i))
		{
			echo "/i/".$i;
		}
		?>" >
            
            <table width="100" border="0" cellspacing="0" cellpadding="8">
				  <tr>
                    <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">Subject :<?php echo $indicator;?></td>
                    <td colspan="2" nowrap class="field">
                      <?php  
			if(!empty($isview))
			{
				echo "<span class='viewtext'>".$formdata['subject']."</span>";
			}else{
					echo get_required_field_wrap($requiredfields, 'subject');
					?>
                      <input type="text" name="subject" id="subject" class="textfield" size="30" value="<?php 
				  if(!empty($formdata['subject'])){
				 	 echo $formdata['subject'];
				  }?>"/>
                      <?php  echo get_required_field_wrap($requiredfields, 'subject', 'end');
			}
				  ?>
                    </td>
                    </tr>
                   <tr>
                    <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">Code :<?php echo $indicator;?></td>
                    <td colspan="2" nowrap class="field">
                      <?php  
			if(!empty($isview))
			{
				echo "<span class='viewtext'>".$formdata['code']."</span>";
			}else{
					echo get_required_field_wrap($requiredfields, 'code');
					?>
                      <input type="text" name="code" id="code" class="textfield" size="30" value="<?php 
				  if(!empty($formdata['code'])){
				 	 echo $formdata['code'];
				  }?>"/>
                      <?php  echo get_required_field_wrap($requiredfields, 'code', 'end');
			}
				  ?>                  
                    </td>
                    </tr>
                    
                    <tr>
                    <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">Papers :</td>
                    <td colspan="2" nowrap class="field">
                      <?php  
			if(!empty($isview))
			{
				echo "<span class='viewtext'>".$formdata['papers']."</span>";
			}else{
					echo get_required_field_wrap($requiredfields, 'code');
					?>
                      <input type="text" name="papers" id="papers" class="textfield" size="30" value="<?php 
				  if(!empty($formdata['papers'])){
				 	 echo $formdata['papers'];
				  }?>"/>
                      <?php  echo get_required_field_wrap($requiredfields, 'papers', 'end');
			}
				  ?>
                  <span style="font-style:italic; font-size:11px; display:block">Separate each paper with a comma e.g Paper I, Paper II, Paper III</span>
                    </td>
                    </tr>
                    
                  <tr>
                    <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">Classes :<?php echo $indicator;?></td>
                    <td colspan="2" nowrap class="field">
                     <?php  
			if(!empty($isview))
			{
				echo "<span class='viewtext'>".$classes."</span>";
			}else{
					echo get_required_field_wrap($requiredfields, 'classes');
					echo '<table cellpadding="5"><tr>';
					$class_ctr = 0;
					foreach($classes as $class)
					{
						$class_ctr++;
						echo '<td style="padding-left:0" valign="middle"><input onchange="update_classes('.count($classes).', \'classes\')" id="class'.$class_ctr.'" type="checkbox" value="'.$class['id'].'" name="classes[]" /></td><td style="padding-left:0">'.$class['class'].'</td>';	
						
						if($class_ctr%3 == 0)	echo '</tr></tr>';				
					}
					if($class_ctr%3 > 0)
					echo '<td colspan="'.($class_ctr%3).'">&nbsp;</td>';
					echo '</tr></table>';
					echo get_required_field_wrap($requiredfields, 'classes', 'end');
			}
				  ?>
                  
                  <input type="hidden" id="classes" name="classes" />
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
                    <td><input onclick="saveSubject('<?php echo ((!empty($i))? '/i/'.$i : '');?>', 'subject<>code<>*papers<>classes<>save<?php echo (!empty($i) || !empty($editid))? '<>editid' : ''; ?>')" type="button" name="save" id="save" value="Save" class="button"/></td>
                    <td>&nbsp;</td>
                    </tr>
                  <?php } ?>
                  </table>
            
            </form>
            
            </td>
            </tr>
          
        </table>
	</td>
  </tr>
</table>
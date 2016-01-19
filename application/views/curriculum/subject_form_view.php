<div id="subject_results">
<?php
if(empty($requiredfields)){
	$requiredfields = array();
}

$indicator = (!empty($isview))? "": "<span class='redtext'>*</span>";?>
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
				  ?></td>
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
                      <input type="text" name="papers" id="papers" class="textfield" size="30" value=""/>
                      <?php  echo get_required_field_wrap($requiredfields, 'papers', 'end');
			}
				  ?>
                  <span style="font-style:italic; font-size:11px; display:block">Separate each paper with a comma e.g Paper I, Paper II, Paper III</span>
                  <div id="paper_results">
                  <?php if(!empty($formdata['papers']) && count($formdata['papers'])){
					   
                  echo "<table>
                  <tr><td colspan='2'>&nbsp;</td></tr>
                  <tr><td colspan='2'><b>Current Papers</b></td></tr>";
                  
                 
				  	foreach($formdata['papers'] as $paper)
						echo "<tr><td><a href='javascript:void(0)' onclick=\"updateFieldLayer('".base_url()."curriculum/delete_paper/i/".encryptValue($paper['id'])."','paper".$paper['id']."','','paper_results','');\"><img src='".base_url()."images/delete.png' border='0'/></a>&nbsp;&nbsp;
						<a href='javascript:void()' title=\"Click to edit ".$paper['paper']." details.\"><img src='".base_url()."images/edit.png' border='0'/></a>&nbsp;&nbsp;
						</td><td><input type='hidden' id='paper".$paper['id']."' name='paper".$paper['id']."' value='".encryptValue($paper['id'])."' />".$paper['paper']."</td></tr>";
                  echo "</table>";
                  } 
				  ?>
                  </div>
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
					$selected_classes = array();
					if(!empty($formdata['classes']))
						$selected_classes = remove_empty_indices(explode('|', $formdata['classes']));
					
					foreach($classes as $class)
					{
						$class_ctr++;
						echo '<td style="padding-left:0" valign="middle"><input '.((in_array($class['id'], $selected_classes))? 'checked="checked"' : '').' onchange="update_classes('.count($classes).', \'classes\')" id="class'.$class_ctr.'" type="checkbox" value="'.$class['id'].'" name="classes[]" /></td><td style="padding-left:0">'.$class['class'].'</td>';	
						
						if($class_ctr%3 == 0)	echo '</tr></tr>';				
					}
					if($class_ctr%3 > 0)
					echo '<td colspan="'.($class_ctr%3).'">&nbsp;</td>';
					echo '</tr></table>';
					echo get_required_field_wrap($requiredfields, 'classes', 'end');
			}
				  ?>
                  
                  <input type="hidden" value="<?php echo implode('|', $selected_classes); ?>" id="classes" name="classes" />
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
                    <td><input type="button" onclick="saveSubject('<?php echo ((!empty($i))? '/i/'.$i : '');?>', 'subject<>code<>*papers<>classes<>save<?php echo (!empty($i) || !empty($editid))? '<>editid' : ''; ?>')" name="save" id="save" value="Save" class="button"/></td>
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
</div>
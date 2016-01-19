<?php
if(empty($requiredfields)){
	$requiredfields = array();
}

$indicator = (!empty($isview))? "": "<span class='redtext'>*</span>";?>
<script type="text/javascript">
$(document).ready(function(){
   $('#save').click(function(){
		updateFieldLayer('<?php echo base_url().'exams/save_exam'.((!empty($i))? '/i/'.$i : '');?>','exam<>term<>contribution<>classes<>save<?php echo (!empty($i) || !empty($editid))? '<>editid' : ''; ?>','','exam-results','Please enter the required fields.');
		listRefresher.curContext='manage-exams';
	});		
	
});
</script>
<table border="0" cellspacing="0" width="100%" cellpadding="5" align="center">
  <tr>
    <td valign="top" style="padding:0">&nbsp;</td>
    <td valign="top" style="padding:0">
        <table border="0" cellspacing="0" cellpadding="10" width="100%" id='contenttable'>
          <tr>
            <td colspan="2" style="padding-top:0px;" class="pageheader">
            	<table>
          		<tr>
            		<td valign="middle"><div class="page-title">Exam Details</div></td>
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
                    <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">Exam:<?php echo $indicator;?></td>
                    <td colspan="2" nowrap class="field">
                      <?php  
			if(!empty($isview))
			{
				echo "<span class='viewtext'>".$formdata['exam']."</span>";
			}else{
					echo get_required_field_wrap($requiredfields, 'exam');
					?>
                      <input type="text" name="exam" id="exam" class="textfield" size="30" value="<?php 
				  if(!empty($formdata['exam'])){
				 	 echo $formdata['exam'];
				  }?>"/>
                      <?php  echo get_required_field_wrap($requiredfields, 'exam', 'end');
			}
				  ?>
                    </td>
                    </tr>
                    
                    <tr>
                    <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">Term:<?php echo $indicator;?></td>
                    <td class="field" nowrap>
                      <?php  
			if(!empty($isview))
			{
				echo "<span class='viewtext'>".$formdata['term']."</span>";
			}else{
					echo get_required_field_wrap($requiredfields, 'term');
					?>
                      <select name="term" id="term"  class="selectfield"> <?php echo get_select_options($terms, 'id', 'term',(!empty($formdata['term']))? $formdata['term'] : '','Y','Select Term') ?>
                    </select>
                      <?php  echo get_required_field_wrap($requiredfields, 'term', 'end');
			}
				  ?>
                    </td>
                    </tr>
                    
                   <tr>
                    <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">% Contribution to <br />
                    final term mark:<?php echo $indicator;?></td>
                    <td colspan="2" nowrap class="field">
                      <?php  
			if(!empty($isview))
			{
				echo "<span class='viewtext'>".$formdata['contribution']."</span>";
			}else{
					echo get_required_field_wrap($requiredfields, 'contribution');
					?>
                      <input type="text" name="contribution" id="contribution" class="textfield" size="30" value="<?php 
				  if(!empty($formdata['contribution'])){
				 	 echo $formdata['contribution'];
				  }?>"/> %
                      <?php  echo get_required_field_wrap($requiredfields, 'contribution', 'end');
			}
				  ?></td>
                    </tr>                    
                  <tr>
                    <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">Classes:<?php echo $indicator;?></td>
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
                    <td><input type="button" onclick="saveExam('<?php echo ((!empty($i))? '/i/'.$i : '');?>', 'exam<>term<>contribution<>classes<>save<?php echo (!empty($i) || !empty($editid))? '<>editid' : ''; ?>')" name="save" id="save" value="Save" class="button"/></td>
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
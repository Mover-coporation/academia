<div id="assign-teacher-subject-results">
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
            		<td valign="middle"><div class="page-title">Assign a teacher for <?php echo $formdata['subject']; ?> </div></td>
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
                    <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">Select Paper :<?php if (count($papers)) echo $indicator;?></td>
                    <td colspan="3" nowrap class="field">
                      <?php  
			if(!empty($isview))
			{
				echo "<span class='viewtext'>".$formdata['subject']."</span>";
			}else{
				if (count($papers)){
					echo get_required_field_wrap($requiredfields, 'paper');
					?>
                      <select name="paper" id="paper"  class="selectfield"> <?php echo get_select_options($papers, 'id', 'paper',(!empty($formdata['paper'])) ? $formdata['paper'] : '','Y','Select a paper') ?>
                    </select>
                      <?php  echo get_required_field_wrap($requiredfields, 'subject', 'end');
				}
				else
				{
					echo '<span style="font-style:italic; font-size:11px; display:block">No papers have been specified for '.$formdata['subject'].'</span>';
				}
			}
				  ?>
                    </td>
                    <td rowspan="3" valign="top" nowrap class="field">
                    </td>
                    </tr>
                  
                  <tr>
                    <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">Select Class :<?php echo $indicator;?></td>
                    <td colspan="3" nowrap class="field">
                      <?php  
			if(!empty($isview))
			{
				echo "<span class='viewtext'>".$formdata['class']."</span>";
			}else{
					echo get_required_field_wrap($requiredfields, 'class');
					?>
                      <select name="class" id="class"  class="selectfield"> <?php echo get_select_options($classes, 'id', 'class',(!empty($formdata['class'])) ? $formdata['class'] : '','Y','Select a class') ?>
                    </select>
                      <?php  echo get_required_field_wrap($requiredfields, 'class', 'end');
			}
				  ?>                  
                    </td>
                    </tr>
                    
                  <tr>
                    <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">Select Teacher :<?php echo $indicator;?></td>
                    <td colspan="3" nowrap class="field">
                      <?php  
			if(!empty($isview))
			{
				echo "<span class='viewtext'>".$formdata['papers']."</span>";
			}else{
					echo get_required_field_wrap($requiredfields, 'teacher');
					?>
                      <select name="teacher" id="teacher"  class="selectfield"> <?php echo get_select_options($staff, 'id', 'fullname',(!empty($formdata['teacher'])) ? $studentdetails['teacher'] : '','Y','Select a teacher') ?>
                    </select>
                      <?php  echo get_required_field_wrap($requiredfields, 'teacher', 'end');
			}
				  ?>
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
                    <td><input type="button" onclick="updateFieldLayer('<?php echo base_url().'curriculum/assign_teacher'.((!empty($i))? '/i/'.$i : '');?>','subject<>teacher<>class<><?php if(count($papers)) echo 'paper<>'; ?>save','','assign-teacher-subject-results','Please enter the required fields.');" name="save" id="save" value="Save" class="button"/>
                    <input type="hidden" id="subject" name="subject" value="<?php echo $formdata['id']; ?>" />
                    </td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
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
<?php if(empty($requiredfields)) $requiredfields = array(); ?>
<form id="form1" name="form1">
	 <table cellpadding="8">
				          <tr>
			              <td colspan="2" align="left"><strong>Registration Details</strong></td></tr>
                          
                           <?php   
if(isset($msg)){
	echo "<tr><td colspan='4'>".format_notice($msg)."</td></tr>";
}
?>           
                          
				          <tr>
				            <td>Term : </td><td>
				              <?php if(!empty($isview))
			{
				echo "<span class='viewtext'>".$studentdetails['guardianone']."</span>";
			}
			else{
					echo get_required_field_wrap($requiredfields, 'term');
			?>
				              <select name="term" id="term"  class="selectfield"> <?php echo get_select_options($terms, 'id', 'term',(!empty($formdata['term'])) ? $formdata['term'] : '','Y','Select Term') ?>
                    </select>
				              <?php 
							  echo get_required_field_wrap($requiredfields, 'term', 'end');
							  } 
							  ?>
			              </td></tr>
				          <tr>
				            <td>Class : </td><td>
				              <?php if(!empty($isview))
			{
				echo "<span class='viewtext'>".$formdata['class']."</span>";
			}
			else{
				echo get_required_field_wrap($requiredfields, 'class');
			?>
				              <select name="class" id="class"  class="selectfield"> <?php echo get_select_options($classes, 'id', 'class',(!empty($formdata['class'])) ? $formdata['class'] : '','Y','Select Class') ?>
                    </select>
				              <?php 
							  echo get_required_field_wrap($requiredfields, 'class', 'end');
							  } 
							  ?>
			              </td></tr>
				          <tr>
				            <td>Subjects : </td><td>
				              <?php if(!empty($isview))
			{
				echo "<span class='viewtext'>".$formdata['subjects']."</span>";
			}
			else{
				echo get_required_field_wrap($requiredfields, 'subjects');
			?>
                              <input type="hidden" id="selected-reg-subjects" value="" />
				              <select multiple="multiple" name="subjects[]" id="update-reg-subjects"  class="selectfield"> <?php echo get_select_options($subjects, 'id', 'subject',(!empty($formadata['subjects'])) ? $formdata['subjects'] : '','Y','Select Sujects') ?>
                    </select>
				              <?php 
							  echo get_required_field_wrap($requiredfields, 'subjects', 'end');
							  } 
							  ?>
			              </td></tr>
                          <?php  if(empty($isview)){ ?>
				          <tr>
				            <td class="label" style="padding-top:13px">&nbsp;</td>
				            <td>
                            <?php if(!empty($i) || !empty($editid)){?><input name="editid" type="hidden" id="editid" value="<?php 
					if(!empty($i)){
						echo decryptValue($i);
					} else {
						echo $editid;
					}?>"/><?php }

                            $datp = (!empty($studentdetails['id'])) ? encryptValue($studentdetails['id']) : true;
					?>

                    <input type="hidden" name="student"  value="<?php echo encryptValue($studentdetails['id']); ?>" />
                            <input type="button" onclick="updateFieldLayer('<?php echo base_url(); ?>students/register_student/student/<?php echo $datp;  ?><?php if(!empty($i)) echo '/i/' . $i; ?>', 'term<>class<>selected-reg-subjects', '', 'contentdiv', 'Please enter the required fields.');" name="save" id="update-register" value="Save" class="button"/></td>
			              </tr>
                          <?php } ?>
			            </table>
</form>
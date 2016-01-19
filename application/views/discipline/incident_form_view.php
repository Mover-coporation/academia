<?php
if(empty($requiredfields)) $requiredfields = array();

$indicator = (!empty($isview))? "": "<span class='redtext'>*</span>";?>
<script type="text/javascript">
$(document).ready(function() {
	$(function() {
    $( "#incidentdate" ).datepicker({
      changeMonth: true,
      changeYear: true,
      yearRange: "-50:+5",
	  dateFormat: "yy-mm-dd"
    });
  });
	
});
</script>
<div class="content hasSelects" id="incident-form-results">
        <table border="0" cellspacing="0" cellpadding="10" width="100%" id='contenttable'>
          <tr>
            <td colspan="2" style="padding-top:0px;" class="pageheader">
            	<table>
          		<tr>
            		<td valign="middle"><div class="page-title">Add Incident</div></td>
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
if(isset($msg))
	echo "<tr><td colspan='4'>".format_notice($msg)."</td></tr>";
?>           
            
          <tr>
            <td valign="top">
            <form id="form1" name="form1" class="ajaxPost" method="post" action="<?php echo base_url() . 'discipline/save_incident' . ((!empty($s))? '/s/' . $s : ''); ?>" >
            
            <table width="100" border="0" cellspacing="0" cellpadding="8">
				  <tr>
                    <td width="96" valign="top" nowrap="nowrap" class="left_label" style="padding-top:13px">Incident date :<?php echo $indicator;?></td>
                    <td width="251" nowrap class="field">
                      <?php  
			if(!empty($isview))
			{
				echo "<span class='viewtext'>".$formdata['incidentdate']."</span>";
			}else{
					echo get_required_field_wrap($requiredfields, 'incidentdate');
					?>
                      <input type="text" name="incidentdate" id="incidentdate" class="textfield" size="30" value="<?php 
				  if(!empty($formdata['incidentdate']))
				 	 echo $formdata['incidentdate'];
				  ?>"/>
                      <?php  echo get_required_field_wrap($requiredfields, 'incidentdate', 'end');
			}
				  ?>
                    </td>
                    <td width="251" rowspan="5" style="padding-left:15px" nowrap valign="top">
                    <div style="padding-bottom:10px">
                    <div class="label" style="width:100%; padding-top:0">
                    <span >Incident details:<?php echo $indicator;?></span>
                    </div>
                   
                      <?php if(!empty($isview))
			{
				echo "<span class='viewtext'>".$incidentdetails['incidentdetails']."</span>";
			}else{
				echo get_required_field_wrap($requiredfields, 'incidentdetails');
                    ?>
                    <textarea id="incidentdetails" name="incidentdetails" rows="2" cols="40"><?php 
				  if(!empty($formdata['incidentdetails']))
				 	 echo $formdata['incidentdetails'];
?></textarea>
                      <?php  echo get_required_field_wrap($requiredfields, 'incidentdetails', 'end');
			}
				  ?>
                  </div>
                  
                  <div>
                  <div class="label" style="width:100%">
                    <span >
                  	Action taken:<?php echo $indicator;?>
                    </span>
                   </div>
                      <?php if(!empty($isview))
			{
				echo "<span class='viewtext'>".$incidentdetails['actiontaken']."</span>";
			}else{
				echo get_required_field_wrap($requiredfields, 'actiontaken');
                    ?>
                    <textarea id="actiontaken" name="actiontaken" rows="2" cols="40"><?php 
				  if(!empty($formdata['actiontaken']))
				 	 echo $formdata['actiontaken'];
?></textarea>
                      <?php  echo get_required_field_wrap($requiredfields, 'actiontaken', 'end');
			}
				  ?> 
                  </div>
                    </td>
                    </tr>
                  <tr>
                    <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">Student :<?php echo $indicator;?></td>
                    <td class="field" nowrap>
                      <?php if(!empty($isview))
							{
								echo "<span class='viewtext'>".$formdata['studentfirstname']." " . $formdata['studentlastname'] . "</span>";
							}else{
								echo get_required_field_wrap($requiredfields, 'student');
								if(!empty($s)):
									echo '<input name="student" value="'.$s.'" type="hidden" />'.
									'<input class="readonlytextfield" readonly="true" value="' . $student_details['firstname'] . ' '. $student_details['lastname'] . '" />';
								else:
                                    $students = $this->db->query($this->Query_reader->get_query_by_code('get_students_list', array('isactive'=>'Y', 'searchstring'=>' AND school=\'' . $this->myschool['id'] . '\'', 'limittext'=>'')))
                                        ->result_array();

                                    foreach($students as $key=>$value)
                                    {
                                       $students[$key]['id'] = encryptValue($value['id']);
                                        $students[$key]['fullname'] = $value['firstname'] . ' ' . $value['lastname'];
                                    }

									echo '<select class="selectfield" name="student">'.
                                            get_select_options($students, 'id', 'fullname', (!empty($formdata['student'])? encryptValue($formdata['student']) : ''));
                                        '</select>';
								endif;

                                echo get_required_field_wrap($requiredfields, 'student', 'end');
							}
				  	?>
                    </td>
                  </tr>
                  
                  <tr>
                    <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">Reported by:<?php echo $indicator;?></td>
                    <td class="field" nowrap>
                      <?php if(!empty($isview))
			{
				echo "<span class='viewtext'>".$formdata['userfirstname'].' '.$formdata['userlastname']."</span>";
			}else{
				echo get_required_field_wrap($requiredfields, 'reportedby');
                          $teachers = $this->db->query($this->Query_reader->get_query_by_code('search_schoolusers', array('searchstring'=>' school=\'' . $this->myschool['id'] . '\' AND isactive=\'Y\'', 'limittext'=>'')))
                              ->result_array();

                          foreach($teachers as $key=>$value)
                          {
                              $teachers[$key]['id'] = encryptValue($value['id']);
                              $teachers[$key]['fullname'] = $value['firstname'] . ' ' . $value['lastname'];
                          }

                          echo '<select class="selectfield" name="reportedby">'.
                              get_select_options($teachers, 'id', 'fullname', (!empty($formdata['reportedby'])? $formdata['reportedby'] : ''));
                          '</select>';
                    ?>
                      <?php  echo get_required_field_wrap($requiredfields, 'reportedby', 'end');
			}
				  ?>
                    </td>
                  </tr>
                  <tr>
                    <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px"><span class="label" style="padding-top:13px">Response</span>:<?php echo $indicator;?></td>
                    <td class="field" valign="top" nowrap>
                      <?php 
					  	if(!empty($isview))
						{
							echo "<span class='viewtext'>".$formdata['response']."</span>";
						}else{
							echo get_required_field_wrap($requiredfields, 'response');
                    ?>
                        <select id="response" name="response" class="selectfield">
                            <option <?php if(empty($formdata['response'])) echo 'selected="selected"'; ?> value="">-Select One-</option>
                            <option <?php if(!empty($formdata['response']) && $formdata['response'] == 'N\A') echo 'selected="selected"'; ?> value="N\A">N\A</option>
                            <option <?php if(!empty($formdata['response']) && $formdata['response'] == 'suspension') echo 'selected="selected"'; ?> value="suspension">Suspension</option>
                            <option <?php if(!empty($formdata['response']) && $formdata['response'] == 'expulsion') echo 'selected="selected"'; ?> value="expulsion">Expulsion</option>
                            <option <?php if(!empty($formdata['response']) && $formdata['response'] == 'other') echo 'selected="selected"'; ?> value="other">Other</option>
                        </select>
                      <?php  echo get_required_field_wrap($requiredfields, 'response', 'end');
			}
				  ?>
                    </td>
                  </tr>
                  <tr>
                    <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">Upload File</td>
                    <td class="field" valign="top" nowrap>&nbsp;</td>
                  </tr>
                  
				  <tr>
                    <td colspan="3" valign="top" nowrap="nowrap" class="left_label" style="padding-top:13px">                    </td>
                  </tr>
                  
                  <tr>
                    <td colspan="3" valign="top" nowrap="nowrap" class="left_label" style="padding-top:13px">                   </td>
                  </tr>
                  
				  <?php  if(empty($isview)){ ?>
				  <tr>
                    <td>
                    <input id="call-back-element" type="hidden" value="incident-form-results" />
                    <input id="save-incident" type="hidden" value="save-incident" name="save_incident" />
                    <input id="list-link-to-refresh" type="hidden" value="discipline" name="list-link-to-refresh" />
					<?php if(!empty($i) || !empty($editid)){?><input name="editid" type="hidden" id="editid" value="<?php 
					if(!empty($i)){
						echo decryptValue($i);
					} else {
						echo $editid;
					}?>"/>
					<?php } ?></td>
                    <td><input type="submit" name="save" id="save-incident-btn" value="Save" class="button"/></td>
                    <td>&nbsp;</td>
                    </tr>
                  <?php } ?>
                </table>
            
            </form>
            
            </td>
            </tr>
          
        </table>
    </div>
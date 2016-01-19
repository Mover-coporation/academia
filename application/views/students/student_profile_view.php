<script type="text/javascript">
	uploadAjaxImageFound = false;
</script>
<script type="text/javascript">
    alert('Issue');
    $(document).ready(function() {
        $(function() {
            $( "#startdate" ).datepicker({
                changeMonth: true,
                changeYear: true,
                yearRange: "-50:+5",
                dateFormat: "yy-mm-dd"
            });

            $( "#enddate" ).datepicker({
                changeMonth: true,
                changeYear: true,
                yearRange: "-50:+5",
                dateFormat: "yy-mm-dd"
            });
        });

    });
</script>
<div class="content has_photo_upload" id="student-profile-view-content">
        <table border="0" cellspacing="0" cellpadding="10" width="100%" id='contenttable'>
          <tr>
            <td valign="top" width="1%" style="padding-top:0px;">

                <table>
                    	<tr>
                        <td align="left">
                            <span id="print">
                        <div id="image-upload-status">Uploading photo..</div>
                                </span>
                        <?php
						#Get the current class details
						$current_class = current_class($this, $studentdetails['id']);


						$profile_image_src = (empty($studentdetails['photo']))? 'images/no-photo.jpg' : 'downloads/students/'.student_photo_thumb($studentdetails['photo']) ;
						echo '<img id="profile-pic" src="'.base_url().$profile_image_src.'" class="profile-pic"/>';
						?>
                        <div id="add-image" class="button" style="width:110px; margin-top:10px">
                        Upload Photo
                      </div>
                      <input type="hidden" name="photo" id="photo" value="" />
                        </td>
                        </tr>
                        <tr>
                    	<td class="field" nowrap>
                      	<?php
						echo "<div class='viewtext'>".number_format(get_date_diff($studentdetails['dob'], date('m/d/Y h:i:s a', time()), 'days')/365,0).", ".$studentdetails['gender']."</div>";
					?>
                    	</td>
                  		</tr>

                  		<tr>
                    	<td class="field" nowrap>
					  	<?php
						echo "<div class='viewtext'>".$current_class['class']."</div>";
						?>
                    	</td>
                  		</tr>

                        <tr>
                    	<td class="field" nowrap>
					  	<?php
						echo "<div class='viewtext'>".$current_class['term']." [".$current_class['year']."]</div>";
						?>
                    	</td>
                  		</tr>

                        <tr>
                    	<td class="field" nowrap>
					  	<?php
						echo "<div class='viewtext'>".$studentdetails['studentno']."</div>";
						?>
                    	</td>
                  		</tr>

                    </table>

			</td>
            <td colspan="2" style="padding-top:0px; vertical-align:top">
            <div class="content_head_one">
            	<div class="page-title clear"> <?php
                    echo $studentdetails['firstname']." ".$studentdetails['lastname'].
						"<input type='hidden' name='firstname' value='".$studentdetails['firstname']."' />";
						?>

                 	<a class="grey_buttons" style="float:right" onclick="updateFieldLayer('<?php echo base_url().'students/manage_students' ?>','','','contentdiv','');" href="javascript:void(0);">View all students
                  </a>
                 </div>
            </div>

            <div class="content_head_two">
            <ul class="page-links clear">
            <a href="javascript:void(0)" onclick="updateFieldLayer('<?php echo base_url().'students/student_profile/incl/'.encryptValue('True').((!empty($i))? '/i/'.$i : '');?>','','','results','');addRemoveClass('active', 'profile', 'student-finances<>academics<>discipline<>attendance<>student-sponsors')">
            	<li id="profile" class="active">Profile</li>
            </a>
            <a href="javascript:void(0)" onclick="updateFieldLayer('<?php echo base_url().'students/get_student_academics'.((!empty($i))? '/i/'.$i : '');?>','','','results','');addRemoveClass('active', 'academics', 'profile<>student-finances<>discipline<>attendance<>student-sponsors')">
            <li id="academics">Academics</li>
            </a>
            <a href="javascript:void(0)" onclick="updateFieldLayer('<?php echo base_url().'sponsors/manage_student_sponsors'.((!empty($i))? '/i/'.$i : '');?>','','','results','');addRemoveClass('active', 'student-sponsors', 'profile<>student-finances<>discipline<>attendance<>academics')">
            <li id="student-sponsors">Sponsors</li>
            </a>
            <a href="javascript:void(0)" onclick="updateFieldLayer('<?php echo base_url().'students/get_student_finances'.((!empty($i))? '/i/'.$i : '');?>','','','results','');addRemoveClass('active', 'student-finances', 'profile<>academics<>discipline<>attendance<>student-sponsors')">
            <li id="student-finances">Finances</li>
            </a>
            <a href="javascript:void(0)" onclick="updateFieldLayer('<?php echo base_url().'discipline/manage_incidents'.((!empty($i))? '/i/'.$i : '');?>','','','results','');">
            	<li id="discipline">Discipline</li>
            </a>
            <a href="javascript:void(0)">
            	<li id="attendance">Attendance</li>
            </a>
            </ul>
            </div>

            <div class="content_head_three">
            	<div id="results">
            <?php $this->load->view('students/student_profile_form', array('studentdetails'=>$studentdetails)); ?>
            	</div>
            </div>

            </td>
          </tr>
        </table>
    </div>
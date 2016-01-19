<div class="content hasDatatable">
        <table border="0" cellspacing="0" cellpadding="10" width="100%" id='contenttable'>            
 <?php   
if(isset($msg)){
	echo "<tr><td colspan='4'>".format_notice($msg)."</td></tr>";
}
?>           
            
          <tr>
          
          <tr>
          <td colspan="2">
          <table width="100%">
          <tr>
    		<td width="50%">
    <div class="search_container clear" style="width:100%">
    <input name="search" placeholder="Search.." type="text" id="search" size="35" class="search_box" value="" onkeyup="startInstantSearch('search', 'searchby', '<?php echo base_url();?>search/load_results/type/<?php echo ($view_leave)? 'student_leave' : 'students'; ?>/layer/searchresults')" onkeypress="return handleEnter(this, event)"/>
    <div class="search_button"></div>
    </div>
    </td>
    
    		<td>
    	<ul class='list_actions'>
		 	<li><a id="select_all" class='grey_buttons select_all' title='Click to select all students in the current list' href='javascript:void(0)'>Select All</a></li>
			<li><a id="unselect_all" class='grey_buttons unselect_all' title='Click to deselect all students in the current list' href='javascript:void(0)'>Deselect All</a></li>
            <li><a id="advanced-search" class='grey_buttons advanced-search' title='Click to display advanced search options' href='javascript:void(0)'>Advanced search</a></li>
			<li><a id="register-students" class='grey_buttons register-students' title='Click to register all the selected students' href='javascript:void(0)'>Register selected students</a></li>

            <li><a  onclick="updateFieldLayer('<?php echo base_url(); ?>/students/manage_students','','','contentdiv','');"  class='grey_buttons register-students' title='Clear Cache' href='javascript:void(0)'>Reset Search</a></li>

        </ul>
    &nbsp;<input name="searchby" type="hidden" id="searchby" value="students.firstname__students.lastname__students.studentno__sponsors.firstname__sponsors.lastname" />
    </td>
    	  </tr>
          
          <tr>
          <td colspan="2">
          <div class="advanced_search" style="">
   			<table>
    	<tr>
        <td><span>Class</span></td>
        <td>
        <select name="class-type" id="class-type">
        <option>Select type</option>
        <option value="current">Current class</option>
        <option value="admission">Admission class</option>
        </select>
        </td>
        <td>
        <select name="select_class" id="select-class"> <?php echo get_select_options($classes, 'id', 'class',(!empty($formdata['class'])) ? $formdata['class'] : '','Y','Select class') ?>
        </select>
        </td>
        <td>&nbsp;</td>
        <td><span>Term</span></td>
        <td>
        <select name="term" id="select-term"> <?php echo get_select_options($terms, 'id', 'term',(!empty($formdata['term'])) ? $formdata['term'] : '','Y','Select Term') ?>
        </select>
        </td>
        <td>&nbsp;</td>
        <!--
        <td><span>Birth Year</span></td>
        <td>
        <select name="term" id="select-term" > <?php #echo get_select_options($terms, 'id', 'term',(!empty($formdata['term'])) ? $formdata['term'] : '','Y','Select Term') ?>
        </select>
        </td>
        -->
        </tr>
    </table>
    	  </div>          
          </td>
          </tr>
          
    	  </table>
		 </td>
          </tr>
          <tr>
            <td valign="top">
            
            <div id="searchresults">
            <?php  
			#$page_list = array();
			if(!empty($page_list))
			{
				echo "<table class='datatable' width='100%' border='0' cellspacing='0' cellpadding='5'>
          	<tr>
			<td class='listheader' width='1%'>&nbsp;</td>
           	<td class='listheader' nowrap>Student &nbsp;<a class='fancybox fancybox.ajax' href='".base_url()."students/load_student_form' title='Click to add a student'><img src='".base_url()."images/add_item.png' border='0'/></a></td>
			<td class='listheader' nowrap>Sponsor</td>
			<td class='listheader' nowrap>Student No</td>
           	<td class='listheader' nowrap>Age</td>".
			(($view_leave) ? 
			//viewing leave
			"<td class='listheader' nowrap>Current Class</td>".
			"<td class='listheader' nowrap>Leaves taken</td></tr>" :
			
			//viewing all student detals
			"<td class='listheader' nowrap>Admission Class</td>
			<td class='listheader' nowrap>Current Class</td>
			<td class='listheader' nowrap>Date Added</td>
			</tr>");	
	$counter = 0;	
	$current_student = 0;
	
	#check if user has delete rights
	$delete_students = check_user_access($this,'delete_students');
	
	foreach($page_list AS $row)
	{
		#Show one row at a time
		
		#Get the admission term title and year
		if(!$view_leave){
		$admitterminfo = get_term_name_year($this, $row['admissionterm']);
		
		#Get the admission class
		$admitclass = get_class_title($this, $row['admissionclass']);		
		}
		
		#Get the current class details
		$current_class = current_class($this, $row['id']);
		
		echo "<tr class='listrow ".(($counter%2)? '' : 'grey_list_row')."' id='student-list-row-". $row['id'] ."'>
		<td class='leftListCell rightListCell' valign='top' nowrap>";
		
		
		if($view_leave){
			echo " &nbsp;&nbsp; <a href='".base_url()."students/load_leave_form/s/".encryptValue($row['id'])."' title=\"Click to assign ".$row['firstname']." leave.\">Assign leave</a>";
		}
		else
		{
			#if(check_user_access($this,'delete_deal')){
				echo "<input class=\"list_checkbox\" type=\"checkbox\" name=\"selected_student[]\" id=\"selected_student_".$row['id']."\" />";
			#}
				
			if($delete_students){
				echo "&nbsp;&nbsp;<a href='javascript:void(0)' onclick=\"asynchDelete('".base_url()."students/delete_student/i/".encryptValue($row['id'])."', 'Are you sure you want to delete this student? \\nThis operation can not be undone. \\nClick OK to confirm, \\nCancel to cancel this operation and stay on this page.','student-list-row-" . $row['id'] . "');\" title=\"Click to remove this student.\"><img src='".base_url()."images/delete.png' border='0'/></a>";
			}
		
			#if(check_user_access($this,'update_deals')){
				//echo " &nbsp;&nbsp; <a onclick=\"updateFieldLayer('".base_url()."students/student_profile/i/".encryptValue($row['id'])."','','','contentdiv','');\" href='javascript:void(0)' title=\"Click to edit ".$row['firstname']."'s details.\"><img src='".base_url()."images/edit.png' border='0'/></a>";
			#}
			
		}
		 echo "</td>		
		<td valign='top' id='std_name_".$row['id']."'><a onclick=\"updateFieldLayer('".base_url()."students/student_profile/i/".encryptValue($row['id'])."','','','contentdiv','');\" href='javascript:void(0)' title=\"Click to edit ".$row['firstname']."'s details.\">".$row['firstname']." ".$row['lastname']."</a></td>	
		<td valign='top'>".$row['sponsorfullname']."</td>	
		<td valign='top'>".$row['studentno']."</td>
		<td valign='top' nowrap>".number_format(get_date_diff($row['dob'], date('m/d/Y h:i:s a', time()), 'days')/365,0)."</td>".
		(($view_leave) ?
		//viewing only leave
		"<td valign='top' nowrap id='std_class_".$row['id']."'>".$current_class['class'].", ".$current_class['term']." [".$current_class['year']."]</td>".
		"<td>".(empty($row['leaves'])? '<i>N/A</i>' :'<a href="'.base_url().'students/student_leave_list/i/'.encryptValue($row['id']).'" title="click to view '.$row['firstname'].'\' leaves.">'.$row['leaves'].'</a>')."</td></tr>" :				
		"<td valign='top'>".$admitclass.", ".$admitterminfo['term']." [".$admitterminfo['year']."]</td>
		<td valign='top' id='std_class_".$row['id']."' nowrap>".$current_class['class'].", ".$current_class['term']." [".$current_class['year']."]</td>
		<td class='rightListCell' valign='top'>".date("j M, Y", GetTimeStamp($row['dateadded']))."</td>		
		</tr>");
		
		$counter++;
		$current_student = $row['id'];
	}
	
		
	echo "<tr>
	  	 <td colspan='7' align='right'  class='layer_table_pagination'>".
			pagination($this->session->userdata('search_total_results'), $rows_per_page, $current_list_page, base_url().				"students/manage_students/p/%d", 'contentdiv')
		."</td>
		</tr>
		</table>";	
			}
			else
			{
				echo "<div>No student admissions have been made.</div>";
			}
		
		?>
           </div> 
            
            </td>
            </tr>
          
        </table>
        
        <div id="registration_form">
        <table border="0" cellspacing="0" cellpadding="10" width="100%" id='contenttable'>
          <tr>
            <td colspan="2" style="padding-top:0px;" class="pageheader">
            <div class="page-title">
					<?php 
if(empty($requiredfields))
	$requiredfields = array();

$indicator = (!empty($isview))? "": "<span class='redtext'>*</span>";?>
           		      Registration Details
            <div style="float:right">
 				<a class="grey_buttons" id="back-to-students" href="javascript:void(0)">View students</a>
 </div>
            
            </div>
             
            </td>
          </tr>
            
 <?php   
if(isset($msg)){
	echo "<tr><td colspan='4'>".format_notice($msg)."</td></tr>";
}
?>           
            
          <tr>
            <td valign="top">
            <form id="form1" name="form1">
            	<table cellpadding="8">
				          <tr>
				            <td>Term: </td><td>
				              <?php if(!empty($isview))
			{
				echo "<span class='viewtext'>".$studentdetails['guardianone']."</span>";
			}
			else{
					echo get_required_field_wrap($requiredfields, 'term');
			?>
				              <select name="term" id="reg-term"  class="selectfield"> <?php echo get_select_options($terms, 'id', 'term',(!empty($formdata['term'])) ? $formdata['term'] : '','Y','Select Term') ?>
                    </select>
				              <?php 
							  echo get_required_field_wrap($requiredfields, 'term', 'end');
							  } 
							  ?>
			              </td>
				            <td rowspan="4" valign="top" align="right">
                            	<table id="selected-reg-students" cellspacing="0" cellpadding="5">
                                <tr><td colspan="3"><b>Selected Students</b></td></tr>
                                <tr>
                                	<td class="listheader">&nbsp;</td>
                                    <td class="listheader">Student</td>
                                    <td	class="listheader">Class</td>
                                </tr>
                                </table>
                                <input type="hidden" id="selected-reg-students" name="selected-reg-students" />
                                <input type="hidden" id="selected-reg-subjects" name="selected-reg-subjects" />
                            </td>
				          </tr>
				          <tr>
				            <td>Class: </td><td>
				              <?php if(!empty($isview))
			{
				echo "<span class='viewtext'>".$formdata['class']."</span>";
			}
			else{
				echo get_required_field_wrap($requiredfields, 'class');
			?>
				              <select name="class" id="reg-class" onChange=""  class="selectfield"> <?php echo get_select_options($classes, 'id', 'class',(!empty($formdata['class'])) ? $formdata['class'] : '','Y','Select Class') ?>
                    </select>
				              <?php 
							  echo get_required_field_wrap($requiredfields, 'class', 'end');
							  } 
							  ?>
			              </td>
			              </tr>
				          <tr>
				            <td>Subjects: </td>
                            <td>
                            <div id="class-subjects">
                            Select a class to view applicable subjects
                            </div></td>
			              </tr>
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
					
					
					?>
                    
                            <input type="button" name="save" id="regstudents" value="Save" class="button"/></td>
			              </tr>
                          <?php } ?>
			            </table>            
            </form>
            
            </td>
            </tr>          
        </table>
</div>
</div>
<?php  
			#$page_list = array();
			if(!empty($page_list))
			{
				echo "<table width='100%' border='0' cellspacing='0' cellpadding='5'>
          	<tr>
			<td class='listheader' width='1%'>&nbsp;</td>
           	<td class='listheader' nowrap>Subject &nbsp;<a class='fancybox fancybox.ajax' href='".base_url()."curriculum/load_subject_form')' title='Click to add a subject'><img src='".base_url()."images/add_item.png' border='0'/></a></td>
			<td class='listheader' nowrap>Classes</td>
           	<td class='listheader' nowrap>Teachers</td>
			<td class='listheader' nowrap>Date Added</td>
			</tr>";	
	$counter = 0;	
	foreach($page_list AS $row)
	{
		#Get applicable classes
		$class_str = '';
		$classids = explode('|', $row['classes']);
		$classids = remove_empty_indices($classids);
		
		#Get number of teachers
		$num_of_teachers = get_subject_teachers($this, $row['id'])
							->num_rows();
		
		#Show in drop down if more than 1 class
		if(is_array($classids))
		{
		  if(count($classids) > 1){
			  foreach ($classids AS $key => $classid)
				  $class_str .= '<option>'.get_class_title($this, $classid).'</option>';
				  $class_str = '<select class="selectfield">'.$class_str.'</select>';
		  }
		  elseif(count($classids) > 0)
		  {
			  $class_str = get_class_title($this, $classids[1]);
		  }
		}
		else
		{
			$class_str = "N/A";
		}
		
		#Show one row at a time
		echo "<tr id='tr_".$row['id']."' class='listrow' style='".get_row_color($counter, 2)."'>
		<td class='leftListCell rightListCell' valign='middle' width='1%' nowrap>";
		
			#if(check_user_access($this,'delete_deal')){
				echo "<a href='javascript:void(0)' onclick=\"asynchDelete('".base_url()."curriculum/delete_subject/i/".encryptValue($row['id'])."', 'Are you sure you want to remove this subject? \\nThis operation can not be undone. \\nClick OK to confirm, \\nCancel to cancel this operation and stay on this page.', 'tr_".$row['id']."');\" title=\"Click to remove ".$row['subject']." from the school curriculum.\"><img src='".base_url()."images/delete.png' border='0'/></a>";
			#}
		
			#if(check_user_access($this,'update_deals')){
				echo " &nbsp;&nbsp; <a class='fancybox fancybox.ajax' href='".base_url()."curriculum/load_subject_form/i/".encryptValue($row['id'])."' title=\"Click to edit ".$row['subject']." details.\"><img src='".base_url()."images/edit.png' border='0'/></a>";
			#}
		
		
		 echo "</td>		
				<td valign='middle'>".$row['subject']."</td>		
				<td valign='middle'>".$class_str."</td>				
				<td valign='middle' nowrap><a class='fancybox fancybox.ajax' href='".base_url()."curriculum/manage_subject_teachers/i/".encryptValue($row['id'])."' title='Click to view teachers for ".$row['subject'].".'>".$num_of_teachers."</a> | <a title='Click to add teachers for ".$row['subject']."' class='fancybox fancybox.ajax' href='".base_url()."/curriculum/assign_teacher_form/i/".encryptValue($row['id'])."'>Assign a teacher</a></td>
				<td class='rightListCell' width='1%' valign='middle'>".date("j M, Y", GetTimeStamp($row['dateadded']))."</td>		
			</tr>";
		
		$counter++;
	}
	
		
	echo "<tr>
	<td colspan='5' align='right'  class='layer_table_pagination'>".
	pagination($this->session->userdata('search_total_results'), $rows_per_page, $current_list_page, base_url()."curriculum/manage_subjects/p/%d", 'results')
	."</td>
	</tr>
	</table>";	
			}
			else
			{
				echo "<div>No subjects have been added.<br /> Click <i><a class='fancybox fancybox.ajax' href='".base_url()."curriculum/load_subject_form')' title='Click to add a subject'>here</a></i> to add a subject.</div>";
			}
		
?>
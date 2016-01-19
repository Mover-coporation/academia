<table width="100" border="0" cellspacing="0" cellpadding="8">
      <tr>
        <td colspan="10" nowrap="nowrap"><div class="page-title"> Manage Gradebook</div></td>
  </tr>
      <tr>
        <td nowrap="nowrap" valign="top">
        <div id="current-term-gradebook">
            <?php 
				if(!empty($current_term)){ 
			?>
            	<div id="grade-term-title" class="ying_yang_bg" title="Click to view performance for current term subjects">
            <?php echo $current_term['term'].' ['.$current_term['year'].'] <i> - Current term</i>'; ?>
            </div>
            <ul>
			<?php 
				if(!empty($subjects))
				{
					foreach($subjects as $subject)
					{
						$num_of_students = $this->Query_reader->get_row_as_array('subject_num_of_students', array('subject'=>$subject['subjectid'], 'class'=>$subject['classid'], 'term'=>$current_term['id']));
						
						echo '<li id="grade_subject_'.$subject['subjectid'].'_'.$subject['classid'].'_'.$current_term['id'].'" class="ying_yang_bg">'.$subject['subjectname'].', '.$subject['classname'].' <i title="'.$num_of_students['numOfStudents'].' '.$subject['classname'].' students registered for '.$subject['subjectname'].'">('.$num_of_students['numOfStudents'].')</i></li>';
					}
				}
				else
				{
					echo '<li>No classes have been assigned to you.</li>';
				}
			?>
            </ul>
            
            <?php 
				}else{
					echo '<div>'.format_notice('WARNING: No active term').'</div>';
				}
			?>            
            </div>
        
        <div id="previous-term-gradebook">
        <div id="previous-terms-title" title="Click to view performance of previous terms" class="ying_yang_bg">Previous Terms</div>
        </div>
        </td>
        <td nowrap>&nbsp;</td>
        <td nowrap valign="top" width="100%">
        	<div id="grading-list">&nbsp;</div>
        </td>
      </tr>      
</table>
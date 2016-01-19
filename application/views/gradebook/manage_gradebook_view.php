<table width="100" border="0" cellspacing="0" cellpadding="8">
      <tr>
        <td colspan="10" nowrap="nowrap"><div class="page-title"> Manage Gradebook</div></td>
  </tr>
      <tr>
        <td nowrap="nowrap" valign="top">
        <div id="current-term-gradebook">
            <?php if(!empty($current_term)){ ?>
            	<div id="grade-term-title" class="ying_yang_bg" title="Click to view performance for current term subjects">
                    <?php

                    echo $current_term['term'].' ['.$current_term['year'].'] <i> - Current term</i>'; ?>
                </div>
                <ul>
                <?php
                    if(!empty($subjects))
                    {
                        foreach($subjects as $subject)
                        {
                         //   Query_reader->
                            $datdd =  $this->Query_reader->get_query_by_code('subject_num_of_students', array('subject'=> '|' . $subject['subjectid'] . '|', 'class'=>$subject['classid'], 'term'=>$current_term['id']));
                           # print_r($datdd); echo'<br/>';
                            $num_of_students = $this->Query_reader->get_row_as_array('subject_num_of_students', array('subject'=> '|' . $subject['subjectid'] . '|', 'class'=>$subject['classid'], 'term'=>$current_term['id']));
                            if($num_of_students['numOfStudents'] > 0)
                            echo '<li id="grade_subject_'.$subject['subjectid'].'_'.$subject['classid'].'_'.$current_term['id'].'" class="ying_yang_bg">'.$subject['subjectname'].', '.$subject['classname'].' <i title="'.$num_of_students['numOfStudents'].' '.$subject['classname'].' students registered for '.$subject['subjectname'].'">('.$num_of_students['numOfStudents'].')</i></li>';
                        }
                    }
                    else
                    {
                        echo '<li class="ying_yang_bg no_classes_assigned">No classes have been assigned to you.</li>';
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
            <div id="previous-terms-title" title="Click to view performance of previous terms" class="ying_yang_bg">
                <table cell-padding="0">
                    <tr>
                        <td>Previous Terms</td>
                        <td><div class="more_arrow"></div></td>
                    </tr>
                </table>
            </div>
            <?php
                if(!empty($terms)):
                    foreach($terms as $term):
                        if((!empty($current_term) && ($current_term['id'] != $term['id'])) || empty($current_term)):
                            echo '<div id="grade-term-' . $term['id'] . '" class="previous-term-sub-title ying_yang_bg" title="Click to view ' . $term['term'] . ' grades">'.
                                '<table cellpadding=0><tr>'.
                                '<td>' . $term['term'] . '</td>'.
                                '<td><div class="more_arrow"></div></td>'.
                                '</tr></table>'.
                                '</div><ul id="term-subjects-' . $term['id'] . '" class="term_subjects">';
                            if(!empty($subjects))
                            {
                                foreach($subjects as $subject)
                                {

                                    $num_of_students = $this->Query_reader->get_row_as_array('subject_num_of_students', array('subject'=> '|' . $subject['subjectid'] . '|', 'class'=>$subject['classid'], 'term'=>$term['id']));
                                    if( $num_of_students['numOfStudents'] > 0)
                                    echo '<li id="grade_subject_'.$subject['subjectid'].'_'.$subject['classid'].'_'.$term['id'].'" class="ying_yang_bg">'.$subject['subjectname'].', '.$subject['classname'].' <i title="'.$num_of_students['numOfStudents'].' '.$subject['classname'].' students registered for '.$subject['subjectname'].'">('.$num_of_students['numOfStudents'].')</i></li>';
                                }
                            }
                            else
                            {
                                echo '<li class="ying_yang_bg no_classes_assigned">No classes were assigned to you.</li>';
                            }
                            echo '</ul>';
                        endif;
                    endforeach;
                endif;
            ?>
        </div>
        </td>
        <td nowrap>&nbsp;</td>
        <td nowrap valign="top" width="100%">
        	<div id="grading-list">&nbsp;</div>
        </td>
      </tr>      
</table>
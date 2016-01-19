<table cellspacing="0" class="mark_sheet">
            	<?php
					if(!empty($page_list))
					{
						//list summary and instructions
						echo '<tr>'.
								'<td colspan="4">'.
								'<div id="mark-sheet-summary">'.
								'Showing '.count($page_list).' '.$class['class'].' students registered for '.$subject['subject'].'.<br /><br />'.
								format_notice('HELP:'.
								((!empty($exam['id']))? 'Click the mark or comment column for a student to edit/add their marks or comments': 
								'Select an exam to view or edit the marks.')).
								'</div>'.
								'</td>
							  </tr>';
						
						//list headers
						echo '<tr>
								<td class="listheader">Student</td>
								<td class="listheader">Mark</td>
								<td class="listheader">Comment</td>
								<td class="listheader">Grade</td>
							  </tr>';
							  
						//check if an exam has been selected
						if(!empty($exam['id']))
						{
							$counter = 0;	 
							$total_mark = 0;
							$average_mark = 0; 
						
							foreach($page_list as $row)
							{	
								$marks = '';
								$comments = '';	
								$mark_grade = array('grade'=>'', 'value'=>'');
								
								if(!empty($mark_sheet_data))
								{
									foreach($mark_sheet_data as $mark_sheet_data_key => $mark_sheet_data_value)
									{
										if($mark_sheet_data_value['student'] == $row['studentid'])
										{
											$marks = $mark_sheet_data_value['mark'];
											$comments = $mark_sheet_data_value['comment'];
											
											if(!empty($grading_scale_details))
											$mark_grade = get_grade($grading_scale_details, $marks);
											
											unset($mark_sheet_data[$mark_sheet_data_key]);
											
											$total_mark += $mark_sheet_data_value['mark'];
											
											break;
										}									
									}								
								}
							
								echo '<tr class="mark_sheet_row" id="student_grades_'.$row['studentid'].'" style="'.get_row_color($counter, 2).'">
										<td><div>'.$row['studentname'].'</div></td>
										<td>
										<div>
											<input name="students[std_'.$row['studentid'].'][marks]" value="'.$marks.'" id="marks_cell_'.$row['studentid'].'" type="text" size="2" maxlength="5" class="marks_cell" />
										</div>
										</td>
										<td>
										<div>
											<input name="students[std_'.$row['studentid'].'][comments]" value="'.$comments.'" id="comments_cell_'.$row['studentid'].'" type="text" class="comments_cell" />
										</div>
										<td>
										<div>
											<input type="text" readonly="readonly" class="grade_cell" value="'.$mark_grade['grade'].'" id="grade_cell_'.$row['studentid'].'" name="students[std_'.$row['studentid'].'][grade]" size="2" />
										</div>
										</td>
										</td>
									</tr>';
								
								$counter++;
							}
							
							//Format grading scale data
							$grading_scale_info = '';
							if(!empty($grading_scale_details))
							{
								$grading_scale_info = '<div><b>Grading scale details</b></div>'.
													  '<table cellpadding="5" cellspacing="0">'.
													  '<tr class="listheader">'.
													  	'<td>Range</td>'.
														'<td>Grade</td>'.
														'<td>Value</td>'.
													  '</tr>';
								
								$grade_counter = 0;					
								$js_grade_ranges = '';	  
								foreach($grading_scale_details as $grading_scale_detail)
								{
									$grading_scale_info .= '<tr id="grade_scale_row_'.$grading_scale_detail['id'].'" '.(($grade_counter%2==0)? 'class="stripe grade_scale_row"' : 'class="grade_scale_row"').'>'.
														   '<td>'.$grading_scale_detail['mingrade'].'-'.$grading_scale_detail['maxgrade'].'</td>'.
														   '<td>'.$grading_scale_detail['symbol'].'</td>'.
														   '<td>'.$grading_scale_detail['value'].'</td>'.
														   '</tr>';
														   
									$grade_counter++;
								}
								
								$grading_scale_info .= '</table>';
							}
							else
							{
								$grading_scale_info = '<div>'.format_notice('WARNING: No grading scale has been defined').'</div>';
							}
							
							$average_mark = number_format(($total_mark/$counter), 2);
							
							echo '<tr>'.
									'<td colspan="4">'.
										'<input type="hidden" name="sm" value="'.encryptValue('true').'" />'.
										'<input type="hidden" name="s" value="'.encryptValue($subject['id']).'" />'.
										'<input type="hidden" name="c" value="'.encryptValue($class['id']).'" />'.
										'<input type="hidden" name="e" value="'.((!empty($exam['id'])? encryptValue($exam['id']) : '')).'" />'.
									'</td></tr>'.
									
									//show averages
									'<tr>'.									
									'<td align="right"><b>Average Mark: </b></td>'.
									'<td colspan="3">'.
										'<input type="test" size="4" class="average_mark" readonly="readonly" value="'.$average_mark.'" id="average-mark" />'.
									'</td></tr>'.
								//nbsp
								 '<tr><td colspan="4">&nbsp;</td></tr>'.
								 '<tr><td colspan="4"><input type="button" value="Save" id="save-marks" class="button" /></td></tr>'.
								 '<tr><td colspan="4">&nbsp;</td></tr>'.
								 '<tr><td colspan="4">'.
								 $grading_scale_info.								 
								 '</td></tr>';
						}
						else
						{							
							$counter = 0;	  
						
							foreach($page_list as $row)
							{	
								echo '<tr class="mark_sheet_row" id="student_grades_'.$row['studentid'].'" style="'.get_row_color($counter, 2).'">
										<td colspan="4"><div>'.$row['studentname'].'</div></td>
									 </tr>';
								
								$counter++;
							}
						}						
												
					}
					else
					{
						echo '<tr><td colspan="3">'.format_notice('WARNING: No '.$class['class'].' students have been registered for '.$subject['subject'].' in '.$term['term'].', '.$term['year']).'</td></tr>';
					}
				?>
            </table>
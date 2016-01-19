<form name="mark_sheet_form" id="mark-sheet-form" method="post">
<table width="100%" border="0" cellspacing="0" cellpadding="8">
      <tr>
        <td nowrap="nowrap" width="100%" style="width:100%">
        	<ul class="list_summary">
            	<li>
                	<div class="label">Class:</div>
                	<div class="label_value"><?php echo $class['class']; ?></div>    
                </li>
                <li>
                	<div class="label">Subject:</div>
                	<div class="label_value"><?php echo $subject['subject']; ?></div>
                </li>
                <li>
                	<div class="label">Term:</div>
                	<div class="label_value"><?php echo $term['term'].', '.$term['year']; ?></div>
                </li>
                
                <li>
                	<div class="label">Exam:</div>
                	<div class="label_value">
					<select name="term" id="select-marksheet-exam"  class="selectfield"> <?php echo get_select_options($exams, 'id', 'exam','','Y','Select exam') ?>
                    </select>
                    <input type="hidden" id="cste" value="<?php echo $class['id'].'^'.$subject['id'].'^'.$term['id'] ?>" />
                    </div>
                </li>
                <div style="clear: both;"></div>
            </ul>
        </td>
  	 </tr>
      <tr>
        <td align="left" nowrap="nowrap" valign="top">
        <div id="mark-sheet-result">&nbsp;</div>
        	<div id="mark-sheet">
            	<?php $this->load->view('gradebook/mark_sheet_view'); ?>
            </div>        	
        </td>
      </tr>
</table>
</form>
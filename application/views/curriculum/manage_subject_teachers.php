<div id="results">
<table border="0" cellspacing="0" width="100%" cellpadding="5" align="center">
  <tr>
    <td valign="top" style="padding:0">&nbsp;</td>
    <td valign="top" style="padding:0">
        <table border="0" cellspacing="0" cellpadding="10" width="100%" id='contenttable'>
          <tr>
            <td colspan="2" style="padding-top:0px;" class="pageheader">
            	<table>
          		<tr>
            		<td valign="middle"><div class="page-title"><?php echo 'Manage '.$subject_details['subject'].' teachers' ?></div></td>
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
            <?php
				if(count($teachers))
				{
					$counter = 0;
					echo '<table cellpadding="5">
						 	<tr class="listheader">
							<td></td>
							<td align="left" >Teacher</td>
							<td align="left" >Class</td>
							</tr>';
							
					foreach($teachers as $teacher)
					{
						echo '<tr style=\''.get_row_color($counter, 2).'\'>'.
							 '<td><a href="javascript:void(0)" onclick="confirmDeleteEntity(\''.base_url().'curriculum/delete_subject/i/'.encryptValue($teacher['assignmentid']).'\', \'Are you sure you want to remove this teacher? \\nThis operation can not be undone. \\nClick OK to confirm, \\nCancel to cancel this operation and stay on this page.\');" title="Click to remove "'.$teacher['teacher'].'"><img src="'.base_url().'images/delete.png" border=0 /></a></td>'.
							 '<td align="left">'.$teacher['teacher'].'</td>'.
							 '<td align="left" >'.$teacher['class'].'</td>'.
							 '</tr>';
						
						$counter++;
					}
								
				 	echo '</table>';
				}
				else
				{
					echo 'No teachers have been assigned for '.$subject_details['subject'];
				}
			?>
            
            </td>
            </tr>
          
        </table>
	</td>
  </tr>
</table>
</div>
        <table border="0" cellspacing="0" cellpadding="10" width="100%" id='contenttable'>
          <tr>
            <td colspan="2" style="padding-top:0px;">
            <ul class="page-links clear">
            <a href="javascript:void(0)" onclick="updateFieldLayer('<?php echo base_url().'curriculum/manage_subjects';?>','','','results','Please enter the required fields.');addRemoveClass('active', 'manage-curriculum', 'manage-terms<>manage-exams<>manage-grading<>manage-classes')">
            	<li id="manage-curriculum" class="active">Curriculum</li>
            </a>
            <a href="javascript:void(0)" onclick="updateFieldLayer('<?php echo base_url().'grading/manage_grading';?>','','','results','Please enter the required fields.');addRemoveClass('active', 'manage-grading', 'manage-terms<>manage-exams<>manage-classes<>manage-curriculum')">
            <li id="manage-grading">Grading</li>
            </a>
            <a href="javascript:void(0)" onclick="updateFieldLayer('<?php echo base_url().'exams/manage_exams';?>','','','results','Please enter the required fields.');addRemoveClass('active', 'manage-exams', 'manage-terms<>manage-classes<>manage-grading<>manage-curriculum')">
            <li id="manage-exams">Exams</li>
            </a>
            <a href="javascript:void(0)" onclick="updateFieldLayer('<?php echo base_url().'terms/manage_terms';?>','','','results','Please enter the required fields.');addRemoveClass('active', 'manage-terms', 'manage-classes<>manage-exams<>manage-grading<>manage-curriculum')">
            	<li id="manage-terms">Terms</li>
            </a>
            <a href="javascript:void(0)" onclick="updateFieldLayer('<?php echo base_url().'classes/manage_classes';?>','','','results','Please enter the required fields.');addRemoveClass('active', 'manage-classes', 'manage-terms<>manage-exams<>manage-grading<>manage-curriculum')">
            	<li id="manage-classes">Classes</li>
            </a>
            </ul>
            </td>
          </tr>
            
 <?php   
if(isset($msg)){
	echo "<tr><td colspan='4'>".format_notice($msg)."</td></tr>";
}
?>           
            
          <tr>
            <td valign="top">
            <div id="results">
            <?php 
			$this->load->view('curriculum/manage_subjects_view', array('page_list'=>$page_list)); 
			?>
            </div>
              
            </td>
            </tr>
          
        </table>
	
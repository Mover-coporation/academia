        <table border="0" cellspacing="0" cellpadding="10" width="100%" id='contenttable'>
          <tr>
            <td colspan="2" style="padding-top:0px;">
            <ul class="page-links clear">
            <a href="javascript:void(0)" onclick="updateFieldLayer('<?php echo base_url().'finances/manage_fee_structure';?>','','','results','Please enter the required fields.');">
            	<li id="manage-fees-structure" class="active">Fees Structure</li>
            </a>
            <a href="javascript:void(0)" onclick="updateFieldLayer('<?php echo base_url().'finances/student_accounts_overview';?>','','','results','Please enter the required fields.');">
            <li id="student-accounts-overview">Student Accounts Overview</li>
            </a>
            <a href="javascript:void(0)" onclick="updateFieldLayer('<?php echo base_url().'finances/school_accounts';?>','','','results','Please enter the required fields.');">
            <li id="school-accounts">School Accounts</li>
            </a>
            <a href="javascript:void(0)" onclick="updateFieldLayer('<?php echo base_url().'finances/manage_petty_cash_book';?>','','','results','Please enter the required fields.');startapp=0;">
            <li id="manage-petty-cash">Petty Cash Book</li>
            </a>
 <a href="javascript:void(0)" onclick="updateFieldLayer('<?php echo base_url().'finances/manage_donations';?>','','','results','Please enter the required fields.');">
            <li id="manage-donations">Donations</li>
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
			$this->load->view('finances/manage_fees_structure', array('page_list'=>$page_list)); 
			?>
            </div>
              
            </td>
            </tr>
</table>
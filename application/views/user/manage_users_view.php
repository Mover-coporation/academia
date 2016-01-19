        <table border="0" cellspacing="0" cellpadding="10" width="100%" id='contenttable'>
          <tr>
            <td colspan="2" style="padding-top:0px;">
            <ul class="page-links clear">
            <a href="javascript:void(0)" onclick="updateFieldLayer('<?php echo base_url().'user/manage_staff';?>','','','results','Please enter the required fields.');">
            	<li id="sub-manage-users" class="active">Users</li>
            </a>
            <a href="javascript:void(0)" onclick="updateFieldLayer('<?php echo base_url().'user/manage_staff_groups';?>','','','results','Please enter the required fields.');">
            <li id="manage-user-groups">User Groups</li>
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
			$this->load->view('user/manage_staff_view', array('page_list'=>$page_list)); 
			?>
            </div>
              
            </td>
            </tr>
          
        </table>
	
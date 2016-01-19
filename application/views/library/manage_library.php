
        <table border="0" cellspacing="0" cellpadding="10" width="100%" id='contenttable'>
          <tr>
            <td colspan="2" style="padding-top:0px;">
            <ul class="page-links clear">
            <a href="javascript:void(0)" onclick="updateFieldLayer('<?php echo base_url().'library/manage_library';?>','','','results','Please enter the required fields.');">
                <li id="manage-stock" class="active">Inventory</li>
            </a>
            <!-- <a href="javascript:void(0)" onclick="updateFieldLayer('<?php
            //echo base_url().'library/manage_borrowers';?>','','','results','Please enter the required fields.');addRemoveClass('active', 'manage-borrowers', 'manage-stock<>manage-returns')"> -->
            <a href="javascript:void(0)" onclick="updateFieldLayer('<?php echo base_url().'library/inventory_status';?>','','','results','Please enter the required fields.');">
            <li id="manage-borrowers">Inventory Status</li>
            </a>
            <!--
            <a href="javascript:void(0)" onclick="updateFieldLayer('<?php //echo base_url().'library/manage_borrowers';?>','','','results','Please enter the required fields.');addRemoveClass('active', 'manage-returns', 'manage-stock<>manage-borrowers')">
            <li id="manage-returns">Returns</li>
            </a> -->
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
			$this->load->view('library/manage_stock_view', array('page_list'=>$page_list));
			?>
            </div>

            </td>
            </tr>
</table>
<div class="content">
        <table border="0" cellspacing="0" cellpadding="10" width="100%" id='contenttable'>            
 <?php   
if(isset($msg)){
	echo "<tr><td colspan='4'>".format_notice($msg)."</td></tr>";
}
?>           
            
          <tr>
          
          <tr>
          <td colspan="2">
          <table width="100%">
          <tr>
    		<td width="50%">
    <div class="search_container clear" style="width:100%">
    <input name="search" placeholder="Search.." type="text" id="search" size="35" class="search_box" value="" onkeyup="startInstantSearch('search', 'searchby', '<?php echo base_url();?>search/load_results/type/sponsors/layer/searchresults')" onkeypress="return handleEnter(this, event)"/>
    
    <div class="search_button"></div>
    </div>
    </td>
    
    		<td>&nbsp;<input name="searchby" type="hidden" id="searchby" value="firstname__lastname" />
    </td>
    	  </tr>
          
    	  </table>
		 </td>
          </tr>
          <tr>
            <td valign="top">
            
            <div id="searchresults">
            <?php  
			#$page_list = array();
			if(!empty($page_list))
			{
				echo "<table width='100%' border='0' cellspacing='0' cellpadding='5'>
          	<tr>
			<td class='listheader' width='1%'>&nbsp;</td>
           	<td class='listheader' nowrap>Sponsor &nbsp;<a class='fancybox fancybox.ajax' href='".base_url()."sponsors/load_sponsor_form' title='Click to add a sponsor'><img src='".base_url()."images/add_item.png' border='0'/></a></td>
			<td class='listheader' nowrap>Email Address</td>
           	<td class='listheader' nowrap>Students sponsored</td>".
			"<td class='listheader' nowrap>Date Added</td>
			</tr>";	
	$counter = 0;	
	foreach($page_list AS $row)
	{
		#Show one row at a time
						
		echo "<tr class='listrow' style='".get_row_color($counter, 2)."'>
		<td class='leftListCell rightListCell' valign='top' nowrap>";
		
		#if(check_user_access($this,'delete_deal')){
		echo "<input class=\"list_checkbox\" type=\"checkbox\" name=\"selected_student[]\" id=\"selected_student_".$row['sponsorid']."\" />";
			#}
				
			#if(check_user_access($this,'delete_deal')){
		echo "&nbsp;&nbsp;<a href='javascript:void(0)' onclick=\"confirmDeleteEntity('".base_url()."students/delete_student/i/".encryptValue($row['sponsorid'])."', 'Are you sure you want to delete this student? \\nThis operation can not be undone. \\nClick OK to confirm, \\nCancel to cancel this operation and stay on this page.');\" title=\"Click to remove this student.\"><img src='".base_url()."images/delete.png' border='0'/></a>";
			
		 echo "</td>		
		<td valign='top' id='row_sponsor_name_".$row['sponsorid']."'><a class='fancybox fancybox.ajax' href='".base_url()."sponsors/load_sponsor_form/i/".encryptValue($row['sponsorid'])."' title=\"Click to edit ".$row['firstname']."'s details.\">".$row['firstname']." ".$row['lastname']."</a></td>		
		<td valign='top'>".$row['emailaddress']."</td>
		<td valign='top' nowrap></td>".			
		"<td class='rightListCell' valign='top'>".date("j M, Y", GetTimeStamp($row['dateadded']))."</td>		
		</tr>";
		
		$counter++;
	}
	
		
	echo "<tr>
	  	 <td colspan='7' align='right'  class='layer_table_pagination'>".
			pagination($this->session->userdata('search_total_results'), $rows_per_page, $current_list_page, base_url(). "students/manage_sponsors/p/%d", 'searchresults')
		."</td>
		</tr>
		</table>";	
			}
			else
			{
				echo "<div>No sponsors have been added. Click <a class='fancybox fancybox.ajax' href='".base_url()."sponsors/load_sponsor_form')' title='Click to add a sponsor'><i>here</i></a> to add a sponsor</div>";
			}
		
		?>
           </div> 
            
            </td>
            </tr>
          
        </table>
</div>
<div class="content">
	<table border="0" cellspacing="0" cellpadding="10" width="100%" id='contenttable'>          
 <?php   
if(isset($msg)){
	echo "<tr><td colspan='4'>".format_notice($msg)."</td></tr>";
}
?>           
            
          <tr>
            <td valign="top">
            <div id="student_account_details">
            </div>
            
            <div id="student_accounts_list">
            	<?php  
				  #$page_list = array();
				  if(!empty($page_list))
				  {
					  echo "<table width='100%' border='0' cellspacing='0' cellpadding='5'>
							  <tr>
							  <td class='listheader'>&nbsp;</td>
							  <td class='listheader'>Student</td>
							  <td class='listheader' nowrap>Current Class</td>
							  <td class='listheader' nowrap align='right'>Total Debit</td>
							  <td class='listheader' nowrap align='right'>Total Credit</td>
							  <td class='listheader' nowrap align='right'>Balance</td>
							  </tr>";	
					  $counter = 0;
					  $total_debit = 0;
					  $total_credit = 0;
					  
					  foreach($page_list AS $row)
					  {
						  $total_debit += $row['studentdebit'];
						  $total_credit += $row['studentcredit']; 
						  $studentclass = current_class($this, $row['studentid']);	
						  echo "<tr class='listrow ".(($counter%2)? '' : 'grey_list_row')."'>
						  <td class='leftListCell rightListCell' valign='top' nowrap>";
						  
							  #if(check_user_access($this,'update_deals')){
								  echo " &nbsp;&nbsp; <a onClick=\"updateFieldLayer('".base_url()."students/get_student_finances/i/" . encryptValue($row['studentid']) . "','','','student_account_details','');hideTbody('student_accounts_list');\" href='javascript:void(0)' title=\"Click to view ".$row['firstname']."'s financial details.\"><img src='".base_url()."images/details.png' border='0'/></a>";
							  #}
						  
						  
						   echo "</td>		
								  <td valign='top'>".$row['firstname']." ".$row['lastname']."</td>
								  <td valign='top'>".$studentclass['class']."</td>		
								  <td valign='top' align='right'>".number_format($row['studentdebit'],0,'.',',')."</td>
								  <td valign='top' align='right'>".number_format($row['studentcredit'],0,'.',',')."</td>				
								  <td valign='top' class='rightListCell' nowrap align='right'>".number_format(($row['studentcredit'] - $row['studentdebit']),0,'.',',')."</td>	
							  </tr>";
						  
						  $counter++;
					  }
		  
					  echo "<tr>
							<td colspan='3'></td>
							<td><div class='sum'>".number_format($total_debit,0,'.',',')."</div></td>
							<td><div class='sum'>".number_format($total_credit,0,'.',',')."</div></td>
							<td style='padding-right:0'><div class='sum'>".number_format(-($total_debit - $total_credit),0,'.',',')."</div></td>
						   </tr>";
						  
					  echo "<tr>
					  <td colspan='6' align='right'  class='layer_table_pagination'>".
					  pagination($this->session->userdata('search_total_results'), $rows_per_page, $current_list_page, base_url()."finances/student_accounts_overview/p/%d")
					  ."</td>
					  </tr>
					  </table>";	
				  }
				  else
				  {
					  echo "<div>No transactions have been added.</div";
				  }
			  
			  ?>
            </div>
            </td>
            </tr>
          
        </table>
</div>
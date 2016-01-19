<div class="content">
    <table border="0" cellspacing="0" cellpadding="10" width="100%" id='contenttable'>    
    <tr>
    	<td colspan="4">
        	    <a class="grey_buttons fancybox fancybox.ajax" href="<?php echo base_url() . 'finances/load_transaction_form/tt/' . encryptValue('CR'); ?>">Replenish</a>
                  &nbsp;<a class="grey_buttons fancybox fancybox.ajax" href="<?php echo base_url() . 'finances/load_transaction_form/tt/' . encryptValue('DR'); ?>" title="Click to spend">Spend</a>
                  &nbsp;<a class="grey_buttons fancybox fancybox.ajax" href="<?php echo base_url(); ?>finances/load_account_form" title="Click to add accounts">Create Account</a>
                  &nbsp;<a class="grey_buttons" href="#" id="petty-cash-book-reload">Reload</a>  
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
        #$page_list = array();
        if(!empty($page_list))
        {
            echo "<table width='100%' border='0' cellspacing='0' cellpadding='5'>
        <tr>
        <td class='listheader' width='1%'>&nbsp;</td>
        <td class='listheader' nowrap>Date</td>
        <td class='listheader' nowrap>Account</td>
        <td class='listheader' nowrap>Details</td>
        <td class='listheader' align='right' nowrap>Debit</td>
        <td class='listheader' align='right' nowrap>Credit</td>
        <td class='listheader' align='right' nowrap>Balance</td>
        </tr>";	

		$counter = 0;
		$total_debit = 0;
		$total_credit =	0;
		$balance = 0;

foreach($page_list AS $row)
{
    #Get the account title
    $account_info = get_db_object_details($this, 'accounts', $row['account']);
	
	#total debit
	if($row['cr_dr'] == 'CR') $total_credit += $row['amount'];
	
	#total credit
	if($row['cr_dr'] == 'DR') $total_debit += $row['amount'];
	
	$balance = $total_credit - $total_debit;
	   
    #Show one row at a time
    echo "<tr class='listrow' style='".get_row_color($counter, 2)."'>
    <td class='leftListCell rightListCell' valign='top' nowrap>";
    
        #if(check_user_access($this,'delete_deal')){
            echo "<a href='javascript:void(0)' onclick=\"confirmDeleteEntity('".base_url()."finances/delete_transaction/i/".encryptValue($row['transid'])."', 'Are you sure you want to remove this fee? \\nThis operation can not be undone. \\nClick OK to confirm, \\nCancel to cancel this operation and stay on this page.');\" title=\"Click to remove this fee.\"><img src='".base_url()."images/delete.png' border='0'/></a>";
        #}
    
        #if(check_user_access($this,'update_deals')){
            echo " &nbsp;&nbsp; <a href='".base_url()."finances/load_transaction_form/i/".encryptValue($row['transid'])."' title=\"Click to edit this fee details.\"><img src='".base_url()."images/edit.png' border='0'/></a>";
        #}
    
    
     echo "</td>		
            <td valign='top'>".date("j M, Y", GetTimeStamp($row['dateadded']))."</td>		
            <td valign='top'>".$account_info['title']."</td>
            <td valign='top'>".$row['particulars']."</td>				
            <td valign='top' class='number_format' align='right' nowrap>".
				(($row['cr_dr'] == 'DR')? number_format($row['amount'], 0, '.', ',') : '').
			"</td>		
            <td valign='top' class='number_format' align='right' nowrap>".
				(($row['cr_dr'] == 'CR')? number_format($row['amount'], 0, '.', ',') : '').
			"</td>
            <td class='rightListCell number_format' valign='top' align='right' nowrap>". number_format($balance, 0, '.', ',') . "</td>		
        </tr>";
    
    $counter++;
}

    
echo "<tr>
<td colspan='5' align='right'  class='layer_table_pagination'>".
pagination($this->session->userdata('search_total_results'), $rows_per_page, $current_list_page, base_url()."finances/manage_petty_cash_book/p/%d")
."</td>
</tr>
</table>";	
        }
        else
        {
            echo "<div>No transactions have been added.</div>";
        }
    
    ?>
        
        
        </td>
        </tr>
      
    </table>
</div>
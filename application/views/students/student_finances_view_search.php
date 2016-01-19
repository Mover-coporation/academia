
<table border="0" cellspacing="0" cellpadding="5" class="datepicker" width="100%" id='contenttable'>


    <?php
    if(isset($msg)){
        echo "<tr><td colspan='4'>".format_notice($msg)."</td></tr>";
    }
    ?>

    <tr>
        <td valign="top">

                <div id="result">

                    <?php
                    #$page_list = array();
                    if(!empty($page_list))
                    {
                        echo "<table width='100%' border='0' cellspacing='0' cellpadding='5'>
          	<tr>
			<td class='listheader'>&nbsp;</td>
			<td class='listheader'>Date</td>
           	<td class='listheader' nowrap>Particulars </td>
			<td class='listheader' nowrap align='right'>Debit</td>
			<td class='listheader' nowrap align='right'>Credit</td>
           	<td class='listheader' nowrap align='right'>Balance</td>
			</tr>";
                        $counter = 0;
                        $balance = 0;
                        $total_debit = 0;
                        $total_credit = 0;
                        foreach($page_list AS $row)
                        {
                            #Show one row at a time
                            if($row['type'] == 'DEBIT'){
                                $debit = $row['amount'];
                                $credit = 0;
                                $balance -= $debit;
                                $total_debit += $debit;
                            }
                            else
                            {
                                $debit = 0;
                                $credit = $row['amount'];
                                $balance += $credit;
                                $total_credit += $credit;
                            }

                            $fee = get_fee_lines($this, $row['fee']);

                            echo "<tr class='listrow' style='".get_row_color($counter, 2, 'row_borders')."'>
		<td valign='top' nowrap>";

                            if(check_user_access($this,'delete_deal')){
                                echo "<a href='javascript:void(0)' onclick=\"confirmDeleteEntity('".base_url()."finances/delete_fee/i/".encryptValue($row['id'])."', 'Are you sure you want to remove this fee? \\nThis operation can not be undone. \\nClick OK to confirm, \\nCancel to cancel this operation and stay on this page.');\" title=\"Click to remove this fee.\"><img src='".base_url()."images/delete.png' border='0'/></a>";
                            }

                            #if(check_user_access($this,'update_deals')){
                            echo " &nbsp;&nbsp; <a href='#' title=\"Click to print this transaction details.\"><img src='".base_url()."images/small_pdf.png' border='0'/></a>";
                            #}


                            echo "</td>
		 		<td valign='top'>".date("j M, Y", GetTimeStamp($row['dateadded']))."</td>
				<td valign='top'>".$fee['fee']."</td>
				<td valign='top' nowrap align='right'>".number_format($debit,0,'.',',')."</td>
				<td valign='top' nowrap align='right'>".number_format($credit,0,'.',',')."</td>
				<td valign='top' nowrap align='right'>".number_format($balance,0,'.',',')."</td>
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
                            pagination($this->session->userdata('search_total_results'), $rows_per_page, $current_list_page, base_url()."classes/manage_classes/p/%d")
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

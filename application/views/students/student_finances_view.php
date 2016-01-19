
<table border="0" cellspacing="0" cellpadding="10" class="datepicker" width="100%" id='contenttable'>
          <tr>
            <td colspan="2" style="padding-top:0px;" class="pageheader">

            	<table>
          		<tr>
            		<td valign="middle"><div class="small-page-title" id="printreport"> Financial Statement</div></td>
            		<td valign="middle"><a href='javascript:mailed();' title="Click to print <?php echo $studentdetails['firstname']; ?> financial statement"><img src='<?php echo base_url()."images/small_pdf.png"; ?>' border='0'/></a></td>
                    <td>&nbsp;&nbsp;</td>
                    <td valign="middle"><a class="fancybox fancybox.ajax"  href="<?php echo base_url()?>finances/load_credit_form/s/<?php echo encryptValue($studentdetails['id']) ?>"  title="Click to credit <?php echo $studentdetails['firstname']; ?>'s account"><img src='<?php echo base_url(); ?>images/credit.jpg' border='0'/></a></td>
                    <td>&nbsp;&nbsp;</td>
                    <td valign="middle"><a  class="fancybox fancybox.ajax" href="<?php echo base_url(); ?>finances/load_debit_form/s/<?php echo encryptValue($studentdetails['id']); ?> " title="Click to debit<?php echo $studentdetails['firstname']; ?>'s account"><img src='<?php echo base_url() ?>images/debit.jpg' border='0'/></a></td>
<td>


                </tr>

          </table>

    <tr>
        <td colspan="0" >
            <input type="text" class="textfield " name="financial-search" id="financial_search" size="35" value="" placeholder="Search For Financial Statement "  style="float:left;" onkeyup="searchfinancial_statment('<?php echo encryptValue($studentdetails['id']) ?>');">

            <input type="text" name="startdate" id="startdate" class="textfield manyyearsdatefield datepicker" size="15" value=""  style="float:left;"  onchange="searchfinancial_statment('<?php echo encryptValue($studentdetails['id']) ?>');">
            <input type="text" name="enddate" id="enddate" class="textfield manyyearsdatefield datepicker" size="15" value="" style="float:left;" onchange="searchfinancial_statment('<?php echo encryptValue($studentdetails['id']) ?>');">
            <div id="add-image" class="button     hover" style="width:30px; margin: 5px; text-align:center; float:left; margin-top:0px;" onclick="searchfinancial_statment('<?php echo encryptValue($studentdetails['id']) ?>');">
               GO
            </div>
        </td>
          </tr>
			</td>
          </tr>

 <?php
if(isset($msg)){
	echo "<tr><td colspan='4'>".format_notice($msg)."</td></tr>";
}
?>

          <tr>
            <td valign="top">
            <div  id="printreport">
            <div style="display:block; text-align: left;" >    <?php


                    $name  = $studentdetails['firstname'].'&nbsp;'.$studentdetails['lastname'];

                echo 'Student Name : '.$name;
                ?>
            </div>
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
            </div></td>
            </tr>

        </table>

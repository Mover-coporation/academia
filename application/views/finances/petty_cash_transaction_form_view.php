<?php
if(empty($requiredfields)){
	$requiredfields = array();
}

$indicator = (!empty($isview))? "": "<span class='redtext'>*</span>";?>
<div class="content" id="transaction-results">
        <table border="0" cellspacing="0" cellpadding="10" width="100%" id='contenttable'>
          <tr>
            <td colspan="2" style="padding-top:0px;" class="pageheader">
            	<table>
          		<tr>
            		<td valign="middle">
                    	<div class="page-title">
                        	<?php echo ((decryptValue($tt) == 'CR')? 'Income Details' : 'Expense Details'); ?>
                    </div></td>
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
            <form id="form1" name="form1" method="post" >
            
            <table width="100" border="0" cellspacing="0" cellpadding="8">
				  <tr>
                    <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">Voucher No:<?php echo $indicator;?></td>
                    <td class="field" nowrap>
                      <?php  
			if(!empty($isview))
			{
				echo "<span class='viewtext'>".$transactiondetails['reference']."</span>";
			}else{
					echo get_required_field_wrap($requiredfields, 'reference');
					?>
                      <input type="text" name="reference" id="reference" class="textfield" size="30" value="<?php 
				  if(!empty($transactiondetails['reference'])){
				 	 echo $transactiondetails['reference'];
				  }?>"/>
                      <?php  echo get_required_field_wrap($requiredfields, 'reference', 'end');
			}
				  ?>
                    </td>
                    </tr>
                    <tr>
                    <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">Date:<?php echo $indicator;?></td>
                    <td class="field" nowrap>
                      <?php if(!empty($isview))
			{
				echo "<span class='viewtext'>".$transactiondetails['date']."</span>";
			}else{
				echo get_required_field_wrap($requiredfields, 'date');
                    ?>
                      <input type="text" name="date" id="date" class="textfield datepicker" size="30" value="<?php 
				  if(!empty($transactiondetails['date'])){
				 	 echo $transactiondetails['date'];
				  }?>"/>
                      <?php  echo get_required_field_wrap($requiredfields, 'date', 'end');
			}
				  ?>
                   </td>
                  </tr>
                  <tr>
                    <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">Item:<?php echo $indicator;?></td>
                    <td class="field" nowrap>
                      <?php if(!empty($isview))
			{
				echo "<span class='viewtext'>".$transactiondetails['rank']."</span>";
			}else{
				echo get_required_field_wrap($requiredfields, 'rank');
                    ?>
                      <select name="account" id="account"  class="selectfield"> <?php echo get_select_options($accounts, 'id', 'title', (!empty($formdata['title']))? $formdata['title'] : '','Y','Select Account') ?>
                    </select>
                      <?php  echo get_required_field_wrap($requiredfields, 'rank', 'end');
			}
				  ?>
                   </td>
                  </tr>
                  <tr>
                    <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">Notes:</td>
                    <td class="field" nowrap>
                      <?php if(!empty($isview))
			{
				echo "<span class='viewtext'>".$transactiondetails['particulars']."</span>";
			}else{
                    ?>
                      <textarea rows="2" cols="28" name="particulars" id="particulars" class="richtextfield" size="30"> <?php 
				  if(!empty($transactiondetails['particulars'])){
				 	 echo $transactiondetails['particulars'];
				  }?></textarea>
                      <?php  
			}
				  ?>
                   </td>
                  </tr>
                  <tr>
                    <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">Amount:<?php echo $indicator;?></td>
                    <td class="field" nowrap>
                      <?php if(!empty($isview))
			{
				echo "<span class='viewtext'>".$transactiondetails['amount']."</span>";
			}else{
				echo get_required_field_wrap($requiredfields, 'amount');
                    ?>
                      <input type="text" name="amount" id="amount" class="textfield" size="30" value="<?php 
				  if(!empty($transactiondetails['amount'])){
				 	 echo $transactiondetails['amount'];
				  }?>"/>
                      <?php  echo get_required_field_wrap($requiredfields, 'amount', 'end');
			}
				  ?>
                   </td>
                  </tr>
                  <?php  if(empty($isview)){ ?>
				  <tr>
                    <td><?php if(!empty($i) || !empty($editid)){?><input name="editid" type="hidden" id="editid" value="<?php 
					if(!empty($i)){
						echo decryptValue($i);
					} else {
						echo $editid;
					}?>"/>
					<?php } ?></td>
                    <td>
                    <input type="button" onclick="saveTransaction('<?php echo ((!empty($i))? '/i/'.$i : '') . '/tt/' . $tt;?>', 'reference<>date<>account<>*particulars<>amount<>save<?php if(!empty($i) || !empty($editid)) echo '<>editid' ?>')" name="save" id="save" value="Save" class="button"/></td>
                    </tr>
                  <?php } ?>
                </table>
            
            </form>
            
            </td>
            </tr>
          
        </table>
    </div>
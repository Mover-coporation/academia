<?php /* Smarty version 2.6.18, created on 2010-07-05 13:21:50
         compiled from odcnotification.tpl */ ?>
<table>
   <tr>
      <td><?php echo $this->_tpl_vars['employee']; ?>
, <br>
         <br></td>
   </tr>
   <tr>
      <td><?php echo $this->_tpl_vars['message']; ?>
</td>
   </tr>
   <tr>
      <td><table>
            <tr>
               <td
align = "left" class = "titleheader" colspan =
"2"><hr>
                  Other Direct Cost
                  Information
                  <hr></td>
            </tr>
            <tr>
               <td align="right"
nowrap><span class = "label">Job
                  Number:</span></td>
               <td align="LEFT"> <?php echo $this->_tpl_vars['jobnumber']; ?>
</td>
            </tr>
            <tr>
               <td align="right"
nowrap><span class = "label">Cost
                  Center:</span></td>
               <td align="LEFT"> <?php echo $this->_tpl_vars['costcentercode']; ?>
</td>
            </tr>
            <tr>
               <td align="right"
nowrap><span class = "label">Activity: </span></td>
               <td align="LEFT"> <?php echo $this->_tpl_vars['activity']; ?>
</td>
            </tr>
            <tr>
               <td align="right" nowrap><span class =
"label">Transaction Date:</span></td>
               <td
align="LEFT"><?php echo $this->_tpl_vars['transactiondate']; ?>
</td>
            </tr>
            <tr>
               <td
align="right" nowrap><span class =
"label">Amount:</span></td>
               <td align="LEFT"> <?php echo $this->_tpl_vars['amount']; ?>
</td>
            </tr>
            <tr>
               <td align="right"
nowrap><span class =
"label">Description:</span></td>
               <td align="LEFT"> <?php echo $this->_tpl_vars['description']; ?>
</td>
            </tr>
				<?php if ($this->_tpl_vars['status'] == Approved || $this->_tpl_vars['status'] == Rejected): ?> 	
            <tr>
               <td align="right"
nowrap><span class="label">Status Message:</span></td>
               <td align="LEFT"><?php echo $this->_tpl_vars['statusmessage']; ?>
</td>
            </tr>
				<?php endif; ?>
            <tr>
               <td align = "left" class =
"titleheader" colspan =
"2"><hr></td>
            </tr>
      </table></td>
   </tr>
   <tr>
      <td><br></td>
   </tr>
</table>
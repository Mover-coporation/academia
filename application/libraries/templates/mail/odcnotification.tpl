<table>
   <tr>
      <td>{$employee}, <br>
         <br></td>
   </tr>
   <tr>
      <td>{$message}</td>
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
               <td align="LEFT"> {$jobnumber}</td>
            </tr>
            <tr>
               <td align="right"
nowrap><span class = "label">Cost
                  Center:</span></td>
               <td align="LEFT"> {$costcentercode}</td>
            </tr>
            <tr>
               <td align="right"
nowrap><span class = "label">Activity: </span></td>
               <td align="LEFT"> {$activity}</td>
            </tr>
            <tr>
               <td align="right" nowrap><span class =
"label">Transaction Date:</span></td>
               <td
align="LEFT">{$transactiondate}</td>
            </tr>
            <tr>
               <td
align="right" nowrap><span class =
"label">Amount:</span></td>
               <td align="LEFT"> {$amount}</td>
            </tr>
            <tr>
               <td align="right"
nowrap><span class =
"label">Description:</span></td>
               <td align="LEFT"> {$description}</td>
            </tr>
				{if $status == Approved || $status == Rejected} 	
            <tr>
               <td align="right"
nowrap><span class="label">Status Message:</span></td>
               <td align="LEFT">{$statusmessage}</td>
            </tr>
				{/if}
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

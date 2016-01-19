<table width="100%" border="0" cellspacing="0" cellpadding="2">
  {if $taskstatus != "Complete"}
  <tr>
    <td colspan="2" nowrap="nowrap">Dear {$assignee},</td>
  </tr>
  <tr>
    <td colspan="2" nowrap="nowrap">You have been assigned the following candidate task<br />
      <br /></td>
  </tr>
  {/if}
  <tr>
    <td valign="top" nowrap="nowrap"><b>Candidate:</b></td>
    <td valign="top" width="99%">{$candidate}</td>
  </tr>
  <tr>
    <td valign="top" nowrap="nowrap"><b>Company:</b></td>
    <td valign="top">{$company}</td>
  </tr>
  <tr>
    <td valign="top" nowrap="nowrap"><b>Manager:</b></td>
    <td valign="top">{$manager}</td>
  </tr>
  <tr>
    <td valign="top" nowrap="nowrap"><b>Job Title:</b></td>
    <td valign="top">{$jobtitle}</td>
  </tr>
  <tr>
    <td valign="top" nowrap="nowrap"><b>Task Name:</b></td>
    <td valign="top">{$taskname}</td>
  </tr>
  <tr>
    <td valign="top" nowrap="nowrap"><b>Start Date: </b></td>
    <td valign="top">{$startdate}</td>
  </tr>
  <tr>
    <td valign="top" nowrap="nowrap"><b>End Date: </b></td>
    <td valign="top">{$enddate}</td>
  </tr>
  <tr>
    <td valign="top" nowrap="nowrap"><b>Priority:</b></td>
    <td valign="top">{$priority}</td>
  </tr>
  <tr>
    <td valign="top" nowrap="nowrap"><b>Update Message: </b></td>
    <td valign="top">{$updatemessage}</td>
  </tr>
</table>

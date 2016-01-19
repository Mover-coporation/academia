<table width="100%" border="0" cellspacing="0" cellpadding="2">
 <tr>
  <td colspan="2" nowrap="nowrap">{$message}:</td>
 </tr>
 <tr>
  <td colspan="2" nowrap="nowrap" height="5"></td>
 </tr>
 <tr>
  <td valign="top" nowrap="nowrap"><b>Company:</b></td>
  <td valign="top" width="99%">{$company}</td>
 </tr>
 <tr>
  <td valign="top" nowrap="nowrap"><b>Manager:</b></td>
  <td valign="top">{$manager}</td>
 </tr>
 <tr>
  <td valign="top" nowrap="nowrap"><b>Job: </b></td>
  <td valign="top">{$job}</td>
 </tr>
 <tr>
  <td valign="top" nowrap="nowrap"><b>Request Status: </b></td>
  <td valign="top">{$requeststatus}</td>
 </tr>
 <tr>
  <td valign="top" nowrap="nowrap"><b>Priority:</b></td>
  <td valign="top">{$priority}</td>
 </tr>
 <tr>
  <td valign="top" nowrap="nowrap"><b>Date Sent: </b></td>
  <td valign="top">{$datesent}</td>
 </tr>
 <tr>
  <td valign="top" nowrap="nowrap"><b>Requirements:</b></td>
  <td valign="top">{$requirements}</td>
 </tr>
 <tr>
  	<td colspan="2" height="5"></td>
 </tr>
  {if $noresumes != ""}
	  	<tr>
	  		<td colspan="2">{$noresumes}</td>
	 	</tr>
   {else}
		 <tr>
		  <td colspan="2" valign="top" nowrap="nowrap" style="color:#0069b5;font-size:16px;	font-weight:bold;font-family: Arial, Helvetica, sans-serif;">Resumes</td>
		 </tr>
		 <tr>
		  <td colspan="2" align="right" valign="top" nowrap="nowrap">
		  
				  <table id="resumes" width="100%" border="0" cellspacing="0" cellpadding="4">
				    <tr style="background-color: #003366;color: #FFFFFF;font-weight: bold;text-decoration: none;height: 20px;text-align:left;font-size:12px;" class="listheading">
				     <td nowrap="nowrap" width="150">Resume</td>
				     <td nowrap="nowrap" width="150">Found By </td>
				     <td nowrap="nowrap" width="150">Submitted By </td>
				     <td nowrap="nowrap" width="150">Date Submitted </td>
				     <td nowrap="nowrap" width="150">Contacted/<br />
				      Responded
				      </th>
				     <td nowrap="nowrap" width="150">Status</td>
				     <td nowrap="nowrap" width="99%">Comments</td>
				    </tr>
				    {foreach from=$items key=myId item=i}
				    <tr>
				     <td align="left" nowrap="nowrap" valign="top">{$i.resume}</td>
				     <td align="left" nowrap="nowrap" valign="top">{$i.foundby}</td>
				     <td align="left" nowrap="nowrap" valign="top">{$i.submittedby}</td>
				      <td align="left" nowrap="nowrap" valign="top">{$i.resumesubmissiondate}</td>
				     <td align="left" valign="top" nowrap="nowrap">Contacted:&nbsp;&nbsp;{$i.contacted}<br/>
				      Responded: {$i.responded}</td>
				     <td align="left" nowrap="nowrap" valign="top">{$i.resumestatus}</td>
				     <td align="left" valign="top" width="99%">{$i.resumecomments}</td>
				    </tr>
				    {/foreach}
				   </table>
		   </td>
		 </tr>
 {/if}
</table>

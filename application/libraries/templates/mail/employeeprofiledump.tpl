<html>
<head>
</head>
<style type="text/css">
td {
	font-family: verdana, arial, helvetica, sans-serif;
	font-size: 13px;
}
.label {
	font-weight: bold;
	font-size: 10px;
	font-family:
verdana, arial, helvetica, sans-serif
}
.titleheader {
	font-family: verdana, arial, helvetica, sans-serif;
	font-size: 13px;
	font-weight: bold;
	color:
#336699;
}
.leftlinks {
	border-right: 0px;
	border-top: 0px;
	font-weight: bold;
	border-left:
0px;
	color: #FFFFFF;
	border-bottom: 1px solid #FFFFFF;
	height: 100%;
	background-color: #003366;
	text-align: left;
	text-decoration: none;
	padding:
0px 2px;
	margin: 0px 0px 4px;
}
.smallgraytextnolink {
	font-size: 8pt;
	color: #666666;
	text-decoration:
none;
}
hr {
	border-right: #fff;
	border-top: #fff;
	margin-top: 0px;
	margin-bottom: 0px;
	border-left:
#fff;
	width: 100%;
	border-bottom: #ccc 2px;
}
</style>
<body topmargin="0">
<table width="100%" border="0" cellspacing="0" cellpadding="4">
  <tr>
    <td colspan="2" nowrap="nowrap" class="titleheader"><hr />
      General Information
      <hr /></td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Employee:</b></td>
    <td align="left">{$salutation} {$employeenames}</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Gender:</b></td>
    <td align="left" width="99%">{$gender}</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Initials:</b></td>
    <td align="left">{$initials}</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Job Title:</b></td>
    <td align="left">{$jobtitle}</td>
  </tr>
  <tr>
    <td align="right" valign="top" nowrap><b>BLC Code:</b></td>
    <td align="left">{$blccode}</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Employee Job Category:</b></td>
    <td align="left">{$jobcategory}</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Department:</b></td>
    <td align="left">{$department}</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Location:</b></td>
    <td align="left">{$joblocation}</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Work Email Address:</b></td>
    <td align="left">{$emailaddress}</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Personal Email Address:</b></td>
    <td align="left">{$personalemailaddress}</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Username:</b></td>
    <td align="left">{$username}</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Is Admin:</b></td>
    <td align="left">{$isadmin}</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>User Type:</b></td>
    <td align="left">{$usertype}</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Status:</b></td>
    <td align="left">{$status}</td>
  </tr>
  <tr>
    <td colspan="2" nowrap="nowrap" class="titleheader"><hr />
      Contact Information
      <hr /></td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Mobile Phone Number:</b></td>
    <td align="left" width="99%">{$mobilenumber}</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Home Phone:</b></td>
    <td align="left">{$homephone}</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Office Line:</b></td>
    <td align="left">{$officeline}</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Fax Number:</b></td>
    <td align="left">{$faxnumber}</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Address Line 1:</b></td>
    <td align="left">{$address1}</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Address Line 2:</b></td>
    <td align="left">{$address2}</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>State/Province:</b></td>
    <td align="left">{$stateorprovince}</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Postal/Zip Code:</b></td>
    <td align="left">{$postalcode}</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>City:</b></td>
    <td align="left">{$city}</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Country:</b></td>
    <td align="left">{$country}</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Company Name:</b></td>
    <td align="left">{$companyname}</td>
  </tr>
  <tr>
    <td align="right" valign="top" nowrap="nowrap"><b>Company Address:</b></td>
    <td align="left" valign="top">{$companyaddress}</td>
  </tr>
  <tr>
    <td colspan="2" nowrap="nowrap" class="titleheader"><hr />
      Human Resource
      <hr /></td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Social Security #:</b></td>
    <td align="left" width="99%">{$ssn}</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Employer Identification Number:</b></td>
    <td align="left">{$ein}</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>TSG Badge Number:</b></td>
    <td align="left">{$tsgbadgenumber}</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Employee Type:</b></td>
    <td align="left">{$employeetype}</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Birth Date:</b></td>
    <td align="left">{$birthdate}</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Hire Date:</b></td>
    <td align="left">{$hiredate}</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Employee Start Date:</b></td>
    <td align="left">{$employeestartdate}</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Employee End Date:</b></td>
    <td align="left">{$employeeenddate}</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Release Date:</b></td>
    <td align="left">{$releasedate}</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Last Review Date:</b></td>
    <td align="left">{$lastreviewdate}</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Next Review Date:</b></td>
    <td align="left">{$nextreviewdate}</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Supervisor Names:</b></td>
    <td align="left">{$supervisorname}</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Supervisor Email:</b></td>
    <td align="left">{$supervisoremail}</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Supervisor Office Line:</b></td>
    <td align="left">{$supervisorofficeline}</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Can view Employee Resources:</b></td>
    <td align="left">{$canviewemployeeresources}</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Can view Public Holidays:</b></td>
    <td align="left">{$canviewpublicholidays}</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Can view Payroll Dates:</b></td>
    <td align="left">{$canviewpayrolldates}</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Can view Travel Policy:</b></td>
    <td align="left">{$canviewtravelpolicy}</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Can view 401k Information:</b></td>
    <td align="left">{$canview401kinformation}</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Can view Reference Information:</b></td>
    <td align="left">{$canviewreferenceinformation}</td>
  </tr>
  <tr>
    <td colspan="2" nowrap="nowrap" class="titleheader"><hr />
      Payroll
      <hr /></td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Payroll Frequency:</b></td>
    <td colspan="3" align="left">{$payrollfrequency}</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Invoice Category:</b></td>
    <td colspan="3" align="left">{$invoicecategory}</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Maximum Hours per Day:</b></td>
    <td colspan="3" align="left">{$maximumhoursperday}</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Maximum Hours per Week:</b></td>
    <td colspan="3" align="left">{$maximumhoursperweek}</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Vacation Days Allowed:</b></td>
    <td align="left" width="99%" colspan=""><table width="409"  border="0" cellspacing="0" cellpadding="2">
        <tr>
          <td>{$vacationdaysallowed}</td>
          <td align="right" nowrap="nowrap">&nbsp;</td>
          <td align="right" nowrap="nowrap"><b>Maximum Vacation Days:</b></td>
          <td>{$maximumvacationdays}</td>
        </tr>
      </table>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Personal Days Allowed:</b></td>
    <td align="left" width="99%" colspan=""><table width="409"  border="0" cellspacing="0" cellpadding="2">
        <tr>
          <td>{$personaldaysallowed}</td>
          <td align="right" nowrap="nowrap">&nbsp;</td>
          <td align="right" nowrap="nowrap"><b>Maximum Personal Days:</b></td>
          <td>{$maximumpersonaldays}</td>
        </tr>
      </table>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Paid Holiday Allowed:</b></td>
    <td align="left" width="99%" colspan=""><table width="409"  border="0" cellspacing="0" cellpadding="2">
        <tr>
          <td>{$paidholidaysallowed}</td>
          <td align="right" nowrap="nowrap">&nbsp;</td>
          <td align="right" nowrap="nowrap"><b>Maximum Paid Holiday Days:</b></td>
          <td>{$maximumpaidholidays}</td>
        </tr>
      </table>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Sick Days Allowed:</b></td>
    <td align="left" width="99%" colspan=""><table width="409"  border="0" cellspacing="0" cellpadding="2">
        <tr>
          <td>{$sickdaysallowed}</td>
          <td align="right" nowrap="nowrap">&nbsp;</td>
          <td align="right" nowrap="nowrap"><b>Maximum Sick Days:</b></td>
          <td>{$maximumsickdays}</td>
        </tr>
      </table>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Can work on Saturday:</b></td>
    <td colspan="3" align="left">{$saturdayworkallowed}</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Can work on Sunday:</b></td>
    <td colspan="3" align="left">{$sundayworkallowed}</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Can work on Public Holidays:</b></td>
    <td colspan="3" align="left">{$publicholidayworkallowed}</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Employee Benefits Billable:</b></td>
    <td colspan="3" align="left">{$employeebenefitsbillable}</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Maximum Social Security:</b></td>
    <td colspan="3" align="left">{$maximumsocialsecurity}</td>
  </tr>
  <tr>
    <td colspan="4" align="center" valign="top" class="error"></td>
  </tr>
  <td colspan="2" nowrap="nowrap" class="titleheader"><hr />
      Emergency Contacts
      <hr /></td>
  <tr>
    <td align="left" nowrap="nowrap" colspan="2" class="titleheader">First Emergency Contact</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>First Name:</b></td>
    <td align="left" width="99%">{$ec1_firstname}</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Last Name:</b></td>
    <td align="left">{$ec1_lastname}</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Street Address:</b></td>
    <td align="left">{$ec1_streetaddress}</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>City:</b></td>
    <td align="left">{$ec1_city}</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>State:</b></td>
    <td align="left" width="99%" colspan=""><table width="409"  border="0" cellspacing="0" cellpadding="2">
        <tr>
          <td>{$ec1_state}</td>
          <td align="right" nowrap="nowrap"><b>Zip Code:</b></td>
          <td>{$ec1_zipcode}</td>
        </tr>
      </table>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Home Phone #:</b></td>
    <td align="left">{$ec1_homephone}</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Work Phone #:</b></td>
    <td align="left">{$ec1_workphone}</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Cell Phone or Pager #:</b></td>
    <td align="left">{$ec1_cellphone}</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Relationship:</b></td>
    <td align="left">{$ec1_relationship}</td>
  </tr>
  <tr>
    <td align="left" nowrap="nowrap" class="titleheader" colspan="2">Second Emergency Contact</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>First Name:</b></td>
    <td align="left" width="99%">{$ec2_firstname}</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Last Name:</b></td>
    <td align="left">{$ec2_lastname}</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Street Address:</b></td>
    <td align="left">{$ec2_streetaddress}</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>City:</b></td>
    <td align="left">{$ec2_city}</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>State:</b></td>
    <td align="left" width="99%" colspan=""><table width="409"  border="0" cellspacing="0" cellpadding="2">
        <tr>
          <td>{$ec2_state}</td>
          <td align="right" nowrap="nowrap"><b>Zip Code:</b></td>
          <td>{$ec2_zipcode}</td>
        </tr>
      </table>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Home Phone #:</b></td>
    <td align="left">{$ec2_homephone}</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Work Phone #:</b></td>
    <td align="left">{$ec2_workphone}</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Cell Phone or Pager #:</b></td>
    <td align="left">{$ec2_cellphone}</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Relationship:</b></td>
    <td align="left">{$ec2_relationship}</td>
  </tr>
  <tr>
    <td align="left" nowrap="nowrap" class="titleheader" colspan="2"><b>Third Emergency Contac</b>t</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>First Name:</b></td>
    <td align="left" width="99%">{$ec3_firstname}</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Last Name:</b></td>
    <td align="left">{$ec3_lastname}</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Street Address:</b></td>
    <td align="left">{$ec3_streetaddress}</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>City:</b></td>
    <td align="left">{$ec3_city}</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>State:</b></td>
    <td align="left" width="99%" colspan=""><table width="409"  border="0" cellspacing="0" cellpadding="2">
        <tr>
          <td>{$ec3_state}</td>
          <td align="right" nowrap="nowrap"><b>Zip Code:</b></td>
          <td>{$ec3_zipcode}</td>
        </tr>
      </table>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Home Phone #:</b></td>
    <td align="left">{$ec3_homephone}</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Work Phone #:</b></td>
    <td align="left">{$ec3_workphone}</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Cell Phone or Pager #:</b></td>
    <td align="left">{$ec3_cellphone}</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Relationship:</b></td>
    <td align="left">{$ec3_relationship}</td>
  </tr>
  <tr>
    <td colspan="2"></td>
  </tr>
</table>
</body>
</html>
<?php /* Smarty version 2.6.18, created on 2010-06-30 14:05:57
         compiled from employeeprofiledump.tpl */ ?>
<html>
<head>
</head>
<style type="text/css">
td .label .titleheader .leftlinks .smallgraytextnolink hr </style>
<body topmargin="0">
<table width="100%" border="0" cellspacing="0" cellpadding="4">
  <tr>
    <td colspan="2" nowrap="nowrap" class="titleheader"><hr />
      General Information
      <hr /></td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Employee:</b></td>
    <td align="left"><?php echo $this->_tpl_vars['salutation']; ?>
 <?php echo $this->_tpl_vars['employeenames']; ?>
</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Gender:</b></td>
    <td align="left" width="99%"><?php echo $this->_tpl_vars['gender']; ?>
</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Initials:</b></td>
    <td align="left"><?php echo $this->_tpl_vars['initials']; ?>
</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Job Title:</b></td>
    <td align="left"><?php echo $this->_tpl_vars['jobtitle']; ?>
</td>
  </tr>
  <tr>
    <td align="right" valign="top" nowrap><b>BLC Code:</b></td>
    <td align="left"><?php echo $this->_tpl_vars['blccode']; ?>
</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Employee Job Category:</b></td>
    <td align="left"><?php echo $this->_tpl_vars['jobcategory']; ?>
</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Department:</b></td>
    <td align="left"><?php echo $this->_tpl_vars['department']; ?>
</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Location:</b></td>
    <td align="left"><?php echo $this->_tpl_vars['joblocation']; ?>
</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Work Email Address:</b></td>
    <td align="left"><?php echo $this->_tpl_vars['emailaddress']; ?>
</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Personal Email Address:</b></td>
    <td align="left"><?php echo $this->_tpl_vars['personalemailaddress']; ?>
</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Username:</b></td>
    <td align="left"><?php echo $this->_tpl_vars['username']; ?>
</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Is Admin:</b></td>
    <td align="left"><?php echo $this->_tpl_vars['isadmin']; ?>
</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>User Type:</b></td>
    <td align="left"><?php echo $this->_tpl_vars['usertype']; ?>
</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Status:</b></td>
    <td align="left"><?php echo $this->_tpl_vars['status']; ?>
</td>
  </tr>
  <tr>
    <td colspan="2" nowrap="nowrap" class="titleheader"><hr />
      Contact Information
      <hr /></td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Mobile Phone Number:</b></td>
    <td align="left" width="99%"><?php echo $this->_tpl_vars['mobilenumber']; ?>
</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Home Phone:</b></td>
    <td align="left"><?php echo $this->_tpl_vars['homephone']; ?>
</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Office Line:</b></td>
    <td align="left"><?php echo $this->_tpl_vars['officeline']; ?>
</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Fax Number:</b></td>
    <td align="left"><?php echo $this->_tpl_vars['faxnumber']; ?>
</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Address Line 1:</b></td>
    <td align="left"><?php echo $this->_tpl_vars['address1']; ?>
</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Address Line 2:</b></td>
    <td align="left"><?php echo $this->_tpl_vars['address2']; ?>
</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>State/Province:</b></td>
    <td align="left"><?php echo $this->_tpl_vars['stateorprovince']; ?>
</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Postal/Zip Code:</b></td>
    <td align="left"><?php echo $this->_tpl_vars['postalcode']; ?>
</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>City:</b></td>
    <td align="left"><?php echo $this->_tpl_vars['city']; ?>
</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Country:</b></td>
    <td align="left"><?php echo $this->_tpl_vars['country']; ?>
</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Company Name:</b></td>
    <td align="left"><?php echo $this->_tpl_vars['companyname']; ?>
</td>
  </tr>
  <tr>
    <td align="right" valign="top" nowrap="nowrap"><b>Company Address:</b></td>
    <td align="left" valign="top"><?php echo $this->_tpl_vars['companyaddress']; ?>
</td>
  </tr>
  <tr>
    <td colspan="2" nowrap="nowrap" class="titleheader"><hr />
      Human Resource
      <hr /></td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Social Security #:</b></td>
    <td align="left" width="99%"><?php echo $this->_tpl_vars['ssn']; ?>
</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Employer Identification Number:</b></td>
    <td align="left"><?php echo $this->_tpl_vars['ein']; ?>
</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>TSG Badge Number:</b></td>
    <td align="left"><?php echo $this->_tpl_vars['tsgbadgenumber']; ?>
</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Employee Type:</b></td>
    <td align="left"><?php echo $this->_tpl_vars['employeetype']; ?>
</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Birth Date:</b></td>
    <td align="left"><?php echo $this->_tpl_vars['birthdate']; ?>
</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Hire Date:</b></td>
    <td align="left"><?php echo $this->_tpl_vars['hiredate']; ?>
</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Employee Start Date:</b></td>
    <td align="left"><?php echo $this->_tpl_vars['employeestartdate']; ?>
</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Employee End Date:</b></td>
    <td align="left"><?php echo $this->_tpl_vars['employeeenddate']; ?>
</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Release Date:</b></td>
    <td align="left"><?php echo $this->_tpl_vars['releasedate']; ?>
</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Last Review Date:</b></td>
    <td align="left"><?php echo $this->_tpl_vars['lastreviewdate']; ?>
</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Next Review Date:</b></td>
    <td align="left"><?php echo $this->_tpl_vars['nextreviewdate']; ?>
</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Supervisor Names:</b></td>
    <td align="left"><?php echo $this->_tpl_vars['supervisorname']; ?>
</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Supervisor Email:</b></td>
    <td align="left"><?php echo $this->_tpl_vars['supervisoremail']; ?>
</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Supervisor Office Line:</b></td>
    <td align="left"><?php echo $this->_tpl_vars['supervisorofficeline']; ?>
</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Can view Employee Resources:</b></td>
    <td align="left"><?php echo $this->_tpl_vars['canviewemployeeresources']; ?>
</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Can view Public Holidays:</b></td>
    <td align="left"><?php echo $this->_tpl_vars['canviewpublicholidays']; ?>
</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Can view Payroll Dates:</b></td>
    <td align="left"><?php echo $this->_tpl_vars['canviewpayrolldates']; ?>
</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Can view Travel Policy:</b></td>
    <td align="left"><?php echo $this->_tpl_vars['canviewtravelpolicy']; ?>
</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Can view 401k Information:</b></td>
    <td align="left"><?php echo $this->_tpl_vars['canview401kinformation']; ?>
</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Can view Reference Information:</b></td>
    <td align="left"><?php echo $this->_tpl_vars['canviewreferenceinformation']; ?>
</td>
  </tr>
  <tr>
    <td colspan="2" nowrap="nowrap" class="titleheader"><hr />
      Payroll
      <hr /></td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Payroll Frequency:</b></td>
    <td colspan="3" align="left"><?php echo $this->_tpl_vars['payrollfrequency']; ?>
</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Invoice Category:</b></td>
    <td colspan="3" align="left"><?php echo $this->_tpl_vars['invoicecategory']; ?>
</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Maximum Hours per Day:</b></td>
    <td colspan="3" align="left"><?php echo $this->_tpl_vars['maximumhoursperday']; ?>
</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Maximum Hours per Week:</b></td>
    <td colspan="3" align="left"><?php echo $this->_tpl_vars['maximumhoursperweek']; ?>
</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Vacation Days Allowed:</b></td>
    <td align="left" width="99%" colspan=""><table width="409"  border="0" cellspacing="0" cellpadding="2">
        <tr>
          <td><?php echo $this->_tpl_vars['vacationdaysallowed']; ?>
</td>
          <td align="right" nowrap="nowrap">&nbsp;</td>
          <td align="right" nowrap="nowrap"><b>Maximum Vacation Days:</b></td>
          <td><?php echo $this->_tpl_vars['maximumvacationdays']; ?>
</td>
        </tr>
      </table>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Personal Days Allowed:</b></td>
    <td align="left" width="99%" colspan=""><table width="409"  border="0" cellspacing="0" cellpadding="2">
        <tr>
          <td><?php echo $this->_tpl_vars['personaldaysallowed']; ?>
</td>
          <td align="right" nowrap="nowrap">&nbsp;</td>
          <td align="right" nowrap="nowrap"><b>Maximum Personal Days:</b></td>
          <td><?php echo $this->_tpl_vars['maximumpersonaldays']; ?>
</td>
        </tr>
      </table>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Paid Holiday Allowed:</b></td>
    <td align="left" width="99%" colspan=""><table width="409"  border="0" cellspacing="0" cellpadding="2">
        <tr>
          <td><?php echo $this->_tpl_vars['paidholidaysallowed']; ?>
</td>
          <td align="right" nowrap="nowrap">&nbsp;</td>
          <td align="right" nowrap="nowrap"><b>Maximum Paid Holiday Days:</b></td>
          <td><?php echo $this->_tpl_vars['maximumpaidholidays']; ?>
</td>
        </tr>
      </table>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Sick Days Allowed:</b></td>
    <td align="left" width="99%" colspan=""><table width="409"  border="0" cellspacing="0" cellpadding="2">
        <tr>
          <td><?php echo $this->_tpl_vars['sickdaysallowed']; ?>
</td>
          <td align="right" nowrap="nowrap">&nbsp;</td>
          <td align="right" nowrap="nowrap"><b>Maximum Sick Days:</b></td>
          <td><?php echo $this->_tpl_vars['maximumsickdays']; ?>
</td>
        </tr>
      </table>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Can work on Saturday:</b></td>
    <td colspan="3" align="left"><?php echo $this->_tpl_vars['saturdayworkallowed']; ?>
</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Can work on Sunday:</b></td>
    <td colspan="3" align="left"><?php echo $this->_tpl_vars['sundayworkallowed']; ?>
</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Can work on Public Holidays:</b></td>
    <td colspan="3" align="left"><?php echo $this->_tpl_vars['publicholidayworkallowed']; ?>
</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Employee Benefits Billable:</b></td>
    <td colspan="3" align="left"><?php echo $this->_tpl_vars['employeebenefitsbillable']; ?>
</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Maximum Social Security:</b></td>
    <td colspan="3" align="left"><?php echo $this->_tpl_vars['maximumsocialsecurity']; ?>
</td>
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
    <td align="left" width="99%"><?php echo $this->_tpl_vars['ec1_firstname']; ?>
</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Last Name:</b></td>
    <td align="left"><?php echo $this->_tpl_vars['ec1_lastname']; ?>
</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Street Address:</b></td>
    <td align="left"><?php echo $this->_tpl_vars['ec1_streetaddress']; ?>
</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>City:</b></td>
    <td align="left"><?php echo $this->_tpl_vars['ec1_city']; ?>
</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>State:</b></td>
    <td align="left" width="99%" colspan=""><table width="409"  border="0" cellspacing="0" cellpadding="2">
        <tr>
          <td><?php echo $this->_tpl_vars['ec1_state']; ?>
</td>
          <td align="right" nowrap="nowrap"><b>Zip Code:</b></td>
          <td><?php echo $this->_tpl_vars['ec1_zipcode']; ?>
</td>
        </tr>
      </table>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Home Phone #:</b></td>
    <td align="left"><?php echo $this->_tpl_vars['ec1_homephone']; ?>
</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Work Phone #:</b></td>
    <td align="left"><?php echo $this->_tpl_vars['ec1_workphone']; ?>
</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Cell Phone or Pager #:</b></td>
    <td align="left"><?php echo $this->_tpl_vars['ec1_cellphone']; ?>
</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Relationship:</b></td>
    <td align="left"><?php echo $this->_tpl_vars['ec1_relationship']; ?>
</td>
  </tr>
  <tr>
    <td align="left" nowrap="nowrap" class="titleheader" colspan="2">Second Emergency Contact</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>First Name:</b></td>
    <td align="left" width="99%"><?php echo $this->_tpl_vars['ec2_firstname']; ?>
</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Last Name:</b></td>
    <td align="left"><?php echo $this->_tpl_vars['ec2_lastname']; ?>
</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Street Address:</b></td>
    <td align="left"><?php echo $this->_tpl_vars['ec2_streetaddress']; ?>
</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>City:</b></td>
    <td align="left"><?php echo $this->_tpl_vars['ec2_city']; ?>
</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>State:</b></td>
    <td align="left" width="99%" colspan=""><table width="409"  border="0" cellspacing="0" cellpadding="2">
        <tr>
          <td><?php echo $this->_tpl_vars['ec2_state']; ?>
</td>
          <td align="right" nowrap="nowrap"><b>Zip Code:</b></td>
          <td><?php echo $this->_tpl_vars['ec2_zipcode']; ?>
</td>
        </tr>
      </table>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Home Phone #:</b></td>
    <td align="left"><?php echo $this->_tpl_vars['ec2_homephone']; ?>
</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Work Phone #:</b></td>
    <td align="left"><?php echo $this->_tpl_vars['ec2_workphone']; ?>
</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Cell Phone or Pager #:</b></td>
    <td align="left"><?php echo $this->_tpl_vars['ec2_cellphone']; ?>
</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Relationship:</b></td>
    <td align="left"><?php echo $this->_tpl_vars['ec2_relationship']; ?>
</td>
  </tr>
  <tr>
    <td align="left" nowrap="nowrap" class="titleheader" colspan="2"><b>Third Emergency Contac</b>t</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>First Name:</b></td>
    <td align="left" width="99%"><?php echo $this->_tpl_vars['ec3_firstname']; ?>
</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Last Name:</b></td>
    <td align="left"><?php echo $this->_tpl_vars['ec3_lastname']; ?>
</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Street Address:</b></td>
    <td align="left"><?php echo $this->_tpl_vars['ec3_streetaddress']; ?>
</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>City:</b></td>
    <td align="left"><?php echo $this->_tpl_vars['ec3_city']; ?>
</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>State:</b></td>
    <td align="left" width="99%" colspan=""><table width="409"  border="0" cellspacing="0" cellpadding="2">
        <tr>
          <td><?php echo $this->_tpl_vars['ec3_state']; ?>
</td>
          <td align="right" nowrap="nowrap"><b>Zip Code:</b></td>
          <td><?php echo $this->_tpl_vars['ec3_zipcode']; ?>
</td>
        </tr>
      </table>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Home Phone #:</b></td>
    <td align="left"><?php echo $this->_tpl_vars['ec3_homephone']; ?>
</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Work Phone #:</b></td>
    <td align="left"><?php echo $this->_tpl_vars['ec3_workphone']; ?>
</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Cell Phone or Pager #:</b></td>
    <td align="left"><?php echo $this->_tpl_vars['ec3_cellphone']; ?>
</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><b>Relationship:</b></td>
    <td align="left"><?php echo $this->_tpl_vars['ec3_relationship']; ?>
</td>
  </tr>
  <tr>
    <td colspan="2"></td>
  </tr>
</table>
</body>
</html>
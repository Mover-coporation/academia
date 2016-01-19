<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">

<meta name="description" content="">
<meta name="keywords" content="">
<title><?php echo SITE_TITLE." : Financial Statement";?></title>
<link rel="shortcut icon" type="image/x-icon" href="<?php echo BASE_URL;?>favicon.ico">
<?php
echo "<script src='".base_url()."js/jquery.min.js' type='text/javascript'></script>";
echo minimize_code($this, 'javascript');
echo get_AJAX_constructor(TRUE);
?>
<?php echo minimize_code($this, 'stylesheets');?>
<style>

</style>
</head>

<body>
<table>
<tr><td>Student</td><td colspan="3"><?php echo $studentdetails['firstname'].' '.$studentdetails['lastname']; ?></td></tr>
<tr><td>Amount</td><td colspan="3"><?php echo $transaction['amount'] ?></td></tr>
<tr>
  <td>Particulars</td>
  <td colspan="3"><?php echo $feedetails['fee'] ?></td>
</tr>
<tr><td>Paid by</td><td colspan="3"><?php echo $transaction['payer']; ?></td></tr>
<tr><td>Received by</td><td><?php echo $author['firstname'].' '.$author['lastname']; ?></td><td>Date :</td><td><?php echo date("j M, Y", GetTimeStamp($transaction['dateadded'])); ?></td></tr>
<tr><td>PRINT DATE</td><td><?php echo date("j M, Y"); ?></td><td>PRINTED BY :</td><td><?php echo $this->session->userdata('names'); ?></td></tr>
</table>
</body>
</html>
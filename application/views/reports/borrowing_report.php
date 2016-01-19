<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">

<meta name="description" content="">
<meta name="keywords" content="">
<title><?php echo SITE_TITLE." : Purchases report";?></title>
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
<div>
<table width="100%">
<tr>
	<td colspan="2" style="text-align:center;"><?php echo strtoupper($schoolname); ?></td>
</tr>
<tr>

<td align="left" width="50%">BORROWING REPORT</td>
<?php
	$size = sizeof($page_list);
	$maxdate = date("j M, Y", GetTimeStamp($page_list[($size-1)]['datetaken']));
	$mindate = date("j M, Y", GetTimeStamp($page_list[0]['datetaken']));
?>
<td align="right" width="50%">From : <?php  if(!empty($datefrom)) echo date("j M, Y", GetTimeStamp($datefrom)); else echo $maxdate;?> &nbsp;&nbsp;To : <?php if(!empty($dateto)) echo date("j M, Y", GetTimeStamp($dateto)); else echo $mindate;?></td>
</tr>
</table>
</div><br /><br />
<?php
#Show search results
if(!empty($page_list))
{
	echo "<table width='100%' border='0' cellspacing='0' cellpadding='5'>
          	<tr>
			<td class='listheader' nowrap>Date Borrowed</td>
           	<td class='listheader' nowrap>Title</td>
			<td class='listheader' nowrap>Returned / Borrowed</td>
			<td class='listheader' nowrap>Name</td>
			
			<td class='listheader' nowrap>Date Expected</td>
			</tr>";	
	$counter = 0;	
	foreach($page_list AS $row)
	{
		#check expiry of rental period
		$currentdate = date("Y-m-d H:i:s");
		$borrower_status = check_borrower_status($this, $row['borrowerid']);
		#Show one row at a time
			echo "<tr style='".get_row_color($counter, 2)."'>";
		
		 echo "
		
		<td valign='top'>".date("j M, Y", GetTimeStamp($row['datetaken']))."</td>
		
		<td valign='top'>".$row['stocktitle']."</td>'
		
		<td valign='top'>".($row['copiestaken'] - $borrower_status)."/".$row['copiestaken']."</td>
		
		<td valign='top'>".$row['firstname']." ".$row['lastname']."</td>
		
		
		
		<td valign='top'>".date("j M, Y", GetTimeStamp($row['returndate']))."</td>
		
		</tr>";
		
		$counter++;
	}
	
		
	echo "<tr></table>";	
		
} else {
	echo format_notice("There are no borrowing data matching that criteria at the moment.");
	
}?><br /><br />
<?php $this->load->view('incl/footer');?>
</body>
</html>
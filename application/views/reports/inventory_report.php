<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">

<meta name="description" content="">
<meta name="keywords" content="">
<title><?php echo SITE_TITLE." : Inventory report";?></title>
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

<td align="left">INVENTORY REPORT</td>

<td align="right" width="50%"><?php echo date("j M, Y", time()); ?></td>
</tr>
</table>
</div><br /><br />
<?php
if(!empty($page_list))
{
	echo "<table width='100%' border='0' cellspacing='0' cellpadding='5'>
          	<tr>
			<td class='listheader' nowrap>Item Name</td>
			
			<td class='listheader' nowrap>In</td>
			<td class='listheader' nowrap>Out</td>
			<td class='listheader' nowrap>Stocked</td>			
			<td class='listheader' nowrap>Units</td>
			</tr>";	
	$counter = 0;	
	foreach($page_list AS $row)
	{
		$stocked = get_stocked($this, $row['id']);
		$sold = get_sold($this, $row['id']);
		$remaining = $stocked - $sold;
		
		#Assign zeros to empty values	
		if(empty($stocked)) $stocked=0;
		if(empty($sold)) $sold=0;
		
		#Show one row at a time
		if($row['reorderlevel'] >= $remaining)
			echo "<tr style='color:red;".get_row_color($counter, 2)."'><td valign='top' nowrap>";
		else
			echo "<tr style='".get_row_color($counter, 2)."'>";	
		
		 echo "
		
		<td valign='top'>".$row['itemname']."</td>
		
		
		
		<td valign='top'>".($stocked - $sold)."</td>
		
		<td valign='top'>".$sold."</td>
		
		<td valign='top'>".$stocked."</td>
		
		<td valign='top'>".$row['unitspecification']."</td>
		
		</tr>";
		
		$counter++;
	}
	
		
	echo "</table>";	
		
} else {
	echo format_notice("There are no inventory data matching that criteria at the moment.");
	
}?><br /><br />
<?php $this->load->view('incl/footer');?>
</body>
</html>
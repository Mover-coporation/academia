<table border="0" cellspacing="0" cellpadding="10" width="100%" id='contenttable'>
          <tr>
            <td colspan="2" style="padding-top:0px;" class="pageheader">
            	<table>
          		<tr>
            		<td valign="middle"><div class="page-title">Item Details</div></td>
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
            <form id="form1" name="form1" method="post" action="<?php echo base_url();?>inventory/load_item_form<?php 
		if(!empty($i))
		{
			echo "/i/".$i;
		}
		?>" >
            
            <table width="100" border="0" cellspacing="0" cellpadding="8">
				  <tr>
                    <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">Item Name :<?php echo $indicator;?></td>
                    <td class="field" nowrap>
                      <?php  
			if(!empty($isview))
			{
				echo "<span class='viewtext'>".$formdata['itemname']."</span>";
			}else{
					echo get_required_field_wrap($requiredfields, 'itemname');
					?>
                      <input type="text" name="itemname" id="itemname" class="textfield" size="30" value="<?php 
				  if(!empty($formdata['itemname'])){
				 	 echo $formdata['itemname'];
				  }?>"/>
                      <?php  echo get_required_field_wrap($requiredfields, 'itemname', 'end');
			}
				  ?>
                    </td>
                  </tr>
                  
                  <tr>
                    <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">Unit Specification :<?php echo $indicator;?></td>
                    <td class="field" nowrap>
                      <?php  
			if(!empty($isview))
			{
				echo "<span class='viewtext'>".$formdata['unitspecification']."</span>";
			}else{
					echo get_required_field_wrap($requiredfields, 'unitspecification');
					?>
                      <input type="text" name="unitspecification" id="unitspecification" class="textfield" size="30" value="<?php 
				  if(!empty($formdata['unitspecification'])){
				 	 echo $formdata['unitspecification'];
				  }?>"/>
                      <?php  echo get_required_field_wrap($requiredfields, 'unitspecification', 'end');
			}
				  ?>
                    </td>
                  </tr>
                  
                  <tr>
                    <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">Reorder Level :<?php echo $indicator;?></td>
                    <td class="field" nowrap>
                      <?php  
			if(!empty($isview))
			{
				echo "<span class='viewtext'>".$formdata['reorderlevel']."</span>";
			}else{
					echo get_required_field_wrap($requiredfields, 'reorderlevel');
					?>
                      <input type="text" name="reorderlevel" id="reorderlevel" class="textfield" size="30" value="<?php 
				  if(!empty($formdata['reorderlevel'])){
				 	 echo $formdata['reorderlevel'];
				  }?>"/>
                      <?php  echo get_required_field_wrap($requiredfields, 'reorderlevel', 'end');
			}
				  ?>
                    </td>
                  </tr>
                  <?php  if(empty($isview)){ ?>
				  <tr>
                    <td>&nbsp;</td>
                    <td><input type="submit" name="saveitem" id="login" value="Save" class="button"/></td>
                    <td>&nbsp;</td>
                  </tr>
                  <?php } ?>
                </table>
            
            </form>
            
            <?php if(!empty($isview)){ ?>
    <div id="itemlog">
    	<div id="in">
        <br /><br />
        <div class="page-title">In</div>
        	<?php             
#Show search results
if(!empty($in))
{
	echo "<table width='100%' border='0' cellspacing='0' cellpadding='5'>
          	<tr>
			<td class='listheader' nowrap>Date Added</td>
			<td class='listheader' nowrap>Supplier</td>
			<td class='listheader' nowrap>Invoice Number</td>
			<td class='listheader' nowrap>Quantity</td>
			</tr>";	
	$counter = 0;	
	foreach($in AS $row)
	{
		
		#Show one row at a time
		echo "<tr style='".get_row_color($counter, 2)."'>";
		
		 echo "
		
		<td valign='top'>".$row['datecreated']."</td>
		
		<td valign='top'>".$row['supplier']."</td>
		
		<td valign='top'>".$row['invoicenumber']."</td>
		
		<td valign='top'>".$row['quantity']."</td>
		
		
		
		</tr>";
		
		$counter++;
	}
	
		
	echo "</table>";	
		
} else {
	echo format_notice("There are no in history at the moment.");
	
}?>
        </div>
        <div id="out">
        <br /><br />
        <div class="page-title">Out</div>
        	<?php 
			#Show search results
if(!empty($out))
{
	echo "<table width='100%' border='0' cellspacing='0' cellpadding='5'>
          	<tr>
			<td class='listheader' nowrap>Date Taken</td>			
			<td class='listheader' nowrap>Quantity</td>
			<td class='listheader' nowrap>Issued to</td>	
			</tr>";	
	$counter = 0;	
	foreach($out AS $row)
	{
		
		#Show one row at a time
		echo "<tr style='".get_row_color($counter, 2)."'>";
		
		 echo "
		
		<td valign='top'>".$row['datecreated']."</td>		
		
		<td valign='top'>".$row['quantity']."</td>
		
		<td valign='top'><a href='".base_url()."students/load_student_form/i/".encryptValue($row['studentid'])."/a/".encryptValue("view")."' title=\"Click to view this student.\">".$row['firstname']." ".$row['lastname']."</a></td>
		
		
		
		</tr>";
		
		$counter++;
	}
	
		
	echo "</table>";	
		
} else {
	echo format_notice("There are no out history at the moment.");
	
}
			 ?>
        </div>
    </div>
    <?php
	}
	?>
            
            </td>
            </tr>
          
        </table>
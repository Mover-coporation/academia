<?php
if(empty($requiredfields)){
  $requiredfields = array();
}

$indicator = (!empty($isview))? "": "<span class='redtext'>*</span>";
$rentaldata = (!empty($isview))? "": "<span class='redtext'>*</span>";
?>

<table border="0" cellspacing="0" cellpadding="10" width="100%" id='contenttable'>
          <tr>
            <td colspan="2" style="padding-top:0px;" class="pageheader">
            	<table>
          		<tr>
            		<td valign="middle"><div class="page-title">Return Rental</div></td>
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
            <form id="form1" name="form1" method="post" action="<?php echo base_url();?>library/return_rental<?php 
		if(!empty($i))
		{
			echo "/i/".$i;
		}
		?>" >
            
            <table width="100" border="0" cellspacing="0" cellpadding="8">
            	  <tr>
                    <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">Item :</td>
                    <td class="field" nowrap>
                      <?php  
							echo "<span class='viewtext'>".$rentaldata['stocktitle']." by ".$rentaldata['author']."</span>";
				  	  ?>
                    </td>
                    
                  </tr>
            	  <tr>
                    <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">Borrower :</td>
                    <td class="field" nowrap>
                    	<?php  
							echo "<span class='viewtext'>".$rentaldata['firstname']." ".$rentaldata['lastname']."</span>";
				  	  ?>
					</td>
                  </tr>  
                  
                  <tr>
                    <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">Issue Date :</td>
                    <td class="field" nowrap>
                      <?php 
						echo "<span class='viewtext'>".$rentaldata['datetaken']."</span>";
				  ?>
                    </td>
                  </tr>                    
                  
				  <tr>
                    <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">Return Date :<?php echo $indicator;?></td>
                    <td class="field" nowrap>
                      <?php  
			if(!empty($isview))
			{
				echo "<span class='viewtext'>".$formdata['returndate']."</span>";
			}else{
					echo get_required_field_wrap($requiredfields, 'returndate');
					?>
                      <input type="text" name="returndate" id="returndate" class="textfield manyyearsdatefield" size="30" value="<?php 
				  if(!empty($formdata['returndate'])){
				 	 echo $formdata['returndate'];
				  }?>"/>
                      <?php  echo get_required_field_wrap($requiredfields, 'returndate', 'end');
			}
				  ?>
                    </td>
                  </tr>                 
                  <tr>
                    <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">Select Items to return :<?php echo $indicator;?></td>
                    <td nowrap><?php  
				echo get_required_field_wrap($requiredfields, 'item');?>
                  <input type="hidden" name="borrower" value="<?php echo $rentaldata['borrower']; ?>" />
                  <select name="item[]" multiple="multiple" class="textfield" style="height:200px; width:270px;" >
                  	<?php
							write_options_list($this,array('tname' => "borroweditems b, library l", 'searchstring'=>" WHERE b.borrower =".$rentaldata['borrower']." AND l.isavailable='0' AND b.item=l.id"),'','serialnumber','item'); 
					?>
                  </select>
                  <?php echo get_required_field_wrap($requiredfields, 'item', 'end');
			
			
			?></td>
                  </tr>
                  <?php  if(empty($isview)){ ?>
				  <tr>
                    <td>&nbsp;</td>
                    <td><input type="submit" name="returnrental" id="login" value="Save" class="button"/></td>
                    <td>&nbsp;</td>
                  </tr>
                  <?php } ?>
                </table>
            
            </form>
            
            </td>
            </tr>
          
        </table>
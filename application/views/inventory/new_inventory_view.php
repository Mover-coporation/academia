<table border="0" cellspacing="0" cellpadding="10" width="100%" id='contenttable'>
          <tr>
            <td colspan="2" style="padding-top:0px;" class="pageheader">
            	<table>
          		<tr>
            		<td valign="middle"><div class="page-title">Inventory Details</div></td>
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
            <form id="form1" name="form1" method="post" action="<?php echo base_url();?>inventory/load_inventory_form<?php 
		if(!empty($i))
		{
			echo "/i/".$i;
		}
		echo "/a/".encryptValue($itemdata['id']);
		?>" >
            <table width="100" border="0" cellspacing="0" cellpadding="8">
            		<tr>
                    <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">Item Name :<?php echo $indicator;?></td>
                    <td class="field" nowrap>
                      <?php  
							echo "<span class='viewtext'>".$itemdata['itemname']."</span>";
				  	  ?>
                    </td>
                    <input type="hidden" name="itemid" value="<?php echo $itemdata['id']; ?>"  />
                  </tr>
                  
                  <tr>
                    <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">Supplier :<?php echo $indicator;?></td>
                    <td class="field" nowrap>
                      <?php  
			if(!empty($isview))
			{
				echo "<span class='viewtext'>".$formdata['supplier']."</span>";
			}else{
					echo get_required_field_wrap($requiredfields, 'supplier');
					?>
                      <input type="text" name="supplier" id="supplier" class="textfield" size="30" value="<?php 
				  if(!empty($formdata['supplier'])){
				 	 echo $formdata['supplier'];
				  }?>"/>
                      <?php  echo get_required_field_wrap($requiredfields, 'supplier', 'end');
			}
				  ?>
                    </td>
                  </tr>
                  
                   <tr>
                    <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">Invoice Number :<?php echo $indicator;?></td>
                    <td class="field" nowrap>
                      <?php  
			if(!empty($isview))
			{
				echo "<span class='viewtext'>".$formdata['invoicenumber']."</span>";
			}else{
					echo get_required_field_wrap($requiredfields, 'invoicenumber');
					?>
                      <input type="text" name="invoicenumber" id="invoicenumber" class="textfield" size="30" value="<?php 
				  if(!empty($formdata['invoicenumber'])){
				 	 echo $formdata['invoicenumber'];
				  }?>"/>
                      <?php  echo get_required_field_wrap($requiredfields, 'invoicenumber', 'end');
			}
				  ?>
                    </td>
                  </tr>
                  
                  <tr>
                    <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">Unit Price :<?php echo $indicator;?></td>
                    <td class="field" nowrap>
                      <?php  
					if(!empty($isview))
					{
						echo "<span class='viewtext'>".$formdata['price']."</span>";
					}else{
							echo get_required_field_wrap($requiredfields, 'price');
							?>
							  <input type="text" name="price" id="price" class="textfield" size="30" value="<?php 
						  if(!empty($formdata['price'])){
							 echo $formdata['price'];
						  }?>"/>
							  <?php  echo get_required_field_wrap($requiredfields, 'price', 'end');
					}
				  ?>
                    </td>
                  </tr>
                  
				  <tr>
                    <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">Quanity :<?php echo $indicator;?></td>
                    <td class="field" nowrap>
                      <?php  
			if(!empty($isview))
			{
				echo "<span class='viewtext'>".$formdata['quantity']."</span>";
			}else{
					echo get_required_field_wrap($requiredfields, 'quantity');
					?>
                      <input type="text" name="quantity" id="quantity" class="textfield" size="30" value="<?php 
				  if(!empty($formdata['quantity'])){
				 	 echo $formdata['quantity'];
				  }?>"/>
                      <?php  echo get_required_field_wrap($requiredfields, 'quantity', 'end');
			}
				  ?>
                    </td>
                  </tr>
                  
                  
                  <?php  if(empty($isview)){ ?>
				  <tr>
                    <td>&nbsp;</td>
                    <td><input type="submit" name="saveinventory" id="login" value="Save" class="button"/></td>
                    <td>&nbsp;</td>
                  </tr>
                  <?php } ?>
                </table>
            
            </form>
            
            </td>
            </tr>
          
        </table>

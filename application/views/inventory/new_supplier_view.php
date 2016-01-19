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
                    <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">Name :<?php echo $indicator;?></td>
                    <td class="field" nowrap>
                      <?php  
							echo "<span class='viewtext'>".$itemdata['itemname']."</span>";
				  	  ?>
                    </td>
                    <input type="hidden" name="itemid" value="<?php echo $itemdata['id']; ?>"  />
                  </tr>
                  
                  <tr>
                    <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">Types of goods :<?php echo $indicator;?></td>
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
                    <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">Address Line 1 :<?php echo $indicator;?></td>
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
                    <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">Address Line 2 :<?php echo $indicator;?></td>
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
                  
                  <tr>
                    <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">Email Address :<?php echo $indicator;?></td>
                    <td class="field" nowrap>
                      <?php  
			if(!empty($isview))
			{
				echo "<span class='viewtext'>".$formdata['emailaddress']."</span>";
			}else{
					echo get_required_field_wrap($requiredfields, 'emailaddress');
					?>
                      <input type="text" name="emailaddress" id="emailaddress" class="textfield" size="30" value="<?php 
				  if(!empty($formdata['emailaddress'])){
				 	 echo $formdata['emailaddress'];
				  }?>"/>
                      <?php  echo get_required_field_wrap($requiredfields, 'emailaddress', 'end');
			}
				  ?>
                    </td>
                  </tr>
                  
                  <tr>
                    <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">Contact Person :<?php echo $indicator;?></td>
                    <td class="field" nowrap>
                      <?php  
			if(!empty($isview))
			{
				echo "<span class='viewtext'>".$formdata['contact']."</span>";
			}else{
					echo get_required_field_wrap($requiredfields, 'contact');
					?>
                      <input type="text" name="contact" id="contact" class="textfield" size="30" value="<?php 
				  if(!empty($formdata['contact'])){
				 	 echo $formdata['contact'];
				  }?>"/>
                      <?php  echo get_required_field_wrap($requiredfields, 'contact', 'end');
			}
				  ?>
                    </td>
                  </tr>
                  
                  <tr>
                    <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">Notes :<?php echo $indicator;?></td>
                    <td class="field" nowrap>
                      <?php  
			if(!empty($isview))
			{
				echo "<span class='viewtext'>".$formdata['notes']."</span>";
			}else{
					echo get_required_field_wrap($requiredfields, 'notes');
					?>
                      <input type="text" name="notes" id="notes" class="textfield" size="30" value="<?php 
				  if(!empty($formdata['notes'])){
				 	 echo $formdata['notes'];
				  }?>"/>
                      <?php  echo get_required_field_wrap($requiredfields, 'notes', 'end');
			}
				  ?>
                    </td>
                  </tr>
                  
                  <?php  if(empty($isview)){ ?>
				  <tr>
                    <td>&nbsp;</td>
                    <td><input type="submit" name="savesupplier" id="login" value="Save" class="button"/></td>
                    <td>&nbsp;</td>
                  </tr>
                  <?php } ?>
                </table>
            
            </form>
            
            </td>
            </tr>
          
        </table>
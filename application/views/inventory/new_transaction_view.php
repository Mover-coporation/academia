<table border="0" cellspacing="0" cellpadding="10" width="100%" id='contenttable'>
          <tr>
            <td colspan="2" style="padding-top:0px;" class="pageheader">
            	<table>
          		<tr>
            		<td valign="middle"><div class="page-title">Transaction Details</div></td>
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
                    <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">Item :<?php echo $indicator;?></td>
                    <td class="field" nowrap>
                      <?php  
				echo "<span class='viewtext'>".$itemdata['itemname']."</span>";
				  ?>
                    </td>
                  </tr>
               <form id="form1" name="form1" method="post" action="<?php echo base_url();?>inventory/load_transaction_form<?php 
		if(!empty($i))
		{
			echo "/i/".$i;
		}
			echo "/s/".encryptValue($itemdata['id']) ;
		?>" >
        
        	  <tr>
                    <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">Issue to :<?php echo $indicator;?></td>
                    <td class="field" nowrap>
                    <?php
                        echo get_required_field_wrap($requiredfields, 'search');
                    ?>
                    <input name="search" type="text" id="search" size="35" class="textfield" value="<?php 
                                  if(!empty($formdata['firstname']) && !empty($formdata['middlename']) && !empty($formdata['lastname'])){
                                     echo $formdata['firstname']." ".$formdata['middlename']." ".$formdata['lastname'];
                                  }?>" onkeyup="startInstantSearch('search', 'searchby', '<?php echo base_url();?>search/load_results/type/student_list/layer/searchresults2/area/select_student');showPartLayer('searchresults2', 'fast');" onkeypress="return handleEnter(this, event)"/>
                    <?php  echo get_required_field_wrap($requiredfields, 'search', 'end');?>
                    <div id="searchresults2" style='max-height: 380px; overflow:hidden; position:absolute;border: 1px solid #98CBFF; background-color: #F7F7F7; display:none;'></div></td>
                    <td>&nbsp;<input name="searchby" type="hidden" id="searchby" value="firstname__lastname__middlename__studentno" /></td>
                  </tr>
                  <input id="studentid" type="hidden" name="studentid" value="<?php 
				  if(!empty($formdata['studentid'])){
				 	 echo $formdata['studentid'];
				  }; ?>" />
              	
              <tr>
                    <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">
                   
                    Date of transaction :<?php echo $indicator;?></td>
                    <td class="field" nowrap>
                      <?php  
			if(!empty($isview))
			{
				echo "<span class='viewtext'>".$formdata['datecreated']."</span>";
			}else{
					echo get_required_field_wrap($requiredfields, 'datecreated');
					?>
                      <input type="text" name="datecreated" id="dob" class="textfield manyyearsdatefield" size="30" value="<?php 
				  if(!empty($formdata['datecreated'])){
				 	 echo $formdata['datecreated'];
				  }?>"/>
                      <?php  echo get_required_field_wrap($requiredfields, 'datecreated', 'end');
			}
				  ?>
                    </td>
                  </tr>
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
                    <td><input type="submit" name="savetransaction" id="login" value="Save" class="button"/></td>
                    <td>&nbsp;</td>
                  </tr>
                  <?php } ?>
                </table>
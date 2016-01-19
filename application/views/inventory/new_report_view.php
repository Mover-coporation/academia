 <table border="0" cellspacing="0" cellpadding="10" width="100%" id='contenttable'>
          <tr>
            <td colspan="2" style="padding-top:0px;" class="pageheader">
            	<table>
          		<tr>
            		<td valign="middle"><div class="page-title">Generate Report</div></td>
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
            <form id="form1" name="form1" method="post" action="<?php echo base_url();?>inventory/generate_report" >
            
            <table width="100" border="0" cellspacing="0" cellpadding="8">
            	  <tr>
                    <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">Report Type :<?php echo $indicator;?></td>
                    <td nowrap><?php 
					if(!empty($isview))
			{
				echo "<span class='viewtext'>".$formdata['name']."</span>";
			}else{  
				echo get_required_field_wrap($requiredfields, 'type');?>
                  <select name="type" class="textfield" style="height:35px; width:270px;" >
                  	<?php  
						if(!empty($formdata['type']))
							write_options_list($this,array('tname' => "reporttypes"),$formdata['type']); 
						else
							write_options_list($this,array('tname' => "reporttypes")); 
					?>
                  </select>
                  <?php echo get_required_field_wrap($requiredfields, 'type', 'end');
			}
			
			?></td>
                  </tr>
            	  
                  
                  
                  <tr>
                    <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">From :<?php echo $indicator;?></td>
                    <td class="field" nowrap>
                      <?php  
			if(!empty($isview))
			{
				echo "<span class='viewtext'>".$formdata['datefrom']."</span>";
			}else{
					echo get_required_field_wrap($requiredfields, 'datefrom');
					?>
                      <input type="text" name="datefrom" id="datefrom" class="textfield manyyearsdatefield" size="30" value="<?php 
				  if(!empty($formdata['datefrom'])){
				 	 echo $formdata['datefrom'];
				  }?>"/>
                      <?php  echo get_required_field_wrap($requiredfields, 'datefrom', 'end');
			}
				  ?>
                    </td>
                    <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">To :<?php echo $indicator;?></td>
                    <td class="field" nowrap>
                      <?php  
			if(!empty($isview))
			{
				echo "<span class='viewtext'>".$formdata['dateto']."</span>";
			}else{
					echo get_required_field_wrap($requiredfields, 'dateto');
					?>
                      <input type="text" name="dateto" id="dateto" class="textfield manyyearsdatefield" size="30" value="<?php 
				  if(!empty($formdata['dateto'])){
				 	 echo $formdata['dateto'];
				  }?>"/>
                      <?php  echo get_required_field_wrap($requiredfields, 'dateto', 'end');
			}
				  ?>
                    </td>
                  </tr>                    
                  
				  <tr>
                    <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">Item :<?php echo $indicator;?></td>
                    <td nowrap><?php 
					if(!empty($isview))
			{
				echo "<span class='viewtext'>".$formdata['itemname']."</span>";
			}else{  
				echo get_required_field_wrap($requiredfields, 'type');?>
                  <select name="item" class="textfield" style="height:35px; width:270px;" >
                  	<?php  
						if(!empty($formdata['item']))
							write_options_list($this,array('tname' => "items"),$formdata['item'],'itemname'); 
						else
							write_options_list($this,array('tname' => "items"),'','itemname'); 
					?>
                  </select>
                  <?php echo get_required_field_wrap($requiredfields, 'item', 'end');
			}
			
			?></td>
                  </tr>
				  <tr>

                    <td>&nbsp;</td>
                    <td><input type="submit" name="generatereport" id="login" value="Generate Report" class="button"/></td>
                    <td>&nbsp;</td>
                  </tr>
                </table>
            
            </form>
            
            </td>
            </tr>
          
        </table>
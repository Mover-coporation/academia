<?php
if(empty($requiredfields)){
	$requiredfields = array();
}

$indicator = (!empty($isview))? "": "<span class='redtext'>*</span>";?>

        <table border="0" cellspacing="0" cellpadding="10" width="100%" id='contenttable'>
          <tr>
            <td colspan="2" style="padding-top:0px;" class="pageheader">
            	<table>
          		<tr>
            		<td valign="middle"><div class="page-title">New Term Details</div></td>
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
            <form id="form1" name="form1" >
            
            <table width="100" border="0" cellspacing="0" cellpadding="8">
				  <tr>
                    <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">Term :<?php echo $indicator;?></td>
                    <td class="field" nowrap>
                      <?php  
			if(!empty($isview))
			{
				echo "<span class='viewtext'>".$userdetails['firstname']."</span>";
			}else{
					echo get_required_field_wrap($requiredfields, 'term');
					?>
                      <input type="text" name="term" id="term" class="textfield" size="30" value="<?php 
				  if(!empty($termdetails['term'])){
				 	 echo $termdetails['term'];
				  }?>"/>
                      <?php  echo get_required_field_wrap($requiredfields, 'term', 'end');
			}
				  ?>
                    </td>
                    </tr>
                  <tr>
                    <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">Year :<?php echo $indicator;?></td>
                    <td class="field" nowrap>
                      <?php if(!empty($isview))
			{
				echo "<span class='viewtext'>".$termdetails['year']."</span>";
			}else{
				echo get_required_field_wrap($requiredfields, 'year');
                    ?>
                      <select class="selectfield" name="year" id="year">
                    <?php echo get_year_combo((!empty($termdetails['year']))? $termdetails['year'] : '' , 5, 'DESC', 'FUTURE', '2010'); ?>
                    </select>
                      <?php  echo get_required_field_wrap($requiredfields, 'year', 'end');
			}
				  ?>
                    </td>
                  </tr>
                  <tr>
                    <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">Start Date :<?php echo $indicator;?></td>
                    <td class="field" nowrap>
                      <?php  
			if(!empty($isview))
			{
				echo "<span class='viewtext'>".$termdetails['startdate']."</span>";
			}else{
					echo get_required_field_wrap($requiredfields, 'firstname');
					?>
                      <input type="text" name="startdate" id="startdate" class="textfield manyyearsdatefield" size="30" value="<?php 
				  if(!empty($termdetails['startdate'])){
				 	 echo $termdetails['startdate'];
				  }?>"/>
                      <?php  echo get_required_field_wrap($requiredfields, 'startdate', 'end');
			}
				  ?>
                    </td>
                  </tr>
                  <tr>
                          <td class="label" style="padding-top:13px">End  Date :<?php echo $indicator;?></td><td>
                        <?php if(empty($isview))
			{
				?>
                        <input type="text" name="enddate" id="enddate" class="textfield manyyearsdatefield" value="<?php 
				  if(!empty($termdetails['enddate'])){
				 	 echo $termdetails['enddate'];
				  }?>" size="30"/>
                  <?php } ?>
                  </td></tr>
                  <?php  if(empty($isview)){ ?>
				  <tr>
                    <td><?php if(!empty($i) || !empty($editid)){?><input name="editid" type="hidden" id="editid" value="<?php 
					if(!empty($i)){
						echo decryptValue($i);
					} else {
						echo $editid;
					}?>"/><?php }
					
					
					?></td>
                    <td><input type="button" onclick="saveTerm('<?php echo ((!empty($i))? '/i/'.$i : '');?>', 'term<>year<>startdate<>enddate<>save<?php if(!empty($i) || !empty($editid)) echo '<>editid'?>');" name="save" id="save" value="Save" class="button"/></td>
                    </tr>
                  <?php } ?>
                </table>
            
            </form>
            
            </td>
            </tr>
          
        </table>
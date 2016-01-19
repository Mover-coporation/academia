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
            		<td valign="middle"><div class="page-title">New Class Details</div></td>
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
            <form id="form1" name="form1" method="post">
            
            <table width="100" border="0" cellspacing="0" cellpadding="8">
				  <tr>
                    <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">Class :<?php echo $indicator;?></td>
                    <td class="field" nowrap>
                      <?php  
			if(!empty($isview))
			{
				echo "<span class='viewtext'>".$userdetails['class']."</span>";
			}else{
					echo get_required_field_wrap($requiredfields, 'class');
					?>
                      <input type="text" name="class" id="class" class="textfield" size="30" value="<?php 
				  if(!empty($classdetails['class'])){
				 	 echo $classdetails['class'];
				  }?>"/>
                      <?php  echo get_required_field_wrap($requiredfields, 'class', 'end');
			}
				  ?>
                    </td>
                    </tr>
                  <tr>
                    <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">Rank :<?php echo $indicator;?></td>
                    <td class="field" nowrap>
                      <?php if(!empty($isview))
			{
				echo "<span class='viewtext'>".$termdetails['rank']."</span>";
			}else{
				echo get_required_field_wrap($requiredfields, 'rank');
                    ?>
                      <input type="text" name="rank" id="rank" class="textfield" size="30" value="<?php 
				  if(!empty($classdetails['rank'])){
				 	 echo $classdetails['rank'];
				  }?>"/>
                      <?php  echo get_required_field_wrap($requiredfields, 'rank', 'end');
			}
				  ?>
                    <i style="font-size:10px">(Indicate position of class in the ascending list of classes)</i></td>
                  </tr>
                  <?php  if(empty($isview)){ ?>
				  <tr>
                    <td><?php if(!empty($i) || !empty($editid)){?><input name="editid" type="hidden" id="editid" value="<?php 
					if(!empty($i)){
						echo decryptValue($i);
					} else {
						echo $editid;
					}?>"/><?php } ?>
                    </td>
                    <td><input type="button" onclick="saveClass('<?php echo ((!empty($i))? '/i/'.$i : '');?>', 'class<>rank<>save<?php if(!empty($i) || !empty($editid)) echo '<>editid'?>')" name="save" id="save" value="Save" class="button"/></td>
                    </tr>
                  <?php } ?>
                </table>
            
            </form>
            
            </td>
            </tr>
          
        </table>
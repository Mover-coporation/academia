<?php
if(empty($requiredfields)){
	$requiredfields = array();
}

$indicator = (!empty($isview))? "": "<span class='redtext'>*</span>";?>
<div class="content" id="account-results">
        <table border="0" cellspacing="0" cellpadding="10" width="100%" id='contenttable'>
          <tr>
            <td colspan="2" style="padding-top:0px;" class="pageheader">
            	<table>
          		<tr>
            		<td valign="middle">
                    	<div class="page-title">
                        	Account Details
                    	</div>
                    </td>
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
            <form id="form1" name="form1" method="post" >
            
            <table width="100" border="0" cellspacing="0" cellpadding="8">
				  <tr>
                    <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">Account Title:<?php echo $indicator;?></td>
                    <td class="field" nowrap>
                      <?php  
			if(!empty($isview))
			{
				echo "<span class='viewtext'>".$transactiondetails['reference']."</span>";
			}else{					
					?>
                      <input type="text" name="title" id="title" class="textfield" size="30" value="<?php 
				  if(!empty($transactiondetails['reference'])){
				 	 echo $transactiondetails['reference'];
				  }?>"/>
                      <?php 
			}
				  ?>
                    </td>
                    </tr>
                    <tr>
                    <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">Description:</td>
                    <td class="field" nowrap>
                      <?php if(!empty($isview))
			{
				echo "<span class='viewtext'>".$accountdetails['description']."</span>";
			}else{
                    ?>

                      <textarea rows="2" cols="28" name="description" id="description" class="richtextfield" size="30"> <?php 
				  if(!empty($accountdetails['description'])){
				 	 echo $accountdetails['description'];
				  }?></textarea>
                      <?php  
			}
				  ?>
                   </td>
                  </tr>
                  <?php  if(empty($isview)){ ?>
				  <tr>
                    <td><?php if(!empty($i) || !empty($editid)){?><input name="editid" type="hidden" id="editid" value="<?php 
					if(!empty($i)){
						echo decryptValue($i);
					} else {
						echo $editid;
					}?>"/>
					<?php } ?></td>
                    <td>
                    <input type="button" onclick="saveAccount('<?php echo ((!empty($i))? '/i/'.$i : '') ;?>', 'title<>*description<>save<?php if(!empty($i) || !empty($editid)) echo '<>editid' ?>')" name="save" id="save" value="Save" class="button"/></td>
                    </tr>
                  <?php } ?>
                </table>
            
            </form>
            
            </td>
            </tr>
          
        </table>
    </div>
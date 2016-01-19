<?php
	if(empty($requiredfields))	$requiredfields = array();
	$indicator = (!empty($isview))? "": "<span class='redtext'>*</span>";

	if(empty($formdata['save'])) print "<div id='return-book-form-wrap'>";

?>

<script type="text/javascript">
$(document).ready(function() {
	
	$(function() {
    $("#returndate").datepicker({
      changeMonth: true,
      changeYear: true,
      yearRange: "-50:+50",
	  dateFormat: "yy-mm-dd"
    });
  });
	
});

</script>

<table border="0" cellspacing="0" cellpadding="10" width="100%" id='contenttable'>
          <tr>
            <td colspan="2" style="padding-top:0px;" class="pageheader">
            	<table>
          		<tr>
            		<td valign="middle"><div class="page-title">Return Book Details</div></td>
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
            <form id="form1" class="ajaxPost" name="form1" method="POST" action="<?php echo base_url();?>library/save_return_book_transaction<?php 
		if(!empty($i)) echo "/i/".$i;
		?>" >
            
            <table width="100" border="0" cellspacing="0" cellpadding="8">
                  <tr>
                    <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">ISBN Number :<?php echo $indicator;?></td>
                    <td class="field" nowrap>
                      <?php 
					  	if(!empty($formdata['isbnnumber'])) : 
                      		print $formdata['isbnnumber'];
                      	else:                      
                      		print format_notice("WARNING: Could not retrieve title information");
                        	exit;
                      	endif; 
					 ?>
                    </td>
                  </tr>
                  
                  <tr>
                    <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">Book Title :<?php echo $indicator;?></td>
                    <td class="field" nowrap>
                    <input name="callbackElement" id="call-back-element" value="return-book-form-wrap" type="hidden" />
                    <input name="listLinkToRefresh" id="list-link-to-refresh" value="manage-borrowers" type="hidden" />
                      <?php 
					  	if(!empty($formdata)) : 
                      		print $formdata['stocktitle'];
                      		print "<input type='hidden' name='bookid' value='".encryptValue($formdata['stockid'])."' id='bookid' />";
                      	else:                      
                      		print format_notice("WARNING: Could not retrieve title information");
                        	exit;
                      	endif; 
					 ?>
                    </td>
                  </tr>
                  
                  <tr>
                    <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">Book Author :<?php echo $indicator;?></td>
                    <td class="field" nowrap>
                    <input name="stockno" id="stockno" value="<?php print encryptValue($formdata['stockid']); ?>" type="hidden" />
                      <?php 
					  	if(!empty($formdata['author'])) : 
                      		print $formdata['author'];
                      		print "<input type='hidden' name='bookid' value='".encryptValue($formdata['stockid'])."' id='bookid' />";
                      	else:                      
                      		print format_notice("WARNING: Could not retrieve title information");
                        	exit;
                      	endif; 
					 ?>
                    </td>
                  </tr>
                  
                  <tr>
                    <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">Date Borrowed:<?php echo $indicator;?></td>
                    <td class="field" nowrap><?php 
					  	if(!empty($formdata['transactiondate'])) : 
                      		print date("D, j M, Y", GetTimeStamp($formdata['transactiondate']));
                      	else:                      
                      		print format_notice("WARNING: Could not retrieve title information");
                        	exit;
                      	endif; 
					 ?>
                    </td>
                  </tr>
                  
                  <tr>
                    <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">Expected Return Date:<?php echo $indicator;?></td>
                    <td class="field" nowrap><?php 
					  	if(!empty($formdata['expectedreturndate'])) : 
                      		print date("D, j M, Y", GetTimeStamp($formdata['expectedreturndate']));
                      	else:                      
                      		print format_notice("WARNING: Could not retrieve title information");
                        	exit;
                      	endif; 
					 ?>
                    </td>
                  </tr>
                  
                  <tr>
                    <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">Date of Return:<?php echo $indicator;?></td>
                    <td class="field" nowrap>
                    	<?php  
							if(!empty($isview))
							{
								echo "<span class='viewtext'>".date("D, j M, Y", GetTimeStamp($formdata['returndate']))."</span>";
							}else{
								echo get_required_field_wrap($requiredfields, 'returndate');
						?>
								<input type="text" name="returndate" id="returndate" class="textfield datepicker" size="30">
								  
						<?php  echo get_required_field_wrap($requiredfields, 'returndate', 'end');
							}
                    	?>
                  	</td>
                  </tr>
                  
                  <tr>
                    <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">Comments:<?php echo $indicator;?></td>
                    <td class="field" nowrap>
                    	<?php if(!empty($isview)): ?>
							<span class='viewtext'><?php print $formdata['comments']; ?></span>
						<?php else: ?>
								<textarea class="textarea" name="comments" cols="50" rows="5" ><?php if(!empty($formdata['comments'])) print $formdata['comments'];  ?></textarea>
						<?php endif; ?>
                    </td>
                  </tr>
                  
                  <?php  if(empty($isview)){ ?>
				  <tr>
                    <td><input type="hidden" name="saveitem" id="saveitem" value="Save" class="button"/></td>
                    <td><input type="submit" name="savebutton" id="savebutton" value="Save" class="button"/></td>
                    <td>&nbsp;</td>
                  </tr>
                  <?php } ?>
                </table>
            
            </form>
            
            </td>
            </tr>
          
        </table>
<?php if(empty($formdata['save']))	print "</div>"; ?>
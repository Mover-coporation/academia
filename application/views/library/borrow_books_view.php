<?php
	if(empty($requiredfields)) $requiredfields = array();
	$indicator = (!empty($isview))? "": "<span class='redtext'>*</span>";
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
<?php if(empty($save)) : ?>
<div id="borrow-details" class="" style="min-width:700px; min-height:500px">
<?php endif; ?>
<form id="form1" class="ajaxPost" name="form1" method="POST" action="<?php echo base_url();?>library/save_transaction<?php 
		if(!empty($i))
		{
			echo "/i/".$i;
		}
		?>" >
    <table width="100%" border="0" cellspacing="0" cellpadding="5" align="left">
        <tr>
          <td colspan="2" style="padding-top:0px;" class="pageheader">
              <table>
              <tr>
                  <td valign="middle"><div class="page-title">Borrow Details</div></td>
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
				  echo "<tr><td colspan='2'>".format_notice($msg)."</td></tr>";
			  }
		?>  
        <tr>
          <td width="20%" align="right" nowrap="nowrap"><b>Select borrower:</b></td>
          <td class="field" nowrap>
          		<input name="callbackElement" id="call-back-element" value="borrow-details" type="hidden" />
                <input name="listLinkToRefresh" id="list-link-to-refresh" value="manage-stock" type="hidden" />
				<?php  
					if(!empty($isview))
					{
						echo "<span class='viewtext'>".$formdata['borrower']."</span>";
					}else{
							echo get_required_field_wrap($requiredfields, 'borrower');
							?>
							  <input type="text" name="borrower" id="borrower" autocomplete="off" class="textfield" size="30">
						  <input name="borrower_searchby" type="hidden" id="borrower_searchby" value="borrower" />
						  <input name="borrower_identification" type="hidden" id="borrower_identification" value="" />
						  <input name="borrower_type" type="hidden" id="borrower_type" value="" />
						  <div id='borrower_results' style='max-height: 380px; overflow:hidden; position:absolute;border: 1px solid #98CBFF; background-color: #F7F7F7; display:none;'></div>
							  <?php  echo get_required_field_wrap($requiredfields, 'borrower', 'end');
					}
            ?>
                          
                            </td>
        </tr>
        <tr>
          <td width="20%" align="right" nowrap="nowrap"><b>Expected Return Date:</b></td>
          <td class="field" nowrap>
                              <?php  
                    if(!empty($isview))
                    {
                        echo "<span class='viewtext'>".$formdata['returndate']."</span>";
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
          <td align="right" nowrap="nowrap"><b>Add books:</b></td>
          <td class="field" nowrap>
                          <input type="text" name="select_book" id="select-book" class="textfield" autocomplete="off" size="30" />
                          <input name="select_book_searchby" type="hidden" id="select_book_searchby" value="borrower" />
                          <div id='select_book_results' style='max-height: 380px; overflow:hidden; position:absolute; border: 1px solid #98CBFF; background-color: #F7F7F7; display:none;'></div>
                            </td>
        </tr>
        <tr>
            <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="2">
                <div id="selected-books" style="width:100%">
                    <table id="selected-books-table" cellpadding="9" cellspacing="0">
                        <tr id="selected-books-header">
                            <td class="borrower_details_help">
                                <?php print format_notice("HELP: Search and select available books to add"); ?>
                            </td>
                        </tr>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </td>
        </tr>
        <tr>
        	<td colspan="2" align="center">
            	<input type="hidden" name="save" id="saveitem" value="Save" class="button"/>
            	<input type="submit" style="display:none" name="savebutton" id="save-borrow-transaction" value="Save" class="button"/>
            </td>
        </tr>
    </table>
  </form>
<?php if(empty($save)) print  '</div>'; ?>
<?php
	if(empty($requiredfields))	$requiredfields = array();
	$indicator = (!empty($isview))? "": "<span class='redtext'>*</span>";

	if(empty($formdata) || !empty($i)) print "<div id='stock-title-form-wrap'>";

?>

<table border="0" cellspacing="0" cellpadding="10" width="100%" id='contenttable'>
          <tr>
            <td colspan="2" style="padding-top:0px;" class="pageheader">
            	<table>
          		<tr>
            		<td valign="middle"><div class="page-title">Stock Details</div></td>
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
            <form id="form1" class="ajaxPost" name="form1" method="POST" action="<?php echo base_url();?>library/save_stock<?php
		if(!empty($i)) echo "/i/".$i;
		?>" >

            <table width="100" border="0" cellspacing="0" cellpadding="8">
				  <tr>
                    <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">Book title :<?php echo $indicator;?></td>
                    <td class="field" nowrap>
                    <input name="callbackElement" id="call-back-element" value="stock-title-form-wrap" type="hidden" />
                    <input name="listLinkToRefresh" id="list-link-to-refresh" value="manage-stock" type="hidden" />
                      <?php
					  	if(!empty($title_info)) :
                      		print $title_info['stocktitle']."<span class='viewtext'> <i>by</i> ".$title_info['author']."</span>";
                      		print "<input type='hidden' name='bookid' value='".encryptValue($title_info['stockid'])."' id='bookid' />";
                      	else:
                      		print format_notice("WARNING: Could not retrieve title information");
                        	exit;
                      	endif;
					 ?>
                    </td>
                  </tr>

                  <tr>
                    <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">ISBN Number :<?php echo $indicator;?></td>
                    <td class="field" nowrap>
                      <?php
					  if(!empty($isview))
					  {
						if(!empty($formdata['isbnnumber']))
						   echo "<span class='viewtext'>".$formdata['isbnnumber']."</span>";
						  else
							 echo "<span class='viewtext'><i>No ISBN</i></span>";

					  }else{
						  echo get_required_field_wrap($requiredfields, 'isbnnumber');
						  ?>
							<input type="text" name="isbnnumber" id="isbnnumber" class="textfield" size="30" value="<?php
						  if(!empty($formdata['isbnnumber'])){
						   echo $formdata['isbnnumber'];
						  }?>"/>
							<?php
							echo get_required_field_wrap($requiredfields, 'isbnnumber', 'end');
					  }
					  ?>
                      	<br />
                        <a href="javascript:void(0);" class="tooltip">
                        	<img src="<?php print base_url(); ?>images/info.png" />
                        	<div class="note_box">
                      			To add several books, separate their ISBN numbers<br /> by commas e.g 12345, 54321
                      		</div>
                        </a>
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
<?php if(empty($formdata) || !empty($i))	print "</div>"; ?>
<?php
if(empty($requiredfields)){
  $requiredfields = array();
}

$indicator = (!empty($isview))? "": "<span class='redtext'>*</span>";?>


<script language="JavaScript" type="text/javascript" src="<?php echo base_url();?>js/jquery.datepick.js"></script>

<script type="text/javascript">
$(document).ready(function(){
   $('#save').click(function(){
    updateFieldLayer('<?php echo base_url().'libary/load_borrower_form'.((!empty($i))? '/i/'.$i : '');?>','returndate<>stockid<>studentid<>datetaken<>items*COMBOBOX<>save<?php echo (!empty($i) || !empty($editid))? '<>editid' : ''; ?>','','borrowedbook-results','Please enter the required fields.');
    listRefresher.curContext='update-stock';
  });   
 
});
</script>

<script type="text/javascript">
$(document).ready(function() {
  
  $(function() {
  
    $(".datepicker").datepicker({
      changeMonth: true,
      changeYear: true,
      yearRange: "-50:+0",
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
            		<td valign="middle"><div class="page-title">Borrower Details</div></td>
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
            <form id="form1" name="form1" method="post" action="<?php echo base_url();?>library/load_borrower_form<?php 
		if(!empty($i))
		{
			echo "/i/".$i;
		}
    //print_r($stockdata);
			echo "/s/".encryptValue($stockdata['stockid']);
    ?>" >
            
            <table width="100" border="0" cellspacing="0" cellpadding="8">
            	  <tr>
                    <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">Item :</td>
                    <td class="field" nowrap>
                      <?php  
							echo "<span class='viewtext'>".$stockdata['stocktitle']." by ".$stockdata['author']."</span>";
				  	  ?>
                    </td>
                    
                  </tr>
                  <input type="hidden" name="stockid" value="<?php echo $stockdata['stockid']; ?>"  />
            	  <tr>
                    <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">Borrower :<?php echo $indicator;?></td>
                    <td class="field" nowrap>
                    <?php
					if(!empty($isview))
			{
				echo "<span class='viewtext'>".$formdata['firstname']." ".$formdata['middlename']." ".$formdata['lastname']."</span>";
			}else{
                        echo get_required_field_wrap($requiredfields, 'search');
                    ?>
                    <input name="search" type="text" id="search" size="35" class="textfield" value="<?php 
                                  if(!empty($formdata['firstname']) && !empty($formdata['middlename']) && !empty($formdata['lastname'])){
                                     echo $formdata['firstname']." ".$formdata['middlename']." ".$formdata['lastname'];
                                  }?>" onkeyup="startInstantSearch('search', 'searchby', '<?php echo base_url();?>search/load_results/type/student_list/layer/searchresults2/area/select_student');showPartLayer('searchresults2', 'fast');" onkeypress="return handleEnter(this, event)"/>
                    <?php  echo get_required_field_wrap($requiredfields, 'search', 'end'); }?>
                    <div id="searchresults2" style='max-height: 380px; overflow:hidden; position:absolute;border: 1px solid #98CBFF; background-color: #F7F7F7; display:none;'></div></td>
                    <td>&nbsp;<input name="searchby" type="hidden" id="searchby" value="firstname__lastname__middlename__studentno" /></td>
                  </tr>
                  <input id="studentid" type="hidden" name="studentid" value="<?php 
				  if(!empty($formdata['studentid'])){
				 	 echo $formdata['studentid'];
				  }; ?>" />   
                  
                  <tr>
                    <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">Issue Date :<?php echo $indicator;?></td>
                    <td class="field" nowrap>
                      <?php  
			if(!empty($isview))
			{
				echo "<span class='viewtext'>".$formdata['datetaken']."</span>";
			}else{
					echo get_required_field_wrap($requiredfields, 'datetaken');
					?>
                      <input type="text" name="datetaken" id="datetaken" class="textfield manyyearsdatefield" size="30" value="<?php 
				  if(!empty($formdata['datetaken'])){
				 	 echo $formdata['datetaken'];
				  }?>"/>
                      <?php  echo get_required_field_wrap($requiredfields, 'datetaken', 'end');
			}
				  ?>
                    </td>
                  </tr>                    
                  
				  <tr>
                    <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">Expected Date :<?php echo $indicator;?></td>
                    <td class="field" nowrap>
                      <?php  
			if(!empty($isview))
			{
				echo "<span class='viewtext'>".$formdata['returndate']."</span>";
			}else{
					echo get_required_field_wrap($requiredfields, 'returndate');
					?>
                      <input type="text" name="returndate" id="returndate" class="textfield manyyearsdatefield" size="30" value="<?php 
				  if(!empty($formdata['returndate'])){
				 	 echo $formdata['returndate'];
				  }?>"/>
                      <?php  echo get_required_field_wrap($requiredfields, 'returndate', 'end');
			}
				  ?>
                    </td>
                  </tr>                 
                  <tr>
                    <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">Item(s) :<?php echo $indicator;?></td>
                    <td nowrap><?php  
				echo get_required_field_wrap($requiredfields, 'item');?>
                  <select name="items[]" multiple="multiple" class="textfield" style="height:200px; width:270px;" >
                  	<?php
							if(!empty($isview))
								write_options_list($this,array('tname' => "library", 'searchstring'=>" WHERE stockid =".$stockdata['stockid']),'','serialnumber'); 
							else
								write_options_list($this,array('tname' => "library", 'searchstring'=>" WHERE stockid =".$stockdata['stockid']." AND isavailable=1"),'','serialnumber'); 
					?>
                  </select>
                  <?php echo get_required_field_wrap($requiredfields, 'item', 'end');
			
			
			?></td>
                  </tr>
                  <?php  if(empty($isview)){ ?>
				  <tr>
                    <td>&nbsp;</td>
                    <td><input type="submit" name="saveborrower" id="login" value="Save" class="button"/></td>
                    <td>&nbsp;</td>
                  </tr>
                  <?php } ?>
                </table>
            
            </form>
            
            </td>
            </tr>
          
        </table>
<!-- <body onload="myFunction()"> -->



<style>
    #search-student{width:400px;height: 30px;border-radius:8px;border:1px solid #999;}
</style>
<script type="text/javascript">
   

</script>

<?php
if(empty($requiredfields)){
  $requiredfields = array();
}

$indicator = (!empty($isview))? "": "<span class='redtext'>*</span>";?>





<script language="JavaScript" type="text/javascript" src="<?php echo base_url();?>js/jquery-1.9.1.min.js"></script>
<script language="JavaScript" type="text/javascript" src="<?php echo base_url();?>js/jquery.datepick.js"></script>
<script language="JavaScript" type="text/javascript" src="<?php echo base_url();?>js/jquery-ui.min.js"></script>

<!-- <link href="css/jquery-ui.css" rel="stylesheet" type="text/css" /> -->


<script type="text/javascript">
$(document).ready(function(){
   $('#save').click(function(){
    updateFieldLayer('<?php echo base_url().'libary/load_borrower_form'.((!empty($i))? '/i/'.$i : '');?>','returndate<>stockid<>studentid<>dateborrowed<>items*COMBOBOX<>save<?php echo (!empty($i) || !empty($editid))? '<>editid' : ''; ?>','','borrowedbook-results','Please enter the required fields.');
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

  <div class="has_autocomplete">
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
            <form id="form1" name="form1" method="post" >
            
            <table width="100" border="0" cellspacing="0" cellpadding="8">
<tr>
                    <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">Student Name :<?php echo $indicator;?></td>
                    <td class="field" nowrap>
                      <?php  
      if(!empty($isview))
      {
        echo "<span class='viewtext'>".$formdata['firstname']."</span>";
      }else{
          echo get_required_field_wrap($requiredfields, 'firstname');
          ?>
                      <input type="text" name="firstname" id="student-search" class="textfield" size="30" value="<?php 
          if(!empty($formdata['firstname'])){
           echo $formdata['firstname'];
          }?>"/>
                      <?php  echo get_required_field_wrap($requiredfields, 'firstname', 'end');
      }
          ?>
                    </td>
                  </tr> 


<tr>
                    <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">ISBN Number :<?php echo $indicator;?></td>
                    <td class="field" nowrap>
                      <?php  
      if(!empty($isview))
      {
        echo "<span class='viewtext'>".$formdata['libraryid']."</span>";
      }else{
          echo get_required_field_wrap($requiredfields, 'libraryid');
          ?>
                      <input type="text" name="libraryid" id="libraryid" class="textfield" size="30" value="<?php 
          if(!empty($formdata['libraryid'])){
           echo $formdata['libraryid'];
          }?>"/>
                      <?php  echo get_required_field_wrap($requiredfields, 'libraryid', 'end');
      }
          ?>
                    </td>
                  </tr> 

<!-- type begins -->
<tr>
                           <tr>
                    <td nowrap="nowrap" class="label">Type :<?php echo $indicator;?></td>
                    <td class="field" nowrap>
                       <?php  
      if(!empty($isview))
      {
        echo "<span class='viewtext'>".$data['groupname']."</span>";
      }else{
            ?>
                    <select name="type" id="type"  class="selectfield"> <option>Select</option>
               <option <?php if(!empty($data['type']) && $data['type'] == 'borrowing') echo 'selected="selected"'; ?> value="borrowing">borrowing</option>
               <option <?php if(!empty($data['type']) && $data['type'] == 'returning') echo 'selected="selected"'; ?> value="returning">returning</option>
                    </select>
                    <?php
            }
          ?>
                    </td>
                  </tr>
<!-- <label>Type</label> <input type="text" id="type" /><br /> -->
<!-- type ends -->
<tr>
                    <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">Date Borrowed :<?php echo $indicator;?></td>
                    <td class="field" nowrap>
                      <?php  
      if(!empty($isview))
      {
        echo "<span class='viewtext'>".$formdata['dateborrowed']."</span>";
      }else{
          echo get_required_field_wrap($requiredfields, 'dateborrowed');
          ?>
                      <input type="text" name="dateborrowed" id="dateborrowed" class="textfield datepicker" size="30" value="<?php 
          if(!empty($formdata['dateborrowed'])){
           echo $formdata['dateborrowed'];
          }?>"/>
                      <?php  echo get_required_field_wrap($requiredfields, 'dateborrowed', 'end');
      }
          ?>
                    </td>
                  </tr> 



  <?php  if(empty($isview)){ ?>
          <tr>  
                    <td>&nbsp;</td>

                    
                    <td><input type="button" onclick="saveStock('<?php echo ((!empty($i))? '/i/'.$i : '');?>', 'sectionid<>stocktitle<>stocknumber<>author<>save<?php if(!empty($i) || !empty($editid)) echo '<>editid' ?>')" name="save" id="save" value="Save" class="button"/></td>
                    <td>&nbsp;</td>
                  </tr>
                  <?php } ?>
</table>
            
            </form>
            
            </td>
            </tr>
          
        </table>
</div>
<!-- </body> -->
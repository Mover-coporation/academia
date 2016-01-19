<?php
if(empty($requiredfields)){
  $requiredfields = array();
}

$indicator = (!empty($isview))? "": "<span class='redtext'>*</span>";?>
<?php
	if(empty($requiredfields))	$requiredfields = array();
	$indicator = (!empty($isview))? "": "<span class='redtext'>*</span>";

	if(empty($formdata) || !empty($i)) print "<div id='book-title-form'>";
?>
<table border="0" cellspacing="0" cellpadding="10" width="100%" id='contenttable'>
          <tr>
            <td colspan="2" style="padding-top:0px;" class="pageheader">
              <table>
              <tr>
                <td valign="middle"><div class="page-title">Book Details</div></td>
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
                    <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">Section :<?php echo $indicator;?></td>
                    <td nowrap><?php
          if(!empty($isview))
      {
        echo "<span class='viewtext'>".$formdata['name']."</span>";
      }else{
        echo get_required_field_wrap($requiredfields, 'sectionid');?>
                  <select name="sectionid" class="selectfield" id="sectionid" style="height:35px; width:270px;" >


          <?php echo get_select_options($sections, 'id', 'name',(!empty($formdata['sectionid']))? $formdata['sectionid'] : '','Y','Select Section') ?>

                  </select>
                  <?php echo get_required_field_wrap($requiredfields, 'sectionid', 'end');
      }

      ?></td>
                  </tr>
          <tr id="title">
                    <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">Book Title :<?php echo $indicator;?></td>
                    <td class="field" nowrap>
                      <?php
      if(!empty($isview))
      {
        echo "<span class='viewtext'>".$formdata['stocktitle']."</span>";
      }else{
          echo get_required_field_wrap($requiredfields, 'stocktitle');
          ?>
                      <input type="text" name="stocktitle" id="stocktitle" class="textfield" size="30" value="<?php
          if(!empty($formdata['stocktitle'])){
           echo $formdata['stocktitle'];
          }?>"/>
                      <?php  echo get_required_field_wrap($requiredfields, 'stocktitle', 'end');
      }
          ?>
                    </td>
                  </tr>
                  <tr>
                    <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">Author :<?php echo $indicator;?></td>
                    <td class="field" nowrap>
                      <?php
      if(!empty($isview))
      {
        echo "<span class='viewtext'>".$formdata['author']."</span>";
      }else{
          echo get_required_field_wrap($requiredfields, 'author');
          ?>
                      <input type="text" name="author" id="author" class="textfield" size="30" value="<?php
          if(!empty($formdata['author'])){
           echo $formdata['author'];
          }?>"/>
                      <?php  echo get_required_field_wrap($requiredfields, 'author', 'end');
      }
          ?>
                    </td>
                  </tr>



                  <?php  if(empty($isview)){ ?>
          <tr>
                    <td>&nbsp;</td>
                    <td>
                      <?php if(!empty($i) || !empty($editid)){?><input name="editid" type="hidden" id="editid" value="<?php
          if(!empty($i)){
            echo decryptValue($i);
          } else {
            echo $editid;
          }?>"/><?php }


          ?>

                    <input type="button" onclick="saveBook('<?php echo ((!empty($i))? '/i/'.$i : '');?>', 'sectionid<>stocktitle<>author<>save<?php if(!empty($i) || !empty($editid)) echo '<>editid' ?>')" name="save" id="save" value="Save" class="button"/>
                    </td>


                    <td></td>
                  </tr>
                  <?php } ?>
                </table>

            </form>

            </td>
            </tr>

        </table>
<?php if(empty($formdata) || !empty($i))	print "</div>"; ?>
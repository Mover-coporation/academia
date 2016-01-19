<?php
if(empty($requiredfields)){
    $requiredfields = array();
}

$indicator = (!empty($isview))? "": "<span class='redtext'>*</span>";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <META HTTP-EQUIV="Pragma" CONTENT="no-cache">

    <meta name="description" content="">
    <meta name="keywords" content="">
    <title><?php echo SITE_TITLE." : Fee Details";?></title>
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo BASE_URL;?>favicon.ico">
    <?php
    echo "<script src='".base_url()."js/jquery.min.js' type='text/javascript'></script>";
    echo minimize_code($this, 'javascript');
    echo get_AJAX_constructor(TRUE);
    ?>
    <?php echo minimize_code($this, 'stylesheets');?>
    <style type="text/css">@import "<?php echo base_url();?>css/jquery.datepick.css";</style>
    <script language="JavaScript" type="text/javascript" src="<?php echo base_url();?>js/jquery.datepick.js"></script>
    <script>
        $(document).ready(function() {
            // date picker fields for many years
            $(".manyyearsdatefield").datepick({dateFormat: 'yyyy-mm-dd'});
        });
    </script>
</head>

<body>

<br />
<img src="<?php echo base_url();?>images/spacer.gif" width="255" height="1" />
</div>
</td>
<td valign="top" style="padding:0">
    <div class="tabBox" id="contentdiv">

        <table border="0" cellspacing="0" cellpadding="10" id='contenttable'>
            <tr>
                <td colspan="2" style="padding-top:0px;" class="pageheader">
                    <table>
                        <tr>
                            <td valign="middle"><div class="page-title">Debit Student Account</div></td>
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
                    <iframe id="SomeFrameName" style="display: none" name="SomeFrameName" src="about:blank"></iframe>
            <tr>
                <td valign="top">
                    <form id="form1" name="form1" method="post" target="SomeFrameName"   action="<?php echo base_url();?>finances/save_transaction<?php
                    if(!empty($i))
                    {
                        echo "/i/".$i;
                    }
                    ?>" >

                        <table width="100" border="0" cellspacing="0" cellpadding="8">
                            <tr>
                                <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">Student :</td>
                                <td class="field" nowrap>
                                    <?php
                                    echo "<span class='viewtext'>".$studentdetails['firstname'].' '.$studentdetails['lastname']."</span>
				<input type='hidden' value='".$studentdetails['id']."' name='student' />
				<input type='hidden' value='".encryptValue($studentdetails['id'])."' name='studenta'  id='studenta' />";
                                    ?>
                                </td>
                                <td rowspan="5" nowrap class="field" valign="top">
                                    <table>
                                        <tr>
                                            <td class="label">Notes</td></tr>
                                        <tr>
                                            <td valign="top" class="label" style="padding-top:0px"><?php if(!empty($isview))
                                                {
                                                    echo "<span class='viewtext'>".$formdata['notes']."</span>";
                                                }
                                                else
                                                {
                                                    ?>
                                                    <textarea name="notes" id="notes" rows="3" cols="40" class="richtextfield" ><?php
                                                        if(!empty($formdata['notes']))
                                                            echo $formdata['notes'];
                                                        ?></textarea>
                                                <?php } ?>
                                            </td></tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">Fee :</td>
                                <td class="field" nowrap>
                                    <?php if(!empty($isview))
                                    {
                                        echo "<span class='viewtext'>".$feedetails['fee']."</span>";
                                    }else{
                                        echo get_required_field_wrap($requiredfields, 'fee');
                                        ?>
                                        <select name="fee" id="frequency"  class="selectfield"> <?php echo get_select_options($fees, 'id', 'fee',(!empty($formdata['fee']))? $formdata['fee'] : '','Y','Select fee') ?>
                                        </select>
                                        <?php
                                        echo get_required_field_wrap($requiredfields, 'fee', 'end');
                                    } ?>
                                </td>
                            </tr>
                            <tr>
                                <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">Amount :<?php echo $indicator;?></td>
                                <td class="field" nowrap>
                                    <?php
                                    if(!empty($isview))
                                    {
                                        echo "<span class='viewtext'>".$formdata['amount']."</span>";
                                    }else{
                                        echo get_required_field_wrap($requiredfields, 'amount');
                                        ?><input type="hidden" name="type" value="DEBIT" />
                                        <input type="text" name="amount" id="amount" class="textfield" size="30" value="<?php
                                        if(!empty($formdata['amount'])){
                                            echo $formdata['amount'];
                                        }?>"/>
                                        <?php  echo get_required_field_wrap($requiredfields, 'amount', 'end');
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">Voucher No :</td>
                                <td class="field" nowrap>
                                    <?php
                                    if(!empty($isview))
                                    {
                                        echo "<span class='viewtext'>".$formdata['classes']."</span>";
                                    }else{
                                        echo get_required_field_wrap($requiredfields, 'classes');
                                        ?>
                                        <input type="text" name="voucher" id="voucher" class="textfield" size="30" value="<?php
                                        if(!empty($formdata['amount'])){
                                            echo $formdata['amount'];
                                        }?>"/>
                                        <?php  echo get_required_field_wrap($requiredfields, 'classes', 'end');
                                    }
                                    ?>
                                </td>
                            </tr>

                            <tr>
                                <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">Received By :</td>
                                <td class="field" nowrap>
                                    <?php
                                    echo "<span class='viewtext'>".$this->session->userdata('names')."</span>";
                                    ?>
                                </td>
                            </tr>

                            <tr>
                                <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">Paid in By :</td>
                                <td class="field" nowrap>
                                    <?php
                                    if(!empty($isview))
                                    {
                                        echo "<span class='viewtext'>".$formdata['payer']."</span>";
                                    }else{
                                        echo get_required_field_wrap($requiredfields, 'payer');
                                        ?>
                                        <input type="text" name="payer" id="payer" class="textfield" size="30" value="<?php
                                        if(!empty($formdata['payer'])){
                                            echo $formdata['payer'];
                                        }?>"/>
                                        <?php  echo get_required_field_wrap($requiredfields, 'payer', 'end');
                                    }
                                    ?>
                                </td>
                            </tr>


                            <tr>
                                <td nowrap="nowrap">&nbsp;</td>
                                <td>&nbsp;<?php if(!empty($i) || !empty($editid)){?><input name="editid" type="hidden" id="editid" value="<?php
                                    if(!empty($i)){
                                        echo decryptValue($i);
                                    } else {
                                        echo $editid;
                                    }?>"/><?php }


                                    ?></td>
                                <td>&nbsp;</td>
                            </tr>
                            <?php  if(empty($isview)){ ?>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td><input type="submit" name="save" id="login" value="Save" class="button"/></td>
                                    <td>&nbsp;</td>
                                </tr>
                            <?php } ?>
                        </table>

                    </form>

                </td>
            </tr>


        </table>

    </div>
</td>
</tr>

</table>
</body>
</html>

<div id="grading-results" style="width:950px">
<?php
if(empty($requiredfields)){
	$requiredfields = array();
}

$indicator = (!empty($isview))? "": "<span class='redtext'>*</span>";?>
<table border="0" cellspacing="0" width="100%" cellpadding="5" align="center">
    <tr>
        <td valign="top" style="padding:0">&nbsp;</td>
        <td valign="top" style="padding:0">
            <table border="0" cellspacing="0" cellpadding="10" width="100%" id='contenttable'>
                <tr>
                    <td colspan="2" style="padding-top:0px;" class="pageheader">
                        <table>
                            <tr>
                                <td valign="middle"><div class="page-title">Grading Scale Details</div></td>
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
                        <form id="form1" name="form1" method="post" action="<?php echo base_url();?>curriculum/save_subject<?php
		if(!empty($i))
		{
			echo "/i/".$i;
                        }
                        ?>" >

                        <table width="100%" border="0" cellspacing="0" cellpadding="8">
                            <tr>
                                <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">Grading Scale Name:<?php echo $indicator;?></td>
                                <td nowrap class="field">
                                    <?php
			if(!empty($isview))
			{
				echo "<span class='viewtext'>".$formdata['gradingname']."</span>";
                                    }else{
                                    echo get_required_field_wrap($requiredfields, 'gradingname');
                                    ?>
                                    <input type="text" name="gradingname" id="gradingname" class="textfield" size="30" value="<?php
				  if(!empty($formdata['gradingname'])){
				 	 echo $formdata['gradingname'];
				  }?>"/>
                                    <?php  echo get_required_field_wrap($requiredfields, 'gradingname', 'end');
			}
				  ?>
                                </td>
                                <td colspan="2" rowspan="4" nowrap class="field">
                                    <table cellpadding="5" cellspacing="0" id="grade_details">
                                    <?php
										if(!empty($grading_details))
										{
											echo '<tr class="listheader">
													<td>Label</td>
													<td>Value</td>
													<td>Min. Mark</td>
													<td>Max. Mark</td>
													<td>&nbsp;</td>
												  </tr>';
											$counter = 0;
											foreach($grading_details as $grade_info)
											{
												echo '<tr '.(($counter%2==0)? '' : 'class="stripe"').' id="grade_'.$grade_info['id'].'">
														<td>'.$grade_info['symbol'].'</td>
														<td>'.$grade_info['value'].'</td>
														<td>'.$grade_info['mingrade'].'</td>
														<td>'.$grade_info['maxgrade'].'</td>
														<td><input type="button" onclick="removeGrade(\'grade_'.$grade_info['id'].'\')" value="Remove"></td>
												    </tr>';
												$counter++;
											}
										}
										else
										{
											echo '<tr><td>No grades have been added</td></tr>';
										}
									?>
                                        
                                    </table>
                                    <input type="hidden" name="gradingdetails" id="gradingdetails" value="" />
                                </td>
                            </tr>

                            <tr>
                                <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">Description:</td>
                                <td nowrap class="field">
                                    <?php
			if(!empty($isview))
			{
				echo "<span class='viewtext'>".$formdata['description']."</span>";
                                    }else{

                                    ?>
                                    <input type="text" name="description" id="description" class="textfield" size="30" value="<?php
				  if(!empty($formdata['description'])){
				 	 echo $formdata['description'];
				  }?>"/>
                                    <?php } ?>
                                </td>
                            </tr>
                            <tr>
                                <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">Classes:</td>
                                <td nowrap class="field">
                                    <?php
			if(!empty($isview))
			{
				echo "<span class='viewtext'>".$classes."</span>";
                                    }else{
                                    echo get_required_field_wrap($requiredfields, 'classes');
                                    echo '<table cellpadding="5"><tr>';
                                    $class_ctr = 0;
                                    $selected_classes = array();
                                    if(!empty($formdata['classes']))
                                    $selected_classes = remove_empty_indices(explode('|', $formdata['classes']));

                                    foreach($classes as $class)
                                    {
                                    $class_ctr++;
                                    echo '<td style="padding-left:0" valign="middle"><input '.((in_array($class['id'], $selected_classes))? 'checked="checked"' : '').' onchange="update_classes('.count($classes).', \'classes\')" id="class'.$class_ctr.'" type="checkbox" value="'.$class['id'].'" name="classes[]" /></td><td style="padding-left:0">'.$class['class'].'</td>';

                                    if($class_ctr%3 == 0)	echo '</tr></tr>';
                                    }
                                    if($class_ctr%3 > 0)
                                    echo '<td colspan="'.($class_ctr%3).'">&nbsp;</td>';
                                    echo '</tr></table>';
                                    echo get_required_field_wrap($requiredfields, 'classes', 'end');
                                    }
                                    ?>

                                    <input type="hidden" value="<?php echo implode('|', $selected_classes); ?>" id="classes" name="classes" />
                                </td>
                            </tr>
                            <tr>
                                <td valign="top" nowrap="nowrap" class="label" style="padding-top:13px">Grade:<?php echo $indicator;?></td>
                                <td class="field" valign="top" nowrap>
                                    <table>
                                        <tr>
                                            <td>Symbol :</td>
                                            <td><input type="text" size="17" class="textfield" id="symbol" name="symbol" /></td>
                                        </tr>
                                        <tr>
                                            <td>Minimum Mark :</td>
                                            <td><input type="text" size="17" class="textfield" id="min_mark" name="min_mark" /></td>
                                        </tr>
                                        <tr>
                                            <td>Maximum Mark :</td>
                                            <td><input type="text" size="17" class="textfield" id="max_mark" name="max_mark" /></td>
                                        </tr>
                                        <tr>
                                            <td>Grade Value :</td>
                                            <td><input type="text" size="17" class="textfield" id="grade_value" name="grade_value" /></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"><a onclick="addGrade();" href="javascript:void(0)">Add Row</a></td>
                                        </tr>
                                    </table>
                                </td>

                            </tr>

                            <tr>
                                <td colspan="3" valign="top" nowrap="nowrap" class="label" style="padding-top:13px">
                                    <table id="grading_table">
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <?php  if(empty($isview)){ ?>
                            <tr>
                                <td><?php if(!empty($i) || !empty($editid)){?><input name="editid" type="hidden" id="editid" value="<?php
					if(!empty($i)){
						echo decryptValue($i);
					} else {
						echo $editid;
					}?>"/><?php }


					?></td>
                                <td><input type="button" onclick="saveGradingScheme('<?php echo ((!empty($i))? '/i/'.$i : '');?>', 'gradingname<>*description<>classes<>gradingdetails<>save<?php echo (!empty($i) || !empty($editid))? '<>editid' : ''; ?>')" name="save" id="save" value="Save" class="button"/></td>
                                <td>&nbsp;</td>
                            </tr>
                            <?php } ?>
                        </table>

                        </form>

                    </td>
                </tr>

            </table>
        </td>
    </tr>
</table>
</div>
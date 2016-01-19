<?php
$ajax_HTML = "<script src='".base_url()."js/jquery.min.js' type='text/javascript'></script>";
$javascript_HTML = "<script type='text/javascript' src='".base_url()."js/nyppex.js'></script>".get_AJAX_constructor(TRUE);
$combined_js_HTML = minimize_code($this, 'javascript');

$css_HTML = "<link href='".base_url()."css/nyppex.css' rel='stylesheet' type='text/css' />";
$combined_css_HTML = minimize_code($this, 'stylesheets');

$table_HTML = "";

#*********************************************************************************
# Displays forms used in AJAX when get_stocked_rentalsprocessing data on other forms without
# reloading the whole form.
#*********************************************************************************


#===============================================================================================
# Display for simple message results
#===============================================================================================
if(!empty($area) && in_array($area, array('verify_link_result', 'upload_user_photo', 'document_doesnt_exist', 'update_mark_sheet')))
{
	$table_HTML .= $msg;

}
else if(!empty($area) && $area == 'add_student')
{
	if(!empty($msg))
			$table_HTML .= format_notice($msg)."<BR>";

	if(!empty($status) && $status == 'SUCCESS')
	{
		$table_HTML .= '<input style="display:none" onchange="alert(\'hello\');" type="text" value="'.$status.'" />';
	}
}
else if(!empty($area) && $area == 'stock_details')
{
	$table_HTML .= $combined_js_HTML;

	if(!empty($stockdata))
	{
		if(!empty($msg))
		{
			$table_HTML .= format_notice($msg)."<BR>";
		}
		$table_HTML .= "<table width='100' border='0' cellspacing='0' cellpadding='8'>

				  <tr>
                    <td valign='top' nowrap='nowrap' class='label' style='padding-top:13px'>Title :</td>
                    <td class='field' nowrap><span class='viewtext'>".$stockdata['stocktitle']."</span>
                    </td>
                  </tr>

				  <tr>
                    <td valign='top' nowrap='nowrap' class='label' style='padding-top:13px'>Author :</td>
                    <td class='field' nowrap><span class='viewtext'>".$stockdata['author']."</span>

                    </td>
                  </tr>



                  <tr>
                    <td valign='top' nowrap='nowrap' class='label' style='padding-top:13px'>Stock Number :</td>
                    <td class='field' nowrap><span class='viewtext'>".$stockdata['stocknumber']."</span>
                    </td>
                  </tr>


              	  <tr>
                    <td valign='top' nowrap='nowrap' class='label' style='padding-top:13px'>Section :</td>
                    <td class='field' nowrap><span class='viewtext'>".$stockdata['name']."</span></td>
                  </tr>


                </table>";

	}
}


else if(!empty($area) && $area == 'upload_student_img')
{
	if($msg == "ERROR")
	{
		$table_HTML .= 'ERROR';
	}
	else
	{
		$table_HTML .= $msg;
	}
}

#===============================================================================================
# Search the students and users for possible borrowers
#===============================================================================================
else if(!empty($area) && $area == 'borrower_list')
{
	$table_HTML .= $combined_js_HTML;

	if(!empty($page_list))
	{
		$table_HTML .= "<table cellpadding='5' cellspacing='0' border='0'>
		<tr><td><b>Top ".(NUM_OF_ROWS_PER_PAGE * 2)." Search Results:</b></td><td align='right'><a href='javascript:void(0)' onClick=\"hideLayerSet('".$layer."')\"><img src='".base_url()."images/delete_icon.png' border='0' /></a></td></tr>";
		$counter = 0;
		foreach($page_list AS $row)
		{
			#Show one row at a time
			$table_HTML .= "<tr style='".get_row_color($counter, 2)."'><td colspan='2'><a href='javascript:void(0)' onClick=\"updateFieldValue('borrower', '".$row['userfirstname']. " ". $row['userlastname']. "');updateFieldValue('borrower_identification', '".encryptValue($row['userid'])."');updateFieldValue('borrower_type', '".encryptValue($row['typeOfUser'])."');hideLayerSet('".$layer."')\" class='bluelinks'>" .$row['userfirstname']. " ". $row['userlastname'] ."</a>";

			$table_HTML .= (!empty($row['typeOfUser']))? " (".$row['typeOfUser'].")" : "";

			$table_HTML .= "</td></tr>";
			$counter++;
		}
		$table_HTML .= "</table>";

	} else {
		$table_HTML .= "<table cellpadding='5' cellspacing='0' border='0'>
			<tr><td><b>Top ".NUM_OF_ROWS_PER_PAGE." Search Results:</b></td><td align='right'><a href='javascript:void(0)' onClick=\"hideLayerSet('".$layer."')\"><img src='".base_url()."images/delete_icon.png' border='0' /></a></td></tr></table>".
			format_notice("WARNING: No user meets search.");
	}
}


#===============================================================================================
# Search through the invemtory status
#===============================================================================================
else if(!empty($area) && $area == 'inventory_status')
{
	$table_HTML .= $combined_js_HTML;

	if(!empty($page_list))
	{
			$table_HTML .=  "<table width='100%' border='0' cellspacing='0' cellpadding='5'>
							<tr>
							<td width='1%' class='listheader'>&nbsp;</td>
							<td width='1%' class='listheader'>ISBN</td>
							<td class='listheader' nowrap>Title</td>
							<td class='listheader' nowrap>Author</td>
							<td class='listheader' nowrap>Status</td>
							<td class='listheader' nowrap>Date Taken</td>
							<td class='listheader' nowrap>Date Returned</td>
							</tr>";

			#print_r($page_list);
			$counter = 0;

			foreach($page_list AS $row)
			{
				$row_color_class = '';

				if($row['bookStatus'] == 'OUT'):
					$row_color_class = 'red_list_row';

				else:
					$row_color_class = (($counter%2)? '' : 'grey_list_row');
				endif;

				#Show one row at a time
				$table_HTML .=  "<tr id='list-row-" . $row['booklibraryId'] . "' class='listrow ".$row_color_class."'>
				<td class='leftListCell rightListCell' valign='top' nowrap>";


				$table_HTML .=  "<a href='javascript:void(0)' onclick=\"asynchDelete('".base_url()."library/delete_title/i/".encryptValue($row['booklibraryId'])."', 'Are you sure you want to remove this book? \\nThis operation can not be undone. \\nClick OK to confirm, \\nCancel to cancel this operation and stay on this page.','list-row-" . $row['booklibraryId'] . "');\" title=\"Click to remove the item.\"><img src='".base_url()."images/delete.png' border='0'/></a>&nbsp;&nbsp";

				if($row['bookStatus'] == 'OUT')
					$table_HTML .=  "&nbsp;&nbsp<a class=\"fancybox fancybox.ajax\" href='".base_url()."library/return_book_form/i/".encryptValue($row['booklibraryId'])."' title=\"Click to view return this book.\" class='fancybox fancybox.ajax contentlink'><img src='".base_url()."images/return_item.png' border='0'/></a>&nbsp;&nbsp";

				 $table_HTML .=  "</td>
				 <td><a class=\"fancybox fancybox.ajax\" href='".base_url()."library/load_stock_form/i/".encryptValue($row['booklibraryId'])."/a/".encryptValue("view")."' title=\"Click to view this item.\" class='fancybox fancybox.ajax contentlink'>".$row['isbnnumber']."</a></td>

				<td valign='top'>".$row['bookTitle']."</td>

				<td valign='top'>".$row['bookAuthor']."</td>

				<td  align='left' valign='top'>".$row['bookStatus']."</td>

				<td  align='left' valign='top'>".((!empty($row['lastBorrowTransDate']))? date("j M, Y", GetTimeStamp($row['lastBorrowTransDate'])) : 'N/A')."</td>

				<td  align='left' class='rightListCell' valign='top'>".((!empty($row['lastBorrowTransDate']) && $row['lastBorrowTransDate'] < $row['lastReturnTransDate'])? date("j M, Y", GetTimeStamp($row['lastReturnTransDate'])) : '')."</a></td>

				</tr>";

				$counter++;
			}


			$table_HTML .=  "<tr>
			<td colspan='5' align='right'  class='layer_table_pagination'>".
			pagination($this->session->userdata('search_total_results'), $rows_per_page, $current_list_page, base_url()."library/inventory_status/p/%d", 'results')
			."</td>
			</table>";

	} else {
		$table_HTML .= "<table cellpadding='5' cellspacing='0' border='0'>
			<tr><td><b>Top ".NUM_OF_ROWS_PER_PAGE." Search Results:</b></td><td align='right'><a href='javascript:void(0)' onClick=\"hideLayerSet('".$layer."')\"><img src='".base_url()."images/delete_icon.png' border='0' /></a></td></tr></table>".
			format_notice("WARNING: No book meets search.");
	}
}




#===============================================================================================
# Search for books from the library
#===============================================================================================
else if(!empty($area) && $area == 'library_books')
{
	$table_HTML .= $combined_js_HTML;

	if(!empty($page_list))
	{
		$table_HTML .= "<table cellpadding='5' cellspacing='0' border='0'>".
						"<tr>".
							"<td colspan='3'>".
								"<b>Top ".(NUM_OF_ROWS_PER_PAGE).
								" Search Results:</b>".
							"</td>".
							"<td align='right'>".
								"<a href='javascript:void(0)' onClick=\"hideLayerSet('".$layer."')\">".
									"<img src='".base_url()."images/delete_icon.png' border='0' />".
								"</a>".
							"</td>".
						"</tr>";

		$table_HTML .= "<tr>".
						"<td>ISBN Number</td>".
						"<td>Title</td>".
						"<td>Author</td>".
						"<td>Status</td>".
						"<td>&nbsp;</td>".
						"</tr>";

		$counter = 0;
		foreach($page_list AS $row)
		{
			#Show one row at a time
			$table_HTML .= "<tr id='selected-books-result-".$row['booklibraryId']."' style='".get_row_color($counter, 2)."'>".
							"<td><a href='javascript:void(0)' class='bluelinks'>" . $row['isbnnumber'] ."</a>";

			$table_HTML .= "</td>".
							"<td align='left'>".$row['bookTitle']."</td>".
							"<td align='left'>".$row['bookAuthor']."</td>".
							"<td>".(($row['bookStatus'] == 'IN')? "Available" : $row['bookStatus'])."</td>".
							"<td>".(($row['bookStatus'] == 'IN')? "<a href='javascript:void(0)' onClick=\"academiaLibrarySpace.addBookToBasket('".$row['booklibraryId']. "', '".$row['isbnnumber']. "', '".$row['bookTitle']. "', '".$row['bookAuthor']. "', '".$layer."');\" title='Click to add the book to the user catalogue'><img src='".base_url()."images/add_item.png' border='0'/></a>" : 'N/A')."</td>".
							"</tr>";

			$counter++;
		}
		$table_HTML .= "</table>";

	} else {
		$table_HTML .= "<table cellpadding='5' cellspacing='0' border='0'>
			<tr><td><b>Top ".NUM_OF_ROWS_PER_PAGE." Search Results:</b></td><td align='right'><a href='javascript:void(0)' onClick=\"hideLayerSet('".$layer."')\"><img src='".base_url()."images/delete_icon.png' border='0' /></a></td></tr></table>".
			format_notice("WARNING: No book meets search.");
	}
}


else if(!empty($area) && $area == 'class_subjects')
{
	$table_HTML .= $combined_js_HTML;

	if(!empty($page_list))
	{
		$table_HTML .= "<table cellpadding='5'><tr>";
		$counter = 0;
		foreach($page_list AS $row)
		{
			$counter++;

			$table_HTML .= '<td style="padding-left:0" valign="middle"><input class="subjects_for_select" id="subject_'.$row['id'].'" type="checkbox" value="'.$row['id'].'" name="subjects[]" /></td><td style="padding-left:0">'.$row['subject'].'</td>';

			if($counter%3 == 0) $table_HTML .= '</tr><tr>';
		}

		if($counter%3 > 0) $table_HTML .= '<td colspan="'.($counter%3).'">&nbsp;</td>';

		$table_HTML .= '</tr></table>';

	} else {
		$table_HTML .= format_notice("No subjects have been specified for ".$class);

	}
}


else if(!empty($area) && $area == 'out_inventory_details')
{
	$table_HTML .= $combined_js_HTML;

	if(!empty($page_list))
	{
		$table_HTML .= "<div id='searchresults'><table width='100%' border='0' cellspacing='0' cellpadding='5'>
				<tr>
				<td class='listheader' nowrap>Date Issued</td>
				<td class='listheader' nowrap>Issued to</td>
				<td class='listheader' nowrap>Quantity</td>
				</tr>";
		$counter = 0;
		foreach($page_list AS $row)
		{

			#Show one row at a time
			$table_HTML .= "<tr style='".get_row_color($counter, 2)."'>";

			 $table_HTML .= "

			<td valign='top'>".date("j M, Y", GetTimeStamp($row['datecreated']))."</td>

			<td valign='top'>".$row['firstname']." ".$row['lastname']."</td>

			<td valign='top'>".$row['quantity']."</td>


			</tr>";

			$counter++;
		}
		$table_HTML .= "</table></div>";

	} else {
		$table_HTML .= format_notice("There are no out history at the moment.");

	}
}

else if(!empty($area) && $area == 'in_inventory_details')
{
	$table_HTML .= $combined_js_HTML;

	if(!empty($page_list))
	{
		$table_HTML .= "<div id='searchresults'><table width='100%' border='0' cellspacing='0' cellpadding='5'>
				<tr>
				<td class='listheader' nowrap>Date Added</td>
				<td class='listheader' nowrap>Supplier</td>
				<td class='listheader' nowrap>Invoice No.</td>
				<td class='listheader' nowrap>Quantity</td>
				</tr>";
		$counter = 0;
		foreach($page_list AS $row)
		{

			#Show one row at a time
			$table_HTML .= "<tr style='".get_row_color($counter, 2)."'>";

			 $table_HTML .= "

			<td valign='top'>".date("j M, Y", GetTimeStamp($row['datecreated']))."</td>

			<td valign='top'>".$row['supplier']."</td>

			<td valign='top'>".$row['invoicenumber']."</td>

			<td valign='top'>".$row['quantity']."</td>


			</tr>";

			$counter++;
		}
		$table_HTML .= "</table></div>";

	} else {
		$table_HTML .= format_notice("There are no in history at the moment.");

	}
}

else if(!empty($area) && $area == 'inventory_item_details')
{
	$table_HTML .= $combined_js_HTML;

	if(!empty($itemdata))
	{
		if(!empty($msg))
		{
			$table_HTML .= format_notice($msg)."<BR>";
		}
		$table_HTML .= "<table width='100' border='0' cellspacing='0' cellpadding='8'>

				  <tr>
                    <td valign='top' nowrap='nowrap' class='label' style='padding-top:13px'>Item Name :</td>
                    <td class='field' nowrap><span class='viewtext'>".$itemdata['itemname']."</span>
                    </td>
                  </tr>

				  <tr>
                    <td valign='top' nowrap='nowrap' class='label' style='padding-top:13px'>Unit Specification :</td>
                    <td class='field' nowrap><span class='viewtext'>".$itemdata['unitspecification']."</span>

                    </td>
                  </tr>



                  <tr>
                    <td valign='top' nowrap='nowrap' class='label' style='padding-top:13px'>Reorder Level :</td>
                    <td class='field' nowrap><span class='viewtext'>".$itemdata['reorderlevel']."</span>
                    </td>
                  </tr>


                </table>";

	}
}

else if(!empty($area) && $area == 'borrower_details')
{
	$table_HTML .= $combined_js_HTML;

	if(!empty($stockdata))
	{
		if(!empty($msg))
		{
			$table_HTML .= format_notice($msg)."<BR>";
		}
		$table_HTML .= "<table width='100' border='0' cellspacing='0' cellpadding='8'>

				  <tr>
                    <td valign='top' nowrap='nowrap' class='label' style='padding-top:13px'>Item :</td>
                    <td class='field' nowrap><span class='viewtext'>".$stockdata['stocktitle']." by ".$stockdata['author']."</span>
                    </td>
                  </tr>

				  <tr>
                    <td valign='top' nowrap='nowrap' class='label' style='padding-top:13px'>Borrower :</td>
                    <td class='field' nowrap><span class='viewtext'>".$formdata['search']."</span>

                    </td>
                  </tr>



                  <tr>
                    <td valign='top' nowrap='nowrap' class='label' style='padding-top:13px'>Date Taken :</td>
                    <td class='field' nowrap><span class='viewtext'>".date("j M, Y", GetTimeStamp($formdata['datetaken']))."</span>
                    </td>
                  </tr>


              	  <tr>
                    <td valign='top' nowrap='nowrap' class='label' style='padding-top:13px'>Expected Date :</td>
                    <td class='field' nowrap><span class='viewtext'>".date("j M, Y", GetTimeStamp($formdata['returndate']))."</span></td>
                  </tr>

                  <tr>
                    <td valign='top' nowrap='nowrap' class='label' style='padding-top:13px'>Serial(s) :</td>
                    <td class='field' nowrap><span class='viewtext'>";
						foreach($page_list AS $val){
							$table_HTML .= $val['serialnumber']."&nbsp;&nbsp;";
						}
					$table_HTML .= "</span></td>
                  </tr>
                </table>";

	}
}


else if(!empty($area) && $area == 'stock_item_details')
{
	$table_HTML .= $combined_js_HTML;

	if(!empty($itemdata))
	{
		if(!empty($msg))
		{
			$table_HTML .= format_notice($msg)."<BR>";
		}
		$table_HTML .= "<table width='100' border='0' cellspacing='0' cellpadding='8'>

				  <tr>
                    <td valign='top' nowrap='nowrap' class='label' style='padding-top:13px'>Description :</td>
                    <td class='field' nowrap><span class='viewtext'>".$stockdata['stocktitle']."<span class='viewtext'> <i>by</i> ".$stockdata['author']."</span>
                    </td>
                  </tr>

				  <tr>
                    <td valign='top' nowrap='nowrap' class='label' style='padding-top:13px'>Date Added :</td>
                    <td class='field' nowrap><span class='viewtext'>".date("j M, Y", GetTimeStamp($itemdata['createdon']))."</span>

                    </td>
                  </tr>



                  <tr>
                    <td valign='top' nowrap='nowrap' class='label' style='padding-top:13px'>Serial Number :</td>
                    <td class='field' nowrap><span class='viewtext'>".$itemdata['serialnumber']."</span>
                    </td>
                  </tr>


              	  <tr>
                    <td valign='top' nowrap='nowrap' class='label' style='padding-top:13px'>ISBN Number :</td>
                    <td class='field' nowrap><span class='viewtext'>".$itemdata['isbnnumber']."</span></td>
                  </tr>


                </table>";

	}
}


#===============================================================================================
# Search the help list
#===============================================================================================
else if(!empty($area) && $area == 'search_help_list')
{
	$table_HTML .= $combined_js_HTML;

	if(!empty($page_list))
	{
		$table_HTML .= "<table width='100%' border='0' cellspacing='0' cellpadding='5'>";
			$counter = 0;
	foreach($page_list AS $row)
	{

		#Show one row at a time
		$table_HTML .= "<tr style='".get_row_color($counter, 2)."'>";
		$table_HTML .= "
		<td valign='top' width='1%'>&bull;</td>
		<td valign='top' width='99%' nowrap><a href='".base_url()."wiki/help/i/".encryptValue($row['helpcode']);
		$table_HTML .= "' title=\"Click to view the help details.\" class='bluelink'>".$row['title']."</a></td>
		</tr>";

		$counter++;
	}
		$table_HTML .=  "
		</table>";

	} else {
		$table_HTML .=  format_notice("There are no help topics at the moment.");
	}

}



#===============================================================================================
# Search the students list
#===============================================================================================
else if(!empty($area) && $area == 'student_list')
{
	$table_HTML .= $combined_js_HTML;

	if(!empty($page_list))
	{
	  $table_HTML .= "<table width='100%' border='0' cellspacing='0' cellpadding='5'>
		  <tr>
		  <td class='listheader' width='1%'>&nbsp;</td>
		  <td class='listheader' nowrap>Student &nbsp;<a class='fancybox fancybox.ajax' href='".base_url()."students/load_student_form' title='Click to add a student'><img src='".base_url()."images/add_item.png' border='0'/></a></td>
		  <td class='listheader' nowrap>Sponsor</td>
		  <td class='listheader' nowrap>Student No</td>
		  <td class='listheader' nowrap>Age</td>".
		  (($view_leave) ?
		  //viewing leave
		  "<td class='listheader' nowrap>Current Class</td>".
		  "<td class='listheader' nowrap>Leaves taken</td></tr>" :

		  //viewing all student detals
		  "<td class='listheader' nowrap>Admission Class & Term</td>
		  <td class='listheader' nowrap>Current Class</td>
		  <td class='listheader' nowrap>Date Added</td>
		  </tr>");

		$delete_students = check_user_access($this,'delete_students');

		$counter = 0;
		foreach($page_list AS $row)
		{
			#Show one row at a time

			#Get the admission term title and year
			if(!$view_leave){
				$admitterminfo = get_term_name_year($this, $row['admissionterm']);

				#Get the admission class
				$admitclass = get_class_title($this, $row['admissionclass']);
			}

			#Get the current class details
			$current_class = current_class($this, $row['id']);

			$table_HTML .= "<tr class='listrow ".(($counter%2)? '' : 'grey_list_row')."' id='student-list-row-". $row['id'] ."'>
				  <td class='leftListCell rightListCell' valign='top' nowrap>";


			if($view_leave){
				$table_HTML .= " &nbsp;&nbsp; <a href='".base_url()."students/load_leave_form/s/".encryptValue($row['id'])."' title=\"Click to assign ".$row['firstname']." leave.\">Assign leave</a>";
			}
			else
			{
				#if(check_user_access($this,'delete_deal')){
				$table_HTML .= "<input type=\"checkbox\" class=\"list_checkbox\"  name=\"selected_student[]\" id=\"selected_student_".$row['id']."\" />";
				#}

				if($delete_students){
				$table_HTML .= "&nbsp;&nbsp;<a href='javascript:void(0)' onclick=\"asynchDelete('".base_url()."students/delete_student/i/".encryptValue($row['id'])."', 'Are you sure you want to delete this student? \\nThis operation can not be undone. \\nClick OK to confirm, \\nCancel to cancel this operation and stay on this page.','student-list-row-" . $row['id'] . "');\" title=\"Click to remove this student.\"><img src='".base_url()."images/delete.png' border='0'/></a>";
				}

				#if(check_user_access($this,'update_deals')){
				//echo " &nbsp;&nbsp; <a onclick=\"updateFieldLayer('".base_url()."students/student_profile/i/".encryptValue($row['id'])."','','','contentdiv','');\" href='javascript:void(0)' title=\"Click to edit ".$row['firstname']."'s details.\"><img src='".base_url()."images/edit.png' border='0'/></a>";
			#}

			}
		 	$table_HTML .= "</td>
			<td valign='top' id='std_name_".$row['id']."'><a onclick=\"updateFieldLayer('".base_url()."students/student_profile/i/".encryptValue($row['id'])."','','','contentdiv','');\" href='javascript:void(0)'>".$row['firstname']." ".$row['lastname']."</a></td>
			<td valign='top'>".$row['sponsorfullname']."</td>
			<td valign='top'>".$row['studentno']."</td>
			<td valign='top' nowrap>".number_format(get_date_diff($row['dob'], date('m/d/Y h:i:s a', time()), 'days')/365,0)."</td>".
			(($view_leave) ?
			//viewing only leave
			"<td valign='top' id='std_class_".$row['id']."' nowrap>".$current_class['class'].", ".$current_class['term']." [".$current_class['year']."]</td>".
			"<td>".(empty($row['leaves'])? '<i>N/A</i>' :'<a href="'.base_url().'students/student_leave_list/i/'.encryptValue($row['id']).'" title="click to view '.$row['firstname'].'\' leaves.">'.$row['leaves'].'</a>')."</td></tr>" :
			"<td valign='top'>".$admitclass.", ".$admitterminfo['term']." [".$admitterminfo['year']."]</td>
			<td valign='top' id='std_class_".$row['id']."' nowrap>".$current_class['class'].", ".$current_class['term']." [".$current_class['year']."]</td>
			<td class='rightListCell' valign='top'>".date("j M, Y", GetTimeStamp($row['dateadded']))."</td>
			</tr>");

			$counter++;
		}


		$table_HTML .= "<tr>
		<td colspan='5' align='right'  class='layer_table_pagination'>".
			pagination($this->session->userdata('search_total_results'), $rows_per_page, $current_list_page, base_url().				"students/manage_students/p/%d", 'contentdiv').
		"</td>
		</tr>
		</table>";

	} else {
		$table_HTML .= "<table>
		<tr><td>".format_notice("WARNING: No student data meets search criteria.")."</td></tr></table>";
	}
}



#===============================================================================================
# Search for students to register
#===============================================================================================
else if(!empty($area) && $area == 'register_student')
{
	$table_HTML .= $combined_js_HTML;

	if(!empty($page_list))
	{
		$table_HTML .= "<table width='100%' border='0' cellspacing='0' cellpadding='5'>
		<tr>
		<td class='listheader'>&nbsp;</td>
		<td class='listheader' nowrap>Student</td>
		<td class='listheader' nowrap>Sponsor</td>
		<td class='listheader' nowrap>Student No</td>
		<td class='listheader' nowrap>Age</td>
		<td class='listheader' nowrap>Current Class</td>
		<td class='listheader' nowrap>Date Added</td>
		</tr>";

		$counter = 0;

		foreach($page_list AS $row)
		{
			#Show one row at a time

			#Get the current class details
			$current_class = current_class($this, $row['id']);

			$table_HTML .= "<tr style='".get_row_color($counter, 2)."'>
			<td valign='top' nowrap>";

			$table_HTML .= " &nbsp;&nbsp; <a href='".base_url()."students/load_registration_form/s/".encryptValue($row['id'])."' title=\"Click to register ".$row['firstname'].".\">Register student</a>";

			$table_HTML .= "</td>
			<td valign='top'>".$row['firstname']." ".$row['lastname']."</td>
			<td valign='top'>".$row['sponsorfullname']."</td>
			<td valign='top'>".$row['studentno']."</td>
			<td valign='top' nowrap>".number_format(get_date_diff($row['dob'], date('m/d/Y h:i:s a', time()), 'days')/365,0)."</td>".
			"<td valign='top' nowrap>".$current_class['class'].", ".$current_class['term']." [".$current_class['year']."]</td>
			<td valign='top'>".date("j M, Y", GetTimeStamp($row['dateadded']))."</td>
			</tr>";

			$counter++;
		}

	  /*$table_HTML .= "<!--<tr>
		<td colspan='5' align='right'  class='layer_table_pagination'>".
		pagination($this->session->userdata('search_total_results'), $rows_per_page, $current_list_page, base_url()."students/manage_student_register/p/%d")
		."</td>
		</tr>";
		*/
		$table_HTML .= "</table>";
	}
	else
	{
		$table_HTML .= format_notice("WARNING: No student meets your search criteria");
	}
}




#===============================================================================================
# Search the item list for item selection
#===============================================================================================
else if(!empty($area) && $area == 'select_items')
{
	$table_HTML .= $combined_js_HTML;

	$table_HTML .= "<table cellpadding='5' cellspacing='0' border='0'>
		<tr><td><b>Top ".NUM_OF_ROWS_PER_PAGE." Search Results:</b></td><td align='right'><a href='javascript:void(0)' onClick=\"hideLayerSet('".$layer."')\"><img src='".base_url()."images/delete_icon.png' border='0' /></a></td></tr>

		<tr><td colspan='2' style='padding-top:0px;'>";

	if(!empty($page_list))
	{
		$table_HTML .= "<table width='100%' border='0' cellspacing='0' cellpadding='5'>
          	<tr>
			<td class='listheader'>&nbsp;</td>
			<td class='listheader' nowrap>Item Name</td>
			<td class='listheader' nowrap>Price</td>
			</tr>";

		$counter = 0;
		foreach($page_list AS $row)
		{

			#Show one row at a time
			$table_HTML .= "<tr style='".get_row_color($counter, 2)."'>
			<td width='1%' valign='top' nowrap>";


			$table_HTML .= "<a href='javascript:void(0)' onClick=\"setInnerHtml('itemid','".$row['id']."');setInnerHtml('search','".$row['itemname']."');hideLayerSet('".$layer."');\" title=\"Click to select this item.\"><img src='".base_url()."images/add_icon.png' border='0'/></a>";


			$table_HTML .= "</td>

			<td width='1%' valign='top'>".$row['itemname']."</td>

			<td width='97%' valign='top'>".$row['price']."</td>

			</tr>";

			$counter++;
		}
		$table_HTML .= "</table>";

	} else {
		$table_HTML .= format_notice("No item meets search.");
	}
	$table_HTML .= "</td></tr></table>";
}

#===============================================================================================
# Search the student list for item selection
#===============================================================================================
else if(!empty($area) && $area == 'select_student')
{
	$table_HTML .= $combined_js_HTML;

	$table_HTML .= "<table cellpadding='5' cellspacing='0' border='0'>
		<tr><td><b>Top ".NUM_OF_ROWS_PER_PAGE." Search Results:</b></td><td align='right'><a href='javascript:void(0)' onClick=\"hideLayerSet('".$layer."')\"><img src='".base_url()."images/delete_icon.png' border='0' /></a></td></tr>

		<tr><td colspan='2' style='padding-top:0px;'>";

	if(!empty($page_list))
	{
		$table_HTML .= "<table width='100%' border='0' cellspacing='0' cellpadding='5'>
          	<tr>
			<td class='listheader'>&nbsp;</td>
			<td class='listheader' nowrap>Number</td>
			<td class='listheader' nowrap>Name</td>
			</tr>";

		$counter = 0;
		foreach($page_list AS $row)
		{

			#Show one row at a time
			$table_HTML .= "<tr style='".get_row_color($counter, 2)."'>
			<td width='1%' valign='top' nowrap>";


			$table_HTML .= "<a href='javascript:void(0)' onClick=\"setInnerHtml('studentid','".$row['id']."');setInnerHtml('search','".$row['firstname']." ".$row['middlename']." ".$row['lastname']."');hideLayerSet('".$layer."');\" title=\"Click to select this item.\"><img src='".base_url()."images/add_icon.png' border='0'/></a>";


			$table_HTML .= "<td width='97%' valign='top'>".$row['firstname']." ".$row['middlename']." ".$row['lastname']."</td>

			</tr>";

			$counter++;
		}
		$table_HTML .= "</table>";

	} else {
		$table_HTML .= format_notice("No person meets search.");
	}
	$table_HTML .= "</td></tr></table>";
}

#===============================================================================================
# Search the library stock list for stock selection
#===============================================================================================
else if(!empty($area) && $area == 'select_stock')
{
	$table_HTML .= $combined_js_HTML;

	$table_HTML .= "<table cellpadding='5' cellspacing='0' border='0'>
		<tr><td><b>Top ".NUM_OF_ROWS_PER_PAGE." Search Results:</b></td><td align='right'><a href='javascript:void(0)' onClick=\"hideLayerSet('".$layer."')\"><img src='".base_url()."images/delete_icon.png' border='0' /></a></td></tr>

		<tr><td colspan='2' style='padding-top:0px;'>";

	if(!empty($page_list))
	{
		$table_HTML .= "<table width='100%' border='0' cellspacing='0' cellpadding='5'>
          	<tr>
			<td class='listheader'>&nbsp;</td>
			<td class='listheader' nowrap>Stock Number</td>
			<td class='listheader' nowrap>Stock Title</td>
			</tr>";

		$counter = 0;
		foreach($page_list AS $row)
		{

			#Show one row at a time
			$table_HTML .= "<tr style='".get_row_color($counter, 2)."'>
			<td width='1%' valign='top' nowrap>";


			$table_HTML .= "<a href='javascript:void(0)' onClick=\"setInnerHtml('stockid','".$row['id']."');setInnerHtml('search','".$row['stocktitle']."');hideLayerSet('".$layer."');\" title=\"Click to select this item.\"><img src='".base_url()."images/add_icon.png' border='0'/></a>";


			$table_HTML .= "</td>

			<td width='1%' valign='top'>".$row['stocknumber']."</td>

			<td width='97%' valign='top'>".$row['stocktitle']."</td>

			</tr>";

			$counter++;
		}
		$table_HTML .= "</table>";

	} else {
		$table_HTML .= format_notice("No item meets search.");
	}
	$table_HTML .= "</td></tr></table>";
}

#===============================================================================================
# Search the inventory list
#===============================================================================================
else if(!empty($area) && $area == 'inventory_list')
{
	$table_HTML .= $combined_js_HTML;

	if(!empty($page_list))
	{
		$table_HTML .= "<table width='100%' border='0' cellspacing='0' cellpadding='5'>
          	<tr>
			<td class='listheader'>&nbsp;</td>
			<td class='listheader' nowrap>Date Added</td>
           	<td class='listheader' nowrap>Item Name</td>
			<td class='listheader' nowrap>Supplier</td>
			<td class='listheader' nowrap>Invoice Number</td>
			<td class='listheader' nowrap>Quantity</td>
			</tr>";

		$counter = 0;
		foreach($page_list AS $row)
		{

			#Show one row at a time
			$table_HTML .= "<tr style='".get_row_color($counter, 2)."'>
			<td valign='top' nowrap>";

			if(1){
			$table_HTML .= "<a href='javascript:void(0)' onclick=\"confirmDeleteEntity('".base_url()."inventory/delete_inventory/i/".encryptValue($row['inventoryid'])."', 'Are you sure you want to remove this inventory? \\nThis operation can not be undone. \\nClick OK to confirm, \\nCancel to cancel this operation and stay on this page.');\" title=\"Click to remove this inventory.\"><img src='".base_url()."images/delete.png' border='0'/></a>";
			}

			if(1){
			$table_HTML .= " <a href='".base_url()."inventory/load_inventory_form/i/".encryptValue($row['inventoryid'])."/a/".encryptValue($row['itemid'])."' title=\"Click to edit this inventory.\"><img src='".base_url()."images/edit.png' border='0'/></a>";
			}

			 $table_HTML .= "</td>

			<td valign='top'>".date("j M, Y", GetTimeStamp($row['datecreated']))."</td>

			<td valign='top'><a href='".base_url()."inventory/load_item_form/i/".encryptValue($row['itemid'])."/a/".encryptValue("view")."' title=\"Click to view this item.\">".$row['itemname']."</a></td>

			<td valign='top'>".$row['supplier']."</td>

			<td valign='top'>".$row['invoicenumber']."</td>

			<td valign='top'>".$row['quantity']."</td>



			</tr>";

			$counter++;
		}
		$table_HTML .= "</table>";

	} else {
		$table_HTML .= format_notice("No inventory meets search.");
	}
	$table_HTML .= "</td></tr></table>";
}

#===============================================================================================
# Search the item list
#===============================================================================================
else if(!empty($area) && $area == 'item_list')
{
	$table_HTML .= $combined_js_HTML;

	if(!empty($page_list))
	{
		$table_HTML .= "<table width='100%' border='0' cellspacing='0' cellpadding='5'>
          	<tr>
			<td class='listheader'>&nbsp;</td>
			<td class='listheader' nowrap>Item Name</td>
			<td class='listheader' nowrap>Remaining</td>
			<td class='listheader' nowrap>In</td>
			<td class='listheader' nowrap>Out</td>
			<td class='listheader' nowrap>Units</td>
			</tr>";

		$counter = 0;
		foreach($page_list AS $row)
		{
			$stocked = get_stocked($this, $row['id']);
			$sold = get_sold($this, $row['id']);
			$remaining = $stocked - $sold;

			#Assign zeros to empty values
			if(empty($stocked)) $stocked=0;
			if(empty($sold)) $sold=0;

			$table_HTML .= "<td valign='top'>".$row['firstname']." ".$row['lastname']."</td>

			</tr>";

			$counter++;
		}
		$table_HTML .= "</table>";

	} else {
		$table_HTML .= format_notice("No rental meets search.");
	}
	$table_HTML .= "</td></tr></table>";
}

#===============================================================================================
# Search the borrowers list
#===============================================================================================
else if(!empty($area) && $area == 'borrower_due_list')
{
	$table_HTML .= $combined_js_HTML;

	if(!empty($page_list))
	{
		$table_HTML .= "<table width='100%' border='0' cellspacing='0' cellpadding='5'>
          	<tr>
			<td class='listheader'>&nbsp;</td>
			<td class='listheader' nowrap>Date Borrowed</td>
           	<td class='listheader' nowrap>Title</td>
			<td class='listheader' nowrap>Returned / Borrowed</td>
			<td class='listheader' nowrap>Name</td>
			</tr>";

		$counter = 0;
		foreach($page_list AS $row)
		{
			#check expiry of rental period
			$currentdate = date("Y-m-d H:i:s");
			$borrower_status = check_borrower_status($this, $row['borrowerid']);
			#Show one row at a time
			if($row['reorderlevel'] >= $remaining)
				$table_HTML .= "<tr style='color:red;".get_row_color($counter, 2)."'><td valign='top' nowrap>";
			else
				$table_HTML .= "<tr style='".get_row_color($counter, 2)."'>
				<td valign='top' nowrap>";

			if(1){
			$table_HTML .= "<a href='javascript:void(0)' onclick=\"confirmDeleteEntity('".base_url()."library/delete_borrower/i/".encryptValue($row['borrowerid'])."', 'Are you sure you want to remove this borrower? \\nThis operation can not be undone. \\nClick OK to confirm, \\nCancel to cancel this operation and stay on this page.');\" title=\"Click to remove this borrower.\"><img src='".base_url()."images/delete.png' border='0'/></a>";
			}

			if(1 == 0){
			$table_HTML .= " <a href='".base_url()."library/load_borrower_form/i/".encryptValue($row['borrowerid'])."/s/".encryptValue($row['stockid'])."' title=\"Click to edit this borrower.\"><img src='".base_url()."images/edit.png' border='0'/></a>";
			}

			if(1 && $borrower_status != 0){
			$table_HTML .= "&nbsp;&nbsp;<a href='".base_url()."library/return_rental/i/".encryptValue($row['borrowerid'])."' title=\"Click to return items for this rental.\"><img src='".base_url()."images/returns.png' border='0'/></a>";
			}
			else{
				$table_HTML .= "&nbsp;&nbsp;";
			}

			 $table_HTML .= "</td>

			<td valign='top'>".date("j M, Y", GetTimeStamp($row['datetaken']))."</td>

			<td valign='top'><a href='".base_url()."library/load_stock_form/i/".encryptValue($row['stockid'])."/a/".encryptValue("view")."' title=\"Click to view this stock item.\" class='fancybox fancybox.ajax contentlink'>".$row['stocktitle']."</a></td>'

			<td valign='top'><a class='fancybox fancybox.ajax contentlink' href='".base_url()."library/load_borrower_form/i/".encryptValue($row['borrowerid'])."/s/".encryptValue($row['stockid'])."/a/".encryptValue("view")."' title=\"Click to view borrower details.\">".($row['copiestaken'] - $borrower_status)."/".$row['copiestaken']."</a></td>

			<td valign='top'>".$row['firstname']." ".$row['lastname']."</td>

			</tr>";

			$counter++;
		}
		$table_HTML .= "</table>";

	} else {
		$table_HTML .= format_notice("No rental meets search.");
	}
	$table_HTML .= "</td></tr></table>";
}

#===============================================================================================
# Search the borrowers list
#===============================================================================================
else if(!empty($area) && $area == 'borrower_defaulter_list')
{
	$table_HTML .= $combined_js_HTML;

	if(!empty($page_list))
	{
		$table_HTML .= "<table width='100%' border='0' cellspacing='0' cellpadding='5'>
          	<tr>
			<td class='listheader'>&nbsp;</td>
			<td class='listheader' nowrap>Date Borrowed</td>
           	<td class='listheader' nowrap>Title</td>
			<td class='listheader' nowrap>Returned / Borrowed</td>
			<td class='listheader' nowrap>Name</td>
			</tr>";

		$counter = 0;
		foreach($page_list AS $row)
		{
			#check expiry of rental period
			$currentdate = date("Y-m-d H:i:s");
			$borrower_status = check_borrower_status($this, $row['borrowerid']);
			#Show one row at a time
			if(!(($borrower_status != 0) && $currentdate > $row['returndate'])){
				continue;
				$table_HTML .= "<tr style='color:red;".get_row_color($counter, 2)."'>
				<td valign='top' nowrap>";
			}
			else
				$table_HTML .= "<tr style='".get_row_color($counter, 2)."'>
				<td valign='top' nowrap>";

			if(1){
			$table_HTML .= "<a href='javascript:void(0)' onclick=\"confirmDeleteEntity('".base_url()."library/delete_borrower/i/".encryptValue($row['borrowerid'])."', 'Are you sure you want to remove this borrower? \\nThis operation can not be undone. \\nClick OK to confirm, \\nCancel to cancel this operation and stay on this page.');\" title=\"Click to remove this borrower.\"><img src='".base_url()."images/delete.png' border='0'/></a>";
			}

			if(1 == 0){
			$table_HTML .= " <a href='".base_url()."library/load_borrower_form/i/".encryptValue($row['borrowerid'])."/s/".encryptValue($row['stockid'])."' title=\"Click to edit this borrower.\"><img src='".base_url()."images/edit.png' border='0'/></a>";
			}

			if(1 && $borrower_status != 0){
			$table_HTML .= "&nbsp;&nbsp;<a href='".base_url()."library/return_rental/i/".encryptValue($row['borrowerid'])."' title=\"Click to return items for this rental.\"><img src='".base_url()."images/returns.png' border='0'/></a>";
			}
			else{
				$table_HTML .= "&nbsp;&nbsp;";
			}

			 $table_HTML .= "</td>

			<td valign='top'>".date("j M, Y", GetTimeStamp($row['datetaken']))."</td>

			<td valign='top'><a href='".base_url()."library/load_stock_form/i/".encryptValue($row['stockid'])."/a/".encryptValue("view")."' title=\"Click to view this stock item.\" class='fancybox fancybox.ajax contentlink'>".$row['stocktitle']."</a></td>'

			<td valign='top'><a class='fancybox fancybox.ajax contentlink' href='".base_url()."library/load_borrower_form/i/".encryptValue($row['borrowerid'])."/s/".encryptValue($row['stockid'])."/a/".encryptValue("view")."' title=\"Click to view borrower details.\">".($row['copiestaken'] - $borrower_status)."/".$row['copiestaken']."</a></td>

			<td valign='top'>".$row['firstname']." ".$row['lastname']."</td>

			</tr>";

			$counter++;
		}
		$table_HTML .= "</table>";

	} else {
		$table_HTML .= format_notice("No rental meets search.");
	}
	$table_HTML .= "</td></tr></table>";
}

#===============================================================================================
# Search the returns list
#===============================================================================================
else if(!empty($area) && $area == 'returns_list')
{
	$table_HTML .= $combined_js_HTML;

	if(!empty($page_list))
	{
		$table_HTML .= "<table width='100%' border='0' cellspacing='0' cellpadding='5'>
          	<tr>
			<td class='listheader'>&nbsp;</td>
			<td class='listheader' nowrap>Date Returned</td>
			<td class='listheader' nowrap>Title</td>
			<td class='listheader' nowrap>Serial Number</td>
			</tr>";

		$counter = 0;
		foreach($page_list AS $row)
		{
			#check expiry of rental period
			$currentdate = date("Y-m-d H:i:s");
			#Show one row at a time

			$table_HTML .= "<tr style='".get_row_color($counter, 2)."'><td valign='top' nowrap>";

			if(1){
			$table_HTML .= "<a href='javascript:void(0)' onclick=\"confirmDeleteEntity('".base_url()."library/delete_return/i/".encryptValue($row['returnid'])."', 'Are you sure you want to remove this borrower? \\nThis operation can not be undone. \\nClick OK to confirm, \\nCancel to cancel this operation and stay on this page.');\" title=\"Click to remove this borrower.\"><img src='".base_url()."images/delete.png' border='0'/></a>";
			}

			if(1){
			$table_HTML .= " <a href='".base_url()."library/return_rental/i/".encryptValue($row['returnid'])."/s/".encryptValue($row['stockid'])."' title=\"Click to edit this return.\"><img src='".base_url()."images/edit.png' border='0'/></a>";
			}
			 $table_HTML .= "</td>

			<td valign='top'>".date("j M, Y", GetTimeStamp($row['returndate']))."</td>

			<td valign='top'><a class='fancybox fancybox.ajax contentlink' href='".base_url()."library/load_stock_form/i/".encryptValue($row['stockid'])."/a/".encryptValue("view")."' title=\"Click to view this stock item.\">".$row['stocktitle']."</a></td>

			<td valign='top'><a class='fancybox fancybox.ajax contentlink' href='".base_url()."library/load_stock_item_form/i/".encryptValue($row['item'])."/a/".encryptValue("view")."/s/".encryptValue($row['stockid'])."' title=\"Click to view this item.\">".$row['serialnumber']."</a></td>

			</tr>";

			$counter++;
		}
		$table_HTML .= "</table>";

	} else {
		$table_HTML .= format_notice("No rental meets search.");
	}
	$table_HTML .= "</td></tr></table>";
}


#===============================================================================================
# Search the stock list @mover edition
#===============================================================================================
else if(!empty($area) && $area == 'stock_list')
{
	$table_HTML .= $combined_js_HTML;

	if(!empty($page_list))
	{
		$table_HTML .= "<table width='100%' border='0' cellspacing='0' cellpadding='5'>

          	<tr><td class='listheader leftListCell'></td>
			<td class='listheader'>Title  &nbsp;<a class='fancybox fancybox.ajax' href='".base_url()."library/load_title_form' title='Click to add a Book'><img src='".base_url()."images/add_item.png' border='0'/></a>
			&nbsp;<a class='fancybox fancybox.ajax' href='".base_url()."library/borrow_books' title='Click to issue multiple books'><img src='".base_url()."images/book.png' border='0'/></a>
		</td>

			<td class='listheader' nowrap>Author </td>
           	<td class='listheader' nowrap>In</td>
			<td class='listheader' nowrap>Out</td>
			<td class='listheader' nowrap>Stocked</td>
          		</tr>";

		$counter = 0;
		foreach($page_list AS $row)
		{
            $stocked = get_all_stock_items($this, $row['id']);
            $in = get_stock_items($this, $row['id'], 1);
            $out = get_stock_items($this, $row['id'], 0);
            $remain = $in - $out;
            #print_r($row['id']);
			$stocked = get_stocked_rentals($this,$row['id']);

			if(empty($stocked)) $stocked=0;

			$borrowed = get_borrowed_rentals($this,$row['id']);

			if(empty($borrowed)) $borrowed=0;
			$returned = get_returned_rentals($this,$row['id']);

			if(empty($returned)) $returned=0;
			$remaining = $stocked + $returned - $borrowed;
			#Show one row at a time
			$table_HTML .= "<tr style='".get_row_color($counter, 2)."'>
			<td valign='top' class ='leftListCell'  nowrap>";

			if(1){
			$table_HTML .= " <a href='javascript:void(0)' onclick=\"asynchDelete('".base_url()."library/delete_title/i/".encryptValue($row['id'])."', 'Are you sure you want to remove this book? \\nThis operation can not be undone. \\nClick OK to confirm, \\nCancel to cancel this operation and stay on this page.','list-row-" . $row['id'] . "');\" title=\"Click to remove the item.\"><img src='".base_url()."images/delete.png' border='0'/></a>&nbsp;&nbsp";
            }

            if(1){
			$table_HTML .= " <a class=\"fancybox fancybox.ajax\" href='".base_url()."library/load_title_form/i/".encryptValue($row['id'])."' title=\"Click to edit this item.\"><img src='".base_url()."images/edit.png' border='0'/></a>&nbsp;&nbsp;";
            }
            if(1){

                $table_HTML .= " <a class=\"fancybox fancybox.ajax\" href='".base_url()."library/stock_title_form/s/".encryptValue($row['id'])."' title=\"Click to stock this item.\"><img src='".base_url()."images/box-icon.png' border='0'/></a>&nbsp;&nbsp;";
            }
            if($row['availableBooks'] > 0){
                $table_HTML .=" <a class=\"fancybox fancybox.ajax\" href='".base_url()."library/load_borrower_form/s/".encryptValue($row['id'])."' title=\"Click to lend out this item.\"><img src='".base_url()."images/book.png' border='0'/></a>";
            }
            $table_HTML .= " </td>
<td valign='top'>
		".$row['stocktitle']."
		</td>
			<td valign='top'>"

                .$row['author']."

			</td>

			<td valign='top'>".number_format($row['availableBooks'], 0, '.', ',')."</td>
			<td valign='top'>".number_format($row['unavailableBooks'], 0, '.', ',')."</td>
				<td valign='top'>".($row['availableBooks'] + $row['unavailableBooks'])."</td>




			</tr>";

			$counter++;
		}
		$table_HTML .= "</table>";

	} else {
		$table_HTML .= format_notice("No stock meets search.");
	}
	$table_HTML .= "</td></tr></table>";
}

#===============================================================================================
# Search the stock list
#===============================================================================================
else if(!empty($area) && $area == 'stock_items_list')
{
	$table_HTML .= $combined_js_HTML;

	if(!empty($page_list))
	{
		$table_HTML .= "<table width='100%' border='0' cellspacing='0' cellpadding='5'>
          	<tr>
			<td class='listheader'>&nbsp;</td>
			<td class='listheader' nowrap>Date Added</td>
           	<td class='listheader' nowrap>Serial Number</td>
			<td class='listheader' nowrap>Title</td>
			<td class='listheader' nowrap>ISBN Number</td>
			</tr>";

		$counter = 0;
		foreach($page_list AS $row)
		{

			#Show one row at a time
			$table_HTML .= "<tr style='".get_row_color($counter, 2)."'>
			<td valign='top' nowrap>";

			if(1){
			$table_HTML .= "<a href='javascript:void(0)' onclick=\"confirmDeleteEntity('".base_url()."library/delete_stock_item/i/".encryptValue($row['itemid'])."', 'Are you sure you want to remove this item? \\nThis operation can not be undone. \\nClick OK to confirm, \\nCancel to cancel this operation and stay on this page.');\" title=\"Click to remove this item.\"><img src='".base_url()."images/delete.png' border='0'/></a>";
			}

			if(1){
			$table_HTML .= " <a href='".base_url()."library/load_stock_item_form/i/".encryptValue($row['itemid'])."/s/".encryptValue($row['stockid'])."' title=\"Click to edit this item.\"><img src='".base_url()."images/edit.png' border='0'/></a>";
			}

			 $table_HTML .= "</td>

			<td valign='top'>".date("j M, Y", GetTimeStamp($row['datecreated']))."</td>

			<td valign='top'>".$row['serialnumber']."</a></td>

			<td valign='top'><a href='".base_url()."library/load_stock_item_form/i/".encryptValue($row['itemid'])."/a/".encryptValue("view")."/s/".encryptValue($row['stockid'])."' class='fancybox fancybox.ajax contentlink' title=\"Click to view this item.\">".$row['serialnumber']."</a></td>

			<td valign='top'><a href='".base_url()."library/load_stock_form/i/".encryptValue($row['stockid'])."/a/".encryptValue("view")."' title=\"Click to view this item.\" class='fancybox fancybox.ajax contentlink'>".$row['stocktitle']."</a></td>

			<td valign='top'>".$row['isbnnumber']."</td>

			</tr>";

			$counter++;
		}
		$table_HTML .= "</table>";

	} else {
		$table_HTML .= format_notice("No stock items meets search.");
	}
	$table_HTML .= "</td></tr></table>";
}

#===============================================================================================
# Search the transactions list
#===============================================================================================
else if(!empty($area) && $area == 'transactions_list')
{
	$table_HTML .= $combined_js_HTML;

	if(!empty($page_list))
	{
		$table_HTML .= "<table width='100%' border='0' cellspacing='0' cellpadding='5'>
          	<tr>
			<td class='listheader'>&nbsp;</td>
			<td class='listheader' nowrap>Date Issued</td>

			<td class='listheader' nowrap>Item Name</td>
			<td class='listheader' nowrap>Quantity</td>
			<td class='listheader' nowrap>Issued to:</td>
			</tr>";

		$counter = 0;
		foreach($page_list AS $row)
		{
			#Show one row at a time
			$table_HTML .= "<tr style='".get_row_color($counter, 2)."'>
			<td valign='top' nowrap>";

			if(1){
			$table_HTML .= "<a href='javascript:void(0)' onclick=\"confirmDeleteEntity('".base_url()."students/delete_transaction/i/".encryptValue($row['transactionid'])."', 'Are you sure you want to remove this transaction? \\nThis operation can not be undone. \\nClick OK to confirm, \\nCancel to cancel this operation and stay on this page.');\" title=\"Click to remove this transaction.\"><img src='".base_url()."images/delete.png' border='0'/></a>";
			}

			if(1){
			$table_HTML .= " <a href='".base_url()."inventory/load_transaction_form/i/".encryptValue($row['transactionid'])."/s/".encryptValue($row['id'])."' title=\"Click to edit this transaction.\"><img src='".base_url()."images/edit.png' border='0'/></a>";
			}

			 $table_HTML .= "</td>

			<td valign='top'>".date("j M, Y", GetTimeStamp($row['dateadded']))."</td>

			<td valign='top'><a class='fancybox fancybox.ajax contentlink' href='".base_url()."inventory/load_item_form/i/".encryptValue($row['itemid'])."/a/".encryptValue("view")."' title=\"Click to view this item.\">".$row['itemname']."</a></td>

			<td valign='top'>".$row['quantity']."</td>

			<td valign='top'><a href='".base_url()."students/load_student_form/i/".encryptValue($row['id'])."/a/".encryptValue("view")."' title=\"Click to view this student.\">".$row['firstname']." ".$row['middlename']." ".$row['lastname']."</a></td>

			</tr>";

			$counter++;
		}
		$table_HTML .= "</table>";

	} else {
		$table_HTML .= format_notice("No transaction meets search.");
	}
	$table_HTML .= "</td></tr></table>";
}



#===============================================================================================
# Search the fund symbol list
#===============================================================================================
else if(!empty($area) && $area == 'fund_symbol_list')
{
	$table_HTML .= $combined_js_HTML;

	if(!empty($page_list))
	{
		$table_HTML .= "<table cellpadding='5' cellspacing='0' border='0'>
		<tr><td><b>Top ".NUM_OF_ROWS_PER_PAGE." Search Results:</b></td><td align='right'><a href='javascript:void(0)' onClick=\"hideLayerSet('".$layer."')\"><img src='".base_url()."images/delete_icon.png' border='0' /></a></td></tr>";
		$counter = 0;
		foreach($page_list AS $row)
		{
			#Show one row at a time
			$table_HTML .= "<tr style='".get_row_color($counter, 2)."'><td colspan='2'>";

			#Determine whether to use the edit link
			if($editlink)
			{
				$table_HTML .= "<a href='".base_url()."marketdata/add_fund/i/".encryptValue($row['id'])."' class='bluelinks'>".$row['symbol']."</a> (".$row['description'].")";
			}
			else if($type == 'portfolio_fundsymbol')
			{
				$table_HTML .= "<a href='javascript:void(0)' onClick=\"updateFieldValue('fundsymbol', '".$row['fundsymbol']."');updateFieldValue('dealid', '".$row['dealid']."');hideLayerSet('".$layer."')\" class='bluelinks'>".$row['fundsymbol']."</a> ";

				$table_HTML .= (!empty($row['description']))? "(".$row['description'].") ": "";

				$table_HTML .= "for Deal: ".$row['dealdescription']." (".$row['dealstamp']." <b>$".addCommas(removeCommas($row['dealamount'])/1000000)."MM</b>)";
			}
			else
			{
				$table_HTML .= "<a href='javascript:void(0)' onClick=\"updateFieldValue('fundsymbol', '".$row['symbol']."');hideLayerSet('".$layer."')\" class='bluelinks'>".$row['symbol']."</a> (".$row['description'].")";
			}

			$table_HTML .= "</td></tr>";
			$counter++;
		}
		$table_HTML .= "</table>";

	} else {
		$table_HTML .= "<table width=\"100%\"><tr><td align='right'><a href='javascript:void(0)' onClick=\"hideLayerSet('".$layer."')\"><img src='".base_url()."images/delete_icon.png' border='0' /></a></td></tr></table>".
		format_notice("No symbol meets search.");
	}
}


#===============================================================================================
# Search the fund list
#===============================================================================================
else if(!empty($area) && $area == 'fund_list')
{
	$table_HTML .= $combined_js_HTML;

	if(!empty($page_list))
	{
		#Variables to control display of the market quote report link and action columns if user is
		#searching within the market quote report list
		$mqr_link = "";
		$action_column_headers = "";
		$graph_column_header = "";

		if(empty($mqr))
		{
			$action_column_headers = '<td class="listheader">&nbsp;</td>
									 <td class="listheader">&nbsp;</td>';

		}
		else if(!empty($mqr) && decryptValue($mqr) == 'true')
		{
			$graph_column_header = '<td class="listheader" width="1%">&nbsp;</td>';
		}

		$table_HTML .= '<table width="100%" border="0" cellspacing="0" cellpadding="5">
                       <tr>'.$graph_column_header.$action_column_headers.
                        '<td class="listheader">Symbol</td>
                        <td class="listheader">Fund Name</td>
                        <td class="listheader">Sector</td>
						<td class="listheader">Fund Type</td>
                        <td class="listheader">Rating</td>
                        <td class="listheader">Price</td>
					  </tr>';

		$counter = 0;
		foreach($page_list AS $row)
		{
			#Show one row at a time
			$table_HTML .= "<tr style='".get_row_color($counter, 2)."'>";

			if(empty($mqr))
			{
				$table_HTML .= "<td nowrap>";

				if(empty($up))
				{

					if(check_user_access($this,'delete_fund'))
					{
						$table_HTML .= "<a  href=\"javascript:void(0)\" onclick=\"confirmDeleteEntity('".base_url()."marketdata/delete_fund". encryptValue($row['id'])."', 'Are you sure you want to delete this fund? \\nThis operation is permanent and cannot be undone.\\nClick OK to confirm, \\nCancel to cancel this operation and stay on this page.')\" title=\"Click to delete this fund\"><img src=\"".base_url()."images/delete.png\" border=\"0\"/></a> ";
					}

					if(check_user_access($this,'update_fund'))
					{
						$table_HTML .= "<a  href=\"".base_url()."marketdata/add_fund/i/". encryptValue($row['id'])."\" title=\"Click to update this fund\"><img src=\"".base_url()."images/edit.png\" border=\"0\"/></a> ";
					}

				}

				$table_HTML .= "</td><td>";

				if(check_user_access($this,'update_fund_prices')){

					$table_HTML .=  "<div id='".$row['id']."_div' style='display:block;'><a href='javascript:void(0)' onclick=\"updateFieldLayer('".base_url()."marketdata/fund_price_form/i/".encryptValue($row['id'])."/cv/".encryptValue($row['fundvalue'])."', '','".$row['id']."_div','".$row['id']."_edit_div','')\" title=\"Click to update this fund's price.\" class='contentlink'><img src='".base_url()."images/price_icon.png' border='0'></a></div><div id='".$row['id']."_edit_div' style='display:none;position:absolute;margin-top: -10px;'></div>";

					$table_HTML .=  "</td>".
									"<td>".$row['symbol']."</td>";
				}
			}
			elseif(!empty($mqr) && decryptValue($mqr) == 'true')
			{
				$mqr_link = "<td nowrap=\"nowrap\"><div id=\"curvalue_".$row['id']."\" ><a href='".base_url()."marketdata/view_market_index/i/".encryptValue($row['id'])."' title='Click to view the market charts.'><img src='".base_url()."images/graph_icon.png' /></a></div></td>";
			}

			$table_HTML .= $mqr_link;
			$table_HTML .= (!empty($mqr) && decryptValue($mqr) == 'true') ? "<td nowrap=\"nowrap\"><a href='".base_url()."marketdata/view_fund_ytd/i/".encryptValue($row['id'])."' class=\"fancybox fancybox.ajax contentlink\" title=\"Click to view the ".$row['symbol']." YTD trend. \">".$row['symbol']."</a></td>": "";
			$table_HTML .= "<td>".$row['description']."</td>".
						   "<td>".ucfirst($row['fundsector'])."</td>".
						   "<td>".$row['typename']."</td>".
						   "<td>".$row['rating']."</td>".
					       "<td><div id=\"curvalue_".$row['id']."\" >".$row['fundvalue']."</div></td>
						   </tr>";

			$counter++;
		}

		$table_HTML .= "</table>";


	} else {
		$table_HTML .= format_notice("No fund meets the search criteria.");
	}
}


#===============================================================================================
# Search the report list
#===============================================================================================
else if(!empty($area) && $area == 'report_list')
{
	$table_HTML .= $combined_js_HTML;

	if(!empty($page_list))
	{

		$table_HTML .= '<table width="100%" border="0" cellspacing="0" cellpadding="5">
                      <tr>
                        <td class="listheader" width="1%">&nbsp;</td>
                        <td class="listheader">Report Name</td>';

		if($selected_reports == 'false')
		{
			$table_HTML .= '<td class="listheader">Accessed By</td>';
		}

		$table_HTML .= '</tr>';

		$counter = 0;
		foreach($page_list AS $row)
		{
			#Show one row at a time
			$table_HTML .= "<tr style='".get_row_color($counter, 2)."'>".
						   	"<td nowrap>";
			if(!isset($archives) && $selected_reports == 'false')
			{

				if(check_user_access($this,'delete_report'))
				{
					$table_HTML .= " <a  href=\"javascript:void(0)\" onclick=\"confirmDeleteEntity('".base_url()."reports/archive_report/i/". encryptValue($row['id'])."', 'Are you sure you want to delete this report? The report will be moved to the archives section.\\nClick OK to confirm, \\nCancel to cancel this operation and stay on this page.');\" title=\"Click to delete this report\"><img src=\"".base_url()."images/delete.png\" border=\"0\"/></a> ";
				}

				if(check_user_access($this,'update_report'))
				{
					$table_HTML .= "<a  href=\"".base_url()."reports/add_report/i/". encryptValue($row['id'])."\" title=\"Click to update this report\"><img src=\"".base_url()."images/edit.png\" border=\"0\"/></a> ";
				}

				if(check_user_access($this,'update_report_access'))
				{
					$table_HTML .= "<a  href=\"".base_url()."reports/report_access_control/i/".encryptValue($row['id'])."\" title=\"Click to edit this report's user access lists\"><img src=\"".base_url()."images/patient_history.png\" border=\"0\"/></a> ";
				}

			}

			if($selected_reports == 'true')
			{
				$table_HTML .= "<a href='javascript:void(0)' onClick=\"updateFieldLayer('".base_url()."reports/report_access_control/i/".encryptValue($row['id'])."','','".$layer."','','');\" title=\"Click to select this report.\"><img src='".base_url()."images/add_icon.png' border='0'/></a>";
			}


			if(isset($archives))
			{
				$table_HTML .= " <a  href=\"javascript:void(0)\" onclick=\"confirmDeleteEntity('".base_url()."reports/archive_report/i/". encryptValue($row['id'])."', 'Are you sure you want to restore this report ? The report will be visible in the report list.\\nClick OK to confirm, \\nCancel to cancel this operation and stay on this page.')\" title=\"Click to restore this report\"><img src=\"".base_url()."images/restore.png\" border=\"0\"/></a>";
			}

			if(isset($archives))
			{
				$table_HTML .= " <a  href=\"javascript:void(0)\" onclick=\"confirmDeleteEntity('".base_url()."reports/delete_report/i/". encryptValue($row['id'])."', 'Are you sure you want to delete this report ? The report will be deleted permanently.\\nClick OK to confirm, \\nCancel to cancel this operation and stay on this page.')\" title=\"Click to delete this report\"><img src=\"".base_url()."images/delete.png\" border=\"0\"/></a>";
			}

			$table_HTML .= "</td>";

			if($selected_reports == 'false')
			{
				$table_HTML .= "<td nowrap=\"nowrap\"><a href=\"".base_url()."documents/force_download/f/".encryptValue('reports')."/u/".encryptValue($row['fileurl'])."\" class='contentlink' >".$row['reportname']."</a></td>";

				$table_HTML .= "<td nowrap=\"nowrap\"><a href='".base_url()."reports/report_access_list/i/".encryptValue($row['id'])."' class='fancybox fancybox.ajax contentlink' >View list</a></td>";
			}
			else
			{
				$table_HTML .= "</td>".
						   "<td nowrap=\"nowrap\"><span>".$row['reportname']."</span></td>";
			}

			$table_HTML .= "</tr>";

			$counter++;
		}
		$table_HTML .= "</table>";


	} else {
		$table_HTML .= format_notice("No report meets the search criteria.");
	}
}

#===============================================================================================
# Search the organization list
#===============================================================================================
else if(!empty($area) && $area == 'organization_list')
{
	$table_HTML .= $combined_js_HTML;

	if(!empty($page_list))
	{
		$table_HTML .= "<table cellpadding='5' cellspacing='0' border='0'>
		<tr><td><b>Top ".NUM_OF_ROWS_PER_PAGE." Search Results:</b></td><td align='right'><a href='javascript:void(0)' onClick=\"hideLayerSet('".$layer."')\"><img src='".base_url()."images/delete_icon.png' border='0' /></a></td></tr>";
		$counter = 0;
		foreach($page_list AS $row)
		{
			#Show one row at a time
			$table_HTML .= "<tr style='".get_row_color($counter, 2)."'><td colspan='2'><a href='javascript:void(0)' onClick=\"updateFieldValue('organizationname<>companyid<>addressline1<>addressline2<>city<>state<>zipcode<>telephone', '".$row['organizationname']."<>".$row['id']."<>".$row['contactaddressline1']."<>".$row['contactaddressline2']."<>".$row['contactcity']."<>".$row['contactstate']."<>".$row['contactzipcode']."<>".$row['contactphone']."');hideLayerSet('".$layer."')\" class='bluelinks'>".$row['organizationname']."</a></td></tr>";
			$counter++;
		}
		$table_HTML .= "</table>";

	} else {
		$table_HTML .= "<table width=\"100%\"><tr><td align='right'><a href='javascript:void(0)' onClick=\"hideLayerSet('".$layer."')\"><img src='".base_url()."images/delete_icon.png' border='0' /></a></td></tr></table>".
		format_notice("No organization meets the search criteria.");
	}
}


#===============================================================================================
# Get an access group's permissions
#===============================================================================================
else if(!empty($area) && $area == 'get_group_permissions')
{
	$table_HTML .= $combined_js_HTML;

	if(count($groupdetails) < 1)
	{
		$table_HTML .= format_notice("Please select an access group.");
	}
	else
	{
		if(!empty($page_list))
		{
			$table_HTML = "<table align=\"left\" width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"3\">".
					       "<tr>".
                          "<td align=\"left\" colspan=\"2\" style=\"background-color:#E6E6E6; font-style:italic;font-size: 13px;\">".
						  "<b>Access Group :</b> ".$groupdetails['groupname'].
						  "</td></tr>".
						  "<tr>".
                           "<td align=\"left\" colspan=\"2\" height=\"10\"></td></tr>".
						   "<tr><td colspan=\"2\">";

				$counter = 0;
				$oldsection = "";

				foreach($all_permissions AS $row){
					  #if(($userdetails['isadmin'] == 'Y' && $row['accessfor'] == 'admin') || ($userdetails['isadmin'] == 'N' && $row['accessfor'] == ''))
					 # {
					  $section = $row['section'];

					  if($section != $oldsection){
					  	if($oldsection != ''){
							$table_HTML .=  "</table></div><br>";
						}

						 $table_HTML .= "<a href=\"javascript:showHideLayer('".$row['section']."_div')\">".ucfirst($row['section'])."</a><hr><div id='".$row['section']."_div' style='display:none'>

						 <table width='100%' border='0' cellspacing='0' cellpadding='3'>";
					  }


					  $table_HTML .= "<tr style='".get_row_color($counter, 2)."'>
                          <td align=\"left\" style='font-size: 13px;' width='1%' nowrap><input name='permissions[]' id='permission_".$row['id']."' onClick=\"selectCheckBoxList_WithUncheck('permission_".$row['id']."', '".get_related_permissions($this, $row['id'])."', '".get_related_permissions($this, $row['id'],'uncheck')."', 'permission_')\" type='checkbox' value='".$row['id']."'";
						if(in_array($row['id'], $permissions_list)){
						$table_HTML .= " checked";
						}
					  $table_HTML .= "/></td>
                          <td align=\"left\" style='font-size: 13px;' width='99%' nowrap>".$row['permission']."</td>
                        </tr>";

					  	if($counter == (count($all_permissions) - 1)){
					  		$table_HTML .= "</table></div>";
						}

						$oldsection = $row['section'];
						$counter++;
				#}
			}
					  $table_HTML .= "</td></tr></table>";


		} else {
			$table_HTML .= format_notice("No permissions have been set for the selected group.");
		}
	}

}



#===============================================================================================
# Get a user's permissions
#===============================================================================================
else if(!empty($area) && $area == 'view_user_group_permissions')
{
	$table_HTML .= $combined_css_HTML;

    if(!empty($page_list))
    {
        $table_HTML .= "<table align='left' width='400px' border='0' cellspacing='0' cellpadding='5'>";
        $counter = 0;
		foreach($page_list AS $row)
		{
			$table_HTML .= "<tr style='".get_row_color($counter, 2)."'><td align='left' >".$row['permission']."</td></tr>";
			$counter++;
		}
		$table_HTML .= "</table>";

     } else {
        $table_HTML .= format_notice("WARNING: No permissions for this user group.");
     }
}




#===============================================================================================
# Search the user list
#===============================================================================================
else if(!empty($area) && $area == 'search_user_details_list')
{
	$table_HTML .= $combined_js_HTML;

	if(!empty($page_list))
	{

		$table_HTML .= "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"3\">
                      <tr>
                        <td class=\"listheader\">&nbsp;</td>
                        <td class=\"listheader\">User</td>
                        <td class=\"listheader\">Email</td>
						<td class=\"listheader\">Telephone</td>
						<td class=\"listheader\">User Name</td>
                      </tr>";

					  $counter = 0;
					  foreach($page_list AS $row){
					  	$table_HTML .= "<tr style='".get_row_color($counter, 2)."'>".
                        				"<td nowrap=\"\">";

							if(check_user_access($this,'delete_user'))
							{
						  		$table_HTML .= " <a  href=\"javascript:void(0)\" onclick=\"confirmDeleteEntity('".base_url()."admin/delete_user/i/".encryptValue($row['id'])."', 'Are you sure you want to delete this user? All the user\'s information will be removed.\\nClick OK to confirm, \\nCancel to cancel this operation and stay on this page.')\" title=\"Click to delete this user\"><img src=\"".base_url()."images/delete.png\" border=\"0\"/></a> ";
							}

							if(check_user_access($this,'update_user_data'))
							{
								$table_HTML .= "<a href=\"".base_url()."admin/load_user_form/i/".encryptValue($row['id'])."\" title=\"Click to update this user's details\"><img src=\"".base_url()."images/edit.png\" border=\"0\"/></a>";
					  		}
						$table_HTML .= "</td>".
                        			   "<td>".$row['firstname']." ".$row['lastname']."</td>".
									   "<td>".$row['emailaddress']."</td>".
									   "<td>";
						$table_HTML .= ($row['telephone'] == '000-000-0000')? 'NONE': $row['telephone'];
						$table_HTML .= "</td>".
									   "<td>".format_usertype($row['usertype'])."</td>".
                      				   "</tr>";
					  $counter++;
					}

                    $table_HTML .= "</table>";

	} else {
		$table_HTML .= format_notice("No user meets the search criteria.");
	}
}










#===============================================================================================
# Search the user list
#===============================================================================================
else if(!empty($area) && $area == 'search_user_list')
{
	$table_HTML .= $combined_js_HTML;

	if(!empty($page_list))
	{
		$table_HTML .= "<table cellpadding='5' cellspacing='0' border='0'>
		<tr><td><b>Top ".NUM_OF_ROWS_PER_PAGE." Search Results:</b></td><td align='right'><a href='javascript:void(0)' onClick=\"hideLayerSet('".$layer."')\"><img src='".base_url()."images/delete_icon.png' border='0' /></a></td></tr>";
		$counter = 0;
		foreach($page_list AS $row)
		{
			$field = (!empty($fieldname))? $fieldname: "generalpartner";
			#Show one row at a time
			$table_HTML .= "<tr style='".get_row_color($counter, 2)."'><td colspan='2'><a href='javascript:void(0)' onClick=\"updateFieldValue('generalpartnerview', '".$row['firstname']." ".$row['lastname']."');updateFieldValue('".$field."', '".$row['id']."');hideLayerSet('".$layer."')\" class='bluelinks'>".$row['username']."</a> (".$row['firstname']." ".$row['middlename']." ".$row['lastname'].")</td></tr>";
			$counter++;
		}
		$table_HTML .= "</table>";

	} else {
		$table_HTML .= "<table cellpadding='5' cellspacing='0' border='0'>
			<tr><td><b>Top ".NUM_OF_ROWS_PER_PAGE." Search Results:</b></td><td align='right'><a href='javascript:void(0)' onClick=\"hideLayerSet('".$layer."')\"><img src='".base_url()."images/delete_icon.png' border='0' /></a></td></tr></table>".
			format_notice("No user meets search.");
	}
}










#===============================================================================================
# Search the organization list
#===============================================================================================
else if(!empty($area) && $area == 'search_gp_list')
{
	$table_HTML .= $combined_js_HTML;

	if(!empty($page_list))
	{
		$table_HTML .= "<table cellpadding='5' cellspacing='0' border='0'>
		<tr><td><b>Top ".NUM_OF_ROWS_PER_PAGE." Search Results:</b></td><td align='right'><a href='javascript:void(0)' onClick=\"hideLayerSet('".$layer."')\"><img src='".base_url()."images/delete_icon.png' border='0' /></a></td></tr>";
		$counter = 0;
		foreach($page_list AS $row)
		{
			#Show one row at a time
			$table_HTML .= "<tr style='".get_row_color($counter, 2)."'><td colspan='2'><a href='javascript:void(0)' onClick=\"updateFieldValue('generalpartnerview', '".$row['organizationname']."');updateFieldValue('generalpartner', '".$row['id']."');hideLayerSet('".$layer."')\" class='bluelinks'>".$row['organizationname']."</a>";

			$table_HTML .= (!empty($row['symbol']))? " (".$row['symbol'].")" : "";

			$table_HTML .= "</td></tr>";
			$counter++;
		}
		$table_HTML .= "</table>";

	} else {
		$table_HTML .= "<table cellpadding='5' cellspacing='0' border='0'>
			<tr><td><b>Top ".NUM_OF_ROWS_PER_PAGE." Search Results:</b></td><td align='right'><a href='javascript:void(0)' onClick=\"hideLayerSet('".$layer."')\"><img src='".base_url()."images/delete_icon.png' border='0' /></a></td></tr></table>".
			format_notice("No company meets search.");
	}
}


#===============================================================================================
# Search the news list
#===============================================================================================
else if(!empty($area) && $area == 'search_news_list')
{
	$table_HTML .= $combined_js_HTML;

	if(!empty($page_list))
	{


		$table_HTML .= "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"5\">".
                       "<tr>".
                       "<td class=\"listheader\" width='1%'>&nbsp;</td>".
                       "<td class=\"listheader\" width='1%' nowrap>Affected Fund(s)</td>".
                       "<td class=\"listheader\" width='1%'>News</td>".
					   "<td class=\"listheader\" width='97%'>Date</td>".
                       "</tr>";

					  $counter = 0;
					  foreach($page_list AS $row){

					  	$table_HTML .= "<tr style='".get_row_color($counter, 2)."'>".
                        			   "<td nowrap>";

						if(check_user_access($this,'delete_news_item')){
						  $action_link = (!empty($isarchive))? "news/delete_news": "news/deactivate_news";
						  $table_HTML .=  "<a href=\"javascript:void(0)\" onclick=\"confirmDeleteEntity('".base_url().$action_link."/i/". encryptValue($row['id'])."', 'Are you sure you want to delete this news article? \\nThis operation cannot be undone.\\nClick OK to confirm, \\nCancel to cancel this operation and stay on this page.')\" title=\"Click to delete this news item\"><img src=\"".base_url()."images/delete.png\" border=\"0\"/></a> &nbsp;";
						}


						if(check_user_access($this,'restore_news_item') && !empty($isarchive)){
							$table_HTML .=  " <a href=\"javascript:void(0)\" onclick=\"confirmDeleteEntity('".base_url()."news/restore_news/i/". encryptValue($row['id'])."', 'Are you sure you want to restore this news article? \\nClick OK to confirm, \\nCancel to cancel this operation and stay on this page.')\" title=\"Click to restore this news item\"><img src=\"".base_url()."images/restore.png\" border=\"0\"/></a> ";
                        }

						if(check_user_access($this,'edit_news_item') && empty($isarchive)){
							$table_HTML .=  "<a href='".base_url()."news/add_news/i/".encryptValue($row['id'])."' title='Click to update this news item'><img src='".base_url()."images/edit.png' border='0'/></a>";
						}


						$table_HTML .= "</td>".
							 		   "<td nowrap=\"nowrap\">".$row['affectedfund']."</td>".
                        	 		   "<td nowrap=\"nowrap\"><a target=\"_blank\" href=\"".$row['articlelink']."\" class='contentlink'>".wordwrap($row['title'], 60, '<BR>')."</a></td>".
									   "<td>".date("d-M-Y", strtotime($row['newsdate']))."</td>".
                      				   "</tr>";
					  $counter++;
					  }


					  $table_HTML .= "</table>";

	} else {
		$table_HTML .= format_notice("No news item meets the search criteria.");
	}
}








#===============================================================================================
# Search the deal list
#===============================================================================================
else if(!empty($area) && $area == 'search_deal_list')
{
	$table_HTML .= $combined_js_HTML;

	if(!empty($page_list))
	{
		$table_HTML .= "<table width='100%' border='0' cellspacing='0' cellpadding='5'>
          	<tr>
			<td class='listheader'>&nbsp;</td>
           	<td class='listheader' nowrap>Desk ID</td>
			<td class='listheader' nowrap>Fund</td>
			<td class='listheader' nowrap>Deal</td>
           	<td class='listheader' nowrap>Start Date</td>
			<td class='listheader' nowrap>Status</td>
			</tr>";

		$counter = 0;
		foreach($page_list AS $row)
		{
			$newstr = ($row['dealtype'] == 'issue')? "<img src='".base_url()."images/new.png' title='This is an issue.' style='cursor: pointer;'/>": "";

			#Show one row at a time
			$table_HTML .= "<tr style='".get_row_color($counter, 2)."'>
		<td valign='top' nowrap>";

		if(check_user_access($this,'delete_deal')){
		$table_HTML .= "<a href=\"javascript:confirmDeleteEntity('".base_url()."deal/deactivate_deal/i/".encryptValue($row['id'])."', 'Are you sure you want to remove this deal? \\nThis operation can not be undone. \\nClick OK to confirm, \\nCancel to cancel this operation and stay on this page.');\" title=\"Click to remove this deal.\"><img src='".base_url()."images/delete.png' border='0'/></a>";
		}

		if(check_user_access($this,'update_deals')){
		$table_HTML .= " <a href='".base_url()."deal/add_deal/i/".encryptValue($row['id'])."' title=\"Click to edit this deal.\"><img src='".base_url()."images/edit.png' border='0'/></a>";
		}

		#Adding documents
		if(check_user_access($this,'manage_deal_documents')){
		 $table_HTML .= " &nbsp;&nbsp; <a href='".base_url()."deal/add_documents/i/".encryptValue($row['id'])."' title=\"Click to add documents to this deal.\"><img src='".base_url()."images/attachment_icon.png' border='0'/></a>";
		}

		#Sending Invitations
		if(check_user_access($this,'send_invitation_by_deal') && $row['dealstatus'] == 'active'){
		$table_HTML .= " <a href='".base_url()."deal/send_invitation/i/".encryptValue($row['id'])."' title=\"Click to send invitations.\"><img src='".base_url()."images/email_icon.png' border='0'/></a>";
		}

		$table_HTML .= "</td>

		<td valign='top'>".$row['deskid']."</td>

		<td valign='top'>".$row['fundsymbol']."</td>

		<td valign='top'><a href='".base_url()."deal/add_deal/i/".encryptValue($row['id'])."/a/".encryptValue('view')."' class='contentlink'>".$newstr." ".wordwrap($row['dealdescription'], 30, "<BR>")."</a></td>

		<td valign='top' nowrap>".date("d-M-Y", strtotime($row['startdate']))." ".date("h:i A", strtotime($row['starttime']))."</td>

		<td valign='top'>".ucfirst($row['dealstatus'])."</td>

		</tr>";

			$counter++;
		}
		$table_HTML .= "</table>";

	} else {
		$table_HTML .= format_notice("No deal meets search.");
	}
}





#===============================================================================================
# Search the deal list for invitation selection
#===============================================================================================
else if(!empty($area) && $area == 'select_invitations')
{
	$table_HTML .= $combined_js_HTML;

	$table_HTML .= "<table cellpadding='5' cellspacing='0' border='0'>
		<tr><td><b>Top ".NUM_OF_ROWS_PER_PAGE." Search Results:</b></td><td align='right'><a href='javascript:void(0)' onClick=\"hideLayerSet('".$layer."')\"><img src='".base_url()."images/delete_icon.png' border='0' /></a></td></tr>

		<tr><td colspan='2' style='padding-top:0px;'>";

	if(!empty($page_list))
	{
		$table_HTML .= "<table width='100%' border='0' cellspacing='0' cellpadding='5'>
          	<tr>
			<td class='listheader'>&nbsp;</td>
           	<td class='listheader' nowrap>Desk ID</td>
			<td class='listheader' nowrap>Fund</td>
			<td class='listheader' nowrap>Deal</td>
			</tr>";

		$counter = 0;
		foreach($page_list AS $row)
		{
			$newstr = ($row['dealtype'] == 'issue')? "<img src='".base_url()."images/new.png' title='This is an issue.' style='cursor: pointer;'/>": "";

			#Show one row at a time
			$table_HTML .= "<tr style='".get_row_color($counter, 2)."'>
			<td width='1%' valign='top' nowrap>";

			if(!empty($invuserid))
			{
				$table_HTML .= "<a href='javascript:void(0)' onClick=\"hideLayerSet('".$layer."');updateFieldLayer('".base_url()."deal/add_deal_to_invitation/i/".encryptValue($row['id'])."/u/".encryptValue($invuserid)."','','','searchdeallist','');\" title=\"Click to add this deal to invitation list.\"><img src='".base_url()."images/add_icon.png' border='0'/></a>";
			}
			else if(!empty($subarea) && $subarea == 'dealdocs')
			{
				$table_HTML .= "<a href='javascript:void(0)' onClick=\"updateFieldLayer('".base_url()."deal/add_documents/i/".encryptValue($row['id'])."','','".$layer."','','');\" title=\"Click to select this deal.\"><img src='".base_url()."images/add_icon.png' border='0'/></a>";
			}
			else if(!empty($subarea) && $subarea == 'selectorder')
			{
				$table_HTML .= "<a href='javascript:void(0)' onClick=\"updateFieldLayer('".base_url()."deal/add_single_order/d/".encryptValue($row['id']);
				$table_HTML .= ($this->session->userdata('isadmin') && $this->session->userdata('isadmin') == 'Y')? "/u/".encryptValue('NONE'): "";
				$table_HTML .= "','','".$layer."','','');\" title=\"Click to select this deal.\"><img src='".base_url()."images/add_icon.png' border='0'/></a>";
			}
			else
			{
				$table_HTML .= "<a href='javascript:void(0)' onClick=\"hideLayerSet('".$layer."');updateFieldLayer('".base_url()."deal/send_invitation/i/".encryptValue($row['id'])."','','deal_search_fields','','');showLayerSet('userfields<>searchuserlist');\" title=\"Click to select this deal.\"><img src='".base_url()."images/add_icon.png' border='0'/></a>";
			}

			$table_HTML .= "</td>
			<td width='1%' valign='top'>".$row['deskid']."</td>

			<td width='1%' valign='top'>".$row['fundsymbol']."</td>

			<td width='97%' valign='top'>".$newstr." ".wordwrap($row['dealdescription'], 30, "<BR>")."</td>

			</tr>";

			$counter++;
		}
		$table_HTML .= "</table>";

	} else {
		$table_HTML .= format_notice("No deal meets search.");
	}

	$table_HTML .= "</td></tr></table>";
}



#===============================================================================================
# Search the for a subject's papers
#===============================================================================================
else if(!empty($area) && $area == 'subject_papers')
{
	if(count($papers)){
    	$table_HTML .= "<table>
                  <tr><td colspan='2'>&nbsp;</td></tr>
                  <tr><td colspan='2'><b>Current Papers</b></td></tr>";

		foreach($papers as $paper)
			$table_HTML .= "<tr><td><a href='javascript:void(0)' onclick=\"updateFieldLayer('".base_url()."curriculum/delete_paper/i/".encryptValue($paper['id'])."','paper".$paper['id']."','','paper_results','');\"><img src='".base_url()."images/delete.png' border='0'/></a>&nbsp;&nbsp;
						<a href='javascript:void()' title=\"Click to edit ".$paper['paper']." details.\"><img src='".base_url()."images/edit.png' border='0'/></a>&nbsp;&nbsp;
						</td><td><input type='hidden' id='paper".$paper['id']."' name='paper".$paper['id']."' value='".encryptValue($paper['id'])."' />".$paper['paper']."</td></tr>";

		$table_HTML .= "</table>";
     }
	 else
	 {
	 	$table_HTML .= "No papers have been specified.";
	 }
}





#===============================================================================================
# Search the user list for invitation selection
#===============================================================================================
else if(!empty($area) && $area == 'invitation_user_list')
{
	$table_HTML .= $combined_js_HTML;

	$table_HTML .= "<table cellpadding='5' cellspacing='0' border='0'>
		<tr><td><b>Top ".NUM_OF_ROWS_PER_PAGE;
	#Update the header to cater for group searches too.
	if(empty($subarea) && empty($msubarea))
	{
		$table_HTML .=" Group and ";
	}

	$table_HTML .= " User Search Results:</b></td><td align='right'><a href='javascript:void(0)' onClick=\"hideLayerSet('".$layer."')\"><img src='".base_url()."images/delete_icon.png' border='0' /></a></td></tr>";

	#Do not show this list when starting the search by client
	if(!empty($group_list) && empty($subarea) && empty($msubarea))
	{
		$table_HTML .= "<tr><td colspan='2' style='padding-top:0px;'>
			<table width='100%' border='0' cellspacing='0' cellpadding='5'>
          	<tr>
			<td class='listheader' width='1%'>&nbsp;</td>
           	<td class='listheader' width='99%' nowrap>Group Name</td>
			</tr>";

		$counter = 0;
		foreach($group_list AS $row)
		{
			$table_HTML .= "<tr style='".get_row_color($counter, 2)."'>
			<td><a href='javascript:void(0)' onClick=\"hideLayerSet('".$layer."');updateFieldLayer('".base_url()."deal/select_invitation_user/gn/".encryptValue($row['groupname'])."','dealid','user_searchresults','searchuserlist','');\" title=\"Click to add all users in this email group.\"><img src='".base_url()."images/add_icon.png' border='0'/></a></td>

				<td valign='top'><a href='".base_url()."user/get_group_users/gn/".encryptValue($row['groupname'])."' class='fancybox fancybox.ajax bluelink' >".$row['groupname']."</a></td>
				</tr>";

			$counter++;
		}
		$table_HTML .= "</table></td></tr>";
	}

	$table_HTML .= "<tr><td colspan='2' style='padding-top:0px;'>";

	if(!empty($page_list))
	{
		$table_HTML .= "<table width='100%' border='0' cellspacing='0' cellpadding='5'>
          	<tr>
			<td class='listheader'>&nbsp;</td>
           	<td class='listheader' nowrap>First Name</td>
			<td class='listheader' nowrap>Last Name</td>
			<td class='listheader' nowrap>User Name</td>
			<td class='listheader' nowrap>Email</td>
			<td class='listheader' nowrap>Desk ID</td>
			<td class='listheader' nowrap>Organization</td>
			</tr>";

		$counter = 0;
		foreach($page_list AS $row)
		{
			#Show one row at a time
			$table_HTML .= "<tr style='".get_row_color($counter, 2)."'>
		<td valign='top' nowrap>";

		if(!empty($subarea) && $subarea == 'deals')
		{
			$table_HTML .= "<a href='javascript:void(0)' onClick=\"hideLayerSet('".$layer."');updateFieldLayer('".base_url()."deal/send_invitation_by_client/i/".encryptValue($row['id'])."','','deal_search_fields','','');showLayerSet('dealfields<>searchdeallist');\" title=\"Click to view user details.\"><img src='".base_url()."images/add_icon.png' border='0'/></a>";
		}
		else if(!empty($msubarea) && $msubarea == 'invitation_user_list')
		{
			$table_HTML .= "<a href='javascript:void(0)' onClick=\"hideLayerSet('".$layer."');updateFieldLayer('".base_url()."messages/pick_receiver/i/".encryptValue($row['id'])."','','','selectedusers','');\" title=\"Click to add a user to the recipient list.\"><img src='".base_url()."images/add_icon.png' border='0'/></a>";
		}
		else
		{
			$table_HTML .= "<a href='javascript:void(0)' onClick=\"hideLayerSet('".$layer."');updateFieldLayer('".base_url()."deal/select_invitation_user/i/".encryptValue($row['id'])."','dealid','user_searchresults','searchuserlist','');\" title=\"Click to add to invitation list.\"><img src='".base_url()."images/add_icon.png' border='0'/></a>";
		}

		$table_HTML .= "</td>
		<td valign='top'>".$row['firstname']."</td>
		<td valign='top'>".$row['lastname']."</td>
		<td valign='top'>".$row['username']."</td>
		<td valign='top'>".$row['emailaddress']."</td>
		<td valign='top'>".$row['deskid']."</td>
		<td valign='top'>".$row['organizationname']."</td>
		</tr>";

			$counter++;
		}
		$table_HTML .= "</table>";

	} else {
		$table_HTML .= format_notice("<span='error'>No user meets search.</span>");
	}
	$table_HTML .= "</td></tr></table>";

}



#===============================================================================================
# Search the user list for report selection
#===============================================================================================
else if(!empty($area) && $area == 'outside_report_user_list')
{
	$table_HTML .= $combined_js_HTML;

	$table_HTML .= "<table cellpadding='5' cellspacing='0' border='0'>
		<tr><td><b>Top ".NUM_OF_ROWS_PER_PAGE;

	$table_HTML .= " User Search Results:</b></td><td align='right'><a href='javascript:void(0)' onClick=\"hideLayerSet('".$layer."')\"><img src='".base_url()."images/delete_icon.png' border='0' /></a></td></tr>";



	$table_HTML .= "<tr><td colspan='2' style='padding-top:0px;'>";

	if(!empty($page_list))
	{
		$table_HTML .= "<table width='100%' border='0' cellspacing='0' cellpadding='5'>
          	<tr>
			<td class='listheader'>&nbsp;</td>
           	<td class='listheader' nowrap>First Name</td>
			<td class='listheader' nowrap>Last Name</td>
			<td class='listheader' nowrap>User Name</td>
			<td class='listheader' nowrap>Email</td>
			<td class='listheader' nowrap>Desk ID</td>
			<td class='listheader' nowrap>Organization</td>
			</tr>";

		$counter = 0;
		foreach($page_list AS $row)
		{
			#Show one row at a time
			$table_HTML .= "<tr style='".get_row_color($counter, 2)."'>
		<td valign='top' nowrap>";

		$table_HTML .= "<a href='javascript:void(0)' onClick=\"hideLayerSet('".$layer."');updateFieldLayer('".base_url()."reports/select_report_user/i/".encryptValue($row['id'])."','reportid','user_searchresults','searchuserlist','');\" title=\"Click to add to report user list.\"><img src='".base_url()."images/add_icon.png' border='0'/></a>";


		$table_HTML .= "</td>
		<td valign='top'>".$row['firstname']."</td>
		<td valign='top'>".$row['lastname']."</td>
		<td valign='top'>".$row['username']."</td>
		<td valign='top'>".$row['emailaddress']."</td>
		<td valign='top'>".$row['deskid']."</td>
		<td valign='top'>".$row['organizationname']."</td>
		</tr>";

			$counter++;
		}
		$table_HTML .= "</table>";

	} else {
		$table_HTML .= format_notice("No user meets search criteria.");
	}
	$table_HTML .= "</td></tr></table>";

}


#===============================================================================================
# Selected report users
# Display users allowed to access a selected report
#===============================================================================================
else if(!empty($area) && $area == 'selected_report_users')
{
	$table_HTML .= $combined_js_HTML;

	if(!empty($page_list))
	{
		if(!empty($msg))
		{
			$table_HTML .= format_notice($msg)."<BR>";
		}

		#show lightbox list if user is only viewing users
		if(!empty($isviewing) && $isviewing)
		{
			$table_HTML .= "<table width='100%' border='0' cellspacing='0' cellpadding='5'>
          	<tr align='left'>
			<td class='listheader'>&nbsp;</td>
           	<td class='listheader' nowrap>First Name</td>
			<td class='listheader' nowrap>Last Name</td>
			<td class='listheader' nowrap>User Name</td>
			<td class='listheader' nowrap>Email</td>
			<td class='listheader' nowrap>Desk ID</td>
			<td class='listheader' nowrap>Organization</td>
			</tr>";

			$counter = 0;
			foreach($page_list AS $row)
			{
				#Show one row at a time
				$table_HTML .= "<tr align='left' style='".get_row_color($counter, 2)."'>
				<td valign='top' nowrap>";


				$table_HTML .= "</td>
					<td valign='top'>".$row['firstname']."</td>
					<td valign='top'>".$row['lastname']."</td>
					<td valign='top'>".$row['username']."</td>
					<td valign='top'>".$row['emailaddress']."</td>
					<td valign='top'>".$row['deskid']."</td>
					<td valign='top'>".$row['organizationname']."</td>
					</tr>";

				$counter++;
			}
			$table_HTML .= "</table>";


		}
		else
		{
			foreach($page_list AS $row)
			{
				#Show one row at a time
				$table_HTML .= "<div id='user_".$row['id']."_layer' style='border-top: solid 1px #EEE;'>
					<table width='100%' border='0' cellspacing='0' cellpadding='5' style='background-color:#FFF;'>
					<tr align='left' >
					<td valign='top' width='1%' nowrap><div id='user_action_".$row['id']."_layer'>";

				if(empty($isviewing))
				{
					$table_HTML .= "<a href='javascript:void(0)' onClick=\"confirmRemoveUserReportAccessAction('".base_url()."reports/remove_report_user/i/".encryptValue($row['id'])."', 'user_".$row['id']."_layer', 'searchuserlist', 'remove this user')\" title=\"Click to remove this user from the access list.\"><img src='".base_url()."images/delete.png' border='0'/></a> </div></td>";
				}

				$table_HTML .= "<td width='97%' valign='top'>".wordwrap("<b>".$row['firstname']." ".$row['lastname']."</b> (User Name: <i>".$row['username']."</i> &nbsp; Email: <i>".$row['emailaddress']."</i> &nbsp; Desk ID: <i>".$row['deskid']."</i> &nbsp; Organization: <i>".check_empty_value($row['organizationname'],'N/A')."</i>", 90, "<BR>").")</td>".
					"<td valign='top' width='1%' nowrap></td>".
					"</tr>".
					"</table></div>";


			}
		}



	} else {
		$table_HTML .= format_notice("No users in report access list.");
	}

}


#===============================================================================================
# Selected invitation users
#===============================================================================================
else if(!empty($area) && $area == 'selected_invitation_users')
{
	$table_HTML .= $combined_js_HTML;

	if(!empty($page_list))
	{
		if(!empty($msg))
		{
			$table_HTML .= format_notice($msg)."<BR>";
		}


		foreach($page_list AS $row)
		{
			#Show one row at a time
			$table_HTML .= "<div id='user_".$row['id']."_layer' style='border-top: solid 1px #EEE;'>
			<table width='100%' border='0' cellspacing='0' cellpadding='5' style='background-color:#FFF;'>
			<tr>
		<td valign='top' width='1%' nowrap><div id='user_action_".$row['id']."_layer'>";

if($row['issent'] == 'N')
{
		$table_HTML .= "<a href='javascript:void(0)' onClick=\"confirmInvitationAction('".base_url()."deal/remove_invitation_user/i/".encryptValue($row['id'])."', 'user_".$row['id']."_layer', 'searchuserlist', 'remove this user')\" title=\"Click to remove this user from list.\"><img src='".base_url()."images/delete.png' border='0'/></a> ";

	/*if((!empty($deal_details['needsnda']) && $deal_details['needsnda'] == 'Y' && $row['ndasigned'] == 'Y') || (!empty($deal_details['needsnda']) && $deal_details['needsnda'] == 'N') || empty($deal_details['needsnda']))
	{	*/
		$table_HTML .= "<a href='javascript:void(0)' onClick=\"confirmInvitationAction('".base_url()."deal/send_deal_invitation/i/".encryptValue($row['id'])."', '', 'user_action_".$row['id']."_layer', 'send this user an invitation')\" title=\"Click to send this user an invitation.\"><img src='".base_url()."images/email_icon.png' border='0'/></a>";

	/*}
	else
	{
		$table_HTML .= "<img src='".base_url()."images/spacer.gif' width='17' height='1'/>";
	}*/
}
else
{
	#echo "<img src='".base_url()."images/spacer.gif' width='30' height='1'/>";
	$table_HTML .= "<span class='littlegreentext'>SENT</span>";
}

		$table_HTML .= "</div></td>

		<td width='97%' valign='top'>".wordwrap("<b>".$row['firstname']." ".$row['lastname']."</b> (User Name: <i>".$row['username']."</i> &nbsp; Email: <i>".$row['emailaddress']."</i> &nbsp; Desk ID: <i>".$row['deskid']."</i> &nbsp; Organization: <i>".$row['organizationname']."</i>", 90, "<BR>").")</td>
		<td valign='top' width='1%' style='padding-right:0px;' nowrap><b>NDA Signed:</b></td><td valign='top' width='1%' nowrap>";


if($row['issent'] == 'N')
{
	$table_HTML .= "<input type='checkbox' id='nda_".$row['id']."' name='nda[]' value='".$row['id']."'  ";
	if($row['ndasigned'] == 'Y')
	{
		$table_HTML .=  " checked";
	}
	$table_HTML .=  "/>";
}
else
{
	$table_HTML .=  "<B class='viewtext' style='padding: 5px 5px 5px 5px;'>".$row['ndasigned']."</B>";
}

		$table_HTML .= "</td>
		</tr>
		</table></div>";

		}

		$table_HTML .= "<br><input type='submit' name='updatenda' id='updatenda' value='Save' class='button'/>";

	} else {
		$table_HTML .= format_notice("No users in invitation list.");
	}

}





#===============================================================================================
# Invitation user details
#===============================================================================================
else if(!empty($area) && $area == 'invitation_user_details')
{
	$table_HTML .= $combined_js_HTML;

	$table_HTML .= "<table width='100%' border='0' cellspacing='0' cellpadding='5' class='lightorangebg'>
	 	<tr>
		<td width='1%' nowrap><b>Invitations For:</b></td>
	 	<td width='99%' valign='top'>".$user_details['firstname']." ".$user_details['lastname']." (User Name: <i>".$user_details['username']."</i>, Email Address: <i>".$user_details['emailaddress']."</i>)
		<input type='hidden' name='invuserid' id='invuserid' value='".$user_details['id']."' />
		</td>
		</tr>
		</table>";
}





#===============================================================================================
# Selected invitation users
#===============================================================================================
else if(!empty($area) && $area == 'invitation_deal_list')
{
	$table_HTML .= $combined_js_HTML;

	if(!empty($page_list))
	{
		if(!empty($msg))
		{
			$table_HTML .= format_notice($msg)."<BR>";
		}

		foreach($page_list AS $row)
		{
			$newstr = ($row['dealtype'] == 'issue')? "<img src='".base_url()."images/new.png' title='This is an issue.' style='cursor: pointer;'/>": "";

			$table_HTML .= "<div id='deal_".$row['id']."_layer' style='border-top: solid 1px #EEE;'>
			<table width='100%' border='0' cellspacing='0' cellpadding='5' style='background-color:#FFF;'>
			<tr>
				<td valign='top' width='1%' nowrap><div id='deal_action_".$row['id']."_layer'>";

			if($row['issent'] == 'N')
			{
				$table_HTML .= "<a href='javascript:void(0)' onClick=\"confirmInvitationAction('".base_url()."deal/remove_invitation_deal/u/".encryptValue($row['userid'])."/d/".encryptValue($row['dealid'])."', 'deal_".$row['id']."_layer', 'searchdeallist', 'remove this deal')\"  title=\"Click to remove this deal from list.\"><img src='".base_url()."images/delete.png' border='0'/></a>

				<a href='javascript:void(0)' onClick=\"confirmInvitationAction('".base_url()."deal/send_deal_invitation/u/".encryptValue($row['userid'])."/d/".encryptValue($row['dealid'])."', '', 'deal_action_".$row['id']."_layer', 'send this deal invitation')\" title=\"Click to send this deal invitation.\"><img src='".base_url()."images/email_icon.png' border='0'/></a>";

			}
			else
			{
				$table_HTML .= "<span class='littlegreentext'>SENT</span>";
			}

			$table_HTML .= "</div></td>

				<td width='97%' valign='top'>".$newstr." ".wordwrap("<b>".$row['dealdescription']."</b> (Desk ID: <i>".$row['deskid']."</i> &nbsp; Fund Symbol: <i>".$row['fundsymbol']."</i>", 90, "<BR>").")</td>
				<td valign='top' width='1%' style='padding-right:0px;' nowrap><b>NDA Signed:</b></td><td valign='top' width='1%' nowrap>";


			if($row['issent'] == 'N')
			{
				$table_HTML .= "<input type='checkbox' id='nda_".$row['id']."' name='nda[]' value='".$row['dealid']."'  ";
				if($row['ndasigned'] == 'Y')
				{
					$table_HTML .=  " checked";
				}
				$table_HTML .=  "/>";
			}
			else
			{
				$table_HTML .= "<B class='viewtext' style='padding: 5px 5px 5px 5px;'>".$row['ndasigned']."</B>";
			}

			$table_HTML .= "</td>
					</tr>
				</table></div>";

		}

		$table_HTML .=  "<br><input type='submit' name='updatenda' id='updatenda' value='Save' class='button'/>";

	} else {
		$table_HTML .= format_notice("No deal invitations yet.");
	}

}





#===============================================================================================
# Selected invitation users
#===============================================================================================
else if(!empty($area) && $area == 'file_under_list')
{
	$table_HTML .= $combined_js_HTML;

	if(!empty($page_list))
	{
		$table_HTML .= "<table width='100%' border='0' cellspacing='0' cellpadding='5'>";

		$counter = 0;
		foreach($page_list AS $row)
		{
			#Show one row at a time
			$table_HTML .= "<tr style='".get_row_color($counter, 2)."'>
			<td valign='top' nowrap><a href='javascript:void(0)' onClick=\"updateFieldValue('fileunder', '".$row['fileunder']."');hideLayerSet('".$layer."')\" title=\"Click to select this section.\" class='bluelink'>".$row['fileunder']."</a></td>

			</tr>";

			$counter++;
		}
		$table_HTML .= "</table>";
	}
	else
	{
		$table_HTML .= format_notice("No results match the search.");
	}
}





#===============================================================================================
# Selected filename update
#===============================================================================================
else if(!empty($area) && $area == 'filename_update')
{
	$table_HTML .= $combined_js_HTML.$combined_css_HTML;

	if(!empty($action) && $action == 'isediting')
	{
		$table_HTML .= "<table><tr>
				<td><input type='text' name='filename_".$docid."' id='filename_".$docid."' size='40' class='textfield' value='".$document_details['filename']."'/></td>
				<td style='padding-left:4px;'><input type='button' name='save_".$docid."' id='save_".$docid."' value='Save'  class='bodybutton' onclick=\"updateFieldLayer('".base_url()."deal/update_filename/i/".encryptValue($docid)."','filename_".$docid."','".$docid."_edit_div','".$docid."_div','Please enter the new file name.')\"/></td>
				<td><input type='button' name='cancel_".$docid."' id='cancel_".$docid."' value='Cancel'  style='font-family:Arial, Helvetica, sans-serif;
	font-size:14px;
	padding: 5px 10px 5px 10px;' onclick=\"updateFieldLayer('".base_url()."deal/update_filename/i/".encryptValue($docid)."/a/".encryptValue('view')."','','".$docid."_edit_div','".$docid."_div','')\"/></td>
				</tr></table>";
	}
	else
	{
		$table_HTML .= "<a href='".base_url()."documents/force_download/u/".encryptValue($document_details['fileurl'])."' class='contentlink'>".$document_details['filename']."</a>";
	}

}


#===============================================================================================
# View help details
#===============================================================================================
else if(!empty($area) && $area == 'view_help_details')
{


	$helptopic = (!empty($page_list[0]['helptopic']))? $page_list[0]['helptopic']: "General Help";
	$table_HTML .= "<html>
	<title>".SITE_TITLE.": Help for ".$helptopic."</title>
	<head>";

	$table_HTML .= "</head>
	<body style='background: #FFF;'>";
	$table_HTML .= $combined_js_HTML.$combined_css_HTML;
	$table_HTML .= "<table width='100%' border='0' cellspacing='0' cellpadding='5' style='text-align:left;font-size:13px;'>
	<tr><td class='lightgreybg pageheader' nowrap>".$helptopic."</td></tr>
	<tr><td>";

	if(!empty($page_list))
	{
		foreach($page_list AS $row)
		{
			if(!empty($row['fileurl']))
			{
				if(strtolower(strrchr($row['fileurl'],".")) == '.swf')
				{
					$table_HTML .= "<a href=\"javascript:void(0)\" onclick=\"updateFieldLayer('".base_url()."page/view_video/f/".encryptValue('documents')."/u/".encryptValue($row['fileurl'])."', '', '', '_', '')\" class='bluelink'>View Larger Video</a>
					<br>
					<object id=\"movie\" type=\"application/x-shockwave-flash\" data=\"".base_url()."downloads/documents/".$row['fileurl']."\" style=\"width: 400px; height: 250px;\">
						<embed src=\"".base_url()."downloads/documents/".$row['fileurl']."\" type=\"application/x-shockwave-flash\" width=\"400\" height=\"100%\" allowScriptAccess=\"sameDomain\" pluginspage=\"http://get.adobe.com/de/flashplayer/\"></embed>
					</object><br>";
				}
				else if(is_file_an_image(UPLOAD_DIRECTORY."documents/".$row['fileurl']))
				{
					$WIDTH  = 600;
					$img_properties = minimize_image(UPLOAD_DIRECTORY."documents/".$row['fileurl'], '', $WIDTH);
					$imgwidth = ($img_properties['actualwidth'] < $WIDTH)? $img_properties['actualwidth']: $WIDTH;
					$table_HTML .= "<a href='javascript:void(0)' onclick=\"updateFieldLayer('".base_url()."downloads/documents/".$row['fileurl']."','','','_','')\"><img src='".base_url()."downloads/documents/".$row['fileurl']."' width='".$imgwidth."' border='0'></a> ";
				}
				else
				{
					$table_HTML .= "<br><a href='".base_url()."documents/force_download/u/".encryptValue($row['fileurl'])."/f/".encryptValue('documents')."' class='bluelink'><img src='".base_url()."images/".get_doc_logo($row['fileurl'])."' border='0'> &nbsp; Download Document</a><br>";
				}
			}
			if(!empty($row['helplink']))
			{
				$table_HTML .= "<a href='".$row['helplink']."' class='contentlink' target='_blank'>".$row['helplink']."</a>";
			}
			$table_HTML .= stripslashes(html_entity_decode( nl2br(html_entity_decode($row['details'])) ))."<BR>";


			#$table_HTML .= $row['details']."<BR>";
		}
	}
	else
	{
		$table_HTML .= "There is no help entered for this page yet.";
	}

	$table_HTML .= "</td></tr>
	</table>";
	$table_HTML .= "</body>
	</html>";


}




#===============================================================================================
# Search the usertable for usernames
#===============================================================================================
else if(!empty($area) && $area == 'username_list')
{
	$table_HTML .= $combined_js_HTML;

	if(strlen($uname) < 5)
	{
		$table_HTML .= format_notice("WARNING: Username should be at least 5 characters. ");
	}
	else if(!empty($page_list))
	{
		$table_HTML .= format_notice("WARNING: Invalid username");

	} else {
		$table_HTML .= format_notice("The username is valid");
	}
}



#===============================================================================================
# show password strength
#===============================================================================================
else if(!empty($area) && $area == 'show_password_strength')
{
	$table_HTML .= $combined_js_HTML;

	if(!$passwordmsg['bool'])
	{
		$table_HTML .= format_notice("WARNING: ".$passwordmsg['msg']);
	}
	else
	{
		$table_HTML .= format_notice("Valid Password.");
	}
}






#===============================================================================================
# View holiday list
#===============================================================================================
else if(!empty($area) && $area == 'holiday_list')
{
	$table_HTML .= $combined_js_HTML.$combined_css_HTML;

	if(!empty($page_list))
	{
		$table_HTML .= "<table width='100%' border='0' cellspacing='0' cellpadding='5'>
          	<tr>
			<td class='listheader' width='1%'>&nbsp;</td>
           	<td class='listheader' width='1%' nowrap>Date</td>
			<td class='listheader' width='98%' nowrap>Holiday Name</td>
			</tr>";
		$counter = 0;
		foreach($page_list AS $row)
		{
			#Show one row at a time
			$table_HTML .= "<tr style='".get_row_color($counter, 2)."'>
		<td valign='top' nowrap>";

			if(check_user_access($this,'delete_holiday')){
			$table_HTML .= "<a href='javascript:void(0)' onclick=\"confirmDeleteEntity('".base_url()."marketdata/deactivate_holiday/i/".encryptValue($row['id'])."', 'Are you sure you want to remove this holiday? \\nThis operation can not be undone. \\nClick OK to confirm, \\nCancel to cancel this operation and stay on this page.');\" title=\"Click to remove this holiday.\"><img src='".base_url()."images/delete.png' border='0'/></a> ";
			}

			if(check_user_access($this,'edit_holiday')){
			$table_HTML .= "<a href='".base_url()."marketdata/add_holiday/i/".encryptValue($row['id'])."' title=\"Click to edit this holiday.\"><img src='".base_url()."images/edit.png' border='0'/></a>";
			}

			$table_HTML .= "</td>

		<td valign='top' nowrap>".date("d-M-Y", strtotime($row['holidaydate']))."</td>
		<td valign='top'>".$row['holidayname']."</td>
		</tr>";

		$counter++;
	}


		$table_HTML .= "</table>";

	} else {
		$table_HTML .= format_notice("There are no active holidays at the moment.");

	}

}




#===============================================================================================
# Select holiday list
#===============================================================================================
else if(!empty($area) && $area == 'select_holiday')
{
	$table_HTML .= $combined_js_HTML.$combined_css_HTML;

	if(!empty($page_list))
	{
		$table_HTML .= "<table width='100%' border='0' cellspacing='0' cellpadding='5'>
		<tr><td><table width='100%'><tr><td><b>Top ".NUM_OF_ROWS_PER_PAGE." Results</b></td><td align='right'><a href='javascript:void(0)' onclick=\"hideLayerSet('".$layer."')\"><img src='".base_url()."images/delete_icon.png' border='0'/></a></td></tr></table></td></tr>";

		$counter = 0;
		foreach($page_list AS $row)
		{
			#Show one row at a time
			$table_HTML .= "<tr style='".get_row_color($counter, 2)."'>
			<td valign='top' nowrap><a href='javascript:void(0)' onClick=\"updateFieldValue('holidayname', '".$row['holidayname']."');hideLayerSet('".$layer."')\" title=\"Click to select this holiday.\" class='bluelink'>".$row['holidayname']."</a></td>

			</tr>";

			$counter++;
		}
		$table_HTML .= "</table>";
	}
	else
	{
		$table_HTML .= "<table><tr><td align='right'><a href='javascript:void(0)' onclick=\"hideLayerSet('".$layer."')\"><img src='".base_url()."images/delete_icon.png' border='0'/></a></td></tr>
		<tr><td>".format_notice("No results match the search.")."</td></tr>
		</table>";
	}
}




#===============================================================================================
# Show news distribution
#===============================================================================================
else if(!empty($area) && $area == 'news_distribution')
{
	$table_HTML .= $combined_js_HTML.$combined_css_HTML;

	if(!empty($page_list))
	{
		$table_HTML .= "<table width='100%' border='0' cellspacing='0' cellpadding='5'>
          	<tr>
			<td class='listheader' width='1%'>&nbsp;</td>
           	<td class='listheader' nowrap>User</td>
			<td class='listheader' nowrap>Email</td>
			<td class='listheader' nowrap>Total <br>Feeds</td>
           	<td class='listheader' nowrap>Active <br>Feeds</td>
			<td class='listheader' nowrap>Articles <br>Sent</td>
			<td class='listheader' nowrap>Articles <br>Read</td>
			<td class='listheader' nowrap>Push <br>Frequency</td>
			</tr>";
		$counter = 0;
		foreach($page_list AS $row)
		{
			$push_frequency = (!empty($row['pushfrequency']))? ucfirst($row['pushfrequency']): "<i>Not Set</i>";

			$feed_link_start = (!empty($row['totalfeeds']))? "<a href='".base_url()."news/user_feed_details/i/".encryptValue($row['userid'])."' class='fancybox fancybox.ajax bluelink' title='The user feeds vs those activated.'>": "";
			$feed_link_end = (!empty($row['totalfeeds']))? "</a>": "";

			$news_link_start = (!empty($row['articlessent']))? "<a href='".base_url()."news/user_article_reads/i/".encryptValue($row['userid'])."' class='fancybox fancybox.ajax bluelink' title='The latest news articles sent vs those read.'>": "";
			$news_link_end = (!empty($row['articlessent']))? "</a>": "";


			#Show one row at a time
			$table_HTML .=  "<tr style='".get_row_color($counter, 2)."'>
				<td valign='top' nowrap>";

			if(check_user_access($this,'update_news_distribution_settings')){
			$table_HTML .=  "<a href='".base_url()."news/distribution_settings/i/".encryptValue($row['userid'])."' title=\"Click to update this user's distribution settings.\"><img src='".base_url()."images/settings_icon.png' height='14' border='0'/></a>";
			}

			$table_HTML .=  "</td>

				<td valign='top'>".$row['firstname']." ".$row['lastname']."</td>

				<td valign='top'>".$row['emailaddress']."</td>

				<td valign='top'>".$feed_link_start.$row['totalfeeds'].$feed_link_end."</td>

				<td valign='top'>".$feed_link_start.$row['activefeeds'].$feed_link_end."</td>

				<td valign='top'>".$news_link_start.$row['articlessent'].$news_link_end."</td>

				<td valign='top'>".$news_link_start.$row['articlesread'].$news_link_end."</td>

				<td valign='top'>".$push_frequency."</td>

				</tr>";

			$counter++;
		}


		$table_HTML .=  "</table>";

	}
	else
	{
		$table_HTML .=  format_notice("No users meet your search.");
	}
}




#===============================================================================================
# Show email groups
#===============================================================================================
else if(!empty($area) && $area == 'email_groups')
{
	$table_HTML .= $combined_js_HTML.$combined_css_HTML;
	#Show search results
	if(!empty($page_list))
	{
		$table_HTML .= "<table width='100%' border='0' cellspacing='0' cellpadding='5'>
          	<tr>
			<td class='listheader'>&nbsp;</td>
           	<td class='listheader' nowrap>Group Name</td>
			<td class='listheader' nowrap>Email List</td>
			</tr>";
		$counter = 0;
		foreach($page_list AS $row)
		{
			#Show one row at a time
			$table_HTML .= "<tr style='".get_row_color($counter, 2)."'>
			<td valign='top' nowrap>";

			if(check_user_access($this,'delete_email_group')){
			$table_HTML .= "<a href='javascript:void(0)' onclick=\"confirmDeleteEntity('".base_url()."user/deactivate_email_group/i/".encryptValue($row['groupname'])."', 'Are you sure you want to remove this email group? \\nThis operation can not be undone. \\nClick OK to confirm, \\nCancel to cancel this operation and stay on this page.');\" title=\"Click to remove this email group.\"><img src='".base_url()."images/delete.png' border='0'/></a> ";
			}

			if(check_user_access($this,'update_email_group')){
			$table_HTML .= "<a href='".base_url()."user/add_email_group/i/".encryptValue($row['groupname'])."' title=\"Click to edit this email group.\"><img src='".base_url()."images/edit.png' border='0'/></a>";
			}

			$table_HTML .= "</td>

			<td valign='top'>".$row['groupname']."</td>

			<td valign='top'>".wordwrap($row['emaillist'], 70, "<BR>")."</td>

			</tr>";

			$counter++;
		}


		$table_HTML .= "</table>";

	} else {
		$table_HTML .= format_notice("No email groups meet your search.");
	}
}




#===============================================================================================
# Show user feed details
#===============================================================================================
else if(!empty($area) && $area == 'user_feed_details')
{
	$table_HTML .= $combined_js_HTML.$combined_css_HTML;

	if(!empty($page_list))
	{
		$table_HTML .= "<table width='300' border='0' cellspacing='0' cellpadding='5' style='text-align:left;'>
          	<tr>
			<td class='listheader' width='1%' nowrap>Symbol</td>
			<td class='listheader' width='98%' nowrap>Feed Name</td>
			<td class='listheader' width='1%' nowrap>Is Active</td>
			</tr>";
		$counter = 0;
		foreach($page_list AS $row)
		{
			$table_HTML .= "<tr style='".get_row_color($counter, 2)."'>
			<td valign='top'>".$row['fundsymbol']."</td>
			<td valign='top'>".$row['fundname']."</td>
			<td valign='top'>".$row['isactive']."</td>
			</tr>";
			$counter++;
		}
		$table_HTML .= "</table>";
	}
	else
	{
		$table_HTML .= format_notice("There are no user feeds for this user.");
	}
}




#===============================================================================================
# Show user article reads
#===============================================================================================
else if(!empty($area) && $area == 'user_article_reads')
{
	$table_HTML .= $combined_js_HTML.$combined_css_HTML;

	if(!empty($page_list))
	{
		$table_HTML .= "<table width='600' border='0' cellspacing='0' cellpadding='5' style='text-align:left;'>";

		if(count($page_list) == $maxrows)
		{
			$table_HTML .= "<tr>
			<td class='lightgreybg' colspan='4'><b>Showing the last ".$maxrows." articles sent.</b></td>
			</tr>";
		}

		$table_HTML .= "<tr>
			<td class='listheader' width='1%' nowrap>Date</td>
			<td class='listheader' nowrap>Article</td>
			<td class='listheader' nowrap>Affected Fund</td>
			<td class='listheader' nowrap>Is Read</td>
			</tr>";
		$counter = 0;
		foreach($page_list AS $row)
		{
			$table_HTML .= "<tr style='".get_row_color($counter, 2)."'>
			<td valign='top' nowrap>".date("d-M-Y H:iA", strtotime($row['newsdate']." ".$row['newstime']))."</td>
			<td valign='top'>";

			#Show video icon if the article has one
			if($row['hasvideo'] == 'Y')
			{
				$table_HTML .= "<table border='0' cellspacing='0' cellpadding='0'><tr><td>";
			}

			$table_HTML .= "<a href='".$row['articlelink']."' target='_blank' class='contentlink'>".wordwrap($row['title'], 100, "<BR>")."</a>";

			if($row['hasvideo'] == 'Y')
			{
				$table_HTML .= "</td><td valign='top' style='padding-left:5px;'><a href='".$row['articlelink']."' target='_blank'><img src='".base_url()."images/video_icon.png'  border='0'/></a></td></tr></table>";
			}

			$table_HTML .= "</td>
			<td valign='top'>".$row['affectedfund']."</td>
			<td valign='top'>".$row['isread']."</td>
			</tr>";
			$counter++;
		}
		$table_HTML .= "</table>";
	}
	else
	{
		$table_HTML .= format_notice("There are no user feeds for this user.");
	}
}




#===============================================================================================
# Show user article reads
#===============================================================================================
else if(!empty($area) && $area == 'group_name_select')
{
	$table_HTML .= $combined_js_HTML.$combined_css_HTML;

	if(!empty($page_list))
	{
		$table_HTML .= "<table cellpadding='5' cellspacing='0' border='0'>
		<tr><td><b>Top ".NUM_OF_ROWS_PER_PAGE." Search Results:</b></td><td align='right'><a href='javascript:void(0)' onClick=\"hideLayerSet('".$layer."')\"><img src='".base_url()."images/delete_icon.png' border='0' /></a></td></tr>";
		$counter = 0;
		foreach($page_list AS $row)
		{
			#Show one row at a time
			$table_HTML .= "<tr style='".get_row_color($counter, 2)."'><td colspan='2'><a href='javascript:void(0)' onClick=\"updateFieldValue('groupname', '".$row['groupname']."');hideLayerSet('".$layer."')\" class='bluelinks'>".$row['groupname']."</a></td></tr>";
			$counter++;
		}
		$table_HTML .= "</table>";
	}
	else
	{
		$table_HTML .= "<table width=\"100%\"><tr><td align='right'><a href='javascript:void(0)' onClick=\"hideLayerSet('".$layer."')\"><img src='".base_url()."images/delete_icon.png' border='0' /></a></td></tr></table>".format_notice("No group name meets the search.");
	}
}




#===============================================================================================
# Show user to group
#===============================================================================================
else if(!empty($area) && $area == 'add_user_to_group')
{
	$table_HTML .= $combined_js_HTML.$combined_css_HTML;

	$table_HTML .= "<table style='background:#FFF;' cellpadding='3' cellspacing='0' border='0'><tr>
				<td class='label'><b>Search:</b> </td>
				<td><input type='text' name='adduser' id='adduser' size='20' class='textfield' value='' onkeyup=\"startInstantSearch('adduser', 'adduser_searchby', '".base_url()."search/load_results/type/user_search/layer/adduser_searchresults');ShowContent('adduser_searchresults','');\"/><input type='hidden' name='adduserid' id='adduserid' value=''/>
				<input name='adduser_searchby' type='hidden' id='adduser_searchby' value='firstname__lastname__username__emailaddress' /><div id='adduser_searchresults' style='max-height: 380px; overflow:hidden; position:absolute;border: 1px solid #98CBFF; background-color: #F7F7F7; display:none;'></div>
				</td>
				<td style='padding-left:4px;'><input type='button' name='add' id='add' value='Add'  class='bodybutton' onclick=\"updateFieldLayer('".base_url()."user/add_user_to_group/a/".encryptValue('adduser');

	if(!empty($gn))
	{
		$table_HTML .= "/gn/".$gn;
	}

	$table_HTML .= "','adduserid','".$layer."','emailgrouplist','Please search and select a user.')\"/></td>
				<td><input type='button' name='cancel' id='cancel' value='Cancel'  style='font-family:Arial, Helvetica, sans-serif;
	font-size:14px;
	padding: 5px 10px 5px 10px;' onclick=\"hideLayerSet('".$layer."')\"/></td>
				</tr></table>";
}




#===============================================================================================
# Show general user list
#===============================================================================================
else if(!empty($area) && $area == 'general_user_list')
{
	$table_HTML .= $combined_js_HTML.$combined_css_HTML;

	if(!empty($page_list))
	{
		$table_HTML .= "<table cellpadding='5' cellspacing='0' border='0'>
		<tr><td><b>Top ".NUM_OF_ROWS_PER_PAGE." Search Results:</b></td><td align='right'><a href='javascript:void(0)' onClick=\"hideLayerSet('".$layer."')\"><img src='".base_url()."images/delete_icon.png' border='0' /></a></td></tr>";
		$counter = 0;
		foreach($page_list AS $row)
		{
			$field = (!empty($fieldname))? $fieldname: "adduser";
			$fieldid_script = (empty($fieldname))? "updateFieldValue('adduserid', '".$row['id']."');": "";
			#Show one row at a time
			$table_HTML .= "<tr style='".get_row_color($counter, 2)."'><td colspan='2'><a href='javascript:void(0)' onClick=\"updateFieldValue('".$field."', '".$row['firstname']." ".$row['lastname']."');updateFieldValue('".$field."', '".$row['firstname']." ".$row['lastname']."');".$fieldid_script."hideLayerSet('".$layer."')\" class='bluelinks'>".$row['firstname']." ".$row['middlename']." ".$row['lastname']."</a> (".$row['emailaddress'].")</td></tr>";
			$counter++;
		}
		$table_HTML .= "</table>";

	} else {
		$table_HTML .= "<table cellpadding='5' cellspacing='0' border='0'>
			<tr><td><b>Top ".NUM_OF_ROWS_PER_PAGE." Search Results:</b></td><td align='right'><a href='javascript:void(0)' onClick=\"hideLayerSet('".$layer."')\"><img src='".base_url()."images/delete_icon.png' border='0' /></a></td></tr></table>".
			format_notice("No user meets search.");
	}

}




#===============================================================================================
# Show the user email grou list
#===============================================================================================
else if(!empty($area) && $area == 'user_email_group_list')
{
	$table_HTML .= $combined_js_HTML.$combined_css_HTML;

	if(!empty($page_list))
	{
		if(!empty($msg))
		{
			$table_HTML .= format_notice($msg);
		}
		$table_HTML .= "<table width='100%' border='0' cellspacing='0' cellpadding='5'>
					<tr>
						<td class='listheader'>&nbsp;</td>
           				<td class='listheader' nowrap>Name</td>
						<td class='listheader' nowrap>Email</td>
					</tr>";
		$counter = 0;
		foreach($page_list AS $row)
		{
			$table_HTML .= "<tr style='".get_row_color($counter, 2)."'>
		<td valign='top' nowrap><a href='javascript:void(0)' onclick=\"confirmDeleteEntity('".base_url()."user/remove_user_from_group/i/".encryptValue($row['id'])."/gn/".encryptValue($row['groupname'])."', 'Are you sure you want to remove this user from the group? \\nThis operation can not be undone. \\nClick OK to confirm, \\nCancel to cancel this operation and stay on this page.');\" title=\"Click to remove this user from the group.\"><img src='".base_url()."images/delete.png' border='0'/></a></td>

			<td valign='top'>".$row['firstname']." ".$row['lastname']."</td>

			<td valign='top'>".$row['emailaddress']."</td>
			</tr>";
			$counter++;
		}

		$table_HTML .= "</table>";
	}
	else
	{
		$table_HTML .= format_notice("There are no users in this email group yet.");
	}

}




#===============================================================================================
# Show the organizations list
#===============================================================================================
else if(!empty($area) && $area == 'organizations_list')
{
	$table_HTML .= $combined_js_HTML.$combined_css_HTML;

	if(!empty($page_list))
	{
		$table_HTML .= "<table width='100%' border='0' cellspacing='0' cellpadding='5'>
          	<tr>
			<td class='listheader'>&nbsp;</td>
           	<td class='listheader' nowrap>Organization</td>
			<td class='listheader' nowrap>Symbol</td>
			<td class='listheader' nowrap>Contact Email</td>
			<td class='listheader' nowrap>Contact Phone</td>
			</tr>";
		$counter = 0;
		foreach($page_list AS $row)
		{
			#Show one row at a time
			$table_HTML .= "<tr style='".get_row_color($counter, 2)."'>
			<td valign='top' nowrap>";

			if(check_user_access($this,'delete_organization')){
			$table_HTML .= "<a href='javascript:void(0)' onclick=\"confirmDeleteEntity('".base_url()."user/deactivate_organization/i/".encryptValue($row['id'])."', 'Are you sure you want to remove this organization? \\nThis operation can not be undone. \\nClick OK to confirm, \\nCancel to cancel this operation and stay on this page.');\" title=\"Click to remove this organization.\"><img src='".base_url()."images/delete.png' border='0'/></a> ";
			}

			if(check_user_access($this,'update_organization')){
			$table_HTML .= "<a href='".base_url()."user/add_organization/i/".encryptValue($row['id'])."' title=\"Click to edit this organization.\"><img src='".base_url()."images/edit.png' border='0'/></a>";
			}

			$table_HTML .= "</td>

			<td valign='top'><a href='".base_url()."user/add_organization/i/".encryptValue($row['id'])."/a/".encryptValue('view')."' title=\"Click to view this organization's details.\" class='contentlink'>".wordwrap($row['organizationname'], 50, "<BR>")."</a></td>

			<td valign='top'>".$row['symbol']."</td>

			<td valign='top'>".$row['contactemail']."</td>

			<td valign='top'>(".substr_replace(substr_replace($row['contactphone'], ') ', 3, 0), '-', 8, 0)."</td>

		</tr>";

		$counter++;
	}

	$table_HTML .= "</table>";

	} else {
		$table_HTML .= format_notice("No organizations meet your search.");

	}
}




#===============================================================================================
# Show the user news list
#===============================================================================================
else if(!empty($area) && $area == 'search_user_news_list')
{
	$table_HTML .= $combined_js_HTML.$combined_css_HTML;

	if(!empty($page_list))
	{
		$table_HTML .= "<table width='100%' border='0' cellspacing='0' cellpadding='5'>
          	<tr>
			<td class='listheader'>Company</td>
           	<td class='listheader' nowrap>News</td>
			<td class='listheader' nowrap>Date</td>
			</tr>";
		$counter = 0;
		foreach($page_list AS $row)
		{
			#Show one row at a time
			$table_HTML .= "<tr style='".get_row_color($counter, 2)."'>
			<td width='1%' valign='top'>".$row['affectedfund']."</td>
			<td valign='top'>";

			#Show video icon if the article has one
			if($row['hasvideo'] == 'Y')
			{
				$table_HTML .= "<table border='0' cellspacing='0' cellpadding='0'><tr><td>";
			}

			$table_HTML .= "<a href='".$row['articlelink']."' target='_blank' class='contentlink'>".wordwrap($row['title'], 80, "<BR>")."</a>";

			if($row['hasvideo'] == 'Y')
			{
				$table_HTML .= "</td><td valign='top' style='padding-left:5px;'><a href='".$row['articlelink']."' target='_blank'><img src='".base_url()."images/video_icon.png'  border='0'/></a></td></tr></table>";
			}

			$table_HTML .= "</td>
			<td>".date('m/d/Y', strtotime($row['newsdate']))."</td>
			</tr>";
			$counter++;
		}

		$table_HTML .= "</table>";

	}
	else
	{
		$table_HTML .= format_notice("No news item meets your search.");
	}

}




#===============================================================================================
# Show the user group email list
#===============================================================================================
else if(!empty($area) && $area == 'group_emails_list')
{
	$table_HTML .= $combined_js_HTML.$combined_css_HTML;

	if(!empty($group_list))
	{
		$table_HTML .= "<table width='100%' border='0' cellspacing='0' cellpadding='5' style='text-align:left;'>
          	<tr>
			<td class='listheader' nowrap>First Name</td>
			<td class='listheader' nowrap>Last Name</td>
			<td class='listheader' nowrap>User Name</td>
			<td class='listheader' nowrap>Email</td>
			<td class='listheader' nowrap>Desk ID</td>
			<td class='listheader' nowrap>Organization</td>
			</tr>";

		$counter = 0;
		foreach($group_list AS $row)
		{
			#Show one row at a time
			$table_HTML .= "<tr style='".get_row_color($counter, 2)."'>
				<td valign='top'>".$row['firstname']."</td>
				<td valign='top'>".$row['lastname']."</td>
				<td valign='top'>".$row['username']."</td>
				<td valign='top'>".$row['emailaddress']."</td>
				<td valign='top'>".$row['deskid']."</td>
				<td valign='top'>".$row['organizationname']."</td>
			</tr>";

			$counter++;
		}
		$table_HTML .= "</table>";
	}
	else
	{
		$table_HTML .= format_notice("No users are available in this group.");
	}
}




#===============================================================================================
# Show the user invitations list
#===============================================================================================
else if(!empty($area) && $area == 'search_user_invitations_list')
{
	$table_HTML .= $combined_js_HTML.$combined_css_HTML;

	if(!empty($page_list))
	{
		$table_HTML .= "<table width='100%' border='0' cellspacing='0' cellpadding='5'>
          	<tr>
			<td class='listheader' colspan='2' align='left'>Invitation</td>
           	<td class='listheader' align='right' nowrap>Time Left</td>
			</tr>";
		$counter = 0;
		foreach($page_list AS $row)
		{
			#Is the company private or public?
			$type_icon = ($row['companytype'] == 'private')? "private_icon.png": "public_icon.png";

			#Show one row at a time
			$table_HTML .= "<tr style='".get_row_color($counter, 2)."'>
			<td width='1%' valign='top' nowrap><img src='".base_url()."images/".$type_icon."' /> ";

			#The inviting company icon
			if(!empty($row['iconurl']))
			{
				#Get image settings and reduce the size if it is too wide
				$img_settings = minimize_image(UPLOAD_DIRECTORY."images/".$row['iconurl']);
				$width = ($img_settings['width'] > 56)? 56: $img_settings['width'];
				$table_HTML .= "<img src='".base_url()."downloads/images/".$row['iconurl']."' width='".$width."'/>";
			}

			$diff_format = ($row['datediff'] < 0)? " class='redtext'": " class='contentlink'";
			$diff = ($row['datediff'] < 0)? "-": "";

			$date_diff_str = get_date_diff_str(abs($row['datediff']), 'hrs');

			$table_HTML .= "</td>
                <td width='98%'><a href='".base_url()."deal/view_invitation/i/".encryptValue($row['id'])."' ".$diff_format.">".wordwrap($row['dealdescription'], 70, '<BR>')."</a></td>
                <td width='1%' align='right' valign='top' nowrap><span ".$diff_format.">".$diff.$date_diff_str."</span></td>
              </tr>";
			$counter++;
		}
		$table_HTML .= "</table>";

	}
	else
	{
		$table_HTML .= format_notice("No invitation meets your search.");
	}

}




#===============================================================================================
# Select account number
#===============================================================================================
else if(!empty($area) && $area == 'order_accountnumber_list')
{
	$table_HTML .= $combined_js_HTML.$combined_css_HTML;

	if(!empty($page_list))
	{
		$table_HTML .= "<table width='100%' border='0' cellspacing='0' cellpadding='5'>
		<tr><td><table width='100%'><tr><td><b>Top ".NUM_OF_ROWS_PER_PAGE." Results</b></td><td align='right'><a href='javascript:void(0)' onclick=\"hideLayerSet('".$layer."')\"><img src='".base_url()."images/delete_icon.png' border='0'/></a></td></tr></table></td></tr>";

		$counter = 0;
		foreach($page_list AS $row)
		{
			#Show one row at a time
			$table_HTML .= "<tr style='".get_row_color($counter, 2)."'>";

			if(!empty($subarea) && $subarea == 'portfolio_account')
			{
				$table_HTML .= "<td valign='top' nowrap><a href='javascript:void(0)' onClick=\"updateFieldLayer('".base_url()."deal/new_portfolio_order/i/".encryptValue($row['accountnumber'])."','','','','')\" title=\"Click to select this account number.\" class='bluelink'>".$row['accountnumber']."</a></td>";
			}
			else
			{
				$table_HTML .= "<td valign='top' nowrap><a href='javascript:void(0)' onClick=\"updateFieldValue('".$fieldname."', '".$row['accountnumber']."');hideLayerSet('".$layer."')\" title=\"Click to select this account number.\" class='bluelink'>".$row['accountnumber']."</a></td>";
			}

			$table_HTML .= "</tr>";

			$counter++;
		}
		$table_HTML .= "</table>";
	}
	else
	{
		$table_HTML .= "<table><tr><td align='right'><a href='javascript:void(0)' onclick=\"hideLayerSet('".$layer."')\"><img src='".base_url()."images/delete_icon.png' border='0'/></a></td></tr>
		<tr><td>".format_notice("No results match the search.")."</td></tr>
		</table>";
	}
}



#===============================================================================================
# Uploaded photo results
#===============================================================================================
else if(!empty($area) && $area == 'uploaded_photo')
{
	if(!empty($msg) && $msg == 'SUCCESS')
	{
		$table_HTML .= '<img src="'.$photo_dir.'" class="profile-pic" />';
	}
	else
	{
		$table_HTML .= '<img src="'.base_url().'images/no-photo.jpg" class="profile-pic" />';
		$table_HTML .= '<div>'.format_notice($msg).'</div>';
	}
}



#===============================================================================================
# Show the help list
#===============================================================================================
else if(!empty($area) && $area == 'help_list')
{
	$table_HTML .= $combined_js_HTML.$combined_css_HTML;
	$table_HTML .= "<table cellpadding='5' cellspacing='0' border='0'>
		<tr><td><b>Top ".NUM_OF_ROWS_PER_PAGE." Search Results:</b></td><td align='right'><a href='javascript:void(0)' onClick=\"hideLayerSet('".$layer."')\"><img src='".base_url()."images/delete_icon.png' border='0' /></a></td></tr>
		<tr><td colspan='2'>";

	if(!empty($page_list))
	{
		$table_HTML .= "<table width='100%' border='0' cellspacing='0' cellpadding='5'>";
		$counter = 0;
		foreach($page_list AS $row)
		{

			#Show one row at a time
			$table_HTML .= "<tr style='".get_row_color($counter, 2)."'>
				<td><a href='javascript:void(0)' onClick=\"updateFieldValue('".$fieldname."', '".$row['helptopic']."');updateFieldValue('".$hiddenfieldname."', '".$row['topiccode']."');updateFieldLayer('".base_url()."help/add_help_topic/i/".encryptValue($row['topiccode'])."', '', '', '', '');hideLayerSet('".$layer."');showLayerSet('instructiondiv')\" title=\"Click to select content for this topic.\" class='bluelink'>".$row['helptopic']."</a></td>
              </tr>";
			$counter++;
		}

		$table_HTML .= "</table>";
	}
	else
	{
		$table_HTML .= format_notice("<span class='error'>No help topic meets your search.</span>");
	}

	$table_HTML .= "</td></tr></table>";
}





#===============================================================================================
# Show the help details for a given topic
#===============================================================================================
else if(!empty($area) && $area == 'help_details')
{
	$table_HTML .= $combined_js_HTML.$combined_css_HTML;

	if(!empty($page_list))
	{
		$table_HTML .= "<table width='100%' border='0' cellspacing='0' cellpadding='5' class='selectfield' style='background: #F2F4F4;'>
		<tr><td><b>Content List:</b><br />";
		$counter = 0;
		foreach($page_list AS $row)
		{
			#Show one row at a time
			$table_HTML .= "<div class='ui-state-default'><table style='".get_row_color($counter, 2)."'><tr>
    <td valign='top'><a href='javascript:void(0)' title='Click to remove this help item.'><img src='".base_url()."images/delete.png' border='0'/></a><br><span class='ui-icon ui-icon-arrowthick-2-n-s'></span></td>
    <td>".$row['details']."</td>
    </tr></table></div>";
			$counter++;
		}

		$table_HTML .= "</td></tr></table>";
	}
	else
	{
		$table_HTML .= format_notice("<span class='error'>No help is attached to this topic.</span>");
	}
}





#===============================================================================================
# Show the manage help list
#===============================================================================================
else if(!empty($area) && $area == 'manage_help_list')
{
	$table_HTML .= $combined_js_HTML.$combined_css_HTML;

	if(!empty($page_list))
	{

		$table_HTML .= "<table width='100%' border='0' cellspacing='0' cellpadding='5'>
          	<tr>
			<td class='listheader'>&nbsp;</td>
			<td class='listheader'>Help Topic</td>
           	<td class='listheader' nowrap>Last Updated</td>
			</tr>";
		$counter = 0;
		foreach($page_list AS $row)
		{
			#Show one row at a time
			$table_HTML .= "<tr style='".get_row_color($counter, 2)."'>
				<td width='1%'>";

			if(check_user_access($this,'update_help_topic')){
			$table_HTML .= "<a href='".base_url()."help/add_help_topic/i/".encryptValue($row['topiccode'])."' title=\"Click to edit this help topic.\"><img src='".base_url()."images/edit.png' border='0'/></a>";
			}

			$table_HTML .= "</td>

				<td width='1%' valign='top' nowrap><a href='".base_url()."help/view_help_topic/i/".encryptValue($row['topiccode'])."' class='fancybox fancybox.ajax bluelink'>".$row['helptopic']."</a></td>

                <td width='98%'>".date('m/d/Y h:iA', strtotime($row['lastupdateddate']))."</td>
			</tr>";
			$counter++;
		}

		$table_HTML .= "</table>";
	}
	else
	{
		$table_HTML .= format_notice("<span class='error'>No help meets your search.</span>");
	}


}





#===============================================================================================
# Show the manage message list
#===============================================================================================
else if(!empty($area) && $area == 'message_list')
{
	$table_HTML .= $combined_js_HTML.$combined_css_HTML;

	if(!empty($page_list))
	{
		$table_HTML .= "<table width='100%' border='0' cellspacing='0' cellpadding='5'>
          	<tr>
			<td class='listheader' width='1%'>&nbsp;</td>
           	<td class='listheader' width='1%' nowrap>Message</td>
           	<td class='listheader' width='98%' nowrap>Date</td>
			</tr>";
		$counter = 0;
		foreach($page_list AS $row)
		{
			$bold_start = ($row['isread'] == 'N')? "<b>": "";
			$bold_end = ($row['isread'] == 'N')? "</b>": "";

			#Show one row at a time
			$table_HTML .= "<tr style='".get_row_color($counter, 2)."'>
			<td valign='top' nowrap>";

			if(check_user_access($this,'delete_message')){
			$table_HTML .= "<a href='javascript:void(0)' onclick=\"confirmDeleteEntity('".base_url()."messages/deactivate_message/i/".encryptValue($row['id'])."', 'Are you sure you want to remove this message? \\nThis operation can not be undone. \\nClick OK to confirm, \\nCancel to cancel this operation and stay on this page.');\" title=\"Click to remove this message.\"><img src='".base_url()."images/delete.png' border='0'/></a>";
			}

			$table_HTML .= "</td>

			<td valign='top' nowrap><a href='".base_url()."messages/load_form/i/".encryptValue($row['id'])."/a/".encryptValue('view')."' class='contentlink'>".$bold_start.wordwrap($row['subject'], 80, "<BR>").$bold_end."</a></td>

			<td valign='top' nowrap>".$bold_start.date("d-M-Y h:iA", strtotime($row['datesent'])).$bold_end."</td>
			</tr>";

			$counter++;
		}
		$table_HTML .= "</table>";
	}
	else
	{
		$table_HTML .= format_notice("<span class='error'>No messages meet your search.</span>");
	}
}





#===============================================================================================
# Show the selected receiver list
#===============================================================================================
else if(!empty($area) && $area == 'selected_receiver_list')
{
	$table_HTML .= $combined_js_HTML.$combined_css_HTML;

	if($this->session->userdata('exclusers'))
	{
		$excl_users = $this->session->userdata('exclusers');

		$page_result = $this->db->query($this->Query_reader->get_query_by_code('get_users_in_list', array('idlist'=>"'".implode("','", $excl_users)."'")));
		$page_list = $page_result->result_array();

		if(!empty($page_list))
		{
			$table_HTML .= "<div id='del_result'></div>
			<div class='listheader'>Selected Recipients:</div>";
			foreach($page_list AS $row)
			{
				#Show one row at a time
				$table_HTML .= "<div id='".$row['id']."' class='resultsrow'>
				<table width='100%' style='".get_row_color(0, 2)."'>
				<tr>
				<td width='1%'><a href=\"javascript:void(0)\" onclick=\"pickSearchResult('".base_url()."messages/remove_receiver/i/".encryptValue($row['id'])."', '".$row['id']."', 'del_result', 'selectedusers')\"><img src='".IMAGE_URL."delete.png' border='0' class='btn'/></a></td>
				<td width='1%'>".$row['firstname']." ".$row['lastname']."</td>
				<td width='1%'><b>".$row['organizationname']."</b></td>
				<td width='97%' nowrap>(".$row['emailaddress'].")<input type='hidden' name='recipientids[]' id='recipientids_".$row['id']."' value='".$row['id']."'></td>
				</tr>
				</table>
				</div>";
			}
		}
		else
		{
			$table_HTML .= format_notice("<span class='error'>No messages meet your search.</span>");
		}

	}
}





#===============================================================================================
# Show the video in larger mode
#===============================================================================================
else if(!empty($area) && $area == 'view_video')
{
	$table_HTML .= "<html>
	<head><title>Larger Video</title>
	</head>
	<body>
	<object id=\"movie\" type=\"application/x-shockwave-flash\" data=\"".base_url()."downloads/documents/".decryptValue($u)."\" style=\"width: 1383px; height: 778px;\">
	<param name=\"movie\" value=\"".base_url()."downloads/documents/".decryptValue($u)."\" />
	<param name=\"quality\" value=\"high\" />
	<param name=\"bgcolor\" value=\"#ffffff\" />
	<p>You do not have the latest version of Flash installed. Please visit this link to download it: <a href=\"http://www.adobe.com/products/flashplayer/\">http://www.adobe.com/products/flashplayer/</a></p>
</object>
	</body>
	<html>";
}







#===============================================================================================
# Show fund sector list
#===============================================================================================
else if(!empty($area) && $area == 'fund_sector')
{
	$table_HTML .= $combined_js_HTML.$combined_css_HTML;

	if(!empty($page_list))
	{
		$table_HTML .= "<table cellpadding='5' cellspacing='0' border='0'>
		<tr><td><b>Top ".NUM_OF_ROWS_PER_PAGE." Search Results:</b></td><td align='right'><a href='javascript:void(0)' onClick=\"hideLayerSet('".$layer."')\"><img src='".base_url()."images/delete_icon.png' border='0' /></a></td></tr>";
		$counter = 0;
		foreach($page_list AS $row)
		{
			#Show one row at a time
			$table_HTML .= "<tr style='".get_row_color($counter, 2)."'><td colspan='2'><a href='javascript:void(0)' onClick=\"updateFieldValue('fundsector', '".ucfirst($row['fundsector'])."');hideLayerSet('".$layer."')\" class='bluelinks'>".ucfirst($row['fundsector'])."</a></td></tr>";
			$counter++;
		}
		$table_HTML .= "</table>";

	} else {
		$table_HTML .= "<table cellpadding='5' cellspacing='0' border='0'>
			<tr><td><b>Top ".NUM_OF_ROWS_PER_PAGE." Search Results:</b></td><td align='right'><a href='javascript:void(0)' onClick=\"hideLayerSet('".$layer."')\"><img src='".base_url()."images/delete_icon.png' border='0' /></a></td></tr></table>".
			format_notice("No sector meets search.");
	}

}







#===============================================================================================
# Show the NAV details
#===============================================================================================
else if(!empty($area) && $area == 'nav_amt_details')
{
	$table_HTML .= $combined_js_HTML.$combined_css_HTML;

	if((!empty($unfunded) || $unfunded == 0) && !empty($fundedamount))
	{
		$table_HTML .= "<b>Unfunded Amount:</b> $".addCommas($unfunded)." &nbsp;&nbsp; NAV: $".addCommas(removeCommas(restore_bad_chars($fundedamount)));
	}
	else
	{
		$table_HTML .= format_notice("<span class='error'>Invalid Commitment or funded amount.</span>");
	}
}







#===============================================================================================
# Show the Uncalled details
#===============================================================================================
else if(!empty($area) && $area == 'called_amt_details')
{
	$table_HTML .= $combined_js_HTML.$combined_css_HTML;

	if((!empty($uncalled) || $uncalled == 0) && !empty($dealamount) && $uncalled >= 0)
	{
		$perc = addCommas(($uncalled/removeCommas($dealamount))*100);
		$table_HTML .= "<b>Uncalled Amount:</b> $".addCommas($uncalled)." &nbsp;&nbsp; (".$perc."%)";
	}
	else
	{
		$table_HTML .= format_notice("<span class='error'>Invalid called or commitment amount.</span>");
	}
}







#===============================================================================================
# Show the new section details
#===============================================================================================
else if(!empty($area) && $area == 'new_section_details')
{
	$table_HTML .= $combined_js_HTML.$combined_css_HTML;

	if(!empty($a) && decryptValue($a) == 'add')
	{
		$table_HTML .= format_notice("New section added")."<select name='fileunder' id='fileunder'  class='selectfield' onchange=\"showWithValue('fileunder', 'addbtn', 'addfields')\">";

		$section_list = $this->db->query($this->Query_reader->get_query_by_code('search_file_under', array('searchstring'=>'')));
		$options = $section_list->result_array();
		$selected = restore_bad_chars($sectionname);

		$options = array_merge(array(array('fileunder'=>$selected)), $options);
		$table_HTML .= get_select_options($options, 'fileunder', 'fileunder', '');

		$table_HTML .= "</select>";
	}
	else
	{
		$table_HTML .= "<table class='lightgreybg'>
		<tr>
		<td class='label'>New Section:</td>
		<td><input name='sectionname' type='text' id='sectionname' size='18' class='textfield' value='' /></td>
		<td><input type='button' name='addsection' id='addsection' value='Add' class='bodybutton' onclick=\"updateFieldLayer('".base_url()."deal/add_section/a/".encryptValue('add')."', 'sectionname', 'newsectiondetails', 'fileunderdiv', 'Enter the new section name.')\" /></td>
		<td>
		<input type='button' name='canceladdn' id='canceladdn' value='Cancel' class='bodybutton' onclick=\"unhideShowLayer('newsec','');absHideDiv('newsectiondetails');\" />
		</td>
		</tr>
		</table>";
	}
}









#===============================================================================================
# Select the order user
#===============================================================================================
else if(!empty($area) && $area == 'select_order_user')
{
	$table_HTML .= $combined_js_HTML;

	if(!empty($page_list))
	{
		$table_HTML .= "<table cellpadding='5' cellspacing='0' border='0'>
		<tr><td><b>Top ".NUM_OF_ROWS_PER_PAGE." Search Results:</b></td><td align='right'><a href='javascript:void(0)' onClick=\"hideLayerSet('".$layer."')\"><img src='".base_url()."images/delete_icon.png' border='0' /></a></td></tr>";
		$counter = 0;
		foreach($page_list AS $row)
		{
			#Show one row at a time
			$table_HTML .= "<tr style='".get_row_color($counter, 2)."'><td colspan='2'><a href='javascript:void(0)' onClick=\"updateFieldLayer('".base_url()."deal/add_single_order/d/".$d."/u/".encryptValue($row['id'])."', '', '', '', '');hideLayerSet('".$layer."')\" class='bluelinks'>".$row['firstname']." ".$row['lastname']."</a> (".$row['emailaddress'].")</td></tr>";
			$counter++;
		}
		$table_HTML .= "</table>";

	} else {
		$table_HTML .= "<table><tr><td align='right'><a href='javascript:void(0)' onclick=\"hideLayerSet('".$layer."')\"><img src='".base_url()."images/delete_icon.png' border='0'/></a></td></tr>
		<tr><td>".format_notice("No user meets search.")."</td></tr></table>";
	}
}
































if(!empty($table_HTML))
{
	#echo htmlentities($table_HTML);
	echo $table_HTML;
}
?>

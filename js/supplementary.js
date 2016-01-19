// JavaScript Document
var curGradeScaleRanges = Array();

function  refreshListController(context)
{
	var curContext = context;
	
	this.refreshList = function refreshList()
	{
		if(this.curContext !== undefined)
		{
			document.getElementById(this.curContext).click();
			this.curContext = undefined;
		}
	}
}

function saveSubject(urlVars, formVars)
{
	updateFieldLayer(getBaseURL()+'curriculum/save_subject'+urlVars, formVars,'','subject_results','Please enter the required fields.');
	listRefresher.curContext='manage-curriculum';
}

function saveStaffGroup(urlVars, formVars)
{
	updateFieldLayer(getBaseURL()+'user/save_staff_group'+urlVars, formVars,'','staff-group-form-results','Please enter the required fields.');
	listRefresher.curContext='manage-user-groups';
}

function saveGradingScheme(urlVars, formVars)
{
	assignGradeData();
	updateFieldLayer(getBaseURL()+'grading/save_grading_scale'+urlVars, formVars,'','grading-results','Please enter the required fields.');
	gradedata = new Array();
	listRefresher.curContext='manage-grading';	
}

function saveExam(urlVars, formVars)
{
	updateFieldLayer(getBaseURL()+'exams/save_exam'+urlVars, formVars,'','exam-results','Please enter the required fields.');
	listRefresher.curContext='manage-exams';	
}

function saveTerm(urlVars, formVars)
{
	updateFieldLayer(getBaseURL()+'terms/save_term'+urlVars, formVars,'','term_results','Please enter the required fields.');
	listRefresher.curContext='manage-terms';	
}

function saveClass(urlVars, formVars)
{
	updateFieldLayer(getBaseURL()+'classes/save_class'+urlVars, formVars,'','class-results','Please enter the required fields.');
	listRefresher.curContext='manage-classes';	
}

function saveBook(urlVars, formVars)
{
	updateFieldLayer(getBaseURL()+'library/save_title'+urlVars, formVars,'','book-title-form','Please enter the required fields.');
	listRefresher.curContext='manage-stock';	
}

function saveTransaction(urlVars, formVars)
{
	updateFieldLayer(getBaseURL()+'finances/save_petty_cash_transaction'+urlVars, formVars,'','transaction-results','Please enter the required fields.');
	listRefresher.curContext='manage-petty-cash';	
}

function saveAccount(urlVars, formVars)
{
	updateFieldLayer(getBaseURL()+'finances/save_account'+urlVars, formVars,'','account-results','Please enter the required fields.');
	listRefresher.curContext='manage-petty-cash';	
}

function saveStaff(urlVars, formVars)
{
	updateFieldLayer(getBaseURL()+'user/save_staff'+urlVars, formVars, '', 'staff-results', 'Please enter the required fields.');
	listRefresher.curContext='manage-staff';	
}

function saveStudentSponsor(urlVars, formVars)
{
	updateFieldLayer(getBaseURL()+'students/save_student_sponsor'+urlVars, formVars, '', 'sponsorship-form-results', 'Please enter the required fields.');
	listRefresher.curContext='student-sponsors';	
}

function saveSponsor(urlVars, formVars)
{
	updateFieldLayer(getBaseURL()+'sponsors/save_sponsor'+urlVars, formVars, '', 'sponsor-form-results', 'Please enter the required fields.');
	//listRefresher.curContext='manage-sponsors';	
}

function manageSchoolInfo()
{
	updateFieldLayer(getBaseURL()+'schoolinfo/manage_school_info', '', '', 'contentdiv', 'Please enter the required fields.');
}

function toggleChecked(status) {
	$(".list_checkbox").each( function() {
		$(this).attr("checked",status);
	});
}

function isAnyChecked(objectType)
{
	var checked = 0;
	$(".list_checkbox").each( function() {
		if($(this).is(':checked')) checked++;
	});
	
	if(!checked) {
		alert("Please select a "+objectType);
		return false;
	}
	else
	{
		return true;
	}
}

function registrationForm()
{
	if(isAnyChecked('student'))
	{	
		//get list of selected students
		 var checked = 0;
		 var selectedStudents = '';
		$(".list_checkbox").each( function() {
			if($(this).is(':checked')){
				stdId = ((this.id).split('_'));
				stdId = stdId[stdId.length -1];
								
				selectedStudents += '<tr class="selected_reg_std" id="selected_reg_std_'+stdId+'" style="background-color:'+((checked%2)? '#FFFFFF;' :'#F0F0E1')+'">'+
										'<td><a href=\'javascript:void(0)\' title="Click to remove '+$('#std_name_'+stdId+' a').html()+' from the list."><img src=\"'+getBaseURL()+'images/delete.png" border=0/></a></td>'+
										'<td>'+$('#std_name_'+stdId+' a').html()+'</td>'+
										'<td>'+$('#std_class_'+stdId).html()+'</td>'+
									 '</tr>';
				
				checked++;
			}
		});
		
		$('#selected-reg-students').append(selectedStudents);
		$('#contenttable').slideUp();
		$('#registration_form').slideDown();
		
	}
}

function getClassSubjects(selectedClass)
{
	if(selectedClass != '')
	{
		updateFieldLayer(getBaseURL()+'curriculum/get_subjects_by_class/sc/'+selectedClass, '', '', 'class-subjects', '');
	}
	else
	{
		document.getElementById('class-subjects').innerHTML = 'Select a class to view the applicable subjects';
	}
}

var academiaLibrarySpace = academiaLibrarySpace || {};

academiaLibrarySpace.booksInLibraryBasket = new Array();

academiaLibrarySpace.removeBookFromBasket = function (rowId){
	$('#'+rowId).remove();
	$("#selected-books-table").find("tr:even:not(:first)").addClass("stripe");
	
	var bookId = rowId.split('-');
	bookId = bookId[bookId.length -1];
	
	var tempbooksInLibraryBasket = academiaLibrarySpace.booksInLibraryBasket;
	
	for(i=0; i<tempbooksInLibraryBasket.length; i++)
	{
		if(tempbooksInLibraryBasket[i] == bookId)
		{
			tempbooksInLibraryBasket.splice(i,1);
			break;
		}
	}
	
	academiaLibrarySpace.booksInLibraryBasket = tempbooksInLibraryBasket;
	
	if(!academiaLibrarySpace.booksInLibraryBasket.length)
	{
		document.getElementById('selected-books-header').innerHTML = '<td class="borrower_details_help"><table width="100%" border=0 class="notice help" cellspacing=0 cellpadding=10>'+
		'<tr><td width=50 class="msg_icon" align="center" nowrap><img src="'+getBaseURL()+'images/blue_exclamation.png"  border=0/></td><td class="msg" valign="middle">No books have been selected</td></tr></table></td>';
		
		document.getElementById('save-borrow-transaction').style.display = 'none';
	}
}

academiaLibrarySpace.addBookToBasket = function (bookId, bookIsbn, bookTitle, author, layerToHide){
	var tempBooksInLibraryBasket = academiaLibrarySpace.booksInLibraryBasket;
	
	if($('.borrower_details_help').length) academiaLibrarySpace.booksInLibraryBasket.length = 0;
	
	if(jQuery.inArray(bookId, academiaLibrarySpace.booksInLibraryBasket) == -1)
	{
		if($('.borrower_details_help').length)
		{
			academiaLibrarySpace.booksInLibraryBasket.length = 0;
			document.getElementById('selected-books-header').innerHTML = '<td class="form_table_header">ISBN Number</td>'+
																		  '<td class="form_table_header">Title</td>'+
																		  '<td class="form_table_header">Author</td>'+
																		  '<td></td>';
		}
		
		document.getElementById('selected-books-table').innerHTML+= '<tr id="book-row-'+bookId+'">'+
																		'<td>'+
																			'<input type="hidden" name="selected_books[]" value="'+bookId+'" />'+
																			bookIsbn+
																		'</td>'+
																		'<td>'+bookTitle+'</td>'+
																		'<td>'+author+'</td>'+
																		'<td><input type="button" value="Remove" onclick="academiaLibrarySpace.removeBookFromBasket(\'book-row-'+bookId+'\')" /></td>'+
																	'</tr>';
																	
		$("#selected-books-table").find("tr:even:not(:first)").addClass("stripe");
		
		//add selected book id to array, such that it is excluded in subsequent searches
		tempBooksInLibraryBasket.push(bookId);
		academiaLibrarySpace.booksInLibraryBasket = tempBooksInLibraryBasket;
		//hideLayerSet(layerToHide);
        $('#selected-books-result-'+bookId).closest('tr').remove();
		
		if(document.getElementById('save-borrow-transaction').style.display == 'none')
			document.getElementById('save-borrow-transaction').style.display = 'block';
	
	}
	else
	{
		alert("The item you are trying to add is already in the borrow basket");
	}
}

function registerStudents()
{

  
	if(checkEmpty('reg-term', 'Please specify the school term') && checkEmpty('reg-class', 'Please specify the class'))
	{
		//format the selected subjects
		var selectedSubjects = '';
		$(".subjects_for_select").each( function() {
			if($(this).is(':checked')){
				subjectId = ((this.id).split('_'));
				subjectId = subjectId[subjectId.length -1];								
				selectedSubjects += (selectedSubjects == '')? '|'+subjectId+'|' : subjectId+'|';
			}
		});
		document.getElementById('selected-reg-subjects').value = selectedSubjects;
		
		//format selected students
		var selectedStudents = '';
		$(".selected_reg_std").each( function() {
				studentId = ((this.id).split('_'));
				studentId = studentId[studentId.length -1];								
				selectedStudents += (selectedStudents == '')? studentId : '^'+studentId;
		});
		document.getElementById('selected-reg-students').value = selectedStudents;
		
		updateFieldLayer(getBaseURL()+'students/register_student', 'regstudents<>reg-term<>reg-class<>selected-reg-students<>*selected-reg-subjects', '', 'registration_form', '');
	}
}

function viewStudents()
{
	updateFieldLayer(getBaseURL()+'students/manage_students','','','contentdiv','');
}

function viewCurSubjects()
{
	$('#current-term-gradebook ul').slideToggle();
}

function uploadPhotoViaAjax()
{
	var btnUpload=$('#add-image');
	var files=$('#my-image');
	var photoUrl;
	
	new AjaxUpload(btnUpload, {
		action: getBaseURL()+'photo/upload_photo',
		name: 'insert-image',
		onSubmit: function(file, ext){
			 if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext))){ 
				// extension is not allowed 
				mestatus.text('Only JPG, PNG or GIF files are allowed');
				return false;
			}
			
			$('#image-upload-status').slideDown();
			$('#profile-pic').attr('src', getBaseURL()+'images/loading.gif');
		},
		onComplete: function(file, response){
			//On completion clear the status
			
			//On completion clear the status
			$('#image-upload-status').slideUp();
	
			if(response == 'ERROR')
			{
				$('#image-upload-error').slideDown();
				$('#profile-pic').attr('src', getBaseURL()+'images/no-photo.jpg');
			}
			else
			{
				//Add uploaded file to list
				$('#image-upload-error').slideUp();
				$('#profile-pic').attr('src', response);
				photoUrl = response.split('/');
				$('#photo').val(photoUrl[photoUrl.length-1].replace('_thumb', ''));
			}			
		}
	});
}

function initClientDashboard()
{
	listRefresher = new refreshListController('');
		
	menuController = new switchActiveMenu('dashboard');	  
	
	$('#school-info').click(manageSchoolInfo); 
	   
	$('.fancybox').fancybox({
		afterClose: function(){
			listRefresher.refreshList();
			academiaLibrarySpace.booksInLibraryBasket = new Array();
        }
    });

		
	$('.nav a').click(function(){
		menuController.switchMenu(this.id);
	});

    $('#class-type, #select-class, #select-term').live('change', function(){
        if($('#class-type').val() == 'current')
        {
            if(!isNullOrEmpty($('#select-class').val()) || !isNullOrEmpty($('#select-term').val()))
            {
                updateFieldLayer(getBaseURL()+'search/load_results/type/classes/phrase/'+ ($('#search').val() == '' ? 'null' : $('#search').val() ) +'/term/'+ ($('#select-term').val() == '' ? 'null' : $('#select-term').val()) +'/class/'+ ($('#select-class').val() == ''? 'null' : $('#select-class').val()), '', '', 'searchresults', '');
            }
        }
        else if($('#class-type').val() == 'admission')
        {
            if(!isNullOrEmpty($('#select-class').val()) || !isNullOrEmpty($('#select-term').val()))
            {
                updateFieldLayer(getBaseURL()+'search/load_results/type/admission/phrase/'+ ($('#search').val() == '' ? 'null' : $('#search').val() ) +'/term/'+ ($('#select-term').val() == '' ? 'null' : $('#select-term').val()) +'/class/'+ ($('#select-class').val() == ''? 'null' : $('#select-class').val()), '', '', 'searchresults', '');
            }
        }
    });
	
	$('#select_all, #unselect_all, #register-students, #advanced-search, #regstudents, #back-to-students, #grade-term-title, #previous-terms-title, #save-marks, #select-academic-period, #previous-terms-title').live('click', function(){
		switch(this.id){
			case 'select_all':
				toggleChecked(true);
				break;
				
			case 'unselect_all':
				toggleChecked(false);
				break;
				
			case 'advanced-search':
				$('.advanced_search').slideToggle();
				break;
				
			case 'register-students':
				registrationForm();
				break;
			
			case 'regstudents':
				registerStudents();
				break;
			
			case 'back-to-students':
				viewStudents();
				break;
			
			case 'previous-terms-title':
				if($('#current-term-gradebook ul').css('display') == 'block')
					$('#current-term-gradebook ul').slideUp();

                if($('#previous-terms-title .more_arrow').length>0)
                {
                    $('#previous-terms-title .more_arrow').removeClass('more_arrow').addClass('less_arrow');
                    $(".previous-term-sub-title").slideDown();
                }
                else
                {
                    $(".previous-term-sub-title").slideUp();
                    $('#previous-terms-title .less_arrow').removeClass('less_arrow').addClass('more_arrow');
                }

				break;
				
			case 'grade-term-title':
				viewCurSubjects();			
				if($('#previous-term-gradebook ul').css('display') == 'block')
					$('#previous-term-gradebook ul').slideUp();					
				break;
			
			case 'select-academic-period':
				$(".academic_period_details ul").each(function(){$(this).slideUp();});
				
				$('.academic_period_year').slideToggle('swing', function(){
					if($('.academic_period_year').css('display') == 'block')
					{
						$('#select-academic-period .more_arrow').addClass('less_arrow');
						$('#select-academic-period .more_arrow').removeClass('more_arrow');
					}
					else
					{
						$('#select-academic-period .less_arrow').addClass('more_arrow');
						$('#select-academic-period .less_arrow').removeClass('less_arrow');
					}
				});								
						
				break;
								
			/* case 'save-marks':
				$('#mark-sheet-result').html('<img src="'+getBaseURL()+'images/loading.gif" />');
				
				$.ajax({
					   type: "POST",
					   url: getBaseURL()+"gradebook/save_marks",
					   data: $("#mark-sheet-form").serialize(), // serializes the form's elements.
					   success: function(data)
					   {
						   $('#mark-sheet-result').html(data);
					   }
					 });
			
				return false;
				
				break; */
		}	
		
	});

    $('.previous-term-sub-title').live('click', function(){
        var thisIdArr = this.id.split('-');
        var termDef = thisIdArr[thisIdArr.length - 1];
        if($('#term-subjects-'+termDef).css('display') == 'block')
        {
            $('#term-subjects-'+termDef).slideUp();
            $('#grade-term-'+termDef+' .less_arrow').removeClass('less_arrow').addClass('more_arrow');
        }
        else
        {
            $('.term_subjects').slideUp();
            $('#term-subjects-'+termDef).slideDown();
            $('#grade-term-'+termDef+' .more_arrow').removeClass('more_arrow').addClass('less_arrow');
        }
    });
	
	var uploadAjaxImageFound = false;
	
	$('body').on({
		 DOMNodeInserted : function(e){
			element = e.target;
			if($('.datepicker').length>0 && $(element).hasClass('datepicker'))
			{
				$('.datepicker').datepicker({
					dateFormat: "yy-mm-dd",
					changeMonth: true,
					changeYear: true,
					yearRange: "-50:+50"
					});
			}

             /*
            if($('.datatable').length>0 && $(element).hasClass('hasDatatable'))
            {
                alert('hello');
                $('.datatable').dataTable();
            }
            */
			
			/*
			if($('.keysearch').length>0 && $(element).hasClass('has_keysearch'))
			{
				alert('hello');
				 var availableTags = [
					"ActionScript",
					"AppleScript",
					"Asp",
					"BASIC",
					"C",
					"C++",
					"Clojure",
					"COBOL",
					"ColdFusion",
					"Erlang",
					"Fortran",
					"Groovy",
					"Haskell",
					"Java",
					"JavaScript",
					"Lisp",
					"Perl",
					"PHP",
					"Python",
					"Ruby",
					"Scala",
					"Scheme"
					];
					
				$( ".keysearch" ).autocomplete({
					source: availableTags
					});
			}
			*/
			
			if($('#add-image').length>0 && $(element).hasClass('has_photo_upload')){
				$('input[name="insert-image"]').remove();
				 if($('input[name="insert-image"]').length<1)
					uploadPhotoViaAjax();
					uploadAjaxImageFound = true;				
			}
		}
	 });
	
	
	$('.academic_period').live('click', function(){
		//get the term id
		var term_arr = (this.id).split('^');
		updateFieldLayer(getBaseURL()+'students/get_student_academics/term/'+term_arr[1]+'/i/'+term_arr[2],'','','academics-content','');
	});
	
	
	$('.academic_period_year').live('click', function(){
		var curOpenTerms = $(this).next('ul');
		var curOpenAcademicYear = $(this);
		curOpenTerms.slideToggle('swing', function(){
			if(curOpenTerms.css('display') == 'block')
			{
				curOpenAcademicYear.find('div').addClass('less_arrow');
				curOpenAcademicYear.find('div').removeClass('more_arrow');
			}
			else
			{
				curOpenAcademicYear.find('div').addClass('more_arrow');
				curOpenAcademicYear.find('div').removeClass('less_arrow');
			}
		});
	});
	
	$('#save-marks').live('click', function(){
		$('#mark-sheet-result').show();
		$('#mark-sheet-result').html('<img src="'+getBaseURL()+'images/loading.gif" />');
				
				$.ajax({
					   type: "POST",
					   url: getBaseURL()+"gradebook/save_marks",
					   data: $("#mark-sheet-form").serialize(), // serializes the form's elements.
					   success: function(data)
					   {
						   //get grade scale ranges
						   $('#mark-sheet-result').html(data);
					   }
					 });
			 
				return false;
	});
	
	
	$("#staff-group-permissions-form").live("submit", function(event){
		var postURL = $(this).attr('action');
        $.ajax({
			  url : postURL,
			  type : "POST",
			  data : $("#staff-group-permissions-form").serialize(),
			  success:function (data)
			  {
				  document.getElementById("staff-group-permissions").innerHTML = data;
				  //$("#staff-group-permissions").html(data);
			  },
			  error:function (XHR, status, response) {
				alert(response);
			  }
        });
		event.preventDefault();
    });
	
	
	$(".ajaxPost").live("submit", function(event){			
			var postURL = $(this).attr('action');
			var callBackElement = $("#call-back-element").val();
			
			var tempFormHTML = document.getElementById(callBackElement).innerHTML;
			document.getElementById($("#call-back-element").val()).innerHTML = '<img src="'+getBaseURL()+'images/loading.gif" />';
						
			$.ajax({
				  url : postURL,
				  type : "POST",
				  data : $(this).serialize(),
				  success:function (data)
				  {					  
					  document.getElementById(callBackElement).innerHTML = data;					  
					  if($('#list-link-to-refresh').length>0){
						 listRefresher.curContext = $("#list-link-to-refresh").val();
					  }					 	
				  },
				  error:function (XHR, status, response) {
					document.getElementById(callBackElement).innerHTML = tempFormHTML;
					alert(response);
				  }				  
			});	
				
			event.preventDefault();
		});
	
	
	$('selected-books').live();
	
		
	$('input#borrower, input#select-book').live('keyup', function(){
			switch(this.id){
				case 'borrower':
					startInstantSearch('borrower', 'borrower_searchby', getBaseURL()+'search/load_results/type/borrowers/layer/borrower_results');								
					ShowContent('borrower_results','');
					break;
					
				case 'select-book':
					var selectedBooks = academiaLibrarySpace.booksInLibraryBasket.join('_');
					
					if(selectedBooks != '')
						selectedBooks = '/selectedBooks/'+selectedBooks;
					
					startInstantSearch('select-book', 'select_book_searchby', getBaseURL()+'search/load_results/type/library_books/layer/select_book_results'+selectedBooks);
					ShowContent('select_book_results','');			
			}			
		});

    $('#update-reg-subjects').live('change', function(){
        $('#selected-reg-subjects').val($(this).val());
    });
	
	
	$('.page-links li').live('click', function(){
			var curLi = $(this);
			$('.page-links li').each(function(){
					$(this).removeClass('active');
				});
			$(this).addClass('active');
		});
			
	$('#reg-class').live('change', function(){getClassSubjects($(this).val());});
	
	$('#select-marksheet-exam').live('change', getExamMarksSheet);
	
	$('#current-term-gradebook ul li').live('click', getSubjectStudents);
	
	$('#previous-term-gradebook ul li').live('click', getSubjectStudents);
	
	$('.marks_cell, .comments_cell').live('focusin', function(){
		$(this).closest('tr').addClass('activeRow');
		$(this).closest('div').addClass('activeCell');
	});
	
	$('.marks_cell, .comments_cell').live('focusout', function(){
		$(this).closest('tr').removeClass('activeRow');
		$(this).closest('div').removeClass('activeCell');
		
		if($(this).hasClass('marks_cell')){
			//get the actual mark and student id
			var thisMarkValue = $(this).val();
			var stdMarksRowId = (this.id).split('_');
			stdMarksRowId = stdMarksRowId[stdMarksRowId.length -1];	
			
			if(isNaN(thisMarkValue)){
				alert('Student marks should only be numeric values');
				$(this).closest('div').addClass('fielderror');
				$(this).focus();
			
			}else{
				//calculate the average mark
				var totalStudents = 0;
				var totalMark = 0;
				$(".marks_cell").each( function() {
					totalStudents++;
					if($(this).val()!=''){
						totalMark += parseInt($(this).val());
					}
				});
				
				$('#average-mark').val(parseInt(totalMark/totalStudents));
				
				//get the grade
				var gradeArr;
				$(".grade_scale_row").each( function() {
					gradeArr = ($('#'+this.id+' td:eq(0)').html()).split('-');
					//alert(parseInt(gradeArr[0]) + ' ' +parseInt(gradeArr[1]));
					if(thisMarkValue > parseInt(gradeArr[0]) && thisMarkValue < parseInt(gradeArr[1]))
					{
						$('#grade_cell_'+stdMarksRowId).val($('#'+this.id+' td:eq(1)').html());
					}
				});
				
				$(this).closest('div').removeClass('fielderror');
			}			
		}
	});
	
}


function getSubjectStudents()
{
	//get the line details
	var lineDetailsArray = (this.id).split('_');
	
	$('#current-term-gradebook ul').slideUp();
	
	updateFieldLayer(getBaseURL()+'gradebook/grading_list/s/'+lineDetailsArray[2]+'/c/'+lineDetailsArray[3]+'/t/'+lineDetailsArray[4],'','','grading-list','');
}


function getExamMarksSheet()
{
	if($(this).val() !='')
	{
		var lineDetailsArray = ($('#cste').val()).split('^');
		updateFieldLayer(getBaseURL()+'gradebook/grading_list/s/'+lineDetailsArray[1]+'/c/'+lineDetailsArray[0]+'/t/'+lineDetailsArray[2]+'/e/'+$(this).val(),'','','mark-sheet','');
	}
}
function checkSelection(msg){

	count=0;

	for(var i=0; i<document.forms[0].elements.length;i++){

		if(document.forms[0].elements[i].checked){

			count++;

			}

	}



	if(count==0)

	{

		alert(msg);

		return false;

	}



	return true;

}



$(document).ready(function(){textboxHint("block");});



function textboxHint(id,options){

	var o= {selector:'input:text[title]',blurClass:'blur'},$e=$('#'+id);

	$.extend(true,o,options||{});



	if($e.is(':text')){

		if(!$e.attr('title'))$e=null;

	}else{

		$e=$e.find(o.selector);

}

if($e){$e.each(function(){var $t=$(this);

if($.trim($t.val()).length==0){$t.val($t.attr('title'));

}

if($t.val()==$t.attr('title')){$t.addClass(o.blurClass);

}else{$t.removeClass(o.blurClass);

}

$t.focus(function(){if($.trim($t.val())==$t.attr('title')){$t.val('');

$t.removeClass(o.blurClass);

}}).blur(function(){var val=$.trim($t.val());

if(val.length==0||val==$t.attr('title')){$t.val($t.attr('title'));

$t.addClass(o.blurClass);

}});

$(this.form).submit(function(){if($.trim($t.val())==$t.attr('title'))$t.val('');

});

});

}}

function setInnerHtml(elem,val){document.getElementById(elem).value=val;

}

function transferHTML(target){var srcIFrame=document.getElementById('i'+target);

var srcContent=(srcIFrame.contentDocument)?srcIFrame.contentDocument.getElementsByTagName("BODY")[0].innerHTML:(srcIFrame.contentWindow)?srcIFrame.contentWindow.document.body.innerHTML:"";

document.getElementById(target).innerHTML=srcContent;

}

function isNotNullOrEmptyString(fieldName,message){if(isNullOrEmpty(document.getElementById(fieldName).value)){alert(message);

return false;

}

return true;

}

function isNullOrEmpty(inputStr){if(isEmpty(inputStr)||inputStr=="null"){return true;

}

return false;

}

function isEmpty(inputStr){if(inputStr==null||inputStr==""){return true;

}

return false;

}

function checkPasswordFields(field1,field2,msg){if(isNullOrEmpty(document.getElementById(field1).value)){document.getElementById(field1).value="";

document.getElementById(field2).value="";

alert(msg);

return false;

}else if(isNullOrEmpty(document.getElementById(field2).value)){document.getElementById(field1).value="";

document.getElementById(field2).value="";

alert(msg);

return false;

}else if(document.getElementById(field1).value!=document.getElementById(field2).value){document.getElementById(field1).value="";

document.getElementById(field2).value="";

alert(msg);

return false;

}

return true;

}

function setChangedPassword(field1,field2,field3,msg){if(isNullOrEmpty(document.getElementById(field1).value)&&isNullOrEmpty(document.getElementById(field2).value)){return true;

}else{if(checkPasswordFields(field1,field2,msg)){document.getElementById(field3).value=document.getElementById(field1).value;

return true;

}else{return false;

}}}

function setStatus(fieldName,value){document.getElementById(fieldName).value=value;

if(value=="Active"){document.getElementById('isactive').value='Y';

}else{document.getElementById('isactive').value='N';

}}

function showHideLayer(formDiv)

{if(document.getElementById(formDiv).style.display=='block'){$('#'+formDiv).slideUp('fast');

document.getElementById(formDiv).style.display='none';

}

else

{$('#'+formDiv).slideDown('fast');

document.getElementById(formDiv).style.display='block';

}}

function validateEmail(fieldValue){var invalidChars=" /:,;";

var emailAddress=fieldValue;

var atPosition=emailAddress.indexOf("@",1);

var periodPosition=emailAddress.indexOf(".",atPosition);

for(var i=0;

i<invalidChars.length;

i++){badChar=invalidChars.charAt(i);

if(emailAddress.indexOf(badChar,0)>-1){return false;

}}

if(atPosition==-1){return false;

}

if(emailAddress.indexOf("@",atPosition+1)>-1){return false;

}

if(periodPosition==-1){return false;

}

if((periodPosition+3)>emailAddress.length){return false;

}

return true;

}

function isValidEmail(fieldname,msg){if(!validateEmail(document.getElementById(fieldname).value)){alert(msg);

return false;

}

return true;

}

function validateEmailAddressList(emailAddressList,message){var pos=0;

var i=0;

var origin=0;

originalString="";

originalString=stringReplace(document.getElementById(emailAddressList).value," ","");

if(originalString==""){return true;

}else{pos=originalString.indexOf(',');

while(pos!=-1){preString=originalString.substring(0,pos);

emailAddress=originalString.substring(origin,pos);

if(validateEmailAddress(emailAddress,message)){origin=pos+1;

postString=originalString.substring(pos+1,originalString.length);

originalString=preString+' '+postString;

pos=originalString.indexOf(',');

i++}

else{return false;

}}

emailAddress=originalString.substring(origin,originalString.length);

return validateEmailAddress(emailAddress,message);

}}

function validateEmailAddress(inputValue,message){var invalidChars=" /:,;";

var emailAddress=inputValue;

var atPosition=emailAddress.indexOf("@",1);

var periodPosition=emailAddress.indexOf(".",atPosition);

for(var i=0;

i<invalidChars.length;

i++){badChar=invalidChars.charAt(i);

if(emailAddress.indexOf(badChar,0)>-1){alert(message);

return false;

}}

if(atPosition==-1){alert(message);

return false;

}

if(emailAddress.indexOf("@",atPosition+1)>-1){alert(message);

return false;

}

if(periodPosition==-1){alert(message);

return false;

}

if((periodPosition+3)>emailAddress.length){alert(message);

return false;

}

return true;

}

function stringReplace(originalString,findText,replaceText){var pos=0;

pos=originalString.indexOf(findText);

while(pos!=-1){preString=originalString.substring(0,pos);

postString=originalString.substring(pos+1,originalString.length);

originalString=preString+replaceText+postString;

pos=originalString.indexOf(findText);

}

return originalString;

}

function checkBoxSelected(msg){count=0;

for(var i=0;

i<document.forms[0].elements.length;

i++){if(document.forms[0].elements[i].checked){count++;

}}

if(count==0){return false;

}

return true;

}

function checkForInvalidCharacters(inputValue,message){var invalidChars="/:,;'";

var string=document.getElementById(inputValue).value;

for(var i=0;

i<invalidChars.length;

i++){badChar=invalidChars.charAt(i);

if(string.indexOf(badChar,0)>-1){alert(message);

return false;

}}

return true;

}

function isNonNegativeNumber(fieldName,message){if(isNumber(document.getElementById(fieldName).value)){return true;

}

alert(message);

document.getElementById(fieldName).value="";

return false;

}

function isNumber(inputVal){oneDecimal=false;

inputStr=inputVal.toString();

for(var i=0;

i<inputStr.length;

i++){var oneChar=inputStr.charAt(i);

if(i==0&&oneChar=="+"){continue;

}

if(oneChar=="."&&!oneDecimal){oneDecimal=true;

continue;

}

if(oneChar<"0"||oneChar>"9"){return false;

}}

return true;

}

function isPosInteger(fieldName,message){inputStr=document.getElementById(fieldName).value;

for(var i=0;

i<inputStr.length;

i++){var oneChar=inputStr.charAt(i);

if(oneChar<"0"||oneChar>"9"){document.getElementById(fieldName).value="";

alert(message);

return false;

}}

return true;

}

function isPercentage(fieldName,message){var percentage=document.getElementById(fieldName).value;

if(percentage>100){document.getElementById(fieldName).value="";

alert(message);

return false;

}

if(percentage==0){document.getElementById(fieldName).value="";

alert(message);

return false;

}

return true;

}

function enableTextFieldFromCheckbox(checkbox,textfield){if(document.getElementById(checkbox).checked==true){document.getElementById(textfield).disabled=false;

document.getElementById(textfield).className="";

}else{document.getElementById(textfield).disabled=true;

document.getElementById(textfield).className="disabledfield";

document.getElementById(textfield).value="";

}}

function comparePasswords(firstPassword,secondPassword,message){if(document.getElementById(firstPassword).value!=document.getElementById(secondPassword).value){alert(message);

document.getElementById(firstPassword).value="";

document.getElementById(secondPassword).value="";

return false;

}

return true;

}

function deleteEntity(url,entity,name){message="Are you sure you want to delete "+entity+": '"+name+"'? \n"+"Press OK to delete the "+entity+"\n"+"Cancel to stay on the current page";

if(window.confirm(message)){window.location.href=url;

}}

function confirmDeleteEntity(url,message){if(window.confirm(message)){window.location.href=url;

}}

function asynchDelete(url,message,elementToRemove){

	if(window.confirm(message)){	

		var tempelementToRemoveData = document.getElementById(elementToRemove).innerHTML;

		document.getElementById(elementToRemove).innerHTML = "<img src='"+getBaseURL()+"images/loading.gif'>";	

		$.ajax({

		   type: "GET",

		   url: url,

		   //data: $("#mark-sheet-form").serialize(), // serializes the form's elements.

		   success: function(data)

		   {

			   $('#'+elementToRemove).fadeOut('slow', function(){

				   var rowCtr = 0;

				   $('#'+elementToRemove).remove();

				   $('.listrow').each(function(){

					   		if(rowCtr%2 != 0){

								if(!$(this).hasClass('grey_list_row')) 

									$(this).addClass('grey_list_row');

							}else{

								$(this).removeClass('grey_list_row');

							}

							rowCtr++;

					   });

				});

		   },

		   error:function (XHR, status, response) {

				alert(response);

				document.getElementById(elementToRemove).innerHTML = tempelementToRemoveData;

			  }

		 });		

	}

}



function promptIfValueIsSet(url,message,confirmField){if(document.getElementById(confirmField).value!='')

{if(window.confirm(message)){window.location.href=url;

}}

else

{window.location.href=url;

}}

function UpdateHiddenField(){var physical_path=document.getElementById("file").value;

document.getElementById("physical_filename").value=physical_path;

}

function isPositiveNumber(fieldName,message){var fieldvalue=document.getElementById(fieldName).value;

if(isNumber(fieldvalue)&&fieldvalue>=0){return true;

}

alert(message);

return false;

}

function isAnyCheckboxSelected(checkboxarray,message,limit){var i=0;

while(i<limit){if(document.all(checkboxarray,i).checked==true){return true;

}

i++;

}

alert(message);

return false;

}

function isEmptyOrPositive(fieldName,message){if(isEmpty(document.getElementById(fieldName).value)){return true;

}else{return isPositiveNumber(fieldName,message);

}}

function openPopupListWindow(fileName){features="width=750,height=500,left=100,top=75,resizable=1, scrollbars=1";

listwindow=window.open(fileName,"listWin",features);

listwindow.focus();

}

function openPopup(fileName){features="width=750,height=500,left=100,top=75,resizable=1, scrollbars=1";

listwindow=window.open(fileName,"listWin",features);

listwindow.focus();

}

function setResultsUrl(url){var parameter=document.getElementById('parameter').value;

parent.document.location=url+"parameter="+parameter;

}

function setYearAndMonthToAll(){document.getElementById("month").value="";

document.getElementById("year").value="";

document.getElementById("submitform").click();

}

function setIsActiveStatus(fieldName){if(document.getElementById(fieldName+"_checkbox").checked){document.getElementById(fieldName).value="Y";

}else{document.getElementById(fieldName).value="N";

}}

function showLayer(name){var layers=document.getElementsByName(name);

for(var i=0;

i<layers.length;

i++){layers[i].style.visibility="inherit";

}}

function hideLayer(name){var layers=document.getElementsByName(name);

for(var i=0;

i<layers.length;

i++){layers[i].style.visibility="hidden";

}}

function validateDateFields(firstField,secondField,message){var firstdatearray=new Array();

var seconddatearray=new Array();

if(firstField!='birthdate'){firstdatestring=document.getElementById(firstField).value;

}else{firstdatestring=document.getElementById("birthdate_m").value+"/"+document.getElementById("birthdate_d").value+"/"+document.getElementById("birthdate_y").value;

}

var seconddatestring=document.getElementById(secondField).value;

if(firstdatestring!=""&&seconddatestring!=""){firstdatearray=firstdatestring.split("/");

seconddatearray=seconddatestring.split("/");

var firstdate=new Date(firstdatearray[2],firstdatearray[0]-1,firstdatearray[1]);

var seconddate=new Date(seconddatearray[2],seconddatearray[0]-1,seconddatearray[1]);

var difference=seconddate.getTime()-firstdate.getTime();

if(difference<0){alert(message);

return false;

}}

return true;

}

function validatemultiplemailids(fieldname)

{var sendmailIDs=document.getElementById(fieldname).value;

if(sendmailIDs!="")

{var sendmailIDs_arr=sendmailIDs.split(",");

var totalIds=sendmailIDs_arr.length;

for(k=0;

k<totalIds;

k++)

{if(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(trim(sendmailIDs_arr[k])))

{}

else

{alert("Please enter a Valid Email Address for Approver Mails on Human Resource tab");

return false;

}}}

return true;

}

function openPopupListWindow(fileName,width,height){features="width="+width+",height="+height+",left=100,top=75,resizable=1, scrollbars=1";

listwindow=window.open(fileName,"listWin",features);

listwindow.focus();

}

function enableField(fieldName){document.getElementById(fieldName).disabled=false;

document.getElementById(fieldName).className="";

}

function disableField(fieldName){document.getElementById(fieldName).disabled=true;

document.getElementById(fieldName).checked="";

document.getElementById(fieldName).className="disabledfield";

}

function validateCompany(fieldName,msg){var company=document.getElementById(fieldName).value;

if(document.getElementById(fieldName).value==0){alert(msg);

return false;

}

return true;

}

function checkEnabledSubCategory(fieldName,msg){if(document.getElementById(fieldName).disabled==false){if(isNullOrEmpty(document.getElementById(fieldName).value)){alert(msg);

return false;

}}

return true;

}

function checkForAddedElement(elementArray,message){loadArray(elementArray);

if(checkedRows.length==0){alert(message);

return false}

return true;

}

function checkForAddedTasks(elementname,message){for(var i=1;

i<10;

i++){if(document.getElementById(elementname+i).value==""){alert(message);

alert(elementname+i);

alert(i);

return true}

return false;

}}

function isValidFileType(field,message){var filename=document.getElementById(field).value;

if(!isNullOrEmpty(filename)){var validfiletypes=new Array("sql","txt","SQL","TXT");

var extension=filename.substring(filename.length-3,filename.length)

for(var i=0;

i<validfiletypes.length;

i++){if(extension==validfiletypes[i]){return true;

}}

alert(message);

return false;

}}

function isValidUploadFileType(field,message){var filename=document.getElementById(field).value;

if(isNullOrEmpty(filename)){return true;

}else{var validfiletypes=new Array("doc","txt","pdf","xls","rar","zip","rtf","docx","DOC","TXT","PDF","XLS","RAR","ZIP","RTF","DOCX");

var extension=filename.substring(filename.length-3,filename.length)

for(var i=0;

i<validfiletypes.length;

i++){if(extension==validfiletypes[i]){return true;

}}

alert(message);

return false;

}}

function updateFormFromHiddenDivElements(fieldName){HIDDEN_DIV_ELEMENT_PREFIX="h_";

var children=document.getElementById(fieldName).getElementsByTagName('*');

for(i=0;

i<children.length;

i++){var elem=children[i];

if(document.getElementById(getEnd(elem.name,HIDDEN_DIV_ELEMENT_PREFIX))!=null){document.getElementById(getEnd(elem.name,HIDDEN_DIV_ELEMENT_PREFIX)).value=elem.value;

}}}

function getEnd(mainStr,searchStr){foundOffset=mainStr.indexOf(searchStr)

if(foundOffset==-1){return null}

return mainStr.substring(foundOffset+searchStr.length,mainStr.length)}

function checkDisabledField(fieldName,message){if(document.getElementById(fieldName).disabled){return true;

}else{return isNotNullOrEmptyString(fieldName,message);

}}

function checkDisabledFieldWithNumber(fieldName,message){if(document.getElementById(fieldName).disabled){return true;

}else{return isNotNullOrEmptyString(fieldName,message)&&isNonNegativeNumber(fieldName,'Please enter a valid number for '+fieldName);

}}

function getMonthName(month){switch(month){case'1':return'January';

break;

case'2':return'February';

break;

case'3':return'March';

break;

case'4':return'April';

break;

case'5':return'May';

break;

case'6':return'June';

break;

case'7':return'July';

break;

case'8':return'August';

break;

case'9':return'September';

break;

case'10':return'October';

break;

case'11':return'November';

break;

case'12':return'December';

break;

}}

function showContentOrUploadDiv(fieldName){var option=document.getElementById(fieldName).value;

if(option=='N'){document.getElementById('content_div').style.visibility='visible';

document.getElementById('upload_div').style.visibility='hidden';

document.getElementById('originalname').value="";

}else if(option=='Y'){document.getElementById('upload_div').style.visibility='visible';

document.getElementById('content_div').style.visibility='hidden';

document.getElementById('format').value="";

document.getElementById('FCKeditor1').value="";

}}

function isValidFileTypeForUpload(field,message){var filename=document.getElementById(field).value;

if(!isNullOrEmpty(filename)){var validfiletypes=new Array("zip","ZIP","txt","TXT",'xls','XLS','pdf','PDF','doc','DOC');

var extension=filename.substring(filename.length-3,filename.length)

for(var i=0;

i<validfiletypes.length;

i++){if(extension==validfiletypes[i]){return true;

}}

alert(message);

return false;

}

return true;

}

function showTbody(fieldname){var e=document.getElementById(fieldname);

if(e!=null){e.style.display="";

}}

function hideTbody(fieldname){var e=document.getElementById(fieldname);

if(e!=null){e.style.display="none";

}}

function validateCheckedElement(fieldName,message){var checkboxes=document.getElementsByName(fieldName);

var checked=false;

for(i=0;

i<checkboxes.length;

i++){if(checkboxes[i].checked){checked=true;

}}

if(!checked){alert(message);

}

return checked;

}

function clickButton(buttonName){document.getElementById(buttonName).click();

}

function loadnext(currentpage,nextpage){if(!(nextpage<currentpage)){if(!validateWizardPages(currentpage,nextpage)){return false;

}}

$("."+currentpage).hide();

$("."+nextpage).fadeIn("fast");

$("#info_"+currentpage).removeClass('current');

$("#info_"+nextpage).addClass('current');

if(nextpage<currentpage){$("#info_"+nextpage).removeClass('lastDone');

$("#info_"+(nextpage-1)).removeClass('done').addClass('lastDone');

return false;

}

$("#info_"+currentpage).addClass('lastDone');

$("#info_"+(currentpage-1)).removeClass('current').removeClass('lastDone').addClass('done');

processWizardPages(currentpage,nextpage);

}

function redirection(page,form_name)

{document.forms[form_name].action=page;

document.forms[form_name].submit();

return false;

}

function showHideSlowLayer(url){http.open("POST",url,true);

http.onreadystatechange=handleHttpResponse;

http.send(null);

}

function getHTTPObject(){var xmlhttp;

if(!xmlhttp&&typeof XMLHttpRequest!='undefined'){try{xmlhttp=new XMLHttpRequest();

}catch(e){xmlhttp=false;

}}

return xmlhttp;

}

function handleHttpResponse(callback){

	if(http.readyState==4){

		results=http.responseText;

		document.getElementById(document.getElementById("layerid").value).innerHTML=results;

	}else{	

		document.getElementById(document.getElementById("layerid").value).innerHTML="<img src='"+getBaseURL()+"images/loading.gif'>";

	}

	return true;

}



function hasClass(ele,cls){return document.getElementById(ele).className.match(new RegExp('(\\s|^)'+cls+'(\\s|$)'));

}

function removeClass(ele,cls){if(hasClass(ele,cls)){var reg=new RegExp('(\\s|^)'+cls+'(\\s|$)');

document.getElementById(ele).className=document.getElementById(ele).className.replace(reg,' ');

}}



function checkEmpty(fieldName,message){

	if(isNullOrEmpty(document.getElementById(fieldName).value)&&message!=''){

		sysAlert(message);

		document.getElementById(fieldName).classList.add('fielderror');

		return false;

	}else{

		removeClass(fieldName,'fielderror')

		return true;

	}

}



function checkEmpty_basic(fieldName,message){if(isNullOrEmpty(document.getElementById(fieldName).value)){alert(message);

return false;

}

return true;

}

function updateDropDownDiv(selectedDropDown,dropDownName,dropDownDiv,serverPage,errorMsg){var selectedValue=document.getElementById(selectedDropDown).value;

document.getElementById("layerid").value=dropDownDiv;

if(selectedValue!=""){serverPage+="/ndrop_"+dropDownName+"/value_"+selectedValue;

showHideSlowLayer(serverPage);

}else{alert(errorMsg);

}}



function updateFieldLayer(serverPage,fieldNameArrStr,layerShown,displayLayer,errorMsg){

	if(fieldNameArrStr.length>0){

		var fieldNameArr=fieldNameArrStr.split("<>");

	}else{

		var fieldNameArr=Array();

	}



	var serverPageStr=serverPage;

	

	if(layerShown!=""&&layerShown.charAt(0)!="*"){

		var shownLayerObj=document.getElementById(layerShown);

	}

	

	if(displayLayer!="" && displayLayer.charAt(0)!="*" && displayLayer!="_" && displayLayer!="-"){

		var displayLayerObj = document.getElementById(displayLayer);

	}

	

	var allIn="";



	if(fieldNameArrStr!='' && fieldNameArr.length>0)

	{

		for(var i=0;i<fieldNameArr.length;i++){

			if(fieldNameArr[i].charAt(0)!="*"){

				if(!checkEmpty(fieldNameArr[i],errorMsg)){

					allIn="NO";

					break;

				}else{

					if(trimString(document.getElementById(fieldNameArr[i]).value)==''){

						var fieldValue='_';

					}else{

						var fieldValue=replaceBadChars(document.getElementById(fieldNameArr[i]).value);

					}

					

					serverPageStr += "/"+fieldNameArr[i]+"/"+fieldValue;

				}

			

			}else{

				var fieldName=fieldNameArr[i].substr(1,fieldNameArr[i].length);

				

				if(trimString(document.getElementById(fieldName).value)==''){

					var fieldValue='_';

				

				}else{

					var fieldValue=replaceBadChars(document.getElementById(fieldName).value);

				}

				

				serverPageStr+="/"+fieldName+"/"+fieldValue;

			}

		}

	}

	

	if(allIn==""){

		if(layerShown!=""){

			if(layerShown.charAt(0)=="*"){

				shownLayerObj=document.getElementById(substr(1,layerShown.length));

				shownLayerObj.style.visibility="hidden";

				shownLayerObj.style.height=0;



			}else{

				shownLayerObj.style.visibility="hidden";

				shownLayerObj.style.height=0;

			}

		}

		

		if(displayLayer!="" && displayLayer!="_" && displayLayer!="-"){

			if(displayLayer.charAt(0)!="*"){

				displayLayerObj.style.visibility="hidden";

				displayLayerObj.style.height=0;

			}

			

			showFormLayer(serverPageStr,displayLayer);

		

		}else{

			if(displayLayer=="_")

				openWindow(serverPageStr);



			else if(displayLayer=="-"){

				window.top.location.href=serverPageStr;

		

			}else{

				document.location.href=serverPageStr;

			}

		}

	}

}



function replaceBadChars(formString){var badChars=Array("'","\"","\\","(",")","/","<",">","!","#","@","%","&","?","$",",",";",":"," ");

var replaceChars=Array("_QUOTE_","_DOUBLEQUOTE_","_BACKSLASH_","_OPENPARENTHESIS_","_CLOSEPARENTHESIS_","_FORWARDSLASH_","_OPENCODE_","_CLOSECODE_","_EXCLAMATION_","_HASH_","_EACH_","_PERCENT_","_AND_","_QUESTION_","_DOLLAR_","_COMMA_","_SEMICOLON_","_FULLCOLON_","_SPACE_");

var newString='';

for(var i=0;

i<badChars.length;

i++){newString=replaceAllStr(formString,badChars[i],replaceChars[i]);

formString=newString;

}

return newString;

}



function showFormLayer(serverPage,object){var obj=document.getElementById(object);

document.getElementById("layerid").value=object;

if(obj.style.visibility=="hidden"||obj.style.display=="none"){obj.style.visibility="visible";

obj.style.height="";

obj.style.display="block";

if(serverPage!=''){showHideSlowLayer(serverPage);

}}else{obj.style.visibility="hidden";

obj.style.height=0;

obj.style.display="none";

}}

function hideDiv(divID){var divObj=document.getElementById(divID);

divObj.innerHTML="";

divObj.style.visibility="hidden";

divObj.style.display="none";

divObj.style.height=0;

}

function printDiv(divId){var DocumentContainer=document.getElementById(divId);

var WindowObject=window.open('',"PrintWindow","width=600,height=500,top=50,left=50,toolbars=no,scrollbars=yes,status=no,resizable=yes");

WindowObject.document.writeln(DocumentContainer.innerHTML);

WindowObject.document.close();

WindowObject.focus();

WindowObject.print();

WindowObject.close();

}

function openWindow(fileName){features="width=600,height=450,left=100,top=130,resizable=1, scrollbars=1";

listwindow=window.open(fileName,"newWin",features);

listwindow.focus();

}

function closeAndRefresh(parentUrl){window.opener.location.href=parentUrl;

window.close();

}

function absHideDiv(divID){var dd=document.getElementById(divID);

dd.style.display="none";

}

function absShowDiv(divID){var dd=document.getElementById(divID);

dd.style.display="block";

}

function showLoadingBtnDiv(showDiv,hideDiv){absShowDiv(showDiv);

absHideDiv(hideDiv);

return true;

}

function isValidEmailMany(fieldname,msg){var allEmails=document.getElementById(fieldname).value;

var decision=true;

if(trimString(allEmails)!=''){var allEmailArray=allEmails.split(',');

for(var i=0;

i<allEmailArray.length;

i++){if(!validateEmail(trimString(allEmailArray[i]))){decision=false;

break;

}}}

if(!decision){alert(msg);

}

return decision;

}

function trimString(sInString){sInString=sInString.replace(/^\s+/g,"");

return sInString.replace(/\s+$/g,"");

}

function openEmailWindow(serverPage,fieldNameArrStr,errorMsg){var fieldNameArr=fieldNameArrStr.split("<>");

var selectedIds=new Array();

var scount=0;

for(var i=0;

i<fieldNameArr.length;

i++){if(document.getElementById(fieldNameArr[i]).checked){selectedIds[scount]=document.getElementById(fieldNameArr[i]).value;

scount++;

}}

if(selectedIds.length>0){var field_ids=selectedIds.join('-');

openPopup(serverPage+'/i_'+field_ids);

}else{alert(errorMsg);

}}

function clearInitialValue(fieldName,initialValue){if(document.getElementById(fieldName).value==initialValue){document.getElementById(fieldName).value='';

}else if(document.getElementById(fieldName).value==''){document.getElementById(fieldName).value=initialValue;

}}

function clearOnActionCheck(theField,otherFieldID,otherDefaultValue){if(theField.checked){document.getElementById(otherFieldID).value=otherDefaultValue;

}}

function clearOnActionForGroup(otherFieldIDs){var fieldIDArr=otherFieldIDs.split(",");

for(var i=0;

i<fieldIDArr.length;

i++){document.getElementById(fieldIDArr[i]).checked=false;

}}

function isValidTOEmails(toEmailField,groupIdentifier,defaultFieldvalue){if(document.getElementById(toEmailField).value!=''&&document.getElementById(toEmailField).value!=defaultFieldvalue){return isValidEmailMany(toEmailField,'Please enter all email addresses in a valid format.');

}else{var inputs=document.getElementsByTagName("input");

for(var i=0;

i<inputs.length;

i++){if(inputs[i].type=="checkbox"){if(inputs[i].checked){return true;

break;

}}}}

alert('Please select an email group or enter the emails to send to.');

return false;

}

function isValidSelectEmails(toSelectIdentifier,errorMSG){var inputs=document.getElementsByTagName("input");

for(var i=0;

i<inputs.length;

i++){if(inputs[i].type=="checkbox"){if(inputs[i].checked){return true;

break;

}}}

alert(errorMSG);

return false;

}

function passSelectToHidden(selectField,hiddenField){var selField=document.getElementById(selectField);

document.getElementById(hiddenField).value=selField.options[selField.selectedIndex].value;

}

function passSCheckToHidden(checkField,hiddenField){var checkFieldObj=document.getElementById(checkField);

if(checkFieldObj.checked){document.getElementById(hiddenField).value='Y';

}else{document.getElementById(hiddenField).value='N';

}}

function showActionDivs(serverPage,elemString,sitecode,action,errorMsg){var elemIDArr=elemString.split("<>");

var viewDivIds=new Array();

var editDivIds=new Array();

var realElemIds=new Array();

for(var i=0;

i<elemIDArr.length;

i++){viewDivIds[i]=elemIDArr[i]+'_'+sitecode+'_v';

editDivIds[i]=elemIDArr[i]+'_'+sitecode;

realElemIds[i]=elemIDArr[i]+'_value_'+sitecode;

if(action=='edit'){document.getElementById(viewDivIds[i]).style.display="none";

document.getElementById(editDivIds[i]).style.display='block';

}}

if(action=='save'){document.getElementById('action_'+sitecode+'_v').style.display='block';

document.getElementById('action_'+sitecode+'_v').style.visibility="hidden";

updateFieldLayer(serverPage,realElemIds.join('<>'),'action_'+sitecode,'action_'+sitecode+'_v',errorMsg);

}}

function AssignPosition(d,h){d.style.top=h+"px";

}

function HideContent(d){document.getElementById(d).style.display="none";

document.getElementById(d).style.visiblity="hidden";

}

function AssignHiddenContent(d,h){if(d.length<1){return;

}

var dd=document.getElementById(d);

if(h!=''){AssignPosition(dd,h);

}}

function ShowContent(d,h){if(d.length<1){return;

}

var dd=document.getElementById(d);

if(h!=''){AssignPosition(dd,h);

}

dd.style.display="block";

dd.style.visiblity="visible";

}

function showPageContent(d,h,url){if(d.length>1){var dd=document.getElementById(d);

if(h!=''){AssignPosition(dd,h);

}

dd.style.display="block";

dd.style.visiblity="visible";

document.getElementById("layerid").value=d;

if(url!=''){showHideSlowLayer(url);

}}}

function ReverseContentDisplay(d){if(d.length<1){return;

}

var dd=document.getElementById(d);

AssignPosition(dd);

if(dd.style.display=="none"){dd.style.visiblity="visible";

dd.style.display="block";

}else{dd.style.visiblity="hidden";

dd.style.display="none";

}}

function proceedOnChecked(fieldToFill,divToHide,divToShow,errorMSG,submitDiv){if(document.getElementById(fieldToFill).value!=''){HideContent(divToHide);

ShowContent(divToShow,'');

if(submitDiv!=''){ShowContent(submitDiv,'');

}}else{alert(errorMSG);

}}

function getItemPos(anchorFieldID,dimensionRequired,offsetValue){var fieldObj=document.getElementById(anchorFieldID);

var curleft=0;

var curtop=0;

var actualtop=0;

var actualleft=0;

if(fieldObj.offsetParent){do{curleft+=fieldObj.offsetLeft;

curtop+=fieldObj.offsetTop;

}while(fieldObj=fieldObj.offsetParent);

}

if(dimensionRequired=='fromtop'){actualtop=curtop-offsetValue;

return actualtop;

}else if(dimensionRequired=='fromleft'){actualleft=curleft-offsetValue;

return actualleft;

}}

function minimizeMaximize(minimizeDiv,maximizeDiv,textDiv,imgDiv,baseImgUrl){if(minimizeDiv!=''){document.getElementById(minimizeDiv).style.display='none';

document.getElementById(textDiv).innerHTML="<a href=\"javascript:minimizeMaximize('', '"+minimizeDiv+"', '"+textDiv+"', '"+imgDiv+"', '"+baseImgUrl+"')\" class='whiteverysmalltxt'>View More</a>";

document.getElementById(imgDiv).innerHTML="<a href=\"javascript:minimizeMaximize('', '"+minimizeDiv+"', '"+textDiv+"', '"+imgDiv+"', '"+baseImgUrl+"')\"><img src='"+baseImgUrl+"maximize.png' border='0' /></a>";

}else if(maximizeDiv!=''){document.getElementById(maximizeDiv).style.display='block';

document.getElementById(textDiv).innerHTML="<a href=\"javascript:minimizeMaximize('"+maximizeDiv+"', '', '"+textDiv+"', '"+imgDiv+"', '"+baseImgUrl+"')\" class='whiteverysmalltxt'>View Less</a>";

document.getElementById(imgDiv).innerHTML="<a href=\"javascript:minimizeMaximize('"+maximizeDiv+"', '', '"+textDiv+"', '"+imgDiv+"', '"+baseImgUrl+"')\"><img src='"+baseImgUrl+"minimize.png' border='0' /></a>";

}}

function inArray(haystack,needle,returnType){$bool=false;

$pos='';

for(var i=0;

i<haystack.length;

i++){if(haystack[i]==needle){$bool=true;

$pos=i;

};

}

if(returnType=='bool'){return $bool;

}else{return $pos;

}}

function startInstantSearch(searchFieldName,searchByFieldName,actionURL){

	var phrase=replaceBadChars(document.getElementById(searchFieldName).value);

	var searchby=document.getElementById(searchByFieldName).value;

	var extraURL="";

	var urlArray=actionURL.split('/');



	if(inArray(urlArray,'layer','bool')){

		document.getElementById('layerid').value=urlArray[inArray(urlArray,'layer','pos')+1];

var layerID=document.getElementById('layerid').value;

}

if(inArray(urlArray,'extrafields','bool')){var extraFieldsString=urlArray[inArray(urlArray,'extrafields','pos')+1];

var extraFieldsArray=extraFieldsString.split('__');

for(var i=0;

i<extraFieldsArray.length;

i++){extraURL+="/"+extraFieldsArray[i]+"/"+document.getElementById(extraFieldsArray[i]).value;

}}

if(searchby.length>0){if(phrase.length>0){var serverPageStr=actionURL+"/searchfield/"+searchby+"/phrase/"+phrase+extraURL;

document.getElementById(layerID).style.visibility='';

showHideSlowLayer(serverPageStr);

}}else{sysAlert('Please select a field to search by');

}}

function handleEnter(field,event){var keyCode=event.keyCode?event.keyCode:event.which?event.which:event.charCode;

if(keyCode==13){var i;

for(i=0;

i<field.form.elements.length;

i++)

if(field==field.form.elements[i])

break;

i=(i+1)%field.form.elements.length;

field.form.elements[i].focus();

return false;

}

else

return true;

}

function handleEnterButton(field,event,buttonID){var keyCode=event.keyCode?event.keyCode:event.which?event.which:event.charCode;

if(keyCode==13){document.getElementById(buttonID).click();

}

else

return true;

}

function restoreBadChars(formString){var badChars=Array("'","\"","\\","(",")","/","<",">","!","#","@","%","&","?","$",",",";",":"," ");

var replaceChars=Array("_QUOTE_","_DOUBLEQUOTE_","_BACKSLASH_","_OPENPARENTHESIS_","_CLOSEPARENTHESIS_","_FORWARDSLASH_","_OPENCODE_","_CLOSECODE_","_EXCLAMATION_","_HASH_","_EACH_","_PERCENT_","_AND_","_QUESTION_","_DOLLAR_","_COMMA_","_SEMICOLON_","_FULLCOLON_","_SPACE_");

var newString='';

for(var i=0;

i<replaceChars.length;

i++){newString=replaceAllStr(formString,replaceChars[i],badChars[i]);

formString=newString;

}

return newString;

}

function replaceAllStr(strText,strTarget,strSubString){var intIndexOfMatch=strText.indexOf(strTarget);

while(intIndexOfMatch!=-1){strText=strText.replace(strTarget,strSubString)

intIndexOfMatch=strText.indexOf(strTarget);

}

return(strText);

}

function confirmSearchAndActivateLogin(searchField,searchFieldValue,valueField,valueFieldValue,btnDiv,searchDiv,imageURL){document.getElementById(searchField).value=searchFieldValue;

document.getElementById(valueField).value=valueFieldValue;

if(btnDiv!=''){document.getElementById(btnDiv).innerHTML="<table border='0' cellspacing='0' cellpadding='8' style='background-color:#FFFFFF;border: 1px solid #2E8D8E;'>"+"<tr>"+"<td style='padding-bottom:0px'><b>"+searchFieldValue+"</b></td>"+"</tr>"+"<tr>"+"<td align='center'><img src='"+imageURL+"'/></td>"+"</tr>"+"</table>";

}

document.getElementById(searchDiv).innerHTML='&nbsp;';

}

function showDivWithImage(searchFieldValue,imageDiv,imageURL){document.getElementById(imageDiv).innerHTML="<table border='0' cellspacing='0' cellpadding='8' style='background-color: #FFFFFF;'>"+"<tr>"+"<td style='padding-bottom:0px'><b>"+searchFieldValue+"</b></td>"+"</tr>"+"<tr>"+"<td align='center'><img src='"+imageURL+"'/></td>"+"</tr>"+"</table>";

}

function passFormValue(passingField,receivingField,fieldType){var passingObj=document.getElementById(passingField);

if(fieldType=="radio"||fieldType=="checkbox"){if(passingObj.checked){document.getElementById(receivingField).value=passingObj.value;

}else{document.getElementById(receivingField).value='';

}}else{document.getElementById(receivingField).value=passingObj.value;

}}

function reportCheckedBox(passingField,receivingField)

{var passingObj=document.getElementById(passingField);

if(passingObj.checked)

{document.getElementById(receivingField).value='Y';

}

else

{document.getElementById(receivingField).value='N';

}}

function selectCheckBoxList(checkboxID,checkBoxList,stubStr){var elemIDArr=checkBoxList.split(",");

if(document.getElementById(checkboxID).checked){for(var i=0;

i<elemIDArr.length;

i++){document.getElementById(stubStr+elemIDArr[i]).checked=true;

}}

else

{for(var i=0;

i<elemIDArr.length;

i++){document.getElementById(stubStr+elemIDArr[i]).checked=false;

}}}

function handleEnterKey(btnToClick){if(event.keyCode=='13'){document.getElementById(btnToClick).click();

}}

function limitText(limitField,limitCount,limitNum){if(limitField.value.length>limitNum){limitField.value=limitField.value.substring(0,limitNum);

}else{limitCount.innerHTML=limitNum-limitField.value.length;

}}

function formatTime(formField)

{var theCount=0;

var theString=document.getElementById(formField).value;

var newString="";

var myString=theString;

var theLen=myString.length;

for(var i=0;

i<theLen;

i++)

{if((myString.charCodeAt(i)>=48)&&(myString.charCodeAt(i)<=57))

newString=newString+myString.charAt(i);

}

if(newString.length<5)

{var newLen=newString.length;

var newTime="";

var invalid="N";

for(var i=0;

i<newLen;

i++)

{if((i==0&&newString.charAt(i)>1)||(i==1&&parseInt(newString.substr(0,2))>12)||(i==3&&parseInt(newString.substr(2,2))>59)){invalid="Y";

break;

}

else

{if((i==1))

{newTime=newTime+newString.charAt(i)+":";

}else{newTime=newTime+newString.charAt(i);

}}}

if(invalid=='N'){document.getElementById(formField).value=newTime;

}

else

{document.getElementById(formField).value=myString.substr(0,(myString.length-1));

}}

else

{document.getElementById(formField).value=myString.substr(0,5);

}}

function formatTimeEntry(formField)

{var theCount=0;

var theString=document.getElementById(formField).value;

var newString="";

var myString=theString;

var theLen=myString.length;

for(var i=0;

i<theLen;

i++)

{if((myString.charCodeAt(i)>=48)&&(myString.charCodeAt(i)<=57))

newString=newString+myString.charAt(i);

}

if(newString.length<5)

{var newLen=newString.length;

var newTime="";

var invalid="N";

for(var i=0;

i<newLen;

i++)

{if((i==0&&newString.charAt(i)>5)||(i==1&&parseInt(newString.substr(0,2))>60)||(i==3&&parseInt(newString.substr(2,2))>59)){invalid="Y";

break;

}

else

{if((i==1))

{newTime=newTime+newString.charAt(i)+":";

}else{newTime=newTime+newString.charAt(i);

}}}

if(invalid=='N'){document.getElementById(formField).value=newTime;

}

else

{document.getElementById(formField).value=myString.substr(0,(myString.length-1));

}}

else

{document.getElementById(formField).value=myString.substr(0,5);

}}

function defaultFieldValue(fieldObj,defaultValue,reqAction){var fieldValue=fieldObj.value;

if(trimString(fieldValue)!=''){if(reqAction=='clear'&&fieldValue==defaultValue){fieldObj.value='';

fieldObj.style.color='#000000';

}else if(reqAction=='clearpassword'&&fieldValue==defaultValue){document.getElementById(fieldObj.id+'_cell').innerHTML="<input name='"+fieldObj.id+"' type='password' size='24' id='"+fieldObj.id+"' class='textfield' style='color:#000000;' value='' onfocus=\"defaultFieldValue(this, '"+defaultValue+"', 'clearpassword')\" onblur=\"defaultFieldValue(this, '"+defaultValue+"', 'restorepassword')\"  onkeypress=\"return handleEnterButton(this, event, 'login')\"/>";

setTimeout(function(){document.getElementById(fieldObj.id).focus();

},10);

}else{fieldObj.style.color='#000000';

}}else{if(reqAction=='restore'){fieldObj.value=defaultValue;

fieldObj.style.color='#CCCCCC';

}else if(reqAction=='restorepassword'){document.getElementById(fieldObj.id+'_cell').innerHTML="<input name='"+fieldObj.id+"' type='text' size='24' id='"+fieldObj.id+"' class='textfield' style='color:#CCCCCC' value='"+defaultValue+"' onfocus=\"defaultFieldValue(this, '"+defaultValue+"', 'clearpassword')\" onblur=\"defaultFieldValue(this, '"+defaultValue+"', 'restorepassword')\"/>";

}else{fieldObj.style.color='#000000';

}}}

function addRow(tableID){var table=document.getElementById(tableID);

var rowCount=table.rows.length;

var row=table.insertRow(rowCount);

if(tableID=='itemTable'){var cell1=row.insertCell(0);

cell1.innerHTML="<input type='checkbox' name='id[]' />";

var cell2=row.insertCell(1);

cell2.innerHTML="<input type='text' style='width: 400px' value='' class='textfield' name='items[]'>";

}else if(tableID=='imageTable'){var cell1=row.insertCell(0);

cell1.innerHTML="<input type='checkbox' name='id[]' />";

cell1.style.textAlign="right";

var cell2=row.insertCell(1);

cell2.innerHTML="<input type='text' name='images[]' id='images_"+(rowCount+1)+"' class='textfield' value='' style='width:400px;' onkeyup='showSearchLayers(\"searchresults_"+(rowCount+1)+"\", \"bottomspacer_"+(rowCount+1)+"\", \"images_"+(rowCount+1)+"\",\"Please specify the reference number of the image.\");startInstantSearch(\"images_"+(rowCount+1)+"\", \"searchby_"+(rowCount+1)+"\",\""+getBaseURL()+"wiki/load_results/type/image/layer/searchresults_"+(rowCount+1)+"/updatefield/images_"+(rowCount+1)+"/resultsdiv/searchresults_"+(rowCount+1)+"\");'><input type='hidden' name='imageid_"+(rowCount+1)+"' id='imageid_"+(rowCount+1)+"'><div id='searchresults_"+(rowCount+1)+"' style='position:absolute; width:400px;border: 1px solid #98CBFF;margin-top:-3px; margin-left:0px; background-color: #FFFFFF; display:none;'></div><div id='bottomspacer_"+(rowCount+1)+"' style='display:none;'><img src='"+getBaseURL+"spacer.gif' width='1' height='280'/></div><input name='searchby_"+(rowCount+1)+"' type='hidden' id='searchby_"+(rowCount+1)+"' value='referenceno' /><input name='layerid_"+(rowCount+1)+"' type='hidden' id='layerid_"+(rowCount+1)+"' value='searchresults_"+(rowCount+1)+"' />";

}else if(tableID=='selectTable'){var cell1=row.insertCell(0);

cell1.innerHTML="<input type='checkbox' name='id[]' />";

cell1.style.textAlign="right";

var cell2=row.insertCell(1);

cell2.innerHTML="<input type='text' style='width: 100px' value='' class='textfield' name='values[]'>";

var cell3=row.insertCell(2);

cell3.innerHTML="<input type='text' style='width: 100px' value='' class='textfield' name='displays[]'>";

var cell4=row.insertCell(3);

cell4.innerHTML="<input type='radio' name='isdefault' id='isdefault[]' value='isdefault[]'>";

}else if(tableID=='affiliationsTable'){var cell1=row.insertCell(0);

cell1.innerHTML="<input type='checkbox' name='affiliationid[]' />";

var cell2=row.insertCell(1);

cell2.innerHTML="<input type='text' class='textfield' style='width: 166px;' name='affiliationname[]' value=''>";

cell2.style.paddingRight="0px";

}else if(tableID=='insuranceTable'){var cell1=row.insertCell(0);

cell1.innerHTML="<input type='checkbox' name='insuranceid[]' />";

var cell2=row.insertCell(1);

cell2.innerHTML="<input type='text' class='textfield' style='width: 166px;' name='insurancename[]' value=''>";

cell2.style.paddingRight="0px";

}else if(tableID=='publicationTable'){var cell1=row.insertCell(0);

cell1.innerHTML="<input type='checkbox' name='publicationid[]' />";

cell1.style.paddingTop="10px";

cell1.style.borderBottom="1px solid #D5E1EE";

cell1.style.verticalAlign="top";

var cell2=row.insertCell(1);

cell2.innerHTML="<table>"+"<tr><td>Title:</td><td><input type='text' class='textfield' style='width: 130px;name='publicationname[]' value=''></td></tr>"+"<tr><td>Link:</td><td><input type='text' class='textfield' style='width: 130px;' name='publicationlink[]' value=''></td></tr>"+"<tr><td>Year:</td><td><input type='text' class='textfield' style='width: 35px;' name='publicationyear[]' value='' maxlength='4' onkeyup='numOnly(this)'></td></tr>"+"</table>";

cell2.style.paddingRight="0px";

cell2.style.borderBottom="1px solid #D5E1EE";

}}

function numOnly(obj)

{obj.value=obj.value.replace(/[^\d]/,'');

}

function deleteRow(tableID,errorMsg){try{var table=document.getElementById(tableID);

var rowCount=table.rows.length;

var selectCount=0;

for(var i=0;

i<rowCount;

i++){var row=table.rows[i];

var chkbox=row.cells[0].childNodes[0];

if(null!=chkbox&&true==chkbox.checked){table.deleteRow(i);

rowCount--;

i--;

selectCount++;

}}

if(selectCount==0){alert(errorMsg);

}}catch(e){alert(e);

}}

function addDynamicRow(tableID,dynamicURL)

{var table=document.getElementById(tableID);

var rowCount=table.rows.length;

var row=table.insertRow(rowCount);

var timestamp=new Date().getTime();

if(tableID=='languageTable'){var cell1=row.insertCell(0);

cell1.innerHTML="<input type='checkbox' name='languageid[]' />";

var cell2=row.insertCell(1);

var cell2LayerID=tableID+"_"+timestamp;

cell2.style.paddingRight="0px";

cell2.innerHTML="<div id='"+cell2LayerID+"'></div>";

updateFieldLayer(dynamicURL,'','',cell2LayerID,'');

}

else if(tableID=='excludedatesTable')

{var cell1=row.insertCell(0);

cell1.innerHTML="<input type='checkbox' name='dateid[]' />";

var cell2=row.insertCell(1);

var cell2LayerID=tableID+"_"+timestamp;

cell2.innerHTML="<div id='"+cell2LayerID+"'></div>";

updateFieldLayer(dynamicURL,'','',cell2LayerID,'');

}}

function showWithSelectValue(formURL,selectFieldId,answerTableDiv,listOfDivsToShow,errorMsg)

{var selectValue=document.getElementById(selectFieldId).value;

var divsToShow=listOfDivsToShow.split('<>');

if(selectValue!=''){updateFieldLayer(formURL+'/value/'+selectValue,'','',answerTableDiv,errorMsg);

for(var i=0;

i<divsToShow.length;

i++){document.getElementById(divsToShow[i]).style.display='block';

}}else{for(var i=0;

i<divsToShow.length;

i++){document.getElementById(divsToShow[i]).style.display='none';

}

alert(errorMsg);

}}

function selectAll(id)

{document.getElementById(id).focus();

document.getElementById(id).select();

}

function showZeroData(layerID)

{document.getElementById(layerID).innerHTML="<b style='color:#009933'>0.00</b>";

}

function clearVisibleDiv(id)

{document.getElementById(id).innerHTML="";

}

function showtimer(){if(timercount){clearTimeout(timercount);

clockID=0;

}

if(!timestart){timestart=new Date();

}

var timeend=new Date();

var timedifference=timeend.getTime()-timestart.getTime();

timeend.setTime(timedifference);

var minutes_passed=timeend.getMinutes();

if(minutes_passed<10){minutes_passed="0"+minutes_passed;

}

var seconds_passed=timeend.getSeconds();

if(seconds_passed<10){seconds_passed="0"+seconds_passed;

}

document.timeform.timetextarea.value=minutes_passed+":"+seconds_passed;

timercount=setTimeout("showtimer()",1000);

}

function sw_start(){if(!timercount){timestart=new Date();

document.timeform.timetextarea.value="00:00";

document.timeform.laptime.value="";

timercount=setTimeout("showtimer()",1000);

}

else{var timeend=new Date();

var timedifference=timeend.getTime()-timestart.getTime();

timeend.setTime(timedifference);

var minutes_passed=timeend.getMinutes();

if(minutes_passed<10){minutes_passed="0"+minutes_passed;

}

var seconds_passed=timeend.getSeconds();

if(seconds_passed<10){seconds_passed="0"+seconds_passed;

}

var milliseconds_passed=timeend.getMilliseconds();

if(milliseconds_passed<10){milliseconds_passed="00"+milliseconds_passed;

}

else if(milliseconds_passed<100){milliseconds_passed="0"+milliseconds_passed;

}

document.timeform.laptime.value=minutes_passed+":"+seconds_passed;

}}

function Stop(){if(timercount){clearTimeout(timercount);

timercount=0;

var timeend=new Date();

var timedifference=timeend.getTime()-timestart.getTime();

timeend.setTime(timedifference);

var minutes_passed=timeend.getMinutes();

if(minutes_passed<10){minutes_passed="0"+minutes_passed;

}

var seconds_passed=timeend.getSeconds();

if(seconds_passed<10){seconds_passed="0"+seconds_passed;

}

var milliseconds_passed=timeend.getMilliseconds();

if(milliseconds_passed<10){milliseconds_passed="00"+milliseconds_passed;

}

else if(milliseconds_passed<100){milliseconds_passed="0"+milliseconds_passed;

}

document.timeform.timetextarea.value=minutes_passed+":"+seconds_passed;

}

timestart=null;

}

function Reset(){timestart=null;

document.timeform.timetextarea.value="00:00";

document.timeform.laptime.value="";

}

function checkAllHiddensBeforeSubmit(idList,idStub,submitBtn,errorMSG){var allChecked='Y';

var fieldIDArr=idList.split(",");

for(var i=0;

i<fieldIDArr.length;

i++){var fieldValue=document.getElementById(idStub+fieldIDArr[i]).value;

if(fieldValue==''){allChecked='N';

break;

}}

if(allChecked=='Y'){document.getElementById(submitBtn).click();

}else{alert(errorMSG);

}}

function getBaseURL()

{var pageURL=document.location.href;

var urlArray=pageURL.split("/");

var BaseURL=urlArray[0]+"//"+urlArray[2]+"/";

if(urlArray[2]=='localhost'){BaseURL=BaseURL+'academia_new/';

}


return BaseURL;

}

function customDropDown(listUrl,listDiv,errorMsg){if(document.getElementById(listDiv).style.display=='block'){document.getElementById(listDiv).style.display='none';

}else{document.getElementById(listDiv).style.display='block';

updateFieldLayer(getBaseURL()+listUrl,'','',listDiv,errorMsg);

}}

function addSearchResult(resultRowVals,confirmedLayer,resultsLayer){var searchResultArray=resultRowVals.split('|');

var layerHTML="<div id='"+searchResultArray[0]+"' class='resultsrow'>"+"<table width='100%' border='0' cellspacing='0' cellpadding='5'>"+"<tr>"+"<td width='1%'><a href='javascript:void(0)' onclick=\"removeSearchResult('"+searchResultArray[0]+"', 'diagnosis_conclusion');addOrRemove('selectedcount', 'remove')\" title='Remove this symptom.'><img src='"+getBaseURL()+"images/delete_icon.png' border='0' class='btn'/></a></td>"+"<td width='1%'><a href='javascript:void(0)' onclick=\"updateFieldLayer('"+getBaseURL()+"page/show_pop_div/i/add_symptom_photo/s/"+searchResultArray[0]+"', '','','_','')\" title='Add your photo of this symptom.'><img src='"+getBaseURL()+"images/add_photo_icon.png' border='0' class='btn'/></a></td>"+"<td width='98%'><table>"+"<tr>"+"<td>"+document.getElementById(searchResultArray[0]+'_raw').innerHTML+"</td>"+"<td><img src='"+getBaseURL()+"images/spacer.gif' width='1' height='30' /></td>"+"</tr></table></td>"+"</tr>"+"</table></div>";

var originalContent=document.getElementById(confirmedLayer).innerHTML;

if(originalContent==null||originalContent=="<div></div>"){originalContent=='';

}

document.getElementById(confirmedLayer).innerHTML=layerHTML+originalContent;

var theNode=document.getElementById(searchResultArray[0]);

theNode.parentNode.removeChild(theNode);

var allTriggersString=document.getElementById('alltriggers').value;

var allTriggers=allTriggersString.split('__');

allTriggers.push(searchResultArray[0]);

document.getElementById('alltriggers').value=allTriggers.join('__');

var URL=getBaseURL()+"diagnosis/make_conclusion/r/"+searchResultArray[0];

if(document.getElementById(searchResultArray[0]+"_value"))

{URL=URL+"/v/"+document.getElementById(searchResultArray[0]+"_value").value;

}

if(searchResultArray[1]!=''){URL=URL+"/f1/"+replaceBadChars(searchResultArray[1]);

}

if(searchResultArray[2]!=''){URL=URL+"/fv1/"+replaceBadChars(searchResultArray[2]);

}

if(searchResultArray[3]!=''){URL=URL+"/f2/"+replaceBadChars(searchResultArray[3]);

}

if(searchResultArray[4]!=''){URL=URL+"/fv2/"+replaceBadChars(searchResultArray[4]);

}

document.getElementById('layerid').value=resultsLayer;

updateFieldLayer(URL,'','',resultsLayer,'');

}

function removeSearchResult(resultID,resultsLayer){var URL=getBaseURL()+"diagnosis/make_conclusion/r/"+resultID+"/a/remove";

var theNode=document.getElementById(resultID);

theNode.parentNode.removeChild(theNode);

document.getElementById('layerid').value=resultsLayer;

updateFieldLayer(URL,'','',resultsLayer,'');

}

function selectValue(dropValueId,dropValue)

{document.getElementById(dropValueId).value=dropValue;

document.getElementById(dropValueId+'_selected').innerHTML=dropValue;

document.getElementById(dropValueId+'_listdiv').style.display='none';

}

function showSearchLayers(showLayerList,hideLayerList,requiredFields,requiredMessages)

{var showLayers=showLayerList.split('<>');

var hideLayers=hideLayerList.split('<>');

var formFields=requiredFields.split('<>');

var fieldMessages=requiredMessages.split('<>');

var proceedStr='TRUE';

if(requiredFields!='')

{for(var i=0;

i<formFields.length;

i++)

{if(!checkEmpty(formFields[i],fieldMessages[i])){proceedStr='FALSE';

break;

}}}

if(proceedStr=='TRUE'){for(var i=0;

i<hideLayers.length;

i++)

{processFormVisibleObj(hideLayers[i],'hide');

}

for(var i=0;

i<showLayers.length;

i++)

{processFormVisibleObj(showLayers[i],'show');

}}}

function processFormVisibleObj(formObjStr,actionStr)

{if(formObjStr.indexOf('#')!=-1){var propertyStrArray=formObjStr.split('#');

if(actionStr=='show'){document.getElementById(propertyStrArray[0]).className=propertyStrArray[1];

}else{document.getElementById(propertyStrArray[0]).className='';

}}

if(formObjStr.indexOf('*')!=-1){var propertyStrArray=formObjStr.split('*');

var subPropertyStrArray=propertyStrArray[1].split('_');

if(actionStr=='show'){if(subPropertyStrArray[0]=='w'){document.getElementById(propertyStrArray[0]).size=subPropertyStrArray[1];

}else if(subPropertyStrArray[0]=='h'){document.getElementById(propertyStrArray[0]).height=subPropertyStrArray[1];

}}else{if(subPropertyStrArray[0]=='w'){document.getElementById(propertyStrArray[0]).style.width='0px';

}else if(subPropertyStrArray[0]=='h'){document.getElementById(propertyStrArray[0]).style.height='0px';

}}}

if(formObjStr.indexOf('*')==-1&&formObjStr.indexOf('#')==-1)

{if(actionStr=='show')

{document.getElementById(formObjStr).style.display='';

}else{document.getElementById(formObjStr).style.display='none';

}}}

function sysAlert(msg)

{jAlert(msg,'Message from ACADEMIA');

}

function sysConfirm(posAction,msg)

{jConfirm(msg,'Message from ACADEMIA',function(r){document.location.href=posAction;

});

}

function sysPrompt(posAction,fieldText,prefilledValue,msg)

{jPrompt(fieldText,prefilledValue,'Message from ACADEMIA',function(r){if(r){var fvalue=r;

}

else if(prefilledValue!='')

{var fvalue=prefilledValue;

}

else

{sysAlert(msg);

}

if(fvalue!='')

{document.location.href=posAction+'/'+fieldText+'/'+replaceBadChars(fvalue);

}});

}

function showShadowBox(msgHTML,boxStyles)

{if(document.getElementById('light')){}else{var lightDiv=document.createElement("div");

lightDiv.setAttribute("id","light");

lightDiv.setAttribute("class","white_content");

for(var i=0;

i<boxStyles.length;

i++){lightDiv.setAttribute(boxStyles[i][0],boxStyles[i][1]);

}

var fadeDiv=document.createElement("div");

fadeDiv.setAttribute("id","fade");

fadeDiv.setAttribute("class","black_overlay");

document.body.appendChild(lightDiv);

document.body.appendChild(fadeDiv);

}

document.getElementById('light').innerHTML=msgHTML;

document.getElementById('light').style.display='block';

document.getElementById('fade').style.display='block';

}

function actOnLightDiv(lightLayer,darkLayer,action){if(action=='open'){document.getElementById(lightLayer).style.display='block';

document.getElementById(darkLayer).style.display='block';

}else{document.getElementById(lightLayer).style.display='none';

document.getElementById(darkLayer).style.display='none';

}}

function showPopDiv(popId,popSpecs,popDiv)

{document.getElementById('layerid').value=popDiv;

showHideSlowLayer(getBaseURL()+"page/show_pop_div/pi/"+popId);

var popDivArray=popSpecs.split('<>');

var boxSpecs=new Array();

for(var i=0;

i<popDivArray.length;

i++){var popSubSpec=popDivArray[i].split('*');

var popSubSpecArray=new Array(popSubSpec[0],popSubSpec[1]);

boxSpecs.push(popSubSpecArray);

}

document.getElementById('').value=$('#'+popDiv).get().innerHTML;

var boxHTML=$('#'+popDiv).get().innerHTML;

showShadowBox(boxHTML,boxSpecs);

}

function showTipDetails(tipID)

{$('#'+tipID+'_box').fadeIn(80);

}

function hideTipDetails(tipID)

{$('#'+tipID+'_box').fadeOut('fast');

}

function elegantHideDiv(divID)

{$('#'+divID).fadeOut('fast');

document.getElementById(divID).style.display='none';

}

function showBiggerImage(imgId){var imgObj=document.getElementById(imgId);

var href=imgObj.src;

var divObj=document.getElementById(imgId+'_div');

divObj.innerHTML='<img id="largeImage" src="'+href+'" height="200" alt="big image" />';

var x=$('#'+imgId).offset().left;

var y=$('#'+imgId).offset().top;

var imgHeight=$('#'+imgId).outerHeight();

var bigy=$('#'+imgId+'_div').position().top;

$('#'+imgId+'_div').fadeIn(100);

}

function hideBiggerImage(imgId){var divObj=document.getElementById(imgId+'_div');

divObj.style.display='none';

}

function moveLeft(parentDivID){var allImgDivs=$("#"+parentDivID+" > div").map(function(){return this.id;

}).get();

for(var i=0;

i<allImgDivs.length;

i++){var idParts=allImgDivs[i].split('_');

var divCount=parseInt(idParts[1]);

var divStyle=document.getElementById(allImgDivs[i]).style.display;

if(divStyle=='block'&&divCount!=0){document.getElementById(allImgDivs[i]).style.display='none';

$('#'+allImgDivs[i-1]).fadeIn(100);

document.getElementById(allImgDivs[i-1]).style.display='block';

break;

}}}

function moveRight(parentDivID)

{var allImgDivs=$("#"+parentDivID+" > div").map(function(){return this.id;

}).get();

var maxDivCount=allImgDivs.length-1;

for(var i=0;

i<allImgDivs.length;

i++){var idParts=allImgDivs[i].split('_');

var divCount=parseInt(idParts[1]);

var divStyle=document.getElementById(allImgDivs[i]).style.display;

if(divStyle=='block'&&divCount!=maxDivCount){document.getElementById(allImgDivs[i]).style.display='none';

$('#'+allImgDivs[i+1]).fadeIn(100);

document.getElementById(allImgDivs[i+1]).style.display='block';

break;

}}}

function showLoading(divList)

{var divIdArray=divList.split('<>');

for(var i=0;

i<divIdArray.length;

i++){document.getElementById(divIdArray[i]).innerHTML="<img src='"+getBaseURL()+"images/loading.gif'>";

}}

function showHideVerticalLayers()

{if(document.getElementById('diagnosis_conc').style.display=='none'){$("#pointercell").html("<img src='"+getBaseURL()+"images/expand_arrow_right.png'/>");

$("#expandtext").hide('fast');

$("#diagnosis_conc").show('fast');

}

else

{$("#pointercell").html("<img src='"+getBaseURL()+"images/expand_arrow_left.png'/>");

$("#expandtext").show('fast');

$("#diagnosis_conc").hide('fast');

}}

function checkBox(checkboxID,bgColor)

{if(document.getElementById(checkboxID).checked){document.getElementById(checkboxID+'_cell').style.backgroundColor=bgColor;

}

else

{document.getElementById(checkboxID+'_cell').style.backgroundColor="";

}}

function showFormEditLayer(viewLayer,editLayer,URL)

{if(document.getElementById(viewLayer).style.display=='none')

{$('#'+viewLayer).show('fast');

$('#'+editLayer).hide('fast');

updateFieldLayer(URL,'','',viewLayer,'');

}

else

{$('#'+viewLayer).hide('fast');

$('#'+editLayer).show('fast');

updateFieldLayer(URL,'','',editLayer,'');

}}

function hideLayerSet(layerSet)

{var layerArray=layerSet.split('<>');

for(var i=0;

i<layerArray.length;

i++)

{$('#'+layerArray[i]).hide('fast');

}}

function unhideShowLayer(showLayer,hideLayer)

{if(showLayer!='')

{var obj=document.getElementById(showLayer);

obj.style.visibility="visible";

obj.style.height="";

obj.style.display="block";

}

if(hideLayer!='')

{var objHidden=document.getElementById(hideLayer);

objHidden.style.visibility="hidden";

objHidden.style.height=0;

objHidden.style.display="none";

}}

function showLayerSet(layerSet)

{var layerArray=layerSet.split('<>');

for(var i=0;

i<layerArray.length;

i++)

{$('#'+layerArray[i]).show('fast');

}}

function postToLayer(URL,fieldIds,layerId,errorMsg){var params="";

var allIn="";

var fieldNameArr=fieldIds.split('<>');

if(fieldNameArr.length>0)

{for(var i=0;

i<fieldNameArr.length;

i++)

{if(i!=0){params+="/";

}

if(fieldNameArr[i].charAt(0)!="*"){if(!checkEmpty(fieldNameArr[i],errorMsg))

{allIn="NO";

break;

}else{if(trimString(document.getElementById(fieldNameArr[i]).value)==''){var fieldValue='_';

}else{var fieldValue=replaceBadChars(document.getElementById(fieldNameArr[i]).value);

}

params+=fieldNameArr[i]+"/"+fieldValue;

}}else{var fieldName=fieldNameArr[i].substr(1,fieldNameArr[i].length);

if(trimString(document.getElementById(fieldName).value)==''){var fieldValue='_';

}else{var fieldValue=replaceBadChars(document.getElementById(fieldName).value);

}

params+=fieldName+"/"+fieldValue;

}}}

if(allIn==""){URL=URL+"/"+params;

http.open("POST",URL,true);

http.setRequestHeader("Content-type","application/x-www-form-urlencoded");

http.setRequestHeader("Content-length",URL.length);

http.setRequestHeader("Connection","close");

http.onreadystatechange=function(){if(http.readyState==4&&http.status==200){document.getElementById(layerId).innerHTML=http.responseText;

}}

http.send(URL);

}}

function showToolDetails(toolDiv,toolType,fieldName,toolElement)

{$(".tool_bg_middle_active").each(function(){this.className="tool_bg_middle";

});

if(document.getElementById('active_wiki_tool').value==toolType){$('#'+toolDiv).slideUp('fast');

document.getElementById('active_wiki_tool').value='';

document.getElementById('layerid').value='';

}else{toolElement.className='tool_bg_middle_active';

document.getElementById('active_wiki_tool').value=toolType;

document.getElementById('layerid').value=toolDiv;

var selectedText=getInputSelection(fieldName);

selectedValue="EMPTY";

if(!isNullOrEmpty(selectedText.text)){selectedValue=selectedText.text;

}

showHideSlowLayer(getBaseURL()+"page/show_tool_details/i/"+toolType+"/d/"+toolDiv+"/f/"+fieldName+"/s/"+selectedValue+"/b/"+selectedText.start+"/e/"+selectedText.end);

if((document.getElementById(toolDiv).style.display)=="none"){$('#'+toolDiv).slideDown('fast');

}}}

function showHideFastLayer(divID,divURL)

{if(document.getElementById(divID).style.display=='none'){if(divURL!='')

{document.getElementById('layerid').value=divID;

showHideSlowLayer(divURL);

}

$('#'+divID).slideDown('fast');

}

else

{$('#'+divID).slideUp('fast');

}}

function toggleLayer(divID,divURL)

{if(document.getElementById(divID).style.display=='none'){if(divURL!='')

{document.getElementById('layerid').value=divID;

showHideSlowLayer(divURL);

}

$('#'+divID).slideDown('fast');

document.getElementById(divID).style.display='block';

}

else

{$('#'+divID).slideUp('fast');

document.getElementById(divID).style.display='none';

}}

function changeScrollDivContent(actionDivId)

{if(document.getElementById('content_'+actionDivId).style.display=='none')

{var divHTML="<table><tr>"+"<td><a href=\"javascript:void(0)\" onclick=\"toggleLayer('content_"+actionDivId+"', '');changeScrollDivContent('"+actionDivId+"');absHideDiv('summary_"+actionDivId+"');\" class='smallbluelinks'>View More</a></td>"+"<td style='padding:0px;padding-right:10px;' nowrap><img src='"+getBaseURL()+"images/blue_arrow_bottom.png'/></td>"+"</tr></table>";

}

else

{var divHTML="<table><tr>"+"<td><a href=\"javascript:void(0)\" onclick=\"toggleLayer('content_"+actionDivId+"','');changeScrollDivContent('"+actionDivId+"');absShowDiv('summary_"+actionDivId+"');\" class='smallbluelinks'>View Less</a></td>"+"<td style='padding:0px;padding-right:10px;' nowrap><img src='"+getBaseURL()+"images/blue_arrow_top.png'/></td>"+"</tr></table>";

}

document.getElementById(actionDivId).innerHTML=divHTML;

}

function applyLayerAction(actionURL,divID)

{document.getElementById('layerid').value=divID;

showHideSlowLayer(actionURL);

}

function closePopupAndLoadInParent(url)

{window.opener.location.replace(url);

window.close();

}

function clearFormFields(fieldStr)

{var fieldNameArr=fieldStr.split('<>');

for(var i=0;

i<fieldNameArr.length;

i++)

{document.getElementById(fieldNameArr[i]).value='';

}}

function showPartLayer(layerID,speed)

{if(document.getElementById(layerID).style.display!='block')

{$('#'+layerID).slideDown(speed);

}}

function showDropLayer(URL,dropDownId,nextDropDiv,errorMSG)

{if(document.getElementById(dropDownId).value!='')

{updateFieldLayer(URL,dropDownId,'',nextDropDiv,errorMSG);

$('#'+nextDropDiv+'_label').slideDown('fast');

hideDiv(nextDropDiv);

}

else

{alert(errorMSG);

}}

function confirmActionToLayer(URL,fieldList,fromLayer,layerID,errorMSG)

{if(window.confirm(errorMSG))

{var newMSG="";

if(fieldList!='')

{newMSG="All fields are required except where indicated.";

}

updateFieldLayer(URL,fieldList,fromLayer,layerID,newMSG);

}}

function updateFieldValue(fieldChangeId,fieldChangeValue)

{if(fieldChangeId.indexOf('<>',0)>-1)

{var fieldIdArr=fieldChangeId.split('<>');

var fieldValueArr=fieldChangeValue.split('<>');

for(var i=0;

i<fieldIdArr.length;

i++){document.getElementById(fieldIdArr[i]).value=fieldValueArr[i];

}}

else

{document.getElementById(fieldChangeId).value=fieldChangeValue;

}}

function getInputSelection(fieldName)

{var textComponent=document.getElementById(fieldName);

var selectedText;

var start=0;

var end=0;

if(document.selection!=undefined)

{textComponent.focus();

var sel=document.selection.createRange();

selectedText=sel.text;

range=document.selection.createRange();

if(range&&range.parentElement()==textComponent){len=textComponent.value.length;

normalizedValue=textComponent.value.replace(/\r\n/g,"\n");

textInputRange=textComponent.createTextRange();

textInputRange.moveToBookmark(range.getBookmark());

endRange=textComponent.createTextRange();

endRange.collapse(false);

if(textInputRange.compareEndPoints("StartToEnd",endRange)>-1){start=end=len;

}else{start=-textInputRange.moveStart("character",-len);

start+=normalizedValue.slice(0,start).split("\n").length-1;

if(textInputRange.compareEndPoints("EndToEnd",endRange)>-1){end=len;

}else{end=-textInputRange.moveEnd("character",-len);

end+=normalizedValue.slice(0,end).split("\n").length-1;

}}}}

else if(textComponent.selectionStart!=undefined)

{start=textComponent.selectionStart;

end=textComponent.selectionEnd;

selectedText=textComponent.value.substring(start,end)}

return{start:start,end:end,text:selectedText}}

function applyBasicWikiRule(fieldName,startWith,endWith){var elementText=document.getElementById(fieldName).value;

var selectedText=getInputSelection(fieldName);

var newText="";

if(isNullOrEmpty(selectedText.text)){sysAlert("Please select text to apply formatting");

return false;

}else{newText=elementText.substring(0,selectedText.start)+startWith+selectedText.text+endWith+elementText.substring(selectedText.end,elementText.length);

document.getElementById(fieldName).value=newText;

return true;

}}

function applyIndentationWikiRule(fieldName){var elementText=document.getElementById(fieldName).value;

var selectedText=getInputSelection(fieldName);

var newText="";

if(isNullOrEmpty(document.getElementById('selectedtext').value)){sysAlert("Please select text to apply formatting");

return false;

}else{if(isNullOrEmpty(document.getElementById('start').value)){newText=elementText.substring(0,selectedText.start)+"<indent"+document.getElementById("indentationlevel").options[document.getElementById("indentationlevel").selectedIndex].value+" "+document.getElementById('selectedtext').value+">"+elementText.substring(selectedText.end,elementText.length);

}else{newText=elementText.substring(0,document.getElementById('start').value)+"<indent"+document.getElementById("indentationlevel").options[document.getElementById("indentationlevel").selectedIndex].value+" "+document.getElementById('selectedtext').value+">"+elementText.substring(document.getElementById('end').value,elementText.length);

}

document.getElementById(fieldName).value=newText;

return true;

}}

function applyCharacterWikiRule(fieldName,characterHTML){var elementText=document.getElementById(fieldName).value;

var selectedText=getInputSelection(fieldName);

var newText=elementText.substring(0,selectedText.start)+characterHTML+elementText.substring(selectedText.end,elementText.length);

document.getElementById(fieldName).value=newText;

return true;

}

function applyHeaderWikiRule(fieldName,optionText){var optionsArray=new Array();

var elementText=document.getElementById(fieldName).value;

var selectedText=getInputSelection(fieldName);

var newText="";

optionsArray=optionText.split("|");

if(isNullOrEmpty(optionsArray[2])){newText=elementText.substring(0,selectedText.start)+"<heading"+optionsArray[0]+" "+optionsArray[1]+">"+elementText.substring(selectedText.end,elementText.length);

}else{newText=elementText.substring(0,optionsArray[2])+"<heading"+optionsArray[0]+" "+optionsArray[1]+">"+elementText.substring(optionsArray[3],elementText.length);

}

document.getElementById(fieldName).value=newText;

}

function applyLinkWikiRule(fieldName,optionText){var optionsArray=new Array();

var elementText=document.getElementById(fieldName).value;

var selectedText=getInputSelection(fieldName);

var newText="";

optionsArray=optionText.split("|");

if(isNullOrEmpty(optionsArray[3])){newText=elementText.substring(0,selectedText.start)+"<"+optionsArray[0]+optionsArray[1]+optionsArray[2]+">"+elementText.substring(selectedText.end,elementText.length);

}else{newText=elementText.substring(0,optionsArray[3])+"<"+optionsArray[0]+optionsArray[1]+optionsArray[2]+">"+elementText.substring(optionsArray[4],elementText.length);

}

document.getElementById(fieldName).value=newText;

}

function applyRedirectWikiRule(fieldName,optionText){var optionsArray=new Array();

var elementText=document.getElementById(fieldName).value;

var selectedText=getInputSelection(fieldName);

var newText="";

optionsArray=optionText.split("|");

if(isNullOrEmpty(optionsArray[2])){newText=elementText.substring(0,selectedText.start)+"<redirect "+optionsArray[0];

}else{newText=elementText.substring(0,optionsArray[2])+"<redirect "+optionsArray[0];

}

if(document.getElementById('redirectanchor').checked&&!isNullOrEmpty(document.getElementById('anchorname').value)){newText=newText+" | anchor="+optionsArray[1];

}else if(document.getElementById('redirectsection').checked&&!isNullOrEmpty(document.getElementById('section').value)){newText=newText+" | section="+optionsArray[1];

}

if(isNullOrEmpty(optionsArray[2])){newText=newText+">"+elementText.substring(selectedText.end,elementText.length);

}else{newText=newText+">"+elementText.substring(optionsArray[3],elementText.length);

}

document.getElementById(fieldName).value=newText;

}

function applyTipWikiRule(fieldName,optionText){var optionsArray=new Array();

var elementText=document.getElementById(fieldName).value;

var selectedText=getInputSelection(fieldName);

var newText="";

optionsArray=optionText.split("|");

if(optionsArray[0]=="yestip"){if(isNullOrEmpty(optionsArray[3])){newText=elementText.substring(0,selectedText.start)+"<tip "+optionsArray[1]+" | utip="+optionsArray[2];

}else{newText=elementText.substring(0,optionsArray[3])+"<tip "+optionsArray[1]+" | utip="+optionsArray[2];

}}else if(optionsArray[0]=="notip"){if(isNullOrEmpty(optionsArray[6])){newText=elementText.substring(0,selectedText.start)+"<tip "+optionsArray[2];

}else{newText=elementText.substring(0,optionsArray[6])+"<tip "+optionsArray[2];

}

if(!isNullOrEmpty(optionsArray[3])){newText=newText+" | name="+optionsArray[3];

}

if(optionsArray[1]=="imagelist"){newText=newText+" | imagelist=";

if(!isNullOrEmpty(optionsArray[4])){var images=optionsArray[4].split("<>");

for(var i=0;

i<images.length;

i++){if(!isNullOrEmpty(trim(images[i]))){newText=newText+" "+trim(images[i]);

}}}}else{newText=newText+" | details="+optionsArray[4];

}

if(!isNullOrEmpty(optionsArray[5])){var imageOptions=optionsArray[5].split("<>");

for(var i=0;

i<imageOptions.length;

i++){if(!isNullOrEmpty(trim(imageOptions[i]))){newText=newText+" | "+trim(imageOptions[i]);

}}}}

if(isNullOrEmpty(optionsArray[6])){newText=newText+">"+elementText.substring(selectedText.end,elementText.length);

}else{newText=newText+">"+elementText.substring(optionsArray[7],elementText.length);

}

document.getElementById(fieldName).value=newText;

}

function applyReferenceWikiRule(fieldName,optionText){var optionsArray=new Array();

var elementText=document.getElementById(fieldName).value;

var selectedText=getInputSelection(fieldName);

var newText="";

optionsArray=optionText.split("|");

if(optionsArray[0]=="yesref"){if(isNullOrEmpty(optionsArray[2])){newText=elementText.substring(0,selectedText.start)+"<ref "+optionsArray[1];

}else{newText=elementText.substring(0,optionsArray[2])+"<ref "+optionsArray[1];

}}else if(optionsArray[0]=="noref"){if(isNullOrEmpty(optionsArray[3])){newText=elementText.substring(0,selectedText.start)+"<ref "+optionsArray[1];

}else{newText=elementText.substring(0,optionsArray[3])+"<ref "+optionsArray[1];

}

if(!isNullOrEmpty(optionsArray[2])){var imageOptions=optionsArray[2].split("<>");

for(var i=0;

i<imageOptions.length;

i++){if(!isNullOrEmpty(trim(imageOptions[i]))){newText=newText+" | "+trim(imageOptions[i]);

}}}}

if(!isNullOrEmpty(optionsArray[2])&&(optionsArray[0]=="yesref")){newText=newText+">"+elementText.substring(optionsArray[3],elementText.length);

}else if(!isNullOrEmpty(optionsArray[3]&&optionsArray[0]=="noref")){newText=newText+">"+elementText.substring(optionsArray[4],elementText.length);

}else{newText=newText+">"+elementText.substring(selectedText.end,elementText.length);

}

document.getElementById(fieldName).value=newText;

}

function applyListWikiRule(fieldName,optionText){var optionsArray=new Array();

var elementText=document.getElementById(fieldName).value;

var selectedText=getInputSelection(fieldName);

var newText="";

optionsArray=optionText.split("|");

if(isNullOrEmpty(optionsArray[2])){newText=elementText.substring(0,selectedText.start)+"<"+optionsArray[0]+">";

}else{newText=elementText.substring(0,optionsArray[2])+"<"+optionsArray[0]+">";

}

if(!isNullOrEmpty(optionsArray[1])){var imageOptions=optionsArray[1].split("<>");

for(var i=0;

i<imageOptions.length;

i++){if(!isNullOrEmpty(trim(imageOptions[i]))){newText=newText+"<item "+trim(imageOptions[i])+">";

}}}

if(isNullOrEmpty(optionsArray[2])){newText=newText+"</"+optionsArray[0]+">"+elementText.substring(selectedText.end,elementText.length);

}else{newText=newText+"</"+optionsArray[0]+">"+elementText.substring(optionsArray[3],elementText.length);

}

document.getElementById(fieldName).value=newText;

}

function applySelectWikiRule(fieldName,optionText){var optionsArray=new Array();

var elementText=document.getElementById(fieldName).value;

var selectedText=getInputSelection(fieldName);

var newText="";

optionsArray=optionText.split("|");

newText=elementText.substring(0,selectedText.start)+"<"+optionsArray[0];

if(optionsArray[0]=="bselect"){if(!isNullOrEmpty(optionsArray[4])){newText=newText+" "+optionsArray[4];

}else{newText=newText+" ["+optionsArray[1]+"]";

}

newText=newText+" | name="+optionsArray[1]+" | min="+optionsArray[2]+" | max="+optionsArray[3]+">";

}else{if(!isNullOrEmpty(optionsArray[3])){newText=newText+"  "+optionsArray[3]+"  ";

}else{newText=newText+" ["+optionsArray[1]+"]";

}

newText=newText+" | name="+optionsArray[1]+" | ";

if(!isNullOrEmpty(optionsArray[2])){var imageOptions=optionsArray[2].split("<>");

for(var i=0;

i<imageOptions.length;

i++){if(!isNullOrEmpty(trim(imageOptions[i]))){newText=newText+imageOptions[i]+"*";

}}

newText=newText+">";

}}

newText=newText+elementText.substring(selectedText.end,elementText.length);

document.getElementById(fieldName).value=newText;

}

function applyAnchorWikiRule(fieldName,optionText){var elementText=document.getElementById(fieldName).value;

var selectedText=getInputSelection(fieldName);

var newText="";

var optionsArray=optionText.split("|");

if(isNullOrEmpty(optionsArray[1])){newText=elementText.substring(0,selectedText.start)+"<anchor "+optionsArray[0]+">"+elementText.substring(selectedText.end,elementText.length);

}else{newText=elementText.substring(0,optionsArray[1])+"<anchor "+optionsArray[0]+">"+elementText.substring(optionsArray[2],elementText.length);

}

document.getElementById(fieldName).value=newText;

}

function applyImageWikiRule(fieldName,optionText){var optionsArray=new Array();

var elementText=document.getElementById(fieldName).value;

var selectedText=getInputSelection(fieldName);

var newText="";

optionsArray=optionText.split("|");

if(isNullOrEmpty(optionsArray[3])){newText=elementText.substring(0,selectedText.start)+"<image "+optionsArray[0];

}else{newText=elementText.substring(0,optionsArray[3])+"<image "+optionsArray[0];

}

if(!isNullOrEmpty(optionsArray[1])){newText=newText+" "+trim(optionsArray[1]);

if(!isNullOrEmpty(optionsArray[2])){var imageOptions=optionsArray[2].split("<>");

for(var i=0;

i<imageOptions.length;

i++){if(!isNullOrEmpty(trim(imageOptions[i]))){newText=newText+" | "+trim(imageOptions[i]);

}}}}

if(isNullOrEmpty(optionsArray[3])){newText=newText+">"+elementText.substring(selectedText.end,elementText.length);

}else{newText=newText+">"+elementText.substring(optionsArray[4],elementText.length);

}

document.getElementById(fieldName).value=newText;

}

function applyWikiRule(rule,fieldName,optiontext){switch(rule){case"bold":applyBasicWikiRule(fieldName,"<b ",">");

break;

case"italic":applyBasicWikiRule(fieldName,"<i ",">");

break;

case"underline":applyBasicWikiRule(fieldName,"<u ",">");

break;

case"header":applyHeaderWikiRule(fieldName,optiontext);

break;

case"link":applyLinkWikiRule(fieldName,optiontext);

break;

case"redirect":applyRedirectWikiRule(fieldName,optiontext);

break;

case"tip":applyTipWikiRule(fieldName,optiontext);

break;

case"anchor":applyAnchorWikiRule(fieldName,optiontext);

break;

case"image":applyImageWikiRule(fieldName,optiontext);

break;

case"indentation":applyIndentationWikiRule(fieldName);

break;

case"reference":applyReferenceWikiRule(fieldName,optiontext);

break;

case"list":applyListWikiRule(fieldName,optiontext);

break;

case"select":applySelectWikiRule(fieldName,optiontext);

break;

case"character":applyCharacterWikiRule(fieldName,optiontext);

break;

}}

function processToolCharacter(fieldName,characterField){applyWikiRule("character",fieldName,characterField.innerHTML);

}

function processToolHeader(fieldName){if(isNullOrEmpty(document.getElementById("headingtext").value)){sysAlert("Please specify the header text.");

return false;

}else{var optiontext=document.getElementById("headinglevel").options[document.getElementById("headinglevel").selectedIndex].value+"|"+document.getElementById("headingtext").value+"|"+document.getElementById("start").value+"|"+document.getElementById("end").value;

applyWikiRule("header",fieldName,optiontext);

}}

function processToolList(listTable,type,fieldName){try{var table=document.getElementById(listTable);

var rowCount=table.rows.length;

var optiontext=type+'|';

var selectCount=0;

for(var i=0;

i<rowCount;

i++){var row=table.rows[i];

var txtBox=row.cells[1].childNodes[0];

if(!isNullOrEmpty(txtBox.value)){optiontext=optiontext+txtBox.value+"<>";

selectCount++;

}}

if(selectCount==0){sysAlert("Please enter at least one item.");

return;

}}catch(e){sysAlert("Error: "+e);

return;

}

optiontext=optiontext+"|"+document.getElementById("start").value+"|"+document.getElementById("end").value;

applyWikiRule("list",fieldName,optiontext);

}

function processToolAnchor(fieldName){if(isNullOrEmpty(document.getElementById("anchorname").value)){sysAlert("Please specify the name of the anchor.");

return false;

}else{var optiontext=document.getElementById("anchorname").value+"|"+document.getElementById("start").value+"|"+document.getElementById("end").value;

applyWikiRule("anchor",fieldName,optiontext);

}}

function processToolLink(fieldName){if(document.getElementById("ulink").checked){var optiontext="ulink"+"| "+document.getElementById("diseasesstamp").value+"| "+document.getElementById("displaytext").value+"|"+document.getElementById("start").value+"|"+document.getElementById("end").value;

applyWikiRule("link",fieldName,optiontext);

}else if(document.getElementById("elink").checked){if(trim(document.getElementById("linktarget").value)=="http://"){sysAlert("Please specify the address of the external page.");

}else{var optiontext="elink"+"| "+document.getElementById("linktarget").value+"| "+document.getElementById("displaytext").value+"|"+document.getElementById("start").value+"|"+document.getElementById("end").value;

applyWikiRule("link",fieldName,optiontext);

}}else{sysAlert("Please specify the link type.");

}}

function processToolReference(fieldName){if(document.getElementById('yesref').checked&&isNullOrEmpty(document.getElementById('referencename').value)){sysAlert("Please specify the name of the reference.");

return;

}else{if(document.getElementById('yesref').checked){var optiontext="yesref|"+document.getElementById('referencename').value+"|"+document.getElementById('start').value+"|"+document.getElementById('end').value;

applyWikiRule("reference",fieldName,optiontext);

}else{var optiontext="noref|";

if(document.getElementById("ulink").checked){if(isNullOrEmpty(document.getElementById('diseasesstamp').value)){sysAlert("Please specify the reference page.");

return;

}else{optiontext=optiontext+document.getElementById("diseasesstamp").value+"|<>";

}}else if(document.getElementById("elink").checked){if(isNullOrEmpty(document.getElementById('linktarget').value)){sysAlert("Please specify the URL of the external page.");

return;

}else{optiontext=optiontext+document.getElementById("linktarget").value+"|<>";

}}else{sysAlert("Please specify the link type.");

return;

}

if(!isNullOrEmpty(document.getElementById('referencename').value)){optiontext=optiontext+"name="+document.getElementById('referencename').value+"<>";

}

if(!isNullOrEmpty(document.getElementById('refdescription').value)){optiontext=optiontext+"details="+document.getElementById('refdescription').value+"<>";

}

optiontext=optiontext+"|"+document.getElementById('start').value+"|"+document.getElementById('end').value

applyWikiRule("reference",fieldName,optiontext);

}}}

function processToolSelect(fieldName,listTable){if(isNullOrEmpty(document.getElementById('listname').value)){sysAlert("Please specify the name of the select field.");

return;

}else{if(document.getElementById('numerical').checked){if(isNullOrEmpty(document.getElementById('min').value)){sysAlert("Please specify the minimum value of the select field.");

}

if(isNullOrEmpty(document.getElementById('max').value)){sysAlert("Please specify the maximum value of the select field.");

}

var optiontext="bselect|"+document.getElementById('listname').value+"|"+document.getElementById('min').value+"|"+document.getElementById('max').value+"|"+document.getElementById('default').value;

applyWikiRule("select",fieldName,optiontext);

}else{var optiontext="nselect|"+document.getElementById('listname').value+"|";

try{var table=document.getElementById(listTable);

var rowCount=table.rows.length;

sysAlert("Table: "+listTable+", rows "+rowCount);

var selectCount=0;

for(var i=0;

i<rowCount;

i++){var row=table.rows[i];

var valueTxtBox=row.cells[1].childNodes[0];

var displayTxtBox=row.cells[2].childNodes[0];

var defaultRadio=row.cells[3].childNodes[0];

var defaultValue="";

sysAlert("Checking....");

if(!isNullOrEmpty(valueTxtBox.value)&&!isNullOrEmpty(displayTxtBox.value)){optiontext=optiontext+valueTxtBox.value+"="+displayTxtBox.value+"<>";

if(defaultRadio.checked){sysAlert("Got one!");

defaultValue=valueTxtBox.value;

}

selectCount++;

}}

if(selectCount==0){sysAlert("Please enter details for at least one select item.");

return;

}

if(isNullOrEmpty(defaultValue)){sysAlert("Please select the default.");

return;

}}catch(e){sysAlert("Error: "+e);

return;

}

optiontext=optiontext+"|"+defaultValue;

applyWikiRule("select",fieldName,optiontext);

}}}

function processToolRedirect(fieldName){if(isNullOrEmpty(document.getElementById('pagename').value)){sysAlert("Please specify the page to redirect to.");

}else{var optiontext=document.getElementById('pagename').value;

if(document.getElementById('redirectanchor').checked&&!isNullOrEmpty(document.getElementById('anchorname').value)){optiontext=optiontext+"|"+document.getElementById("anchorname").value;

}else if(document.getElementById('redirectsection').checked&&!isNullOrEmpty(document.getElementById('section').value)){optiontext=optiontext+"|"+document.getElementById("section").value;

}

optiontext=optiontext+"|"+document.getElementById("start").value+"|"+document.getElementById("end").value;

applyWikiRule("redirect",fieldName,optiontext);

}}

function processToolTip(fieldName,listTable){if(isNullOrEmpty(document.getElementById('texttoshowtip').value)){sysAlert("Please specify the text to show the tip.");

return;

}else if(document.getElementById('yestip').checked&&isNullOrEmpty(document.getElementById('tipname').value)){sysAlert("Please specify the name of the tip.");

return;

}else{if(document.getElementById('yestip').checked){var optiontext="yestip|"+document.getElementById('texttoshowtip').value+"|"+document.getElementById('tipname').value+"|"+document.getElementById('start').value+"|"+document.getElementById('end').value;

applyWikiRule("tip",fieldName,optiontext);

}else{if(document.getElementById('imagelist').checked){var optiontext="notip|imagelist|"+document.getElementById('texttoshowtip').value+"|"+document.getElementById('tipname').value+"|<>";

try{var table=document.getElementById(listTable);

var rowCount=table.rows.length;

var selectCount=0;

for(var i=0;

i<rowCount;

i++){var row=table.rows[i];

var txtBox=document.getElementById('images_'+(i+1));

if(!isNullOrEmpty(txtBox.value)){optiontext=optiontext+txtBox.value+"<>";

selectCount++;

}}

if(selectCount==0){sysAlert("Please select at least one image.");

return;

}}catch(e){sysAlert("Error: "+e);

return;

}

optiontext=optiontext+"|";

if(!isNullOrEmpty(document.getElementById('tipimagelistwidth').value)){if(isNumber(document.getElementById('tipimagelistwidth').value)&&(parseInt(document.getElementById('tipimagelistwidth').value)<500)){optiontext=optiontext+"width="+document.getElementById("tipimagelistwidth").value+"<>";

}else{sysAlert("The width should be a number value less than 500.");

return;

}}

if(!isNullOrEmpty(document.getElementById('tipimagelistheight').value)){if(isNumber(document.getElementById('tipimagelistheight').value)&&(parseInt(document.getElementById('tipimagelistheight').value)<500)){optiontext=optiontext+"height="+document.getElementById("tipimagelistheight").value+"<>";

}else{sysAlert("The height should be a number value less than 500.");

return;

}}}else{if(isNullOrEmpty(document.getElementById('tipdetails').value)){sysAlert("Please specify the details to be shown in the tip.");

return;

}else{var optiontext="notip|other|"+document.getElementById('texttoshowtip').value+"|"+document.getElementById('tipname').value+"|"+document.getElementById('tipdetails').value;

if(!isNullOrEmpty(document.getElementById('tipimage').value)){optiontext=optiontext+"|<>image="+document.getElementById("tipimage").value+"<>";

if(!isNullOrEmpty(document.getElementById('tipImageAlign').value)){optiontext=optiontext+"align="+document.getElementById("tipImageAlign").value+"<>";

}

if(!isNullOrEmpty(document.getElementById('tipimagewidth').value)){if(isNumber(document.getElementById('tipimagewidth').value)&&(parseInt(document.getElementById('tipimagewidth').value)<500)){optiontext=optiontext+"width="+document.getElementById("tipimagewidth").value+"<>";

}else{sysAlert("The width should be a number value less than 500.");

return;

}}

if(!isNullOrEmpty(document.getElementById('tipimageheight').value)){if(isNumber(document.getElementById('tipimageheight').value)&&(parseInt(document.getElementById('tipimageheight').value)<500)){optiontext=optiontext+"height="+document.getElementById("tipimageheight").value+"<>";

}else{sysAlert("The height should be a number value less than 500.");

return;

}}}}

optiontext=optiontext+"|"+document.getElementById('start').value+"|"+document.getElementById('end').value}

applyWikiRule("tip",fieldName,optiontext);

}}}

function processToolImage(fieldName){if(document.getElementById('mdbrainimage').checked&&isNullOrEmpty(document.getElementById('internalimage').value)){sysAlert("Please specify the Image ID for the MDBrain Image.");

return;

}else if(document.getElementById('externalimage').checked&&isNullOrEmpty(document.getElementById('externalimageurl').value)){sysAlert("Please specify the URL of the external image.");

return;

}else{var optiontext="";

if(document.getElementById('mdbrainimage').checked){optiontext=document.getElementById('internalimage').value;

}else{optiontext=document.getElementById('externalimageurl').value;

}

optiontext=optiontext+" | "+document.getElementById('imagecaption').value+" |<>";

if(document.getElementById('externalimage').checked&&!isNullOrEmpty(document.getElementById('imagecredit').value)){optiontext=optiontext+"thanks="+document.getElementById("imagecredit").value+"<>";

}

if(!isNullOrEmpty(document.getElementById('tipImageAlign').value)){optiontext=optiontext+"align="+document.getElementById("tipImageAlign").value+"<>";

}

if(!isNullOrEmpty(document.getElementById('tipimagewidth').value)){if(isNumber(document.getElementById('tipimagewidth').value)&&(parseInt(document.getElementById('tipimagewidth').value)<500)){optiontext=optiontext+"width="+document.getElementById("tipimagewidth").value+"<>";

}else{sysAlert("The width should be a number value less than 500.");

return;

}}

if(!isNullOrEmpty(document.getElementById('tipimageheight').value)){if(isNumber(document.getElementById('tipimageheight').value)&&(parseInt(document.getElementById('tipimageheight').value)<500)){optiontext=optiontext+"height="+document.getElementById("tipimageheight").value+"<>";

}else{sysAlert("The height should be a number value less than 500.");

return;

}}

optiontext=optiontext+" | "+document.getElementById('start').value+" | "+document.getElementById('end').value

applyWikiRule("image",fieldName,optiontext);

}}

function addSearchResultValue(searchValue,fieldName,searchDiv,searchField,searchText){document.getElementById(fieldName).value=searchValue;

document.getElementById(searchField).value=searchText;

elegantHideDiv(searchDiv);

}

function toggleSearchByFieldType(fieldName,searchDivs,hiddenDivs,searchField,requiredMessages,searchTypeField,searchLocation){if(document.getElementById(fieldName).checked){showSearchLayers(searchDivs,hiddenDivs,searchField,requiredMessages);

startInstantSearch(searchField,searchTypeField,searchLocation);

}}

function clearSearch(searchField,resultsValueField,searchDiv,defaultValue){document.getElementById(searchField).value=defaultValue;

document.getElementById(resultsValueField).value="";

elegantHideDiv(searchDiv);

}

function toggleRedirectDivs(){if(document.getElementById('redirectanchor').checked){showTbody('redirecttolabeldiv');

showTbody('anchordiv');

hideTbody('sectiondiv');

}else if(document.getElementById('redirectsection').checked){showTbody('redirecttolabeldiv');

showTbody('sectiondiv');

hideTbody('anchordiv');

}}

function toggleDivs(firstField,firstDiv,secondField,secondDiv){if(document.getElementById(firstField).checked){showTbody(firstDiv);

hideTbody(secondDiv);

}else if(document.getElementById(secondField).checked){showTbody(secondDiv);

hideTbody(firstDiv);

}}

function toggleDivFromField(fieldName,divName){if(document.getElementById(fieldName).checked){showTbody(divName);

}else{hideTbody(divName);

}}

function setSelectedText(sourceField,targetField){if(!isNullOrEmpty(document.getElementById(sourceField).value)){document.getElementById(targetField).value=getInputSelection(targetField).text;

}}

function limitText(limitField,limitCount,limitNum){if(document.getElementById(limitField).value.length>limitNum){document.getElementById(limitField).value=document.getElementById(limitField).value.substring(0,limitNum);

}else{document.getElementById(limitCount).innerHTML=limitNum-document.getElementById(limitField).value.length;

}}

function trim(str){return str.replace(/^\s+|\s+$/g,"");

}

function displayPreviewLink(wikiFieldName){document.getElementById('hasChanged').value='Yes';

document.getElementById('previewChangesDiv').innerHTML="<span style=\"text-decoration:underline;cursor: hand;\" onclick=\"previewWikiChanges('"+wikiFieldName+"');\">Preview Changes</span>";

}

function previewWikiChanges(wikiFieldName){$.post(getBaseURL()+"wiki/previewchanges",{wikitext:document.getElementById(wikiFieldName).value},function(result){wikiPreviewAlert(result);

});

}

function OpenWindowWithPost(url,windowoption,name,params)

{var form=document.createElement("form");

form.setAttribute("method","post");

form.setAttribute("action",url);

form.setAttribute("target",name);

for(var i in params){if(params.hasOwnProperty(i)){var input=document.createElement('input');

input.type='hidden';

input.name=i;

input.value=params[i];

form.appendChild(input);

}}

document.body.appendChild(form);

window.open("",name,windowoption);

form.submit();

document.body.removeChild(form);

}

function wikiPreviewAlert(msg)

{var alertHTML="<table width='100%' padding='10'>"+"<tr>"+"<td width='1%'><img src='"+getBaseURL()+"images/alert.png' border='0' width='40'/></td>"+"<td width='98%' align='left' style='padding-left:10px'><b>"+msg+"</b></td>"+"<td width='1%' valign='top'><div style='float:right;'><a href = \"javascript:actOnLightDiv('wikipreviewdiv', 'wikifadediv', 'close')\"><img src='"+getBaseURL()+"images/delete_icon.png' border='0' class='btn'/></a></div></td>"+"</tr>"+"<tr><td colspan='3' align='center'><br><br><table border='0' cellspacing='0' cellpadding='0' class='btn' onclick=\"javascript:actOnLightDiv('wikipreviewdiv', 'wikifadediv', 'close')\">"+"<tr>"+"<td class='btnleft'><img src='"+getBaseURL()+"images/spacer.gif' width='4' height='1'/></td>"+"<td class='btnmiddle' nowrap>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Close&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>"+"<td class='btnright'><img src='"+getBaseURL()+"images/spacer.gif' width='4' height='1'/></td>"+"</tr>"+"</table></td></tr>"+"</table>";

var boxStyles=[['top','20%'],['left','37%'],['width','60%'],['height','70%']];

if(document.getElementById('wikipreviewdiv')){}else{var lightDiv=document.createElement("div");

lightDiv.setAttribute("id","wikipreviewdiv");

lightDiv.setAttribute("class","wiki_white_content");

for(var i=0;

i<boxStyles.length;

i++){lightDiv.setAttribute(boxStyles[i][0],boxStyles[i][1]);

}

var fadeDiv=document.createElement("div");

fadeDiv.setAttribute("id","wikifadediv");

document.body.appendChild(lightDiv);

}

document.getElementById('wikipreviewdiv').innerHTML=alertHTML;

document.getElementById('wikipreviewdiv').style.display='block';

}

function clearAndAssign(clearList,currentValue,finalValueID)

{clearListArray=clearList.split("|");

for(var i=0;

i<clearListArray.length;

i++)

{$("#"+clearListArray[i]).removeClass();

}

$("#"+currentValue).addClass("lightorangebg");

$("#"+finalValueID).val(currentValue);

}

function pickSearchResult(actionURL,resultDivID,selectedLayerID,resultListDivID)

{if(resultListDivID!='')

{$("#"+resultListDivID+" #"+resultDivID).html('').slideUp('fast');

}

else

{$("#"+resultDivID).html('').slideUp('fast');

}

updateFieldLayer(actionURL,'','',selectedLayerID,'');

}

function actOnCheckBox(fieldID,actionToField)

{if(actionToField=='uncheck')

{document.getElementById(fieldID).checked=false;

}

else if(actionToField=='check')

{document.getElementById(fieldID).checked=true;

}}

function toggleCheckBox(fieldID)

{if(document.getElementById(fieldID).checked==false)

{document.getElementById(fieldID).checked=true;

}

else

{document.getElementById(fieldID).checked=false;

}}

function actOnValue(actionURL,actionLayer,fieldID,actionValue)

{if(document.getElementById(fieldID).value==actionValue)

{setTimeout(function(){updateFieldLayer(actionURL,'','',actionLayer,'');

},1250);

}}

function onlyNumbers(evt)

{var e=event||evt;

var charCode=e.which||e.keyCode;

if(charCode>31&&(charCode<48||charCode>57))

return false;

return true;

}

function swapFieldInputs(textFieldID,checkBoxIDs,hiddenFieldID,theClickedField)

{if(theClickedField=='textfield')

{clearOnActionForGroup(checkBoxIDs);

document.getElementById(hiddenFieldID).value='';

}

else if(theClickedField=='checkbox'||theClickedField=='radio')

{document.getElementById(textFieldID).value='';

}}

function restoreLayerState(layerList,fieldList)

{if(fieldList.length>0){var fieldsArr=fieldList.split("<>");

}else{var fieldsArr=Array();

}

for(var i=0;

i<fieldsArr.length;

i++)

{var fieldIdArray=fieldsArr[i].split("*");

if(fieldIdArray.length==2&&fieldIdArray[1].charAt(0)=="_")

{var instruction=fieldIdArray[1].substr(1,fieldIdArray[1].length);

if(instruction=='CHECK')

{document.getElementById(fieldIdArray[0]).checked=true;

}

else if(instruction=='UNCHECK')

{document.getElementById(fieldIdArray[0]).checked=false;

}}

else if(fieldIdArray.length==2)

{document.getElementById(fieldIdArray[0]).value=fieldIdArray[1];

}

else

{document.getElementById(fieldIdArray[0]).value='';

}}

if(layerList.length>0){var layersArr=layerList.split("<>");

}else{var layersArr=Array();

}

for(var i=0;

i<layersArr.length;

i++)

{var layerIdArray=layersArr[i].split("*");

if(layerIdArray.length==2&&layerIdArray[1]=='SHOW')

{$("#"+layerIdArray[0]).slideDown('fast');

}

else

{$("#"+layerIdArray[0]).slideUp('fast');

}}}

function toggleCellImg(layerID,cellID,expandImageURL,collapseImageURL,titleCell)

{var titleCellTds=titleCell.split('<>');

if(document.getElementById(layerID).style.display=='none')

{document.getElementById(cellID).innerHTML="<img src='"+expandImageURL+"' border='0'/>";

for(var i=0;

i<titleCellTds.length;

i++)

{document.getElementById(titleCellTds[i]).title="Click to view more.";

}}

if(document.getElementById(layerID).style.display=='block')

{document.getElementById(cellID).innerHTML="<img src='"+collapseImageURL+"' border='0'/>";

for(var i=0;

i<titleCellTds.length;

i++)

{document.getElementById(titleCellTds[i]).title="Click to view less.";

}}}

function addOrRemove(spanID,clickAction)

{if($("#"+spanID).length>0)

{var spanValue=document.getElementById(spanID).innerHTML;

if(clickAction=='add')

{document.getElementById(spanID).innerHTML=parseInt(spanValue)+1;

}

if(clickAction=='remove')

{document.getElementById(spanID).innerHTML=parseInt(spanValue)-1;

}}}

$(document).ready(function(){if(!$.browser.opera)

{$('.dropdown select').each(function(){var title=$(this).attr('title');

var selID=$(this).attr('id');

if($('option:selected',this).val()!='')title=$('option:selected',this).text();

$(this).css({'z-index':10,'opacity':0,'-khtml-appearance':'none'}).after('<span id="'+selID+'_span" class="select">'+title+'</span>').change(function(){val=$('option:selected',this).text();

$(this).next().text(val);

})});

$('.dropdown select').each(function(){var selectID=$(this).attr('id');

var drp=document.getElementById(selectID);

$('#'+selectID+'_span').each(function(){$(this).css('width',$('#'+selectID).css('width'));

$(this).html(drp.options[drp.selectedIndex].text);

})});

};

});

$(document).ready(function(){$('.bluronclick').click(function(){$(this).fadeTo('fast',0.4);

$(this).append("<div style='display:inline-block;'><img src='"+getBaseURL()+"images/loading.gif' height='30'></div>");

});

});

function selectAndRefresh(refreshLayer,selectValueField,selectValue)

{document.getElementById(selectValueField).value=selectValue;

absShowDiv(refreshLayer);

}

function generateFollowList(actionURL,childStem,parentHolderID,pageNumberTracker)

{var currentPage=document.getElementById(pageNumberTracker).value;

var nextPage=parseInt(currentPage)+1;

var newLayerId=childStem+nextPage;

$('#'+parentHolderID).append("<div id='"+newLayerId+"'></div>");

$("#"+newLayerId).slideDown('fast');

updateFieldLayer(actionURL+'/p/'+nextPage,'','',newLayerId,'');

document.getElementById(pageNumberTracker).value=nextPage;

var remaingItems=parseInt(document.getElementById(childStem+'remaining_'+currentPage).value);

if(remaingItems<=0)

{document.getElementById(childStem+'navcell').innerHTML='<b>All shown above</b>';

}}

function postAndCheckLayer(URL,fieldIds,layerId,errorMsg,otherLayer)

{var fieldsArray=fieldIds.split('<>');

var allIn="YES";

if(fieldsArray.length>0)

{for(var i=0;

i<fieldsArray.length;

i++)

{if(fieldsArray[i].charAt(0)!="*"){if(!checkEmpty(fieldsArray[i],errorMsg))

{allIn="NO";

break;

}}}}

if(allIn=="YES")

{postToLayer(URL,fieldIds,layerId,errorMsg);

$('#'+otherLayer+'_'+document.getElementById('gender').value).animate({width:'toggle'},350);

}

else

{sysAlert(errorMsg);

}}

function confirmInvitationAction(URL,hideDiv,finalDiv,msgPart)

{var message="Are you sure you want to "+msgPart+"? \n"+"Press OK to "+msgPart+"\n"+"Cancel to stay on the current page";

if(window.confirm(message)){if(hideDiv!='')

{hideLayerSet(hideDiv);

}

if(finalDiv.search('deal')!=-1)

{var id='invuserid';

}

else

{var id='dealid';

}

updateFieldLayer(URL,id,'',finalDiv,'');

}}

function confirmRemoveUserReportAccessAction(URL,hideDiv,finalDiv,msgPart)

{var message="Are you sure you want to "+msgPart+"? \n"+"Press OK to "+msgPart+"\n"+"Cancel to stay on the current page";

if(window.confirm(message)){if(hideDiv!='')

{hideLayerSet(hideDiv);

}

var id='reportid';

updateFieldLayer(URL,id,'',finalDiv,'');

}}

function uncheckCheckboxFields(checkBoxList,fieldList,currentCheckbox)

{var checkElemIDArr=checkBoxList.split(",");

var fieldElemIDArr=fieldList.split(",");

if(checkBoxList!='')

{for(var i=0;

i<checkElemIDArr.length;

i++)

{document.getElementById(checkElemIDArr[i]).checked=false;

}}

if(fieldList!='')

{for(var k=0;

k<fieldElemIDArr.length;

k++)

{document.getElementById(fieldElemIDArr[k]).value='';

}}

if(currentCheckbox!='')

{document.getElementById(currentCheckbox).click();

}}

function str_replace(searchStr,replaceStr,subject,count){var i=0,j=0,temp='',repl='',sl=0,fl=0,f=[].concat(searchStr),r=[].concat(replaceStr),s=subject,ra=Object.prototype.toString.call(r)==='[object Array]',sa=Object.prototype.toString.call(s)==='[object Array]';

s=[].concat(s);

if(count){this.window[count]=0;

}

for(i=0,sl=s.length;

i<sl;

i++){if(s[i]===''){continue;

}

for(j=0,fl=f.length;

j<fl;

j++){temp=s[i]+'';

repl=ra?(r[j]!==undefined?r[j]:''):r[0];

s[i]=(temp).split(f[j]).join(repl);

if(count&&s[i]!==temp){this.window[count]+=(temp.length-s[i].length)/f[j].length;

}}}

return sa?s:s[0];

}

function addCommas(nStr)

{nStr+='';

x=nStr.split('.');

x1=x[0];

x2=x.length>1?'.'+x[1]:'';

var rgx=/(\d+)(\d{3})/;

while(rgx.test(x1)){x1=x1.replace(rgx,'$1'+','+'$2');

}

return x1+x2;

}

function setDefaultValuesOnSelect(selectFieldID,otherFieldID,selectValues,defaultValues)

{var selectValuesArr=selectValues.split("<>");

var defaultValuesArr=defaultValues.split("<>");

var selectFieldValue=document.getElementById(selectFieldID).value;

for(var i=0;

i<selectValuesArr.length;

i++)

{if(selectValuesArr[i]==selectFieldValue)

{if(defaultValuesArr[i]=='_EMPTY_')

{document.getElementById(otherFieldID).value='';

}

else

{document.getElementById(otherFieldID).value=defaultValuesArr[i];

}

break;

}}}

function selectCheckBoxListWithUncheck(checkboxID,checkList,uncheckList,stubStr){var checkIDArr=checkList.split(",");

var uncheckIDArr=uncheckList.split(",");

if(document.getElementById(checkboxID).checked){for(var i=0;

i<checkIDArr.length;

i++){document.getElementById(stubStr+checkIDArr[i]).checked=true;

}}

else

{for(var i=0;

i<uncheckIDArr.length;

i++){document.getElementById(stubStr+uncheckIDArr[i]).checked=false;

}}}



function update_classes(numOfClasses,inputField)

{

	var classStr='';

	

	for(var i=1; i<=numOfClasses; i++)

		if(document.getElementById('class'+i).checked)

			classStr += (classStr=='')? document.getElementById('class'+i).value : '|'+document.getElementById('class'+i).value;

	

	document.getElementById(inputField).value=classStr;

}



function showWithValue(fieldId,divId,wildLayer)

{if(document.getElementById(fieldId).value!='')

{if(wildLayer!='')

{var displayStatus=document.getElementById(wildLayer).style.display;

if(displayStatus=='none')

{absShowDiv(divId);

}

else

{absHideDiv(divId);

}}

else

{absShowDiv(divId);

}

var selectobject=document.getElementById(fieldId);

for(var i=0;

i<selectobject.length;

i++){if(selectobject.options[i].value=='')

{selectobject.options[i].disabled=true;

}}}

else

{absHideDiv(divId);

}}

function clickElement(elementId)

{document.getElementById(elementId).click();

}

function removeHTMLTags(htmlString){if(htmlString){var mydiv=document.createElement("div");

mydiv.innerHTML=htmlString;

if(document.all)

{return mydiv.innerText;

}

else

{return mydiv.textContent;

}}}



var gradeCount=0;

var gradedata=new Array();

function clearGradeSettings()

{

	document.getElementById('max_mark').value='';

	document.getElementById('min_mark').value='';

	document.getElementById('symbol').value='';

	document.getElementById('grade_value').value='';

}





function assignGradeData()

{

	document.getElementById('gradingdetails').value='';

	for(key in gradedata)

	{

		if(gradedata[key]!='')

		{

			if(document.getElementById('gradingdetails').value=='')

			{

				document.getElementById('gradingdetails').value=gradedata[key];

			}

			else

			{

				document.getElementById('gradingdetails').value+='|'+gradedata[key];

			}

		}

	}

}



function getFilledGrades()

{

	var filledKeys=0;

	for(key in gradedata)

	if(gradedata[key]!='')filledKeys++;

	return filledKeys;

}



function removeGrade(fieldId)

{

	gradedata[fieldId]='';

	$('#'+fieldId).remove();

	

	if(!getFilledGrades())

	{

		document.getElementById('grade_details').innerHTML='<tbody><tr><td>No grades have been added</td></tr></tbody>';

	}

	else

	{

		$("#grade_details").find("tr:even:not(:first)").addClass("stripe");

	}

}



function addGrade()

{

	var max_mark=document.getElementById('max_mark').value;

	var min_mark=document.getElementById('min_mark').value;

	var symbol=document.getElementById('symbol').value;

	var grade_value=document.getElementById('grade_value').value;

	

	if(checkEmpty('symbol', 'Please enter the grade symbol e.g D1') && checkEmpty('min_mark', 'Please enter the minimum mark') && checkEmpty('max_mark','Please enter the maximum mark for this grade') && checkEmpty('grade_value','Please enter the grade value')){

		if(isNaN(min_mark))

		{

			alert('Minimum mark should be a number');

			document.getElementById('min_mark').classList.add('fielderror');

		}

		else if(isNaN(max_mark))

		{

			alert('Maximum mark should be a number');

			document.getElementById('max_mark').classList.add('fielderror');

		}

		else if(isNaN(grade_value))

		{

			alert('Grade value should be a number');

			document.getElementById('grade_value').classList.add('fielderror');

		}

		else if(parseInt(max_mark)<=parseInt(min_mark))

		{

			alert('Maximum mark should be greater than minimum mark ');

			document.getElementById('max_mark').classList.add('fielderror');

			document.getElementById('min_mark').classList.add('fielderror');

		}

		else

		{

			if(!getFilledGrades())

			{

				document.getElementById('grade_details').innerHTML='<tr class="listheader"><td>Symbol</td><td>Value</td><td>Min. Mark</td><td>Max. Mark</td><td></td></tr>'+'<tr id="grade'+gradeCount+'"><td>'+document.getElementById('symbol').value+'</td><td>'+document.getElementById('grade_value').value+'</td><td>'+min_mark+'</td><td>'+max_mark+'</td><td><input type="button" value="Remove" onclick="removeGrade(\'grade'+gradeCount+'\')" /></td></tr>';

			

				$("#grade_details").find("tr:even:not(:first)").addClass("stripe");

		

				clearGradeSettings();

		

				gradedata['grade'+gradeCount]=symbol+'^'+min_mark+'^'+max_mark+'^'+grade_value;

		

				gradeCount++;

			}		

			else

			{

				document.getElementById('grade_details').innerHTML+='<tr id="grade'+gradeCount+'"><td>'+document.getElementById('symbol').value+'</td><td>'+document.getElementById('grade_value').value+'</td><td>'+min_mark+'</td><td>'+max_mark+'</td><td><input type="button" value="Remove" onclick="removeGrade(\'grade'+gradeCount+'\')" /></td></tr>';

				

				$("#grade_details").find("tr:even:not(:first)").addClass("stripe");

				clearGradeSettings();

				gradedata['grade'+gradeCount]=symbol+'^'+min_mark+'^'+max_mark+'^'+grade_value;

				gradeCount++;

			}

		}

	}

}



function addRemoveClass(className,elementsToAdd,elementsToRemove)

{elementsToAddArray=elementsToAdd.split('<>');

elementsToRemoveArray=elementsToRemove.split('<>');

if(elementsToAddArray.length>0)

for(i=0;

i<elementsToAddArray.length;

i++)

document.getElementById(elementsToAddArray[i]).classList.add(className);

if(elementsToRemoveArray.length>0)

for(i=0;

i<elementsToRemoveArray.length;

i++)

removeClass(elementsToRemoveArray[i],className);

}



function initStudentMgt(){}

 

function switchActiveMenu(currentMenu)

{

	var curMenu=currentMenu;

	this.switchMenu=function switchMenu(selectedMenu){

		$('#selected_menu table').animate({'left':10},'fast');

		$('#selected_menu table').animate({'left':-400},'fast');

		$('#selected_menu table tbody tr:first td:last').remove();

		$('#selected_menu table .menu_vertical_separator').show();

		var tempMenuItem=(curMenu!='dashboard')?'<a href="javascript:void(0)" onClick="menuController.switchMenu(\''+curMenu+'\')" id="'+curMenu+'"><li id="li_'+curMenu+'"><table id="table_'+curMenu+'">'+document.getElementById('table_'+curMenu).innerHTML+'</table></li></a>':'';

		$('#selected_menu table').remove;

		$('#'+selectedMenu).hide();

		document.getElementById('table_'+selectedMenu).style.position='relative';

		document.getElementById('table_'+selectedMenu).style.left='-200px';

		$('#table_'+selectedMenu+' tbody tr:first td').remove;

		document.getElementById('selected_menu').innerHTML=document.getElementById('li_'+selectedMenu).innerHTML;

		$('#'+selectedMenu).remove();

		$('#selected_menu table .menu_vertical_separator').hide();

		$('#selected_menu table tr').append('<td align="right"><img src="'+getBaseURL()+'images/red_arrow.jpg" /></td>');

		$('#selected_menu table').css('width','100%');

		$('#selected_menu table').animate({'left':0},'fast');

		$('.nav').append(tempMenuItem);

		curMenu=selectedMenu;

		switch(selectedMenu)

		{

			case 'students':

				updateFieldLayer(getBaseURL()+'students/manage_students','','','contentdiv','');

				break;

				

			case 'school_settings':

				updateFieldLayer(getBaseURL()+'schoolsettings/manage_settings','','','contentdiv','');

				break;

			

			case 'gradebook':

				updateFieldLayer(getBaseURL()+'gradebook/manage_gradebook','','','contentdiv','');

				break;

				

			case 'inventory':

				updateFieldLayer(getBaseURL()+'inventory/manage_inventory','','','contentdiv','');

				break;

				

			case 'staff':

				updateFieldLayer(getBaseURL()+'user/manage_users','','','contentdiv','');

				break;

				

			case 'finances':

				updateFieldLayer(getBaseURL()+'finances/manage_finances','','','contentdiv','');

				break;

				

			case 'library':

				updateFieldLayer(getBaseURL()+'library/manage_stock','','','contentdiv','');

				break;

				

			case 'schools':

				updateFieldLayer(getBaseURL()+'admin/manage_schools','','','contentdiv','');

				break;

				

			case 'users':

				updateFieldLayer(getBaseURL()+'admin/manage_users','','','contentdiv','');

				break;

				

			case 'manage_sponsors':

				updateFieldLayer(getBaseURL()+'sponsors/manage_sponsors','','','contentdiv','');

				break;

				

			default:

		}

		window.scroll(window.top, 0);

	}

}


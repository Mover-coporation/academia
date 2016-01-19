
$('#students_summary,#finances_summary,#school_summary,#library_summary').live('click', function(){

    var className = $(this).attr('dit');

    switch(className){

        case 'students':

            $('.students').slideToggle();
            // alert(this.)
            break;
        case 'finances':
            $('.finances').slideToggle();
            break;
        case 'setup':
            $('.setup').slideToggle();
            break;
        case 'library':
            $('.library').slideToggle();
            break;

        //school_summary
    }
});
var acron = 1;
$('.icon').live('click',function(){

    if( acron == 1)
    {
        $(this).find('#imag').html(' <img   src=" '+getBaseURL()+'images/red_down.png">');



        //getBaseURL()

        acron = 0;
    }
    else
    {
        $(this).find('#imag').html(' <img   src=" '+getBaseURL()+'images/red_up.png">');
        acron = 1;
    }



});
/**
 * Created by MOVER on 6/23/14.
 */


// PRINT FUNCTION
function mailed()
{
    $("div#printreport").printArea();
}

// Toggling Header Informatioin on Report
function header()
{
    $('.header').toggle('slow');
    //alert('Hello');
}


//Toggling Footer Information on the Footer ..
function footer()
{
    $('.footer').toggle('slow');
}


// fetching and displaying a given exam in a term using AJAX
function fetchexam(st)
{

    $('#subject').fadeOut('fast');
    if(st.length  ==9 )
    {
        return false;
    }
    if(st == 0)
    {
        return false;
    }
    // AJAX CALL TO THE SERVER
    if(window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    }
    else{		// code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }	xmlhttp.onreadystatechange=function() {

    if(xmlhttp.readyState==4 && xmlhttp.status==200)
    {     var rr = xmlhttp.responseText;

        var subjects  = rr.split('##');
        xx = 0;
        $('#subject').fadeIn('fast');
        $('#subject').find('option').remove();
        $('#subject').append('<option value="" selected="selected">Select Exam </option>');
        if(subjects.length > 0){
            for(xx = 0; xx <subjects.length; xx++)
            {
                //"@@"
                var tt =subjects[xx].split('@@');

                //  alert( terms[xx]);
                ss  =  '<option value="'+ tt[1]+'" selected="selected">' + tt[0] +  '</option>';
                // $('#example').append();
                $('#subject').append(ss);

            }
            $("select#subject").val('0');
        }


        var std  = document.getElementById('std').value;
        updateFieldLayer(getBaseURL()+'students/get_student_academics_exam/exam/'+st+'/i/'+std,'','','academic-content','');
        $('#subject').fadeIn('fast');
    }  }
    xmlhttp.open("GET",getBaseURL()+"students/fetch_subject_ajax/"+st,false);
    xmlhttp.send();


}



// Fetching Subject Performance :: and position of the student ::
function fetchsubjects(st)
{

    var exam  = document.getElementById('term').value;

    if(st.length  ==9 )
    {
        return false;
    }
    if(st == 0)
    {
        return false;
    }
    var std  = document.getElementById('std').value;
    updateFieldLayer(getBaseURL()+'students/get_student_academics_subject/subject/'+st+'@@'+exam+'/i/'+std,'','','academic-content','');

}
// fetching information based on a selected term ::
function fetchinfo(st)
{

    $('#term').fadeOut('fast');
    $('#subject').fadeOut('fast');

    if(st.length  ==9 )
    {
        return false;
    }
    if(st == 0)
    {
        return false;
    }
    // NATIVE AJAX CALL TO THE SERVER
    if(window.XMLHttpRequest)
    {
        xmlhttp = new XMLHttpRequest();
    }
    else{
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }	xmlhttp.onreadystatechange=function() {

    if(xmlhttp.readyState==4 && xmlhttp.status==200)
    {     var rr = xmlhttp.responseText;
        // Adding Information about a Year ::
        //  updateFieldLayer(getBaseURL()+'students/get_student_academics_year/year/'+st+'/i/'+std,'','','academic-content','');
        var terms  = rr.split('##');
        xx = 0;
        $('#term').fadeIn('fast');
        $('#term').find('option').remove();
        $('#term').append('<option value="" selected="selected">Select Exam </option>');
        for(xx = 0; xx <terms.length; xx++)
        {
            //"@@"
            var tt =terms[xx].split('@@');

            //  alert( terms[xx]);
            ss  =  '<option value="'+ tt[1]+'" selected="selected">' + tt[0] +  '</option>';
            // $('#example').append();
            $('#term').append(ss);

        }

        $("select#term").val('0');
        var std  = document.getElementById('std').value;
        updateFieldLayer(getBaseURL()+'students/get_student_academics/term/'+st+'/i/'+std,'','','academic-content','');

    }  }
    xmlhttp.open("GET",getBaseURL()+"students/fetch_exams_ajax/"+st,false);
    xmlhttp.send();


}


// Fetching terms based on Year ID and Schol Id.
/*
 * YearID and School ID  make the algorithm ~ mover
 * */

function fetchTerms(yearid)
{
    /*
     Sends Year ID to the   fetch  the terms and populate the terms menu.

     */
    $('#xterms').fadeOut('fast');
    $('#term').fadeOut('fast');
    $('#subject').fadeOut('fast');
    if(yearid == 0)
    {
        return false;
    }
    if(window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    }
    else{		// code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }	xmlhttp.onreadystatechange=function() {

    if(xmlhttp.readyState==4 && xmlhttp.status==200)
    {
        var rr = xmlhttp.responseText;
        // Adding Information about a Year ::
        var terms  = rr.split('##');
        xx = 0;
        if(terms.length > 0)
        {
            $('#xterms').fadeIn('fast');
            $('#xterms').find('option').remove();
            $('#xterms').append('<option value="" selected="selected">Select Term </option>');
            for(xx = 0; xx <terms.length; xx++)
            {

                var tt =terms[xx].split('@@');
                ss  =  '<option value="'+ tt[1]+'" selected="selected">' + tt[0] +  '</option>';
                $('#xterms').append(ss);

            }
            $("select#xterms").val('0');
        }
        var std  = document.getElementById('std').value;

        updateFieldLayer(getBaseURL()+'students/get_student_academics_years/year/'+yearid+'/i/'+std,'','','academic-content','');


    }  }
    xmlhttp.open("GET",getBaseURL()+"students/fetch_terms_ajax/"+yearid,false);
    xmlhttp.send();

}

// Initialize the Drop Down

/*
 * END
 */
/* Make Me Fancy */
$(document).ready(function(){

    // The select element to be replaced:
    var select = $('select.makeMeFancy');

    var selectBoxContainer = $('<div>',{
        width		: select.outerWidth(),
        className	: 'tzSelect',
        html		: '<div class="selectBox"></div>'
    });

    var dropDown = $('<ul>',{className:'dropDown'});
    var selectBox = selectBoxContainer.find('.selectBox');

    // Looping though the options of the original select element

    select.find('option').each(function(i){
        var option = $(this);

        if(i==select.attr('selectedIndex')){
            selectBox.html(option.text());
        }

        // As of jQuery 1.4.3 we can access HTML5
        // data attributes with the data() method.

        if(option.data('skip')){
            return true;
        }

        // Creating a dropdown item according to the
        // data-icon and data-html-text HTML5 attributes:

        var li = $('<li>',{
            html:	'<span>'+
                option.data('html-text')+'</span>'
        });

        li.click(function(){

            selectBox.html(option.text());
            dropDown.trigger('hide');

            // When a click occurs, we are also reflecting
            // the change on the original select element:
            select.val(option.val());

            return false;
        });

        dropDown.append(li);
    });

    selectBoxContainer.append(dropDown.hide());
    select.hide().after(selectBoxContainer);

    // Binding custom show and hide events on the dropDown:

    dropDown.bind('show',function(){

        if(dropDown.is(':animated')){
            return false;
        }

        selectBox.addClass('expanded');
        dropDown.slideDown();

    }).bind('hide',function(){

            if(dropDown.is(':animated')){
                return false;
            }

            selectBox.removeClass('expanded');
            dropDown.slideUp();

        }).bind('toggle',function(){
            if(selectBox.hasClass('expanded')){
                dropDown.trigger('hide');
            }
            else dropDown.trigger('show');
        });

    selectBox.click(function(){
        dropDown.trigger('toggle');
        return false;
    });


    $(document).click(function(){
        dropDown.trigger('hide');
    });
});


//FUNCTION TO  VALIDATE CREDIT FORM ON SUBMIT EVENT
$('#form1').on('submit', function(e){

    // FETCH INFORMATION  FROM THE FORM
    notes = $('#notes').val();
    frequency  = $('#frequency').val();
    voucher  = $('#voucher').val();
    payer  = $('#payer').val();
    amount = $('#amount').val();
    student = $('#studenta').val();

    if((notes.length <1 )||(notes.length<1)||(notes.length<1)||(notes.length<1)||(amount.length<1))
    {
        sysAlert('Fill Blanks'); return false;
    }

    if(isNaN(amount))
    {
        sysAlert('Enter Number for Amount'); return false;
    }
    //UPDATE LAYER
    updateFieldLayer(getBaseURL()+'students/get_student_finances/i/'+student,'','','results','');

    //CLOSE FANCY BOX AND ALERT
    $('.fancybox-overlay').fadeOut('fast');
    sysAlert('Record Saved');



});

// Search Stdent Financial Statement in Real Time
function searchfinancial_statment(st)
{
    // Get Information from Search box and Date Pickers
    var search = document.getElementById('financial_search').value;
    var startdate = document.getElementById('startdate').value;
    var enddate  = document.getElementById('enddate').value;
    if((search.length <=  1) && (startdate.length <=  1 )  && (enddate <=  1 ))
        return false;

    //GENERATE SEARCH QUERY
    search_query = st+"@@"+search+"@@"+startdate+"@@"+enddate;

    //UPDATE LAYER
    updateFieldLayer(getBaseURL()+'students/get_student_finances_search/i/'+search_query,'','','result','');

}

// registration javascript

/*
THIS DOCUMENT IS MEANT TO HANDLE REGISTRATION LEVELS ON THE SYSTEM
*/
$(function(){
	
	
	
 alerts = (function(){
		 var alertme = {};
		 
		 // Show Alert 
		 alertme.show = function(msg) {
			 alert(msg);
			// $(".alert").html(msg).fadeIn('slow');
		 }
		 
		 // Hide Alert
		 alertme.hide = function(msg) {
			 $(".alert").html(msg).fadeOut('slow');
		 }
		 
		 
}(cm));

validate = (function(){
		 var validate = {};
		 
		 	//validate phone
			validate.validatephone = function(inputtxt){
				var testPhoneNumber = inputtxt; // Typical Ugandan Mobile Minus phone number
				var phn = testPhoneNumber.replace(/\s/g,'');
				var testPattern = /[0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9]/;
				if(testPhoneNumber.length == 10){
				return( testPattern.test(phn) );
				}
				else
				{
					return false;
				}
		}
			
			
			 //validate email address
			validate.validateemail = function(inputtxt){
				
				 
					var str= inputtxt;
					var filter=/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
					if (filter.test(str))
					return true
					else{
					return false
					}
			}
			
			 // VALIDATE WEB URL
		validate.validateweb = function(inputtxt){
				var message;
				var myRegExp =/^(?:\S+(?::\S*)?@)?(?:(?!10(?:\.\d{1,3}){3})(?!127(?:\.\d{1,3}){3})(?!169\.254(?:\.\d{1,3}){2})(?!192\.168(?:\.\d{1,3}){2})(?!172\.(?:1[6-9]|2\d|3[0-1])(?:\.\d{1,3}){2})(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:\.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(?:\.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z\u00a1-\uffff0-9]+-?)*[a-z\u00a1-\uffff0-9]+)(?:\.(?:[a-z\u00a1-\uffff0-9]+-?)*[a-z\u00a1-\uffff0-9]+)*(?:\.(?:[a-z\u00a1-\uffff]{2,})))(?::\d{2,5})?(?:\/[^\s]*)?$/i;
				var urlToValidate = inputtxt;
				if (!myRegExp.test(urlToValidate)){
				return false;
				}else{
				return true;
				}
	
		}
		
		
   validate.isNumber= function(input){
    var RE = /^-{0,1}\d*\.{0,1}\d+$/;
    return (RE.test(input));
}

return validate
	
}());

 var cm = (function(){
	
	 var login = {};
			 
			
			/* SET GET NAME */
			login.setName =  function(){}
			
			login.getName = function(){
			 
			}
			
			/* SET GET EMAIL */
			login.setEmail = function(){}
			function getEmail(){}
			
			/*  SET GET USERNAME*/
			login.setUsername = function(){}
			login.getUseranem = function(){}
			
			/* SET GET PASSWORD  */
		    login.setPassword = function(){}
		    login.getPassword = function(){}
			
			return login;
	
	}(alerts,validate));


	
 
		//
	  $(".simple_form").submit(function (e) {
     
       
	   //Form action :: 
       var form = this;
       var formid = form.id;
       var datatype = $("#"+formid).attr('data-type');
       var dataaction =   $("#"+formid).attr('data-action');
       var dataelements =   $("#"+formid).attr('data-elements');
       console.log(dataelements);
       var serversidecheckss =  $("#"+formid).attr('data-cheks');
         //the url where you are going to use for server side checks on data
       var datacheckaction =  $("#"+formid).attr('data-check-action');
       var datacomp =  $("#"+formid).attr('datacompare');

       url = dataaction;
       console.log(dataelements);

           if(dataelements.length > 0)
            {
                var fieldNameArr=dataelements.split("<>");
            }
            else
            {
                fieldNameArr = Array();
            }

             var elementfield  ='';
             var formdata = {};
             var commitcheckdata = {};
             

             if((dataelements!= ' ') &&(dataelements.length > 0))
            {
                for(var i=0;i<fieldNameArr.length;i++)
                 {

                    //CHECK TO SEE IF ELEMEMENTS ARE REQUIRED
                     var lke = fieldNameArr[i].split("*");
                      elementfield = lke[1];
                      // alert(elementfield);

                     console.log(elementfield);
                         formvalue = $("#"+elementfield).val();
                         if(fieldNameArr[i].charAt(0)=="*"){
                          if(formvalue.length <= 0)
                          {
							   e.preventDefault();
                          	  alert('Fill Blanks');
                              return false;
                          }
                      }

                        else
                        {
                            elementfield = fieldNameArr[i];
                            formvalue = $("#"+elementfield).val();
                        }

                   var datatype =  $("#"+elementfield).attr('datatype');


                    switch(datatype)
                    {
                        case 'text':
                        break;
                        case 'tel':

                        if(formvalue.length > 0)
                        {
                        var valu = validate.validatephone(formvalue);
                        if(valu == false)
                        {
							  e.preventDefault();
                            alert('Invalid Phone, Digits are allowed, Not More than 10 digits'); return false;
                        }


                        }
                        break;
                        case 'web':

                        if(formvalue.length > 0)
                        {
							
                        var valu = validate.validateweb(formvalue);
                        if(valu == false)
                        {
							  e.preventDefault();
                             alert('Invalid Web Url '); return false;
                        }

                        }
                        break;
                        case 'email':
						
						$("#"+elementfield).css('border', 'none');
 						$("#"+elementfield).css('border-bottom', ' solid 1px #636363');
						
                        if(formvalue.length > 0)
                        {
                            var valu = validate.validateemail(formvalue);
                            if(valu == false)
                            {
								  e.preventDefault();
								 $("#"+elementfield).css('border', 'solid 3px #FFE79B');

                                alert('Invalid Email Address'); return false;
                            }


                        }
                        break;
                        case 'phone':
                        if(formvalue.length > 0)
                        {
							
                        var valu = validate.validatephone(formvalue);
							$("#"+elementfield).css('border', 'none');
 						$("#"+elementfield).css('border-bottom', ' solid 1px #636363');
					
                        if(valu == false)
                        {
							  e.preventDefault();
                            alert('Invalid Phone, Digits are allowed, Not More than 10 digits'); return false;
							
							 $("#"+elementfield).css('border', 'solid 3px #FFE79B');
                        }

                        }
                        break;

            case 'money':
              if(formvalue.length > 0)
                        {
             
                        var valu = validate.isNumber(formvalue);          
                        if(valu == false)
                        {
							  e.preventDefault();
                            alert('Invalid Entry, Enter Digits');
						  $("#"+elementfield).css('border', 'solid 3px #FFE79B');
						  return false;
                        }
            }

            break;
             case 'numeric':


            break;
                        default:
                        break;
                    }

                    // ADDING ELEMETNTS TO THE FORM
                    formdata[elementfield] =formvalue;
                     }
                    console.log(formdata);
            }
			
			console.log("DATA PASSED  <BR/>");
			console.log(formdata);
			
			
			//Ajax Submition 
			 console.log(url);
   

 
  });
  
	});
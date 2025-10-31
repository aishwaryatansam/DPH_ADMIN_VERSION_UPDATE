/*
Template Name: Material Pro admin
Author: Wrappixel
Email: niravjoshi87@gmail.com
File: js
*/

 

$(function() {
    "use strict";

    toastr.options = {
      "closeButton": false,
      "debug": false,
      "newestOnTop": false,
      "progressBar": false,
      "positionClass": "toast-top-right",
      "preventDuplicates": false,
      "onclick": null,
      "showDuration": "300",
      "hideDuration": "1000",
      "timeOut": "5000",
      "extendedTimeOut": "1000",
      "showEasing": "swing",
      "hideEasing": "linear",
      "showMethod": "fadeIn",
      "hideMethod": "fadeOut"
    }

    $('.__success').click(function(){
    	
    	var message = ($(this).attr('data-toast'))?$(this).attr('data-toast'):'Request Successfull !';
    	success(message);
    });
    $('.__error').click(function(){
    	var message = ($(this).attr('data-toast'))?$(this).attr('data-toast'):'Something went wrong !';
    	error(message);
    });
    $('.__info').click(function(){
    	var message = ($(this).attr('data-toast'))?$(this).attr('data-toast'):'Empty information !';
    	info(message);
    });
    $('.__warning').click(function(){
    	var message = ($(this).attr('data-toast'))?$(this).attr('data-toast'):'Process interupted !';
    	warning(message);
    });

});
          

function success(message = '',heading='Success') {
	
		toastr.success(message);
}

function error(message = '',heading='Oops!') {
	    
        toastr.error(message);
		
}

function info(message = '',heading='Information') {
	
		toastr.info(message);
}


function warning(message = '', heading='Warning !') {
	
		toastr.warning(message);
}

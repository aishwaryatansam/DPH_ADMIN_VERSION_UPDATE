function token(){
return $('meta[name="csrf-token"]').attr('content');
}
function feedUrl(url=''){
	var base_url = $('meta[name="base-url"]').attr('content');
	if(url) {
		return base_url+url;
	}
	return base_url;
}


$("#register-form").validate({
		rules: {
			name: {
				required:true,
				minlength:2,
				maxlength:50
			},
			email: {
				required: false,
				email: true
			},
			contact_number:{
				required: true,
				digits: true,
				minlength:10,
				maxlength:10,
				remote:triggerOtp()
			},
			otp : {
				required:true,
				digits:true,
				minlength:4,
				maxlength:4,
				remote:validateOtp()
			},
			address_line_1:{
				required:true,
				minlength:1,
				maxlength:50
			},
			address_line_2:{
				required:false,
				minlength:1,
				maxlength:50
			},
			city:{
				required:true,
				minlength:1,
				maxlength:50
			},
			pincode:{
				required:true,
				digits:true,
				minlength:6,
				maxlength:7
			},
			otpVerified:{
				required:true
			}
		},
		messages: {
			name: "Please enter your name",
			email: "Please enter a valid email address",
			contact_number: "Please enter a valid mobile number",
			otp: "Please enter a valid OTP",
			address_line_1: "Please enter a valid address line 1",
			address_line_2: "Please enter a valid address line 2",
			city: "Please enter a valid city name",
			pincode: "Please enter a valid pincode",
			otpVerified: "Please enter a valid pincode",
		},
		errorPlacement: function (error, element) {
		    error.insertAfter(element.parent('div'));
		},
		submitHandler: function(form) {
		    registerForm();
		}
	});

$(document).on('keyup','#contact_number', function(){
	var contactNumber = $(this).val();
	if(contactNumber.length == 10) {
		$("#opt").val('');
		triggerOtp();
	}
});

$(document).on('keyup','#otp', function(){
	var otp = $(this).val();
	if(otp.length == 4) {
		if($("#contact_number").val().length == 10) {
			validateOtp();
		} else {
			warning("Please Enter Valid Mobile Number");
		}
	}
});

$(document).on('click','.openRegisterModal',function() {
	$('.close').click();
});

$(document).on('click','.openLoginModal',function() {
	$('.close').click();

});

function triggerOtp() {

	var contactNumber = $("#contact_number").val();

	if(typeof contactNumber == "undefined" || contactNumber.length < 10) {
		return false;
	}
	var formData = {
		_token:token(),
		contactNumber:contactNumber
	};

	$.ajax({
        method:"POST",
        url: feedUrl('/trigger-otp'),
        data: formData,
        success: function( data ) {
        	if(data.status == 1) {
        		success( data.message );
        	}

			if(data.status == 0) {
        		warning( data.message );
        	}

        }
    });
}

function validateOtp() {

	var contactNumber = $("#contact_number").val();
	var otp = $("#otp").val();

	if(typeof contactNumber == "undefined" || contactNumber.length < 10) {
		return false;
	}
	if(typeof otp == "undefined" || otp.length < 4) {
		return false;
	}
	var formData = {
		_token:token(),
		contactNumber:contactNumber,
		otp:otp
	};
	$.ajax({
        type: "POST",
        url: feedUrl('/validate-otp'),
        data: formData,
        success: function( data ) {
            success( data.message );
            $("#contact_number").attr('disable',true);
            $("#otp").attr('disable',true);
            $("#otpVerified").val(token());
        }
    });
}

function registerForm() {

	var formData = {
		_token:$("#otpVerified").val(),
		name : $("#name").val(),
		contact_number : $("#contact_number").val(),
		otp : $("#otp").val(),
		email : $("#email").val(),
		address_line_1 : $("#address_line_1").val(),
		address_line_2 : $("#address_line_2").val(),
		city : $("#city").val(),
		pincode : $("#pincode").val(),
	};
	$.ajax({
        type: "POST",
        url: feedUrl('/register-user'),
        data: formData,
        success: function( data ) {
					// $('#register-modal').modal('toggle');
			if( data.message ) {
				location.reload();
			} else {
				$('#errors').empty().append( data );
			}
        }
    });
}

$("#login-form").validate({
		rules: {
			contact_number:{
				required: true,
				digits: true,
				minlength:10,
				maxlength:10,
			}
		},
		messages: {
			contact_number: "Please enter a valid mobile number",
		},
		errorPlacement: function (error, element) {
		    error.insertAfter(element.parent('div'));
		},
		submitHandler: function(form) {
		    loginForm();
				//$( "#login-form" ).submit();
		}
});

function loginForm() {
	var formData = {
		_token:$("#_token").val(),
		contact_number : $("#inputEmail").val(),
	};
	$.ajax({
				type: "POST",
				url: feedUrl('/customer/login'),
				data: formData,
				success: function( data ) {					
					info(data.message);
					if(data.errors) {
						$('#errors').empty().append( data.errors.error_view );
					} else {
						location.reload();	
					}						
				}
		});
}

$("#add-address").validate({
		rules: {
			address_line_1:{
				required:true,
				minlength:1,
				maxlength:50
			},
			address_line_2:{
				required:false,
				minlength:1,
				maxlength:50
			},
			city:{
				required:true,
				minlength:1,
				maxlength:50
			},
			pincode:{
				required:true,
				digits:true,
				minlength:6,
				maxlength:7
			},
			otpVerified:{
				required:true
			}
		},
		messages: {
			address_line_1: "Please enter a valid address line 1",
			address_line_2: "Please enter a valid address line 2",
			city: "Please enter a valid city name",
			pincode: "Please enter a valid pincode",
		},
		errorPlacement: function (error, element) {
		    error.insertAfter(element.parent('div'));
		},
		submitHandler: function(form) {
		    $("#add-address-form").submit();
		}
});

$(document).on('click','.addresses-item',function() {

	$('.addresses-item').removeClass('border-success');
	$('.deliver-here').removeClass('btn-success');

	$(this).addClass('border-success');
	$(this).find('.deliver-here').addClass('btn-success');

	var deliverTo = $(this).find('.deliver_to').val();
	$('#delivery_address_id').val(deliverTo);

});


function updateItemToCart(itemId,sessionId,processType=1){

	var formData = {
		_token:token(),
		itemId : itemId,
		sessionId : sessionId,
		processType:processType
	};

	$.ajax({
        type: "POST",
        url: feedUrl('/update-cart'),
        data: formData,
        success: function( data ) {
        	if(data.status == 1){
        		success(data.message);        		
        	} else if(data.status == 2){
        		warning(data.message);
        	} else if(data.status == 3){
        		info(data.message);
        	}	else {
        		error(data.message);
        	}
			refreshCart();
        }
    });

}

function refreshCart() {

	var formData = {
		_token:token(),
	};

	$.ajax({
        type: "POST",
        url: feedUrl('/refresh-cart'),
        data: formData,
        success: function( data ) {
			$(".dropdown-cart").empty().append(data.layoutCartview);
			$("#home-cart").empty().append(data.homeCartview);
        }
    });
}

$(document).on('click','.dec',function(){
	var currentValue =  $(this).closest('span').find('.count-number-input').val();
	$(this).closest('span').find('.count-number-input').val(parseInt(currentValue)-1);
	$(this).closest('span').find('.inc').attr("disabled",false);

	if(currentValue <= 1 ) {
		$(this).attr("disabled",true);
	}
});

$(document).on('click','.inc',function(){
	var currentValue =  $(this).closest('span').find('.count-number-input').val();
	$(this).closest('span').find('.count-number-input').val(parseInt(currentValue)+1);
	$(this).closest('span').find('.dec').attr("disabled",false);
	if(currentValue >= 100 ) {
	$(this).attr("disabled",true);
	}
});

$(document).on('click','.payment_method',function(){
	var payment_method = $(this).attr('data-method');
	$('.payment_method').removeClass('active');
	$(this).addClass('active');
	$("#payment_method").val(payment_method);	
});






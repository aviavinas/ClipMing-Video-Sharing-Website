$(function(){
    "use strict";
	var sec1 = {email : 0, pass : 0, rpass : 0, total : 0};
	var sec2 = {fname : 0, lname : 0, gen : 0, dob : 0, phone : 0, total : 0};
	
	
	// var sec3 = {terms : 0, total : 0};
	
	$('#signup-sbmt').prop('disabled', true);
	$('#signup-sbmt').css('cursor', 'not-allowed');
			  
	// Constructor
	$(".fa-exclamation-circle").hide();
	$(".fa-check-circle").hide();
	
	// Go Next Function
	$("#goNext").click(function(){
		var new_email;
		if((new_email = $("#n-ml").val())!=="") {
			
			$("#reg-frm").hide(500);
			$("#login-frm").hide(500);
			$(".signUp-exp").show(500);
			$(".sec1 h2").css("color", "#1976D2");
			$(".sec1 h2").css("margin-right", "0");
			$("#r_email").val(new_email);
		}
    });
	$("#goLogin").click(function(){
		$(".signUp-exp").hide(500);
		$("#reg-frm").show(500);
		$("#login-frm").show(500);
	});
	
	// Login Button Handler
	$("#login-sbmt").click(function(){
		
		if($("#o-ml").val()==="") {
			$(this).off();
		}
    });
	
// -- SignUp Expanded page Handler  -------------------------------------------------------
	
	$("input[type=email]").on('input',function() {
		var email = $(this).val();
		checkMail(this,email);
	});
	
	// Strength.Js Initializer
	$("#r_pass").on('input',function() {
		strength('#r_pass');
	});
	
	// Check Confirm Password
	$("#r_rpass").on('input',function(e) {
		var pass = $("#r_pass").val();
		var rpass = $("#r_rpass").val();
		 if(pass == rpass) {
			 $(this).removeClass();
			 $(this).addClass('strong');
			 sec1.rpass = 1;
		 }
		 else {
			 $(this).removeClass();
			 $(this).addClass('veryweak');
			 sec1.rpass = 0;
		 }
	});
	
	// Jump to next Section
	  // To Sec2
	$('#r_email, #r_pass, #r_rpass').on('input', function() {
	
		checkMail(this,$("#r_email").val());
	  
		sec1.total = sec1.email + sec1.pass + sec1.rpass;
			if(sec1.total == 3) {
			  switchToSec("sec2","sec1");
		  }
	});
	
	
	// To Sec3
	$("#r_fn, #r_ln, #r_gM, #r_gF, #form_dob_day, #form_dob_month, #form_dob_year, #r_ph").on('input change', function()      {
		  
		  validateSec2();
		  sec2.total = sec2.fname + sec2.lname + sec2.gen + sec2.dob + sec2.phone;
		  if(sec2.total == 5) {
			  switchToSec("sec3","sec3");
		  }
		  
		  if((sec1.total + sec2.total)==8) {
			  $('#signup-sbmt').prop('disabled', false);
			  $('#signup-sbmt').css('cursor', 'pointer');
		  }
		  else {
			  $('#signup-sbmt').prop('disabled', true);
			  $('#signup-sbmt').css('cursor', 'not-allowed');
		  }
		  

	  });
	
function strength(id) {
   
	  var characters = 0;
	  var capitalletters = 0;
	  var loweletters = 0;
	  var number = 0;
	  var special = 0;

	  var upperCase= new RegExp('[A-Z]');
	  var lowerCase= new RegExp('[a-z]');
	  var numbers = new RegExp('[0-9]');
	  var specialchars = new RegExp('([!,%,&,@,#,$,^,*,?,_,~])');
	  
	  check_strength(id);
	  
	  function get_total(total,thisid){

		  var thismeter = $(thisid), err_msg = $("#err_msg");
		  if(total == 0){
				thismeter.removeClass(); 
				err_msg.html('');
				sec1.pass = 0;
		  }else if (total <= 1) {
			 thismeter.removeClass();
			 thismeter.addClass('veryweak');
			 err_msg.html('very weak');
			 err_msg.css("color","#e53935");
			 sec1.pass = 0;
		  } else if (total == 2){
			  thismeter.removeClass();
			 thismeter.addClass('weak');
			 err_msg.html('weak');
			 err_msg.css("color","#e57373");
			 sec1.pass = 0;
		  } else if(total == 3){
			  thismeter.removeClass();
			 thismeter.addClass('medium');
			 err_msg.html('medium');
			 err_msg.css("color","#ff9800");
			 sec1.pass = 0;
		  } else {
			 thismeter.removeClass();
			 thismeter.addClass('strong');
			 err_msg.html('strong');
			 err_msg.css("color","#4CAF50");
			 sec1.pass = 1;
		  } 
	  }

	  function check_strength(thisid){
		  var thisval = $(thisid).val();
		  if (thisval.length > 8) { characters = 1; } else { characters = 0; }
		  if (thisval.match(upperCase)) { capitalletters = 1;} else { capitalletters = 0; }
		  if (thisval.match(lowerCase)) { loweletters = 1;}  else { loweletters = 0; }
		  if (thisval.match(numbers)) { number = 1;}  else { number = 0; }

		  var total = characters + capitalletters + loweletters + number + special;
		  
		  get_total(total,thisid);
	  }

} // ------ End of strength()

function checkMail(e,email) {
  
  $(e).css("border","2px solid red");
  var testEmail = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
  var id = $(e).attr("id");
  if (testEmail.test(email)) {
		 $(e).next().hide();
		 sec1.email = 1;
		  if(id==="n-ml") {
			  $(e).css("border","1px solid #4caf50");
			  $('#goNext').prop('disabled', false);
			  $('#goNext').css('cursor', 'pointer');
		  }
		  else if(id==="o-ml") {
			  $(e).css("border","1px solid #00bcd4");
			  $('#login-sbmt').prop('disabled', false);
			  $('#login-sbmt').css('cursor', 'pointer');
		  }
	}
	else 
	{
		  $(e).next().show();
		  sec1.email = 0;
		  if(id==="n-ml") {
				$('#goNext').prop('disabled', true);
				$('#goNext').css('cursor', 'not-allowed');
			}
		  else if(id==="o-ml") {
			  $('#login-sbmt').prop('disabled', true);
			  $('#login-sbmt').css('cursor', 'not-allowed');
		  }
		  
	}
} // ------ End of checkMail()

function validateSec2() {
	// Name Verification
	var fName = $("#r_fn").val();
	var lName = $("#r_ln").val();
	 
	  validateName(fName,0);
	  validateName(lName,1);
	  validateGen();
	  validateDob();
	  validatePhone();
	  
	 function validateName(name,mode) {
		  if (name.match('^[a-zA-Z]{3,16}$') ) {
				  if(mode==0) {
					  sec2.fname = 1;
					  $('#ex-fn').hide();
				  }
				  else {
					  sec2.lname = 1;
					  $('#ex-ln').hide();
				  }
		  } else {
				  if(mode==0) {
					  sec2.fname = 0;
					  $('#ex-fn').show();
				  }
				  else {
					  sec2.lname = 0;
					  $('#ex-ln').show();
				  }
		  }
	 }
	 
	 function validateGen() {
		 var gen = $("input[name='gen']:checked"). val();
		 if(gen=='M' || gen=='F') {
			 sec2.gen = 1;
			 $('#ex-gn').hide();
		 }
		 else {
			 sec2.gen = 0;
			 $('#ex-gn').show();
		 }
	 }
	 
	 function validateDob() {
		 var dd = $("#form_dob_day").val();
		 var mm = $("#form_dob_month").val();
		 var yy = $("#form_dob_year").val();
		 
		 if(dd =="-" || mm =="-" || yy =="-") {
			 sec2.dob = 0;
			 $('#ex-db').show();
		 }
		 else {
			 sec2.dob = 1;
			 $('#ex-db').hide();
		 }
	 }
	 
	 function validatePhone() {
		  var ph = $("#r_ph").val();
		  var filter = /^[0-9+]+$/;
		  if (filter.test(ph) && ((ph.length>9) && (ph.length<=16))) {
			  sec2.phone = 1;
			 $('#ex-ph').hide();
		  }
		  else {
			  sec2.phone = 0;
			 $('#ex-ph').show();
		  }
	 }
} // ------ End of verifySec2()


function switchToSec(element,scrollTargetId) {
	
	$('html, body').animate({
        scrollTop: $("#"+scrollTargetId).offset().top
    }, 1000);
	
	$("."+element+" h2").css("color", "#1976D2");
	$("."+element+" h2").css("margin-right", "0");
} 

});

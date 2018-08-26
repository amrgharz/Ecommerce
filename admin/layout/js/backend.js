console.log("hey")
$(function(){

	$('[placeholder]').focus(function (){

		$(this).attr('data-text' , $(this).attr('placeholder'));

		$(this).attr('placeholder', '');

	}).blur(function(){

		$(this).attr('placeholder' , $(this).attr('data-text'));
	});

	// Add Asterisk when the field is required

	$('input').each(function(){

		if($(this).attr('required') === 'required'){

			$(this).after('<span class="astrisk">*</span>');
		}
	
	});

	//  Show password on hover 

	var password= $('.password');

	$('.show-pass').hover(function(){

		password.attr("type" , "text");
	},function(){

		password.attr("type" , 'password');
	});

	//Confirmation message on deletion 

	$('.confirm').click(function(){

		return confirm("Are You Sure");
	})

});


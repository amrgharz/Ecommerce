console.log("hey")
$(function(){
	//dashboard
	$('.toggle-info').click(function(){
		$(this).toggleClass('selected').parents().next('.panel-body').fadeToggle(1000);
		if($(this).hasClass('selected')){
			$(this).html('<i class="fa fa-minus fa-lg"></i>');
		}else{
			$(this).html('<i class="fa fa-plus fa-lg"></i>');
		}
	});

	// Switch Between Login and SignUp

	$('.login-page h1 span').click(function(){
		$(this).addClass('selected').siblings().removeClass('selected');
		$('.login-page form').hide();
		$('.' + $(this).data('class')).fadeIn(100);
	});

	//Trigger The selectBox method
	$("select").selectBoxIt({
		autoWidth: false
	});

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


	//Confirmation message on deletion 

	$('.confirm').click(function(){

		return confirm("Are You Sure");
	});
});


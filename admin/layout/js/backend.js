console.log("hey")
$(function(){
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
	});
	//category view option'

	$('.cat h3').click(function(){
		$(this).next('.full-view').fadeToggle(500);
	});

	$('.option span').click(function(){
		$(this).addClass('active').siblings('span').removeClass('active');

		if($(this).data('view') === 'full'){

			$('.cat .full-view').fadeIn(300);
		}else{
			$('.cat .full-view').fadeOut(300);
		}
	});

	
});


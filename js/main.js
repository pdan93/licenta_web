(function ($) {
	
	/*============== JS FILE ACTIVE ===============*/
	/*-----------------------------------------
	[1. jQuery Mobilemenu ]
	[2. Bootstrap Tabs ]
	[3. ScrollUp ]
	[4. Google Map ]
	--------------------------------------------*/
	/*---------------------
	 [1. jQuery Mobilemenu ]
	--------------------- */
		jQuery('nav#dropdown').meanmenu();
		
	/*---------------------
	[2. Bootstrap Tabs ]
	--------------------- */
	$('#myTabs a').on('click',function (e) {
		e.preventDefault()
		$(this).tab('show')
	});
	/*-------------------
	[3. ScrollUp ]
	---------------------*/
	$.scrollUp({
		animation: 'slide', // Fade, slide, none
		scrollSpeed: 1500,
		scrollText: [
		  "<i class='fa fa-chevron-up'></i>"
		]
	});
	
})(jQuery);

function add_to_cart(id) {
    $.post('add_to_cart.php',{id_product:id});
    var nr = parseInt($('.shop_icon span').text());
    $('.shop_icon span').text((nr+1));
    $('.message').html("Added to cart");
}

function first_login() {
    $('.message').html("You must login first");
}

function CheckCard() {
    var ok=1;
    if ($('input[name=card_name]').val()!='' || $('input[name=card_number]').val()!='' || $('input[name=card_ccc]').val()!='')
        {
        ok=0;
        }
    if ($('select[name=card_type]').val()=='-' || $('select[name=card_exp_m]').val()=='-' || $('select[name=card_exp_y]').val()=='-')
        {
        ok=0;
        }
    if (ok==0)
        $('#message1').html('Please complete all fields');
        else
        {
        $('#message1').html('');
        $('.panel h4 a:last').click()
        }
}

function checkout() {
    $('#accordion').submit();
}
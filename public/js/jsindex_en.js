var $win = $(window);
$win.scroll(function () {
	if ($win.scrollTop() > 45) {
		$(".js-header").addClass("navbarcolor");
	} else {
		$(".js-header").removeClass("navbarcolor");
	}
});
$('a.link[href^="#"]').click(function(e) {
 	var target = $(this).attr('href');
 	var strip = target.slice(1);
 	var anchor = $("section[id='" + strip + "']");
 	e.preventDefault();
 	y = (anchor.offset() || {
 		"top" : NaN
 	}).top;
 	$('html, body').animate({
 		scrollTop : (y - 40)
 	}, 'slow');
});
function sendInformation(){
	var name 		= $('#name').val();
	var surname 	= $('#surname').val();
	var email 		= $('#email').val();
	var phone 		= $('#phone').val();
	var company 	= $('#company').val();
	var position 	= $('#position').val();
	var country 	= $('#country').val();
	if(name == null || name == '') {
		msj('error', 'First Name must be completed');
		return;
	}
	if(surname == null || surname == '') {
		msj('error', 'Last Name must be completed');
		return;
	}
	if(email == null || email == '') {
		msj('error', 'Email debe completarse');
		return;
	}
	if(!validateEmail(email)){
		msj('error', 'The email format is incorrect');
		return;
	}
	if(phone == null || phone == '') {
		msj('error', 'Mobile Phone Number must be completed');
		return;
	}
	if(company == null || company == '') {
		msj('error', 'Company must be completed');
		return;
	}
	if(position == null || position == '') {
		msj('error', 'Job Title must be completed');
		return;
	}
	if(country == null || country == '') {
		msj('error', 'Country must be completed');
		return;
	}
	$.ajax({
		data : {Name	    : name,
				Surname	    : surname,
				Email 	    : email,
				Phone	    : phone,
				Company	    : company,
				Position    : position,
				Country	    : country},
		url  : 'home/register',
		type : 'POST'
	}).done(function(data){
		try {
			data = JSON.parse(data);
			if(data.error == 0){
				$('.js-input').find('input').val('');
				$('.js-input').find('select').val('0');
				$('.js-input').find('select').selectpicker('refresh');
				$('#confirmation').addClass('aparecer');
				msj('success', 'It was registered correctly');
        	}else{
        		msj('error', data.msj);
        		return;
        	}
		} catch (err) {
			msj('error', err.message);
		}
	});
}
function validateEmail(email){
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}
function verificarDatos(e) {
	if(e.keyCode === 13){
		e.preventDefault();
		ingresar();
    }
}
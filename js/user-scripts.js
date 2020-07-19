var PATH_TO_SCRIPT = '../php-bin/handlers-events/';

$(function () {
    'use strict';
	
	// Btn autorization
	$('#btnAutorization').click(function() {
		var query, login, pass;
		if($('#login').val() === undefined || $('#login').val().trim().length == 0) {
			showModal('ModalWindow', 'Не заполнено поле логин!');
			$('#login').focus();
			return;
		} else {
			login = $('#login').val();
		}
		
		if($('#password').val() === undefined || $('#password').val().trim().length == 0) {
			showModal('ModalWindow', 'Не заполнено поле пароль!');
			$('#password').focus();
			return;
		} else {
			pass = $('#password').val();
		}
		query = 'option=1&login=' + login + '&password=' + pass;
		AjaxQuery('POST', PATH_TO_SCRIPT + 'user-events.php', query, function(result) {
			var res = eval(result);
			if(res[0] == -1) {
				showModal('ModalWindow', 'При обработке запроса произошла ошибка! Повторите запрос!');
			} else if(res[0] == 1) {
				window.location = '../index.php';
			} else {
				showModal('ModalWindow', 'При обработке запроса произошла непредвиденная ошибка!');
			}
		});
	});
	
	// Btn change type input password/text
	$('#btnEye').click(function() {
		if($(this).closest('.col').find('input').prop('type') == 'password')
			$(this).closest('.col').find('input').prop('type', 'text');
		else
			$(this).closest('.col').find('input').prop('type', 'password');
	});

});


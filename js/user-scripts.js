/*
	Copyright: Rostislav Gashin (rost1993), 2019
*/

var PATH_TO_SCRIPT = '/BeeJee/php-bin/handlers-events/';

$(function () {
    'use strict';
	
	$('#btnAutorization').click(function() {
		var query, login, pass;
		if($('#login').val() === undefined || $('#login').val().trim().length == 0) {
			alert('Не заполнено поле логин!');
			return;
		} else {
			login = $('#login').val();
		}
		
		if($('#password').val() === undefined || $('#password').val().trim().length == 0) {
			alert('Не заполнено поле пароль!');
			return;
		} else {
			pass = $('#password').val();
		}
		query = 'option=1&login=' + login + '&password=' + pass;
		AjaxQuery('POST', PATH_TO_SCRIPT + 'user-events.php', query, function(result) {
			var res = eval(result);
			if(res[0] == -1) {
				alert('При обработке запроса произошла ошибка! Повторите запрос!');
			} else if(res[0] == 1) {
				window.location = '/beejee/index.php';
			} else {
				alert('При обработке запроса произошла непредвиденная ошибка!');
			}
		});
	});

});


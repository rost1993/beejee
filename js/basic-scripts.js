/*
	Служебный JavaScript предназначенный для описания различных функций и обработчиков, связанных с транспортными средствами
	Используем схему разделения функций и полномочий чтобы было удобнее вностиь изменения
	
	Copyright: Rostislav Gashin (rost1993), 2019
*/

var PATH_TO_SCRIPT = '/beejee/php-bin/handlers-events/';

$(function () {
    'use strict';
	
	// Определяем на какой странице запустился JavaScript
	var page = location.pathname.match(/[^/]*$/).toString().replace(".php", "");
	switch(page) {
		case 'list-tasks':

			AjaxQuery('POST', PATH_TO_SCRIPT + 'list-tasks-events.php', 'option=1', function(result) {
				var res = eval(result);
				if(res[0] == -1) {
					alert('При обработке запроса произошла ошибка! Повторите запрос!');
				} else if(res[0] == 1) {
					$('#card-header-pagination').html(res[1]);
				} else {
					alert('При обработке запроса произошла непредвиденная ошибка!');
				}
			});
			break;
	}

});


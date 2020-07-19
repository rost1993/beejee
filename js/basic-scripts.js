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

			AjaxQuery('POST', PATH_TO_SCRIPT + 'list-tasks-events.php', 'option=1&page=1', function(result) {
				var res = eval(result);
				if(res[0] == -1) {
					showModal('ModalWindow', 'При обработке запроса произошла ошибка! Повторите запрос!');
				} else if(res[0] == 1) {
					$('#accordion').html(res[1]);
				} else {
					showModal('ModalWindow', 'При обработке запроса произошла непредвиденная ошибка!');
				}
			});
			break;
	}
	
	$('#btnAddTask').click(function() {
		$('#ModalWindowTask').modal('toggle');
	});
	
	// Save task
	$('#btnSaveTask').click(function() {
		var arrSaveItem = {};		
		var resultCollectionsItems = getArrayItemsForms('#ModalWindowTask input, #ModalWindowTask textarea');
		if(resultCollectionsItems[0]) {
			arrSaveItem = resultCollectionsItems[1];
		} else {
			showModal('ModalWindow', resultCollectionsItems[1]);
			return;
		}	
		
		var query = 'option=2&JSON=' + JSON.stringify(arrSaveItem) + '&nsyst=-1';
		/*if($('#nsyst').html().trim().length == 0)
			query += '&nsyst=-1';
		else
			query += '&nsyst=' + $('#nsyst').html().trim();*/
		
		
		AjaxQuery('POST', PATH_TO_SCRIPT + 'list-tasks-events.php', query, function(result) {
			var res = eval(result);
			if(res[0] == -1) {
				showModal('ModalWindow', 'При обработке запроса произошла ошибка! Повторите запрос!');
			} else if(res[0] == 1) {
				closeModal('ModalWindowTask');
			} else {
				showModal('ModalWindow', 'При обработке запроса произошла непредвиденная ошибка!');
			}
		});
		
	});
	
	$('#accordion').on('click', '.page-link', function() {
		var page = Number($(this).data('page'));
		var sort_field = $('#select_sort_field').val();
		var type_sort;
		$("[type='radio']").each(function() {
			if($(this).prop('checked'))
				type_sort = $(this).val();
		});
		
		var query = 'option=1&page=' + page + '&sort_field=' + sort_field + '&type_sort=' + type_sort;
		AjaxQuery('POST', PATH_TO_SCRIPT + 'list-tasks-events.php', query, function(result) {
			var res = eval(result);
			if(res[0] == -1) {
				showModal('ModalWindow', 'При обработке запроса произошла ошибка! Повторите запрос!');
			} else if(res[0] == 1) {
				$('#accordion').html(res[1]);
			} else {
				showModal('ModalWindow', 'При обработке запроса произошла непредвиденная ошибка!');
			}
		});
	});

});


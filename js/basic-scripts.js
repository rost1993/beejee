var PATH_TO_SCRIPT = '../php-bin/handlers-events/';

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
		$('#ModalWindowTask').find('#name_user').val('');
		$('#ModalWindowTask').find('#e_mail').val('');
		$('#ModalWindowTask').find('#text_task').val('');
		$('#ModalWindowTask').find('#btnSaveTask').data('id', '-1');
		$('#ModalWindowTask').modal('toggle');
	});
	
	// Save task
	$('#btnSaveTask').click(function() {
		var reg = /\S+@\S+\.\S+/;
		if(!reg.test($('#e_mail').val())) {
			showModal('ModalWindow', 'Некорректный email!');
			return;
		}
		
		var arrSaveItem = {};		
		var resultCollectionsItems = getArrayItemsForms('#ModalWindowTask input, #ModalWindowTask textarea');
		if(resultCollectionsItems[0]) {
			arrSaveItem = resultCollectionsItems[1];
		} else {
			showModal('ModalWindow', resultCollectionsItems[1]);
			return;
		}
		
		var query = 'option=2&JSON=' + JSON.stringify(arrSaveItem) + '&nsyst=' + $(this).data('id');		
		AjaxQuery('POST', PATH_TO_SCRIPT + 'list-tasks-events.php', query, function(result) {
			var res = eval(result);
			if(res[0] == -1) {
				showModal('ModalWindow', 'При обработке запроса произошла ошибка! Повторите запрос!');
			} else if(res[0] == -2) {
				showModal('ModalWindow', res[1]);
			} else if(res[0] == 1) {
				closeModal('ModalWindowTask');
			} else {
				showModal('ModalWindow', 'При обработке запроса произошла непредвиденная ошибка!');
			}
		});
		
	});
	
	// Change page
	$('#accordion').on('click', '.page-link', function() {
		var page = Number($(this).data('page'));
		var order_field = $('#select_order_field').val();
		var order_type;
		$("[type='radio']").each(function() {
			if($(this).prop('checked'))
				order_type = $(this).val();
		});
		
		var query = 'option=1&page=' + page + '&order_field=' + order_field + '&order_type=' + order_type;
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
	
	// Change type sorting
	$("#select_order_field, [type='radio']").change(function() {
		var order_field = $('#select_order_field').val();
		var order_type;
		$("[type='radio']").each(function() {
			if($(this).prop('checked'))
				order_type = $(this).val();
		});
		
		var query = 'option=1&page=1&order_field=' + order_field + '&order_type=' + order_type;
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

	// Remove task
	$('#accordion').on('click', '.btnRemoveTask', function() {
		var item_task = $(this).closest('.card');
		AjaxQuery('POST', PATH_TO_SCRIPT + 'list-tasks-events.php', 'option=3&id=' + $(this).data('id'), function(result) {
			var res = eval(result);
			if(res[0] == -1) {
				showModal('ModalWindow', 'При обработке запроса произошла ошибка! Повторите запрос!');
			} else if(res[0] == 1) {
				showModal('ModalWindow', 'Задача удалена!');
				$(item_task).remove();
			} else {
				showModal('ModalWindow', 'При обработке запроса произошла непредвиденная ошибка!');
			}
		});
	});
	
	// Edit task
	$('#accordion').on('click', '.btnEditTask', function() {
		AjaxQuery('POST', PATH_TO_SCRIPT + 'list-tasks-events.php', 'option=4&id=' + $(this).data('id'), function(result) {
			var res = eval(result);
			if(res[0] == -1) {
				showModal('ModalWindow', 'При обработке запроса произошла ошибка! Повторите запрос!');
			} else if(res[0] == 1) {
				$('#ModalWindowTask').find('#name_user').val(res[2]);
				$('#ModalWindowTask').find('#e_mail').val(res[3]);
				$('#ModalWindowTask').find('#text_task').val(res[4]);
				$('#ModalWindowTask').find('#btnSaveTask').data('id', res[1]);
				$('#ModalWindowTask').modal('toggle');
			} else {
				showModal('ModalWindow', 'При обработке запроса произошла непредвиденная ошибка!');
			}
		});
	});
	
	// Change status task
	$('#accordion').on('click', '.btnCheckTask', function() {
		AjaxQuery('POST', PATH_TO_SCRIPT + 'list-tasks-events.php', 'option=5&id=' + $(this).data('id'), function(result) {
			var res = eval(result);
			if(res[0] == -1) {
				showModal('ModalWindow', 'При обработке запроса произошла ошибка! Повторите запрос!');
			} else if(res[0] == 1) {
				showModal('ModalWindow', 'Статус изменен обновите страницу!');
			} else {
				showModal('ModalWindow', 'При обработке запроса произошла непредвиденная ошибка!');
			}
		});
	});
});


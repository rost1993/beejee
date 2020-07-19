'use strict';

function AjaxQuery(method, url, query, callback, fileDownload, statusError) {
	var result;
	var cacheVal, processDataVal, contentTypeVal;
	
	fileDownload = (typeof fileDownload !== undefined) ? fileDownload : false;
	
	if(fileDownload === undefined || fileDownload == false) {
		cacheVal = true;
		processDataVal = true;
		contentTypeVal = 'application/x-www-form-urlencoded';
	} else {
		cacheVal = false;
		processDataVal = false;
		contentTypeVal = false;
	}
	
	$.ajax({
		type: method,
		url: url,
		data: query,
		cache: cacheVal,
		processData: processDataVal,
		contentType: contentTypeVal,
		
		success: function(data) {
			if(callback != null)
				callback(data);
		},
		
		complete: function() {
			//callback(result);
		},
		
		error: function(data, status, xhr) {
			if(statusError === undefined)
				showModal('ModalWindow', 'Ошибка при выполнении запроса! Повторите запрос или обратитесь к администратору!');
			return;
		},
		
		statusCode: {			
			404: function() {
				document.location.href = '/pages/service-pages/not-found.php';
			}
		}
	});
}

/* 
 * Функция всплытия модального окна.
 * message - сообщение, которое необходимо вывести
 * modalName - ID модального окна, которое необходимо вызвать
 * modalOpen - параметр, если установлен в TRUE, то добавляет класс modal-open и убирает полосу прокрутки (по умолчанию FALSE)
 */
function showModal(modalName, message, modalOpen)
{
	document.getElementById(modalName).getElementsByTagName('h4')[0].innerHTML = message;	
	$('#' + modalName).modal('toggle');

	// Вызываем глобальную потерю фокуса с кнопок и устанавливаем фокус на кнопке закрытия
	$('.btn').blur();
	$('#' + modalName).on('shown.bs.modal', function() {
		$('#' + modalName).find('#closeButton').focus();
	});
	
	if((modalOpen === undefined) && (modalOpen == true))
		$('#closeButton').data('modalOpen', '1');
	else
		$('#closeButton').data('modalOpen', '0');
}

function getArrayItemsForms(searchItems) {
	var flgCheck = true;
	var messageError = '';
	var arrSaveItem = {};
	
	$(searchItems).each(function() {
		if($(this).data('mandatory')) {
			if($(this).prop('tagName').toUpperCase() == 'SELECT') {
				if($(this).val() == 0 || $(this).val() === undefined || $(this).val() == null) {
					messageError = $(this).data('messageError');
					flgCheck = false;
					return false;
				}
			} else {
				if($(this).val().trim().length == 0) {
					messageError = $(this).data('messageError');
					flgCheck = false;
					return false;
				}
			}
			
			var nameItem = $(this).prop('id');
			var arrayTemp = {};
			
			if($(this).prop('type') == 'CHECKBOX')
				arrayTemp['value'] = $(this).prop('checked');
			else
				arrayTemp['value'] = $(this).val().trim().toUpperCase();
			
			arrayTemp['type'] = $(this).data('datatype');
			arrSaveItem[nameItem] = arrayTemp;
		} else {
			var nameItem = $(this).prop('id');
			var arrayTemp = {}
			
			if($(this).prop('tagName').toUpperCase() == 'SELECT') {
				arrayTemp['value'] = $(this).val();
			} else {
				if(($(this).prop('type').toUpperCase() == 'CHECKBOX') || ($(this).prop('type').toUpperCase() == 'RADIO'))
					arrayTemp['value'] = $(this).prop('checked');
				else
					arrayTemp['value'] = $(this).val().trim().toUpperCase();
			}
			
			arrayTemp['type'] = $(this).data('datatype');
			arrSaveItem[nameItem] = arrayTemp;
		}
	});
	
	var arrayResult = {};
	
	if(!flgCheck) {
		arrayResult[0] = false;
		arrayResult[1] = messageError;
	} else {
		arrayResult[0] = true;
		arrayResult[1] = arrSaveItem;
	}

	return arrayResult;
}

/* 
 * Функция закрытия диалогового модального окна
 * modalname - ID модального окна, которое необходимо закрыть
 */
function closeModal(modalName) {
	$('#' + modalName).modal('hide');
}
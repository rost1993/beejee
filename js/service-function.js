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
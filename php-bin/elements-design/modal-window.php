<?php
echo "<div class='modal fade' id='ModalWindow' role='dialog' style='z-index: 1000001;'>
	<div class='modal-dialog modal-lg' role='document'>
		<div class='modal-content text-center'>
			<div class='modal-header'>
				<p><h4 class='modal-tittle' id='textModal'></h4></p>
			</div>
			<div class='modal-footer' id='modalFooterWindow'>
				<button id='closeButton' class='btn btn-warning' type='button' data-dismiss='modal' aria-label='Close'> Закрыть </button>
			</div>
		</div>
	</div>
</div>";

echo "<div class='modal fade' id='ModalWindowTask' role='dialog'>
	<div class='modal-dialog modal-lg' role='document'>
		<div class='modal-content text-center'>
			<div class='modal-header'>
				<p><h4 class='modal-tittle' id='textModal'>Задача</h4></p>
			</div>
			<div class='modal-body'>
				<div class='row'>
					<div class='col col-sm mb-0 text-left' style='vertical-align: center;'>
						<label for='name_user' style='font-size: 13px;'><strong>Имя пользователя:</strong></label>
					</div>
				</div>
				<div class='form-row mb-4'>
					<input type='text' class='form-control form-control-sm black-text' id='name_user' maxlength='50' placeholder='Имя пользователя' data-mandatory='true' data-datatype='char' data-message-error='Не заполнено поле: Имя пользователя'>
				</div>

				<div class='form-row'>
					<div class='col col-sm mb-0 text-left' style='vertical-align: center;'>
						<label for='e_mail' style='font-size: 13px;'><strong>E-mail:</strong></label>
					</div>
				</div>
				<div class='form-row mb-4'>
					<input type='text' class='form-control form-control-sm black-text' id='e_mail' maxlength='50' placeholder='E-mail' data-mandatory='true' data-datatype='char' data-message-error='Не заполнено поле: E-mail'>
				</div>

				<div class='form-row'>
					<div class='col col-sm mb-0 text-left' style='vertical-align: center;'>
						<label for='text_task' style='font-size: 13px;'><strong>Текст задачи:</strong></label>
					</div>
				</div>
				<div class='form-row'>
					<textarea class='form-control form-control-sm black-text' id='text_task' maxlength='1000' placeholder='Текст задачи' rows='4' data-mandatory='true' data-datatype='char' data-message-error='Не заполнено поле: Текст задачи'></textarea>
				</div>

			</div>
			<div class='modal-footer' id='modalFooterWindow'>
				<button id='closeButton' class='btn btn-warning' type='button' data-dismiss='modal' aria-label='Close'>Закрыть</button>
				<button id='btnSaveTask' class='btn btn-success' type='button'>Сохранить</button>
			</div>
		</div>
	</div>
</div>";

?>
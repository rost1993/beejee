<?php
echo "<div class='modal fade' id='ModalWindow' role='dialog'>
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

echo "<div class='modal fade' id='ModalWindowServiceInterfaces' role='dialog' data-backdrop='static'>
	<div class='modal-dialog modal-dialog-centered modal-xl' role='document'>
		<div class='modal-content text-center'>
			<div class='modal-header'>
				<h4 class='modal-tittle' id='textModal'></h4>
				<button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times</span></button>
			</div>
			<div class='modal-body' id='bodyModal'>
			</div>
			<div class='modal-footer' id='modalFooterWindow'>
				<button id='saveModalWindowButton' class='btn btn-success' type='button'> Сохранить </button>
				<button id='closeButton' class='btn btn-warning' type='button' data-dismiss='modal'> Закрыть </button>
			</div>
		</div>
	</div>
</div>";

/*echo "<div class='modal fade' id='ModalWindowViewDocument' role='dialog' data-backdrop='static'>
	<div class='modal-dialog modal-dialog-centered modal-xl' role='document' style='max-width: 90%'>
		<div class='modal-content text-center' style='height: 90vh; width: 100%;'>
			<div class='modal-header'>
				<h4 class='modal-tittle' id='textModal'></h4>
				<button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times</span></button>
				<button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times</span></button>
			</div>
			<div class='modal-body' id='bodyModal' style='height: 100%; position: relative;'>
			</div>
		</div>
	</div>
</div>";*/

echo "<div class='modal fade' id='ModalWindowViewDocument' role='dialog' data-backdrop='static'>
	<div class='modal-dialog modal-dialog-centered modal-xl' role='document' style='max-width: 90%'>
		<div class='modal-content text-center' style='height: 90vh; width: 100%;'>
			<div class='modal-header'>
				<h4 class='modal-tittle' id='textModal'></h4>
				<div class='text-right'>
					<button type='button' class='btn btn-outline-secondary' id='btnOpenFileNewPage' title='Открыть в новом окне'><span class='fa fa-folder-open-o'></span></button>
					<button type='button' class='btn btn-outline-danger' title='Закрыть просмотр' data-dismiss='modal' aria-label='Close'><span class='fa fa-close'></span></button>
				</div>
			</div>
			<div class='modal-body' id='bodyModal' style='height: 100%; position: relative;'>
			</div>
			<div id='TextModalWindowViewDocument'></div>
		</div>
	</div>
</div>";


?>
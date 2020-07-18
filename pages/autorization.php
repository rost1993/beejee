<?php
	include('../php-bin/service-php/main_setting.php');
?>

<!DOCTYPE HTML>
<html>
<body>
	
<div class="container-fluid starter-template">
	<div class="row">
		<div class="col-2"></div>
		
		<div class="col-8">
			<div class='card text-center border-dark' style='margin-top: 80px; background: #E6E6E6;'>
				<div class='card-header'>
					<h4>Авторизация</h4>
				</div>
				
				<div class="card-body">
					<div class="form-row">
						<div class="col col-sm mb-0 text-left" style="vertical-align: center;">
							<label for="login" class="text-muted" style="font-size: 13px;"><strong>Логин:</strong></label>
						</div>
					</div>

					<div class="col mb-4">
						<div class="input-group">
							<div class="input-group-prepend">
								<span for="login" class="input-group-text fa fa-user"></span>
							</div>
							<input type="text" class="form-control form-control-sm black-text" id="login" maxlength="50" placeholder="Логин" autofocus />
						</div>
					</div>

					<div class="form-row">
						<div class="col col-sm mb-0 text-left" style="vertical-align: center;">
							<label for="password" class="text-muted" style="font-size: 13px;"><strong>Пароль:</strong></label>
						</div>
					</div>

					<div class="col mb-4">
						<div class="input-group">
							<div class="input-group-prepend">
								<span for="password" class="input-group-text fa fa-lock"></span>
							</div>
							<input type="password" class="form-control form-control-sm black-text" id="password" maxlength="50" placeholder="Пароль">
							<div class="input-group-append">
								<button class="btn btn-sm btn-outline-secondary" id="btnEye"><span class="fa fa-eye"></span></button>
							</div>
						</div>
					</div>

				</div>
				
				<div class="card-header">
					<button type="button" class="btn btn-success" id="btnAutorization" title="Авторизоваться" style="margin: 2px;"><span class="fa fa-check">&nbsp;</span>Авторизоваться</button>
				</div>
			</div>
		</div>
		
		<div class="col-2"></div>
	</div>
</div>
	
</body>
</html>
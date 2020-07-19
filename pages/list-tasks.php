<?php
	include('../php-bin/service-php/main_setting.php');
?>

<!DOCTYPE HTML>
<html>
<body>

<div class="container-fluid starter-template">
	<div class="row mb-3" style='margin-top: 80px;'>
		<div class="col-2">
		
			<button class="btn btn-success" id="btnAddTask" title="Добавить задачу"><span class="fa fa-plus">&nbsp;</span>Добавить задачу</button>
		</div>
		
		<div class="col-5">
			<div class="input-group">
				<div class="input-group-prepend">
					<span class="input-group-text">Сортировать по полю</span>
				</div>
				<select class="custom-select custom-select black-text" id="select_order_field">
					<option value="name_user">Имя пользователя</option>
					<option value="e_mail">E-mail</option>
					<option value="status">Статус</option>
				</select>
			</div>
		</div>
		
		<div class="col-5">
			<label for="radioSortPlus">По возрастанию</label>
			<input type="radio" id="radioSortPlus" name="sorting_tasks" value="1" checked>
			
			<label for="radioSortMinus">По убыванию</label>
			<input type="radio" id="radioSortMinus" name="sorting_tasks" value="2">
		</div>

	</div>
	
	<div class="row">
		<div class="col text-center">
			<div id="accordion"></div>
		</div>
	</div>
</div>
</body>
</html>
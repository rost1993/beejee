<?php
	$path = $_SERVER['DOCUMENT_ROOT'];
	$root = 'http://' . $_SERVER['HTTP_HOST'];
	
	$arr_path = explode("/", $path);
	if($arr_path[count($arr_path) - 1] != 'BeeJee')
		$path .= '/BeeJee';
	
	$arr_root = explode("/", $root);
	if($arr_root[count($arr_root) - 1] != 'BeeJee')
		$root .= '/BeeJee';
	
	require($path . '/php-bin/classes/Sessions.php');
	
	Session::start();
	$login = Session::get('login');
	$userRole = 0;
	$userLogin = '';
	//$userRole = Session::get('role');
	
	/*$fam = Session::get('fam');
	$imj = Session::get('imj');
	$otch = Session::get('otch');
	$fio =  "  <span class='fa fa-user-o'></span>&nbsp;" . $fam . ' ' . mb_substr($imj, 0, 1) . '.' . mb_substr($otch, 0, 1) . ". ";*/
	Session::commit();
	

	// Определяем тип надписи левого бокового меню
	/*if($login != null) {
		if($kod_slugba == null || $text_slugba == null)
			$userLogin = "  <span class='fa fa-user-circle'></span>&nbsp;" . $login . " ";
			//$userLogin = "  <span class='fa fa-user-circle'></span>&nbsp;" . $fio . " ";
		else
			$userLogin = "  <span class='fa fa-user-o'></span>&nbsp;" . $login . " - " . $text_slugba . " ";
	} else {
		if($kod_slugba == null || $text_slugba == null)
			$userLogin = " <span class='fa fa-user-circle-o'></span>&nbsp;  Анонимный пользователь ";
		else
			$userLogin = "  <span class='fa fa-user-o'></span>&nbsp;" . $text_slugba . " ";
	}*/

	$navbar1 = "<nav class='navbar fixed-top navbar-expand-lg bg-dark'>"
			. "<a class='navbar-brand' href='" . $root . "/index.php' title='BeeJee Team'>"
			. "<img style='max-width: 60px; margin-top: -7px;' src='" . $root . "/images/beejee_header_en_new_white.png' alt='BeeJee Team'></a>"
			. "<button class='navbar-toggler' type='button' data-toggle='collapse' data-target='#navbarSupportedContent' aria-controls='navbarSupportedContent' aria-expanded='false' aria-label='Toggle navigation'>"
				. "<span class='navbar-toggler-icon'></span>"
			. "</button>"
		. "<div class='collapse navbar-collapse' id='navbarSupportedContent'>";
	
	// Получаем уровень доступа у пользователя
	if($userRole == null)
		$userRole = 0;
	
	switch($userRole) {
		case 0:
			$navbar2 = "<ul class='navbar-nav mr-auto'>"
						. "<li class='nav-item'>"
							. "<a class='text-white nav-link' id='documentation' href='" . $root . "/pages/documentation.php' title='Переход на страницу с документацией'>Список задач</a>"
						. "</li>"						

					. "</ul>"
					. "<ul class='navbar-nav navbar-right'>"
						. "<li class='nav-item dropdown'>"
							. "<a class='text-white nav-link dropdown-toggle' href='#' id='user' ole='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>Меню " . $userLogin . "</a>"
							. "<div class='dropdown-menu dropdown-menu-right' aria-labelledby='user'>"
								. "<div class='dropdown-divider'></div>"
								. "<a class='dropdown-item' id='autorization' href='pages/autorization.php'><span class='fa fa-power-off'>&nbsp;</span>Войти на веб-ресурс</a>"
							. "</div>"
						. "</li>"
					. "</ul>"
				. "</div></nav>";
			break;
		
		case 1:
			$navbar2 = "<ul class='navbar-nav mr-auto'>"
						
						. "<li class='nav-item'>"
							. "<a class='text-white nav-link' id='contacts' href='" . $root . "/pages/list-device.php' title='ЖУРНАЛ УЧЕТА '>Журнал учета</a>"
						. "</li>"
						. "<li class='nav-item dropdown'>"
							. "<a class='text-white nav-link dropdown-toggle' href='#' id='user' ole='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>Отчеты</a>"
							. "<div class='dropdown-menu dropdown-menu-right' aria-labelledby='user'>"
								. "<a class='dropdown-item' id='otchet' href='" . $root . "/pages/otchet.php'><span class='fa fa-bar-chart'>&nbsp;</span>Ежемесячный отчет в ИЦ</a>"
								. "<a class='dropdown-item' id='otchet_kvart' href='" . $root . "/pages/otchet_kvart.php'><span class='fa fa-bar-chart'>&nbsp;</span>Ежеквартальный отчет в ИЦ</a>"
						
								
						. "</li>"

						. "<li class='nav-item'>"
							. "<a class='text-white nav-link' id='documentation' href='" . $root . "/pages/documentation.php' title='Переход на страницу с документацией'>Документация</a>"
						. "</li>"
						
						. "<li class='nav-item'>"
							. "<a class='text-white nav-link' id='contacts' href='" . $root . "/pages/contacts.php' title='Переход на страницу с контактными данными сотрудников'>Контакты</a>"
						. "</li>"
						
						. "</ul>"
					. "<ul class='navbar-nav navbar-right'>"
						. "<li class='nav-item dropdown'>"
							. "<a class='text-white nav-link dropdown-toggle' href='#' id='user' ole='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>Меню " . $fio  . "</a>"
							. "<div class='dropdown-menu dropdown-menu-right' aria-labelledby='user'>"
								. "<a class='dropdown-item' id='edit' href='" . $root . "/pages/edit.php'><span class='fa fa-vcard-o'>&nbsp;</span>Редактировать данные пользователя</a>"
								. "<div class='dropdown-divider'></div>"
								. "<a class='dropdown-item' id='autorization' href='" . $root . "/php-bin/service-php/exit.php'><span class='fa fa-close'>&nbsp;</span>Выход</a>"
							. "</div>"
						. "</li>"
					. "</ul>"
				. "</div></nav>";
			break;

		default:
			$navbar2 = "<ul class='navbar-nav mr-auto'>"
						. "<li class='nav-item'>"
							. "<a class='text-white nav-link' id='contacts' href='" . $root . "/pages/contacts.php' title='Переход на страницу с контактными данными сотрудников'>Контакты</a>"
						. "</li>"
					. "</ul>"
					
					. "<ul class='navbar-nav navbar-right'>"
						. "<li class='nav-item dropdown'>"
							. "<a class='text-white nav-link dropdown-toggle' href='#' id='user' ole='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>Меню " . $userLogin . "</a>"
							. "<div class='dropdown-menu dropdown-menu-right' aria-labelledby='user'>"
								. "<div class='dropdown-divider'></div>"
								. "<a class='dropdown-item' id='autorization' href='/pages/autorization.php'><span class='fa fa-power-off'>&nbsp;</span>Войти на веб-ресурс</a>"
							. "</div>"
						. "</li>"
					. "</ul>"
				. "</div></nav>";
			break;
	}

	echo $navbar1 . $navbar2;
?>
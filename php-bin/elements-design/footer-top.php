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
	$user_role = 0;
	$user_login = '';
	$user_role = Session::get('role');
	$user_login = Session::get('login');
	Session::commit();

	$navbar1 = "<nav class='navbar fixed-top navbar-expand-lg bg-dark'>"
			. "<a class='navbar-brand' href='" . $root . "/index.php' title='BeeJee Team'>"
			. "<img style='max-width: 60px; margin-top: -7px;' src='" . $root . "/images/beejee_header_en_new_white.png' alt='BeeJee Team'></a>"
			. "<button class='navbar-toggler' type='button' data-toggle='collapse' data-target='#navbarSupportedContent' aria-controls='navbarSupportedContent' aria-expanded='false' aria-label='Toggle navigation'>"
				. "<span class='navbar-toggler-icon'></span>"
			. "</button>"
		. "<div class='collapse navbar-collapse' id='navbarSupportedContent'>";
	
	// Получаем уровень доступа у пользователя
	if($user_role == null)
		$user_role = 0;
	
	switch($user_role) {
		case 0:
			$navbar2 = "<ul class='navbar-nav mr-auto'>"
						. "<li class='nav-item'>"
							. "<a class='text-white nav-link' id='list-tasks' href='" . $root . "/pages/list-tasks.php' title='Список задач'>Список задач</a>"
						. "</li>"						

					. "</ul>"
					. "<ul class='navbar-nav navbar-right'>"
						. "<li class='nav-item dropdown'>"
							. "<a class='text-white nav-link dropdown-toggle' href='#' id='user' ole='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>Меню " . $user_login . "</a>"
							. "<div class='dropdown-menu dropdown-menu-right' aria-labelledby='user'>"
								. "<div class='dropdown-divider'></div>"
								. "<a class='dropdown-item' id='autorization' href='" . $root . "/pages/autorization.php'><span class='fa fa-power-off'>&nbsp;</span>Войти на веб-ресурс</a>"
							. "</div>"
						. "</li>"
					. "</ul>"
				. "</div></nav>";
			break;
		
		case 1:
			$navbar2 = "<ul class='navbar-nav mr-auto'>"
						
						. "<li class='nav-item'>"
							. "<a class='text-white nav-link' id='list-tasks' href='" . $root . "/pages/list-tasks.php' title='Список задач'>Список задач</a>"
						. "</li>"
						. "</ul>"
					. "<ul class='navbar-nav navbar-right'>"
						. "<li class='nav-item dropdown'>"
							. "<a class='text-white nav-link dropdown-toggle' href='#' id='user' ole='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>Меню " . $user_login  . "</a>"
							. "<div class='dropdown-menu dropdown-menu-right' aria-labelledby='user'>"
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
							. "<a class='text-white nav-link' id='list-tasks' href='" . $root . "/pages/list-tasks.php' title='Список задач'>Список задач</a>"
						. "</li>"						

					. "</ul>"
					. "<ul class='navbar-nav navbar-right'>"
						. "<li class='nav-item dropdown'>"
							. "<a class='text-white nav-link dropdown-toggle' href='#' id='user' ole='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>Меню " . $user_login . "</a>"
							. "<div class='dropdown-menu dropdown-menu-right' aria-labelledby='user'>"
								. "<div class='dropdown-divider'></div>"
								. "<a class='dropdown-item' id='autorization' href='" . $root . "/pages/autorization.php'><span class='fa fa-power-off'>&nbsp;</span>Войти на веб-ресурс</a>"
							. "</div>"
						. "</li>"
					. "</ul>"
				. "</div></nav>";
			break;
	}

	echo $navbar1 . $navbar2;
?>
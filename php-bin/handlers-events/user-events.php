<?php
// Скрипт взаимодействия со справочниками.
// В данный скрипт необходимо помещать только функции, которые необходимы для работы со справочникаим.
// Используем идею разграничения кода
	
	//require_once('../classes/Spr.php');
	require_once('../classes/User.php');
	//require_once('../classes/Rights.php');
	
	setlocale(LC_CTYPE, 'ru_RU.UTF8');

	// Функция авторизации пользователя
	function auth_user() {
		$login = $password = '';
		$result = array();
		if(empty($_POST['login']) || (empty($_POST['password'])))
			return false;

		$login = addslashes($_POST['login']);
		$password = addslashes($_POST['password']);
		
		echo json_encode(array(User::login($login, $password)));
		return true;
	}

	/*************************************************************************/
	if(empty($_POST['option']))
		ServiceFunction::returnErrorCode(-1);
	
	$option = addslashes($_POST['option']);
	switch($option) {
		// Регистрация нового пользователя
		case 1:
			if(!auth_user())
				ServiceFunction::returnErrorCode(-1);
			break;

		default:
			ServiceFunction::returnErrorCode(-1);
			break;
	}

	exit();
?>
<?php
// Скрипт взаимодействия со справочниками.
// В данный скрипт необходимо помещать только функции, которые необходимы для работы со справочникаим.
// Используем идею разграничения кода
	
	//require_once('../classes/Spr.php');
	require_once('../classes/User.php');
	require_once('../classes/Tasks.php');
	//require_once('../classes/Rights.php');
	
	setlocale(LC_CTYPE, 'ru_RU.UTF8');

	function painting_list_tasks() {
		
		$html = "<nav>"
					. "<ul class='pagination justify-content-center'>"
						. "<li class='page-item'><a class='page-link' href='#'>Prev</a></li>"
						. "<li class='page-item'><a class='page-link' href='#'>1</a></li>"
						. "<li class='page-item'><a class='page-link' href='#'>2</a></li>"
						. "<li class='page-item'><a class='page-link' href='#'>3</a></li>"
						. "<li class='page-item'><a class='page-link' href='#'>Next</a></li>"
					. "</ul>"
			  . "</nav>";
		
		echo json_encode(array(1, $html));
		
		return true;
	}
	
	function save() {
		if(empty($_POST['nsyst']) || empty($_POST['JSON']))
			return false;
		
		$tasks = new Tasks();
		if($tasks->save($_POST) === false)
			return false;
		echo json_encode(array(1));
		return true;
	}

	/*************************************************************************/
	if(empty($_POST['option']))
		ServiceFunction::returnErrorCode(-1);
	
	$option = addslashes($_POST['option']);
	switch($option) {
		// Регистрация нового пользователя
		case 1:
			if(!painting_list_tasks())
				ServiceFunction::returnErrorCode(-1);
			break;
		
		case 2:
			if(!save())
				ServiceFunction::returnErrorCode(-1);
			break;

		default:
			ServiceFunction::returnErrorCode(-1);
			break;
	}

	exit();
?>
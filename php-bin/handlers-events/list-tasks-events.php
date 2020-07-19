<?php
// Скрипт взаимодействия со справочниками.
// В данный скрипт необходимо помещать только функции, которые необходимы для работы со справочникаим.
// Используем идею разграничения кода
	
	//require_once('../classes/Spr.php');
	require_once('../classes/User.php');
	require_once('../classes/Tasks.php');
	//require_once('../classes/Rights.php');
	
	setlocale(LC_CTYPE, 'ru_RU.UTF8');

	function rendering_panagination($data) {
		
		$count_page = count($data) / 3;
		if((count($data) % 3) != 0)
			$count_page++;
		
		$html = "<nav>";
		$html .= "<ul class='pagination justify-content-center'>";
		for($i = 1; $i < $count_page; $i++)
			$html .= "<li class='page-item'><a class='page-link' href='#'>" . $i . "</a></li>";

		$html .= "</ul></nav>";
		return $html;
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
	
	function get_list_tasks() {
		$data = array();
		$tasks = new Tasks();
		if(($data = $tasks->get_list_tasks()) === false)
			return false;

		$html = rendering_list($data);
		$html .= rendering_panagination($data);
		
		echo json_encode(array(1, $html));
		return true;
	}
	
	function rendering_list($data) {
		$html = "";
		for($i = 0; $i < count($data); $i++) {
			$id = 'task_' . $i;
			$id_collapse = "collapse_" . $i;
			$html .= "<div class='card mb-2'>"
					. "<div class='card-header' id='" . $id . "'>"
						. "<h5 class='mb-0'>"
							. "<button class='btn btn-link' data-toggle='collapse' data-target='#" . $id_collapse . "' aria-expanded='false' aria-controls='" . $id_collapse . "'>"
							 . $data[$i]['name_user'] . "&nbsp;-&nbsp;" . $data[$i]['e_mail']
							. "</button>"
						. "</h5>"
					. "</div>"
					. "<div id='" . $id_collapse . "' class='collapse show' aria-labelledby='" . $id . "' data-parent='#accordion'>"
						. "<div class='card-body'>"
							. $data[$i]['text_task']
						. "</div>"
					. "</div>"
				. "</div>";
		}

		return $html;
	}

	/*************************************************************************/
	if(empty($_POST['option']))
		ServiceFunction::returnErrorCode(-1);
	
	$option = addslashes($_POST['option']);
	switch($option) {
		// Регистрация нового пользователя
		/*case 1:
			if(!painting_list_tasks())
				ServiceFunction::returnErrorCode(-1);
			break;*/
		
		case 2:
			if(!save())
				ServiceFunction::returnErrorCode(-1);
			break;
		
		case 1:
			if(!get_list_tasks())
				ServiceFunction::returnErrorCode(-1);
			break;

		default:
			ServiceFunction::returnErrorCode(-1);
			break;
	}

	exit();
?>
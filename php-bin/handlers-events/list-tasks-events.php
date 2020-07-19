<?php
	require_once('../classes/Sessions.php');
	require_once('../classes/User.php');
	require_once('../classes/Tasks.php');
	
	setlocale(LC_CTYPE, 'ru_RU.UTF8');

	function rendering_panagination($data, $page) {
		
		$count_page = count($data) / 3;
		if((count($data) % 3) != 0)
			$count_page++;
		
		//$count_page = ($count_page == 1) ? $count_page + 1 : $count_page;
		
		$html = "<nav>";
		$html .= "<ul class='pagination justify-content-center'>";
		for($i = 1; $i <= $count_page; $i++) {
			$active = ($page == $i) ? ' active ': '';
			$html .= "<li class='page-item " . $active . "'><button class='page-link' data-page='" . $i . "'>" . $i . "</button></li>";
		}

		$html .= "</ul></nav>";
		return $html;
	}
	
	function save() {
		if(empty($_POST['nsyst']) || empty($_POST['JSON']))
			return false;

		$tasks = new Tasks();
		if($tasks->save($_POST, $msg_error) === false) {
			echo json_encode(array(-2, $msg_error));
			return true;
		}
		echo json_encode(array(1));
		return true;
	}
	
	function get_list_tasks() {
		$order_field = (empty($_POST['order_field'])) ? 'name_user' : $_POST['order_field'];
		$order_type = (empty($_POST['order_type'])) ? 1 : $_POST['order_type'];
		
		$data = array();
		$tasks = new Tasks();
		if(($data = $tasks->get_list_tasks($order_field, $order_type)) === false)
			return false;

		$html = rendering_list($data, addslashes($_POST['page']));
		$html .= rendering_panagination($data, addslashes($_POST['page']));
		
		echo json_encode(array(1, $html));
		return true;
	}
	
	function rendering_list($data, $page) {
		$html = "";
		
		$start_page = ($page - 1) * 3;
		$end_page = (count($data) > ($start_page + 3)) ? $start_page + 3: count($data);
		
		Session::start();
		$role = Session::get('role');
		Session::commit();

		for($i = $start_page; $i < $end_page; $i++) {
			
			$html_admin_panel = '';
			if($role == 1) {
				$html_admin_panel = "<div class='btn-group' role='group' style='position: absolute; top:0; right: 0;'>"
					. "<button class='btn btn-sm btn-success btnCheckTask' data-id='" . $data[$i]['id'] . "' title='Изменить статус'><span class='fa fa-check'></span></button>"
					. "<button class='btn btn-sm btn-info btnEditTask' data-id='" . $data[$i]['id'] . "' title='Редактировать'><span class='fa fa-pencil'></span></button>"
					. "<button class='btn btn-sm btn-danger btnRemoveTask' data-id='" . $data[$i]['id'] . "' title='Удалить'><span class='fa fa-remove'></span></button>"
				. "</div>";
			}
			
			$id = 'task_' . $i;
			$id_collapse = "collapse_" . $i;
			$status = ($data[$i]['status'] == 0) ? 'НА ИСПОЛНЕНИИ' : 'ИСПОЛНЕНО';
			
			$html .= "<div class='card mb-2'>"
					. "<div class='card-header' id='" . $id . "'>"
							. "<h5 class='mb-0'>"
								. "<button class='btn btn-link' data-toggle='collapse' data-target='#" . $id_collapse . "' aria-expanded='false' aria-controls='" . $id_collapse . "'>"
								. "Имя пользователя:&nbsp;" . $data[$i]['name_user'] . "<br>E-mail:&nbsp;" . $data[$i]['e_mail'] . "<br>Статус:&nbsp;" . $status
								. "</button>"
								. $html_admin_panel
							. "</h5>"
					. "</div>"
					. "<div id='" . $id_collapse . "' class='collapse show' aria-labelledby='" . $id . "' data-parent='#accordion'>"
						. "<div class='card-body'>"
							. strip_tags($data[$i]['text_task'])
						. "</div>"
					. "</div>"
				. "</div>";
		}

		return $html;
	}
	
	function change_status() {
		if(empty($_POST['id']))
			return false;
		
		$tasks = new Tasks();
		if(($tasks->change_status(addslashes($_POST['id']))) === false)
			return false;
		echo json_encode(array(1));
		return true;
	}
	
	function remove(){
		if(empty($_POST['id']))
			return false;
		$tasks = new Tasks();
		if($tasks->remove(addslashes($_POST['id'])) === false)
			return false;
		echo json_encode(array(1));
		return true;
	}
	
	function edit() {
		if(empty($_POST['id']))
			return false;

		$data = array();
		$tasks = new Tasks();
		if(($data = $tasks->get(addslashes($_POST['id']))) === false)
			return false;

		$id = (count($data) == 0) ? '-1' : $data[0]['id'];
		$name_user = (count($data) == 0) ? '' : $data[0]['name_user'];
		$email = (count($data) == 0) ? '' : $data[0]['e_mail'];
		$text_task = (count($data) == 0) ? '' : $data[0]['text_task'];
		$status = (count($data) == 0) ? '' : $data[0]['status'];
		
		echo json_encode(array(1, $id, $name_user, $email, $text_task, $status));
		return true;
	}

	/*************************************************************************/
	if(empty($_POST['option']))
		ServiceFunction::returnErrorCode(-1);
	
	$option = addslashes($_POST['option']);
	switch($option) {
		case 1:
			if(!get_list_tasks())
				ServiceFunction::returnErrorCode(-1);
			break;

		case 2:
			if(!save())
				ServiceFunction::returnErrorCode(-1);
			break;
		
		case 3:
			if(!remove())
				ServiceFunction::returnErrorCode(-1);
			break;
		
		case 4:
			if(!edit())
				ServiceFunction::returnErrorCode(-1);
			break;
		
		case 5:
			if(!change_status())
				ServiceFunction::returnErrorCode(-1);
			break;

		default:
			ServiceFunction::returnErrorCode(-1);
			break;
	}

	exit();
?>
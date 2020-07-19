<?php

	// Разбиваем путь по слэшам, и берем последний скрипт
	$arr_page = explode("/", $_SERVER['PHP_SELF']);
	$col = count($arr_page);
	$page = $arr_page[$col - 1];
	
	$root = "../";
	
	// В первую очередь подгружаем JS скрипты, которые отвечают за основной функционал сайта
	echo "<script src='" . $root . "js/other-js/jquery-3.3.1.min.js?ver=1'></script>";
	echo "<script src='" . $root . "js/other-js/bootstrap.bundle.min.js?ver=1'></script>";
	echo "<script src='" . $root . "js/service-function.js?ver=1'></script>";

	// Подгружаем необходимые компоненты только для необходимых страниц
	switch($page) {
		case 'autorization.php':
			echo "<script src='" . $root . "js/user-scripts.js?ver=1'></script>";
			break;
		
		case 'list-tasks.php':
			echo "<script src='" . $root . "js/basic-scripts.js?ver=1'></script>";
			break;
	}
?>
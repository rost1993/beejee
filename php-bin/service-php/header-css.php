<?php
	// Наиболее часто встречающиеся CSS-скрипты
	$root = 'http://' . $_SERVER['HTTP_HOST'];
	
	// Разбиваем путь по слэшам, и берем последний скрипт
	$arr_page = explode("/", $_SERVER['PHP_SELF']);
	$col = count($arr_page);
	$page = $arr_page[$col - 1];
	
	/*$root_array = explode("/", $root_web);
	if($root_array[count($root_web_array) - 1] != 'BeeJee')
		$root .= '/BeeJee';*/
	
	$root = "../";
	
	echo "<!DOCTYPE HTML>";
	echo "<html lang='en'><head>";
	echo "<meta http-equiv='Content-Type' content='text/html; charset=UTF-8;'>";
	echo "<meta charset='UTF-8'>";
	echo "<meta http-equiv='X-UA-Compatible' content='IE=edge'>";
	echo "<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=no'>";
	
	echo "<link rel='shortcut icon' href='". $root . "images/favicon.ico' type='image/x-icon'>";
	echo "<link rel='stylesheet' href='" . $root . "css/other-css/atx-bootstrap.css'>";
	echo "<link rel='stylesheet' href='" . $root . "css/other-css/font-awesome.min.css'>";
	
	echo "<title>Тестовый стед BeeJee</title>";
?>
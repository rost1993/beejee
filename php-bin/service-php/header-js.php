<?php
	// Наиболее часто встречающиеся JS-скрипты
	$root = 'http://' . $_SERVER['HTTP_HOST'];
	
	$root_array = explode("/", $root_web);
	if($root_array[count($root_web_array) - 1] != 'BeeJee')
		$root .= '/BeeJee';
	
	// В первую очередь подгружаем JS скрипты, которые отвечают за основной функционал сайта
	echo "<script src='" . $root . "/js/other-js/jquery-3.3.1.min.js?ver=1'></script>";
	echo "<script src='" . $root . "/js/other-js/bootstrap.bundle.min.js?ver=1'></script>";
	echo "<script src='" . $root . "/js/service-function.js?ver=1'></script>";
	echo "<script src='" . $root . "/js/user-scripts.js?ver=1'></script>";
	//echo "<script src='" . $root . "/js/basic-scripts.js?ver=4'></script>";
?>
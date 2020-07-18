<?php

session_name('PAPILLON');
session_start();

$root = 'http://' . $_SERVER['HTTP_HOST'] . '/index.php';	// Путь куда необходимо редиректить в случае выхода

$_SESSION = array();
session_unset();
session_destroy();
header('location: ' . $root);

?>
<?php

session_name('BeeJee');
session_start();

$_SESSION = array();
session_unset();
session_destroy();
header('location: ../../index.php');

?>
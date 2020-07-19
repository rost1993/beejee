<?php

require_once('Sessions.php');
require_once('Mysql.php');
require_once('ServiceFunction.php');

/* */

class User {
	
	// Функция авторизации пользователя на веб-ресурсе
	public static function login($login, $password) {
		Session::start();
		$mysql = new mysqlRun();
		
		$sqlQuery = "SELECT * FROM users WHERE login='" . $login . "'";
		
		$mysql = new mysqlRun();
		if(!$mysql->mysqlQuery($sqlQuery, mysqlRun::MYSQL_SELECT)) {
			Session::destroy();
			return -1;
		}
		
		if($mysql->numRows <= 0) {
			Session::destroy();
			return 0;
		}
		
		if($mysql->resultQuery[0]["access"] != 1) {
			Session::destroy();
			return 0;
		}
		
		if(!password_verify($password, $mysql->resultQuery[0]["hash_pass"]))
			return 0;
		
		Session::set("login", $mysql->resultQuery[0]["login"]);
		Session::set("id", $mysql->resultQuery[0]["id"]);
		Session::set("role", $mysql->resultQuery[0]["role"]);
		Session::commit();

		return 1;
	}

	public static function logout() {
		Session::start();
		Session::destroy();
	}

}

?>

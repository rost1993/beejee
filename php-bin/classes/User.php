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
	
	// Функция регистрации нового пользователя в системе
	// Возвращает: -1 - ошибка, 0 - такой пользователь уже существует, 1 - пользователь создан
	public static function register($fam, $imj, $otch, $login, $password, $slugba) {
		
		$mysql = new mysqlRun();
		$sqlQuery = "SELECT login FROM users WHERE login='" . $login . "'";
		
		if(!$mysql->mysqlQuery($sqlQuery, mysqlRun::MYSQL_SELECT))
			return -1;
		
		if($mysql->numRows > 0)
			return 0;
		
		$curDate = date('Y') . "-" . date('m') . "-" . date('d'); // Текущая дата
		$hashSHA = hash('sha256', $login . $fam . $imj . $otch . $password . $curDate);
		$hash_password = password_hash($password, PASSWORD_BCRYPT);

		$sqlQuery = "INSERT INTO users (fam, imj, otch, login, passwd_hash, role, access, slugba, hash, dt_reg)"
				  . " VALUES ('". $fam . "','" . $imj . "','" . $otch . "','" . $login . "','" . $hash_password . "', 1, 0, " . $slugba . ",'" . $hashSHA . "','" . $curDate . "')";
		
		if(!$mysql->mysqlQuery($sqlQuery, mysqlRun::MYSQL_INSERT_OR_UPDATE))
			return -1;
		
		return 1;
	}
	
	
	
	public static function logout() {
		Session::start();
		Session::destroy();
	}
	
	public static function change_role($id, $hash, $role) {
		if((mb_strlen($id) == 0) || (mb_strlen($hash) == 0))
			return -1;
		
		if(mb_strlen($role) == 0)
			$role = 1;
		
		if(!User::check_level_user(8))
			return -1;
		
		$sqlQuery = "UPDATE users SET role=" . $role . " WHERE id=" . $id . " AND hash='" . $hash . "'";
		$mysql = new mysqlRun();
		
		if(!$mysql->mysqlQuery($sqlQuery, mysqlRun::MYSQL_INSERT_OR_UPDATE))
			return -1;
		
		Session::start();
		Session::set('role', $role);
		Session::commit();
		
		return 1;
	}
	
	public static function change_slugba($id, $hash, $slugba) {
		if((mb_strlen($id) == 0) || (mb_strlen($hash) == 0) || (mb_strlen($slugba) == 0))
			return -1;
		
		if(!User::check_level_user(8))
			return -1;
		
		$sqlQuery = "UPDATE users SET slugba=" . $slugba . " WHERE id=" . $id . " AND hash='" . $hash . "'";
		$mysql = new mysqlRun();
		
		if(!$mysql->mysqlQuery($sqlQuery, mysqlRun::MYSQL_INSERT_OR_UPDATE))
			return -1;
		
		Session::start();
		Session::set('slugba', $slugba);
		Session::commit();
		
		return 1;
	}
	
	// Функция изменения группы пользователя
	public static function change_group($id, $hash, $group) {
		if((mb_strlen($id) == 0) || (mb_strlen($hash) == 0) || (mb_strlen($group) == 0))
			return -1;
		
		if(!User::check_level_user(8))
			return -1;
		
		$sqlQuery = "UPDATE users SET group_user=" . $group . " WHERE id=" . $id . " AND hash='" . $hash . "'";
		$mysql = new mysqlRun();
		
		if(!$mysql->mysqlQuery($sqlQuery, mysqlRun::MYSQL_INSERT_OR_UPDATE))
			return -1;
		
		Session::start();
		Session::set('group', $group);
		Session::commit();
		
		return 1;
	}
	
	// Функция загрузки содержимого для панели администратора
	// RETURN: -1 - error, -2 - access denied, 1 - succesfully
	public static function get_list_users(&$list_users) {
		Session::start();
		$role = Session::get('role');
		Session::commit();
		
		if($role < 8)
			return -2;
		
		$sqlQuery = "SELECT * FROM users WHERE role<>9 ORDER BY id ASC";
		if($role == 9)
			$sqlQuery = "SELECT * FROM users ORDER BY id ASC";
		
		$mysql = new mysqlRun();
		if(!$mysql->mysqlQuery($sqlQuery, mysqlRun::MYSQL_SELECT))
			return -1;

		$list_users = array();
		
		for($i = 0; $i < $mysql->numRows; $i++)
			array_push($list_users, $mysql->resultQuery[$i]);

		return 1;
	}
	
	// Функция проверка прав доступа у пользователя.
	// Имеет ли право пользователь изменять различные настройки у других пользователь
	public static function check_level_user($role = 0) {
		if(!is_numeric($role))
			return false;
		
		Session::start();
		$id_current_user = Session::get('id');
		$hash_current_user = Session::get('security');
		Session::commit();
		
		if(!User::get_user_info($id_current_user, $hash_current_user, $current_user_info))
			return false;
		
		if($current_user_info['access'] != 1)
			return false;
		
		if($current_user_info['role'] < $role)
			return false;
		
		return true;
	}
	
	public static function get_user_info($id, $hash, &$user_info, $mode = 1) {
		$sqlQuery = '';
		
		if($mode == 1)
			$sqlQuery = "SELECT id, fam, imj, otch, role, slugba, hash, access FROM users WHERE id=" . $id . " AND hash='" . $hash . "'";
		else
			$sqlQuery = "SELECT a.id, a.fam, a.imj, a.otch, b.text as role, c.text as slugba, a.hash, a.access, a.login FROM users a "
					  . " INNER JOIN role b ON a.role = b.category "
					  . " INNER JOIN s2i_klass c ON a.slugba = c.kod AND c.nomer = 1"
					  . " WHERE a.id=" . $id . " AND a.hash='" . $hash . "'";
		
		$mysql = new mysqlRun();
		if(!$mysql->mysqlQuery($sqlQuery, mysqlRun::MYSQL_SELECT))
			return false;

		$user_info = array();
		if($mysql->numRows > 0) {
			if($mode == 1)
				$user_info = $mysql->resultQuery[0];
			else
				array_push($user_info, $mysql->resultQuery[0]);
		}
		
		return true;
	}
	
	public static function remove_user($id, $hash) {
		if(!User::check_level_user(8))
			return -1;
		
		$sqlQuery = "DELETE FROM users WHERE id=" . $id . " AND hash='" . $hash . "'";
		$mysql = new mysqlRun();
		if(!$mysql->mysqlQuery($sqlQuery, mysqlRun::MYSQL_SELECT))
			return -1;
		
		return 1;
	}

	public static function change_access($id, $hash, $access) {
		if((mb_strlen($id) == 0) || (mb_strlen($hash) == 0))
			return -1;
		
		if($access != 1)
			$access = 0;

		if(!User::check_level_user(8))
			return -1;
		
		$sqlQuery = "UPDATE users SET access=" . $access . " WHERE id=" . $id . " AND hash='" . $hash . "'";
		$mysql = new mysqlRun();
		
		if(!$mysql->mysqlQuery($sqlQuery, mysqlRun::MYSQL_INSERT_OR_UPDATE))
			return -1;
		
		return 1;
	}
	
	public static function reset_password($id, $hash, $default_password) {
		if((mb_strlen($id) == 0) || (mb_strlen($hash) == 0) || (mb_strlen($default_password) == 0))
			return -1;
		
		if(!User::check_level_user(8))
			return -1;
		
		$hash_password = password_hash($default_password, PASSWORD_BCRYPT);
		
		$sqlQuery = "UPDATE users SET passwd_hash='" . $hash_password . "' WHERE id=" . $id . " AND hash='" . $hash . "'";
		$mysql = new mysqlRun();
		
		if(!$mysql->mysqlQuery($sqlQuery, mysqlRun::MYSQL_INSERT_OR_UPDATE))
			return -1;
		
		return 1;
	}

	public static function change_user_personal_date($id, $hash, $fam, $imj, $otch) {
		if((mb_strlen($id) == 0) || (mb_strlen($hash) == 0) || (mb_strlen($fam) == 0) || (mb_strlen($imj) == 0))
			return -1;
		
		$sqlQuery = "UPDATE users SET fam='" . $fam . "', imj='" . $imj . "', otch='" . $otch . "' WHERE id=" . $id . " AND hash='" . $hash . "'";
		$mysql = new mysqlRun();
		
		if(!$mysql->mysqlQuery($sqlQuery, mysqlRun::MYSQL_INSERT_OR_UPDATE))
			return -1;
		
		return 1;
	}
	
	public static function change_password($id, $hash, $new_password, $old_password) {
		if((mb_strlen($id) == 0) || (mb_strlen($hash) == 0) || (mb_strlen($new_password) == 0) || (mb_strlen($old_password) == 0))
			return -1;
		
		$sqlQuery = "SELECT passwd_hash FROM users WHERE id=" . $id . " AND hash='" . $hash . "'";
		$mysql = new mysqlRun();
		if(!$mysql->mysqlQuery($sqlQuery, mysqlRun::MYSQL_SELECT))
			return -1;
		
		if($mysql->numRows == 0)
			return -1;
		
		if(!password_verify($old_password, $mysql->resultQuery[0]['passwd_hash']))
			return 0;
		
		$hash_password = password_hash($new_password, PASSWORD_BCRYPT);
		
		$sqlQuery = "UPDATE users SET passwd_hash='" . $hash_password . "' WHERE id=" . $id . " AND hash='" . $hash . "'";
		if(!$mysql->mysqlQuery($sqlQuery, mysqlRun::MYSQL_INSERT_OR_UPDATE))
			return -1;
		return 1;
	}

	// Функция проверки авторизован пользователь или нет
	public static function is_logged() {
		Session::start();
		
		$id = Session::get('id');
		$role = Session::get('role');
		$login = Session::get('login');
		$hash = Session::get('security');
		$slugba = Session::get('slugba');
		
		Session::commit();
		
		if($id == null || $login == null || $role == null || $slugba == null || $hash == null)
			return false;
		
		return true;
	}
	
	public static function check_access_current_user() {
		if(!self::is_logged())
			return false;
		
		Session::start();
		$id = Session::get('id');
		$hash = Session::get('security');
		$login = Session::get('login');
		Session::commit();
		
		$mysql = new mysqlRun();
		$sqlQuery = "SELECT * FROM users WHERE id=" . $id . " AND login='" . $login . "' AND hash='" . $hash . "'";
		if(!$mysql->mysqlQuery($sqlQuery, mysqlRun::MYSQL_SELECT))
			return false;
		
		// Если такой пользователь не найден, то уничтожаем сессию
		if($mysql->numRows == 0) {
			Session::start();
			Session::destroy();
			return false;
		}
		
		// Если доступ пользователю заблокирован, то уничтожаем сессию
		if($mysql->resultQuery[0]['access'] != 1) {
			Session::start();
			Session::destroy();
			return false;
		}
		
		// Если пользователь заблокирован, то уничтожаем сессию
		if($mysql->resultQuery[0]['block'] != 0) {
			Session::start();
			Session::destroy();
			return false;
		}
		
		Session::start();
		Session::set('id', $mysql->resultQuery[0]['id']);
		Session::set('login', $mysql->resultQuery[0]['login']);
		Session::set('security', $mysql->resultQuery[0]['hash']);
		Session::set('role', $mysql->resultQuery[0]['role']);
		Session::set('slugba', $mysql->resultQuery[0]['slugba']);
		Session::commit();
		
		return true;
	}

	// Функция получения ID пользователя.
	// Сначала производится проверка авторизован ли пользователь, затем формируется ID пользователя
	public static function get_user_id() {
		if(!self::is_logged())
			return 0;
		
		Session::start();
		$id = Session::get('id');
		Session::commit();
		
		return $id;
	}
	
	// Функция получения расширенных настроек пользователя.
	// Получает список всех районов которые добавлены пользователю
	public static function get_add_slugba($id) {
		if(!ServiceFunction::check_number($id))
			return false;
		
		$sqlQuery = "SELECT users_list_kodrai.*, x1.text, users.slugba FROM users_list_kodrai "
			. " LEFT JOIN s2i_klass x1 ON x1.kod=users_list_kodrai.kodrai AND x1.nomer=1 "
			. " INNER JOIN users ON users.id=" . $id
			. " WHERE id_user=" . $id;
		$db = new mysqlRun();
		if(!$db->mysqlQuery($sqlQuery, mysqlRun::MYSQL_SELECT))
			return false;
		return $db->resultQuery;
	}
	
	// Функция получения расширенных настроек пользователя.
	// Получает список всех районов которые не добавлены пользователю
	public static function get_no_add_slugba($id) {
		if(!ServiceFunction::check_number($id))
			return false;
		
		$sqlQuery = "SELECT * FROM s2i_klass "
			. " LEFT JOIN users_list_kodrai ON users_list_kodrai.kodrai=s2i_klass.kod AND s2i_klass.nomer=1 AND users_list_kodrai.id_user=" . $id
			. " WHERE s2i_klass.nomer=1 AND users_list_kodrai.id IS NULL";
		$db = new mysqlRun();
		if(!$db->mysqlQuery($sqlQuery, mysqlRun::MYSQL_SELECT))
			return false;
		return $db->resultQuery;
	}
	
	// Добавление или удаление района для расширенных настроек пользователя
	public static function save_and_remove_slugba($nsyst, $data) {
		if(!ServiceFunction::check_number($nsyst))
			return false;
		
		if(!$array_data_decode = json_decode($data))
			return false;
		
		Session::start();
		$id_user = Session::get('id');
		Session::commit();

		$sqlQueryInsert = $sqlQueryDelete = '';
		
		foreach($array_data_decode as $field => $array_value) {
			if($array_value == 'add')
				$sqlQueryInsert .= (mb_strlen($sqlQueryInsert) == 0) ? "(" . $nsyst . "," . $field . "," . $id_user . ")" : ",(" . $nsyst . "," . $field . "," . $id_user . ")";
			else
				$sqlQueryDelete .= (mb_strlen($sqlQueryDelete) == 0) ? $field : "," . $field;
		}
		
		$db = new mysqlRun();
		
		if(mb_strlen($sqlQueryInsert) != 0) {
			$sqlQueryInsert = "INSERT INTO users_list_kodrai (id_user, kodrai, sh_polz) VALUES " . $sqlQueryInsert;
			if(!$db->mysqlQuery($sqlQueryInsert, mysqlRun::MYSQL_INSERT_OR_UPDATE))
				return false;
		}
		
		if(mb_strlen($sqlQueryDelete) != 0) {
			$sqlQueryDelete = "DELETE FROM users_list_kodrai WHERE id_user=" . $nsyst . " AND kodrai IN (" . $sqlQueryDelete . ")";
			if(!$db->mysqlQuery($sqlQueryDelete, mysqlRun::MYSQL_OTHER))
				return false;
		}
		
		/*$fp = fopen("../../excel/rost.txt", "a");
		fwrite($fp, $sqlQueryInsert);
		fwrite($fp, $sqlQueryDelete);
		fclose(fp);*/
		
		return true;
	}
	
	// Функция получения списка всех районов для конкретного пользователя
	public static function get_all_slugba() {
		Session::start();
		$id_user = Session::get('id');
		$slugba = Session::get('slugba');
		Session::commit();
		
		$db = new mysqlRun();
		$sqlQueryDelete = "SELECT kodrai FROM users_list_kodrai WHERE id_user=" . $id_user;
		if(!$db->mysqlQuery($sqlQueryDelete, mysqlRun::MYSQL_SELECT))
			return false;
		
		$list_slugba = '';
		for($i = 0; $i < count($db->resultQuery); $i++)
			$list_slugba .= (mb_strlen($list_slugba) == 0) ? $db->resultQuery[$i]['kodrai'] : ',' . $db->resultQuery[$i]['kodrai'];
		
		if(mb_strlen($list_slugba) == 0)
			$list_slugba = $slugba;
		
		return "(" . $list_slugba . ")";
	}
}

?>

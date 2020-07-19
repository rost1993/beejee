<?php

require_once('Mysql.php');
require_once('Sessions.php');
require_once('ServiceFunction.php');

/* */

class Tasks {

	protected $table = '';

	public function __construct() {
		$this->table = 'list_tasks';
	}
	
	
	// Функция сохранения объекта
	public function save($array_data, &$msg_error) {
		if(empty($array_data['JSON']) || empty($array_data['nsyst']))
			return false;
		
		$id = addslashes($array_data['nsyst']);
		
		if(!ServiceFunction::check_number($id))
			return false;
		
		Session::start();
		$role = Session::get('role');
		Session::commit();
		
		if(($role == 0 || $role == null) && ($id != -1))
			return false;

		// Определяем тип вставка или обновление
		$flg_insert = false;
		if($id == -1)
			$flg_insert = true;
		else
			$flg_insert = false;
		
		if(!ServiceFunction::check_field($array_data['JSON'], $message_error)) {
			$msg_error = $message_error;
			return false;
		}
		
		$sqlQuery = ServiceFunction::generate_sql_query($flg_insert, $array_data['JSON'], $id, $this->table);	
		$mysql = new mysqlRun();
		if(!$mysql->mysqlQuery($sqlQuery, mysqlRun::MYSQL_INSERT_OR_UPDATE))
			return false;

		if($flg_insert)
			$id = $mysql->id;
		
		return $id;
	}

	public function get_list_tasks($order_field = 'name_user', $order_type = 1) {
		$sorting = ($order_type == 1) ? ' ASC ' : 'DESC' ;
		
		$sqlQuery = "SELECT * FROM " . $this->table . " ORDER BY " . $order_field . " " . $sorting;
		$mysql = new mysqlRun();
		if(!$mysql->mysqlQuery($sqlQuery, mysqlRun::MYSQL_SELECT))
			return false;
		return $mysql->resultQuery;
	}
	
	public function remove($id) {
		if(!ServiceFunction::check_number($id))
			return false;
		
		Session::start();
		$role = Session::get('role');
		Session::commit();
		
		if(($role == 0 || $role == null))
			return false;

		$sqlQuery = "DELETE FROM " . $this->table . " WHERE id=" . $id;
		$mysql = new mysqlRun();
		if(!$mysql->mysqlQuery($sqlQuery, mysqlRun::MYSQL_OTHER))
			return false;
		
		return true;
	}
	
	public function get($id) {
		if(!ServiceFunction::check_number($id))
			return false;
		
		Session::start();
		$role = Session::get('role');
		Session::commit();
		
		if(($role == 0 || $role == null))
			return false;

		$sqlQuery = "SELECT * FROM " . $this->table . " WHERE id=" . $id;
		$mysql = new mysqlRun();
		if(!$mysql->mysqlQuery($sqlQuery, mysqlRun::MYSQL_SELECT))
			return false;
		return $mysql->resultQuery;
	}
	
	public function change_status($id) {
		if(!ServiceFunction::check_number($id))
			return false;
		
		Session::start();
		$role = Session::get('role');
		Session::commit();
		
		if(($role == 0 || $role == null))
			return false;
		
		$sqlQuery = "UPDATE " . $this->table . " SET status=MOD(status + 1, 2)  WHERE id=" . $id;
		$mysql = new mysqlRun();
		if(!$mysql->mysqlQuery($sqlQuery, mysqlRun::MYSQL_OTHER))
			return false;
		
		return true;
	}

}

?>

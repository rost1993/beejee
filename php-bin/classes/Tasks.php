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
	public function save($array_data) {
		if(empty($array_data['JSON']) || empty($array_data['nsyst']))
			return false;
		
		$id = addslashes($array_data['nsyst']);
		
		if(!ServiceFunction::check_number($id))
			return false;

		// Определяем тип вставка или обновление
		$flg_insert = false;
		if($id == -1)
			$flg_insert = true;
		else
			$flg_insert = false;
		
		$sqlQuery = ServiceFunction::generate_sql_query($flg_insert, $array_data['JSON'], $id, $this->table);	
		$mysql = new mysqlRun();
		if(!$mysql->mysqlQuery($sqlQuery, mysqlRun::MYSQL_INSERT_OR_UPDATE))
			return false;

		if($flg_insert)
			$id = $mysql->id;
		
		return $id;
	}

	public function get_list_tasks() {
		$sqlQuery = "SELECT * FROM " . $this->table;
		$mysql = new mysqlRun();
		if(!$mysql->mysqlQuery($sqlQuery, mysqlRun::MYSQL_SELECT))
			return false;
		return $mysql->resultQuery;
	}

}

?>

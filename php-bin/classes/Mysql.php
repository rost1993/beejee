<?php

/* Класс для взаимодействия с базой данных */

class mysqlRun {

	// Константы для типа запроса
	const MYSQL_INSERT_OR_UPDATE = 1;
	const MYSQL_SELECT = 2;
	const MYSQL_OTHER = 3;
	
	// Настройки подключения к базе данных
	private $login = "beejee";
	private $password = "beejee";
	private $ipAddress = "localhost";
	private $database = "beejee";
	
	// Глобальные переменные доступные пользователю
	public $msgError = "";			// Глобальная переменная, содержащая ошибки при использовании класса
	public $numRows = 0;			// Количество строк, возвращаемое запросом
	public $id = 0;					// ID - значение поля AUTOINCREMENT (только для INSERT)
	public $resultQuery = array();	// Массив с результатами выборки
	
	// Подключение к базе данных
	private function mysqlConnect($type_database) {
		
		$database = $this->database;
		if($type_database == 1)
			$database = $this->database;
		else if($type_database == 2)
			$database = $this->database_analitycs;
		else
			$database = "";
		
		$link = mysqli_connect($this->ipAddress, $this->login, $this->password, $database);
		
		if(!$link) {
			$this->msgError = mysqli_connect_error($link);
			return NULL;
		}
		
		mysqli_query($link, "SET NAMES 'utf8'");

		return $link;
	}
	
	// Закрытие соединения с базой данных
	private function mysqlClose($link) {
		
		if(mysqli_close($link))
			return TRUE;
		else
			return FALSE;
	}
	
	/*
	 * Функция обработки запроса к базе данных
	 * $query - запрос к базе данных
	 * $mode - режим запроса к базе данных. Необходимо использовать одну из констант:
		MYSQL_INSERT_OR_UPDATE - insert
		MYSQL_OTHER - other query
		MYSQL_SELECT - select
	 * $type_database - база данных к которой необходимо организовать подключение
	 */
	public function mysqlQuery($query, $mode, $type_database = 1) {
		
		$this->resultQuery = array();
		
		if(!(($mode == self::MYSQL_INSERT_OR_UPDATE) || ($mode == self::MYSQL_OTHER) || ($mode == self::MYSQL_SELECT))) {
			$this->msgError = 'UNDEFINED CODE MYSQL QUERY';
			return FALSE;
		}
		
		if(($link = $this->mysqlConnect($type_database)) == NULL)
			return FALSE;
		
		if(!($result = mysqli_query($link, $query))) {
			$this->msgError = mysqli_error($link);
			return FALSE;
		}
		
		if(($mode == self::MYSQL_INSERT_OR_UPDATE) || ($mode == self::MYSQL_OTHER)) {
			$this->id = mysqli_insert_id($link);
			$this->mysqlClose($link);
			return TRUE;
		}
		
		if($mode == self::MYSQL_SELECT) {
			
			$this->numRows = mysqli_num_rows($result);
			
			while($data = mysqli_fetch_assoc($result))
				array_push($this->resultQuery, $data);
			
			
			mysqli_free_result($result);
			$this->mysqlClose($link);
			
			return TRUE;
		}
	}
}
?>

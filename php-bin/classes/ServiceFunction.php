<?php

/* */
class ServiceFunction {
	// Функция возврата кода ошибки
	public static function returnErrorCode($error_code) {
		echo json_encode(array($error_code));
		exit();
	}
	// Функция конвертирования даты из формата MySQL в нормальный человеческий вид
	public static function convertToDate($date) {
		if(mb_strlen(trim($date)) == 0)
			return "";
		
		$newDate = mb_substr($date, 8, 2);
		$newDate .= "." . mb_substr($date, 5, 2);
		$newDate .= "." . mb_substr($date, 0, 4);
		return $newDate;
	}
	
	// Функция конвертирования даты из формата MySQL в нормальный человеческий вид
	public static function convertToMySQLDateFormat($date) {
		if(mb_strlen(trim($date)) == 0)
			return "";
		
		$newDate = mb_substr($date, 6, 4);
		$newDate .= "-" . mb_substr($date, 3, 2);
		$newDate .= "-" . mb_substr($date, 0, 2);
		return $newDate;
	}

	// Функция формирования SQL-запроса для сохранения/обновления информации о водителе
	public static function generate_sql_query($flg_insert, $array_data, $nsyst = 0, $table) {
		$sqlQuery = "";
		
		if(!$array_data_decode = json_decode($array_data))
			return $sqlQuery;
		
		// В зависимости от добавления или корректировки выбираем то или иное действие
		if($flg_insert) {
			$sql_field = $sql_value = "";
			
			foreach($array_data_decode as $field => $array_value) {
				$array_value_decode = (array)$array_value;

				$array_value_decode['value'] = str_replace("\\", "", $array_value_decode['value']);

				if(mb_strlen($sql_field) == 0)
					$sql_field = $field;
				else
					$sql_field .= "," . $field;
				
				if($array_value_decode['type'] == 'char') {
					if(mb_strlen($sql_value) == 0)
						$sql_value = "'" . $array_value_decode['value'] . "'";
					else
						$sql_value .= ",'" . $array_value_decode['value'] . "'";
				} else if($array_value_decode['type'] == 'date') {
					
					// Обработка даты особая, если дата пустая то вставляем пустое значение
					$temp_value = "";
					if(mb_strlen(trim($array_value_decode['value'])) == 0)
						$temp_value = 'NULL';
					else
						$temp_value = "'" .  self::convertToMySQLDateFormat($array_value_decode['value']) . "'";

					if(mb_strlen($sql_value) == 0)
						$sql_value .= $temp_value;
					else
						$sql_value .= "," . $temp_value;
				} else if ($array_value_decode['type'] == 'checkbox') {
					$temp_value = "";
					
					if($array_value_decode['value'] == 'true')
						$temp_value .= '1';
					else
						$temp_value .= '0';
					
					if(mb_strlen($sql_value) == 0)
						$sql_value .= $temp_value;
					else
						$sql_value .= ',' . $temp_value;
				} else {
					// Обработка числа особая, если дата пустая то вставляем пустое значение
					$temp_value = "";
					if(mb_strlen(trim($array_value_decode['value'])) == 0)
						$temp_value = 'NULL';
					else
						$temp_value = $array_value_decode['value'];
					
					if(mb_strlen($sql_value) == 0)
						$sql_value = $temp_value;
					else
						$sql_value .= "," . $temp_value;
				}
			}
			
			$sqlQuery = "INSERT INTO " . $table . " (" . $sql_field . ") VALUES (" . $sql_value . ")";
		} else {
			$sql = "";
			
			foreach($array_data_decode as $field => $array_value) {
				$array_value_decode = (array)$array_value;

				$array_value_decode['value'] = str_replace("\\", "", $array_value_decode['value']);

				if($array_value_decode['type'] == 'char') {
					if(mb_strlen($sql) == 0)
						$sql .= $field . "='" . $array_value_decode['value'] . "'";
					else
						$sql .= "," . $field . "='" . $array_value_decode['value'] . "'";
				} else if($array_value_decode['type'] == 'date') {
					
					// Обработка даты особая, если дата пустая то вставляем пустое значение
					$temp_value = "";
					if(mb_strlen(trim($array_value_decode['value'])) == 0)
						$temp_value = 'NULL';
					else
						$temp_value = "'" .  self::convertToMySQLDateFormat($array_value_decode['value']) . "'";

					if(mb_strlen($sql) == 0)
						$sql .= $field . "=" . $temp_value;
					else
						$sql .= "," . $field . "=" . $temp_value;
				} else if ($array_value_decode['type'] == 'checkbox') {
					$temp_value = '';
					if($array_value_decode['value'] == 'true')
						$temp_value = '=1';
					else
						$temp_value = '=0';
					
					if(mb_strlen($sql) == 0)
						$sql .= $field . $temp_value;
					else
						$sql .= ',' . $field . $temp_value;
				} else {
					// Обработка числа особая, если дата пустая то вставляем пустое значение
					$temp_value = "";
					if(mb_strlen(trim($array_value_decode['value'])) == 0)
						$temp_value = 'NULL';
					else
						$temp_value = $array_value_decode['value'];
					
					if(mb_strlen($sql) == 0)
						$sql .= $field . "=" . $temp_value;
					else
						$sql .= "," . $field . "=" . $temp_value;
				}
			}
			$sqlQuery = "UPDATE " . $table . " SET " . $sql . " WHERE id=" . $nsyst;
		}

		return $sqlQuery;
	}

	// Функция проверки переменной на число
	// RETURN: TRUE - если число, FALSE - если не число
	public static function check_number($value) {
		if(empty($value) || ($value == 0) || (mb_strlen($value) == 0))
			return false;
		
		if(!is_numeric($value))
			return false;
		
		return true;
	}
}
?>

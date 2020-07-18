<?php

/*
	Класс для взаимодействия с сессиями и файлами куки
	
	Переменные:
		life_time - жизненый цикл хранения куки
		name_session - название сессии
	
	Функции:
		is_session_started - функция проверяет запущена сессия или нет. Возвращает TRUE - запущена, FALSE - нет.
		
		start - функция запуска взаимодействия с сессиями. Необходимо первым делом запускать данную функцию. Инициализирует сессию: задает ей имя.
		
		destroy - функция уничтожения сессии. Уничтожает все сессиионные переменные и закрывает сессию.
		
		get - функция получения значения из суперглобального ассоциативного массива $_SESSION по названию переменной. Если значение не будет найдено в массиве будет возвращен NULL.
		
		set - функция записи значения в суперглобальный ассоциативнный массив $_SESSION.
		
		del - функция удаления конкретного значения из суперглобального массива $_SESSION.
		
		clear - функция очистки всех сессионных переменных (очистка суперглобального массива $_SESSION).
		
		restart - функция перезапуска взаимодействия с сессиями.
		
		get_array_session - функция получения всего суперглобального ассоциативного массива $_SESSION.
		
		commit - функция записи всех изменений в сессию и закрытие сессии для освобождения ресурсов.
				После окончания взаимодействия с сессией рекомендовано исопльзовать данную функцию.
				Дальнейшее взаимодействие с сессиями возможно только после вызова функции start
		
		set_cookie - функция записи значения в суперглобальный ассоциативнный массив $_COOKIE.
		
		get_cookie - функция получения значения из суперглобального ассоциативного массива $_COOKIE по названию переменной.
	
	Copyright: Rostislav Gashin (rost1993), 2019.
*/

class Session {
	// Life time COOKIE
	private static $life_time = 60*60*24*30*12;
	
	// Global name session
	private static $name_session = "BeeJee";
	
	// Checked started session
	private static function is_session_started() {
		if(session_status() === PHP_SESSION_ACTIVE)
			return true;
		else
			return false;
	}
	
	// Start session
	public static function start() {
		if(!self::is_session_started()) {
			session_name(self::$name_session);
			session_start();
		}
	}
	
	// Destroy session. Clear array $_SESSION
	public static function destroy() {
		
		if(self::is_session_started())  {
			$_SESSION = array();
			session_name(self::$name_session);
			session_unset();
			session_destroy();
		} else {
			trigger_error('Session is not started!', E_USER_WARNING);
		}
	}
	
	// Get value for the array $_SESSION
	public static function get($name) {
		if(self::is_session_started()) {
			return isset($_SESSION[$name]) ? $_SESSION[$name] : null;
		} else {
			trigger_error('You should start Session first', E_USER_WARNING);
		}
	}
	
	// Set value for the array $_SESSION
	public static function set($name, $value) {
		if(self::is_session_started()) {
			$_SESSION[$name] = $value;
		} else {
			trigger_error('You should start Session first', E_USER_WARNING);
		}
	}
	
	// Delete value of the array $_SESSION
	public static function del($name) {
		if(self::is_session_started()) {
			session_name(self::$name_session);
			unset($_SESSION[$name]);
		} else {
			trigger_error('You should start Session first', E_USER_WARNING);
		}
	}
	
	// Clear all value of the array $_SESSION
	public static function clear() {
		if(self::is_session_started()) {
			session_name(self::$name_session);
			unset($_SESSION);
		} else {
			trigger_error('You should start Session first', E_USER_WARNING);
		}
	}
	
	// Restart interface to run session
	public static function restart() {
		self::destroy();
		self::start();
	}
	
	// Get all value of the array $_SESSION
	public static function get_array_session() {
		if(self::is_session_started()) {
			session_name(self::$name_session);
			return $_SESSION;
		} else {
			trigger_error('You should start Session first', E_USER_WARNING);
		}
	}
	
	// Commit all value session. Closed session interface
	public static function commit() {
		if(self::is_session_started()) {
			session_write_close();
		} else {
			trigger_error('You should start Session first', E_USER_WARNING);
		}
	}
	
	// Set value of the array $_COOKIE
	public static function set_cookie($name_cookie, $value) {
		setcookie($name_cookie, $value, time() + self::$life_time, '/');
	}
	
	// Get value of the array $_COOKIE
	public static function get_cookie($name_cookie) {
		return isset($_COOKIE[$name_cookie]) ? $_COOKIE[$name_cookie] : null;
	}
}

?>

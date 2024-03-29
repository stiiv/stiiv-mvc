<?php

class Session {

	public static function init() {
		session_start();
	}

	public static function set($key, $value) {
		return $_SESSION[$key] = $value;
	}

	public static function multi_set(array $array) {
		foreach($array as $key => $value) {
			self::set($key, $value);
		}
	}

	public static function get($key) {
		return isset($_SESSION[$key]) ? $_SESSION[$key] : '' ;
	}

	public static function view() {
		pretty_print($_SESSION, "SESSION");
	}

	public static function delete($key) {
		if( isset($_SESSION[$key]) ) {
			unset($_SESSION[$key]);
		}
	}

	public static function clean() {
		return $_SESSION = array();
	}

	public static function destroy() {
		session_destroy();
	}

}

Session::init();

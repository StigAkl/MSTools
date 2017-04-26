<?php

class Db {
	private static $instance = NULL;

	private static $servername = "thenewworldproject.com.mysql";
	private static $username = "thenewworldproject_com_ms";
	private static $password = "mafiaspillet123";

	private function __construct() {
	}

	private function __clone() {}

	public static function getInstance() {
		if(!isset(self::$instane)) {
			$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
			self::$instance = new PDO("mysql:host=$servername;dbname=thenewworldproject_com_ms", self::$username, self::$password);
		}
		return self::$instance;
	}
}
?>
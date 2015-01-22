<?php
define('DB_NAME',			'themarc_nl_contact');
define('DB_HOST',			'127.0.0.1');
define('DB_USERNAME',		'thema_nl_contact');
define('DB_PASSWORD',		'aM74xdGMKeNm');

define('EMAIL_ADDR',		'info@themarc.nl');
define('EMAIL_NAME',		'TheMarc.nl Recipes');

class db
{
	public static function connect(){
		db::query();
		if (mysqli_connect_errno()) {
			printf("Connect failed: %s\n", mysqli_connect_error());
			exit();
		}
		return db::query();
	}
	
	public static function disconnect() {
		$dbQuery = db::query();
		mysqli_close($dbQuery);
	}
	
	public static function query() {
		return new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
	}
}

?>
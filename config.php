<?php
// config.php
	$DB_HOST = 'localhost';
	$DB_USER = 'root';
	$DB_PASS = '';        // change if you have a password
	$DB_NAME = 'abclibrary';

	$conn = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
	if (!$conn) {
		die("DB Connection failed: " . mysqli_connect_error());
	}
?>
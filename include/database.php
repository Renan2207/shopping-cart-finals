<?php  
	$dbHost = "localhost";
	$dbUser = "root";
	$dbPass = "";
	$dbName = "shopping_db_cart"; 
	
	$conn = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);

	if (!$conn) {
		die("Database Connection Failed!");
	}

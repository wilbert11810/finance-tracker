<?php 
    $host = getenv("DB_HOST");
	$username = getenv("DB_USER");
	$password = getenv("DB_PASSWORD");
	$dbname = getenv("DB_NAME");

    $conn = new mysqli($host, $username, $password, $dbname);

    if ($conn-> connect_error) {
        die("Connection failed: " . $conn-> connect_error);
    }
   

<?php
$host     = getenv("DB_HOST");
$username = getenv("DB_USER");
$password = getenv("DB_PASSWORD");
$dbname   = getenv("DB_NAME");

// mysqli throws mysqli_sql_exception on failure (PHP 8.1+ default), so a bad
// connection is caught by the handler in bootstrap.php instead of printing the
// host and credentials to the browser.
$conn = new mysqli($host, $username, $password, $dbname);

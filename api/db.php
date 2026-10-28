<?php
$conn = mysqli_init();

// Aiven requires TLS. DB_SSL_CA is the path to its CA certificate on the
// server; it is unset locally, so local Docker connects without TLS.
$ca = getenv("DB_SSL_CA");
if ($ca) {
    $conn->ssl_set(null, null, $ca, null, null);
}

// A failed connection throws mysqli_sql_exception (PHP 8.1+ default), which the
// handler in bootstrap.php turns into a generic 500 instead of leaking the host.
$conn->real_connect(
    getenv("DB_HOST"),
    getenv("DB_USER"),
    getenv("DB_PASSWORD"),
    getenv("DB_NAME"),
    (int) (getenv("DB_PORT") ?: 3306),
    null,
    $ca ? MYSQLI_CLIENT_SSL : 0
);

$conn->set_charset("utf8mb4");

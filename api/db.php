<?php
$conn = mysqli_init();

// DB_SSL_CA is the "use TLS" switch: set in the deployed environment, unset
// locally (so local Docker connects without TLS). Aiven requires TLS, and its
// CA certificate is public, so it ships in the image at api/ca.pem and is
// preferred over any configured path -- no secret file to misconfigure.
$ca = getenv("DB_SSL_CA");
if ($ca) {
    $bundled = __DIR__ . "/ca.pem";
    if (is_file($bundled)) {
        $ca = $bundled;
    }
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

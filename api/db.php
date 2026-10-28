<?php
$conn = mysqli_init();

// Aiven requires TLS. DB_SSL_CA is the path to its CA certificate on the
// server; it is unset locally, so local Docker connects without TLS.
$ca = getenv("DB_SSL_CA");
if ($ca) {
    // --- TEMP DIAGNOSTIC: remove once the secret file is confirmed working ---
    error_log("DBG ca_path=" . var_export($ca, true)
        . " is_file=" . var_export(is_file($ca), true)
        . " is_readable=" . var_export(is_readable($ca), true));
    if (is_file($ca)) {
        $c = (string) @file_get_contents($ca);
        $lines = preg_split('/\R/', rtrim($c));
        error_log("DBG ca_size=" . strlen($c)
            . " md5=" . md5($c)
            . " begin_count=" . substr_count($c, "BEGIN CERTIFICATE")
            . " first=" . var_export($lines[0] ?? "", true)
            . " last=" . var_export($lines[count($lines) - 1] ?? "", true));
    }
    // --- END TEMP DIAGNOSTIC ---
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

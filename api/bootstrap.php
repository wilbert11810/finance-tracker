<?php
ini_set("display_errors", "0");
session_set_cookie_params([
    "httponly" => true,
    "secure"   => !empty($_SERVER["HTTPS"]) || ($_SERVER["HTTP_X_FORWARDED_PROTO"] ?? "") === "https",
    "samesite" => "Lax",
]);
session_start();
header("Content-Type: application/json");

function json_out(array $body, int $status = 200): never {
    http_response_code($status);
    echo json_encode($body);
    exit;
}

function require_user(): int {
    if (!isset($_SESSION["user_id"])) json_out(["error" => "Unauthorized"], 401);
    return (int) $_SESSION["user_id"];
}

// True only for a real calendar date in YYYY-MM-DD form (rejects "2026-13-40").
function valid_date(string $date): bool {
    $d = DateTime::createFromFormat("Y-m-d", $date);
    return $d && $d->format("Y-m-d") === $date;
}

// Any uncaught error (including a thrown mysqli_sql_exception) is logged on the
// server and returned to the client as a generic message, so raw SQL and file
// paths never reach the browser.
set_exception_handler(function (Throwable $e): void {
    error_log($e->getMessage());
    json_out(["error" => "Something went wrong. Please try again."], 500);
});

require __DIR__ . "/db.php";

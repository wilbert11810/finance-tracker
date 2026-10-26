<?php
ini_set("display_errors", "0");
session_set_cookie_params([
    "httponly" => true,
    "secure" => !empty($_SERVER["HTTPS"]) || ($_SERVER["HTTP_X_FORWARDED_PROTO"] ?? "") === "https", 
    "samesite" => "Lax",

]);
session_start();
header("Content-Type: application/json");
require __DIR__ . "/db.php";

function json_out(array $body, int $status = 200): 
never {
    http_response_code($status);
    echo json_encode($body);
    exit;
}

function require_user(): int {
    if (!isset($_SESSION["user_id"])) json_out(["error" => "Unauthorized"], 401);
    return (int) $_SESSION["user_id"];
}
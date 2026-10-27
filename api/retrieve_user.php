<?php
require __DIR__ . "/bootstrap.php";

$user_id = require_user();

$sql = "SELECT first_name, last_name FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt -> bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result -> fetch_assoc();

echo json_encode([
    "firstName" => isset($user["first_name"]) ? $user["first_name"] : "Guest",
    "lastName" => isset($user["last_name"]) ? $user["last_name"] : ""
]);

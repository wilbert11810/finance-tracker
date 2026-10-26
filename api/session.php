<?php
require __DIR__ . "/bootstrap.php";

if (!isset($_SESSION["user_id"])) {
    json_out(["user" => null]);
}

$stmt = $conn->prepare("SELECT id, first_name, last_name, email FROM users WHERE id = ?");
$stmt->bind_param("i", $_SESSION["user_id"]);
$stmt->execute();

json_out(["user" => $stmt->get_result()->fetch_assoc()]);

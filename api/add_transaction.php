<?php
require __DIR__ . "/bootstrap.php";

$user_id = require_user();

$data = json_decode(file_get_contents("php://input"), true);

$title    = trim($data["title"] ?? "");
$amount   = $data["amount"] ?? null;
$date     = $data["date"] ?? "";
$category = $data["category"] ?? "";
$notes    = trim($data["notes"] ?? "");

$allowedCategories = ["food", "bills", "entertainment", "others"];

if ($title === "" || $amount === null || $date === "" || $category === "") {
    json_out(["error" => "Title, amount, date and category are required."], 422);
}
if (!is_numeric($amount) || (float) $amount <= 0) {
    json_out(["error" => "Amount must be a positive number."], 422);
}
if (!in_array($category, $allowedCategories, true)) {
    json_out(["error" => "Invalid category."], 422);
}
if (!valid_date($date)) {
    json_out(["error" => "Invalid date."], 422);
}

$sql = "INSERT INTO finance (user_id, title, amount, date, category, notes) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("isdsss", $user_id, $title, $amount, $date, $category, $notes);
$stmt->execute();

json_out(["success" => true, "message" => "Transaction added successfully!"]);


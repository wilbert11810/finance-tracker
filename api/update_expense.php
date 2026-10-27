<?php
require __DIR__ . "/bootstrap.php";

$user_id = require_user();

$data = json_decode(file_get_contents("php://input"), true);

$title      = trim($data["title"] ?? "");
$amount     = $data["amount"] ?? null;
$date       = $data["date"] ?? "";
$category   = $data["category"] ?? "";
$notes      = trim($data["notes"] ?? "");
$expense_id = $data["expense_id"] ?? null;

$allowedCategories = ["food", "bills", "entertainment", "others"];

if ($title === "" || $amount === null || $date === "" || $category === "" || $expense_id === null) {
    json_out(["error" => "Title, amount, date, category and expense id are required."], 422);
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

$sql = "UPDATE finance SET title=?, amount=?, category=?, date=?, notes=? WHERE id=? AND user_id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sdsssii", $title, $amount, $category, $date, $notes, $expense_id, $user_id);
$stmt->execute();

// WHERE ties the row to this user, so a zero row count means the expense does
// not exist or is not theirs -- don't report success for an edit that changed
// nothing.
if ($stmt->affected_rows < 1) {
    json_out(["error" => "Expense not found, or no changes were made."], 404);
}

json_out(["message" => "Expense updated successfully!"]);


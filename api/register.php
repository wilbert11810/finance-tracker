<?php
require __DIR__ . "/bootstrap.php";

$data = json_decode(file_get_contents("php://input"), true);
$first_name = trim($data["first_name"] ?? "");
$last_name  = trim($data["last_name"] ?? "");
$email      = trim($data["email"] ?? "");
$password   = $data["password"] ?? "";

if ($first_name === "" || $last_name === "" || $email === "" || $password === "") {
    json_out(["error" => "All fields are required."], 422);
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    json_out(["error" => "Please enter a valid email address."], 422);
}

// Same rule as the sign-up form: 8+ chars, an uppercase letter and a number.
if (strlen($password) < 8 || !preg_match("/[A-Z]/", $password) || !preg_match("/[0-9]/", $password)) {
    json_out([
        "error" => "Password must be at least 8 characters and include an uppercase letter and a number.",
    ], 422);
}

$password_hash = password_hash($password, PASSWORD_DEFAULT);

$sql = "INSERT INTO users (first_name, last_name, email, password_hash) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $first_name, $last_name, $email, $password_hash);

try {
    $stmt->execute();
} catch (mysqli_sql_exception $e) {
    if ($conn->errno === 1062) {           // duplicate key: email is UNIQUE
        json_out(["error" => "An account with this email already exists."], 409);
    }
    throw $e;                              // anything else -> generic 500 handler
}

json_out(["message" => "User registered successfully!", "success" => true]);

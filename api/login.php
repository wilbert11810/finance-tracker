<?php
require __DIR__ . "/bootstrap.php";

$data = json_decode(file_get_contents("php://input"), true);
$email = isset($data["email"]) ? $data["email"] : "";
$password = isset($data["password"]) ? $data["password"] : "";


if (!$data || !isset($data["email"]) || !isset($data["password"])) {
    json_out(["error" => "Email and password are required."], 422);
}

$sql = "SELECT * FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// One message for both an unknown email and a wrong password, so the response
// never reveals which emails are registered.
if (!$user || !password_verify($password, $user["password_hash"])) {
    json_out(["error" => "Invalid email or password."], 401);
}

session_regenerate_id(true);
$_SESSION["user_id"] = (int) $user["id"];

json_out([
    "message" => "Login successful!",
    "user" => [
        "id"         => (int) $user["id"],
        "first_name" => $user["first_name"],
        "last_name"  => $user["last_name"],
        "email"      => $user["email"],
    ],
]);


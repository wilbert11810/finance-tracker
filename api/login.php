<?php
require __DIR__ . "/bootstrap.php";

$data = json_decode(file_get_contents("php://input"), true);
$email = isset($data["email"]) ? $data["email"] : "";
$password = isset($data["password"]) ? $data["password"] : "";


if (!$data || !isset($data["email"]) || !isset($data["password"])) {
    echo json_encode(["error" => "Invalid JSON request","raw_received" => $data_raw,
	"decoded_data" => $data ]);
    exit();
}


$sql = "SELECT * FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
if (!$user) {
    echo json_encode(["error" => "User not found"]); 
    exit();
}

if (!password_verify($password, $user["password_hash"])) {
    echo json_encode(["error" => "Incorrect password"]);
    exit();
}

session_regenerate_id(true);
$_SESSION["user_id"] = (int) $user["id"];

echo json_encode([
    "message" => "Login successful!",
    "user" => [
        "id"         => (int) $user["id"],
        "first_name" => $user["first_name"],
        "last_name"  => $user["last_name"],
        "email"      => $user["email"],
    ],
]);




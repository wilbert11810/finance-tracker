<?php
require __DIR__ . "/bootstrap.php";
session_destroy();
echo json_encode(["message" => "Logged out successfully"]);


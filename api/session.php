<?php
require __DIR__ . "/bootstrap.php";

if (isset($_SESSION["user"])) {
    echo json_encode(["user" => $_SESSION["user"]]);
} else {
    echo json_encode(["error" => "No active session"]);
}


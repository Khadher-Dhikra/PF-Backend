<?php
require_once "../cors.php";
require_once "../middleware/AuthMiddleware.php";

$user = AuthMiddleware::verify();

echo json_encode([
    "message" => "Access granted",
    "user" => $user
]);
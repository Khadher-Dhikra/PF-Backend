<?php
require_once __DIR__ . '/../cors.php';
require_once __DIR__ . '/../controllers/AuthController.php';

$data = json_decode(file_get_contents("php://input"), true);

$controller = new AuthController();
$controller->resetPassword($data['token'], $data['newPassword']);
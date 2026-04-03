<?php
require_once "../cors.php";

require_once "../controllers/AuthController.php";

$data = json_decode(file_get_contents("php://input"), true);

$auth = new AuthController();
$auth->login($data);
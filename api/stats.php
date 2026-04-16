<?php
require_once "../cors.php";
require_once "../middlewares/AuthMiddleware.php";
require_once "../controllers/StatsController.php";

$user = AuthMiddleware::verify();

$controller = new StatsController();
echo json_encode($controller->getStats($user));
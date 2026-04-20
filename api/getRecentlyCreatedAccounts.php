<?php
require_once "../cors.php";
require_once "../middlewares/AuthMiddleware.php";
require_once "../controllers/coordinatorController.php";

$user = AuthMiddleware::requireRole("coordinator");

$controller = new coordinatorController();
echo json_encode($controller->getRecentlyCreatedAccounts($user));

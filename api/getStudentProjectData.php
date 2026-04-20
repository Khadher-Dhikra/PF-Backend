<?php
require_once "../cors.php";
require_once "../middlewares/AuthMiddleware.php";
require_once "../controllers/StudentController.php";

$user = AuthMiddleware::requireRole("student");

$controller = new StudentController();
echo json_encode($controller->getStudentsMilstone($user));

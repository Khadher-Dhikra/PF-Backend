<?php
require_once "../cors.php";
require_once "../middlewares/AuthMiddleware.php";
require_once "../controllers/TutorController.php";

$user = AuthMiddleware::requireRole("tutor");

$controller = new TutorController();
echo json_encode($controller->getTutorStudents($user));

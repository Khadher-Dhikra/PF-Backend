<?php
header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

require_once "../config/database.php";
require_once "../controllers/TuteurController.php";
require_once "../middlewares/AuthMiddleware.php";

AuthMiddleware::verifyTuteur();

$projetId = $_GET['projet_id'] ?? null;

$controller = new TuteurController();
$controller->getComptesRendus($projetId);
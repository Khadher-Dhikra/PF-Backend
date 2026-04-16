<?php
require_once "../cors.php";
require_once "../services/PublicStatsService.php";

header("Content-Type: application/json");

try {
    $service = new PublicStatsService();
    echo json_encode($service->getPublicStats());
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        "error" => "Server error",
        "message" => $e->getMessage()
    ]);
}

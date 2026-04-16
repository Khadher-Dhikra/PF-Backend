<?php
require_once __DIR__ . "/../services/StatsService.php";

class StatsController {

    private $service;

    public function __construct() {
        $this->service = new StatsService();
    }

    public function getStats($user) {
        return $this->service->getStatsByRole($user);
    }
}
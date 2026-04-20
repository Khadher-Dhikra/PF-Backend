<?php
require_once __DIR__ . "/../services/coordinatorService.php";

class coordinatorController {
    private $service;

    public function __construct() {
        $this->service = new coordinatorService();
    }

    public function getRecentlyCreatedAccounts($user) {
        return $this->service->getRecCreaAccList($user);
    }
}
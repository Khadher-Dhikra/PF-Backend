<?php
require_once __DIR__ . "/../services/TutorService.php";

class TutorController {
    private $service;

    public function __construct() {
        $this->service = new TutorService();
    }

    public function getTutorStudents($user) {
        return $this->service->getTutorStudentsList($user);
    }
}
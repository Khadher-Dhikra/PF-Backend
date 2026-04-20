<?php
require_once __DIR__ . "/../services/StudentService.php";

class StudentController
{
    private $service;

    public function __construct()
    {
        $this->service = new StudentService();
    }

    public function getStudentsMilstone($user)
    {
        return $this->service->getStudentProjectData($user);
    }
}

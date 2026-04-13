<?php

require_once __DIR__ . "/../config/database.php";
require_once __DIR__ . "/../services/AuthService.php";

class AuthController {

    private $authService;

    public function __construct() {
        $db = (new Database())->connect();
        $this->authService = new AuthService($db);
    }

    public function register($data) {
        echo json_encode($this->authService->register($data));
    }

    public function login($data) {
        echo json_encode($this->authService->login($data));
    }

    public function forgotPassword($email) {
        echo json_encode($this->authService->forgotPassword($email));
    }

    public function resetPassword($token, $password) {
        echo json_encode($this->authService->resetPassword($token, $password));
    }

    public function refresh($token) {
        echo json_encode($this->authService->refresh($token));
    }

    public function logout($token) {
        echo json_encode($this->authService->logout($token));
    }
}
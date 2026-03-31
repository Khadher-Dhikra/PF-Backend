<?php
require_once "../config/database.php";
require_once "../models/PasswordReset.php";

class PasswordResetController {

    private $model;

    public function __construct() {
        $database = new Database();
        $db       = $database->connect();
        $this->model = new PasswordReset($db);
    }

    // ================================================
    // TT-60 : Vérification de l'email
    // ================================================
    public function verifierEmail($email) {

    }

    // ================================================
    // TT-61 : Génération du token sécurisé
    // ================================================
    public function genererToken($email) {

    }

    // ================================================
    // Méthode principale TT-60 → TT-61 → TT-62
    // ================================================
    public function forgotPassword($data) {

        if (!$data) {
            echo json_encode([
                "status"  => "error",
                "message" => "Invalid JSON"
            ]);
            return;
        }

        $email = trim($data['email'] ?? '');

        $user = $this->verifierEmail($email);
        if (!$user) return;

        $token = $this->genererToken($email);

        $sent = $this->envoyerEmail($email, $token);
        if (!$sent) return;

        echo json_encode([
            "status"  => "success",
            "message" => "If this email exists, a reset link will be sent"
        ]);
    }

    // ================================================
    // TT-64 : Mise à jour du mot de passe
    // ================================================
    public function resetPassword($data) {

        if (!$data) {
            echo json_encode([
                "status"  => "error",
                "message" => "Invalid JSON"
            ]);
            return;
        }

        $token    = trim($data['token']    ?? '');
        $password = trim($data['password'] ?? '');

        if (empty($token) || empty($password)) {
            echo json_encode([
                "status"  => "error",
                "message" => "Missing data"
            ]);
            return;
        }

        if (strlen($password) < 8) {
            echo json_encode([
                "status"  => "error",
                "message" => "Password must be at least 8 characters"
            ]);
            return;
        }

        $reset = $this->model->findValidToken($token);

        if (!$reset) {
            echo json_encode([
                "status"  => "error",
                "message" => "Invalid or expired link"
            ]);
            return;
        }

        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $this->model->updatePassword($reset['email'], $hashed);
        $this->model->markTokenUsed($token);

        echo json_encode([
            "status"  => "success",
            "message" => "Password reset successfully"
        ]);
    }
}
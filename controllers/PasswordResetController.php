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

        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode([
                "status"  => "error",
                "message" => "Invalid email"
            ]);
            return null;
        }

        $user = $this->model->findUserByEmail($email);

        if (!$user) {
            echo json_encode([
                "status"  => "success",
                "message" => "If this email exists, a reset link will be sent"
            ]);
            return null;
        }

        return $user;
    }

    // ================================================
    // TT-61 : Génération du token sécurisé
    // ================================================
    public function genererToken($email) {

        $token     = bin2hex(random_bytes(32));
        $expiresAt = date('Y-m-d H:i:s', time() + 3600);

        $this->model->deleteOldTokens($email);
        $this->model->saveToken($email, $token, $expiresAt);

        return $token;
    }

    // ================================================
    // TT-62 : Envoi de l'email automatique
    // ================================================
    public function envoyerEmail($email, $token) {

        $sent = $this->model->sendResetEmail($email, $token);

        if (!$sent) {
            echo json_encode([
                "status"  => "error",
                "message" => "Failed to send email"
            ]);
            return false;
        }

        return true;
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
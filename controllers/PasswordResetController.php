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

    // =================================================
    // TT-60 : Vérifier si l'email existe dans la table users
    // =================================================
    public function verifierEmail($email) {

        // Vérifier si l'email est valide
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode([
                "status"  => "error",
                "message" => "Email invalide"
            ]);
            return null;
        }

        // Chercher utilisateur par email
        $user = $this->model->findUserByEmail($email);

        // Pour la sécurité, on ne précise pas si l'email existe ou non
        if (!$user) {
            echo json_encode([
                "status"  => "success",
                "message" => "Si cet email existe, un lien sera envoyé"
            ]);
            return null;
        }

        return $user;
    }

    // =================================================
    // TT-61 : Générer un token sécurisé
    // =================================================
    public function genererToken($user) {

        // Génération d'un token aléatoire sécurisé
        $token = bin2hex(random_bytes(32));

        // Date d'expiration : 1 heure
        $expiresAt = date('Y-m-d H:i:s', time() + 3600);

        // Récupérer l'id de l'utilisateur
        $userId = $user["id"];

        // Supprimer anciens tokens
        $this->model->deleteOldTokens($userId);

        // Sauvegarder nouveau token
        $this->model->saveToken($userId, $token, $expiresAt);

        return $token;
    }

    // =================================================
    // TT-62 : Envoyer email contenant le lien de reset
    // =================================================
  /*  public function envoyerEmail($email, $token) {

        $sent = $this->model->sendResetEmail($email, $token);

        if (!$sent) {
            echo json_encode([
                "status"  => "error",
                "message" => "Erreur lors de l'envoi de l'email"
            ]);
            return false;
        }

        return true;
    }*/
        public function sendResetEmail($email, $token) {
    $resetLink = "http://localhost:5173/reset-password?token=" . $token;

    // retourne JSON pour React/Postman
    return [
        "status" => "success",
        "message" => "Reset link généré",
        "reset_link" => $resetLink
    ];
}

    // =================================================
    // Méthode principale : 
    // TT-60 → vérifier email
    // TT-61 → générer token
    // TT-62 → envoyer email
    // =================================================
    public function forgotPassword($data) {

        if (!$data) {
            echo json_encode([
                "status"  => "error",
                "message" => "JSON invalide"
            ]);
            return;
        }

        // Nettoyer email
        $email = trim($data['email'] ?? '');

        // Vérifier email
        $user = $this->verifierEmail($email);
        if (!$user) return;

        // Générer token
        $token = $this->genererToken($user);

        // Envoyer email
        $sent = $this->envoyerEmail($email, $token);
        if (!$sent) return;

        echo json_encode([
            "status"  => "success",
            "message" => "Si cet email existe, un lien sera envoyé"
        ]);
    }

    // =================================================
    // TT-64 : Réinitialiser mot de passe avec token
    // =================================================
    public function resetPassword($data) {

        if (!$data) {
            echo json_encode([
                "status"  => "error",
                "message" => "JSON invalide"
            ]);
            return;
        }

        $token    = trim($data['token'] ?? '');
        $password = trim($data['password'] ?? '');

        // Vérifier données
        if (empty($token) || empty($password)) {
            echo json_encode([
                "status"  => "error",
                "message" => "Données manquantes"
            ]);
            return;
        }

        // Vérifier longueur mot de passe
        if (strlen($password) < 8) {
            echo json_encode([
                "status"  => "error",
                "message" => "Mot de passe doit contenir au moins 8 caractères"
            ]);
            return;
        }

        // Vérifier validité du token
        $reset = $this->model->findValidToken($token);

        if (!$reset) {
            echo json_encode([
                "status"  => "error",
                "message" => "Lien invalide ou expiré"
            ]);
            return;
        }

        // Trouver email avec user_id
        $user = $this->model->getUserById($reset['user_id']);

        // Hasher mot de passe
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Mettre à jour mot de passe
        $this->model->updatePassword($user['email'], $hashedPassword);

        // Marquer token comme utilisé
        $this->model->markTokenUsed($token);

        echo json_encode([
            "status"  => "success",
            "message" => "Mot de passe modifié avec succès"
        ]);
    }
}
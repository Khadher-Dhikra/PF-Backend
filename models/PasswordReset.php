<?php
class PasswordReset {

    private $conn;
    private $table        = "users";
    private $resetTable   = "password_resets";

    public function __construct($db) {
        $this->conn = $db;
    }

    // TT-60 : Chercher utilisateur par email
    public function findUserByEmail($email) {
        $query = "SELECT id, email FROM " . $this->table . "
                  WHERE email = :email LIMIT 1";
        $stmt  = $this->conn->prepare($query);
        $stmt->bindParam(":email", $email);
        $stmt->execute();
        return $stmt->fetch();
    }

    // TT-61 : Supprimer anciens tokens
    public function deleteOldTokens($email) {
        $query = "DELETE FROM " . $this->resetTable . "
                  WHERE email = :email";
        $stmt  = $this->conn->prepare($query);
        $stmt->bindParam(":email", $email);
        $stmt->execute();
    }

    // TT-61 : Sauvegarder token
    public function saveToken($email, $token, $expiresAt) {
        $query = "INSERT INTO " . $this->resetTable . "
                  (email, token, expires_at)
                  VALUES (:email, :token, :expires_at)";
        $stmt  = $this->conn->prepare($query);
        $stmt->bindParam(":email",      $email);
        $stmt->bindParam(":token",      $token);
        $stmt->bindParam(":expires_at", $expiresAt);
        $stmt->execute();
    }

    // TT-62 : Envoyer email
    public function sendResetEmail($email, $token) {
        $resetLink = "http://localhost:5173/reset-password?token=" . $token;

        $to      = $email;
        $subject = "Password Reset - TopG Team";
        $message = "
            <h3>Password Reset Request</h3>
            <p>Click the link below to reset your password:</p>
            <a href='{$resetLink}'>Reset my password</a>
            <p>This link expires in <strong>1 hour</strong>.</p>
            <p>If you did not request this, ignore this email.</p>
        ";
        $headers  = "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
        $headers .= "From: no-reply@topgteam.com\r\n";

        return mail($to, $subject, $message, $headers);
    }

    // TT-64 : Trouver token valide
    public function findValidToken($token) {
        $query = "SELECT * FROM " . $this->resetTable . "
                  WHERE token = :token
                  AND used = 0
                  AND expires_at > NOW()
                  LIMIT 1";
        $stmt  = $this->conn->prepare($query);
        $stmt->bindParam(":token", $token);
        $stmt->execute();
        return $stmt->fetch();
    }

    // TT-64 : Mettre à jour le mot de passe
    public function updatePassword($email, $hashedPassword) {
        $query = "UPDATE " . $this->table . "
                  SET password = :password
                  WHERE email = :email";
        $stmt  = $this->conn->prepare($query);
        $stmt->bindParam(":password", $hashedPassword);
        $stmt->bindParam(":email",    $email);
        $stmt->execute();
    }

    // TT-64 : Marquer token utilisé
    public function markTokenUsed($token) {
        $query = "UPDATE " . $this->resetTable . "
                  SET used = 1
                  WHERE token = :token";
        $stmt  = $this->conn->prepare($query);
        $stmt->bindParam(":token", $token);
        $stmt->execute();
    }
}
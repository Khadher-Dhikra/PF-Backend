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
      
    }

    // TT-61 : Supprimer anciens tokens
    public function deleteOldTokens($email) {
        
    }

    // TT-61 : Sauvegarder token
    public function saveToken($email, $token, $expiresAt) {
        
    }

    // TT-62 : Envoyer email
    public function sendResetEmail($email, $token) {
       
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
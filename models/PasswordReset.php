<?php
class PasswordReset {

    private $conn;
    private $table      = "users";
    private $resetTable = "password_resets";

    public function __construct($db) {
        $this->conn = $db;
    }

    // =================================================
    // TT-60 : Chercher utilisateur par email
    // =================================================
    public function findUserByEmail($email) {

        $query = "SELECT id, email FROM " . $this->table . "
                  WHERE email = :email LIMIT 1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email", $email);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // =================================================
    // TT-61 : Supprimer anciens tokens d'un utilisateur
    // =================================================
    public function deleteOldTokens($userId) {

        $query = "DELETE FROM " . $this->resetTable . "
                  WHERE user_id = :user_id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $userId);
        $stmt->execute();
    }

    // =================================================
    // TT-61 : Sauvegarder nouveau token
    // =================================================
    public function saveToken($userId, $token, $expiresAt) {

        $query = "INSERT INTO " . $this->resetTable . "
                  (user_id, token, expires_at)
                  VALUES (:user_id, :token, :expires_at)";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":user_id",    $userId);
        $stmt->bindParam(":token",      $token);
        $stmt->bindParam(":expires_at", $expiresAt);

        $stmt->execute();
    }

    // =================================================
    // TT-62 : Envoyer email contenant lien de reset
    // =================================================
    public function sendResetEmail($email, $token) {

    $resetLink = "http://localhost:5173/reset-password?token=" . $token;

    // نرجع الرابط في JSON بدل ارسال email
    return [
        "status" => "success",
        "message" => "Reset link generated",
        "reset_link" => $resetLink
    ];
}

    // =================================================
    // TT-64 : Vérifier si token est valide
    // =================================================
    public function findValidToken($token) {

        $query = "SELECT * FROM " . $this->resetTable . "
                  WHERE token = :token
                  AND used = 0
                  AND expires_at > NOW()
                  LIMIT 1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":token", $token);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // =================================================
    // TT-64 : Trouver email avec user_id
    // =================================================
    public function getUserById($id) {

        $query = "SELECT email FROM " . $this->table . "
                  WHERE id = :id
                  LIMIT 1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // =================================================
    // TT-64 : Mettre à jour mot de passe utilisateur
    // =================================================
    public function updatePassword($email, $hashedPassword) {

        $query = "UPDATE " . $this->table . "
                  SET password = :password
                  WHERE email = :email";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":password", $hashedPassword);
        $stmt->bindParam(":email",    $email);

        $stmt->execute();
    }

    // =================================================
    // TT-64 : Marquer token comme utilisé
    // =================================================
    public function markTokenUsed($token) {

        $query = "UPDATE " . $this->resetTable . "
                  SET used = 1
                  WHERE token = :token";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":token", $token);

        $stmt->execute();
    }
}
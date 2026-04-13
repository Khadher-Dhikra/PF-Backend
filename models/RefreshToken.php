<?php

class RefreshToken {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function create($userId, $token, $expiresAt) {
        $stmt = $this->pdo->prepare("
            INSERT INTO refresh_tokens (user_id, token, expires_at)
            VALUES (?, ?, ?)
        ");
        return $stmt->execute([$userId, $token, $expiresAt]);
    }

    public function find($token) {
        $stmt = $this->pdo->prepare("
            SELECT * FROM refresh_tokens 
            WHERE token = ? AND expires_at > NOW()
        ");
        $stmt->execute([$token]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function delete($token) {
        $stmt = $this->pdo->prepare("DELETE FROM refresh_tokens WHERE token = ?");
        return $stmt->execute([$token]);
    }

    public function deleteByUser($userId) {
        $stmt = $this->pdo->prepare("DELETE FROM refresh_tokens WHERE user_id = ?");
        return $stmt->execute([$userId]);
    }
}
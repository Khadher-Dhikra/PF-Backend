<?php

class PasswordReset {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function create($userId, $tokenHash, $expiresAt) {
        $stmt = $this->pdo->prepare("
            INSERT INTO password_resets (user_id, token_hash, expires_at, used)
            VALUES (?, ?, ?, 0)
        ");
        return $stmt->execute([$userId, $tokenHash, $expiresAt]);
    }

    public function findValidToken($token) {
        $stmt = $this->pdo->prepare("
            SELECT * FROM password_resets 
            WHERE expires_at > NOW() AND used = 0
        ");
        $stmt->execute();

        $tokens = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($tokens as $t) {
            if (password_verify($token, $t['token_hash'])) {
                return $t;
            }
        }

        return false;
    }

    public function markUsed($id) {
        $stmt = $this->pdo->prepare("UPDATE password_resets SET used = 1 WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function deleteByUser($userId) {
        $stmt = $this->pdo->prepare("DELETE FROM password_resets WHERE user_id = ?");
        return $stmt->execute([$userId]);
    }
}
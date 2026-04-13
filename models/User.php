<?php

class User {
    private $conn;
    private $table = "users";

    public function __construct($db) {
        $this->conn = $db;
    }

    // ================= CHECK EMAIL =================
    public function emailExists($email) {
        $query = "SELECT id FROM " . $this->table . " WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email", $email);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }

    // ================= REGISTER =================
    public function register($username, $email, $password) {
        $query = "INSERT INTO " . $this->table . " 
                  (username, email, password, created_at)
                  VALUES (:username, :email, :password, NOW())";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":password", $password);

        return $stmt->execute();
    }

    // ================= LOGIN =================
    public function login($email) {
        $query = "SELECT * FROM " . $this->table . " WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email", $email);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ================= FIND BY EMAIL =================
    public function findByEmail($email) {
        $query = "SELECT * FROM " . $this->table . " WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email", $email);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ================= UPDATE PASSWORD =================
    public function updatePassword($userId, $hashedPassword) {
        $query = "UPDATE " . $this->table . " 
                  SET password = :password 
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":password", $hashedPassword);
        $stmt->bindParam(":id", $userId);

        return $stmt->execute();
    }

    public function findById($id) {
    $stmt = $this->conn->prepare("
        SELECT id, username, email, role 
        FROM users WHERE id = ?
    ");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
}
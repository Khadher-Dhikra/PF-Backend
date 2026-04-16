<?php
require_once "../cors.php";
date_default_timezone_set('UTC');
class Database
{
    private $host = "localhost";
    private $db_name = "pf_db";
    private $username = "root";
    private $password = "";
    public $conn;

    public function connect()
    {
        try {
            $this->conn = new PDO(
                "mysql:host={$this->host};dbname={$this->db_name};charset=utf8mb4",
                $this->username,
                $this->password
            );

            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

            return $this->conn;
        } catch (PDOException $e) {
            die(json_encode([
                "status" => "error",
                "message" => "Database connection failed",
                "error" => $e->getMessage()
            ]));
        }
    }
}

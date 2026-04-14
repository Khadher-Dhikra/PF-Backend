<?php
require_once __DIR__ . '/../vendor/autoload.php';
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

class JWTHandler {

    private $secret;

    public function __construct() {
        $this->secret = $_ENV['JWT_SECRET'];
    }

    public function generateAccessToken($user) {

        $payload = [
            "iss" => "localhost",
            "iat" => time(),
            "exp" => time() + 900,
            "data" => [
                "id" => $user["id"],
                "email" => $user["email"],
                "role" => $user["role"]
            ]
        ];

        return JWT::encode($payload, $this->secret, 'HS256');
    }

    public function generateRefreshToken() {
        return bin2hex(random_bytes(64));
    }

    public function verify($token) {
        return JWT::decode($token, new Key($this->secret, 'HS256'));
    }
}
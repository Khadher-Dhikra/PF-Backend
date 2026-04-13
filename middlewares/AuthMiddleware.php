<?php

require_once __DIR__ . '/../config/jwt.php';

class AuthMiddleware {

    public static function verify() {
        $headers = getallheaders();

        if (!isset($headers['Authorization'])) {
            http_response_code(401);
            echo json_encode(["message" => "Unauthorized"]);
            exit;
        }

        $token = str_replace("Bearer ", "", $headers['Authorization']);

        try {
            $jwt = new JWTHandler();
            return $jwt->verify($token);
        } catch (Exception $e) {
            http_response_code(401);
            echo json_encode(["message" => "Invalid token"]);
            exit;
        }
    }

    // ====== Tutor wael ======
    public static function verifyTuteur() {

        $headers = getallheaders();
        $token   = $headers['Authorization'] ?? '';

        if (empty($token)) {
            http_response_code(401);
            echo json_encode([
                "status"  => "error",
                "message" => "Token manquant"
            ]);
            exit();
        }

        require_once "../config/database.php";
        $database = new Database();
        $db       = $database->connect();

        $stmt = $db->prepare(
            "SELECT id FROM tuteurs
             WHERE token = ? LIMIT 1"
        );
        $stmt->execute([$token]);
        $tuteur = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$tuteur) {
            http_response_code(401);
            echo json_encode([
                "status"  => "error",
                "message" => "Token invalide"
            ]);
            exit();
        }

        $_SERVER['TUTEUR_ID'] = $tuteur['id'];
    }
}
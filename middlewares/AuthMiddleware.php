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
}
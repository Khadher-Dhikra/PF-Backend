<?php

require_once __DIR__ . '/../config/jwt.php';

class AuthMiddleware
{
    public static function verify()
    {
        $headers = function_exists('getallheaders') ? getallheaders() : [];

        $authHeader = $headers['Authorization']
            ?? $_SERVER['HTTP_AUTHORIZATION']
            ?? null;

        if (!$authHeader || !str_starts_with($authHeader, 'Bearer ')) {
            http_response_code(401);
            echo json_encode(["message" => "Unauthorized"]);
            exit;
        }

        $token = substr($authHeader, 7);

        try {
            $jwt = new JWTHandler();
            return $jwt->verify($token);
        } catch (Exception $e) {
            http_response_code(401);
            echo json_encode(["message" => "Invalid token"]);
            exit;
        }
    }

    public static function requireRole($roles)
    {
        $user = self::verify();

        if (!is_array($roles)) {
            $roles = [$roles];
        }

        if (!isset($user->data->role) || !in_array($user->data->role, $roles)) {
            http_response_code(403);
            echo json_encode([
                "status" => "error",
                "message" => "Forbidden",
            ]);
            exit;
        }

        return $user;
    }
}

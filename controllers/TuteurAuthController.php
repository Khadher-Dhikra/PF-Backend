<?php
require_once __DIR__ . "/../config/database.php";
require_once __DIR__ . "/../models/Tuteur.php";

date_default_timezone_set('Africa/Tunis');
header("Content-Type: application/json");

class TuteurAuthController {

    private $model;

    public function __construct() {
        $db          = (new Database())->connect();
        $this->model = new Tuteur($db);
    }

    public function login($data) {

        if (!$data) {
            echo json_encode(["status" => "error", "message" => "Invalid JSON"]);
            return;
        }

        // 1. Extraction des données
        $email    = isset($data['email']) ? trim($data['email']) : '';
        $password = $data['password'] ?? ''; 

        if (empty($email) || empty($password)) {
            echo json_encode(["status" => "error", "message" => "Champs manquants"]);
            return;
        }

        $tuteur = $this->model->findByEmail($email);

        if (!$tuteur) {
            echo json_encode(["status" => "error", "message" => "Email introuvable"]);
            return;
        }

        // 2. Verification "FORCÉE" (Bech tsal7el mochekel el hash)
        $hashedPassword = $tuteur['password'] ?? '';

        // Hna el code bech i-talle3ek s7i7 ken:
        // - El password huwwa "wael123" (directement)
        // - WALA el password verify t-neja7 bel hash fil base
        if ($password !== "wael123" && !password_verify($password, $hashedPassword)) {
            echo json_encode([
                "status" => "error", 
                "message" => "Mot de passe incorrect",
                "debug_info" => "Vérifiez que le hash dans la base correspond à wael123"
            ]);
            return;
        }

        // 3. Generation mta3 el token
        $token = bin2hex(random_bytes(32));
        $this->model->saveToken($tuteur['id'], $token);

        echo json_encode([
            "status"  => "success",
            "message" => "Connexion réussie",
            "token"   => $token,
            "tuteur"  => [
                "id"    => $tuteur['id'],
                "nom"   => $tuteur['nom'],
                "email" => $tuteur['email']
            ]
        ]);
    }
}
<?php

require_once __DIR__ . "/../config/database.php";
require_once __DIR__ . "/../models/User.php";
require_once __DIR__ . "/../models/PasswordReset.php";
require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__  . '/../');
$dotenv->load();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

date_default_timezone_set('Africa/Tunis');

header("Content-Type: application/json");

class AuthController {

    private $user;
    private $reset;

    public function __construct() {
        $db = (new Database())->connect();
        $this->user = new User($db);
        $this->reset = new PasswordReset($db);
    }

    // ================= REGISTER =================
    public function register($data) {

        if (!$data) {
            echo json_encode(["status" => "error", "message" => "Invalid data"]);
            return;
        }

        if ($this->user->emailExists($data["email"])) {
            echo json_encode(["status" => "error", "message" => "Email already exists"]);
            return;
        }

        $hashedPassword = password_hash($data["password"], PASSWORD_DEFAULT);

        $success = $this->user->register(
            $data["username"],
            $data["email"],
            $hashedPassword
        );

        echo json_encode([
            "status" => $success ? "success" : "error",
            "message" => $success ? "User registered" : "Registration failed"
        ]);
    }

    // ================= LOGIN =================
    public function login($data) {

        if (!$data) {
            echo json_encode(["status" => "error", "message" => "Invalid data"]);
            return;
        }

        $user = $this->user->login($data["email"]);

        if (!$user) {
            echo json_encode(["status" => "error", "message" => "User not found"]);
            return;
        }

        if (!password_verify($data["password"], $user["password"])) {
            echo json_encode(["status" => "error", "message" => "Incorrect password"]);
            return;
        }

        echo json_encode([
            "status" => "success",
            "user" => $user
        ]);
    }

    // ================= FORGOT PASSWORD =================
    public function forgotPassword($email) {

        $user = $this->user->findByEmail($email);

        if (!$user) {
            echo json_encode(["status" => "error", "message" => "Email not found"]);
            return;
        }

        $token = bin2hex(random_bytes(32));
        $tokenHash = password_hash($token, PASSWORD_DEFAULT);
        $expiresAt = date("Y-m-d H:i:s", strtotime("+1 hour"));

        $this->reset->deleteByUser($user["id"]);
        $this->reset->create($user["id"], $tokenHash, $expiresAt);

        $this->sendResetEmail($email, $token);

        echo json_encode([
            "status" => "success",
            "message" => "Check your email"
        ]);
    }

    // ================= RESET PASSWORD =================
    public function resetPassword($token, $newPassword) {

        $record = $this->reset->findValidToken($token);

        if (!$record) {
            echo json_encode(["success" => false]);
            return;
        }

        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        $this->user->updatePassword($record["user_id"], $hashedPassword);
        $this->reset->markUsed($record["id"]);

        echo json_encode(["success" => true]);
    }

    // ================= EMAIL =================
    private function sendResetEmail($email, $token) {

        $mail = new PHPMailer(true);
        $emailContent = file_get_contents(__DIR__ . '/../mail/email_template.html');

        try {
            $mail->isSMTP();
            $mail->Host = $_ENV['SMTP_HOST'];
            $mail->SMTPAuth = true;
            $mail->Username = $_ENV['SMTP_USER'];
            $mail->Password = $_ENV['SMTP_PASS'];
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = $_ENV['SMTP_PORT'];

            $mail->setFrom($_ENV['SMTP_MAIL'], 'TopGTeam');
            $mail->addAddress($email);

            $link = "http://localhost:5173/reset-password?token=" . $token;
            $emailContent = str_replace('{{link}}', $link, $emailContent);

            $mail->isHTML(true);
            $mail->Subject = 'Reset Password';
            $mail->Body = "$emailContent";

            $mail->send();

        } catch (Exception $e) {
            echo json_encode([
                "error" => $mail->ErrorInfo
            ]);
            exit;
        }
    }
}
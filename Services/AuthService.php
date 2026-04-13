<?php

require_once __DIR__ . "/../models/User.php";
require_once __DIR__ . "/../models/PasswordReset.php";
require_once __DIR__ . "/../models/RefreshToken.php";
require_once __DIR__ . "/../config/jwt.php";
require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

date_default_timezone_set('Africa/Tunis');

class AuthService {

    private $user;
    private $reset;
    private $refresh;
    private $jwt;

    public function __construct($db) {
        $this->user = new User($db);
        $this->reset = new PasswordReset($db);
        $this->refresh = new RefreshToken($db);
        $this->jwt = new JWTHandler();
    }

    private function detectRole($email) {
        if (str_contains($email, "-coord")) return "coordinator";
        if (str_contains($email, "-jury")) return "jury";
        if (str_contains($email, "-tutor")) return "tutor";
        return "student";
    }

    // ================= REGISTER =================
    public function register($data) {

        if (!$data) return ["status"=>"error","message"=>"Invalid data"];

        if ($this->user->emailExists($data["email"])) {
            return ["status"=>"error","message"=>"Email exists"];
        }

        $role = $this->detectRole($data["email"]);
        $hashed = password_hash($data["password"], PASSWORD_DEFAULT);

        $success = $this->user->register(
            $data["username"],
            $data["email"],
            $hashed,
            $role
        );

        return [
            "status"=>$success?"success":"error",
            "message"=>$success?"Registered":"Failed"
        ];
    }

    // ================= LOGIN =================
    public function login($data) {

        $user = $this->user->login($data["email"]);

        if (!$user || !password_verify($data["password"], $user["password"])) {
            return ["status"=>"error","message"=>"Invalid credentials"];
        }

        unset($user["password"]);

        $accessToken = $this->jwt->generateAccessToken($user);
        $refreshToken = $this->jwt->generateRefreshToken();

        $this->refresh->create(
            $user["id"],
            $refreshToken,
            date("Y-m-d H:i:s", strtotime("+7 days"))
        );

        return [
            "status"=>"success",
            "token"=>$accessToken,
            "refreshToken"=>$refreshToken,
            "user"=>$user
        ];
    }

    // ================= REFRESH =================
    public function refresh($token) {

        $record = $this->refresh->find($token);
        if (!$record) return ["status"=>"error"];

        $user = $this->user->findById($record["user_id"]);
        $newToken = $this->jwt->generateAccessToken($user);

        return ["status"=>"success","token"=>$newToken];
    }

    // ================= LOGOUT =================
    public function logout($token) {
        $this->refresh->delete($token);
        return ["status"=>"success"];
    }

    // ================= FORGOT =================
    public function forgotPassword($email) {

        $user = $this->user->findByEmail($email);
        if (!$user) return ["status"=>"error","message"=>"Email not found"];

        $token = bin2hex(random_bytes(32));
        $hash = password_hash($token, PASSWORD_DEFAULT);

        $this->reset->deleteByUser($user["id"]);
        $this->reset->create(
            $user["id"],
            $hash,
            date("Y-m-d H:i:s", strtotime("+1 hour"))
        );

        $this->sendEmail($email, $token);

        return ["status"=>"success"];
    }

    // ================= RESET =================
    public function resetPassword($token, $password) {

        $record = $this->reset->findValidToken($token);
        if (!$record) return ["success"=>false];

        $this->user->updatePassword(
            $record["user_id"],
            password_hash($password, PASSWORD_DEFAULT)
        );

        $this->reset->markUsed($record["id"]);

        return ["success"=>true];
    }

    // ================= EMAIL =================
    private function sendEmail($email, $token) {

        $mail = new PHPMailer(true);

        $template = file_get_contents(__DIR__ . '/../mail/email_template.html');
        $link = "http://localhost:5173/reset-password?token=".$token;
        $template = str_replace('{{link}}', $link, $template);

        $mail->isSMTP();
        $mail->Host = $_ENV['SMTP_HOST'];
        $mail->SMTPAuth = true;
        $mail->Username = $_ENV['SMTP_USER'];
        $mail->Password = $_ENV['SMTP_PASS'];
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = $_ENV['SMTP_PORT'];

        $mail->setFrom($_ENV['SMTP_MAIL'], 'TopGTeam');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Reset Password';
        $mail->Body = $template;

        $mail->send();
    }
}
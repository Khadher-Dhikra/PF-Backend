<?php
require_once __DIR__ . "/../config/database.php";
require_once __DIR__ . "/../models/Tuteur.php";
require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

date_default_timezone_set('Africa/Tunis');
header("Content-Type: application/json");

class TuteurController {

    private $model;

    public function __construct() {
        $db          = (new Database())->connect();
        $this->model = new Tuteur($db);
    }

    // TT-72 : GET /projets/tuteur
    public function getProjets() {
        $tuteurId = $_SERVER['TUTEUR_ID'] ?? null;

        if (!$tuteurId) {
            echo json_encode(["status" => "error", "message" => "Non autorisé"]);
            return;
        }

        $projets = $this->model->getProjetsByTuteur($tuteurId);
        echo json_encode([
            "status"  => "success",
            "projets" => $projets
        ]);
    }

    // TT-73 : Vue détaillée projet + comptes rendus
    public function getProjetDetail($projetId) {
        $tuteurId = $_SERVER['TUTEUR_ID'] ?? null;

        if (!$tuteurId) {
            echo json_encode(["status" => "error", "message" => "Non autorisé"]);
            return;
        }

        $projet = $this->model->getProjetDetail($projetId, $tuteurId);

        if (!$projet) {
            echo json_encode(["status" => "error", "message" => "Projet introuvable"]);
            return;
        }

        $comptesRendus = $this->model->getComptesRendus($projetId);

        echo json_encode([
            "status"         => "success",
            "projet"         => $projet,
            "comptes_rendus" => $comptesRendus
        ]);
    }

    // TT-05 : Comptes rendus (tous ou par projet)
    public function getComptesRendus($projetId = null) {
        $tuteurId = $_SERVER['TUTEUR_ID'] ?? null;

        if (!$tuteurId) {
            echo json_encode(["status" => "error", "message" => "Non autorisé"]);
            return;
        }

        if ($projetId) {
            $projet = $this->model->getProjetDetail($projetId, $tuteurId);

            if (!$projet) {
                echo json_encode(["status" => "error", "message" => "Projet introuvable"]);
                return;
            }

            $comptesRendus = $this->model->getComptesRendus($projetId);
        } else {
            $comptesRendus = $this->model->getAllComptesRendusByTuteur($tuteurId);
        }

        echo json_encode([
            "status"         => "success",
            "comptes_rendus" => $comptesRendus
        ]);
    }

    // TT-74 : Valider ou rejeter un compte rendu
    public function validerCompteRendu($data) {
        $tuteurId = $_SERVER['TUTEUR_ID'] ?? null;

        if (!$tuteurId) {
            echo json_encode(["status" => "error", "message" => "Non autorisé"]);
            return;
        }

        $compteRenduId = $data['compte_rendu_id'] ?? null;
        $statut        = trim($data['statut']       ?? '');
        $commentaire   = trim($data['commentaire']  ?? '');

        if (!$compteRenduId || !in_array($statut, ['validé', 'rejeté'])) {
            echo json_encode(["status" => "error", "message" => "Données invalides"]);
            return;
        }

        $this->model->updateStatutCompteRendu($compteRenduId, $statut, $commentaire);

        // TT-75 : Email automatique à l'étudiant
        $etudiant = $this->model->getEtudiantByCompteRendu($compteRenduId);
        if ($etudiant) {
            $this->sendValidationEmail(
                $etudiant['email'],
                $etudiant['username'],
                $statut,
                $commentaire
            );
        }

        echo json_encode([
            "status"  => "success",
            "message" => "Compte rendu " . $statut
        ]);
    }

    // TT-75 : Email automatique
    private function sendValidationEmail($email, $username, $statut, $commentaire) {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host       = $_ENV['SMTP_HOST'];
            $mail->SMTPAuth   = true;
            $mail->Username   = $_ENV['SMTP_USER'];
            $mail->Password   = $_ENV['SMTP_PASS'];
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = $_ENV['SMTP_PORT'];

            $mail->setFrom($_ENV['SMTP_MAIL'], 'TopGTeam');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Résultat de votre compte rendu';

            $couleur = $statut === 'validé' ? '#28a745' : '#dc3545';
            $mail->Body = "
                <div style='font-family:sans-serif;max-width:500px;margin:auto'>
                    <h2 style='color:{$couleur}'>Compte rendu {$statut}</h2>
                    <p>Bonjour <strong>{$username}</strong>,</p>
                    <p>Votre compte rendu a été <strong style='color:{$couleur}'>{$statut}</strong>.</p>
                    " . ($commentaire ? "<p><strong>Commentaire du tuteur :</strong> {$commentaire}</p>" : "") . "
                    <p>Cordialement,<br>TopG Team</p>
                </div>
            ";

            $mail->send();

        } catch (Exception $e) {
            error_log("Mail error: " . $mail->ErrorInfo);
        }
    }
}
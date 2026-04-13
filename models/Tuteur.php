<?php
class Tuteur {

    private $conn;
    private $tableTuteurs = "tuteurs";
    private $tableProjets = "projets";
    private $tableComptes = "comptes_rendus";

    public function __construct($db) {
        $this->conn = $db;
    }

    // TT-02 : Trouver par email
    public function findByEmail($email) {
        $stmt = $this->conn->prepare(
            "SELECT * FROM " . $this->tableTuteurs . "
             WHERE email = :email LIMIT 1"
        );
        $stmt->bindParam(":email", $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // TT-02 : Sauvegarder token
    public function saveToken($id, $token) {
        $stmt = $this->conn->prepare(
            "UPDATE " . $this->tableTuteurs . "
             SET token = :token WHERE id = :id"
        );
        $stmt->bindParam(":token", $token);
        $stmt->bindParam(":id",    $id);
        $stmt->execute();
    }

    // TT-04 : Projets attribués au tuteur
    public function getProjetsByTuteur($tuteurId) {
        $stmt = $this->conn->prepare(
            "SELECT p.*, u.username AS etudiant_nom
             FROM " . $this->tableProjets . " p
             LEFT JOIN users u ON p.user_id = u.id
             WHERE p.tuteur_id = :tuteur_id
             ORDER BY p.created_at DESC"
        );
        $stmt->bindParam(":tuteur_id", $tuteurId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // TT-04 : Détail d'un projet
    public function getProjetDetail($projetId, $tuteurId) {
        $stmt = $this->conn->prepare(
            "SELECT p.*, u.username AS etudiant_nom, u.email AS etudiant_email
             FROM " . $this->tableProjets . " p
             LEFT JOIN users u ON p.user_id = u.id
             WHERE p.id = :id AND p.tuteur_id = :tuteur_id
             LIMIT 1"
        );
        $stmt->bindParam(":id",        $projetId);
        $stmt->bindParam(":tuteur_id", $tuteurId);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // TT-05 : Comptes rendus d'un projet
    public function getComptesRendus($projetId) {
        $stmt = $this->conn->prepare(
            "SELECT cr.*, u.username AS etudiant_nom
             FROM " . $this->tableComptes . " cr
             LEFT JOIN users u ON cr.user_id = u.id
             WHERE cr.projet_id = :projet_id
             ORDER BY cr.created_at DESC"
        );
        $stmt->bindParam(":projet_id", $projetId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // TT-05 : Tous les comptes rendus du tuteur
    public function getAllComptesRendusByTuteur($tuteurId) {
        $stmt = $this->conn->prepare(
            "SELECT cr.*, u.username AS etudiant_nom, p.titre AS projet_titre
             FROM " . $this->tableComptes . " cr
             LEFT JOIN users u ON cr.user_id = u.id
             LEFT JOIN " . $this->tableProjets . " p ON cr.projet_id = p.id
             WHERE p.tuteur_id = :tuteur_id
             ORDER BY cr.created_at DESC"
        );
        $stmt->bindParam(":tuteur_id", $tuteurId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // TT-06 : Valider ou rejeter un compte rendu
    public function updateStatutCompteRendu($compteRenduId, $statut, $commentaire) {
        $stmt = $this->conn->prepare(
            "UPDATE " . $this->tableComptes . "
             SET statut = :statut, commentaire = :commentaire
             WHERE id = :id"
        );
        $stmt->bindParam(":statut",      $statut);
        $stmt->bindParam(":commentaire", $commentaire);
        $stmt->bindParam(":id",          $compteRenduId);
        return $stmt->execute();
    }

    // TT-06 : Récupérer email étudiant via compte rendu
    public function getEtudiantByCompteRendu($compteRenduId) {
        $stmt = $this->conn->prepare(
            "SELECT u.email, u.username
             FROM " . $this->tableComptes . " cr
             LEFT JOIN users u ON cr.user_id = u.id
             WHERE cr.id = :id LIMIT 1"
        );
        $stmt->bindParam(":id", $compteRenduId);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
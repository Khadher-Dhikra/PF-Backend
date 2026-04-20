<?php

require_once __DIR__ . "/../config/database.php";

class coordinatorService
{
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->connect();
    }

    //get tutor students
    public function getRecCreaAccList($user)
    {
        $userId = $user->data->id;

        return $this->RecCreaAccList();
    }

    private function RecCreaAccList()
    {
        $stmt = $this->db->prepare("
            SELECT
                u.username    AS username,
                u.role        AS user_role,
                u.email       AS user_email,
                u.created_at  AS date_created
            FROM users u
            ORDER BY u.created_at DESC
            LIMIT 10
        ");
        $stmt->execute();
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return [
            "status" => "success",
            "accounts" => $users,
        ];
    }
}

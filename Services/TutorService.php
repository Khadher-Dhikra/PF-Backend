<?php

require_once __DIR__ . "/../config/database.php";

class TutorService
{
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->connect();
    }

    //get tutor students
    public function getTutorStudentsList(){
        $userId = $user->data->id;

        return $this->getStudents($userId);
    }

    private function getStudents() {
        $stmt = $this->db->prepare("
            SELECT u.username as student_name
            FROM users u
            JOIN students s ON s.user_id = u.id
            JOIN project_students ps ON s.id = ps.student_id
            JOIN projects pr ON ps.project_id = pr.id
            JOIN tutor tu ON pr.tutor_id = tu.id
            WHERE tu.user_id = ?
        ");
        $stmt->execute([$userId]);
        $students = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return [
            "status" => "success",
            "students" => $students,
            // "project" => $reports,
            // "progress" => (int)$progress,
            // "stats" => $stats,
        ];
    }
}
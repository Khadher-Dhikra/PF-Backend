<?php
require_once __DIR__ . "/../config/database.php";

class StatsService {

    private $db;

    public function __construct() {
        $this->db = (new Database())->connect();
    }

    public function getStatsByRole($user) {

        switch ($user->data->role) {

            case "student":
                return $this->getStudentStats($user->data->id);

            case "tutor":
                return $this->getTutorStats($user->data->id);

            case "coordinator":
                return $this->getCoordinatorStats();

            case "jury":
                return $this->getJuryStats($user->data->id);

            default:
                return [];
        }
    }

    // ================= STUDENT =================
    private function getStudentStats($userId) {

        // عدد المشاريع
        $projects = $this->db->query("
            SELECT COUNT(*) as total
            FROM project_students ps
            JOIN students s ON ps.student_id = s.id
            WHERE s.user_id = $userId
        ")->fetch()['total'];

        // عدد التقارير
        $reports = $this->db->query("
            SELECT COUNT(*) as total
            FROM reports r
            JOIN students s ON r.student_id = s.id
            WHERE s.user_id = $userId
        ")->fetch()['total'];

        // أقرب deadline
        $deadline = $this->db->query("
            SELECT MIN(m.due_date) as next_deadline
            FROM milestones m
            JOIN projects p ON m.project_id = p.id
            JOIN project_students ps ON ps.project_id = p.id
            JOIN students s ON ps.student_id = s.id
            WHERE s.user_id = $userId
        ")->fetch()['next_deadline'];

        return [
            "projects" => $projects,
            "reports" => $reports,
            "deadline" => $deadline
        ];
    }

    // ================= COORDINATOR =================
    private function getCoordinatorStats() {

        $students = $this->db->query("SELECT COUNT(*) as total FROM students")->fetch()['total'];
        $tutors = $this->db->query("SELECT COUNT(*) as total FROM tutors")->fetch()['total'];
        $jury = $this->db->query("SELECT COUNT(*) as total FROM jury_members")->fetch()['total'];
        $projects = $this->db->query("SELECT COUNT(*) as total FROM projects")->fetch()['total'];

        return [
            "students" => $students,
            "tutors" => $tutors,
            "jury" => $jury,
            "projects" => $projects
        ];
    }

    // ================= TUTOR =================
    private function getTutorStats($userId) {

        $projects = $this->db->query("
            SELECT COUNT(*) as total
            FROM projects p
            JOIN tutors t ON p.tutor_id = t.id
            WHERE t.user_id = $userId
        ")->fetch()['total'];

        return [
            "projects" => $projects
        ];
    }

    // ================= JURY =================
    private function getJuryStats($userId) {

        return [
            "defenses" => 0 // نكملها لاحقًا
        ];
    }
}
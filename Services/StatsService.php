<?php

require_once __DIR__ . "/../config/database.php";

class StatsService
{
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->connect();
    }

    public function getStatsByRole($user)
    {
        $role = $user->data->role;
        $userId = $user->data->id;

        switch ($role) {

            case "student":
                return $this->getStudentStats($userId);

            case "tutor":
                return $this->getTutorStats($userId);

            case "coordinator":
                return $this->getCoordinatorStats();

            case "jury":
                return $this->getJuryStats($userId);

            default:
                return [];
        }
    }

    // ================= STUDENT =================
    private function getStudentStats($userId)
    {
        // project status (first project only)
        $stmt = $this->db->prepare("
            SELECT pr.status
            FROM projects pr
            JOIN project_students ps ON ps.project_id = pr.id
            JOIN students s ON ps.student_id = s.id
            WHERE s.user_id = ?
            LIMIT 1
        ");
        $stmt->execute([$userId]);
        $projectStatus = $stmt->fetchColumn();

        // reports count
        $stmt = $this->db->prepare("
            SELECT COUNT(*) as total
            FROM reports r
            JOIN students s ON r.student_id = s.id
            WHERE s.user_id = ?
        ");
        $stmt->execute([$userId]);
        $reports = $stmt->fetch()['total'];

        // next deadline
        $stmt = $this->db->prepare("
            SELECT MIN(m.due_date) as next_deadline
            FROM milestones m
            JOIN projects p ON m.project_id = p.id
            JOIN project_students ps ON ps.project_id = p.id
            JOIN students s ON ps.student_id = s.id
            WHERE s.user_id = ?
        ");
        $stmt->execute([$userId]);
        $deadline = $stmt->fetchColumn();

        return [
            "projects" => $projectStatus,
            "reports" => (int)$reports,
            "deadline" => $deadline
        ];
    }

    // ================= COORDINATOR =================
    private function getCoordinatorStats()
    {
        return [
            "students" => $this->count("students"),
            "tutors" => $this->count("tutors"),
            "jury" => $this->count("jury_members"),
            "projects" => $this->count("projects"),
        ];
    }

    // ================= TUTOR =================
    private function getTutorStats($userId)
    {
        // projects count
        $stmt = $this->db->prepare("
            SELECT COUNT(*) as total
            FROM projects p
            JOIN tutors t ON p.tutor_id = t.id
            WHERE t.user_id = ?
        ");
        $stmt->execute([$userId]);
        $projects = $stmt->fetch()['total'];

        // students count
        $stmt = $this->db->prepare("
            SELECT COUNT(DISTINCT ps.student_id) as total
            FROM projects p
            JOIN tutors t ON p.tutor_id = t.id
            JOIN project_students ps ON ps.project_id = p.id
            WHERE t.user_id = ?
        ");
        $stmt->execute([$userId]);
        $students = $stmt->fetch()['total'];

        // reports count
        $stmt = $this->db->prepare("
            SELECT COUNT(*) as total
            FROM reports r
            JOIN projects p ON r.project_id = p.id
            JOIN tutors t ON p.tutor_id = t.id
            WHERE t.user_id = ? AND r.status = 'en_attente'
        ");
        $stmt->execute([$userId]);
        $reports = $stmt->fetch()['total'];

        // unread messages
        $stmt = $this->db->prepare("
            SELECT COUNT(*) as total
            FROM messages
            WHERE receiver_id = ? AND is_read = 0
        ");
        $stmt->execute([$userId]);
        $messages = $stmt->fetch()['total'];

        return [
            "students" => (int)$students,
            "projects" => (int)$projects,
            "reports" => (int)$reports,
            "messages" => (int)$messages
        ];
    }

    // ================= JURY =================
    private function getJuryStats($userId)
    {
        $stmt = $this->db->prepare("
            SELECT COUNT(*) as total
            FROM soutenance_jury sj
            JOIN jury_members jm ON sj.jury_id = jm.id
            WHERE jm.user_id = ?
        ");
        $stmt->execute([$userId]);
        $defenses = $stmt->fetch()['total'];

        return [
            "defenses" => (int)$defenses,
            "reports" => $this->count("reports"),
            "evaluations" => 0,
            "average" => 0
        ];
    }

    // ================= HELPER =================
    private function count($table)
    {
        $stmt = $this->db->query("SELECT COUNT(*) as total FROM $table");
        return (int)$stmt->fetch()['total'];
    }
}

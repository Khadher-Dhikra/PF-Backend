<?php

require_once __DIR__ . "/../config/database.php";

class StudentService
{
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->connect();
    }

    public function getStudentProjectData($user)
    {
        $userId = $user->data->id;

        $project = $this->getProjectData($userId);

        if (!$project) {
            return [
                "status" => "error",
                "message" => "No Project Found",
            ];
        }

        $subtasks = $this->getSubTasks($project['project_id']);

        return [
            "status" => "success",
            "project" => $project,
            "subtasks" => $subtasks,
        ];
    }

    private function getProjectData($userId)
    {
        $stmt = $this->db->prepare("
        SELECT 
            pr.id AS project_id,
            pr.title AS project_title,
            pr.description AS project_description,
            pr.status AS project_status,
            pr.progress AS project_progress,
            pr.created_at AS project_start_date,
            s.group_name AS student_group,
            tu_user.username AS tutor_name,
            st_user.username AS student_name,
            partner_user.username AS partner_name,
            COALESCE(ms.total_tasks, 0) AS total_tasks,
            COALESCE(ms.completed_tasks, 0) AS completed_tasks,
            COALESCE(ms.progress_percent, 0) AS progress_percent

        FROM students s
        JOIN users st_user ON s.user_id = st_user.id
        JOIN project_students ps ON ps.student_id = s.id
        JOIN projects pr ON ps.project_id = pr.id

        LEFT JOIN tutors t ON pr.tutor_id = t.id
        LEFT JOIN users tu_user ON t.user_id = tu_user.id

        LEFT JOIN project_students ps2 
            ON ps2.project_id = pr.id AND ps2.student_id != s.id
        LEFT JOIN students s2 ON ps2.student_id = s2.id
        LEFT JOIN users partner_user ON s2.user_id = partner_user.id

        LEFT JOIN (
            SELECT 
                project_id,
                COUNT(*) AS total_tasks,
                SUM(CASE WHEN status = 'Completed' THEN 1 ELSE 0 END) AS completed_tasks,
                ROUND(
                    CASE 
                        WHEN COUNT(*) = 0 THEN 0
                        ELSE (SUM(CASE WHEN status = 'Completed' THEN 1 ELSE 0 END) / COUNT(*)) * 100
                    END
                ) AS progress_percent
            FROM milestones
            GROUP BY project_id
        ) ms ON ms.project_id = pr.id

        WHERE s.user_id = ?
        LIMIT 1;
        ");

        $stmt->execute([$userId]);
        $projectData = $stmt->fetch(PDO::FETCH_ASSOC);

        return $projectData;
    }

    private function getSubTasks($projectId)
    {
        $stmt = $this->db->prepare("
            SELECT title, due_date, status
            FROM milestones
            WHERE project_id = ?
            ORDER BY order_index ASC
        ");

        $stmt->execute([$projectId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

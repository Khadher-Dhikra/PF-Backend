<?php
require_once __DIR__ . "/../config/database.php";

class PublicStatsService
{

    private $db;

    public function __construct()
    {
        $this->db = (new Database())->connect();
    }

    public function getPublicStats()
    {

        $projects = $this->count("projects");
        $students = $this->count("students");
        $tutors = $this->count("tutors");

        // عدد المناقشات (soutenances)
        $defenses = $this->count("soutenances");

        return [
            "projects" => $projects,
            "students" => $students,
            "tutors" => $tutors,
            "defenses" => $defenses
        ];
    }

    private function count($table)
    {
        return $this->db->query("SELECT COUNT(*) as total FROM $table")
            ->fetch()['total'];
    }
}

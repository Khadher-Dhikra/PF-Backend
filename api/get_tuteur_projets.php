<?php
// 1. CORS Headers - Lazem t7ot el URL mta3 el React bedhabt mouch "*"
header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

// 2. Handling Preflight (OPTIONS) - Hathi hiya elli kkant tkhalli fil console bel a7mar
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once '../config/database.php';

// 3. Authorization Check
$headers    = getallheaders();
$authHeader = $headers['Authorization'] ?? $headers['authorization'] ?? '';

if (!preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
    http_response_code(401);
    echo json_encode(["status" => "error", "message" => "Token manquant"]);
    exit;
}

$jwt = $matches[1];

$database = new Database();
$db       = $database->connect();

// 4. Vérifier token fil base
$stmt = $db->prepare("SELECT id FROM tuteurs WHERE token = ? LIMIT 1");
$stmt->execute([$jwt]);
$tuteur = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$tuteur) {
    http_response_code(401);
    echo json_encode(["status" => "error", "message" => "Token invalide"]);
    exit;
}

// 5. Fetch projets
$tuteur_id = $_GET['tuteur_id'] ?? $tuteur['id'];

$stmt = $db->prepare("
    SELECT p.id, p.titre, p.description, p.statut, p.created_at,
           u.username AS etudiant_nom
    FROM projets p
    LEFT JOIN users u ON p.user_id = u.id
    WHERE p.tuteur_id = ?
    ORDER BY p.created_at DESC
");
$stmt->execute([$tuteur_id]);
$projets = $stmt->fetchAll(PDO::FETCH_ASSOC);

// 6. Mapping lel Frontend
$mapped = array_map(function($p) {
    $progress = 50;
    if ($p['statut'] === 'valide')     $progress = 100;
    if ($p['statut'] === 'rejete')     $progress = 100;
    if ($p['statut'] === 'en_attente') $progress = 50;

    return [
        "id"            => $p['id'],
        "titre"         => $p['titre'],
        "description"   => $p['description'],
        "status"        => $p['statut'],
        "etudiant_nom"  => $p['etudiant_nom'] ?? 'Étudiant inconnu',
        "date_creation" => $p['created_at'],
        "progress"      => $progress,
    ];
}, $projets);

echo json_encode($mapped);
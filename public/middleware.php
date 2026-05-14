<?php
require_once "../config/config.php";
require_once "../vendor/autoload.php";

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

function auth() {
    $headers = getallheaders();
    if (!isset($headers["Authorization"])) {
        http_response_code(401);
        exit;
    }

    $token = str_replace("Bearer ", "", $headers["Authorization"]);

    try {
        return JWT::decode($token, new Key(JWT_SECRET, "HS256"));
    } catch (Exception $e) {
        http_response_code(401);
        exit;
    }
}

function getPermessi($user_id, $conn) {
    // $conn ora è un oggetto PDO, usiamo la sua sintassi
    $stmt = $conn->prepare("
        SELECT p.codice
        FROM permessi p
        JOIN ruoli_permessi rp ON rp.permesso_id = p.id
        JOIN utenti u ON u.ruolo_id = rp.ruolo_id
        WHERE u.id = ?
    ");
    $stmt->execute([$user_id]);

    $permessi = [];
    while ($r = $stmt->fetch()) {
        $permessi[] = $r["codice"];
    }
    return $permessi;
}

function requirePermission($permesso, $permessi) {
    if (!in_array($permesso, $permessi)) {
        http_response_code(403);
        echo json_encode(["error" => "Accesso negato"]);
        exit;
    }
}
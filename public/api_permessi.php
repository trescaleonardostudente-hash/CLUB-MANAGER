<?php
header("Content-Type: application/json");
require "connessione.php";

$secret_key = "chiave-segreta-molto-lunga-1234567890"; 

$headers = apache_request_headers();
$authHeader = $headers['Authorization'] ?? $headers['authorization'] ?? '';

if (!preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
    echo json_encode(["error" => "Authorization header mancante"]);
    exit;
}

try {
    $jwt = $matches[1];
    $tokenParts = explode('.', $jwt);
    $payload = json_decode(base64_decode(str_replace(['-', '_'], ['+', '/'], $tokenParts[1])), true);

    if ($payload['exp'] < time()) {
        echo json_encode(["error" => "Token scaduto"]);
        exit;
    }

    $sql = "SELECT p.codice 
            FROM permessi p
            JOIN ruoli_permessi rp ON p.id = rp.permesso_id
            JOIN utenti u ON rp.ruolo_id = u.ruolo_id
            WHERE u.id = ?";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$payload['uid']]);
    $risultati = $stmt->fetchAll();

    $privilegi = [];
    foreach ($risultati as $row) { 
        $privilegi[] = $row['codice']; 
    }

    echo json_encode([
        "status" => "success",
        "user_id" => $payload['uid'],
        "privilegi" => $privilegi
    ]);

} catch (Exception $e) {
    echo json_encode(["error" => "Token non valido o errore server: " . $e->getMessage()]);
}
?>
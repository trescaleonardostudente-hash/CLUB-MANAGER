<?php
session_start();
require_once './vendor/autoload.php';
use Firebase\JWT\JWT;

if (!isset($_SESSION["user_id"])) { header("Location: login.php"); exit; }

$secret_key = "chiave-segreta-molto-lunga-1234567890"; 

function generate_jwt($user_id, $key) {
    $issuedAt = time();
    $payload = [
        "iss" => "clubmanager",
        "iat" => $issuedAt,
        "nbf" => $issuedAt,
        "exp" => $issuedAt + 600, // Scadenza 10 minuti (GPO)
        "uid" => $user_id
    ];
    return JWT::encode($payload, $key, 'HS256');
}

$jwt = generate_jwt($_SESSION["user_id"], $secret_key);
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Accesso Autorizzato</title>
    <style>
        body { background: #121212; color: white; font-family: sans-serif; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .card { background: #1e1e1e; padding: 30px; border-radius: 15px; border: 2px solid #2e7d32; width: 400px; text-align: center; }
        .token { background: #000; padding: 10px; color: #4caf50; word-break: break-all; font-family: monospace; border: 1px solid #333; margin: 20px 0; border-radius: 5px; font-size: 0.8rem; }
        button { background: #2e7d32; color: white; border: none; padding: 12px 20px; border-radius: 5px; cursor: pointer; font-weight: bold; }
    </style>
</head>
<body>
    <div class="card">
        <h2>Token Generato</h2>
        <p>Il tuo accesso è valido per 10 minuti</p>
        <div class="token"><?php echo $jwt; ?></div>
        <form action="validatoken.php" method="POST">
            <input type="hidden" name="token" value="<?php echo $jwt; ?>">
            <button type="submit">Entra nella Dashboard</button>
        </form>
    </div>
</body>
</html>
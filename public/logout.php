<?php
session_start();

// 1. Elimina tutte le variabili di sessione (ID utente, token, etc.)
$_SESSION = array();

// 2. Distrugge la sessione sul server
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

session_destroy();

// 3. Reindirizza l'utente alla pagina di login
header("Location: login.php");
exit;
?>
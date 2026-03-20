<?php
$dsn = "mysql:host=localhost;dbname=clubmanager;charset=utf8mb4";
$username = "utente_phpmyadmin";
$password = "ringraziandoPENNETTA";

try {
    $pdo = new PDO($dsn, $username, $password);
    // Imposta PDO per lanciare eccezioni in caso di errore (fondamentale per le transazioni)
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Facoltativo: imposta fetch mode di default ad array associativo
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die(json_encode(["error" => "Connessione fallita: " . $e->getMessage()]));
}
?>
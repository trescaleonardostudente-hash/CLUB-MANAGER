<?php
// Parametri del tuo database
$host = "localhost";
$dbname = "clubmanager";
$username = "utente_phpmyadmin";
$password = "ringraziandoPENNETTA";

// =========================================================
// 1. CONNESSIONE PDO (Serve per far funzionare il login.php)
// =========================================================
try {
    $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Connessione PDO fallita: " . $e->getMessage());
}

// =========================================================
// 2. CONNESSIONE MYSQLI (Serve per la Dashboard e il resto)
// =========================================================
$mysql = new mysqli($host, $username, $password, $dbname);

if ($mysql->connect_error) {
    die("Connessione MySQLi fallita: " . $mysql->connect_error);
}
?>
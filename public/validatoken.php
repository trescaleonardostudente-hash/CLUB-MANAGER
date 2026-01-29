<?php
session_start();
require_once './vendor/autoload.php';
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

$secret_key = "chiave-segreta-molto-lunga-1234567890";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['token'])) {
    try {
        $decoded = JWT::decode($_POST['token'], new Key($secret_key, 'HS256'));
        
        // Impostiamo le sessioni necessarie
        $_SESSION['auth_user'] = true; 
        $_SESSION['user_id'] = $decoded->uid; 
        
        header("Location: dashboard.php");
        exit;
    } catch (Exception $e) {
        die("Errore: Token scaduto o non valido. <a href='login.php'>Riprova</a>");
    }
} else { header("Location: login.php"); }
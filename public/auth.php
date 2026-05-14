<?php
session_start();
require "connessione.php";

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$query = $mysql->prepare(" 
SELECT ruoli.nome AS ruolo
FROM utenti
JOIN ruoli ON utenti.ruolo_id = ruoli.id
WHERE utenti.id = ?
");

$query->bind_param("i",$user_id);
$query->execute();

$utente = $query->get_result()->fetch_assoc();

$ruolo = $utente['ruolo'];

function isAdmin(){
    global $ruolo;
    return $ruolo == 'Amministratore';
}

function isAllenatore(){
    global $ruolo;
    return $ruolo == 'Allenatore';
}

function isVisualizzatore(){
    global $ruolo;
    return $ruolo == 'Visualizzatore';
}

function onlyAdmin(){
    if(!isAdmin()){
        die("Accesso negato");
    }
}

function onlyCoachOrAdmin(){
    if(!isAdmin() && !isAllenatore()){
        die("Accesso negato");
    }
}
?>
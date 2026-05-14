<?php
session_start();
require "connessione.php";

if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit; }

// TODO: Implementare il recupero dei campi sportivi dal database (RF4.1)
// Esempio: $campi = $mysql->query("SELECT * FROM campi");

// TODO: Implementare la logica di inserimento nuovo campo (RF4.2)
// TODO: Creare la UI per la visualizzazione settimanale per singolo campo (RF4.4)

?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Gestione Strutture</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Montserrat', sans-serif; background: #040805; color: white; padding: 40px; text-align:center; }
        .alert { background: rgba(255, 184, 0, 0.2); border: 1px solid #ffb800; padding: 20px; border-radius: 10px; max-width: 600px; margin: 0 auto; }
    </style>
</head>
<body>
    <div class="alert">
        <h2 style="color: #ffb800;">Modulo in fase di sviluppo 🚧</h2>
        <p>Come documentato nel manuale utente, la gestione CRUD delle strutture e la definizione degli orari dei campi (RF4) sono previsti per la prossima release.</p>
        <a href="dashboard.php" style="color: white;">Torna alla Dashboard</a>
    </div>
</body>
</html>

<?php
$mysql = new mysqli("localhost", "utente_phpmyadmin", "ringraziandoPENNETTA", "clubmanager");

if ($mysql->connect_error) {
    die(json_encode(["error" => "Connessione fallita: " . $mysql->connect_error]));
}
?>
<?php
require "connessione.php";
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $cat_id = $_POST['categoria_id'];

    $insert = $mysql->prepare("INSERT INTO squadre (nome, categoria_id, societa_id) VALUES (?, ?, 1)");
    $insert->bind_param("si", $nome, $cat_id);
    
    if($insert->execute()) {
        header("Location: gestione_squadre.php");
        exit;
    } else {
        echo "Errore: " . $mysql->error;
    }
}
?>
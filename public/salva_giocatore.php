<?php
require "connessione.php";
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $cognome = $_POST['cognome'];
    $anno = $_POST['anno_nascita'];
    $ruolo = $_POST['ruolo'];
    $numero = !empty($_POST['numero_maglia']) ? $_POST['numero_maglia'] : NULL;
    $cf = $_POST['codice_fiscale'];
    $contatto = $_POST['contatto_genitore'];
    $squadra_id = !empty($_POST['squadra_id']) ? $_POST['squadra_id'] : NULL;

    $insert = $mysql->prepare("INSERT INTO giocatori (nome, cognome, anno_nascita, ruolo, numero_maglia, codice_fiscale, contatto_genitore, attivo, societa_id) VALUES (?, ?, ?, ?, ?, ?, ?, 1, 1)");
    $insert->bind_param("ssisiss", $nome, $cognome, $anno, $ruolo, $numero, $cf, $contatto);
    
    if($insert->execute()) {
        $giocatore_id = $mysql->insert_id;
        if ($squadra_id) {
            $link = $mysql->prepare("INSERT INTO squadre_giocatori (squadra_id, giocatore_id) VALUES (?, ?)");
            $link->bind_param("ii", $squadra_id, $giocatore_id);
            $link->execute();
        }
        header("Location: gestione_giocatori.php");
        exit;
    } else {
        echo "Errore: " . $mysql->error;
    }
}
?>
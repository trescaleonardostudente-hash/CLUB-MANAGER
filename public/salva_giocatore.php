<?php
session_start();
require "connessione.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'] ?? null;
    $nome = $_POST['nome'];
    $cognome = $_POST['cognome'];
    $anno = $_POST['anno_nascita'];
    $ruolo = $_POST['ruolo'];
    $maglia = $_POST['numero_maglia'];
    $cf = $_POST['codice_fiscale'];
    $genitore = $_POST['contatto_genitore'];
    $scadenza = $_POST['scadenza_visita'];
    $piede = $_POST['piede_preferito'];
    $attivo = isset($_POST['attivo']) ? 1 : 0;

    if ($id) {
        // MODIFICA
        $sql = "UPDATE giocatori SET nome=?, cognome=?, anno_nascita=?, ruolo=?, numero_maglia=?, codice_fiscale=?, contatto_genitore=?, scadenza_visita=?, piede_preferito=?, attivo=? WHERE id=?";
        $stmt = $mysql->prepare($sql);
        $stmt->bind_param("ssissssssii", $nome, $cognome, $anno, $ruolo, $maglia, $cf, $genitore, $scadenza, $piede, $attivo, $id);
    } else {
        // AGGIUNTA
        $sql = "INSERT INTO giocatori (nome, cognome, anno_nascita, ruolo, numero_maglia, codice_fiscale, contatto_genitore, scadenza_visita, piede_preferito, attivo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $mysql->prepare($sql);
        $stmt->bind_param("ssissssssi", $nome, $cognome, $anno, $ruolo, $maglia, $cf, $genitore, $scadenza, $piede, $attivo);
    }

    $stmt->execute();
    header("Location: gestione_giocatori.php?msg=successo");
}
?>
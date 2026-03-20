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

    try {
        $pdo->beginTransaction(); // INIZIO TRANSAZIONE

        if ($id) {
            // MODIFICA
            $sql = "UPDATE giocatori SET nome=?, cognome=?, anno_nascita=?, ruolo=?, numero_maglia=?, codice_fiscale=?, contatto_genitore=?, scadenza_visita=?, piede_preferito=?, attivo=? WHERE id=?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$nome, $cognome, $anno, $ruolo, $maglia, $cf, $genitore, $scadenza, $piede, $attivo, $id]);
        } else {
            // AGGIUNTA
            $sql = "INSERT INTO giocatori (nome, cognome, anno_nascita, ruolo, numero_maglia, codice_fiscale, contatto_genitore, scadenza_visita, piede_preferito, attivo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$nome, $cognome, $anno, $ruolo, $maglia, $cf, $genitore, $scadenza, $piede, $attivo]);
        }

        $pdo->commit(); // CONFERMA
        header("Location: gestione_giocatori.php?msg=successo");
        exit;
        
    } catch (Exception $e) {
        $pdo->rollBack(); // ANNULLA IN CASO DI ERRORE
        die("Errore durante il salvataggio: " . $e->getMessage());
    }
}
?>
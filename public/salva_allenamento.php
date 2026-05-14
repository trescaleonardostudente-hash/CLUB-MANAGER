<?php
session_start();
require "connessione.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $squadra_id = $_POST['squadra_id'];
    $campo_id = $_POST['campo_id'];
    $data = $_POST['data'];
    $ora_inizio = $_POST['ora_inizio'];
    $ora_fine = $_POST['ora_fine'];

    // TODO: RF5.2 Gestione flessibile della durata dell'allenamento
    // TODO: RF5.5 Possibilità di duplicare o ricorrere sessioni settimanali
    // TODO: RF5.6 Possibilità di spostare allenamenti

    // CONTROLLO SOVRAPPOSIZIONI (RF5.4)
    // Verifichiamo se esiste già un allenamento su quello STESSO CAMPO, in quella STESSA DATA, 
    // in cui gli orari si accavallano.
    $check_sql = "SELECT id FROM allenamenti 
                  WHERE campo_id = ? AND data = ? 
                  AND (
                      (? < ora_fine AND ? > ora_inizio)
                  )";
    $stmt = $mysql->prepare($check_sql);
    $stmt->bind_param("isss", $campo_id, $data, $ora_inizio, $ora_fine);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Sovrapposizione trovata! Interrompi e avvisa come da manuale (Punto 4.1)
        die("<div style='background:#ff0055; color:white; padding:20px; font-family:sans-serif; text-align:center;'>
                <h2>ERRORE: SOVRAPPOSIZIONE RILEVATA (RF5.4)</h2>
                <p>Il campo selezionato è già occupato in quella fascia oraria.</p>
                <a href='pianifica_allenamento.php' style='color:white;'>Torna Indietro</a>
             </div>");
    } else {
        // Nessuna sovrapposizione, procedi col salvataggio
        $insert = $mysql->prepare("INSERT INTO allenamenti (squadra_id, campo_id, data, ora_inizio, ora_fine) VALUES (?, ?, ?, ?, ?)");
        $insert->bind_param("iisss", $squadra_id, $campo_id, $data, $ora_inizio, $ora_fine);
        if ($insert->execute()) {
            header("Location: dashboard.php");
        } else {
            echo "Errore durante il salvataggio.";
        }
    }
}
?>
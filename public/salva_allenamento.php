<?php
require "connessione.php";
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $s_id = $_POST['squadra_id'];
    $c_id = $_POST['campo_id'];
    $data = $_POST['data'];
    $ora_i = $_POST['ora_inizio'];
    $ora_f = $_POST['ora_fine'];

    // Controllo sovrapposizioni
    $sql = "SELECT COUNT(*) as tot FROM allenamenti WHERE campo_id = ? AND data = ? AND ora_inizio < ? AND ora_fine > ?";
    $stmt = $mysql->prepare($sql);
    $stmt->bind_param("isss", $c_id, $data, $ora_f, $ora_i);
    $stmt->execute();
    if($stmt->get_result()->fetch_assoc()['tot'] > 0) {
        die("<script>alert('Campo occupato in questo orario!'); window.history.back();</script>");
    }

    $insert = $mysql->prepare("INSERT INTO allenamenti (squadra_id, campo_id, data, ora_inizio, ora_fine) VALUES (?,?,?,?,?)");
    $insert->bind_param("iisss", $s_id, $c_id, $data, $ora_i, $ora_f);
    
    if($insert->execute()) { header("Location: dashboard.php"); exit; }
    else { echo "Errore: " . $mysql->error; }
}
?>
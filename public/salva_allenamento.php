<?php
session_start();
require "connessione.php";

$id = $_POST['id'] ?? '';
$squadra = $_POST['squadra_id'];
$campo = $_POST['campo_id'];
$data = $_POST['data'];
$ora_i = $_POST['ora_inizio'];
$ora_f = $_POST['ora_fine'];
$ric = isset($_POST['ricorrente']) ? 1 : 0;

try {
    $pdo->beginTransaction(); // INIZIO TRANSAZIONE

    if ($id) {
        $stmt = $pdo->prepare("
            UPDATE allenamenti
            SET squadra_id=?, campo_id=?, data=?, ora_inizio=?, ora_fine=?, ricorrente=?
            WHERE id=?
        ");
        $stmt->execute([$squadra, $campo, $data, $ora_i, $ora_f, $ric, $id]);
    } else {
        $stmt = $pdo->prepare("
            INSERT INTO allenamenti (squadra_id, campo_id, data, ora_inizio, ora_fine, ricorrente)
            VALUES (?,?,?,?,?,?)
        ");
        $stmt->execute([$squadra, $campo, $data, $ora_i, $ora_f, $ric]);
    }

    $pdo->commit(); // CONFERMA
    header("Location: allenamenti.php");
    exit;

} catch (Exception $e) {
    $pdo->rollBack(); // ANNULLA IN CASO DI ERRORE
    die("Errore durante il salvataggio: " . $e->getMessage());
}
?>
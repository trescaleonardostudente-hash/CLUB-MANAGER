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

if ($id) {
    $stmt = $mysql->prepare("
        UPDATE allenamenti
        SET squadra_id=?, campo_id=?, data=?, ora_inizio=?, ora_fine=?, ricorrente=?
        WHERE id=?
    ");
    $stmt->bind_param("iisssii", $squadra, $campo, $data, $ora_i, $ora_f, $ric, $id);
} else {
    $stmt = $mysql->prepare("
        INSERT INTO allenamenti (squadra_id, campo_id, data, ora_inizio, ora_fine, ricorrente)
        VALUES (?,?,?,?,?,?)
    ");
    $stmt->bind_param("iisssi", $squadra, $campo, $data, $ora_i, $ora_f, $ric);
}

$stmt->execute();
header("Location: allenamenti.php");
exit;

<?php
session_start();
require "connessione.php";
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit; }

// CORREZIONE: Usiamo la colonna corretta "d.tipo" come definito nel tuo SQL
$query = "SELECT d.id, d.tipo, d.data_scadenza, g.nome, g.cognome 
          FROM documenti d 
          JOIN giocatori g ON d.giocatore_id = g.id 
          ORDER BY d.data_scadenza ASC";
$result = $mysql->query($query);

// Se la query fallisce per qualche motivo, mostriamo l'errore a schermo (aiuta il debug)
if (!$result) {
    die("<div style='color:red; padding:20px; background:black;'>Errore SQL: " . $mysql->error . "</div>");
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Monitoraggio Sanitario (RF8)</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700;900&display=swap" rel="stylesheet">
    <style>
        body { background: #040805; color: white; font-family: 'Montserrat'; padding: 40px; }
        .container { background: rgba(12,24,16,0.8); padding: 30px; border-radius: 15px; border: 1px solid rgba(255,255,255,0.1); }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 15px; text-align: left; border-bottom: 1px solid rgba(255,255,255,0.1); }
        .status { padding: 5px 10px; border-radius: 5px; font-weight: 900; font-size: 0.8rem; text-transform: uppercase; }
        .verde { background: #00ff87; color: #000; }
        .giallo { background: #ffb800; color: #000; }
        .rosso { background: #ff0055; color: #fff; }
    </style>
</head>
<body>
    <div class="container">
        <h2 style="color:#00ff87;"><i class="fa-solid fa-file-medical"></i> MONITORAGGIO DOCUMENTALE (RF8.3)</h2>
        <table>
            <thead><tr><th>Atleta</th><th>Documento</th><th>Scadenza</th><th>Stato</th></tr></thead>
            <tbody>
                <?php if($result && $result->num_rows > 0): while($row = $result->fetch_assoc()): 
                    // Controllo di sicurezza se la data è nulla
                    if(empty($row['data_scadenza'])) {
                        continue; 
                    }

                    $scadenza = new DateTime($row['data_scadenza']);
                    $oggi = new DateTime();
                    
                    // Resettiamo l'orario per calcolare i giorni in modo esatto
                    $scadenza->setTime(0,0,0);
                    $oggi->setTime(0,0,0);

                    // Calcolo differenza in giorni
                    $diff = (int) $oggi->diff($scadenza)->format("%R%a");
                    
                    if ($diff < 0) { $classe = 'rosso'; $testo = 'Scaduto'; }
                    elseif ($diff <= 30) { $classe = 'giallo'; $testo = 'In Scadenza'; }
                    else { $classe = 'verde'; $testo = 'Valido'; }
                ?>
                <tr>
                    <td><strong><?= htmlspecialchars($row['cognome'] . ' ' . $row['nome']) ?></strong></td>
                    <td><?= htmlspecialchars($row['tipo']) ?></td>
                    <td><?= $scadenza->format('d/m/Y') ?></td>
                    <td><span class="status <?= $classe ?>"><?= $testo ?></span></td>
                </tr>
                <?php endwhile; else: ?>
                <tr><td colspan="4" style="text-align:center; padding:30px; color:#aaa;">Nessun documento registrato nel sistema. <br> <span style="font-size:0.8rem;">(La tabella 'documenti' è vuota. Implementare l'upload come previsto nel TODO)</span></td></tr>
                <?php endif; ?>
            </tbody>
        </table>
        <br><a href="dashboard.php" style="color:#fff; text-decoration:none; font-weight:bold; border: 1px solid #fff; padding: 10px; border-radius: 5px; display:inline-block; margin-top:20px;">Torna alla Dashboard</a>
    </div>
</body>
</html>
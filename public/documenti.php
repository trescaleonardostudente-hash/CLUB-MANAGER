<?php
session_start();
require "connessione.php";

// Query per prendere tutti i giocatori che hanno una data di visita inserita
$query = "SELECT nome, cognome, scadenza_visita, contatto_genitore FROM giocatori WHERE scadenza_visita IS NOT NULL ORDER BY scadenza_visita ASC";
$risultato = $pdo->query($query); // Usiamo $pdo->query()
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Verifica Scadenze - Club Manager</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background: #0a0a0a; color: white; font-family: sans-serif; padding: 20px; }
        .container { max-width: 900px; margin: auto; }
        .card-scadenza { background: #1a1a1a; padding: 15px; margin-bottom: 10px; border-radius: 8px; display: flex; justify-content: space-between; align-items: center; border-left: 5px solid #444; }
        
        /* Colori dinamici */
        .status-scaduto { border-left-color: #f44336; background: rgba(244, 67, 54, 0.1); }
        .status-warning { border-left-color: #ffa000; background: rgba(255, 160, 0, 0.1); }
        .status-ok { border-left-color: #4caf50; }

        .badge { padding: 5px 10px; border-radius: 4px; font-size: 0.8rem; font-weight: bold; }
        .badge-danger { background: #f44336; color: white; }
        .badge-warning { background: #ffa000; color: black; }
        .badge-success { background: #4caf50; color: white; }
    </style>
</head>
<body>
    <div class="container">
        <a href="dashboard.php" style="color: #2e7d32; text-decoration: none;"><i class="fas fa-arrow-left"></i> Torna alla Dashboard</a>
        <h1>Monitoraggio Visite Mediche</h1>

        <?php 
        while($row = $risultato->fetch()): // Sostituito fetch_assoc() con fetch()
            $oggi = new DateTime();
            $scadenza = new DateTime($row['scadenza_visita']);
            $differenza = $oggi->diff($scadenza);
            $giorni_mancanti = (int)$differenza->format("%r%a"); // %r include il segno - se passato

            // Logica del messaggio
            if ($giorni_mancanti < 0) {
                $classe = "status-scaduto";
                $messaggio = "SCADUTA";
                $badge = "badge-danger";
            } elseif ($giorni_mancanti <= 30) {
                $classe = "status-warning";
                $messaggio = "IN SCADENZA ($giorni_mancanti gg)";
                $badge = "badge-warning";
            } else {
                $classe = "status-ok";
                $messaggio = "REGOLARE";
                $badge = "badge-success";
            }
        ?>
            <div class="card-scadenza <?php echo $classe; ?>">
                <div>
                    <strong><?php echo htmlspecialchars($row['cognome'] . " " . $row['nome']); ?></strong><br>
                    <small style="color: #bbb;">Scadenza: <?php echo date('d/m/Y', strtotime($row['scadenza_visita'])); ?></small>
                </div>
                <div style="text-align: right;">
                    <span class="badge <?php echo $badge; ?>"><?php echo $messaggio; ?></span><br>
                    <small style="color: #888;">Genitore: <?php echo htmlspecialchars($row['contatto_genitore']); ?></small>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</body>
</html>
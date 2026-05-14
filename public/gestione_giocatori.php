<?php
session_start();
require "connessione.php";
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit; }

// Utilizzo la tua vista_giocatori_squadre se esiste, altrimenti fallback sulla tabella giocatori
$query = "SELECT * FROM vista_giocatori_squadre ORDER BY cognome ASC";
// Se la vista ti dà errore 500, commenta la riga sopra e de-commenta questa sotto:
// $query = "SELECT * FROM giocatori ORDER BY cognome ASC";
$result = $mysql->query($query);
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Roster Giocatori</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700;900&display=swap" rel="stylesheet">
    <style>
        body { background: #040805; color: white; font-family: 'Montserrat'; padding: 40px; }
        .container { background: rgba(12,24,16,0.8); padding: 30px; border-radius: 15px; border: 1px solid rgba(255,255,255,0.1); }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 15px; text-align: left; border-bottom: 1px solid rgba(255,255,255,0.1); }
        th { color: #00ff87; }
    </style>
</head>
<body>
    <div class="container">
        <h2 style="color:#00ff87;">ROSTER ATLETI (RF2)</h2>
        <table>
            <thead><tr><th>Cognome e Nome</th><th>Classe</th><th>Ruolo</th><th>Codice Fiscale</th><th>Squadra</th></tr></thead>
            <tbody>
                <?php if($result && $result->num_rows > 0): while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><strong><?= htmlspecialchars($row['cognome'] . ' ' . $row['nome']) ?></strong></td>
                    <td><?= htmlspecialchars($row['anno_nascita'] ?? '-') ?></td>
                    <td><?= htmlspecialchars($row['ruolo'] ?? '-') ?></td>
                    <td><?= htmlspecialchars($row['codice_fiscale'] ?? '-') ?></td>
                    <td><?= htmlspecialchars($row['squadra'] ?? 'Svincolato') ?></td>
                </tr>
                <?php endwhile; else: ?>
                <tr><td colspan="5">Nessun atleta trovato.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
        <br><a href="dashboard.php" style="color:#fff;">Torna alla Dashboard</a>
    </div>
</body>
</html>
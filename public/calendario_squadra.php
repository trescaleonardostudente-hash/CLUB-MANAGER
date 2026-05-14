<?php
session_start();
require "connessione.php";
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit; }

// Sfruttiamo la Vista (VIEW) che unisce allenamenti, squadre e campi
$query = "SELECT * FROM vista_calendario_allenamenti WHERE data >= CURDATE() ORDER BY data ASC, ora_inizio ASC";
$result = $mysql->query($query);
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Calendario Allenamenti</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --primary: #00ff87; --bg-dark: #040805; --bg-card: rgba(12, 24, 16, 0.7); --text-main: #ffffff; --glass-border: rgba(255, 255, 255, 0.1); }
        body { margin: 0; font-family: 'Montserrat', sans-serif; background: radial-gradient(circle at top left, #0d2e1a, var(--bg-dark) 80%); color: var(--text-main); min-height: 100vh; padding: 40px; }
        .container { max-width: 1000px; margin: 0 auto; background: var(--bg-card); padding: 30px; border-radius: 16px; border: 1px solid var(--glass-border); backdrop-filter: blur(10px); }
        h1 { color: var(--primary); text-transform: uppercase; font-weight: 900; margin-bottom: 30px; text-align:center; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 15px; text-align: left; border-bottom: 1px solid var(--glass-border); }
        th { color: var(--primary); text-transform: uppercase; font-size: 0.8rem; }
        .btn-back { display:block; text-align:center; margin-top:20px; color:#aaa; text-decoration:none; text-transform:uppercase; font-size:0.8rem; font-weight:bold; }
    </style>
</head>
<body>
<div class="container">
    <h1><i class="fa-solid fa-calendar-days"></i> Calendario Settimanale</h1>
    <table>
        <thead><tr><th>Data</th><th>Orario</th><th>Squadra</th><th>Campo</th></tr></thead>
        <tbody>
            <?php if($result && $result->num_rows > 0): ?>
                <?php while($a = $result->fetch_assoc()): ?>
                <tr>
                    <td style="font-weight:bold;"><?= date('d/m/Y', strtotime($a['data'])) ?></td>
                    <td><?= date('H:i', strtotime($a['ora_inizio'])) ?> - <?= date('H:i', strtotime($a['ora_fine'])) ?></td>
                    <td style="color:var(--primary); font-weight:bold;"><?= htmlspecialchars($a['squadra']) ?></td>
                    <td><?= htmlspecialchars($a['campo']) ?></td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="4" style="text-align:center;">Nessun allenamento programmato.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
    <a href="dashboard.php" class="btn-back">Torna alla Dashboard</a>
</div>
</body>
</html>
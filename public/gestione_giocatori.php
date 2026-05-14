<?php
session_start();
require "connessione.php";
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit; }

$result = $mysql->query("SELECT * FROM vista_giocatori_squadre WHERE attivo = 1 ORDER BY cognome ASC");
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Roster Giocatori</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --primary: #00ff87; --bg-dark: #040805; --bg-card: rgba(12, 24, 16, 0.7); --text-main: #ffffff; --glass-border: rgba(255, 255, 255, 0.1); }
        body { margin: 0; font-family: 'Montserrat', sans-serif; background: radial-gradient(circle at top left, #0d2e1a, var(--bg-dark) 80%); color: var(--text-main); min-height: 100vh; padding: 40px; }
        .container { max-width: 1200px; margin: 0 auto; background: var(--bg-card); padding: 30px; border-radius: 16px; border: 1px solid var(--glass-border); backdrop-filter: blur(10px); }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        h1 { color: var(--primary); text-transform: uppercase; font-weight: 900; margin:0; }
        .btn { padding: 10px 20px; background: var(--primary); color: #000; border-radius: 8px; font-weight: 800; text-transform: uppercase; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; }
        .btn-outline { background: transparent; color: #fff; border: 1px solid var(--glass-border); }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 15px; text-align: left; border-bottom: 1px solid var(--glass-border); }
        th { color: var(--primary); text-transform: uppercase; font-size: 0.8rem; letter-spacing: 1px; }
        tr:hover { background: rgba(255,255,255,0.03); }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1><i class="fa-solid fa-users"></i> Roster Atleti</h1>
        <div>
            <a href="dashboard.php" class="btn btn-outline">Dashboard</a>
            <a href="form_giocatore.php" class="btn"><i class="fa-solid fa-plus"></i> Nuovo</a>
        </div>
    </div>
    <table>
        <thead><tr><th>Atleta</th><th>Anno</th><th>Ruolo</th><th>Squadra</th></tr></thead>
        <tbody>
            <?php while($g = $result->fetch_assoc()): ?>
            <tr>
                <td style="font-weight:bold;"><?= htmlspecialchars($g['cognome'] . " " . $g['nome']) ?></td>
                <td><?= $g['anno_nascita'] ?></td>
                <td><?= htmlspecialchars($g['ruolo']) ?></td>
                <td style="color:var(--primary); font-weight:800;"><?= htmlspecialchars($g['squadra'] ?? 'Svincolato') ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>
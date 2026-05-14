<?php
session_start();
require "connessione.php";

if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit; }

$query = "SELECT * FROM vista_allenatori_squadre";
$result = $mysql->query($query);
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Staff Tecnico</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --primary: #00ff87; --bg-dark: #040805; --bg-card: rgba(12, 24, 16, 0.65); --text-main: #ffffff; --glass-border: rgba(255, 255, 255, 0.06); }
        body { margin: 0; font-family: 'Montserrat', sans-serif; background: radial-gradient(circle at top right, #0d2e1a, var(--bg-dark) 80%); color: var(--text-main); min-height: 100vh; padding: 2rem; }
        .container { max-width: 1200px; margin: 0 auto; background: var(--bg-card); padding: 2rem; border-radius: 16px; border: 1px solid var(--glass-border); backdrop-filter: blur(10px); }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; border-bottom: 1px solid var(--glass-border); padding-bottom: 1rem; }
        h1 { margin: 0; color: var(--primary); text-transform: uppercase; font-weight: 900; }
        .btn-outline { padding: 10px 20px; text-decoration: none; border-radius: 8px; font-weight: 800; text-transform: uppercase; font-size: 0.8rem; background: transparent; color: #fff; border: 1px solid var(--glass-border); }
        table { width: 100%; border-collapse: collapse; margin-top: 1rem; }
        th, td { padding: 15px; text-align: left; border-bottom: 1px solid var(--glass-border); }
        th { color: var(--primary); text-transform: uppercase; font-size: 0.8rem; }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1><i class="fa-solid fa-whistle"></i> Staff Tecnico</h1>
        <a href="dashboard.php" class="btn-outline"><i class="fa-solid fa-arrow-left"></i> Dashboard</a>
    </div>
    <table>
        <thead><tr><th>Mister</th><th>Patentino</th><th>Contatti</th><th>Squadra Assegnata</th></tr></thead>
        <tbody>
            <?php if($result && $result->num_rows > 0): ?>
                <?php while($a = $result->fetch_assoc()): ?>
                <tr>
                    <td style="font-weight:bold;"><?= htmlspecialchars($a['nome']) ?></td>
                    <td><?= htmlspecialchars($a['patentino'] ?? 'N/D') ?></td>
                    <td style="font-size:0.8rem;"><?= htmlspecialchars($a['telefono']) ?><br><?= htmlspecialchars($a['email']) ?></td>
                    <td style="color:var(--primary);"><?= htmlspecialchars($a['squadra'] ?? 'Senza Squadra') ?></td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="4" style="text-align:center;">Nessun allenatore in archivio.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>
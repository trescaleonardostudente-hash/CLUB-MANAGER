<?php
session_start();
require "connessione.php";
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit; }

$query = "SELECT s.id, s.nome, c.nome as categoria FROM squadre s LEFT JOIN categorie c ON s.categoria_id = c.id";
$result = $mysql->query($query);
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Gestione Squadre</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;900&display=swap" rel="stylesheet">
    <style>
        /* STILE IDENTICO A GESTIONE GIOCATORI */
        :root { --primary: #00ff87; --bg-dark: #040805; --bg-card: rgba(12, 24, 16, 0.7); --text-main: #ffffff; --glass-border: rgba(255, 255, 255, 0.1); }
        body { margin: 0; font-family: 'Montserrat', sans-serif; background: radial-gradient(circle at top left, #0d2e1a, var(--bg-dark) 80%); color: var(--text-main); min-height: 100vh; padding: 40px; }
        .container { max-width: 1000px; margin: 0 auto; background: var(--bg-card); padding: 30px; border-radius: 16px; border: 1px solid var(--glass-border); backdrop-filter: blur(10px); }
        h1 { color: var(--primary); text-transform: uppercase; font-weight: 900; margin-bottom: 30px; text-align:center; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 15px; text-align: left; border-bottom: 1px solid var(--glass-border); }
        th { color: var(--primary); text-transform: uppercase; font-size: 0.8rem; }
        .btn-back { display:block; text-align:center; margin-top:20px; color:#aaa; text-decoration:none; text-transform:uppercase; font-size:0.8rem; }
    </style>
</head>
<body>
<div class="container">
    <h1>Squadre del Club</h1>
    <table>
        <thead><tr><th>ID</th><th>Nome Squadra</th><th>Categoria</th></tr></thead>
        <tbody>
            <?php while($s = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $s['id'] ?></td>
                <td style="font-weight:bold; color:var(--primary);"><?= htmlspecialchars($s['nome']) ?></td>
                <td><?= htmlspecialchars($s['categoria'] ?? 'N/D') ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <a href="dashboard.php" class="btn-back">Torna alla Dashboard</a>
</div>
</body>
</html>
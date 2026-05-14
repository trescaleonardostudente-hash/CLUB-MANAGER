<?php
session_start();
require "connessione.php";
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit; }

$query = "SELECT s.id, s.nome, c.nome AS categoria FROM squadre s LEFT JOIN categorie c ON s.categoria_id = c.id";
$result = $mysql->query($query);
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Elenco Squadre</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700;900&display=swap" rel="stylesheet">
    <style> /* Stessi stili degli altri file */ body { background: #040805; color: white; font-family: 'Montserrat'; padding: 40px; } .container { background: rgba(12,24,16,0.8); padding: 30px; border-radius: 15px; border: 1px solid rgba(255,255,255,0.1); } table { width: 100%; border-collapse: collapse; margin-top: 20px; } th, td { padding: 15px; text-align: left; border-bottom: 1px solid rgba(255,255,255,0.1); } th { color: #00ff87; } </style>
</head>
<body>
    <div class="container">
        <h2 style="color:#00ff87;">ELENCO SQUADRE (RF1)</h2>
        <table>
            <thead><tr><th>ID (RF1.3)</th><th>Nome Squadra</th><th>Categoria (RF1.2)</th></tr></thead>
            <tbody>
                <?php if($result && $result->num_rows > 0): while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td>#<?= $row['id'] ?></td>
                    <td><strong><?= htmlspecialchars($row['nome']) ?></strong></td>
                    <td><?= htmlspecialchars($row['categoria'] ?? 'Non Assegnata') ?></td>
                </tr>
                <?php endwhile; endif; ?>
            </tbody>
        </table>
        <br><a href="dashboard.php" style="color:#fff;">Torna alla Dashboard</a>
    </div>
</body>
</html>
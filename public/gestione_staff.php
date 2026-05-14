<?php
session_start();
require "connessione.php";
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit; }

$query = "SELECT * FROM allenatori";
$result = $mysql->query($query);
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Staff Tecnico</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700;900&display=swap" rel="stylesheet">
    <style> /* Stessi stili */ body { background: #040805; color: white; font-family: 'Montserrat'; padding: 40px; } .container { background: rgba(12,24,16,0.8); padding: 30px; border-radius: 15px; border: 1px solid rgba(255,255,255,0.1); } table { width: 100%; border-collapse: collapse; } th, td { padding: 15px; text-align: left; border-bottom: 1px solid rgba(255,255,255,0.1); } th { color: #00ff87; } </style>
</head>
<body>
    <div class="container">
        <h2 style="color:#00ff87;">STAFF TECNICO (RF3)</h2>
        <table>
            <thead><tr><th>Nome</th><th>Contatto Telefonico</th><th>Email</th><th>Patentino</th></tr></thead>
            <tbody>
                <?php if($result && $result->num_rows > 0): while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><strong><?= htmlspecialchars($row['nome'] . " " . $row['cognome']) ?></strong></td>
                    <td><?= htmlspecialchars($row['telefono'] ?? '-') ?></td>
                    <td><?= htmlspecialchars($row['email'] ?? '-') ?></td>
                    <td><?= htmlspecialchars($row['patentino'] ?? '-') ?></td>
                </tr>
                <?php endwhile; else: ?>
                <tr><td colspan="4">Nessun allenatore censito.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
        <br><a href="dashboard.php" style="color:#fff;">Torna alla Dashboard</a>
    </div>
</body>
</html>S
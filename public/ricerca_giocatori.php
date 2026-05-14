<?php
session_start();
require "connessione.php";
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit; }

$risultati = null;
if (isset($_GET['cerca'])) {
    $termine = "%" . $_GET['cerca'] . "%";
    $query = "SELECT * FROM vista_giocatori_squadre WHERE nome LIKE ? OR cognome LIKE ? OR codice_fiscale LIKE ?";
    $stmt = $mysql->prepare($query);
    $stmt->bind_param("sss", $termine, $termine, $termine);
    $stmt->execute();
    $risultati = $stmt->get_result();
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Ricerca Database</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Copia qui lo stile di calendario_squadra.php per velocità */
        :root { --primary: #00ff87; --bg-dark: #040805; --bg-card: rgba(12, 24, 16, 0.7); --text-main: #ffffff; --glass-border: rgba(255, 255, 255, 0.1); }
        body { margin: 0; font-family: 'Montserrat', sans-serif; background: radial-gradient(circle at top left, #0d2e1a, var(--bg-dark) 80%); color: var(--text-main); min-height: 100vh; padding: 40px; }
        .container { max-width: 1000px; margin: 0 auto; background: var(--bg-card); padding: 30px; border-radius: 16px; border: 1px solid var(--glass-border); backdrop-filter: blur(10px); }
        input[type="text"] { width: 70%; padding: 15px; border-radius: 8px; border: none; }
        button { padding: 15px 25px; background: var(--primary); border: none; font-weight: bold; border-radius: 8px; cursor: pointer; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px;}
        th, td { padding: 15px; text-align: left; border-bottom: 1px solid var(--glass-border); }
        th { color: var(--primary); text-transform: uppercase; font-size: 0.8rem; }
    </style>
</head>
<body>
<div class="container">
    <h1 style="color:var(--primary); text-align:center;"><i class="fa-solid fa-search"></i> Ricerca Tesserato</h1>
    <form method="GET" style="display:flex; gap:10px; justify-content:center; margin-bottom: 30px;">
        <input type="text" name="cerca" placeholder="Nome, Cognome o Codice Fiscale..." required>
        <button type="submit">Cerca</button>
    </form>

    <?php if($risultati): ?>
    <table>
        <thead><tr><th>Nome</th><th>Ruolo</th><th>Codice Fiscale</th><th>Squadra</th></tr></thead>
        <tbody>
            <?php while($g = $risultati->fetch_assoc()): ?>
            <tr>
                <td style="font-weight:bold;"><?= htmlspecialchars($g['cognome'] . ' ' . $g['nome']) ?></td>
                <td><?= htmlspecialchars($g['ruolo']) ?></td>
                <td><?= htmlspecialchars($g['codice_fiscale']) ?></td>
                <td style="color:var(--primary);"><?= htmlspecialchars($g['squadra'] ?? 'Svincolato') ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <?php endif; ?>
    <a href="dashboard.php" style="display:block; text-align:center; margin-top:20px; color:#aaa; text-decoration:none;">Torna alla Dashboard</a>
</div>
</body>
</html>
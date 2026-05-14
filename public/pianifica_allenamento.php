<?php
session_start();
require "connessione.php";
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit; }

// Recupero squadre e campi con i nomi corretti del tuo DB
$squadre = $mysql->query("SELECT id, nome FROM squadre ORDER BY nome");
$campi = $mysql->query("SELECT id, nome FROM campi ORDER BY nome");
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Pianifica Allenamento</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --primary: #00ff87; --bg-dark: #040805; --bg-card: rgba(12, 24, 16, 0.8); --text-main: #ffffff; --glass-border: rgba(255, 255, 255, 0.1); }
        body { margin: 0; font-family: 'Montserrat', sans-serif; background: radial-gradient(circle at top right, #0d2e1a, var(--bg-dark) 80%); color: var(--text-main); min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 20px; }
        .form-box { background: var(--bg-card); padding: 40px; border-radius: 16px; border: 1px solid var(--glass-border); backdrop-filter: blur(10px); width: 100%; max-width: 500px; box-shadow: 0 10px 30px rgba(0,0,0,0.5); }
        h1 { color: var(--primary); text-transform: uppercase; font-weight: 900; margin: 0 0 30px 0; text-align: center; border-bottom: 2px solid var(--primary); padding-bottom: 10px; }
        .form-group { margin-bottom: 20px; }
        label { display: block; font-size: 0.8rem; font-weight: 800; color: #aaa; text-transform: uppercase; margin-bottom: 8px; }
        input, select { width: 100%; padding: 12px; background: rgba(0,0,0,0.5); border: 1px solid var(--glass-border); border-radius: 8px; color: #fff; font-family: inherit; box-sizing: border-box; }
        .btn { width: 100%; padding: 15px; background: var(--primary); color: #000; font-weight: 900; border: none; border-radius: 8px; text-transform: uppercase; cursor: pointer; transition: 0.3s; margin-top: 10px; }
        .btn:hover { background: #00e67a; transform: translateY(-2px); box-shadow: 0 5px 15px rgba(0,255,135,0.4); }
        .btn-back { display: block; text-align: center; color: #aaa; text-decoration: none; margin-top: 20px; font-size: 0.8rem; font-weight: 600; text-transform: uppercase; }
    </style>
</head>
<body>
<div class="form-box">
    <h1><i class="fa-solid fa-stopwatch"></i> Prenota Campo</h1>
    <form action="salva_allenamento.php" method="POST">
        <div class="form-group">
            <label>Squadra</label>
            <select name="squadra_id" required>
                <option value="">-- Seleziona Squadra --</option>
                <?php while($s = $squadre->fetch_assoc()): ?>
                    <option value="<?= $s['id'] ?>"><?= htmlspecialchars($s['nome']) ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="form-group">
            <label>Campo</label>
            <select name="campo_id" required>
                <option value="">-- Seleziona Struttura --</option>
                <?php while($c = $campi->fetch_assoc()): ?>
                    <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['nome']) ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="form-group"><label>Data</label><input type="date" name="data" required></div>
        <div style="display:flex; gap:15px;">
            <div class="form-group" style="flex:1;"><label>Inizio</label><input type="time" name="ora_inizio" required></div>
            <div class="form-group" style="flex:1;"><label>Fine</label><input type="time" name="ora_fine" required></div>
        </div>
        <button type="submit" class="btn">Salva Sessione</button>
        <a href="dashboard.php" class="btn-back">Torna Indietro</a>
    </form>
</div>
</body>
</html>
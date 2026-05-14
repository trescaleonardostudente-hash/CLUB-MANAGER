<?php
session_start();
require "connessione.php";
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit; }

$squadre = $mysql->query("SELECT id, nome FROM squadre ORDER BY nome ASC");
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Nuovo Atleta - Club Manager</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --primary: #00ff87; --bg-dark: #040805; --bg-card: rgba(12, 24, 16, 0.8); --text-main: #ffffff; --glass-border: rgba(255, 255, 255, 0.1); }
        body { margin: 0; font-family: 'Montserrat', sans-serif; background: radial-gradient(circle at top right, #0d2e1a, var(--bg-dark) 80%); color: var(--text-main); min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 40px 20px; }
        .form-box { background: var(--bg-card); padding: 40px; border-radius: 16px; border: 1px solid var(--glass-border); backdrop-filter: blur(10px); width: 100%; max-width: 650px; box-shadow: 0 10px 30px rgba(0,0,0,0.5); }
        h1 { color: var(--primary); text-transform: uppercase; font-weight: 900; margin: 0 0 30px 0; text-align: center; border-bottom: 2px solid var(--primary); padding-bottom: 10px; }
        .grid-row { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px; }
        .form-group { margin-bottom: 20px; }
        label { display: block; font-size: 0.75rem; font-weight: 800; color: #aaa; text-transform: uppercase; margin-bottom: 8px; }
        input, select { width: 100%; padding: 12px; background: rgba(0,0,0,0.5); border: 1px solid var(--glass-border); border-radius: 8px; color: #fff; font-family: inherit; box-sizing: border-box; }
        .btn { width: 100%; padding: 15px; background: var(--primary); color: #000; font-weight: 900; border: none; border-radius: 8px; text-transform: uppercase; cursor: pointer; transition: 0.3s; margin-top: 10px; }
        .btn:hover { background: #00e67a; transform: translateY(-2px); }
        .btn-back { display: block; text-align: center; color: #aaa; text-decoration: none; margin-top: 20px; font-size: 0.8rem; font-weight: 600; text-transform: uppercase; }
    </style>
</head>
<body>
<div class="form-box">
    <h1><i class="fa-solid fa-user-plus"></i> Nuovo Atleta</h1>
    <form action="salva_giocatore.php" method="POST">
        <div class="grid-row">
            <div class="form-group"><label>Nome</label><input type="text" name="nome" required></div>
            <div class="form-group"><label>Cognome</label><input type="text" name="cognome" required></div>
        </div>
        <div class="grid-row">
            <div class="form-group"><label>Anno di Nascita</label><input type="number" name="anno_nascita" min="1950" max="2026" required></div>
            <div class="form-group"><label>Ruolo</label>
                <select name="ruolo" required>
                    <option value="Portiere">Portiere</option>
                    <option value="Difensore">Difensore</option>
                    <option value="Centrocampista">Centrocampista</option>
                    <option value="Attaccante">Attaccante</option>
                </select>
            </div>
        </div>
        <div class="grid-row">
            <div class="form-group"><label>Numero Maglia</label><input type="number" name="numero_maglia"></div>
            <div class="form-group"><label>Codice Fiscale</label><input type="text" name="codice_fiscale" maxlength="16" required></div>
        </div>
        <div class="form-group"><label>Contatto Genitore (Telefono/Email)</label><input type="text" name="contatto_genitore"></div>
        <div class="form-group">
            <label>Assegna a Squadra</label>
            <select name="squadra_id">
                <option value="">-- Svincolato --</option>
                <?php while($s = $squadre->fetch_assoc()): ?>
                    <option value="<?= $s['id'] ?>"><?= htmlspecialchars($s['nome']) ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <button type="submit" class="btn">Registra Giocatore</button>
        <a href="gestione_giocatori.php" class="btn-back">Torna Indietro</a>
    </form>
</div>
</body>
</html>
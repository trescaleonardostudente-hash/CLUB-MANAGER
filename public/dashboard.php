<?php
session_start();
require "connessione.php";

if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit; }

$user_id = $_SESSION['user_id'];

// Recupero Ruolo e Dati Utente (RF7)
$u_info = $mysql->query("SELECT u.nome, r.nome AS ruolo_testo, u.ruolo_id FROM utenti u JOIN ruoli r ON u.ruolo_id = r.id WHERE u.id = $user_id")->fetch_assoc();
$nome_utente = $u_info['nome'] ?? 'Utente';
$ruolo_label = $u_info['ruolo_testo'] ?? 'Visualizzatore';
$ruolo_id = $u_info['ruolo_id']; // 1: Admin, 2: Allenatore, 3: Visualizzatore

function getKPI($mysql, $sql) {
    $res = $mysql->query($sql);
    return ($res && $row = $res->fetch_row()) ? $row[0] : 0;
}

$tot_squadre = getKPI($mysql, "SELECT COUNT(*) FROM squadre");
$tot_atleti = getKPI($mysql, "SELECT COUNT(*) FROM giocatori WHERE attivo = 1");
$scadenze_alert = getKPI($mysql, "SELECT COUNT(*) FROM documenti WHERE data_scadenza < DATE_ADD(CURDATE(), INTERVAL 30 DAY)");
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>ClubManager - Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --primary: #00ff87; --bg: #040805; --card: rgba(12, 24, 16, 0.7); --text: #fff; --danger: #ff0055; }
        body { margin: 0; font-family: 'Montserrat', sans-serif; background: radial-gradient(circle at top right, #0d2e1a, var(--bg) 80%); color: var(--text); min-height: 100vh; }
        .navbar { display: flex; justify-content: space-between; padding: 1rem 2rem; background: rgba(0,0,0,0.5); backdrop-filter: blur(10px); border-bottom: 1px solid rgba(255,255,255,0.1); }
        .container { max-width: 1200px; margin: 0 auto; padding: 2rem; }
        .kpi-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 2rem; }
        .kpi-card { background: var(--card); padding: 1.5rem; border-radius: 12px; text-align: center; border: 1px solid rgba(255,255,255,0.05); }
        .kpi-card .val { font-size: 2.5rem; font-weight: 900; color: var(--primary); }
        .modules-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 2rem; }
        .module { background: var(--card); border-radius: 16px; border: 1px solid rgba(255,255,255,0.1); overflow: hidden; }
        .m-head { padding: 1rem; background: rgba(0,0,0,0.2); font-weight: 900; text-transform: uppercase; border-bottom: 1px solid rgba(255,255,255,0.05); }
        .m-body { padding: 1.5rem; display: flex; flex-direction: column; gap: 12px; }
        .btn { padding: 12px; text-decoration: none; border-radius: 8px; font-weight: 800; text-transform: uppercase; font-size: 0.75rem; display: flex; justify-content: space-between; align-items: center; }
        .btn-p { background: var(--primary); color: #000; }
        .btn-o { border: 1px solid rgba(255,255,255,0.1); color: #fff; }
        .badge { background: var(--primary); color: #000; padding: 2px 10px; border-radius: 10px; font-weight: 900; font-size: 0.7rem; }
    </style>
</head>
<body>

<nav class="navbar">
    <div style="font-weight:900;"><i class="fa-solid fa-shield-halved" style="color:var(--primary)"></i> CLUBMANAGER</div>
    <div style="display:flex; align-items:center; gap:15px;">
        <span class="badge"><?= $ruolo_label ?></span>
        <span><?= htmlspecialchars($nome_utente) ?></span>
        <a href="logout.php" style="color:var(--danger);"><i class="fa-solid fa-power-off"></i></a>
    </div>
</nav>

<div class="container">
    <div class="kpi-grid">
        <div class="kpi-card"><h3>Squadre</h3><div class="val"><?= $tot_squadre ?></div></div>
        <div class="kpi-card"><h3>Atleti</h3><div class="val"><?= $tot_atleti ?></div></div>
        <div class="kpi-card"><h3>Scadenze Doc</h3><div class="val" style="color:<?= $scadenze_alert > 0 ? 'var(--danger)' : 'var(--primary)' ?>"><?= $scadenze_alert ?></div></div>
    </div>

    <div class="modules-grid">
        <div class="module">
            <div class="m-head">3.1 Gestione Squadre</div>
            <div class="m-body">
                <?php if($ruolo_id == 1): ?>
                    <a href="form_squadra.php" class="btn btn-p">Nuova Squadra (RF1.1) <i class="fa-solid fa-plus"></i></a>
                <?php endif; ?>
                <a href="gestione_squadre.php" class="btn btn-o">Elenco Squadre <i class="fa-solid fa-list"></i></a>
                <?php if($ruolo_id == 1): ?>
                    <a href="gestione_staff.php" class="btn btn-o">Staff Tecnico (RF3) <i class="fa-solid fa-whistle"></i></a>
                <?php endif; ?>
            </div>
        </div>

        <div class="module">
            <div class="m-head">3.2 Anagrafica & Segreteria</div>
            <div class="m-body">
                <?php if($ruolo_id <= 2): ?>
                    <a href="form_giocatore.php" class="btn btn-p">Nuovo Atleta (RF2.1) <i class="fa-solid fa-user-plus"></i></a>
                <?php endif; ?>
                <a href="gestione_giocatori.php" class="btn btn-o">Roster Atleti <i class="fa-solid fa-users"></i></a>
                <a href="documenti.php" class="btn btn-o">Monitoraggio Documentale (RF8) <i class="fa-solid fa-file-medical"></i></a>
            </div>
        </div>

        <div class="module">
            <div class="m-head">4.0 Area Tecnica</div>
            <div class="m-body">
                <?php if($ruolo_id <= 2): ?>
                    <a href="pianifica_allenamento.php" class="btn btn-p">Pianifica Sessione (RF5) <i class="fa-solid fa-stopwatch"></i></a>
                <?php endif; ?>
                <a href="calendario_squadra.php" class="btn btn-o">Consultazione Calendari <i class="fa-solid fa-calendar"></i></a>
                <a href="ricerca_giocatori.php" class="btn btn-o">Ricerca Atleti (RF9) <i class="fa-solid fa-magnifying-glass"></i></a>
            </div>
        </div>
    </div>
</div>
</body>
</html>
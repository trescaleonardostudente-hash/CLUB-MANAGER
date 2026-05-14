<?php
session_start();
require "connessione.php";

// 1. Controllo di Sicurezza
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// 2. Recupero Utente e Ruolo
$query_user = "SELECT u.nome, r.nome AS nome_ruolo FROM utenti u JOIN ruoli r ON u.ruolo_id = r.id WHERE u.id = ?";
$stmt = $mysql->prepare($query_user);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user_info = $stmt->get_result()->fetch_assoc();

$nome_utente = $user_info['nome'] ?? 'Utente';
$ruolo = $user_info['nome_ruolo'] ?? 'Visualizzatore';

// 3. Funzione di Sicurezza per i KPI (Evita Errore 500)
function getCountSicuro($connessione, $query) {
    $result = $connessione->query($query);
    if ($result && $row = $result->fetch_assoc()) {
        return $row['tot'] ?? 0;
    }
    return 0;
}

// 4. Calcolo Statistiche
$tot_squadre = getCountSicuro($mysql, "SELECT COUNT(*) as tot FROM squadre");
$tot_giocatori = getCountSicuro($mysql, "SELECT COUNT(*) as tot FROM giocatori WHERE attivo = 1");
$scadenza_doc = getCountSicuro($mysql, "SELECT COUNT(*) as tot FROM documenti WHERE data_scadenza < DATE_ADD(CURDATE(), INTERVAL 30 DAY)");
$notifiche = getCountSicuro($mysql, "SELECT COUNT(*) as tot FROM notifiche WHERE letto = 0");
$allenamenti_oggi = getCountSicuro($mysql, "SELECT COUNT(*) as tot FROM allenamenti WHERE data = CURDATE()");
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Club Manager Pro - Hub Centrale</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        /* TEMA PREMIUM "EA FC" INCLUSO */
        :root { 
            --primary: #00ff87; 
            --primary-glow: rgba(0, 255, 135, 0.4);
            --bg-dark: #040805; 
            --bg-card: rgba(12, 24, 16, 0.65); 
            --accent-danger: #ff0055; 
            --text-main: #ffffff; 
            --text-muted: #94a39a; 
            --glass-border: rgba(255, 255, 255, 0.06); 
            --glass-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.3);
        }

        body { margin: 0; font-family: 'Montserrat', sans-serif; background: radial-gradient(circle at top right, #0d2e1a, var(--bg-dark) 80%); color: var(--text-main); min-height: 100vh; }
        
        .navbar { display: flex; justify-content: space-between; align-items: center; padding: 1.2rem 4rem; background: rgba(0, 0, 0, 0.4); backdrop-filter: blur(15px); border-bottom: 1px solid var(--glass-border); position: sticky; top: 0; z-index: 1000; }
        .brand { font-size: 1.4rem; font-weight: 900; color: var(--text-main); text-transform: uppercase; display: flex; align-items: center; gap: 10px; }
        .brand i { color: var(--primary); font-size: 1.6rem; }
        
        .user-profile { display: flex; align-items: center; gap: 20px; }
        .badge-ruolo { background: linear-gradient(135deg, var(--primary), #00b35e); color: #000; padding: 5px 15px; border-radius: 50px; font-weight: 900; font-size: 0.7rem; text-transform: uppercase; box-shadow: 0 0 10px var(--primary-glow); }
        .user-name { font-weight: 600; font-size: 0.9rem; }
        .logout-link { color: var(--accent-danger); text-decoration: none; font-weight: 800; font-size: 0.85rem; display: flex; align-items: center; gap: 6px; transition: 0.3s; }
        .logout-link:hover { text-shadow: 0 0 10px var(--accent-danger); }

        .container { max-width: 1400px; margin: 0 auto; padding: 3rem 2rem; }
        .page-title { font-size: 2.5rem; font-weight: 900; margin: 0 0 5px 0; text-transform: uppercase; }
        .page-subtitle { color: var(--text-muted); margin: 0; font-size: 1rem; font-weight: 400; }

        .kpi-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; margin-bottom: 4rem; margin-top:2rem;}
        .kpi-card { background: var(--bg-card); border: 1px solid var(--glass-border); padding: 1.5rem; border-radius: 16px; text-align: center; position: relative; overflow: hidden; backdrop-filter: blur(10px); box-shadow: var(--glass-shadow); transition: 0.3s;}
        .kpi-card:hover { transform: translateY(-5px); border-color: rgba(0, 255, 135, 0.3); }
        .kpi-card::after { content: ''; position: absolute; bottom: 0; left: 0; width: 100%; height: 4px; background: var(--primary); opacity: 0.7; }
        .kpi-card.alert::after { background: var(--accent-danger); }
        .kpi-card h3 { font-size: 0.75rem; text-transform: uppercase; color: var(--text-muted); margin: 0 0 10px 0; font-weight: 700; }
        .kpi-card .value { font-size: 2.8rem; font-weight: 900; color: var(--text-main); line-height: 1; }
        .kpi-card.alert .value { color: var(--accent-danger); }

        .modules-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(340px, 1fr)); gap: 2rem; }
        .module { background: var(--bg-card); border-radius: 16px; border: 1px solid var(--glass-border); display: flex; flex-direction: column; overflow: hidden; backdrop-filter: blur(10px); box-shadow: var(--glass-shadow); transition: 0.3s;}
        .module-header { padding: 1.2rem 1.5rem; font-weight: 900; background: rgba(0, 0, 0, 0.2); border-bottom: 1px solid var(--glass-border); text-transform: uppercase; font-size: 0.9rem; display: flex; justify-content: space-between; align-items: center;}
        .module-header i { color: var(--primary); margin-right: 8px; font-size: 1.1rem; }
        .rf-badge { font-size: 0.6rem; background: rgba(255,255,255,0.05); color: var(--text-muted); padding: 4px 8px; border-radius: 4px; border: 1px solid rgba(255,255,255,0.1); }
        .module-body { padding: 1.5rem; flex-grow: 1; display: flex; flex-direction: column; gap:10px;}
        .module-desc { font-size: 0.85rem; color: var(--text-muted); margin-bottom: 1.5rem; line-height: 1.6; }
        
        .action-list { display: flex; flex-direction: column; gap: 10px; margin-top: auto; }
        .btn { padding: 1rem 1.2rem; text-decoration: none; font-weight: 800; font-size: 0.8rem; border-radius: 8px; text-transform: uppercase; transition: 0.2s; display: flex; justify-content: space-between; align-items: center; border: 1px solid transparent; }
        .btn-primary { background: var(--primary); color: #000; }
        .btn-primary:hover { background: #00e67a; transform: translateY(-2px); box-shadow: 0 5px 20px var(--primary-glow); }
        .btn-outline { background: rgba(255,255,255,0.03); color: var(--text-main); border-color: var(--glass-border); }
        .btn-outline:hover { background: rgba(255,255,255,0.08); border-color: rgba(255,255,255,0.2); }
        .btn-viewer { background: transparent; color: var(--text-muted); border: 1px dashed rgba(255,255,255,0.2); }
        .btn-viewer:hover { color: var(--text-main); border-style: solid; border-color: rgba(255,255,255,0.4); }
    </style>
</head>
<body>

<nav class="navbar">
    <div class="brand"><i class="fa-solid fa-shield-halved"></i> Club Manager</div>
    <div class="user-profile">
        <span class="badge-ruolo"><?= htmlspecialchars($ruolo) ?></span>
        <span class="user-name"><?= htmlspecialchars($nome_utente) ?></span>
        <a href="logout.php" class="logout-link"><i class="fa-solid fa-power-off"></i> Esci</a>
    </div>
</nav>

<div class="container">
    <div class="welcome-header">
        <h1 class="page-title">Centro Operativo</h1>
        <p class="page-subtitle">Gestisci le squadre, i giocatori e gli allenamenti da un unico pannello.</p>
    </div>

    <div class="kpi-grid">
        <div class="kpi-card"><h3>Squadre Attive</h3><div class="value"><?= $tot_squadre ?></div></div>
        <div class="kpi-card"><h3>Tesserati</h3><div class="value"><?= $tot_giocatori ?></div></div>
        <div class="kpi-card <?= $scadenza_doc > 0 ? 'alert' : '' ?>"><h3>Doc. in Scadenza</h3><div class="value"><?= $scadenza_doc ?></div></div>
        <div class="kpi-card"><h3>Sessioni Oggi</h3><div class="value"><?= $allenamenti_oggi ?></div></div>
        <div class="kpi-card <?= $notifiche > 0 ? 'alert' : '' ?>"><h3>Notifiche</h3><div class="value"><?= $notifiche ?></div></div>
    </div>

    <div class="modules-grid">

        <?php if($ruolo == 'Amministratore' || $ruolo == 'Allenatore'): ?>
        <div class="module">
            <div class="module-header">
                <div><i class="fa-solid fa-building-user"></i> Gestione Società</div>
                <span class="rf-badge">RF1 • RF3</span>
            </div>
            <div class="module-body">
                <div class="module-desc">Crea nuove formazioni, assegna le categorie e gestisci il team tecnico.</div>
                <div class="action-list">
                    <a href="form_squadra.php" class="btn btn-primary">Nuova Squadra <i class="fa-solid fa-plus"></i></a>
                    <a href="gestione_squadre.php" class="btn btn-outline">Elenco Squadre <i class="fa-solid fa-list"></i></a>
                    <a href="gestione_staff.php" class="btn btn-outline">Anagrafica Mister <i class="fa-solid fa-whistle"></i></a>
                    <?php if($ruolo == 'Amministratore'): ?>
                        <a href="gestione_utenti.php" class="btn btn-outline">Permessi e Ruoli <i class="fa-solid fa-lock"></i></a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <?php if($ruolo == 'Amministratore' || $ruolo == 'Allenatore'): ?>
        <div class="module">
            <div class="module-header">
                <div><i class="fa-solid fa-id-card-clip"></i> Segreteria Sportiva</div>
                <span class="rf-badge">RF2 • RF8</span>
            </div>
            <div class="module-body">
                <div class="module-desc">Inserimento nuovi atleti con dati fisici e gestione dei certificati medici.</div>
                <div class="action-list">
                    <a href="form_giocatore.php" class="btn btn-primary">Nuovo Atleta <i class="fa-solid fa-user-plus"></i></a>
                    <a href="gestione_giocatori.php" class="btn btn-outline">Roster Giocatori <i class="fa-solid fa-users"></i></a>
                    <a href="documenti.php" class="btn btn-outline">Sistema Documentale <i class="fa-solid fa-file-medical"></i></a>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <?php if($ruolo == 'Amministratore' || $ruolo == 'Allenatore'): ?>
        <div class="module">
            <div class="module-header">
                <div><i class="fa-solid fa-futbol"></i> Programmazione</div>
                <span class="rf-badge">RF4 • RF5</span>
            </div>
            <div class="module-body">
                <div class="module-desc">Pianifica le sedute di allenamento sui campi disponibili senza accavallamenti.</div>
                <div class="action-list">
                    <a href="pianifica_allenamento.php" class="btn btn-primary">Pianifica Sessione <i class="fa-solid fa-stopwatch"></i></a>
                    <a href="calendario_squadra.php" class="btn btn-outline">Calendario Squadra <i class="fa-solid fa-calendar-days"></i></a>
                    <?php if($ruolo == 'Amministratore'): ?>
                        <a href="gestione_campi.php" class="btn btn-outline" style="border-color: rgba(255, 184, 0, 0.4); color: #ffb800;">Gestione Strutture <i class="fa-solid fa-wrench"></i></a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <div class="module">
            <div class="module-header">
                <div><i class="fa-solid fa-magnifying-glass"></i> Database & Ricerca</div>
                <span class="rf-badge">RF7.4 • RF9</span>
            </div>
            <div class="module-body">
                <div class="module-desc">Consultazione dei dati in sola lettura. Ricerca atleti per CF e planning campi.</div>
                <div class="action-list">
                    <a href="ricerca_giocatori.php" class="btn btn-viewer">Ricerca Giocatori <i class="fa-solid fa-search"></i></a>
                    <a href="ricerca_squadre.php" class="btn btn-viewer">Filtro Squadre/Cat. <i class="fa-solid fa-filter"></i></a>
                    <a href="visualizza_campi.php" class="btn btn-viewer">Planning Strutture <i class="fa-solid fa-map"></i></a>
                </div>
                
                <?php if($ruolo == 'Visualizzatore'): ?>
                    <div style="margin-top:1.5rem; font-size:0.75rem; color:var(--accent-danger); text-align:center; padding: 10px; background: rgba(255,0,85,0.1); border-radius: 8px;">
                        <i class="fa-solid fa-lock"></i> Account abilitato alla sola consultazione (RF7.4)
                    </div>
                <?php endif; ?>
            </div>
        </div>

    </div>
</div>

</body>
</html>
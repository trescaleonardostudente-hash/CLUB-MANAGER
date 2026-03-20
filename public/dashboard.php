<?php
session_start();
require "connessione.php"; // Assicurati che contenga $mysql

if (!isset($_SESSION['user_id']) || !isset($_SESSION['auth_user'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// 1. Recupero Info Utente e Ruolo
$query_user = "SELECT u.nome, r.nome AS nome_ruolo, u.ruolo_id 
               FROM utenti u 
               JOIN ruoli r ON u.ruolo_id = r.id 
               WHERE u.id = ?";
$stmt = $mysql->prepare($query_user);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user_info = $stmt->get_result()->fetch_assoc();

$nome_utente = $user_info['nome'] ?? 'Utente';
$ruolo = $user_info['nome_ruolo'] ?? 'Visualizzatore';
$ruolo_id = $user_info['ruolo_id'];

// 2. Query Statistiche (Dati reali dal tuo DB)
$tot_giocatori = $mysql->query("SELECT COUNT(*) as tot FROM giocatori WHERE attivo = 1")->fetch_assoc()['tot'];
$tot_allenamenti = $mysql->query("SELECT COUNT(*) as tot FROM allenamenti WHERE data >= CURDATE()")->fetch_assoc()['tot'];
$scadenza_doc = $mysql->query("SELECT COUNT(*) as tot FROM documenti WHERE data_scadenza < DATE_ADD(CURDATE(), INTERVAL 30 DAY)")->fetch_assoc()['tot'];
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Club Manager - Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root { --primary: #2e7d32; --secondary: #1b5e20; --dark: #0a0a0a; --card-bg: #1a1a1a; --text: #e0e0e0; }
        body { background-color: var(--dark); color: var(--text); font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 0; }
        
        /* Navbar */
        .navbar { background: #000; padding: 15px 5%; display: flex; justify-content: space-between; align-items: center; border-bottom: 3px solid var(--primary); }
        .brand { font-size: 1.5rem; font-weight: bold; color: #4caf50; letter-spacing: 1px; }
        .user-info { display: flex; align-items: center; gap: 15px; }
        .role-badge { background: var(--primary); color: white; padding: 4px 12px; border-radius: 20px; font-size: 0.8rem; text-transform: uppercase; }

        /* Main Layout */
        .main-container { padding: 30px 5%; max-width: 1400px; margin: 0 auto; }
        
        /* Stat Cards */
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 40px; }
        .stat-card { background: var(--card-bg); padding: 20px; border-radius: 10px; text-align: center; border: 1px solid #333; }
        .stat-card h2 { color: var(--primary); margin: 5px 0; font-size: 2rem; }
        .stat-card p { margin: 0; color: #888; text-transform: uppercase; font-size: 0.75rem; }

        /* Action Grid */
        .action-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 25px; }
        .card { background: var(--card-bg); border-radius: 15px; overflow: hidden; transition: 0.3s; border: 1px solid #222; }
        .card:hover { transform: translateY(-5px); border-color: var(--primary); }
        .card-header { background: rgba(46, 125, 50, 0.1); padding: 20px; border-bottom: 1px solid #222; display: flex; align-items: center; gap: 15px; }
        .card-header i { font-size: 1.5rem; color: var(--primary); }
        .card-body { padding: 20px; }
        .card-body p { font-size: 0.9rem; color: #bbb; line-height: 1.5; }
        
        .btn { display: block; width: 100%; padding: 12px; margin-top: 15px; background: var(--primary); color: white; text-align: center; text-decoration: none; border-radius: 8px; font-weight: bold; transition: 0.2s; }
        .btn:hover { background: var(--secondary); }
        
        .alert-dot { height: 10px; width: 10px; background-color: #f44336; border-radius: 50%; display: inline-block; margin-right: 5px; }
    </style>
</head>
<body>

    <nav class="navbar">
        <div class="brand"><i class="fas fa-futbol"></i> CLUB MANAGER</div>
        <div class="user-info">
            <span class="role-badge"><?php echo $ruolo; ?></span>
            <span><strong><?php echo htmlspecialchars($nome_utente); ?></strong></span>
            <a href="logout.php" style="color: #f44336; text-decoration: none;"><i class="fas fa-power-off"></i></a>
        </div>
    </nav>

    <div class="main-container">
        
        <div class="stats-grid">
            <div class="stat-card">
                <p>Atleti Attivi</p>
                <h2><?php echo $tot_giocatori; ?></h2>
            </div>
            <div class="stat-card">
                <p>Prossimi Allenamenti</p>
                <h2><?php echo $tot_allenamenti; ?></h2>
            </div>
            <div class="stat-card">
                <p>Doc. in Scadenza</p>
                <h2 style="color: #ffa000;"><?php echo $scadenza_doc; ?></h2>
            </div>
            <div class="stat-card">
                <p>Status Token</p>
                <h2 style="font-size: 1rem; color: #4caf50;">ATTIVO (10m)</h2>
            </div>
        </div>

        <div class="action-grid">

            <?php if ($ruolo == 'Amministratore'): ?>
            <div class="card">
                <div class="card-header"><i class="fas fa-address-book"></i> <h3>Gestione Società</h3></div>
                <div class="card-body">
                    <p>Accesso completo all'anagrafica atleti e documenti. Puoi gestire le quote e i refresh token degli utenti.</p>
                    <a href="gestione_giocatori.php" class="btn">Lista Giocatori</a>
                    <a href="documenti.php" class="btn">Verifica Scadenze</a>
                </div>
            </div>
            <?php endif; ?>

            <?php if ($ruolo == 'Amministratore' || $ruolo == 'Allenatore'): ?>
            <div class="card">
                <div class="card-header"><i class="fas fa-whistle"></i> <h3>Area Tecnica</h3></div>
                <div class="card-body">
                    <p>Pianifica sessioni su <strong>Campi</strong> disponibili e convoca le <strong>Squadre</strong> per categoria.</p>
                    <a href="pianifica_allenamento.php" class="btn">Nuovo Allenamento</a>
                    <a href="categorie.php" class="btn">Gestione Categorie</a>
                </div>
            </div>
            <?php endif; ?>

            <div class="card">
                <div class="card-header"><i class="fas fa-calendar-alt"></i> <h3>Calendario & Campi</h3></div>
                <div class="card-body">
                    <p>Visualizza la disponibilità dei campi sportivi e le notifiche di sistema inviate dalla segreteria.</p>
                    <a href="visualizza_campi.php" class="btn">Stato Campi</a>
                    <a href="notifiche.php" class="btn">Notifiche (<?php echo $mysql->query("SELECT COUNT(*) FROM notifiche WHERE letto=0")->fetch_assoc()['COUNT(*)']; ?>)</a>
                </div>
            </div>

        </div>
    </div>

</body>
</html>
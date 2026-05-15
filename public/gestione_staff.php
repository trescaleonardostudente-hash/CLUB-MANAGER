<?php
// ABILITAZIONE ERRORI: Forza PHP a mostrare il problema invece della pagina 500
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require "connessione.php";

if (!isset($_SESSION['user_id'])) { 
    header("Location: login.php"); 
    exit; 
}

$user_id = (int)$_SESSION['user_id'];

// 1. Controllo Sicurezza con blocco Anti-Crash
$query_admin = "SELECT ruolo_id FROM utenti WHERE id = $user_id";
$res_admin = $mysql->query($query_admin);

if (!$res_admin) {
    die("<h2 style='color:red;'>Errore Query Admin: " . $mysql->error . "</h2>");
}

$u_info = $res_admin->fetch_assoc();
if (!$u_info || $u_info['ruolo_id'] != 1) {
    header("Location: dashboard.php");
    exit;
}

// 2. Aggiornamento del Ruolo nel Database
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_role'])) {
    $target_user_id = (int)$_POST['target_user_id'];
    $nuovo_ruolo_id = (int)$_POST['nuovo_ruolo_id'];

    $ruoli_validi = [1, 2, 3];
    if (in_array($nuovo_ruolo_id, $ruoli_validi)) {
        $stmt = $mysql->prepare("UPDATE utenti SET ruolo_id = ? WHERE id = ?");
        if (!$stmt) {
            die("<h2 style='color:red;'>Errore Prepare Update: " . $mysql->error . "</h2>");
        }
        
        $stmt->bind_param("ii", $nuovo_ruolo_id, $target_user_id);
        
        if (!$stmt->execute()) {
            die("<h2 style='color:red;'>Errore Esecuzione Update: " . $stmt->error . "</h2>");
        }
        $stmt->close();
        
        header("Location: gestione_staff.php");
        exit;
    }
}

// 3. Estrazione Utenti
// Uso u.* così se ti mancano le colonne email o telefono il sistema non va in crash
$query_utenti = "
    SELECT u.*, r.nome AS ruolo_testo 
    FROM utenti u 
    LEFT JOIN ruoli r ON u.ruolo_id = r.id 
    ORDER BY u.ruolo_id ASC, u.nome ASC
";
$result = $mysql->query($query_utenti);

if (!$result) {
    die("<h2 style='color:red;'>Errore Query Lista Utenti: " . $mysql->error . "</h2>");
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Gestione Staff e Ruoli</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style> 
        :root { --primary: #00ff87; --bg: #040805; --card: rgba(12, 24, 16, 0.7); }
        body { background: var(--bg); color: white; font-family: 'Montserrat', sans-serif; padding: 40px; margin: 0; background: radial-gradient(circle at top right, #0d2e1a, var(--bg) 80%); min-height: 100vh;} 
        .container { background: var(--card); padding: 30px; border-radius: 15px; border: 1px solid rgba(255,255,255,0.1); max-width: 1000px; margin: 0 auto; backdrop-filter: blur(10px); } 
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; } 
        th, td { padding: 15px; text-align: left; border-bottom: 1px solid rgba(255,255,255,0.1); } 
        th { color: var(--primary); text-transform: uppercase; font-size: 0.9em; } 
        .badge { background: var(--primary); color: #000; padding: 4px 10px; border-radius: 10px; font-weight: 900; font-size: 0.75rem; text-transform: uppercase; }
        .badge.admin { background: #ff0055; color: white;}
        .badge.visualizzatore { background: #555; color: white;}
        .btn-update { background: var(--primary); color: #040805; border: none; padding: 8px 15px; border-radius: 5px; font-weight: bold; cursor: pointer; transition: 0.3s; }
        .btn-update:hover { background: #00cc6a; }
        select { padding: 8px; border-radius: 5px; border: 1px solid rgba(255,255,255,0.2); background: rgba(0,0,0,0.5); color: white; font-family: 'Montserrat'; outline: none; }
        option { background: #040805; color: white; }
        .role-form { display: flex; gap: 10px; align-items: center; margin: 0; }
        .back-btn { color: white; text-decoration: none; border: 1px solid rgba(255,255,255,0.2); padding: 10px 20px; border-radius: 8px; display: inline-block; font-weight: bold; transition: 0.3s; }
        .back-btn:hover { background: rgba(255,255,255,0.1); }
    </style>
</head>
<body>
    <div class="container">
        <h2><i class="fa-solid fa-whistle" style="color:#00ff87;"></i> GESTIONE STAFF E RUOLI (RF3)</h2>
        <p style="color: #aaa; font-size: 0.9em; margin-bottom: 20px;">Da questa pagina puoi assegnare il ruolo di Allenatore o Admin agli utenti registrati.</p>
        
        <table>
            <thead>
                <tr>
                    <th>Utente</th>
                    <th>Contatti</th>
                    <th>Ruolo Attuale</th>
                    <th>Assegna Nuovo Ruolo</th>
                </tr>
            </thead>
            <tbody>
                <?php if($result && $result->num_rows > 0): while($row = $result->fetch_assoc()): 
                    $badge_class = 'badge';
                    if(isset($row['ruolo_id'])) {
                        if($row['ruolo_id'] == 1) $badge_class .= ' admin';
                        if($row['ruolo_id'] == 3) $badge_class .= ' visualizzatore';
                    }
                ?>
                <tr>
                    <td>
                        <strong><?= htmlspecialchars($row['nome'] ?? 'Utente') ?> <?= htmlspecialchars($row['cognome'] ?? '') ?></strong>
                    </td>
                    <td>
                        <small style="color:#aaa;">Email: <?= htmlspecialchars($row['email'] ?? 'N/D') ?></small><br>
                        <small style="color:#aaa;">Tel: <?= htmlspecialchars($row['telefono'] ?? 'N/D') ?></small>
                    </td>
                    <td>
                        <span class="<?= $badge_class ?>">
                            <?= htmlspecialchars($row['ruolo_testo'] ?? 'Sconosciuto') ?>
                        </span>
                    </td>
                    <td>
                        <form method="POST" action="" class="role-form">
                            <!-- Assicuriamoci che l'ID utente esista -->
                            <input type="hidden" name="target_user_id" value="<?= $row['id'] ?? 0 ?>">
                            <select name="nuovo_ruolo_id" required>
                                <option value="3" <?= (isset($row['ruolo_id']) && $row['ruolo_id'] == 3) ? 'selected' : '' ?>>Visualizzatore</option>
                                <option value="2" <?= (isset($row['ruolo_id']) && $row['ruolo_id'] == 2) ? 'selected' : '' ?>>Allenatore</option>
                                <option value="1" <?= (isset($row['ruolo_id']) && $row['ruolo_id'] == 1) ? 'selected' : '' ?>>Amministratore</option>
                            </select>
                            <button type="submit" name="update_role" class="btn-update">Applica</button>
                        </form>
                    </td>
                </tr>
                <?php endwhile; else: ?>
                <tr><td colspan="4" style="text-align: center; padding: 20px;">Nessun utente trovato.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
        
        <br>
        <a href="dashboard.php" class="back-btn"><i class="fa-solid fa-arrow-left"></i> Torna alla Dashboard</a>
    </div>
</body>
</html>
<?php
session_start();
require "connessione.php";

if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit; }

$query = "SELECT * FROM giocatori ORDER BY cognome ASC";
$risultato = $pdo->query($query); // Usiamo $pdo->query()
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestione Atleti - Club Manager</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root { 
            --primary: #2e7d32; 
            --accent: #4caf50;
            --dark-bg: #0a0a0a; 
            --card-bg: #161616; 
            --text: #e0e0e0; 
            --border: #2a2a2a;
        }

        body { 
            background-color: var(--dark-bg); 
            color: var(--text); 
            font-family: 'Inter', system-ui, -apple-system, sans-serif; 
            margin: 0; padding: 20px;
        }

        .container { max-width: 1200px; margin: 0 auto; }

        /* Header e Bottoni */
        .header-section { 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            margin-bottom: 30px; 
            border-bottom: 1px solid var(--border);
            padding-bottom: 20px;
        }

        .btn {
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: 0.3s;
        }

        .btn-add { background: var(--primary); color: white; }
        .btn-add:hover { background: var(--accent); transform: translateY(-2px); }
        .btn-back { color: #888; }
        .btn-back:hover { color: white; }

        /* Messaggi di Successo */
        .alert {
            background: rgba(46, 125, 50, 0.2);
            border: 1px solid var(--primary);
            color: var(--accent);
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            animation: slideIn 0.5s ease-out;
        }

        /* Tabella Stilizzata */
        .table-container {
            background: var(--card-bg);
            border-radius: 15px;
            overflow: hidden;
            border: 1px solid var(--border);
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
        }

        table { width: 100%; border-collapse: collapse; }
        
        th { 
            background: #1f1f1f; 
            padding: 15px; 
            text-align: left; 
            font-size: 0.85rem; 
            text-transform: uppercase; 
            color: #888;
            letter-spacing: 1px;
        }

        td { padding: 15px; border-bottom: 1px solid var(--border); }
        tr:last-child td { border-bottom: none; }
        tr:hover { background: rgba(255,255,255,0.02); }

        /* Badge Ruolo e Icone */
        .role-tag {
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: bold;
            background: #333;
        }
        .Portiere { color: #ff9800; background: rgba(255, 152, 0, 0.1); }
        .Difensore { color: #2196f3; background: rgba(33, 150, 243, 0.1); }
        .Centrocampista { color: #4caf50; background: rgba(76, 175, 80, 0.1); }
        .Attaccante { color: #f44336; background: rgba(244, 67, 54, 0.1); }

        .jersey-circle {
            width: 30px; height: 30px;
            background: #2e7d32;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 0.8rem;
        }

        .actions a {
            color: #888;
            transition: 0.2s;
            font-size: 1.1rem;
        }
        .actions a:hover { color: var(--accent); }

        @keyframes slideIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header-section">
        <div>
            <a href="dashboard.php" class="btn btn-back"><i class="fas fa-chevron-left"></i> Dashboard</a>
            <h1 style="margin: 10px 0 0 0;">Anagrafica Atleti</h1>
        </div>
        <a href="form_giocatore.php" class="btn btn-add">
            <i class="fas fa-plus-circle"></i> Nuovo Atleta
        </a>
    </div>

    <?php if (isset($_GET['msg']) && $_GET['msg'] == 'successo'): ?>
        <div class="alert">
            <i class="fas fa-check-circle"></i>
            Database aggiornato con successo!
        </div>
    <?php endif; ?>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Atleta</th>
                    <th>Anno</th>
                    <th>Ruolo</th>
                    <th>Maglia</th>
                    <th>Visita Medica</th>
                    <th style="text-align: center;">Azioni</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $risultato->fetch()): // Sostituito fetch_assoc() con fetch() ?>
                <?php
                    // Logica colore visita
                    $oggi = new DateTime();
                    $scadenza = new DateTime($row['scadenza_visita']);
                    $diff = $oggi->diff($scadenza);
                    $days = (int)$diff->format("%r%a");
                    $status_color = ($days < 0) ? '#f44336' : (($days < 30) ? '#ffa000' : '#4caf50');
                ?>
                <tr>
                    <td>
                        <div style="font-weight: 600;"><?php echo htmlspecialchars($row['cognome'] . " " . $row['nome']); ?></div>
                        <div style="font-size: 0.75rem; color: #666;"><?php echo $row['codice_fiscale']; ?></div>
                    </td>
                    <td><?php echo $row['anno_nascita']; ?></td>
                    <td>
                        <span class="role-tag <?php echo $row['ruolo']; ?>">
                            <?php echo $row['ruolo'] ?: 'Non assegnato'; ?>
                        </span>
                    </td>
                    <td>
                        <div class="jersey-circle"><?php echo $row['numero_maglia'] ?: '-'; ?></div>
                    </td>
                    <td>
                        <i class="fas fa-calendar-day" style="color: <?php echo $status_color; ?>;"></i>
                        <span style="font-size: 0.9rem; margin-left: 5px;">
                            <?php echo date('d/m/Y', strtotime($row['scadenza_visita'])); ?>
                        </span>
                    </td>
                    <td class="actions" style="text-align: center;">
                        <a href="form_giocatore.php?id=<?php echo $row['id']; ?>" title="Modifica">
                            <i class="fas fa-edit"></i>
                        </a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
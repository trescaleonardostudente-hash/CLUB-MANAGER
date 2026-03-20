<?php
session_start();
require "connessione.php";

$g = [ 'id'=>'','nome'=>'','cognome'=>'','anno_nascita'=>'','ruolo'=>'','numero_maglia'=>'','codice_fiscale'=>'','contatto_genitore'=>'','scadenza_visita'=>'','piede_preferito'=>'','attivo'=>1 ];

if (isset($_GET['id'])) {
    $stmt = $mysql->prepare("SELECT * FROM giocatori WHERE id = ?");
    $stmt->bind_param("i", $_GET['id']);
    $stmt->execute();
    $g = $stmt->get_result()->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Gestione Atleta</title>
    <style>
        body { background: #0a0a0a; color: white; font-family: sans-serif; padding: 40px; }
        .form-container { max-width: 600px; margin: auto; background: #1a1a1a; padding: 25px; border-radius: 15px; border: 1px solid #2e7d32; }
        input, select { width: 100%; padding: 10px; margin: 10px 0; background: #333; border: 1px solid #444; color: white; border-radius: 5px; box-sizing: border-box; }
        .btn-save { background: #2e7d32; color: white; border: none; padding: 15px; width: 100%; cursor: pointer; font-weight: bold; border-radius: 5px; }
        label { font-size: 0.8rem; color: #888; }
    </style>
</head>
<body>
    <div class="form-container">
        <h2><?php echo $g['id'] ? 'Modifica Atleta' : 'Nuovo Atleta'; ?></h2>
        <form action="salva_giocatore.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $g['id']; ?>">
            
            <label>Nome</label>
            <input type="text" name="nome" value="<?php echo $g['nome']; ?>" required>
            
            <label>Cognome</label>
            <input type="text" name="cognome" value="<?php echo $g['cognome']; ?>" required>
            
            <div style="display:flex; gap:10px;">
                <div style="flex:1"><label>Anno Nascita</label><input type="number" name="anno_nascita" value="<?php echo $g['anno_nascita']; ?>" placeholder="YYYY"></div>
                <div style="flex:1"><label>N. Maglia</label><input type="number" name="numero_maglia" value="<?php echo $g['numero_maglia']; ?>"></div>
            </div>

            <label>Codice Fiscale</label>
            <input type="text" name="codice_fiscale" value="<?php echo $g['codice_fiscale']; ?>" maxlength="16">

            <label>Ruolo</label>
            <select name="ruolo">
                <option value="Portiere" <?php if($g['ruolo']=='Portiere') echo 'selected'; ?>>Portiere</option>
                <option value="Difensore" <?php if($g['ruolo']=='Difensore') echo 'selected'; ?>>Difensore</option>
                <option value="Centrocampista" <?php if($g['ruolo']=='Centrocampista') echo 'selected'; ?>>Centrocampista</option>
                <option value="Attaccante" <?php if($g['ruolo']=='Attaccante') echo 'selected'; ?>>Attaccante</option>
            </select>

            <label>Scadenza Visita Medica</label>
            <input type="date" name="scadenza_visita" value="<?php echo $g['scadenza_visita']; ?>">

            <label>Contatto Genitore (Telefono/Email)</label>
            <input type="text" name="contatto_genitore" value="<?php echo $g['contatto_genitore']; ?>">

            <label>Piede Preferito</label>
            <select name="piede_preferito">
                <option value="Destro" <?php echo ($g['piede_preferito']=='Destro')?'selected':''; ?>>Destro</option>
                <option value="Sinistro" <?php echo ($g['piede_preferito']=='Sinistro')?'selected':''; ?>>Sinistro</option>
                <option value="Ambidestro" <?php echo ($g['piede_preferito']=='Ambidestro')?'selected':''; ?>>Ambidestro</option>
            </select>

            <button type="submit" class="btn-save">SALVA ATLETA</button>
        </form>
    </div>
</body>
</html>
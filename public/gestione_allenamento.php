<?php
session_start();
require "connessione.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);

/* struttura allenamento */
$a = [
    'id' => '',
    'squadra_id' => '',
    'campo_id' => '',
    'data' => '',
    'ora_inizio' => '',
    'ora_fine' => '',
    'ricorrente' => 0
];

/* modifica */
if (isset($_GET['id'])) {
    $stmt = $pdo->prepare("SELECT * FROM allenamenti WHERE id = ?");
    $stmt->execute([$_GET['id']]);
    $result = $stmt->fetch();
    if ($result) {
        $a = $result;
    }
}

/* categorie */
$categorie = $pdo->query("SELECT * FROM categorie ORDER BY nome");

/* squadre */
$squadre = $pdo->query("
    SELECT s.id, s.nome, c.nome AS categoria
    FROM squadre s
    JOIN categorie c ON c.id = s.categoria_id
    ORDER BY c.nome, s.nome
");

/* campi */
$campi = $pdo->query("SELECT * FROM campi ORDER BY nome");
?>
<!DOCTYPE html>
<html lang="it">
<head>
<meta charset="UTF-8">
<title>Gestione Allenamento</title>
<style>
body { background:#0a0a0a; color:white; font-family:sans-serif; padding:40px; }
.form-container { max-width:600px; margin:auto; background:#1a1a1a; padding:25px; border-radius:15px; border:1px solid #2e7d32; }
input, select { width:100%; padding:10px; margin:10px 0; background:#333; border:1px solid #444; color:white; border-radius:5px; }
label { font-size:0.8rem; color:#888; }
.btn-save { background:#2e7d32; color:white; border:none; padding:15px; width:100%; font-weight:bold; border-radius:5px; cursor:pointer; }
</style>
</head>

<body>
<div class="form-container">
<h2><?= $a['id'] ? 'Modifica Allenamento' : 'Nuovo Allenamento' ?></h2>

<form action="salva_allenamento.php" method="POST">
<input type="hidden" name="id" value="<?= htmlspecialchars($a['id']) ?>">

<label>Squadra</label>
<select name="squadra_id" required>
<option value="">-- seleziona squadra --</option>
<?php while($s = $squadre->fetch()): ?>
<option value="<?= $s['id'] ?>" <?= $a['squadra_id']==$s['id']?'selected':'' ?>>
<?= htmlspecialchars($s['categoria']) ?> - <?= htmlspecialchars($s['nome']) ?>
</option>
<?php endwhile; ?>
</select>

<label>Campo</label>
<select name="campo_id" required>
<option value="">-- seleziona campo --</option>
<?php while($c = $campi->fetch()): ?>
<option value="<?= $c['id'] ?>" <?= $a['campo_id']==$c['id']?'selected':'' ?>>
<?= htmlspecialchars($c['nome']) ?> (<?= htmlspecialchars($c['tipologia']) ?>)
</option>
<?php endwhile; ?>
</select>

<div style="display:flex; gap:10px;">
<div style="flex:1">
<label>Data</label>
<input type="date" name="data" value="<?= htmlspecialchars($a['data']) ?>" required>
</div>
<div style="flex:1">
<label>Ora Inizio</label>
<input type="time" name="ora_inizio" value="<?= htmlspecialchars($a['ora_inizio']) ?>" required>
</div>
</div>

<label>Ora Fine</label>
<input type="time" name="ora_fine" value="<?= htmlspecialchars($a['ora_fine']) ?>" required>

<label>
<input type="checkbox" name="ricorrente" value="1" <?= $a['ricorrente']?'checked':'' ?>>
 Allenamento ricorrente
</label>

<button class="btn-save">SALVA ALLENAMENTO</button>
</form>
</div>
</body>
</html>
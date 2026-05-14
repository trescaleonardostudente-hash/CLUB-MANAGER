<?php
require "auth.php";
require "connessione.php";

$notifiche = $pdo->query("SELECT * FROM notifiche ORDER BY id DESC")->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
<title>Notifiche</title>
<style>
body{background:#0b0f14;color:white;font-family:Arial;padding:40px}
.card{background:#111;padding:12px;margin:10px;border-left:3px solid orange}
</style>
</head>
<body>

<h2>🔔 Notifiche</h2>

<?php foreach($notifiche as $n): ?>
<div class="card">
<?= $n['testo'] ?>
</div>
<?php endforeach; ?>

</body>
</html>
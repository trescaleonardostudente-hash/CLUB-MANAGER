<?php
// 1. Attiviamo il debug per vedere cosa succede
ini_set('display_errors', 1);
error_reporting(E_ALL);

// 2. Includiamo la connessione
require "connessione.php";

$msg = "";

// 3. Logica di registrazione
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome  = $_POST["nome"] ?? "";
    $email = $_POST["email"] ?? "";
    $pass  = $_POST["password"] ?? "";
    $ruolo_id = 3; 

    if (!empty($nome) && !empty($email) && !empty($pass)) {
        $password_hash = password_hash($pass, PASSWORD_BCRYPT);

        // Controllo email
        $check = $mysql->prepare("SELECT id FROM utenti WHERE email = ?");
        $check->bind_param("s", $email);
        $check->execute();
        
        if ($check->get_result()->num_rows > 0) {
            $msg = "Email già registrata!";
        } else {
            $sql = "INSERT INTO utenti (nome, email, password, ruolo_id) VALUES (?, ?, ?, ?)";
            $stmt = $mysql->prepare($sql);
            if ($stmt) {
                $stmt->bind_param("sssi", $nome, $email, $password_hash, $ruolo_id);
                if ($stmt->execute()) {
                    header("Location: login.php?success=1");
                    exit();
                } else {
                    $msg = "Errore database: " . $stmt->error;
                }
            } else {
                $msg = "Errore query: " . $mysql->error;
            }
        }
    } else {
        $msg = "Riempi tutti i campi!";
    }
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Registrazione Club</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0; font-family: sans-serif;
            background: linear-gradient(rgba(0,0,0,0.8), rgba(0,0,0,0.8)), 
                        url('https://images.unsplash.com/photo-1574629810360-7efbbe195018?q=80&w=2000');
            background-size: cover; background-position: center;
            display: flex; justify-content: center; align-items: center; min-height: 100vh;
        }
        .register-card {
            background: rgba(30, 30, 30, 0.95); padding: 40px; border-radius: 20px;
            width: 350px; border: 1px solid #2e7d32; text-align: center; color: white;
            box-shadow: 0 10px 25px rgba(0,0,0,0.5);
        }
        h2 { text-transform: uppercase; letter-spacing: 2px; color: #fff; }
        input {
            width: 100%; padding: 12px; margin: 10px 0; border-radius: 8px;
            border: 1px solid #444; background: #222; color: white; box-sizing: border-box;
        }
        button {
            width: 100%; padding: 12px; background: #2e7d32; border: none;
            color: white; font-weight: bold; border-radius: 8px; cursor: pointer; margin-top: 10px;
        }
        button:hover { background: #1b5e20; }
        .error-box { background: rgba(255,0,0,0.2); padding: 10px; border-radius: 5px; color: #ff8a8a; margin-bottom: 10px; }
    </style>
</head>
<body>

    <div class="register-card">
        <i class="fas fa-futbol fa-3x" style="color: #2e7d32; margin-bottom: 10px;"></i>
        <h2>Registrati</h2>
        
        <?php if($msg): ?>
            <div class="error-box"><?php echo $msg; ?></div>
        <?php endif; ?>

        <form method="POST">
            <input type="text" name="nome" placeholder="Nome Completo" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Crea Account</button>
        </form>
        <p><a href="login.php" style="color: #2e7d32; text-decoration: none; font-size: 0.9rem;">Hai già un account? Accedi</a></p>
    </div>

</body>
</html>
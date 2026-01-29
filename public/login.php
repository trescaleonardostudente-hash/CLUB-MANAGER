<?php
session_start();
require "connessione.php";

$error = "";

// Se l'utente è già loggato e ha un token, lo mandiamo in dashboard
if (isset($_SESSION['auth_user'])) {
    header("Location: dashboard.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"] ?? "";
    $password = $_POST["password"] ?? "";

    $stmt = $mysql->prepare("SELECT id, password FROM utenti WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $utente = $result->fetch_assoc();
        // Verifica la password hashata (creata in registrazione.php)
        if (password_verify($password, $utente["password"])) {
            $_SESSION["user_id"] = $utente["id"];
            header("Location: generatoken.php");
            exit;
        } else { 
            $error = "❌ Password errata. Riprova il tiro!"; 
        }
    } else { 
        $error = "⚠️ Account non trovato. Devi prima firmare il contratto."; 
    }
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Club Manager</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body { 
            margin: 0; 
            font-family: 'Segoe UI', sans-serif; 
            background: linear-gradient(rgba(0,0,0,0.8), rgba(0,0,0,0.8)), 
                        url('https://images.unsplash.com/photo-1574629810360-7efbbe195018?q=80&w=2000'); 
            background-size: cover; 
            background-position: center;
            display: flex; 
            justify-content: center; 
            align-items: center; 
            height: 100vh; 
            color: white; 
        }
        .card { 
            background: rgba(20, 20, 20, 0.95); 
            padding: 40px; 
            border-radius: 15px; 
            border: 2px solid #2e7d32; 
            text-align: center; 
            width: 350px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
        }
        .logo-icon { color: #2e7d32; font-size: 50px; margin-bottom: 15px; }
        h2 { text-transform: uppercase; letter-spacing: 2px; margin-bottom: 25px; margin-top: 0; }
        input { 
            width: 100%; 
            padding: 12px; 
            margin: 10px 0; 
            border-radius: 8px; 
            border: 1px solid #333; 
            background: #222; 
            color: white; 
            box-sizing: border-box; 
        }
        button { 
            width: 100%; 
            padding: 14px; 
            background: #2e7d32; 
            color: white; 
            border: none; 
            border-radius: 8px; 
            cursor: pointer; 
            font-weight: bold; 
            text-transform: uppercase;
            transition: 0.3s;
            margin-top: 10px;
        }
        button:hover { background: #1b5e20; transform: translateY(-2px); }
        .alert { 
            background: rgba(255, 82, 82, 0.2); 
            color: #ff8a8a; 
            padding: 10px; 
            border-radius: 8px; 
            margin-bottom: 15px; 
            font-size: 0.9rem;
            border: 1px solid #ff5252;
        }
        .footer-link { margin-top: 25px; font-size: 0.9rem; color: #bbb; }
        .footer-link a { color: #2e7d32; text-decoration: none; font-weight: bold; }
        .footer-link a:hover { text-decoration: underline; }
    </style>
</head>
<body>

    <div class="card">
        <i class="fas fa-running logo-icon"></i>
        <h2>CLUBMANAGER</h2>

        <?php if($error): ?>
            <div class="alert"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Entra nello spogliatoio</button>
        </form>

        <div class="footer-link">
            Non hai ancora un account? <br>
            <a href="registrazione.php">Registrati ora!</a>
        </div>
    </div>

</body>
</html>
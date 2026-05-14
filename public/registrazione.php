<?php
session_start();
require "connessione.php";

$msg = "";
$status = ""; // 'error' o 'success'

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome  = trim($_POST["nome"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $pass  = $_POST["password"] ?? "";
    $ruolo_id = 3; // Default: Visualizzatore (Livello 3)

    if (!empty($nome) && !empty($email) && !empty($pass)) {
        
        try {
            // INIZIO TRANSAZIONE (RF7) - Protegge l'integrità dei dati
            $pdo->beginTransaction();

            // 1. Verifica se l'email esiste già
            $check = $pdo->prepare("SELECT id FROM utenti WHERE email = ?");
            $check->execute([$email]);
            
            if ($check->rowCount() > 0) {
                throw new Exception("Questa email è già associata a un account.");
            }

            // 2. Hash della password
            $password_hash = password_hash($pass, PASSWORD_BCRYPT);

            // 3. Inserimento Utente
            $sql = "INSERT INTO utenti (nome, email, password, ruolo_id) VALUES (?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$nome, $email, $password_hash, $ruolo_id]);

            // Se tutto è andato bene, confermiamo i dati nel DB
            $pdo->commit();
            
            header("Location: login.php?registered=1");
            exit();

        } catch (Exception $e) {
            // Se c'è un errore, annulliamo tutto (ROLLBACK)
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }
            $status = "error";
            $msg = $e->getMessage();
        }
    } else {
        $status = "error";
        $msg = "Per favore, compila tutti i campi richiesti.";
    }
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ClubManager - Registrazione</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --primary: #00ff87; --bg: #040805; --card: rgba(12, 24, 16, 0.9); --text: #fff; --danger: #ff0055; }
        
        body { 
            margin: 0; 
            font-family: 'Montserrat', sans-serif; 
            background: radial-gradient(circle at center, #0d2e1a, var(--bg)); 
            color: var(--text); 
            display: flex; 
            justify-content: center; 
            align-items: center; 
            min-height: 100vh;
        }

        .register-container {
            background: var(--card);
            padding: 40px;
            border-radius: 20px;
            width: 100%;
            max-width: 400px;
            border: 1px solid rgba(255,255,255,0.1);
            box-shadow: 0 20px 40px rgba(0,0,0,0.5);
            backdrop-filter: blur(10px);
        }

        .logo-area { text-align: center; margin-bottom: 30px; }
        .logo-area i { font-size: 3rem; color: var(--primary); margin-bottom: 10px; }
        .logo-area h2 { margin: 0; font-weight: 900; letter-spacing: -1px; text-transform: uppercase; }

        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; font-size: 0.8rem; font-weight: 700; color: #aaa; text-transform: uppercase; }
        
        input {
            width: 100%;
            padding: 14px;
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 8px;
            color: white;
            font-family: inherit;
            box-sizing: border-box;
            transition: 0.3s;
        }

        input:focus { outline: none; border-color: var(--primary); background: rgba(255,255,255,0.1); }

        .btn-register {
            width: 100%;
            padding: 16px;
            background: var(--primary);
            color: #000;
            border: none;
            border-radius: 8px;
            font-weight: 900;
            text-transform: uppercase;
            cursor: pointer;
            transition: 0.3s;
            margin-top: 10px;
        }

        .btn-register:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(0, 255, 135, 0.3); }

        .alert {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            text-align: center;
        }
        .alert-error { background: rgba(255,0,85,0.1); color: var(--danger); border: 1px solid var(--danger); }

        .footer-links { text-align: center; margin-top: 25px; font-size: 0.85rem; color: #aaa; }
        .footer-links a { color: var(--primary); text-decoration: none; font-weight: 700; }
    </style>
</head>
<body>

<div class="register-container">
    <div class="logo-area">
        <i class="fa-solid fa-shield-halved"></i>
        <h2>ClubManager</h2>
        <p style="font-size: 0.8rem; color: #aaa;">Crea il tuo profilo di accesso</p>
    </div>

    <?php if($msg): ?>
        <div class="alert alert-error">
            <i class="fa-solid fa-circle-exclamation"></i> <?php echo $msg; ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="registrazione.php">
        <div class="form-group">
            <label>Nome Completo</label>
            <input type="text" name="nome" placeholder="es. Mario Rossi" required>
        </div>

        <div class="form-group">
            <label>Indirizzo Email</label>
            <input type="email" name="email" placeholder="nome@esempio.it" required>
        </div>

        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" placeholder="••••••••" required>
        </div>

        <button type="submit" class="btn-register">Registrati ora</button>
    </form>

    <div class="footer-links">
        Hai già un account? <a href="login.php">Accedi qui</a>
    </div>
</div>

</body>
</html>
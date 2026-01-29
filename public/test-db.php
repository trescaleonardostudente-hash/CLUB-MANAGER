<?php
require "connessione.php";

if (isset($mysql)) {
    echo "✅ \$mysqli definito!";
} else {
    echo "❌ \$mysqli NON definito!";
}
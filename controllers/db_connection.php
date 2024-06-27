<?php
// db_connection.php

define('DB_SERVER', 'localhost'); // Remplace par ton serveur de base de données
define('DB_USERNAME', 'root'); // Remplace par ton nom d'utilisateur
define('DB_PASSWORD', ''); // Remplace par ton mot de passe
define('DB_NAME', 'eco_cook'); // Remplace par le nom de ta base de données

// Connexion à la base de données
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Vérifie la connexion
if ($conn->connect_error) {
    die("La connexion a échoué: " . $conn->connect_error);
}
?>

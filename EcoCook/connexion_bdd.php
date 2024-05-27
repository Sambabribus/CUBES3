<?php
$servername = "localhost";
$username = "root";
$password = ""; // Assure-toi que c'est le bon mot de passe
$dbname = "eco_cook";

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifie la connexion
if ($conn->connect_error) {
    die("Échec de la connexion: " . $conn->connect_error);
}
?>

<?php
// Démarre la session
session_start();

// Supposons que la vérification des identifiants est réussie
$_SESSION['user_id'] = $userId; // Ou tout autre identifiant unique à l'utilisateur
$_SESSION['logged_in'] = true; // Un indicateur pour vérifier si l'utilisateur est connecté

// Redirection vers la page d'accueil
header("Location: ..\views\main.php");
exit;
?>

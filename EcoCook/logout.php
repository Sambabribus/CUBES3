<?php
session_start(); // Accès à la session
session_unset(); // Supprimer toutes les variables de session
session_destroy(); // Détruire la session

header('Location: acceuil.php'); // Rediriger vers la page d'accueil
exit;
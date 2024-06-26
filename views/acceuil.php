<?php
session_start(); // Important pour accéder aux variables de session
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accueil - Partage de Recettes</title>
    <link rel="stylesheet"  href="css\style.css"> 
</head>
<body>
<header>
<div class="top-band">
    <div class="container">
        <nav>
            <img src="Image/EcoCook.png" class="logo">
            <ul>
                <li><a href="acceuil.php">Accueil</a></li>
                <li><a href="recettes.php">Recettes</a></li>
                <li><a href="a propos.php">A propos</a></li>
                <li><a href="contact.php">Contact</a></li>
                <?php if (isset($_SESSION['user'])): ?>
                    <li><a href="logout.php">Déconnexion</a></li>
                <?php else: ?>
                    <li><a href="inscription.php">Connexion / Inscription</a></li>
                <?php endif; ?>
            </ul>    
            <?php if (isset($_SESSION['user'])): ?>
            <div class="login">
                <div class="container">
                    <p>Bienvenue, <?php echo htmlspecialchars($_SESSION['user']); ?> !</p>
                </div>
            </div>
            <?php endif; ?>
        </nav>  
    </div>
    </div> 
</header>


<footer>
Copyright © Ez by Lemon
    </footer>
    <script src="../path/to/flowbite/dist/flowbite.min.js"></script>
</body>
</html>
<?php

use src\app\controllers\RecipeController;

require_once '../app/controllers/recipes_controller.php';
require '../../vendor/autoload.php';

$controller = new RecipeController();
$recipes = $controller->main();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accueil - Partage de Recettes</title>
    <link rel="stylesheet" href="../../public/assets/css/style.css"> 
</head>
<body>
<header>
<div class="top-band">

    <div class="container">
        <nav>
            <img src="../../public/assets/img/EcoCook.png" class="logo">
            <ul>
                <li><a href="main.php">Accueil</a></li>
                <li><a href="recipes.php">Recettes</a></li>
                <li><a href="about.php">A propos</a></li>
                <li><a href="contact.php">Contact</a></li>
                <?php if (isset($_SESSION['user'])): ?>
                    <li><a href="../app/controllers/logout.php">Déconnexion</a></li>
                <?php else: ?>
                    <li><a href="login.php">Connexion / Inscription</a></li>
                <?php endif; ?>
            </ul>    
            <?php if (isset($_SESSION['user'])): ?>
            <div class="login">
                <div class="container">
                    <!-- Affiche le message de bienvenue -->
                    <p>Bienvenue, <?php echo htmlspecialchars($_SESSION['user']); ?> !</p>
                </div>
            </div>
            <?php endif; ?>
        </nav>  
    </div>
    </div> 
</header>
<div class="container">
    <h1>Partage de Recettes</h1>
    <p>Bienvenue sur notre site de partage de recettes. Vous pouvez consulter les recettes partagées par les autres utilisateurs, ou bien partager vos propres recettes. Bon appétit !</p>
</div>
<div class="slider-container">
    <div class="slider">
        <?php
            foreach ($recipes as $row) {
                echo "<div class='slide'>
                    <h3>" . htmlspecialchars($row['title']) . "</h3>
                    <p>Description : " . htmlspecialchars($row['description']) . "</p>
                    </div>";
            }
        ?>
    </div>
</div>

<footer>
Copyright © 
    </footer>
</body>
</html>
<?php

session_start();

use src\app\controllers\recipe_controller;

require_once '../../vendor/autoload.php';
require_once '../app/controllers/recipes_controller.php';

$controller = new recipe_controller();
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
                <?php if (isset($_SESSION['user_isadmin']) && $_SESSION['user_isadmin']): ?>
                    <li><a href="admin.php">Admin</a></li>
                <?php endif; ?>
                <?php if (isset($_SESSION['user_mail'])): ?>
                    <li><a href="../app/controllers/logout.php">Déconnexion</a></li>
                <?php else: ?>
                    <li><a href="login.php">Connexion / Inscription</a></li>
                <?php endif; ?>
            </ul>    
            <?php if (isset($_SESSION['user_mail'])): ?>
            <div class="login">
                <div class="container">
                    <!-- Affiche le message de bienvenue -->
                    <p>Bienvenue, <?php echo htmlspecialchars($_SESSION['user_mail']); ?> !
                    <?php if (isset($_SESSION['user_isadmin']) && $_SESSION['user_isadmin']): ?>
                    Admin
                    <?php endif; ?>
                    </p>
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

<footer>
Copyright © 
    </footer>
</body>
</html>
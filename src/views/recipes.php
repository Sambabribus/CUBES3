<?php

session_start();

require_once '../app/controllers/recipes_controller.php';

use src\app\controllers\recipe_controller;

$controller = new recipe_controller();

if (isset($_GET['btn_search_recipe'])) {
    $controller = new recipe_controller();
    $recipes = $controller->search($_GET['search_recipe']);

    if (count($recipes) <= 0) {
        $searchMessage = "Aucune recette trouvée.";
    }

    if (isset($_POST['search_recipe'])) {
        $result = $controller->search($_POST['search_recipe']);
        
        if ($result != null) {
            $_SESSION[''] = $result;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../public/assets/css/style.css">
    <title>Document</title>
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
                    <p>Bienvenue, <?php echo htmlspecialchars($_SESSION['user_mail']); ?> !</p>
                </div>
            </div>
            <?php endif; ?>
        </nav>  
    </div>
    </div> 
</header>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="get">
            <input type="text" name="search_recipe" placeholder="Rechercher une recette" required>
            <button type="submit" name="btn_search_recipe">Rechercher</button>
</form>
<a href="ajout_recettes.php" class="btn btn-primary">Ajouter une recette</a>

        <?php
            foreach ($recipes as $row) {
                echo "<div class='recipes_recipe'>
                    <h3>" . htmlspecialchars($row->getTitle()) . "</h3>
                    <p>Description : " . htmlspecialchars($row->getDescription()) . "</p>
                    </div>";
            }
        ?>

</body>
</html>
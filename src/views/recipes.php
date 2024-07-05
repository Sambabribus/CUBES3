<?php

session_start();

require_once '../app/controllers/recipes_controller.php';
require_once '../app/controllers/comments_controller.php';

use src\app\controllers\recipe_controller;
use src\app\controllers\comments_controller;

$controller = new recipe_controller();
$recipes = [];
$getcomments = [];


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

if (isset($_POST['btn_post_comments_recipe'])) {
    $controller = new comments_controller();
    $comments = $controller->post($_POST['comments_recipe'], $_SESSION['user_id'], $_POST['recipe_id']);
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
        ?> <div class='recipes_recipe'>
                    <div class='content'>
                        <h3 class='title'><?php echo htmlspecialchars($row->getTitle()) ?></h3>
                        <p>Description : <?php echo htmlspecialchars($row->getDescription()); ?></p>
                        <p>Temps de preparation : <?php echo htmlspecialchars($row->getPreparationTime()); ?></p>
                        <p>Temps de cuisson : <?php echo htmlspecialchars($row->getCookingTime()); ?></p>
                        <p>Nombre de personne : <?php echo htmlspecialchars($row->getServes()); ?></p>
                    </div>
                    <div class="display-comment">
                        <?php
                            $com_controller = new comments_controller();
                            $getcomments = $com_controller->get($row->getId());
                            foreach  ($getcomments as $contentcomment){
                                
                            echo "<p>" . htmlspecialchars($contentcomment->getcomComment()) . "</p>";
                            }?>
                    </div>

                    <div class='comments'>
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method='post'>
                            <input type='text' name="comments_recipe" placeholder='Commenter' required>
                            <input type="hidden" name="recipe_id" value="<?php echo $row->getId(); ?>" />
                            <button type='submit' name='btn_post_comments_recipe'>Poster</button>
                        </form>
                    </div>
                </div>
    <?php
    }
    ?>
    

</body>

</html>
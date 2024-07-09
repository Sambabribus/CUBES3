<?php
require_once "../app/controllers/user_controller.php";
require_once "../app/controllers/recipes_controller.php";
require_once "../app/controllers/image_controller.php";

use src\app\controllers\image_controller;
use src\app\controllers\recipe_controller;

session_start(); // Démarre ou reprend une session au début de chaque script

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $controller = new recipe_controller();
    $result = $controller->create(
        $_POST["title"],
        $_POST["description"],
        $_POST["preparation_time"],
        $_POST["cooking_time"],
        $_POST["serves"],
        $_SESSION["user_id"]
    );

    $image_controller = new image_controller();
    $path_parts = pathinfo($_FILES["images"]["name"]);
    $resultImage = $image_controller->post(
        $result,
        $path_parts["filename"],
        $_FILES["images"]["tmp_name"],
        $path_parts["extension"],
        mime_content_type($_FILES["images"]["tmp_name"])
    );
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Ajouter une Recette</title>
    <link rel="stylesheet" href="../../public/assets/css/style.css">
</head>

<body>
    <div class="recipe-form-container">
        <h1 class="recipe-form-title">Ajouter une nouvelle recette</h1>
        <form action="<?php echo htmlspecialchars(
                            $_SERVER["PHP_SELF"]
                        ); ?>" method="post"
                        enctype="multipart/form-data">
            <div class="form-group">
                <input type="text" name="title" placeholder="Titre de la recette" required>
            </div>
            <div class="form-group">
                <textarea name="description" placeholder="Description" required></textarea>
            </div>
            <div class="form-group">
                <input type="number" name="preparation_time" placeholder="Temps de préparation (min)" required>
            </div>
            <div class="form-group">
                <input type="number" name="cooking_time" placeholder="Temps de cuisson (min)" required>
            </div>
            <div class="form-group">
                <input type="number" name="serves" placeholder="Nombre de personnes" required>
            </div>
            <div class="form-group">
                <input type="file" name="images" accept="image/*" required>
            </div>
            <!-- Pour les ingrédients, envisage d'ajouter un gestionnaire dynamique de champs ici -->
            <div class="form-group">
                <button type="submit">Ajouter Recette</button>
            </div>
        </form>
    </div>
</body>

</html>
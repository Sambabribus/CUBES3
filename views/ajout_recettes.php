<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Ajouter une Recette</title>
    <link rel="stylesheet" href="css\style.css">
</head>

<body>
    <div class="recipe-form-container">
        <h1 class="recipe-form-title">Ajouter une nouvelle recette</h1>
        <form action="../controllers/traitement_ajout_recette.php" method="post" enctype="multipart/form-data" class="recipe-form">
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
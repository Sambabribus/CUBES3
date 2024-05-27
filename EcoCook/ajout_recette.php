<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter une Recette</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Ajouter une nouvelle recette</h1>
    <form action="traitement_ajout_recette.php" method="post" enctype="multipart/form-data">
        <input type="text" name="titre" placeholder="Titre de la recette" required><br>
        <textarea name="description" placeholder="Description" required></textarea><br>
        <input type="number" name="temps_prep" placeholder="Temps de préparation (min)" required><br>
        <input type="number" name="temps_cuisson" placeholder="Temps de cuisson (min)" required><br>
        <input type="number" name="nombre_personnes" placeholder="Nombre de personnes" required><br>
        <input type="file" name="photo" accept="image/*" required><br>
        <!-- Pour les ingrédients, il faudra ajouter dynamiquement des champs ou utiliser un sélecteur multiple -->
        <button type="submit">Ajouter Recette</button>
    </form>

</body>
</html>

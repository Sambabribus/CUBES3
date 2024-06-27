<?php
include '../models/db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collecter les informations de la recette
    $titre = $_POST['title'];
    $description = $_POST['description'];
    $temps_prep = $_POST['preparation_time'];
    $temps_cuisson = $_POST['cooking_time'];
    $nombre_personnes = $_POST['serves'];

    // Traitement de l'image téléchargée
    $target_dir = "../../../uploads/";
    $target_file = $target_dir . basename($_FILES["images"]["name"]);
    if (move_uploaded_file($_FILES["images"]["tmp_name"], $target_file)) {
        // Insertion de la recette dans la table recettes
        $sql = "INSERT INTO recipes (title, description, preparation_time, cooking_time, serves, creation_date, user_id) VALUES (?, ?, ?, ?, ?, NOW(), ?)";
        $stmt = $conn->prepare($sql);
        $utilisateur_id = 1; // Cela devrait être l'ID de l'utilisateur connecté
        $stmt->execute([$titre, $description, $temps_prep, $temps_cuisson, $nombre_personnes, $utilisateur_id]);
        $recette_id = $conn->lastInsertId();

        // Insertion de l'URL de la photo dans la table photos
        $sql_photo = "INSERT INTO images (recipe_id, url_image) VALUES (?, ?)";
        $stmt_photo = $conn->prepare($sql_photo);
        $stmt_photo->execute([$recette_id, $target_file]);
        
        echo "Recette et photo ajoutées avec succès!";
    } else {
        echo "Erreur lors du téléchargement de l'image.";
    }
} else {
    echo "Aucune donnée reçue.";
}

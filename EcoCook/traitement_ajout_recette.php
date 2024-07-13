<?php
include 'connexion_bdd.php';  // Assure-toi que ce chemin est correct

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collecter les informations de la recette
    $titre = $_POST['titre'];
    $description = $_POST['description'];
    $temps_prep = $_POST['temps_prep'];
    $temps_cuisson = $_POST['temps_cuisson'];
    $nombre_personnes = $_POST['nombre_personnes'];

    // Traitement de l'image téléchargée
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["photo"]["name"]);
    if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
        // Insertion de la recette dans la table recettes
        $sql = "INSERT INTO recettes (titre, description, temps_preparation, temps_cuisson, nombre_personnes, date_ajout, utilisateur_id) VALUES (?, ?, ?, ?, ?, NOW(), ?)";
        $stmt = $conn->prepare($sql);
        $utilisateur_id = 1; // Cela devrait être l'ID de l'utilisateur connecté
        $stmt->bind_param("ssiisi", $titre, $description, $temps_prep, $temps_cuisson, $nombre_personnes, $utilisateur_id);
        $stmt->execute();
        $recette_id = $conn->insert_id;

        // Insertion de l'URL de la photo dans la table photos
        $sql_photo = "INSERT INTO photos (recette_id, url_photo) VALUES (?, ?)";
        $stmt_photo = $conn->prepare($sql_photo);
        $stmt_photo->bind_param("is", $recette_id, $target_file);
        $stmt_photo->execute();

        echo "Recette et photo ajoutées avec succès!";
    } else {
        echo "Erreur lors du téléchargement de l'image.";
    }
} else {
    echo "Aucune donnée reçue.";
}
?>
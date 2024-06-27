<?php
include '../controllers/db_connection.php';  // Assure-toi que ce chemin est correct

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collecter les informations de la recette
    $titre = $_POST['title'];
    $description = $_POST['description'];
    $temps_prep = $_POST['preparation_time'];
    $temps_cuisson = $_POST['cooking_time'];
    $nombre_personnes = $_POST['serves'];

    // Traitement de l'image téléchargée
    $target_dir = "uploads/";
    // Vérifie si le répertoire existe, sinon crée-le
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    $target_file = $target_dir . basename($_FILES["images"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Vérifier si le fichier est une image réelle
    $check = getimagesize($_FILES["images"]["tmp_name"]);
    if ($check === false) {
        echo "Le fichier n'est pas une image.";
        $uploadOk = 0;
    }

    // Vérifier la taille du fichier (par exemple, max 5MB)
    if ($_FILES["images"]["size"] > 5000000) {
        echo "Désolé, votre fichier est trop volumineux.";
        $uploadOk = 0;
    }

    // Autoriser certains formats de fichiers
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "Désolé, seuls les fichiers JPG, JPEG, PNG et GIF sont autorisés.";
        $uploadOk = 0;
    }

    // Vérifier si $uploadOk est mis à 0 par une erreur
    if ($uploadOk == 0) {
        echo "Désolé, votre fichier n'a pas été téléchargé.";
    } else {
        if (move_uploaded_file($_FILES["images"]["tmp_name"], $target_file)) {
            // Insertion de la recette dans la table recettes
            $sql = "INSERT INTO recipes (title, description, preparation_time, cooking_time, serves, creation_date, user_id) VALUES (?, ?, ?, ?, ?, NOW(), ?)";
            if ($stmt = $conn->prepare($sql)) {
                $utilisateur_id = 1; // Cela devrait être l'ID de l'utilisateur connecté
                $stmt->bind_param("ssiisi", $titre, $description, $temps_prep, $temps_cuisson, $nombre_personnes, $utilisateur_id);

                if ($stmt->execute()) {
                    $recette_id = $conn->insert_id;

                    // Insertion de l'URL de la photo dans la table photos
                    $sql_photo = "INSERT INTO images (recipe_id, url_image) VALUES (?, ?)";
                    if ($stmt_photo = $conn->prepare($sql_photo)) {
                        $stmt_photo->bind_param("is", $recette_id, $target_file);
                        if ($stmt_photo->execute()) {
                            echo "Recette et photo ajoutées avec succès!";
                        } else {
                            echo "Erreur lors de l'ajout de l'image : " . $stmt_photo->error;
                        }
                        $stmt_photo->close();
                    } else {
                        echo "Erreur de préparation de la requête d'insertion de l'image : " . $conn->error;
                    }
                } else {
                    echo "Erreur lors de l'ajout de la recette : " . $stmt->error;
                }
                $stmt->close();
            } else {
                echo "Erreur de préparation de la requête : " . $conn->error;
            }
            $conn->close();
        } else {
            echo "Erreur lors du téléchargement de l'image.";
        }
    }
} else {
    echo "Aucune donnée reçue.";
}

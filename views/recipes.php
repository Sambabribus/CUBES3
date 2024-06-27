<?php
session_start(); // Important pour accéder aux variables de session

include '..\controllers\db_connection.php';  // Inclut ton script de connexion à la base de données

if (isset($_GET['query'])) {
    $query = $_GET['query'];  // Récupère la chaîne de recherche de l'utilisateur
    $query = mysqli_real_escape_string($conn, $query);  // Nettoie la chaîne de recherche

    // Requête SQL pour rechercher les recettes
    $sql = "SELECT * FROM recette WHERE titre_rec LIKE '%$query%' OR desc_rec LIKE '%$query%'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Préparer un tableau pour stocker les résultats
        $results = [];
        while ($row = $result->fetch_assoc()) {
            $results[] = $row;
        }
    } else {
        $results = null;
    }
    $conn->close();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css\output.css">
    <title>Document</title>
</head>
<body>
<header>
<div class="top-band">

    <div class="container">
        <nav>
            <img src="Image/EcoCook.png" class="logo">
            <ul>
                <li><a href="main.php">Accueil</a></li>
                <li><a href="recipes.php">Recettes</a></li>
                <li><a href="about.php">A propos</a></li>
                <li><a href="contact.php">Contact</a></li>
                <?php if (isset($_SESSION['user'])): ?>
                    <li><a href="logout.php">Déconnexion</a></li>
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
<a href="#" class="flex flex-col items-center bg-white border border-gray-200 rounded-lg shadow md:flex-row md:max-w-xl hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700">
    <img class="object-cover w-full rounded-t-lg h-96 md:h-auto md:w-48 md:rounded-none md:rounded-s-lg" src="/docs/images/blog/image-4.jpg" alt="">
    <div class="flex flex-col justify-between p-4 leading-normal">
        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Noteworthy technology acquisitions 2021</h5>
        <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">Here are the biggest enterprise technology acquisitions of 2021 so far, in reverse chronological order.</p>
    </div>
</a>
<a href="ajout_recettes.php" class="btn btn-primary">Ajouter une recette</a>


</body>
</html>


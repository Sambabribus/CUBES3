<?php
session_start(); // Important pour accéder aux variables de session

include 'connexion_bdd.php';  // Inclut ton script de connexion à la base de données

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
    <link rel="stylesheet" href="./css/output.css">
    <title>Document</title>
</head>
<body>
<header>
<div class="top-band">

    <div class="container">
        <nav>
            <img src="Image/EcoCook.png" class="logo">
            <ul>
                <li><a href="acceuil.php">Accueil</a></li>
                <li><a href="recettes.php">Recettes</a></li>
                <li><a href="a propos.php">A propos</a></li>
                <li><a href="contact.php">Contact</a></li>
                <?php if (isset($_SESSION['user'])): ?>
                    <li><a href="logout.php">Déconnexion</a></li>
                <?php else: ?>
                    <li><a href="inscription.php">Connexion / Inscription</a></li>
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
    <input type="text" id="disabled-input" aria-label="disabled input" class="mb-6 bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" value="Disabled input" disabled>
    </div> 
</header>
<script src="../path/to/flowbite/dist/flowbite.min.js"></script>
<a href="ajout_recettes.php" class="btn btn-primary">Ajouter une recette</a>


</body>
</html>


<?php
session_start(); // Important pour accéder aux variables de session

include 'controllers/db_connection.php.php';  // Inclut ton script de connexion à la base de données

if (isset($_GET['query'])) {
    $query = $_GET['query'];  // Récupère la chaîne de recherche de l'utilisateur
    $query = mysqli_real_escape_string($conn, $query);  // Nettoie la chaîne de recherche

    // Requête SQL pour rechercher les recettes
    $sql = "SELECT * FROM recipe WHERE title LIKE '%$query%' OR description LIKE '%$query%'";
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
    <link rel="stylesheet" href="css\style.css">
    <title>Document</title>
</head>
<body>
<header>
<div class="top-band">

    <div class="container">
        <nav>
            <img src="../assets/EcoCook.png" class="logo">
            <ul>
                <li><a href="main.php">Accueil</a></li>
                <li><a href="recipe.php">Recettes</a></li>
                <li><a href="about.php">A propos</a></li>
                <li><a href="contact.php">Contact</a></li>
                <?php if (isset($_SESSION['user'])): ?>
                    <li><a href="../controllers/logout.php">Déconnexion</a></li>
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

<div class="slider">
      <div class="slide-track">
        <div class="slide bg-red-500">
<img src="../assets/shrek-5.jpg">

</div>
        <!-- same 9 slides doubled (duplicate) -->
        <div class="slide1"><img src="../assets/shrek-5.jpg"></div>
       
      </div>
    </div>


    <div class="slider">
      <div class="slide-track">
        <div class="slide bg-red-500">
<img src="../assets/shrek-5.jpg">

</div>
        <!-- same 9 slides doubled (duplicate) -->
        <div class="slide1"><img src="../assets/shrek-5.jpg"></div>
       
      </div>
    </div>

    <div class="slider">
      <div class="slide-track">
        <div class="slide bg-red-500">
<img src="../assets/shrek-5.jpg">

</div>
        <!-- same 9 slides doubled (duplicate) -->
        <div class="slide1"><img src="../assets/shrek-5.jpg"></div>
       
      </div>
    </div>


    <div class="slider">
      <div class="slide-track">
        <div class="slide bg-red-500">
<img src="../assets/shrek-5.jpg">

</div>
        <!-- same 9 slides doubled (duplicate) -->
        <div class="slide1"><img src="../assets/shrek-5.jpg"></div>
       
      </div>
    </div>



    <div class="slider">
      <div class="slide-track">
        <div class="slide bg-red-500">
<img src="Image/EcoCook.png">

</div>
        <!-- same 9 slides doubled (duplicate) -->
        <div class="slide1"><img src="../assets/shrek-5.jpg"></div>
       
      </div>
    </div>
     


<a href="ajout_recette.php" class="btn btn-primary">Ajouter une recette</a>

</body>
</html>


<?php
session_start();
// Important pour accéder aux variables de session
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
                        <li><a href="index.php">Accueil</a></li>
                        <li><a href="recipes.php">Recettes</a></li>
                        <li><a href="about.php">A propos</a></li>
                        <li><a href="contact.php">Contact</a></li>
                        <?php if (isset($_SESSION["user"])) : ?>
                            <li><a href="../app/controllers/logout.php">Déconnexion</a></li>
                        <?php else : ?>
                            <li><a href="login.php">Connexion / Inscription</a></li>
                        <?php endif; ?>
                    </ul>
                    <?php if (isset($_SESSION["user"])) : ?>
                        <div class="login">
                            <div class="container">
                                <!-- Affiche le message de bienvenue -->
                                <p>Bienvenue, <?php echo htmlspecialchars(
                                                    $_SESSION["user"]
                                                ); ?> !</p>
                            </div>
                        </div>
                    <?php endif; ?>
                </nav>
            </div>
        </div>
    </header>

    <div class="contact-container">
    <h2>Contactez-nous</h2>
    <form action="https://formsubmit.co/meelonup@gmail.com" method="POST">
        <div class="form-group">
            <label for="name">Nom:</label>
            <input type="text" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="message">Message:</label>
            <textarea id="message" name="message" rows="5" required></textarea>
        </div>
        <button type="submit">Envoyer</button>
    </form>
</div>

</body>

</html>
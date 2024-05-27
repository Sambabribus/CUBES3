<?php
session_start(); // Démarre ou reprend une session au début de chaque script

$messageInscription = '';
$messageConnexion = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $host = 'localhost';
    $dbname = 'eco_cook';
    $username = 'root';
    $password = '';
    $dsn = "mysql:host=$host;dbname=$dbname";
    try {
        $pdo = new PDO($dsn, $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if (isset($_POST['submit'])) {
            // Inscription
            $sql = "INSERT INTO utilisateur (mail_util, mdp_util, pseudo_util) VALUES (?, ?, ?)";
            $hashedPassword = password_hash($_POST['mdp_util'], PASSWORD_DEFAULT);
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$_POST['mail_util'], $hashedPassword, $_POST['pseudo_util']]);
            $messageInscription = "Inscription réussie!";
        } elseif (isset($_POST['login'])) {
            // Connexion
            $mail_util = $_POST['login-mail_util'];
            $mdp_util = $_POST['login-mdp_util'];
            
            $stmt = $pdo->prepare("SELECT mdp_util FROM utilisateur WHERE mail_util = ?");
            $stmt->execute([$mail_util]);
            $user = $stmt->fetch();

            if ($user && password_verify($mdp_util, $user['mdp_util'])) {
                $_SESSION['user'] = $mail_util; // Stocker l'email de l'utilisateur dans $_SESSION
                header('Location: acceuil.php'); // Rediriger vers acceuil.php après connexion réussie
                exit;
            } else {
                $messageConnexion = "Identifiants incorrects.";
            }
        }
    } catch (PDOException $e) {
        if (isset($_POST['submit'])) {
            $messageInscription = "Erreur lors de l'inscription: " . $e->getMessage();
        } elseif (isset($_POST['login'])) {
            $messageConnexion = "Erreur lors de la connexion: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription / Connexion</title>
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v2.1.9/css/unicons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="inscription.css">
</head>
<body>
<div class="form-container">
    <h2>Inscription</h2>
    <?php if ($messageInscription !== ''): ?>
    <p><?php echo htmlspecialchars($messageInscription); ?></p>
    <?php endif; ?>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <input type="email" name="mail_util" placeholder="Email" required>
        <input type="text" name="pseudo_util" placeholder="Pseudo" required>
        <input type="password" name="mdp_util" placeholder="Mot de passe" required>
        <button type="submit" name="submit">S'inscrire</button>
    </form>
    
    <h2>Connexion</h2>
    <?php if ($messageConnexion !== ''): ?>
    <p><?php echo htmlspecialchars($messageConnexion); ?></p>
    <?php endif; ?>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <input type="email" name="login-mail_util" placeholder="Email" required>
        <input type="password" name="login-mdp_util" placeholder="Mot de passe" required>
        <button type="submit" name="login">Se connecter</button>
    </form>
</div>
</body>
</html>

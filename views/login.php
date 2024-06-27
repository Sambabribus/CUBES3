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
            $sql = "INSERT INTO user (mail_user, pwd_user, username_user) VALUES (?, ?, ?)";
            $hashedPassword = password_hash($_POST['pwd_user'], PASSWORD_DEFAULT);
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$_POST['mail_user'], $hashedPassword, $_POST['username_user']]);
            $messageInscription = "Inscription réussie!";
        } elseif (isset($_POST['login'])) {
            // Connexion
            $mail_user = $_POST['login-mail_user'];
            $pwd_user = $_POST['login-pwd_user'];
            
            $stmt = $pdo->prepare("SELECT pwd_user FROM user WHERE mail_user = ?");
            $stmt->execute([$mail_user]);
            $user = $stmt->fetch();

            if ($user && password_verify($pwd_user, $user['pwd_user'])) {
                $_SESSION['user'] = $mail_user; // Stocker l'email de l'utilisateur dans $_SESSION
                header('Location: main.php'); // Rediriger vers acceuil.php après connexion réussie
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
    <link rel="stylesheet" href="css\inscription.css">
</head>
<body>
<div class="form-container">
    <h2>Inscription</h2>
    <?php if ($messageInscription !== ''): ?>
    <p><?php echo htmlspecialchars($messageInscription); ?></p>
    <?php endif; ?>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <input type="email" name="mail_user" placeholder="Email" required>
        <input type="text" name="username_user" placeholder="Pseudo" required>
        <input type="password" name="pwd_user" placeholder="Mot de passe" required>
        <button type="submit" name="submit">S'inscrire</button>
    </form>
    
    <h2>Connexion</h2>
    <?php if ($messageConnexion !== ''): ?>
    <p><?php echo htmlspecialchars($messageConnexion); ?></p>
    <?php endif; ?>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <input type="email" name="login-mail_user" placeholder="Email" required>
        <input type="password" name="login-pwd_user" placeholder="Mot de passe" required>
        <button type="submit" name="login">Se connecter</button>
    </form>
</div>
</body>
</html>

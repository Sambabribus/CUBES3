<?php
require_once '../app/controllers/user_controller.php';

use src\app\controllers\user_controller;

session_start(); // Démarre ou reprend une session au début de chaque script

$messageInscription = '';
$messageConnexion = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $controller = new user_controller();

    if (isset($_POST['sign_in'])) {
        $result = $controller->sign_up($_POST['username_user'], $_POST['pwd_user'], $_POST['mail_user']);

        if ($result != null) {
            $messageInscription = "Inscription réussie!";
        }
    } elseif (isset($_POST['login'])) {
        $result = $controller->login($_POST['login-mail_user'], $_POST['login-pwd_user']);

        if ($result != null && password_verify($_POST['login-pwd_user'], $result->get_pwd_user())) {
            $_SESSION['user_mail'] = $result->get_mail_user();
            $_SESSION['user_id'] = $result->get_id_user();
            $_SESSION['user_isadmin'] = $result->get_isadmin_user();
            header('Location: main.php');
        } else {
            $messageConnexion = "Identifiants incorrects.";
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
    <link rel="stylesheet" href="../../public/assets/css/inscription.css">
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
            <button type="submit" name="sign_in">S'inscrire</button>
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
<?php
require_once "../app/controllers/user_controller.php";

use src\app\controllers\user_controller;
use src\FileManager;

session_start(); // Démarre ou reprend une session au début de chaque script

$messageInscription = "";
$messageConnexion = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $controller = new user_controller();

    if (isset($_POST["sign_in"])) {
        $result = $controller->sign_up(
            $_POST["username_user"],
            $_POST["pwd_user"],
            $_POST["mail_user"]
        );

        if ($result != null) {
            $messageInscription = "Inscription réussie!";
        }
    } elseif (isset($_POST["login"])) {
        $result = $controller->login(
            $_POST["login-mail_user"],
            $_POST["login-pwd_user"]
        );

        if (
            $result != null &&
            password_verify($_POST["login-pwd_user"], $result->get_pwd_user())
        ) {
            $_SESSION["user_mail"] = $result->get_mail_user();
            $_SESSION["user_id"] = $result->get_id_user();
            $_SESSION["user_isadmin"] = $result->get_isadmin_user();
            header("Location: index.php");
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - Partage de Recettes</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.4.1/dist/flowbite.min.css" rel="stylesheet" />
</head>

<body>
    <header class="sticky top-0 w-full z-20">
        <nav class="border-b border-gray-200 flex flex-wrap items-center justify-between p-4 start-0 bg-white">
            <a href="index.php" class="cursor-pointer flex items-center rtl:space-x-reverse space-x-3">
                <img src="../../public/assets/img/EcoCook.svg" alt="Brand" class="w-10 h-10" />
                <span class="self-center text-2xl font-semibold whitespace-nowrap ">EcoCook</span>
            </a>
            <div class="flex flex-row items-center md:order-last gap-2">
                <button data-collapse-toggle="top-navbar"
                    class="flex md:hidden cursor-pointer focus:outline-none focus:ring-2 focus:ring-gray-200 hover:bg-gray-100 inline-flex items-center justify-center p-2 rounded-lg text-gray-500">
                    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14"
                        class="w-5 h-5">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M1 1h15M1 7h15M1 13h15" />
                    </svg>
                </button>
                <a href="" class="">
                    <?php if (isset($_SESSION["user_isadmin"]) && $_SESSION["user_isadmin"]): ?>
                        <img alt="Profile icon"
                            src="data: image/svg+xml;base64,<?php echo base64_encode(file_get_contents(FileManager::rootDirectory() . 'public/assets/icon/su_user.svg')) ?>" />
                    <?php else: ?>
                        <img alt="Profile icon"
                            src="data: image/svg+xml;base64,<?php echo base64_encode(file_get_contents(FileManager::rootDirectory() . 'public/assets/icon/user.svg')) ?>" />
                    <?php endif; ?>
                </a>
            </div>
            <div id="top-navbar" class="md:flex md:flex-row md:order-none md:w-auto order-last w-full hidden gap-8">
                <div
                    class="font-medium flex flex-col p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:flex-row md:space-x-8 rtl:space-x-reverse md:mt-0 md:border-0 md:bg-white">
                    <a href="recipes.php"
                        class="block cursor-pointer hover:bg-gray-100 md:border-0 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 px-3 py-2 rounded text-gray-900">Recipes</a>
                    <a href="about.php"
                        class="block cursor-pointer hover:bg-gray-100 md:border-0 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 px-3 py-2 rounded text-gray-900">About</a>
                    <a href="contact.php"
                        class="block cursor-pointer hover:bg-gray-100 md:border-0 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 px-3 py-2 rounded text-gray-900">Contact</a>
                    <!-- Is user connected -->
                    <!-- Is user admin -->
                    <?php if (isset($_SESSION["user_isadmin"]) && $_SESSION["user_isadmin"]): ?>
                        <a href="admin.php"
                            class="block cursor-pointer hover:bg-gray-100 md:border-0 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 px-3 py-2 rounded text-gray-900">Admin</a>
                    <?php endif; ?>
                    <?php if (isset($_SESSION["user_mail"])): ?>
                        <a href="../app/controllers/logout.php"
                            class="block cursor-pointer hover:bg-gray-100 md:border-0 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 px-3 py-2 rounded text-gray-900">Déconnexion</a>
                    <?php else: ?>
                        <a href="login.php"
                            class="block cursor-pointer hover:bg-gray-100 md:border-0 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 px-3 py-2 rounded text-gray-900">Connexion
                            / Inscription</a>
                    <?php endif; ?>
                    <!-- Is user not connected -->
                </div>
                <!-- avatar redirect profile -->
            </div>
        </nav>
    </header>

    <main class="mx-auto py-4">
        <section class="mx-auto px-32 max-w-screen-sm border border-gray-200 rounded-xl p-4">
            <form class="grid mb-6" action="<?php echo htmlspecialchars(
                $_SERVER["PHP_SELF"]
            ); ?>" method="post">
                <h2 class="text-2xl font-semibold leading-tight justify-self-center">Connexion</h2>
                <?php if ($messageConnexion !== ""): ?>
                    <p class="text-lg justify-self-center"><?php echo htmlspecialchars($messageConnexion); ?></p>
                <?php endif; ?>
                <div class="flex flex-col mb-2">
                    <label for="input-group-1" class="block mb-2 text-sm font-medium text-gray-900">Votre E-Mail</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="currentColor" viewBox="0 0 20 16">
                                <path
                                    d="m10.036 8.278 9.258-7.79A1.979 1.979 0 0 0 18 0H2A1.987 1.987 0 0 0 .641.541l9.395 7.737Z" />
                                <path
                                    d="M11.241 9.817c-.36.275-.801.425-1.255.427-.428 0-.845-.138-1.187-.395L0 2.6V14a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V2.5l-8.759 7.317Z" />
                            </svg>
                        </div>
                        <input id="input-group-1" type="email" name="login-mail_user" required
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5"
                            placeholder="E-mail">
                    </div>
                </div>
                <div class="flex flex-col mb-4">
                    <label for="website-admin" class="block mb-2 text-sm font-medium text-gray-900">Votre mot de
                        passe</label>
                    <div class="flex">
                        <span
                            class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border rounded-e-0 border-gray-300 border-e-0 rounded-s-md">
                            <svg class="w-5 h-5 text-gray-500" aria-hidden="true" height="24px"
                                xmlns="http://www.w3.org/2000/svg" width="24px" fill="currentColor"
                                viewBox="0 -960 960 960">
                                <path
                                    d="M280-400q-33 0-56.5-23.5T200-480q0-33 23.5-56.5T280-560q33 0 56.5 23.5T360-480q0 33-23.5 56.5T280-400Zm0 160q-100 0-170-70T40-480q0-100 70-170t170-70q67 0 121.5 33t86.5 87h352l120 120-180 180-80-60-80 60-85-60h-47q-32 54-86.5 87T280-240Zm0-80q56 0 98.5-34t56.5-86h125l58 41 82-61 71 55 75-75-40-40H435q-14-52-56.5-86T280-640q-66 0-113 47t-47 113q0 66 47 113t113 47Z" />
                            </svg>
                        </span>
                        <input type="password" id="website-admin" name="login-pwd_user" required
                            class="rounded-none rounded-e-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5"
                            placeholder="Mot de passe">
                    </div>
                </div>
                <button type="submit" name="login"
                    class="justify-self-center w-full sm:w-3/5 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">Se
                    Connecter</button>
            </form>

            <form class="grid"
                action="<?php echo htmlspecialchars(
                $_SERVER["PHP_SELF"]
            ); ?>" method="post">
                <h2 class="text-2xl font-semibold leading-tight justify-self-center">Inscription</h2>
                <?php if ($messageInscription): ?>
                    <p class="text-lg justify-self-center"><?php echo htmlspecialchars($messageInscription); ?></p>
                <?php endif; ?>
                <div class="flex flex-col mb-2">
                    <label for="input-group-1" class="block mb-2 text-sm font-medium text-gray-900">Votre E-Mail</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="currentColor" viewBox="0 0 20 16">
                                <path
                                    d="m10.036 8.278 9.258-7.79A1.979 1.979 0 0 0 18 0H2A1.987 1.987 0 0 0 .641.541l9.395 7.737Z" />
                                <path
                                    d="M11.241 9.817c-.36.275-.801.425-1.255.427-.428 0-.845-.138-1.187-.395L0 2.6V14a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V2.5l-8.759 7.317Z" />
                            </svg>
                        </div>
                        <input id="input-group-1" type="email" name="mail_user" required
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5"
                            placeholder="E-mail">
                    </div>
                </div>
                <div class="flex flex-col mb-2">
                    <label for="input-group-1" class="block mb-2 text-sm font-medium text-gray-900">Votre nom
                        d'utilisateur</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="currentColor" viewBox="0 -960 960 960">
                                <path
                                    d="m10.036 8.278 9.258-7.79A1.979 1.979 0 0 0 18 0H2A1.987 1.987 0 0 0 .641.541l9.395 7.737Z" />
                                <path
                                    d="M360-390q-21 0-35.5-14.5T310-440q0-21 14.5-35.5T360-490q21 0 35.5 14.5T410-440q0 21-14.5 35.5T360-390Zm240 0q-21 0-35.5-14.5T550-440q0-21 14.5-35.5T600-490q21 0 35.5 14.5T650-440q0 21-14.5 35.5T600-390ZM480-160q134 0 227-93t93-227q0-24-3-46.5T786-570q-21 5-42 7.5t-44 2.5q-91 0-172-39T390-708q-32 78-91.5 135.5T160-486v6q0 134 93 227t227 93Zm0 80q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm-54-715q42 70 114 112.5T700-640q14 0 27-1.5t27-3.5q-42-70-114-112.5T480-800q-14 0-27 1.5t-27 3.5ZM177-581q51-29 89-75t57-103q-51 29-89 75t-57 103Zm249-214Zm-103 36Z" />
                            </svg>
                        </div>
                        <input id="input-group-1" type="text" name="username_user" required
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5"
                            placeholder="Nom d'utilisateur">
                    </div>
                </div>
                <div class="flex flex-col mb-4">
                    <label for="website-admin" class="block mb-2 text-sm font-medium text-gray-900">Votre mot de
                        passe</label>
                    <div class="flex">
                        <span
                            class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border rounded-e-0 border-gray-300 border-e-0 rounded-s-md">
                            <svg class="w-5 h-5 text-gray-500" aria-hidden="true" height="24px"
                                xmlns="http://www.w3.org/2000/svg" width="24px" fill="currentColor"
                                viewBox="0 -960 960 960">
                                <path
                                    d="M280-400q-33 0-56.5-23.5T200-480q0-33 23.5-56.5T280-560q33 0 56.5 23.5T360-480q0 33-23.5 56.5T280-400Zm0 160q-100 0-170-70T40-480q0-100 70-170t170-70q67 0 121.5 33t86.5 87h352l120 120-180 180-80-60-80 60-85-60h-47q-32 54-86.5 87T280-240Zm0-80q56 0 98.5-34t56.5-86h125l58 41 82-61 71 55 75-75-40-40H435q-14-52-56.5-86T280-640q-66 0-113 47t-47 113q0 66 47 113t113 47Z" />
                            </svg>
                        </span>
                        <input type="password" id="website-admin" name="pwd_user" required
                            class="rounded-none rounded-e-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5"
                            placeholder="Mot de passe">
                    </div>
                </div>
                <button type="submit" name="sign_in"
                    class="justify-self-center w-full sm:w-3/5 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">
                    Se creer un compte</button>
            </form>
        </section>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.4.1/dist/flowbite.min.js"></script>
</body>

</html>
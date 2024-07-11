<?php
session_start();

use src\FileManager;

require_once "../../vendor/autoload.php";
?>

<!DOCTYPE html>
<html lang="en">

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
<?php
#region Namespace and Imports
session_start();

use src\FileManager;

require_once "../../vendor/autoload.php";
#endregion
?>

<!--#region DOCTYPE Head -->
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - Partage de Recettes</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.4.1/dist/flowbite.min.css" rel="stylesheet" />
</head>
<!--#endregion -->

<!--#region Body -->
<body>
    <!--#region Header -->
    <header class="sticky top-0 w-full z-20">
        <nav class="border-b border-gray-200 flex flex-wrap items-center justify-between p-4 start-0 bg-white">
            <!--#region Brand -->
            <a href="index.php" class="cursor-pointer flex items-center rtl:space-x-reverse space-x-3">
                <img src="data: image/svg+xml;base64,<?php echo base64_encode(
                                file_get_contents(
                                    FileManager::rootDirectory() .
                                        "public/assets/img/EcoCook.svg"
                                )
                            ); ?>" alt="Brand" class="w-10 h-10" />
                <span class="self-center text-2xl font-semibold whitespace-nowrap ">EcoCook</span>
            </a>
            <!--#endregion -->
            <!--#region User Icon Navbar -->
            <div class="flex flex-row items-center md:order-last gap-2">
                <button data-collapse-toggle="top-navbar"
                    class="flex md:hidden cursor-pointer focus:outline-none focus:ring-2 focus:ring-gray-200 hover:bg-gray-100 inline-flex items-center justify-center p-2 rounded-lg text-gray-500">
                    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14"
                        class="w-5 h-5">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M1 1h15M1 7h15M1 13h15" />
                    </svg>
                </button>
                <a href="user.php" class="">
                    <?php if (
                        isset($_SESSION["user_isadmin"]) &&
                        $_SESSION["user_isadmin"]
                    ): ?>
                        <img alt="Profile icon"
                            src="data: image/svg+xml;base64,<?php echo base64_encode(
                                file_get_contents(
                                    FileManager::rootDirectory() .
                                        "public/assets/icon/su_user.svg"
                                )
                            ); ?>" />
                    <?php else: ?>
                        <img alt="Profile icon"
                            src="data: image/svg+xml;base64,<?php echo base64_encode(
                                file_get_contents(
                                    FileManager::rootDirectory() .
                                        "public/assets/icon/user.svg"
                                )
                            ); ?>" />
                    <?php endif; ?>
                </a>
            </div>
            <!--#endregion -->
            <!--#region Top Navbar -->
            <div id="top-navbar" class="md:flex md:flex-row md:order-none md:w-auto order-last w-full hidden gap-8">
                <div
                    class="font-medium flex flex-col p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:flex-row md:space-x-8 rtl:space-x-reverse md:mt-0 md:border-0 md:bg-white">
                    <a href="recipes.php"
                        class="block cursor-pointer hover:bg-gray-100 md:border-0 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 px-3 py-2 rounded text-gray-900">Recherche</a>
                    <a href="about.php"
                        class="block cursor-pointer hover:bg-gray-100 md:border-0 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 px-3 py-2 rounded text-gray-900">À Propos</a>
                    <a href="contact.php"
                        class="block cursor-pointer hover:bg-gray-100 md:border-0 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 px-3 py-2 rounded text-gray-900">Contact</a>
                    <?php if (
                        isset($_SESSION["user_isadmin"]) &&
                        $_SESSION["user_isadmin"]
                    ): ?>
                        <a href="admin.php"
                            class="block cursor-pointer hover:bg-gray-100 md:border-0 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 px-3 py-2 rounded text-gray-900">Admin</a>
                    <?php endif; ?>
                    <?php if (isset($_SESSION["user_mail"])): ?>
                        <a href="logout.php"
                            class="block cursor-pointer hover:bg-gray-100 md:border-0 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 px-3 py-2 rounded text-gray-900">Déconnexion</a>
                    <?php else: ?>
                        <a href="login.php"
                            class="block cursor-pointer hover:bg-gray-100 md:border-0 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 px-3 py-2 rounded text-gray-900">Connexion
                            / Inscription</a>
                    <?php endif; ?>
                </div>
            </div>
            <!--#endregion -->
        </nav>
    </header>
    <!--#endregion -->
    <!--#region Main -->
    <main class="mx-auto px-96 py-6">
        <section class="mx-auto px-8 border border-gray-200 rounded-xl py-4">
            <!--#region About Us -->
            <div class="grid">
                <h1 class="text-3xl font-semibold justify-self-center pb-8">À propos de nous !</h1>
                <h3 class="text-2xl pb-2">Bienvenue sur EcoCook !</h3>
                <p class="pb-6">Nous sommes dédiés à rendre la cuisine accessible et agréable pour tous. Notre mission est de simplifier la recherche de recettes et de permettre à chacun de créer des plats savoureux, qu'il soit débutant ou chef expérimenté.</p>
                <h3 class="text-xl pb-4">Ce que Nous Offrons</h3>
                <ul class="list-disc pb-8 ">
                    <li class="ml-6 pb-2"><span class="font-semibold underline">Recherche de Recettes :</span> Trouvez des recettes variées en fonction de vos préférences, des occasions spéciales, ou des restrictions alimentaires. Notre moteur de recherche intuitif vous aide à découvrir des plats qui correspondent exactement à vos besoins.</li>
                    <li class="ml-6 pb-2"><span class="font-semibold underline">Création de Recettes :</span> Partagez vos propres créations culinaires avec notre communauté. Ajoutez des photos, des astuces et des variations pour inspirer d'autres passionnés de cuisine.</li>
                    <li class="ml-6"><span class="font-semibold underline">Conseils et Astuces :</span> Accédez à des articles et des vidéos sur les techniques culinaires, les tendances gastronomiques, et les conseils pour réussir vos recettes à tous les coups.</li>
                </ul>
                <h3 class="text-xl font-semibold justify-self-center pb-4">Notre Engagement</h3>
                <p>Chez EcoCook, nous croyons que cuisiner doit être une expérience plaisante et enrichissante. Nous nous engageons à vous fournir des outils et des ressources de qualité pour vous aider à explorer et à exprimer votre créativité culinaire.

Rejoignez notre communauté et découvrez le plaisir de cuisiner facilement avec EcoCook !</p>
            </div>
            <!--#endregion -->
        </section>
    </main>
    <!--#endregion -->
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.4.1/dist/flowbite.min.js"></script>
</body>
</html>
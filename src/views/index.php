<?php
session_start();

use src\app\controllers\recipe_controller;
use src\FileManager;

require_once "../../vendor/autoload.php";
require_once "../app/controllers/recipes_controller.php";

$controller = new recipe_controller();
$recipes = $controller->main();

if (isset($_GET["btn_del_recipe"])) {
    $controller = new recipe_controller();
    $recipe = $controller->delete($_GET["btn_del_recipe"]);
    header("Location: index.php");
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
    <main class="container py-6 mx-auto">
        <section class="px-8 mx-auto">
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-8">
                <?php foreach ($recipes as $recipe): ?>
                    <div class="relative flex flex-col items-center border border-gray-200 rounded-lg min-h-64">
                        <?php $menuId = "dropdownRecipeMenu-" . $recipe->getId() ?>
                        <?php $toggleId = "dropdownRecipeToggle-" . $recipe->getId() ?>
                        <div class="absolute top-1 right-1 flex items-start gap-2.5">
                            <button id="<?php echo $toggleId ?>" data-dropdown-toggle="<?php echo $menuId ?>"
                                data-dropdown-placement="bottom-start"
                                class="inline-flex self-center items-center p-2 text-sm font-medium text-center text-gray-900 bg-slate-200/50 rounded-lg hover:bg-slate-400/50"
                                type="button">
                                <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="currentColor" viewBox="0 0 4 15">
                                    <path
                                        d="M3.5 1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 6.041a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 5.959a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z" />
                                </svg>
                            </button>
                            <div id="<?php echo $menuId ?>"
                                class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-40">
                                <ul class="py-2 text-sm text-gray-700" aria-labelledby="<?php echo $toggleId ?>">
                                    <li>
                                        <a href="recipe.php?id=<?php echo $recipe->getId() ?>&edit=false"
                                            class="block px-4 py-2 hover:bg-gray-100/50">Details</a>
                                    </li>
                                    <?php if (isset(($_SESSION["user_id"])) && ($_SESSION["user_id"]) == $recipe->getUserId() || isset(($_SESSION["user_isadmin"])) && ($_SESSION["user_isadmin"]) == 1) { ?>
                                        <li>
                                            <a href="recipe.php?id=<?php echo $recipe->getId() ?>&edit=true"
                                                class="block px-4 py-2 hover:bg-gray-100/50">Edit</a>
                                        </li>
                                        <li>
                                            <a href="?btn_del_recipe=<?php echo $recipe->getId() ?>"
                                                class="block px-4 py-2 hover:bg-gray-100/50">Delete</a>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>

                        <div class="w-full max-h-96 flex flex-col gap-2">
                            <div class="w-full basis-1/3">
                                <?php if (!empty($recipe->getImages())): ?>
                                    <img class="object-cover w-full h-48 rounded-t-lg"
                                        src="data: <?php echo $recipe->getImages()[0]->getMimeType() ?>;base64,<?php echo base64_encode(file_get_contents($recipe->getImages()[0]->getFilePath())) ?>" />
                                <?php else: ?>
                                    <img class="object-cover w-full h-48 rounded-t-lg" src="https://placehold.co/180x120"
                                        alt="Placeholder" />
                                <?php endif; ?>
                            </div>
                            <div class="w-full flex flex-col gap-1 p-4 basis-2/3 text-ellipsis">
                                <a class="mb-3 text-gray-900 text-2xl font-bold leading-tight"
                                    href="recipe.php?id=<?php echo $recipe->getId() ?>&edit=false">
                                    <?php echo $recipe->getTitle() ?>
                                    <span class="text-gray-400 font-light text-sm"><?php echo $recipe->getServes() ?>.
                                        pers</span>
                                </a>
                                <p class="mb-2 line-clamp-3 -text-gray-700 font-normal"><?php echo $recipe->getDescription() ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.4.1/dist/flowbite.min.js"></script>
</body>

</html>
<?php
require_once "../app/controllers/user_controller.php";
require_once "../app/controllers/recipes_controller.php";
require_once "../app/controllers/image_controller.php";
require_once "../app/controllers/comments_controller.php";

use src\app\controllers\image_controller;
use src\FileManager;
use src\app\controllers\recipe_controller;
use src\app\controllers\comments_controller;

session_start(); // Démarre ou reprend une session au début de chaque script

$id = $_GET["id"];
$editable = $_GET["edit"];

$image_controller = new image_controller();

$controller = new recipe_controller();
$recipe = $controller->show($id);

$com_controller = new comments_controller();
$getcomments = $com_controller->get($recipe->getId());

$mustRefresh = false;

if (isset($_POST["update_recipe"])) {
    $controller = new recipe_controller();
    $result = $controller->update(
        $id,
        $_POST["title"],
        $_POST["description"],
        $_POST["preparation_time"],
        $_POST["cooking_time"],
        $_POST["serves"]
    );

    $mustRefresh = true;
}

if (isset($_POST["btn_post_comments_recipe"])) {
    $controller = new comments_controller();
    $comments = $controller->post(
        $_POST["comments_recipe"],
        $_SESSION["user_id"],
        $recipe->getId()
    );

    $mustRefresh = true;
}

if (isset($_POST["btn_del_comment"])) {
    $controller = new comments_controller();
    $comments = $controller->delete($_POST["id_com"]);

    $mustRefresh = true;
}

if ($mustRefresh) {
    header("Location: " . $_SERVER["REQUEST_URI"]);
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detali de la recette <?php echo $recipe->getTitle(); ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.4.1/dist/flowbite.min.css" rel="stylesheet" />
</head>

<body>
    <!-- Header of all pages -->
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
                    <?php if (
                        isset($_SESSION["user_isadmin"]) &&
                        $_SESSION["user_isadmin"]
                    ): ?>
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
            <div class="flex flex-col xl:flex-row gap-4">
                <div
                    class="flex flex-col md:flex-row md:basis-2/3 border border-gray-300 rounded-t-lg xl:rounded-l-lg xl:rounded-tr-none">
                    <div class="flex flex-col basis-3/5 p-4 divide-y divide-gray-200">
                        <?php if ($editable == "true"): ?>
                            <form method="post">
                                <div class="pb-2">
                                    <label for="title" class="block mb-2 text-sm font-medium text-gray-900">Title</label>
                                    <input type="text" id="title" name="title"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                                        value="<?php echo $recipe->getTitle(); ?>" required />
                                </div>
                            <?php else: ?>
                                <h1 class="text-3xl font-bold leading-tight">
                                    <?php echo $recipe->getTitle(); ?>
                                </h1>
                            <?php endif; ?>
                            <div class="flex flex-col text-gray-400 font-light text-md">
                                <?php if ($editable == "true"): ?>
                                    <div class="pb-2">
                                        <label for="serves" class="block mb-2 text-sm font-medium text-gray-900">Nombre de
                                            personnes</label>
                                        <input type="number" id="serves" name="serves"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                                            value="<?php echo $recipe->getServes(); ?>" required />
                                    </div>
                                    <div class="pb-2">
                                        <label for="preparation_time"
                                            class="block mb-2 text-sm font-medium text-gray-900">Nombre de
                                            personnes</label>
                                        <input type="number" id="preparation_time" name="preparation_time"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                                            value="<?php echo $recipe->getPreparationTime(); ?>" required />
                                    </div>
                                    <div class="pb-2">
                                        <label for="cooking_time"
                                            class="block mb-2 text-sm font-medium text-gray-900">Nombre de
                                            personnes</label>
                                        <input type="number" id="cooking_time" name="cooking_time"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                                            value="<?php echo $recipe->getCookingTime(); ?>" required />
                                    </div>
                                <?php else: ?>
                                    <span class="text-normal font-normal leading-tight">
                                        <span class="underline font-semibold text-black">Pour</span>
                                        <?php echo $recipe->getServes(); ?>. pers
                                    </span>
                                    <span class="text-normal font-normal leading-tight divide-x-2 pb-2">
                                        <span>
                                            <span class="underline font-semibold text-black">Temps de préparation :</span>
                                            <?php echo $recipe->getPreparationTime(); ?> minute(s)
                                        </span>
                                        <span class="pl-2">
                                            <span class="underline font-semibold text-black">Temps de cuisson :</span>
                                            <?php echo $recipe->getCookingTime(); ?> minute(s)
                                        </span>
                                    </span>
                                <?php endif; ?>
                            </div>
                            <div class="flex flex-col">
                                <?php if ($editable == "true"): ?>
                                    <div class="pb-2">
                                        <label for="description"
                                            class="block mb-2 text-sm font-medium text-gray-900">Title</label>
                                        <textarea id="description" name="description"
                                            class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300"
                                            required><?php echo $recipe->getDescription(); ?></textarea>
                                    </div>
                                <?php else: ?>
                                    <p class="text-normal font-normal leading-tight pt-1">
                                        <span class="underline font-semibold text-black">Description :</span>
                                        <br />
                                        <span class="whitespace-pre-wrap"><?php echo $recipe->getDescription(); ?></span>
                                    </p>
                                <?php endif; ?>
                            </div>
                            <?php if ($editable == "true"): ?>
                                <div class="flex flex-col">
                                    <button name="update_recipe" type="submit"
                                        class="text-white bg-blue-700 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2">
                                        Modifier
                                    </button>
                                </div>
                            </form>
                        <?php endif; ?>
                    </div>
                    <?php $recipe_images = $image_controller->getByRecipeId(
                        $recipe->getId()
                    ); ?>
                    <?php if (!empty($recipe_images)): ?>
                        <div class="flex flex-col basis-2/5">
                            <img src="data: <?php echo $recipe_images[0]->getMimeType(); ?>;base64,<?php echo base64_encode(
    file_get_contents($recipe_images[0]->getFilePath())
); ?>"
                                class="basis-2/5 m-4 h-12 object-cover rounded-xl shadow-md" alt="...">
                        </div>
                    <?php endif; ?>
                </div>
                <div class="md:basis-1/3 border border-gray-300 rounded-b-lg xl:rounded-r-lg xl:rounded-bl-none">
                    <div class="h-full p-2 flex flex-col gap-1">
                        <h1 class="">Commentaires</h1>
                        <div class="bottom-0 flex flex-col border border-gray-200 rounded-lg p-2 gap-2">
                            <div class="flex flex-row justify-between items-center w-full">
                                <form method="post">
                                    <textarea placeholder="Votre Commentaires" name="comments_recipe" id="small-input" rows="3"
                                        class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-sm focus:ring-blue-500 focus:border-blue-500"
                                        required></textarea>
                                    <button type="submit" name="btn_post_comments_recipe"
                                        class="text-white bg-blue-600 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 m-1">Poster</button>
                                </form>
                            </div>
                        </div>
                        <div class="flex flex-col gap-2 overflow-y-auto h-96">
                            <?php foreach ($getcomments as $comment): ?>
                                <div class="flex flex-row border border-gray-200 rounded-lg p-6 divide-x gap-2">
                                    <img alt="Profile icon"
                                        src="data: image/svg+xml;base64,<?php echo base64_encode(
                                            file_get_contents(
                                                FileManager::rootDirectory() .
                                                    "public/assets/icon/user.svg"
                                            )
                                        ); ?>" />
                                    <div class="flex flex-row justify-between items-center w-full">
                                        <span class="pl-2">
                                            <?php echo $comment->getcomComment(); ?>
                                        </span>
                                        <form method="post">
                                            <input hidden value="<?php echo $comment->getIdCom(); ?>" name="id_com">
                                            <button type="submit" name="btn_del_comment"
                                                class="text-white bg-red-600 font-medium rounded-lg hover:bg-red-800 focus:ring-4 focus:ring-red-700 text-sm px-5 py-2.5 m-1">Supprimer</button>
                                        </form>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.4.1/dist/flowbite.min.js"></script>
</body>

</html>
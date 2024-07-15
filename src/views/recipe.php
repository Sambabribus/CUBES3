<?php
#region require
require_once "../app/controllers/user_controller.php";
require_once "../app/controllers/recipes_controller.php";
require_once "../app/controllers/image_controller.php";
require_once "../app/controllers/comments_controller.php";
require_once "../app/controllers/user_controller.php";

use src\app\controllers\user_controller;
use src\app\controllers\image_controller;
use src\FileManager;
use src\app\controllers\recipe_controller;
use src\app\controllers\comments_controller;

#endregion

#region session
session_start(); // Démarre ou reprend une session au début de chaque script
#endregion

#region variables
$id = $_GET["id"];
$editable = $_GET["edit"];

$mustRefresh = false;

$user_id = isset($_SESSION["user_id"]) ? $_SESSION["user_id"] : -1;
$is_admin = isset($_SESSION["user_isadmin"]) ? $_SESSION["user_isadmin"] : 0;
#endregion

#region controllers
$image_controller = new image_controller();
$user_controller = new user_controller();

$controller = new recipe_controller();
$recipe = $controller->show($id);

$com_controller = new comments_controller();
$getcomments = $com_controller->get($recipe->getId());
#endregion

#region update
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
#endregion

#region comments
if (isset($_POST["btn_post_comments_recipe"])) {
    $controller = new comments_controller();
    $comments = $controller->post(
        $_POST["comments_recipe"],
        $_SESSION["user_id"],
        $recipe->getId()
    );

    $mustRefresh = true;
}
#endregion

#region delete
if (isset($_POST["btn_del_comment"])) {
    $controller = new comments_controller();
    $comments = $controller->delete($_POST["id_com"]);

    $mustRefresh = true;
}
#endregion

#region refresh
if ($mustRefresh) {
    header("Location: " . $_SERVER["REQUEST_URI"]);
}
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
    <link rel="stylesheet" href="style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.4.1/dist/flowbite.min.css" rel="stylesheet" />
</head>
<!--#endregion -->

<body>
    <!--#region Header -->
    <header class="sticky top-0 w-full z-20">
        <nav class="border-b border-gray-200 flex flex-wrap items-center justify-between p-4 start-0 bg-[#C49D836F]">
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
                <button data-collapse-toggle="top-navbar" class="flex md:hidden cursor-pointer focus:outline-none focus:ring-2 focus:ring-gray-200 hover:bg-gray-100 inline-flex items-center justify-center p-2 rounded-lg text-gray-500">
                    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14" class="w-5 h-5">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15" />
                    </svg>
                </button>
                <a href="user.php" class="">
                    <?php if (
                        isset($_SESSION["user_isadmin"]) &&
                        $_SESSION["user_isadmin"]
                    ) : ?>
                        <img alt="Profile icon" src="data: image/svg+xml;base64,<?php echo base64_encode(
                                                                                    file_get_contents(
                                                                                        FileManager::rootDirectory() .
                                                                                            "public/assets/icon/su_user.svg"
                                                                                    )
                                                                                ); ?>" />
                    <?php else : ?>
                        <img alt="Profile icon" src="data: image/svg+xml;base64,<?php echo base64_encode(
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
                <div class="font-medium flex flex-col p-4 md:p-0 mt-4 rounded-lg bg-[#C49D837F] md:flex-row md:space-x-8 rtl:space-x-reverse md:mt-0 md:border-0 md:bg-[#C49D830F]">
                    <a href="recipes.php" class="block cursor-pointer hover:bg-white-100 md:border-0 md:hover:bg-transparent md:hover:text-[#A17C5E] md:p-0 px-3 py-2 rounded text-white-100">Recherche</a>
                    <a href="about.php" class="block cursor-pointer hover:bg-white-100 md:border-0 md:hover:bg-transparent md:hover:text-[#A17C5E] md:p-0 px-3 py-2 rounded text-white-100">À Propos</a>
                    <a href="contact.php" class="block cursor-pointer hover:bg-white-100 md:border-0 md:hover:bg-transparent md:hover:text-[#A17C5E] md:p-0 px-3 py-2 rounded text-white-100">Contact</a>
                    <?php if (
                        isset($_SESSION["user_isadmin"]) &&
                        $_SESSION["user_isadmin"]
                    ) : ?>
                        <a href="admin.php" class="block cursor-pointer hover:bg-gray-100 md:border-0 md:hover:bg-transparent md:hover:text-[#A17C5E] md:p-0 px-3 py-2 rounded text-white-100">Admin</a>
                    <?php endif; ?>
                    <?php if (isset($_SESSION["user_mail"])) : ?>
                        <a href="logout.php" class="block cursor-pointer hover:bg-gray-100 md:border-0 md:hover:bg-transparent md:hover:text-[#A17C5E] md:p-0 px-3 py-2 rounded text-white-100">Déconnexion</a>
                    <?php else : ?>
                        <a href="login.php" class="block cursor-pointer hover:bg-gray-100 md:border-0 md:hover:bg-transparent md:hover:text-[#A17C5E] md:p-0 px-3 py-2 rounded text-white-100">Connexion
                            / Inscription</a>
                    <?php endif; ?>
                </div>
            </div>
            <!--#endregion -->
        </nav>
    </header>
    <!--#endregion -->
    <!--#region Main -->
    <main class="container py-6 mx-auto">
        <section class="px-8 mx-auto">
            <div class="flex flex-col xl:flex-row min-h-[536px] gap-4">
                <!--#region Recipe -->
                <div class="flex flex-col md:flex-row md:basis-2/3 rounded-lg shadow-sm overflow-hidden">
                    <div class="flex flex-col md:flex-row md:basis-3/5 bg-white bg-opacity-50 p-4">
                        <!--#region Title -->
                        <?php if ($editable == "true" && ($user_id == $recipe->getUserId() || $is_admin)) : ?>
                            <form method="post" class="pb-4">
                                <label for="title" class="block mb-2 text-sm font-medium text-gray-900">Titre</label>
                                <input type="text" id="title" name="title" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" value="<?php echo $recipe->getTitle(); ?>" required>
                            </form>
                        <?php else : ?>
                            <div class="flex flex-row justify-between items-center pb-4">
                                <h1 class="text-3xl font-bold text-gray-900"><?php echo $recipe->getTitle(); ?></h1>
                                <button onclick="generatePDF()" class="text-gray-500 hover:text-gray-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 9V5.25C6.75 3.59315 8.09315 2.25 9.75 2.25H14.25C15.9069 2.25 17.25 3.59315 17.25 5.25V9" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11.25H21.75C21.75 16.108 17.858 20 13.5 20C9.142 20 5.25 16.108 5.25 11.25H12" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15.75H12.0075" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 11.25H15" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5V15.75" />
                                    </svg>
                                </button>
                            </div>
                        <?php endif; ?>
                        <!--#endregion -->

                        <!--#region Details -->
                        <div class="pt-4">
                            <?php if ($editable == "true") : ?>
                                <div class="flex flex-wrap -mx-2 space-y-4 md:space-y-0">
                                    <div class="w-full md:w-1/3 px-2 mb-4">
                                        <label for="serves" class="block mb-2 text-sm font-medium text-gray-900">Nombre de personnes</label>
                                        <input type="number" id="serves" name="serves" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" value="<?php echo $recipe->getServes(); ?>" required>
                                    </div>
                                    <div class="w-full md:w-1/3 px-2 mb-4">
                                        <label for="preparation_time" class="block mb-2 text-sm font-medium text-gray-900">Temps de préparation</label>
                                        <input type="number" id="preparation_time" name="preparation_time" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" value="<?php echo $recipe->getPreparationTime(); ?>" required>
                                    </div>
                                    <div class="w-full md:w-1/3 px-2 mb-4">
                                        <label for="cooking_time" class="block mb-2 text-sm font-medium text-gray-900">Temps de cuisson</label>
                                        <input type="number" id="cooking_time" name="cooking_time" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" value="<?php echo $recipe->getCookingTime(); ?>" required>
                                    </div>
                                </div>
                            <?php else : ?>
                                <div class="text-sm font-medium text-gray-600">
                                    <div class="flex items-center justify-between">
                                        <span class="text-black">Pour : <?php echo $recipe->getServes(); ?> personnes</span>
                                        <span>Préparation : <?php echo $recipe->getPreparationTime(); ?> min</span>
                                        <span>Cuisson : <?php echo $recipe->getCookingTime(); ?> min</span>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                        <!--#endregion -->

                        <!--#region Description -->
                        <div class="py-4">
                            <?php if ($editable == "true") : ?>
                                <label for="description" class="block mb-2 text-sm font-medium text-gray-900">Description</label>
                                <textarea id="description" name="description" class="block w-full p-2.5 text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 h-48" required><?php echo $recipe->getDescription(); ?></textarea>
                            <?php else : ?>
                                <p class="text-sm text-gray-600 whitespace-pre-wrap">
                                    <?php echo $recipe->getDescription(); ?>
                                </p>
                            <?php endif; ?>
                        </div>
                        <!--#endregion -->

                        <!--#region Edit Button -->
                        <?php if ($editable == "true") : ?>
                            <div class="py-2">
                                <button name="update_recipe" type="submit" class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 text-center">
                                    Modifier
                                </button>
                            </div>
                        <?php endif; ?>
                    </div>
                    <!--#endregion -->

                    <!--#region Image -->
                    <?php $recipe_images = $image_controller->getByRecipeId($recipe->getId()); ?>
                    <?php if (!empty($recipe_images)) : ?>
                        <div class="md:basis-2/5 bg-gray-50">
                            <img src="data: <?php echo $recipe_images[0]->getMimeType(); ?>;base64,<?php echo base64_encode(file_get_contents($recipe_images[0]->getFilePath())); ?>" class="object-cover w-full h-full" alt="Recipe Image">
                        </div>
                    <?php endif; ?>
                    <!--#endregion -->
                </div>
                <!--#endregion -->
                <!--#region Comments -->
                <div class="md:basis-1/3 border border-gray-300 rounded-b-lg xl:rounded-r-lg xl:rounded-bl-none">
                    <div class="h-full p-2 flex flex-col gap-1">
                        <!--#region Post Comments -->
                        <?php if ($user_id > 0) : ?>
                            <div class="justify-center grid">
                                <h1 class="text-3xl font-semibold">Commentaires</h1>
                            </div>
                            <div class="bottom-0 flex flex-col border content-start border-gray-200 rounded-lg p-2 gap-2">
                                <div class="flex flex-row  w-full">
                                    <form class="w-full flex flex-row" method="post">
                                        <textarea placeholder="Votre Commentaires" name="comments_recipe" id="small-input" class="h-16 block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-sm focus:ring-blue-500 focus:border-blue-500 m-1" required></textarea>
                                        <button type="submit" name="btn_post_comments_recipe" class="h-16 text-white bg-blue-600 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 m-1">Poster</button>
                                    </form>
                                </div>
                            </div>
                        <?php else : ?>
                            <div class="grid border border-gray-200 rounded-lg size-fit mx-auto">
                                <h1 class="text-xl font-semibold text-center justify-self-center p-2">Connectez-vous pour
                                    poster un commentaire</h1>
                            </div>
                        <?php endif; ?>
                        <!--#endregion -->
                        <!--#region Display Comments -->
                        <div class="flex flex-col gap-2 overflow-y-auto max-h-96">
                            <?php foreach ($getcomments as $comment) :
                                $user_name = $user_controller->getOne($comment->getUserIdComment()); ?>
                                <div class="flex flex-row border border-gray-200 rounded-lg p-4 divide-x gap-2">
                                    <img alt="Profile icon" src="data: image/svg+xml;base64,<?php echo base64_encode(
                                                                                                file_get_contents(
                                                                                                    FileManager::rootDirectory() .
                                                                                                        "public/assets/icon/user.svg"
                                                                                                )
                                                                                            ); ?>" />
                                    <div class="flex flex-row justify-between items-center w-full">
                                        <div class="flex flex-col">
                                            <p class="text-sm font-semibold text-gray-400 pl-2">
                                                <?php echo $user_name->get_username_user() ?>
                                            </p>
                                            <span class="pl-2">
                                                <?php echo $comment->getcomComment(); ?>
                                            </span>
                                        </div>
                                        <?php if ($user_id == $comment->getUserIdComment() || $is_admin) : ?>
                                            <form method="post">
                                                <input hidden value="<?php echo $comment->getIdCom(); ?>" name="id_com">

                                                <button type="submit" name="btn_del_comment" class="text-white bg-red-600 font-medium rounded-lg hover:bg-red-800 focus:ring-4 focus:ring-red-700 text-sm px-2 py-1 md:px-5 md:py-2.5 m-1">Supprimer</button>
                                            </form>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <!--#endregion -->
                    </div>
                </div>
                <!--#endregion -->
            </div>
        </section>
    </main>
    <!--#endregion -->
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.4.1/dist/flowbite.min.js"></script>
</body>
<!--#region Script Convert to PDF -->
<script>
    function generatePDF() {
        const {
            jsPDF
        } = window.jspdf;
        const doc = new jsPDF();

        const title = <?php echo json_encode($recipe->getTitle()); ?>;
        const content = <?php echo json_encode($recipe->getDescription()); ?>;

        if (!content) {
            console.error('Element #recipe not found');
            return;
        }

        const maxWidth = 190;

        const lines = doc.splitTextToSize(content, maxWidth);

        doc.setFontSize(22);
        doc.text('EcoCook', 85, 10);
        doc.setFontSize(15);
        doc.text(title, 10, 20);
        doc.setFontSize(12);
        doc.text(lines, 10, 30);

        doc.save('recette.pdf');
    }
</script>
<!--#endregion -->

</html>
<?php
#region require
require_once "../app/controllers/user_controller.php";
require_once "../app/controllers/recipes_controller.php";
require_once "../app/controllers/image_controller.php";

use src\app\controllers\image_controller;
use src\app\controllers\recipe_controller;
use src\FileManager;
#endregion

#region session
session_start(); // Démarre ou reprend une session au début de chaque script
#endregion

#region create recipe
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $controller = new recipe_controller();
    $result = $controller->create(
        $_POST["title"],
        $_POST["description"],
        $_POST["preparation_time"],
        $_POST["cooking_time"],
        $_POST["serves"],
        $_SESSION["user_id"]
    );

    $image_controller = new image_controller();
    $path_parts = pathinfo($_FILES["images"]["name"]);
    $resultImage = $image_controller->post(
        $result,
        $path_parts["filename"],
        $_FILES["images"]["tmp_name"],
        $path_parts["extension"],
        mime_content_type($_FILES["images"]["tmp_name"])
    );
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
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.tailwindcss.com"></script>
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
                            ); ?>" alt="Brand" class="w-20 h-20" />
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
                    class="font-medium flex flex-col p-4 md:p-0 mt-4 rounded-lg bg-[#C49D837F] md:flex-row md:space-x-8 rtl:space-x-reverse md:mt-0 md:border-0 md:bg-[#C49D830F]">
                    <a href="recipes.php"
                        class="block cursor-pointer hover:bg-white-100 md:border-0 md:hover:bg-transparent md:hover:text-[#A17C5E] md:p-0 px-3 py-2 rounded text-white-100">Recherche</a>
                    <a href="about.php"
                        class="block cursor-pointer hover:bg-white-100 md:border-0 md:hover:bg-transparent md:hover:text-[#A17C5E] md:p-0 px-3 py-2 rounded text-white-100">À Propos</a>
                    <a href="contact.php"
                        class="block cursor-pointer hover:bg-white-100 md:border-0 md:hover:bg-transparent md:hover:text-[#A17C5E] md:p-0 px-3 py-2 rounded text-white-100">Contact</a>
                    <?php if (
                        isset($_SESSION["user_isadmin"]) &&
                        $_SESSION["user_isadmin"]
                    ): ?>
                        <a href="admin.php"
                            class="block cursor-pointer hover:bg-gray-100 md:border-0 md:hover:bg-transparent md:hover:text-[#A17C5E] md:p-0 px-3 py-2 rounded text-white-100">Admin</a>
                    <?php endif; ?>
                    <?php if (isset($_SESSION["user_mail"])): ?>
                        <a href="logout.php"
                            class="block cursor-pointer hover:bg-gray-100 md:border-0 md:hover:bg-transparent md:hover:text-[#A17C5E] md:p-0 px-3 py-2 rounded text-white-100">Déconnexion</a>
                    <?php else: ?>
                        <a href="login.php"
                            class="block cursor-pointer hover:bg-gray-100 md:border-0 md:hover:bg-transparent md:hover:text-[#A17C5E] md:p-0 px-3 py-2 rounded text-white-100">Connexion
                            / Inscription</a>
                    <?php endif; ?>
                </div>
            </div>
            <!--#endregion -->
        </nav>
    </header>
    <!--#endregion -->
    <!--#region Main -->
    <main class="mx-auto py-4">
        <section class="mx-auto px-32 max-w-screen-sm border border-gray-200 rounded-xl p-4">
            <form class="grid"
                        enctype="multipart/form-data"
                action="<?php echo htmlspecialchars(
                    $_SERVER["PHP_SELF"]
                ); ?>" method="post">
                <h2 class="text-2xl font-semibold leading-tight justify-self-center">Crée une recette</h2>
                <!--#region Title -->
                <div class="flex flex-col mb-2">
                    <label for="input-group-1" class="block mb-2 text-sm font-medium text-gray-900">Titre</label>
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
                        <input id="input-group-1" type="text" name="title"required
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5"
                            placeholder="Titre de la recette">
                    </div>
                </div>
                <!--#endregion -->

                <!--#region Description -->
                <div class="flex flex-col mb-2">
                    <label for="input-group-1" class="block mb-2 text-sm font-medium text-gray-900">Description</label>
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
                        <textarea id="input-group-1" name="description" required
                            class="bg-gray-50 h-11 min-h-11 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5"
                            placeholder="Description"></textarea>
                    </div>
                </div>
                <!--#endregion -->

                <!--#region Preparation Time -->
                <div class="flex flex-col mb-4">
                    <label for="website-admin" class="block mb-2 text-sm font-medium text-gray-900">Temps de préparation</label>
                    <div class="flex">
                        <span
                            class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border rounded-e-0 border-gray-300 border-e-0 rounded-s-md">
                            <svg class="w-5 h-5 text-gray-500" aria-hidden="true" height="24px"
                                xmlns="http://www.w3.org/2000/svg" width="24px" fill="currentColor"
                                viewBox="0 -960 960 960">
                                <path
                                    d="M360-840v-80h240v80H360Zm80 440h80v-240h-80v240Zm40 320q-74 0-139.5-28.5T226-186q-49-49-77.5-114.5T120-440q0-74 28.5-139.5T226-694q49-49 114.5-77.5T480-800q62 0 119 20t107 58l56-56 56 56-56 56q38 50 58 107t20 119q0 74-28.5 139.5T734-186q-49 49-114.5 77.5T480-80Zm0-80q116 0 198-82t82-198q0-116-82-198t-198-82q-116 0-198 82t-82 198q0 116 82 198t198 82Zm0-280Z" />
                            </svg>
                        </span>
                        <input type="number" id="website-admin" name="preparation_time" required
                            class="rounded-none rounded-e-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5"
                            placeholder="Temps de préparation (min)">
                    </div>
                </div>
                <!--#endregion -->

                <!--#region Cooking Time -->
                <div class="flex flex-col mb-4">
                    <label for="website-admin" class="block mb-2 text-sm font-medium text-gray-900">Temps de cuisson</label>
                    <div class="flex">
                        <span
                            class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border rounded-e-0 border-gray-300 border-e-0 rounded-s-md">
                            <svg class="w-5 h-5 text-gray-500" aria-hidden="true" height="24px"
                                xmlns="http://www.w3.org/2000/svg" width="24px" fill="currentColor"
                                viewBox="0 -960 960 960">
                                <path
                                    d="M360-840v-80h240v80H360Zm80 440h80v-240h-80v240Zm40 320q-74 0-139.5-28.5T226-186q-49-49-77.5-114.5T120-440q0-74 28.5-139.5T226-694q49-49 114.5-77.5T480-800q62 0 119 20t107 58l56-56 56 56-56 56q38 50 58 107t20 119q0 74-28.5 139.5T734-186q-49 49-114.5 77.5T480-80Zm0-80q116 0 198-82t82-198q0-116-82-198t-198-82q-116 0-198 82t-82 198q0 116 82 198t198 82Zm0-280Z" />
                            </svg>
                        </span>
                        <input type="number" id="website-admin" name="cooking_time" required
                            class="rounded-none rounded-e-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5"
                            placeholder="Temps de cuisson (min)">
                    </div>
                </div>
                <!--#endregion -->

                <!--#region Serves -->
                <div class="flex flex-col mb-4">
                    <label for="website-admin" class="block mb-2 text-sm font-medium text-gray-900">Nombre de personnes</label>
                    <div class="flex">
                        <span
                            class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border rounded-e-0 border-gray-300 border-e-0 rounded-s-md">
                            <svg class="w-5 h-5 text-gray-500" aria-hidden="true" height="24px"
                                xmlns="http://www.w3.org/2000/svg" width="24px" fill="currentColor"
                                viewBox="0 -960 960 960">
                                <path
                                    d="M280-80v-366q-51-14-85.5-56T160-600v-280h80v280h40v-280h80v280h40v-280h80v280q0 56-34.5 98T360-446v366h-80Zm400 0v-320H560v-280q0-83 58.5-141.5T760-880v800h-80Z" />
                            </svg>
                        </span>
                        <input type="number" id="website-admin" name="serves" required
                            class="rounded-none rounded-e-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5"
                            placeholder="Nombre de personnes">
                    </div>
                </div>
                <!--#endregion -->

                <!--#region Photo -->
                <div class="flex flex-col mb-4">
                    <label class="block mb-2 text-sm font-medium text-gray-900 " for="file_input">Photo</label>
                    <div class="flex">
                        <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-white focus:outline-none" 
                        id="file_input" 
                        type="file" 
                        name="images" 
                        accept="image/*" 
                        required>
                    </div>
                </div>
                <!--#endregion -->

                <!--#region Create Button -->
                <button type="submit"
                    class="justify-self-center m-5 top-[calc(100%)] right-2.5 px-5 py-2.5 bg-[#A17C5E] text-white no-underline rounded-lg transition-[background-color_0.3s_ease,_transform_0.2s_ease] focus:ring-4 focus:ring-brown-300 font-medium text-sm w-full sm:w-2/5 hover:scale-105 hover:bg-[#C49D83]">
                    Créer</button>
                <!--#endregion -->
            </form>
        </section>
    </main>
    <!--#endregion -->
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.4.1/dist/flowbite.min.js"></script>
</body>
</html>
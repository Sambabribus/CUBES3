<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/controllers/RecipeController.php';
require_once __DIR__ . '/controllers/UserController.php';
require_once __DIR__ . '/controllers/IngredientController.php';
require_once __DIR__ . '/controllers/CommentController.php';

$database = new Database();
$db = $database->getConnection();

$request_method = $_SERVER["REQUEST_METHOD"];
$path_info = isset($_SERVER['PATH_INFO']) ? explode('/', trim($_SERVER['PATH_INFO'], '/')) : [];

if (count($path_info) > 0) {
    switch ($path_info[0]) {
        case 'recipes':
            $recipeId = isset($path_info[1]) ? (int)$path_info[1] : null;
            $controller = new RecipeController($db, $request_method, $recipeId);
            $controller->processRequest();
            break;
        case 'users':
            $userId = isset($path_info[1]) ? (int)$path_info[1] : null;
            $controller = new UserController($db, $request_method, $userId);
            $controller->processRequest();
            break;
        case 'ingredients':
            $ingredientId = isset($path_info[1]) ? (int)$path_info[1] : null;
            $controller = new IngredientController($db, $request_method, $ingredientId);
            $controller->processRequest();
            break;
        case 'comments':
            $commentId = isset($path_info[1]) ? (int)$path_info[1] : null;
            $controller = new CommentController($db, $request_method, $commentId);
            $controller->processRequest();
            break;
        default:
            header("HTTP/1.1 404 Not Found");
            echo json_encode(array("message" => "Endpoint Not Found"));
            break;
    }
} else {
    header("HTTP/1.1 404 Not Found");
    echo json_encode(array("message" => "No Endpoint Specified"));
}

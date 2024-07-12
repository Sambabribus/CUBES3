<?php
require '../config/database.php';
require '../controllers/RecipeController.php';
require '../controllers/UserController.php';
require '../controllers/IngredientController.php';
require '../controllers/CommentController.php';

$database = new Database();
$db = $database->getConnection();

$requestMethod = $_SERVER["REQUEST_METHOD"];
$path = explode('/', trim($_SERVER['PATH_INFO'], '/'));

switch ($path[0]) {
    case 'recipes':
        $recipeId = isset($path[1]) ? (int)$path[1] : null;
        $controller = new RecipeController($db, $requestMethod, $recipeId);
        $controller->processRequest();
        break;
    case 'users':
        $userId = isset($path[1]) ? (int)$path[1] : null;
        $controller = new UserController($db, $requestMethod, $userId);
        $controller->processRequest();
        break;
    case 'ingredients':
        $ingredientId = isset($path[1]) ? (int)$path[1] : null;
        $controller = new IngredientController($db, $requestMethod, $ingredientId);
        $controller->processRequest();
        break;
    case 'comments':
        $commentId = isset($path[1]) ? (int)$path[1] : null;
        $controller = new CommentController($db, $requestMethod, $commentId);
        $controller->processRequest();
        break;
    default:
        header("HTTP/1.1 404 Not Found");
        echo json_encode(array("message" => "Endpoint Not Found"));
        break;
}

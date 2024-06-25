<?php

include_once __DIR__ . '/../config/database.php';;
include_once __DIR__ . '/../controllers/IngredientController.php';

$database = new Database();
$db = $database->getConnection();

$requestMethod = $_SERVER["REQUEST_METHOD"];
$ingredientId = null;
if (isset($_GET['id'])) {
    $ingredientId = (int) $_GET['id'];
}

$controller = new IngredientController($db, $requestMethod, $ingredientId);
$controller->processRequest();

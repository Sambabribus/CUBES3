<?php
namespace src\app\controllers;

require 'S:/wamp64/www/repos/CUBES3/src/app/models/recipes.php';
require 'S:/wamp64/www/repos/CUBES3/src/app/models/database.php';
use src\app\models\Recipe;
use src\app\models\Database;
use src\app\services\RecipeService;

class RecipeController
{
    private RecipeService $recipeService;

    public function __construct()
    {
        $database = new Database();
        $this->recipeService = new RecipeService($database);
    }

    public function search()
    {
        $searchResults = [];
        $searchMessage = "";

        if (isset($_GET['search']) && !empty($_GET['search'])) {
            $searchResults = $this->recipeService->filterByTitleOrDescription((string) $_GET['search']);

        } else {
            $searchMessage = "Aucune recette trouvée.";
        }

        if (empty($searchResults)) {
            $searchMessage = "Aucune recette trouvée.";
        }

        $stmt = null;
        require '../views/recipes.php';
    }

    final public function create($title, $description, $preparation_time, $cooking_time, $serves, $creation_date, $user_id, $url_image): void
    {
        $recipe = new Recipe();
        $recipe
            ->setTitle($title)
            ->setDescription($description)
            ->setPreparationTime($preparation_time)
            ->setCookingTime($cooking_time)
            ->setServes($serves)
            ->setUrlImage($url_image);
        
        $this->recipeService->create($recipe);
    }

    final public function show($id): void
    {
        $recipe = $this->recipeService->getById($id);
        require '../views/recipe.php';
    }

    final public function main(): array
    {
        $recipes = $this->recipeService->getLimitOrderByCreateDate(6);
        return $recipes;
    }

    final public function index(): void
    {
        $recipes = $this->recipeService->getAll();
    }
    final public function edit($id): void
    {
        $recipe = $this->recipeService->getById($id);
        require '../views/edit_recipe.php';
    }

    final public function update($id, $title, $description, $preparation_time, $cooking_time, $serves): void
    {
        $recipe = new Recipe();
        $recipe
            ->setTitle($title)
            ->setDescription($description)
            ->setPreparationTime($preparation_time)
            ->setCookingTime($cooking_time)
            ->setServes($serves);
        
        $this->recipeService->update($id, $recipe);
    }

    final public function delete($id): void
    {
        $this->recipeService->delete($id);
    }
}

<?php
namespace src\app\controllers;

require_once '../app/models/recipes.php';
require_once '../app/models/database.php';
require_once '../app/services/recipe_service.php';

use src\app\models\Recipe;
use src\app\models\Database;
use src\app\services\RecipeService;

class recipe_controller
{
    private RecipeService $recipeService;

    public function __construct()
    {
        $database = new Database();
        $this->recipeService = new RecipeService($database);
    }

    public function search(string $query): array {
        return $this->recipeService->filterByTitleOrDescription($query);
    }

    final public function create($title, $description, $preparation_time, $cooking_time, $serves, $user_id/**, $url_image */): bool
    {
        $recipe = new Recipe();
        $recipe
            ->setTitle($title)
            ->setDescription($description)
            ->setPreparationTime($preparation_time)
            ->setCookingTime($cooking_time)
            ->setServes($serves);
            //->setUrlImage($url_image);
        
        return $this->recipeService->create($recipe, $user_id);
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

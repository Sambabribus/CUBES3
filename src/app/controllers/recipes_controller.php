<?php
namespace src\app\controllers;

require 'S:/wamp64/www/repos/CUBES3/src/app/models/recipes.php';
require 'S:/wamp64/www/repos/CUBES3/src/app/models/database.php';
use src\app\models\Recipe;
use src\app\models\Database;

class RecipeController {
    private Recipe $recipeModel;

    public function __construct() {
        $database = new Database();
        $this->recipeModel = new Recipe($database);
    }

    public function search() {
        $searchResults = [];
        $searchMessage = "";

        if (isset($_GET['search']) && !empty($_GET['search'])) {
            $searchTerm = '%' . $_GET['search'] . '%';
            $stmt = $conn->prepare("SELECT recipes.id, title, description, cooking_time, preparation_time, serves, images.url_image FROM recipes LEFT JOIN images ON recipes.id = images.recipe_id WHERE recipes.title LIKE ? OR recipes.description LIKE ?");
            $stmt->execute([$searchTerm, $searchTerm]);
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (!empty($results)) {
                foreach ($results as $row) {
                    $recipe = new Recipe($row['id'], $row['title'], $row['description'], $row['cooking_time'], $row['preparation_time'], $row['serves'], $row['url_image']);
                    $searchResults[] = $recipe;
                }
            } else {
                $searchMessage = "Aucune recette trouvée.";
            }
            $stmt = null;
        }
        $conn = null;
        require '../views/recipes.php';
    }

    final public function create($title, $description, $preparation_time, $cooking_time, $serves, $creation_date, $user_id): void {
        $this->recipeModel->createRecipe($title, $description, $preparation_time, $cooking_time, $serves, $creation_date, $user_id);
    }

    final public function show($id): void {
        $recipe = $this->recipeModel->getRecipe($id);
        require '../views/recipe.php';
    }

    final public function main(): array{
        $recipes = $this->recipeModel->getMainRecipes();
        return $recipes;
    }

    final public function index(): void {
        $recipes = $this->recipeModel->getAllRecipes();
        require '../views/recipes.php';
    }
    final public function edit($id): void {
        $recipe = $this->recipeModel->getRecipe($id);
        require '../views/edit_recipe.php';
    }

    final public function update($id, $title, $description, $preparation_time, $cooking_time, $serves): void {
        $this->recipeModel->updateRecipe($id, $title, $description, $preparation_time, $cooking_time, $serves);
    }

    final public function delete($id): void {
        $this->recipeModel->deleteRecipe($id);
    }
}

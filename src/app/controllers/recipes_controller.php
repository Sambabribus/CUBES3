<?php
#region Required Classes
// Définition de l'espace de noms et importation des classes nécessaires.
namespace src\app\controllers;
require_once '../app/models/recipes.php';
require_once '../app/models/database.php';
require_once '../app/services/recipe_service.php';
use src\app\models\Recipe;
use src\app\models\Database;
use src\app\services\RecipeService;
#endregion

class recipe_controller
{
    #region Properties
    private RecipeService $recipeService; // Instance du service de recettes.
    #endregion

    #region Constructor
    // Constructeur qui initialise le service de recettes avec une instance de la base de données.
    public function __construct()
    {
        $database = new Database();
        $this->recipeService = new RecipeService($database);
    }
    #endregion

    #region Search Function
    // Méthode pour rechercher des recettes par titre ou description.
    public function search(string $query): array {
        return $this->recipeService->filterByTitleOrDescription($query);
    }
    #endregion

    #region Create Function
    // Méthode pour créer une nouvelle recette.
    final public function create($title, $description, $preparation_time, $cooking_time, $serves, $user_id): bool
    {
        $recipe = new Recipe();
        $recipe
            ->setTitle($title)
            ->setDescription($description)
            ->setPreparationTime($preparation_time)
            ->setCookingTime($cooking_time)
            ->setServes($serves);
        
        return $this->recipeService->create($recipe, $user_id);
    }
    #endregion

    #region Show Function
    // Méthode pour afficher une recette spécifique par son ID.
    final public function show($id): void
    {
        $recipe = $this->recipeService->getById($id);
        require '../views/recipe.php';
    }
    #endregion
    
    #region Main Function
    // Méthode pour récupérer un nombre limité de recettes triées par date de création.
    final public function main(): array
    {
        $recipes = $this->recipeService->getLimitOrderByCreateDate(6);
        return $recipes;
    }
    #endregion

    #region Index Function
    // Méthode pour récupérer toutes les recettes.
    final public function index(): void
    {
        $recipes = $this->recipeService->getAll();
    }
    #endregion

    #region Edit Function
    // Méthode pour préparer l'édition d'une recette spécifique par son ID.
    final public function edit($id): void
    {
        $recipe = $this->recipeService->getById($id);
        require '../views/edit_recipe.php';
    }
    #endregion

    #region Update Function
    // Méthode pour mettre à jour une recette existante.
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
    #endregion

    #region Delete Function
    // Méthode pour supprimer une recette par son ID.
    final public function delete($id): void
    {
        $this->recipeService->delete($id);
    }
    #endregion
}
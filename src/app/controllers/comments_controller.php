<?php
namespace src\app\controllers;

require_once '../app/models/recipes.php';
require_once '../app/models/database.php';
require_once '../app/models/comment.php';
require_once '../app/services/recipe_service.php';

use src\app\models\Recipe;
use src\app\models\Database;
use src\app\models\Comment;
use src\app\services\comment_service;
use src\app\services\RecipeService;

class comments_controller {

    private comment_service $comment_service;

    public function __construct()
    {
        $database = new Database();
        $this->comment_service = new comment_service($database);
    }

    public function post($content, $user_id, $recipe_id)
    {
        $comment = new Comment();
        $comment
            ->setUserIdComment($user_id)
            ->setRecipeIdComment($recipe_id)
            ->setcomComment($content);

        return $this->comment_service->post_comment($comment, $user_id, $recipe_id);
    }

    public function get($recipe_id): ?array {
        $comments = $this->comment_service->get_comment_by_recipe_id($recipe_id, 3);
        return $comments;
    }

    public function update($content, $id_comment): bool {
        $comment = $this->comment_service->update_comment($content, $id_comment,);
        return $comment;
    }
}
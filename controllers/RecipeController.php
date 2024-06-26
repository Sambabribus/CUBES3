<?php
require_once __DIR__ . '/../models/Recipe.php';

class RecipeController
{
    private $db;
    private $requestMethod;
    private $recipeId;

    public function __construct($db, $requestMethod, $recipeId = null)
    {
        $this->db = $db;
        $this->requestMethod = $requestMethod;
        $this->recipeId = $recipeId;
    }

    public function processRequest()
    {
        switch ($this->requestMethod) {
            case 'GET':
                if ($this->recipeId) {
                    $this->getRecipe($this->recipeId);
                } else {
                    $this->getRecipes();
                }
                break;
            case 'POST':
                $this->createRecipe();
                break;
            case 'PUT':
                $this->updateRecipe($this->recipeId);
                break;
            case 'DELETE':
                $this->deleteRecipe($this->recipeId);
                break;
            default:
                $this->notFoundResponse();
                break;
        }
    }

    public function getRecipes()
    {
        $recipe = new Recipe($this->db);
        $stmt = $recipe->read_all();
        $num = $stmt->rowCount();

        if ($num > 0) {
            $recipes_arr = array();
            $recipes_arr["records"] = array();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $recipe_item = array(
                    "id" => $id,
                    "title" => $title,
                    "description" => html_entity_decode($description),
                    "preparation_time" => $preparation_time,
                    "cooking_time" => $cooking_time,
                    "serves" => $serves,
                    "creation_date" => $creation_date,
                    "user_id" => $user_id
                );
                array_push($recipes_arr["records"], $recipe_item);
            }
            http_response_code(200);
            echo json_encode($recipes_arr);
        } else {
            http_response_code(404);
            echo json_encode(array("message" => "No recipes found."));
        }
    }

    public function getRecipe($id)
    {
        $recipe = new Recipe($this->db);
        $recipe->id = $id;
        $stmt = $recipe->read();

        if ($stmt->rowCount() == 1) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            extract($row);
            $recipe_item = array(
                "id" => $id,
                "title" => $title,
                "description" => html_entity_decode($description),
                "preparation_time" => $preparation_time,
                "cooking_time" => $cooking_time,
                "serves" => $serves,
                "creation_date" => $creation_date,
                "user_id" => $user_id
            );
            http_response_code(200);
            echo json_encode($recipe_item);
        } else {
            http_response_code(404);
            echo json_encode(array("message" => "Recipe not found."));
        }
    }

    public function createRecipe()
    {
        $data = json_decode(file_get_contents("php://input"));

        $recipe = new Recipe($this->db);
        $recipe->title = $data->title;
        $recipe->description = $data->description;
        $recipe->preparation_time = $data->preparation_time;
        $recipe->cooking_time = $data->cooking_time;
        $recipe->serves = $data->serves;
        $recipe->creation_date = date('Y-m-d H:i:s');
        $recipe->user_id = $data->user_id;

        if ($recipe->create()) {
            http_response_code(201);
            echo json_encode(array("message" => "Recipe created."));
        } else {
            http_response_code(503);
            echo json_encode(array("message" => "Unable to create recipe."));
        }
    }

    public function updateRecipe($id)
    {
        $data = json_decode(file_get_contents("php://input"));

        $recipe = new Recipe($this->db);
        $recipe->id = $id;
        $recipe->title = $data->title;
        $recipe->description = $data->description;
        $recipe->preparation_time = $data->preparation_time;
        $recipe->cooking_time = $data->cooking_time;
        $recipe->serves = $data->serves;
        $recipe->creation_date = date('Y-m-d H:i:s');
        $recipe->user_id = $data->user_id;

        if ($recipe->update()) {
            http_response_code(200);
            echo json_encode(array("message" => "Recipe updated."));
        } else {
            http_response_code(503);
            echo json_encode(array("message" => "Unable to update recipe."));
        }
    }

    public function deleteRecipe($id)
    {
        $recipe = new Recipe($this->db);
        $recipe->id = $id;

        if ($recipe->delete()) {
            http_response_code(200);
            echo json_encode(array("message" => "Recipe deleted."));
        } else {
            http_response_code(503);
            echo json_encode(array("message" => "Unable to delete recipe."));
        }
    }

    private function notFoundResponse()
    {
        http_response_code(404);
        echo json_encode(array("message" => "Not Found"));
    }
}

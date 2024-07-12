<?php
require_once __DIR__ . '/../models/Ingredient.php';

class IngredientController
{
    private $db;
    private $requestMethod;
    private $ingredientId;

    public function __construct($db, $requestMethod, $ingredientId = null)
    {
        $this->db = $db;
        $this->requestMethod = $requestMethod;
        $this->ingredientId = $ingredientId;
    }

    public function processRequest()
    {
        switch ($this->requestMethod) {
            case 'GET':
                if ($this->ingredientId) {
                    $this->getIngredient($this->ingredientId);
                } else {
                    $this->getIngredients();
                }
                break;
            case 'POST':
                $this->createIngredient();
                break;
            case 'PUT':
                $this->updateIngredient($this->ingredientId);
                break;
            case 'DELETE':
                $this->deleteIngredient($this->ingredientId);
                break;
            default:
                $this->notFoundResponse();
                break;
        }
    }

    public function getIngredients()
    {
        $ingredient = new Ingredient($this->db);
        $stmt = $ingredient->read_all();
        $num = $stmt->rowCount();

        if ($num > 0) {
            $ingredients_arr = array();
            $ingredients_arr["records"] = array();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $ingredient_item = array(
                    "id" => $id,
                    "name" => $name
                );
                array_push($ingredients_arr["records"], $ingredient_item);
            }
            http_response_code(200);
            echo json_encode($ingredients_arr);
        } else {
            http_response_code(404);
            echo json_encode(array("message" => "No ingredients found."));
        }
    }

    public function getIngredient($id)
    {
        $ingredient = new Ingredient($this->db);
        $ingredient->id = $id;
        $stmt = $ingredient->read();

        if ($stmt->rowCount() == 1) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            extract($row);
            $ingredient_item = array(
                "id" => $id,
                "name" => $name
            );
            http_response_code(200);
            echo json_encode($ingredient_item);
        } else {
            http_response_code(404);
            echo json_encode(array("message" => "Ingredient not found."));
        }
    }

    public function createIngredient()
    {
        $data = json_decode(file_get_contents("php://input"));

        $ingredient = new Ingredient($this->db);
        $ingredient->name = $data->name;

        if ($ingredient->create()) {
            http_response_code(201);
            echo json_encode(array("message" => "Ingredient created."));
        } else {
            http_response_code(503);
            echo json_encode(array("message" => "Unable to create ingredient."));
        }
    }

    public function updateIngredient($id)
    {
        $data = json_decode(file_get_contents("php://input"));

        $ingredient = new Ingredient($this->db);
        $ingredient->id = $id;
        $ingredient->name = $data->name;

        if ($ingredient->update()) {
            http_response_code(200);
            echo json_encode(array("message" => "Ingredient updated."));
        } else {
            http_response_code(503);
            echo json_encode(array("message" => "Unable to update ingredient."));
        }
    }

    public function deleteIngredient($id)
    {
        $ingredient = new Ingredient($this->db);
        $ingredient->id = $id;

        if ($ingredient->delete()) {
            http_response_code(200);
            echo json_encode(array("message" => "Ingredient deleted."));
        } else {
            http_response_code(503);
            echo json_encode(array("message" => "Unable to delete ingredient."));
        }
    }

    private function notFoundResponse()
    {
        http_response_code(404);
        echo json_encode(array("message" => "Not Found"));
    }
}

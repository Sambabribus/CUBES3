<?php

include_once __DIR__ . '/../models/Ingredient.php';

class IngredientController
{
    private $conn;
    private $requestMethod;
    private $ingredientId;

    private $ingredient;

    public function __construct($db, $requestMethod, $ingredientId)
    {
        $this->conn = $db;
        $this->requestMethod = $requestMethod;
        $this->ingredientId = $ingredientId;
        $this->ingredient = new Ingredient($db);
    }

    public function processRequest()
    {
        switch ($this->requestMethod) {
            case 'GET':
                if ($this->ingredientId) {
                    $response = $this->getIngredient($this->ingredientId);
                } else {
                    $response = $this->getAllIngredients();
                };
                break;
            case 'POST':
                $response = $this->createIngredient();
                break;
            case 'PUT':
                $response = $this->updateIngredient($this->ingredientId);
                break;
            case 'DELETE':
                $response = $this->deleteIngredient($this->ingredientId);
                break;
            default:
                $response = $this->notFoundResponse();
                break;
        }

        header($response['status_code_header']);
        if ($response['body']) {
            echo $response['body'];
        }
    }

    private function getAllIngredients()
    {
        $result = $this->ingredient->read();
        $ingredients = array();
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $ingredient_item = array(
                'id' => $id,
                'nom' => $nom
            );
            array_push($ingredients, $ingredient_item);
        }

        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($ingredients);
        return $response;
    }

    private function getIngredient($id)
    {
        $this->ingredient->id = (int)$id;
        $result = $this->ingredient->read_single();

        if (!$result) {
            return $this->notFoundResponse();
        }

        $ingredient = array(
            'id' => $this->ingredient->id,
            'nom' => $this->ingredient->nom
        );

        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($ingredient);
        return $response;
    }

    private function createIngredient()
    {
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);

        if (!$this->validateIngredient($input)) {
            return $this->unprocessableEntityResponse();
        }

        $this->ingredient->nom = $input['nom'];

        if ($this->ingredient->create()) {
            $response['status_code_header'] = 'HTTP/1.1 201 Created';
            $response['body'] = json_encode(['message' => 'Ingredient Created']);
        } else {
            $response = $this->unprocessableEntityResponse();
        }

        return $response;
    }

    private function updateIngredient($id)
    {
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);

        if (!$this->validateIngredient($input)) {
            return $this->unprocessableEntityResponse();
        }

        $this->ingredient->id = (int)$id;
        $this->ingredient->nom = $input['nom'];

        if ($this->ingredient->update()) {
            $response['status_code_header'] = 'HTTP/1.1 200 OK';
            $response['body'] = json_encode(['message' => 'Ingredient Updated']);
        } else {
            $response = $this->notFoundResponse();
        }

        return $response;
    }

    private function deleteIngredient($id)
    {
        $this->ingredient->id = (int)$id;

        if ($this->ingredient->delete()) {
            $response['status_code_header'] = 'HTTP/1.1 200 OK';
            $response['body'] = json_encode(['message' => 'Ingredient Deleted']);
        } else {
            $response = $this->notFoundResponse();
        }

        return $response;
    }

    private function validateIngredient($input)
    {
        if (!isset($input['nom'])) {
            return false;
        }
        return true;
    }

    private function unprocessableEntityResponse()
    {
        $response['status_code_header'] = 'HTTP/1.1 422 Unprocessable Entity';
        $response['body'] = json_encode(['message' => 'Invalid input']);
        return $response;
    }

    private function notFoundResponse()
    {
        $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
        $response['body'] = json_encode(['message' => 'Ingredient Not Found']);
        return $response;
    }
}

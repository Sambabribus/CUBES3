<?php

class RecetteController
{
    private $conn;
    private $requestMethod;
    private $recetteId;
    private $recette;

    public function __construct($db, $requestMethod, $recetteId = null)
    {
        $this->conn = $db;
        $this->requestMethod = $requestMethod;
        $this->recetteId = $recetteId;
        $this->recette = new Recette($db);
    }

    public function processRequest()
    {
        switch ($this->requestMethod) {
            case 'GET':
                if ($this->recetteId) {
                    $response = $this->getRecette($this->recetteId);
                } else {
                    $response = $this->getAllRecettes();
                }
                break;
            case 'POST':
                $response = $this->createRecette();
                break;
            case 'PUT':
                $response = $this->updateRecette($this->recetteId);
                break;
            case 'DELETE':
                $response = $this->deleteRecette($this->recetteId);
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

    private function getAllRecettes()
    {
        $result = $this->recette->read();
        $recettes = $result->fetchAll(PDO::FETCH_ASSOC);
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($recettes);
        return $response;
    }

    private function getRecette($id)
    {
        $this->recette->id = $id;
        $recette = $this->recette->read_single();
        if (!$recette) {
            return $this->notFoundResponse();
        }
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($recette);
        return $response;
    }

    private function createRecette()
    {
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);
        if (!$this->validateRecette($input)) {
            return $this->unprocessableEntityResponse();
        }
        $this->recette->titre = $input['titre'];
        $this->recette->description = $input['description'];
        $this->recette->temps_preparation = $input['temps_preparation'];
        $this->recette->temps_cuisson = $input['temps_cuisson'];
        if ($this->recette->create()) {
            $response['status_code_header'] = 'HTTP/1.1 201 Created';
            $response['body'] = null;
        } else {
            $response['status_code_header'] = 'HTTP/1.1 500 Internal Server Error';
            $response['body'] = json_encode(['message' => 'Erreur lors de la création de la recette.']);
        }
        return $response;
    }

    private function updateRecette($id)
    {
        $this->recette->id = $id;
        $existingRecette = $this->recette->read_single();
        if (!$existingRecette) {
            return $this->notFoundResponse();
        }
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);
        if (!$this->validateRecette($input)) {
            return $this->unprocessableEntityResponse();
        }
        $this->recette->titre = $input['titre'];
        $this->recette->description = $input['description'];
        $this->recette->temps_preparation = $input['temps_preparation'];
        $this->recette->temps_cuisson = $input['temps_cuisson'];
        if ($this->recette->update()) {
            $response['status_code_header'] = 'HTTP/1.1 200 OK';
            $response['body'] = null;
        } else {
            $response['status_code_header'] = 'HTTP/1.1 500 Internal Server Error';
            $response['body'] = json_encode(['message' => 'Erreur lors de la mise à jour de la recette.']);
        }
        return $response;
    }

    private function deleteRecette($id)
    {
        $this->recette->id = $id;
        $existingRecette = $this->recette->read_single();
        if (!$existingRecette) {
            return $this->notFoundResponse();
        }
        if ($this->recette->delete()) {
            $response['status_code_header'] = 'HTTP/1.1 200 OK';
            $response['body'] = null;
        } else {
            $response['status_code_header'] = 'HTTP/1.1 500 Internal Server Error';
            $response['body'] = json_encode(['message' => 'Erreur lors de la suppression de la recette.']);
        }
        return $response;
    }

    private function validateRecette($input)
    {
        if (!isset($input['titre']) || !isset($input['description']) || !isset($input['temps_preparation']) || !isset($input['temps_cuisson'])) {
            return false;
        }
        return true;
    }

    private function unprocessableEntityResponse()
    {
        $response['status_code_header'] = 'HTTP/1.1 422 Unprocessable Entity';
        $response['body'] = json_encode(['message' => 'Données invalides.']);
        return $response;
    }

    private function notFoundResponse()
    {
        $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
        $response['body'] = json_encode(['message' => 'Recette non trouvée.']);
        return $response;
    }
}

<?php

class UtilisateurController
{
    private $conn;
    private $requestMethod;
    private $utilisateurId;
    private $utilisateur;

    public function __construct($db, $requestMethod, $utilisateurId = null)
    {
        $this->conn = $db;
        $this->requestMethod = $requestMethod;
        $this->utilisateurId = $utilisateurId;
        $this->utilisateur = new Utilisateur($db);
    }

    public function processRequest()
    {
        switch ($this->requestMethod) {
            case 'GET':
                if ($this->utilisateurId) {
                    $response = $this->getUtilisateur($this->utilisateurId);
                } else {
                    $response = $this->getAllUtilisateurs();
                }
                break;
            case 'POST':
                $response = $this->createUtilisateur();
                break;
            case 'PUT':
                $response = $this->updateUtilisateur($this->utilisateurId);
                break;
            case 'DELETE':
                $response = $this->deleteUtilisateur($this->utilisateurId);
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

    private function getAllUtilisateurs()
    {
        $result = $this->utilisateur->read();
        $utilisateurs = $result->fetchAll(PDO::FETCH_ASSOC);
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($utilisateurs);
        return $response;
    }

    private function getUtilisateur($id)
    {
        $this->utilisateur->id = $id;
        $utilisateur = $this->utilisateur->read_single();
        if (!$utilisateur) {
            return $this->notFoundResponse();
        }
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($utilisateur);
        return $response;
    }

    private function createUtilisateur()
    {
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);
        if (!$this->validateUtilisateur($input)) {
            return $this->unprocessableEntityResponse();
        }
        $this->utilisateur->nom = $input['nom'];
        $this->utilisateur->email = $input['email'];
        $this->utilisateur->mot_de_passe = $input['mot_de_passe'];
        if ($this->utilisateur->create()) {
            $response['status_code_header'] = 'HTTP/1.1 201 Created';
            $response['body'] = null;
        } else {
            $response['status_code_header'] = 'HTTP/1.1 500 Internal Server Error';
            $response['body'] = json_encode(['message' => 'Erreur lors de la création de l\'utilisateur.']);
        }
        return $response;
    }

    private function updateUtilisateur($id)
    {
        $this->utilisateur->id = $id;
        $existingUtilisateur = $this->utilisateur->read_single();
        if (!$existingUtilisateur) {
            return $this->notFoundResponse();
        }
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);
        if (!$this->validateUtilisateur($input)) {
            return $this->unprocessableEntityResponse();
        }
        $this->utilisateur->nom = $input['nom'];
        $this->utilisateur->email = $input['email'];
        $this->utilisateur->mot_de_passe = $input['mot_de_passe'];
        if ($this->utilisateur->update()) {
            $response['status_code_header'] = 'HTTP/1.1 200 OK';
            $response['body'] = null;
        } else {
            $response['status_code_header'] = 'HTTP/1.1 500 Internal Server Error';
            $response['body'] = json_encode(['message' => 'Erreur lors de la mise à jour de l\'utilisateur.']);
        }
        return $response;
    }

    private function deleteUtilisateur($id)
    {
        $this->utilisateur->id = $id;
        $existingUtilisateur = $this->utilisateur->read_single();
        if (!$existingUtilisateur) {
            return $this->notFoundResponse();
        }
        if ($this->utilisateur->delete()) {
            $response['status_code_header'] = 'HTTP/1.1 200 OK';
            $response['body'] = null;
        } else {
            $response['status_code_header'] = 'HTTP/1.1 500 Internal Server Error';
            $response['body'] = json_encode(['message' => 'Erreur lors de la suppression de l\'utilisateur.']);
        }
        return $response;
    }

    private function validateUtilisateur($input)
    {
        if (!isset($input['nom']) || !isset($input['email']) || !isset($input['mot_de_passe'])) {
            return false;
        }
        return true;
    }

    private function unprocessableEntityResponse()
    {
        $response['status_code_header'] = 'HTTP/1.1 422 Unprocessable Entity';
        $response['body'] = json_encode([
            'message' => 'Données invalides.'
        ]);
        return $response;
    }

    private function notFoundResponse()
    {
        $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
        $response['body'] = json_encode([
            'message' => 'Utilisateur non trouvé.'
        ]);
        return $response;
    }
}

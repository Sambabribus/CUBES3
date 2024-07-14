<?php
require_once __DIR__ . '/../models/User.php';

class UserController
{
    private $db;
    private $requestMethod;
    private $userId;

    public function __construct($db, $requestMethod, $userId = null)
    {
        $this->db = $db;
        $this->requestMethod = $requestMethod;
        $this->userId = $userId;
    }

    public function processRequest()
    {
        switch ($this->requestMethod) {
            case 'GET':
                if ($this->userId) {
                    $this->getUser($this->userId);
                } else {
                    $this->getUsers();
                }
                break;
            case 'POST':
                $this->createUser();
                break;
            case 'PUT':
                $this->updateUser($this->userId);
                break;
            case 'DELETE':
                $this->deleteUser($this->userId);
                break;
            default:
                $this->notFoundResponse();
                break;
        }
    }

    public function getUsers()
    {
        $user = new User($this->db);
        $stmt = $user->read_all();
        $num = $stmt->rowCount();

        if ($num > 0) {
            $users_arr = array();
            $users_arr["records"] = array();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $user_item = array(
                    "id" => $id,
                    "mail" => $mail,
                    "password" => $password,
                    "username" => $username
                );
                array_push($users_arr["records"], $user_item);
            }
            http_response_code(200);
            echo json_encode($users_arr);
        } else {
            http_response_code(404);
            echo json_encode(array("message" => "No users found."));
        }
    }

    public function getUser($id)
    {
        $user = new User($this->db);
        $user->id = $id;
        $stmt = $user->read();

        if ($stmt->rowCount() == 1) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            extract($row);
            $user_item = array(
                "id" => $id,
                "mail" => $mail,
                "password" => $password,
                "username" => $username
            );
            http_response_code(200);
            echo json_encode($user_item);
        } else {
            http_response_code(404);
            echo json_encode(array("message" => "User not found."));
        }
    }

    public function createUser()
    {
        $data = json_decode(file_get_contents("php://input"));

        $user = new User($this->db);
        $user->mail = $data->mail;
        $user->password = $data->password;
        $user->username = $data->username;

        if ($user->create()) {
            http_response_code(201);
            echo json_encode(array("message" => "User created."));
        } else {
            http_response_code(503);
            echo json_encode(array("message" => "Unable to create user."));
        }
    }

    public function updateUser($id)
    {
        $data = json_decode(file_get_contents("php://input"));

        $user = new User($this->db);
        $user->id = $id;
        $user->mail = $data->mail;
        $user->password = $data->password;
        $user->username = $data->username;

        if ($user->update()) {
            http_response_code(200);
            echo json_encode(array("message" => "User updated."));
        } else {
            http_response_code(503);
            echo json_encode(array("message" => "Unable to update user."));
        }
    }

    public function deleteUser($id)
    {
        $user = new User($this->db);
        $user->id = $id;

        if ($user->delete()) {
            http_response_code(200);
            echo json_encode(array("message" => "User deleted."));
        } else {
            http_response_code(503);
            echo json_encode(array("message" => "Unable to delete user."));
        }
    }

    private function notFoundResponse()
    {
        http_response_code(404);
        echo json_encode(array("message" => "Not Found"));
    }
}

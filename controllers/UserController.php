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
                    "id_user" => $id_user,
                    "mail_user" => $mail_user,
                    "pwd_user" => $pwd_user,
                    "username_user" => $username_user
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
        $user->id_user = $id;
        $stmt = $user->read();

        if ($stmt->rowCount() == 1) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            extract($row);
            $user_item = array(
                "id_user" => $id_user,
                "mail_user" => $mail_user,
                "pwd_user" => $pwd_user,
                "username_user" => $username_user
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
        $user->mail_user = $data->mail_user;
        $user->pwd_user = $data->pwd_user;
        $user->username_user = $data->username_user;

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
        $user->id_user = $id;
        $user->mail_user = $data->mail_user;
        $user->pwd_user = $data->pwd_user;
        $user->username_user = $data->username_user;

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
        $user->id_user = $id;

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

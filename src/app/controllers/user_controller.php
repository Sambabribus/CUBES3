<?php
namespace src\app\controllers;

require_once '../app/models/database.php';
require_once '../app/services/user_service.php';

use src\app\models\Database;
use src\app\models\User;
use src\app\services\user_service;

class user_controller
{
    private user_service $userService;

    public function __construct()
    {
        $database = new Database();
        $this->userService = new user_service($database);
    }

    public function login(string $login, string $password): ?User
    {
        return $this->userService->login($login, $password);
    }

    public function logout()
    {
    }

    public function sign_up(string $username, string $password, string $email): ?User
    {
        return $this->userService->sign_up($username, $password, $email);
    }

    public function update()
    {
    }

    public function delete()
    {
    }
}
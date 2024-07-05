<?php
#region Setup and Imports
namespace src\app\controllers;

require_once '../app/models/database.php';
require_once '../app/services/user_service.php';

use src\app\models\Database;
use src\app\models\User;
use src\app\services\user_service;
#endregion

class user_controller
{
    #region Properties
    private user_service $userService;
    #endregion

    #region Constructor
    public function __construct()
    {
        $database = new Database();
        $this->userService = new user_service($database);
    }
    #endregion

    #region Login Function
    public function login(string $login, string $password): ?User
    {
        return $this->userService->login($login, $password);
    }
    #endregion

    #region Logout Function
    public function logout()
    {
    }
    #endregion

    #region Sign Up Function
    public function sign_up(string $username, string $password, string $email): ?User
    {
        return $this->userService->sign_up($username, $password, $email);
    }
    #endregion

    #region Update Function
    public function update()
    {
    }
    #endregion

    #region Delete Function
    public function delete(int $id)
    {
        return $this->userService->delUser($id);
    }
    #endregion

    #region Get All Users Function
    public function getAll()
    {
        return $this->userService->getAllUser();
    }
    #endregion
}
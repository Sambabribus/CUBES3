<?php
#region Setup and Imports
// Définition de l'espace de noms et importation des classes nécessaires pour le contrôleur.
namespace src\app\controllers;
require_once "../app/models/database.php";
require_once "../app/services/user_service.php";
use src\app\models\Database;
use src\app\models\User;
use src\app\services\user_service;
#endregion

class user_controller
{
    #region Properties
    // Déclaration d'une propriété pour le service utilisateur.
    private user_service $userService;
    #endregion

    #region Constructor
    // Constructeur qui initialise le service utilisateur avec une instance de la base de données.
    public function __construct()
    {
        $database = new Database();
        $this->userService = new user_service($database);
    }
    #endregion

    #region Login Function
    // Méthode pour gérer la connexion d'un utilisateur.
    public function login(string $login, string $password): ?User
    {
        return $this->userService->login($login, $password);
    }
    #endregion

    #region Logout Function
    // Méthode pour gérer la déconnexion d'un utilisateur (actuellement vide).
    public function logout()
    {
    }
    #endregion

    #region Sign Up Function
    // Méthode pour gérer l'inscription d'un nouvel utilisateur.
    public function sign_up(
        string $username,
        string $password,
        string $email
    ): ?User {
        return $this->userService->sign_up($username, $password, $email);
    }
    #endregion

    #region Update Function
    // Méthode pour mettre à jour les informations d'un utilisateur (actuellement vide).
    final public function update($id, $username, $email, $password): ?User
    {
        return $this->userService->update($id, $username, $email, $password);
    }
    #endregion

    #region Delete Function
    // Méthode pour supprimer un utilisateur par son ID.
    public function delete(int $id)
    {
        return $this->userService->delUser($id);
    }
    #endregion

    public function getOne(int $id): ?User
    {
        return $this->userService->getUser($id);
    }

    #region Get All Users Function
    // Méthode pour récupérer tous les utilisateurs.
    public function getAll()
    {
        return $this->userService->getAllUser();
    }
    #endregion
}

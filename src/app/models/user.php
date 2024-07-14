<?php
#region Namespace and Imports
// Définit l'espace de noms pour le modèle User et importe les dépendances nécessaires.
namespace src\app\models;
require "../../vendor/autoload.php";
#endregion

class User
{
    #region Properties
    private int $id;
    private string $username;
    private string $pwd;
    private string $mail;
    private bool $isadmin;
    #endregion

    #region ID User Accessors
    // Accesseurs pour l'identifiant de l'utilisateur.
    public function get_id_user(): int
    {
        return $this->id;
    }
    public function set_id_user($id): User
    {
        $this->id = $id;
        return $this;
    }
    #endregion

    #region Username User Accessors
    // Accesseurs pour le nom d'utilisateur.
    public function get_username_user(): string
    {
        return $this->username;
    }
    public function set_username_user($username): User
    {
        $this->username = $username;
        return $this;
    }
    #endregion

    #region Password User Accessors
    // Accesseurs pour le mot de passe de l'utilisateur.
    public function get_pwd_user(): string
    {
        return $this->pwd;
    }
    public function set_pwd_user($pwd): User
    {
        $this->pwd = $pwd;
        return $this;
    }
    #endregion

    #region Mail User Accessors
    // Accesseurs pour l'adresse e-mail de l'utilisateur.
    public function get_mail_user(): string
    {
        return $this->mail; // Retourne l'adresse e-mail de l'utilisateur.
    }
    public function set_mail_user($mail): User
    {
        $this->mail = $mail;
        return $this;
    }
    #endregion

    #region IsAdmin User Accessors
    // Accesseurs pour le statut d'administrateur de l'utilisateur.
    public function get_isadmin_user(): bool
    {
        return $this->isadmin;
    }
    public function set_isadmin_user($isadmin): User
    {
        $this->isadmin = $isadmin;
        return $this;
    }
    #endregion
}

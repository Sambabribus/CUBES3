<?php
#region Namespace and Imports
// Définit l'espace de noms pour le modèle User et importe les dépendances nécessaires.
namespace src\app\models;
require "../../vendor/autoload.php";
#endregion

class User
{
    #region Properties
    private int $id_user;
    private string $username_user;
    private string $pwd_user;
    private string $mail_user;
    private bool $isadmin_user;
    #endregion

    #region ID User Accessors
    // Accesseurs pour l'identifiant de l'utilisateur.
    public function get_id_user(): int
    {
        return $this->id_user;
    }
    public function set_id_user($id_user): User
    {
        $this->id_user = $id_user;
        return $this;
    }
    #endregion

    #region Username User Accessors
    // Accesseurs pour le nom d'utilisateur.
    public function get_username_user(): string
    {
        return $this->username_user;
    }
    public function set_username_user($username_user): User
    {
        $this->username_user = $username_user;
        return $this;
    }
    #endregion

    #region Password User Accessors
    // Accesseurs pour le mot de passe de l'utilisateur.
    public function get_pwd_user(): string
    {
        return $this->pwd_user;
    }
    public function set_pwd_user($pwd_user): User
    {
        $this->pwd_user = $pwd_user;
        return $this;
    }
    #endregion

    #region Mail User Accessors
    // Accesseurs pour l'adresse e-mail de l'utilisateur.
    public function get_mail_user(): string
    {
        return $this->mail_user; // Retourne l'adresse e-mail de l'utilisateur.
    }
    public function set_mail_user($mail_user): User
    {
        $this->mail_user = $mail_user;
        return $this;
    }
    #endregion

    #region IsAdmin User Accessors
    // Accesseurs pour le statut d'administrateur de l'utilisateur.
    public function get_isadmin_user(): bool
    {
        return $this->isadmin_user;
    }
    public function set_isadmin_user($isadmin_user): User
    {
        $this->isadmin_user = $isadmin_user;
        return $this;
    }
    #endregion
}

<?php
#region Imports
//
namespace src\app\services;
require_once "../app/models/user.php";
require_once "../app/models/database.php";
use PDOException;
use src\app\models\Database;
use src\app\models\User;
#endregion

class user_service
{
    #region Properties
    // Propriété pour la base de données.
    private Database $db;
    #endregion

    #region Constructor
    // Constructeur de la classe UserService.
    public function __construct(Database $db)
    {
        $this->db = $db;
    }
    #endregion

    #region login Function
    // Fonction pour se connecter.
    public function login(string $username, string $password): ?User
    {
        try {
            $this->db->query("SELECT * FROM users WHERE mail = ?");
            $userResult = $this->db->single([$username]);
            $output = new User();
            $output
                ->set_id_user($userResult["id"])
                ->set_username_user($userResult["username"])
                ->set_mail_user($userResult["mail"])
                ->set_pwd_user($userResult["password"])
                ->set_isadmin_user($userResult["isadmin"]);
            return $output;
        } catch (PDOException $e) {
            return $output;
        }
    }
    #endregion

    #region sign_up Function
    // Fonction pour s'inscrire.
    public function sign_up(
        string $username,
        string $password,
        string $mail,
        string $isadmin
    ): ?User {
        try {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $this->db->query(
                "INSERT INTO users (mail, password, username, isadmin) VALUES (?, ?, ?, ?)"
            );
            $this->db->execute([$mail, $hashedPassword, $username, $isadmin]);
            $this->db->query("SELECT * FROM users WHERE mail = ?");
            $userResult = $this->db->single([$mail]);
            $output = new User();
            $output
                ->set_id_user($userResult["id"])
                ->set_username_user($userResult["username"])
                ->set_mail_user($userResult["mail"])
                ->set_pwd_user($userResult["password"])
                ->set_isadmin_user($userResult["isadmin"]);
            return $output;
        } catch (PDOException $e) {
            return null;
        }
    }
    #endregion

    #region getAllUser Function
    // Fonction pour obtenir tous les utilisateurs.
    public function getAllUser(): array
    {
        try {
            $this->db->query(
                "SELECT username, mail, id, isadmin from users"
            );
            return $this->db->resultSet();
        } catch (PDOException $e) {
            throw new PDOException(
                "Error, no users was found. " . $e->getMessage()
            );
        }
    }
    #endregion

    #region getUser Function
    public function getUser(int $id): ?User
    {
        try {
            $this->db->query("SELECT * FROM users WHERE id = ?");
            $userResult = $this->db->single([$id]);
            $output = new User();
            $output
                ->set_username_user($userResult["username"])
                ->set_mail_user($userResult["mail"])
                ->set_pwd_user($userResult["password"]);
            return $output;
            
        } catch (PDOException $e) {
            throw new PDOException(
                "Error, no user were updated" . $e->getMessage()
            );
        }
    }
    #endregion

    #region delUser Function
    // Fonction pour supprimer un utilisateur.
    public function delUser(int $id)
    {
        try {
            $this->db->query("DELETE FROM users WHERE id = :id");
            $this->db->execute([":id" => $id]);
            return true;
        } catch (PDOException $e) {
            throw new PDOException(
                "Error, no recipe were deleted. " . $e->getMessage()
            );
        }
    }
    #endregion
    
    #region update Function
    final public function update(int $id, string $username, string $mail, string $password): ?User
    {
        try {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $this->db->query(
                "UPDATE users SET username = ?, mail = ?, password = ? WHERE id = ?"
            );
            $this->db->execute([$username, $mail, $hashedPassword, $id]);
            $this->db->query("SELECT * FROM users WHERE mail = ?");
            $userResult = $this->db->single([$mail]);
            $output = new User();
            $output
                ->set_username_user($userResult["username"])
                ->set_mail_user($userResult["mail"])
                ->set_pwd_user($userResult["password"]);
            return $output;
            
        } catch (PDOException $e) {
            throw new PDOException(
                "Error, no user were updated" . $e->getMessage()
            );
        }
    }
    #endregion
    
}

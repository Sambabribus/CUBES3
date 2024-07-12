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
            $this->db->query("SELECT * FROM user WHERE mail_user = ?");
            $userResult = $this->db->single([$username]);
            $output = new User();
            $output
                ->set_id_user($userResult["id_user"])
                ->set_username_user($userResult["username_user"])
                ->set_mail_user($userResult["mail_user"])
                ->set_pwd_user($userResult["pwd_user"])
                ->set_isadmin_user($userResult["isadmin_user"]);
            return $output;
        } catch (PDOException $e) {
            return null;
        }
    }
    #endregion

    #region sign_up Function
    // Fonction pour s'inscrire.
    public function sign_up(
        string $username,
        string $password,
        string $email
    ): ?User {
        try {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $this->db->query(
                "INSERT INTO user (mail_user, pwd_user, username_user) VALUES (?, ?, ?)"
            );
            $this->db->execute([$email, $hashedPassword, $username]);
            $this->db->query("SELECT * FROM user WHERE mail_user = ?");
            $userResult = $this->db->single([$email]);
            $output = new User();
            $output
                ->set_id_user($userResult["id_user"])
                ->set_username_user($userResult["username_user"])
                ->set_mail_user($userResult["mail_user"])
                ->set_pwd_user($userResult["pwd_user"]);
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
                "SELECT username_user, mail_user, id_user, isadmin_user from user"
            );
            return $this->db->resultSet();
        } catch (PDOException $e) {
            throw new PDOException(
                "Error, no users was found. " . $e->getMessage()
            );
        }
    }
    #endregion

    public function getUser(int $id): ?User
    {
        try {
            $this->db->query("SELECT * FROM user WHERE id_user = ?");
            $userResult = $this->db->single([$id]);
            $output = new User();
            $output
                ->set_username_user($userResult["username_user"])
                ->set_mail_user($userResult["mail_user"])
                ->set_pwd_user($userResult["pwd_user"]);
            return $output;
            
        } catch (PDOException $e) {
            throw new PDOException(
                "Error, no user were updated" . $e->getMessage()
            );
        }
    }

    #region delUser Function
    // Fonction pour supprimer un utilisateur.
    public function delUser(int $id)
    {
        try {
            $this->db->query("DELETE FROM user WHERE id_user = :id");
            $this->db->execute([":id" => $id]);
            return true;
        } catch (PDOException $e) {
            throw new PDOException(
                "Error, no recipe were deleted. " . $e->getMessage()
            );
        }
    }
    #endregion
    final public function update(int $id, string $username, string $mail_user, string $password): ?User
    {
        try {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $this->db->query(
                "UPDATE user SET username_user = ?, mail_user = ?, pwd_user = ? WHERE id_user = ?"
            );
            $this->db->execute([$username, $mail_user, $hashedPassword, $id]);
            $this->db->query("SELECT * FROM user WHERE mail_user = ?");
            $userResult = $this->db->single([$mail_user]);
            $output = new User();
            $output
                ->set_username_user($userResult["username_user"])
                ->set_mail_user($userResult["mail_user"])
                ->set_pwd_user($userResult["pwd_user"]);
            return $output;
            
        } catch (PDOException $e) {
            throw new PDOException(
                "Error, no user were updated" . $e->getMessage()
            );
        }
    }
    
    
}

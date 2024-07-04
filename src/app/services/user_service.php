<?php
namespace src\app\services;

require_once '../app/models/user.php';
require_once '../app/models/database.php';

use PDOException;
use src\app\models\Database;
use src\app\models\User;

class user_service
{
    private Database $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function login(string $username, string $password): ?User
    {
        try {
            $this->db->query("SELECT * FROM user WHERE mail_user = ?");
            $userResult = $this->db->single([$username]);

            $output = new User();
            $output
                ->set_id_user($userResult['id_user'])
                ->set_username_user($userResult['username_user'])
                ->set_mail_user($userResult['mail_user'])
                ->set_pwd_user($userResult['pwd_user'])
                ->set_isadmin_user($userResult['isadmin_user']);

            return $output;
        } catch (PDOException $e) {
            return null;
        }
    }

    public function sign_up(string $username, string $password, string $email): ?User {
        try {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $this->db->query("INSERT INTO user (mail_user, pwd_user, username_user) VALUES (?, ?, ?)");
            $this->db->execute([$email, $hashedPassword, $username]);

            $this->db->query("SELECT * FROM user WHERE mail_user = ?");
            $userResult = $this->db->single([$email]);

            $output = new User();
            $output
                ->set_id_user($userResult['id_user'])
                ->set_username_user($userResult['username_user'])
                ->set_mail_user($userResult['mail_user'])
                ->set_pwd_user($userResult['pwd_user']);

                return $output;
        } catch (PDOException $e) {
            return null;
        }
    }

    public function getAllUser(): array {
        try { 
            $this->db->query("SELECT username_user, mail_user, id_user, isadmin_user from user");
            return $this->db->resultSet();
        } catch (PDOException $e) {
            throw new PDOException("Error, no users was found. " . $e->getMessage());
        }
    }

    public function delUser(int $id) {
        try {
            $this->db->query("DELETE FROM user WHERE id_user = :id");
            $this->db->execute([':id' => $id]);
            return true;
        } catch (PDOException $e) {
            throw new PDOException("Error, no recipe were deleted. " . $e->getMessage());
        }
}
}
<?php
namespace src\app\models;

require '../../vendor/autoload.php';

class User {
    private int $id_user;
    private string $username_user;
    private string $pwd_user;
    private string $mail_user;
    private bool $isadmin_user;

    public function get_id_user(): int {
        return $this->id_user;
    }

    public function set_id_user($id_user): User {
        $this->id_user = $id_user;
        return $this;
    }

    public function get_username_user(): string {
        return $this->username_user;
    }

    public function set_username_user($username_user): User {
        $this->username_user = $username_user;
        return $this;
    }

    public function get_pwd_user(): string {
        return $this->pwd_user;
    }

    public function set_pwd_user($pwd_user): User {
        $this->pwd_user = $pwd_user;

        return $this;
    }

    public function get_mail_user(): string {
        return $this->mail_user;
    }

    public function set_mail_user($mail_user): User {
        $this->mail_user = $mail_user;
        return $this;
    }

    public function get_isadmin_user(): bool {
        return $this->isadmin_user;
    }

    public function set_isadmin_user($isadmin_user): User {
        $this->isadmin_user = $isadmin_user;
        return $this;
    }
}
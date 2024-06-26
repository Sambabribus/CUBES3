<?php
class User
{
    private $conn;
    private $table_name = "user";

    public $id_user;
    public $mail_user;
    public $pwd_user;
    public $username_user;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function read_all()
    {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function read()
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id_user = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id_user);
        $stmt->execute();
        return $stmt;
    }

    public function create()
    {
        $query = "INSERT INTO " . $this->table_name . " SET mail_user=:mail_user, pwd_user=:pwd_user, username_user=:username_user";
        $stmt = $this->conn->prepare($query);

        $this->mail_user = htmlspecialchars(strip_tags($this->mail_user));
        $this->pwd_user = htmlspecialchars(strip_tags($this->pwd_user));
        $this->username_user = htmlspecialchars(strip_tags($this->username_user));

        $stmt->bindParam(":mail_user", $this->mail_user);
        $stmt->bindParam(":pwd_user", $this->pwd_user);
        $stmt->bindParam(":username_user", $this->username_user);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function update()
    {
        $query = "UPDATE " . $this->table_name . " SET mail_user=:mail_user, pwd_user=:pwd_user, username_user=:username_user WHERE id_user = :id_user";
        $stmt = $this->conn->prepare($query);

        $this->id_user = htmlspecialchars(strip_tags($this->id_user));
        $this->mail_user = htmlspecialchars(strip_tags($this->mail_user));
        $this->pwd_user = htmlspecialchars(strip_tags($this->pwd_user));
        $this->username_user = htmlspecialchars(strip_tags($this->username_user));

        $stmt->bindParam(":id_user", $this->id_user);
        $stmt->bindParam(":mail_user", $this->mail_user);
        $stmt->bindParam(":pwd_user", $this->pwd_user);
        $stmt->bindParam(":username_user", $this->username_user);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function delete()
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id_user = :id_user";
        $stmt = $this->conn->prepare($query);

        $this->id_user = htmlspecialchars(strip_tags($this->id_user));
        $stmt->bindParam(":id_user", $this->id_user);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}

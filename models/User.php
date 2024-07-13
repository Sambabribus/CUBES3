<?php
class User
{
    private $conn;
    private $table_name = "users";

    public $id;
    public $mail;
    public $password;
    public $username;

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
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        return $stmt;
    }

    public function create()
    {
        $query = "INSERT INTO " . $this->table_name . " SET mail=:mail, password=:password, username=:username";
        $stmt = $this->conn->prepare($query);

        $this->mail = htmlspecialchars(strip_tags($this->mail));
        $this->password = htmlspecialchars(strip_tags($this->password));
        $this->username = htmlspecialchars(strip_tags($this->username));

        $stmt->bindParam(":mail", $this->mail);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":username", $this->username);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function update()
    {
        $query = "UPDATE " . $this->table_name . " SET mail=:mail, password=:password, username=:username WHERE id= :id";
        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->mail = htmlspecialchars(strip_tags($this->mail));
        $this->password = htmlspecialchars(strip_tags($this->password));
        $this->username = htmlspecialchars(strip_tags($this->username));

        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":mail", $this->mail);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":username", $this->username);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function delete()
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(":id", $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}

<?php
class Recipe
{
    private $conn;
    private $table_name = "recipes";

    public $id;
    public $title;
    public $description;
    public $prep_time;
    public $cook_time;
    public $serves;
    public $creation_date;
    public $user_id;

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
        $query = "INSERT INTO " . $this->table_name . " SET title=:title, description=:description, prep_time=:prep_time, cook_time=:cook_time, serves=:serves, creation_date=:creation_date, user_id=:user_id";
        $stmt = $this->conn->prepare($query);

        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->prep_time = htmlspecialchars(strip_tags($this->prep_time));
        $this->cook_time = htmlspecialchars(strip_tags($this->cook_time));
        $this->serves = htmlspecialchars(strip_tags($this->serves));
        $this->creation_date = htmlspecialchars(strip_tags($this->creation_date));
        $this->user_id = htmlspecialchars(strip_tags($this->user_id));

        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":prep_time", $this->prep_time);
        $stmt->bindParam(":cook_time", $this->cook_time);
        $stmt->bindParam(":serves", $this->serves);
        $stmt->bindParam(":creation_date", $this->creation_date);
        $stmt->bindParam(":user_id", $this->user_id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function update()
    {
        $query = "UPDATE " . $this->table_name . " SET title=:title, description=:description, prep_time=:prep_time, cook_time=:cook_time, serves=:serves, creation_date=:creation_date, user_id=:user_id WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->prep_time = htmlspecialchars(strip_tags($this->prep_time));
        $this->cook_time = htmlspecialchars(strip_tags($this->cook_time));
        $this->serves = htmlspecialchars(strip_tags($this->serves));
        $this->creation_date = htmlspecialchars(strip_tags($this->creation_date));
        $this->user_id = htmlspecialchars(strip_tags($this->user_id));

        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":prep_time", $this->prep_time);
        $stmt->bindParam(":cook_time", $this->cook_time);
        $stmt->bindParam(":serves", $this->serves);
        $stmt->bindParam(":creation_date", $this->creation_date);
        $stmt->bindParam(":user_id", $this->user_id);

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

    public function get_image()
    {
        $query = "SELECT file_path FROM images WHERE recipe_id = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        $image = $stmt->fetch(PDO::FETCH_ASSOC);
        return isset($image['file_path']) ? $image['file_path'] : "";
    }
}

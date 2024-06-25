<?php

class Recette
{
    private $conn;
    private $table = 'recettes';

    public $id;
    public $titre;
    public $description;
    public $temps_preparation;
    public $temps_cuisson;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function read()
    {
        $query = 'SELECT * FROM ' . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function read_single()
    {
        $query = 'SELECT * FROM ' . $this->table . ' WHERE id = ? LIMIT 1';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create()
    {
        $query = 'INSERT INTO ' . $this->table . ' SET titre = :titre, description = :description, temps_preparation = :temps_preparation, temps_cuisson = :temps_cuisson';
        $stmt = $this->conn->prepare($query);

        $this->titre = htmlspecialchars(strip_tags($this->titre));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->temps_preparation = htmlspecialchars(strip_tags($this->temps_preparation));
        $this->temps_cuisson = htmlspecialchars(strip_tags($this->temps_cuisson));

        $stmt->bindParam(':titre', $this->titre);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':temps_preparation', $this->temps_preparation);
        $stmt->bindParam(':temps_cuisson', $this->temps_cuisson);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function update()
    {
        $query = 'UPDATE ' . $this->table . ' SET titre = :titre, description = :description, temps_preparation = :temps_preparation, temps_cuisson = :temps_cuisson WHERE id = :id';
        $stmt = $this->conn->prepare($query);

        $this->titre = htmlspecialchars(strip_tags($this->titre));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->temps_preparation = htmlspecialchars(strip_tags($this->temps_preparation));
        $this->temps_cuisson = htmlspecialchars(strip_tags($this->temps_cuisson));
        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(':titre', $this->titre);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':temps_preparation', $this->temps_preparation);
        $stmt->bindParam(':temps_cuisson', $this->temps_cuisson);
        $stmt->bindParam(':id', $this->id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function delete()
    {
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';
        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(':id', $this->id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
}

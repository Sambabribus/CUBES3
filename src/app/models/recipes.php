<?php
namespace src\app\models;

use PDOException;

class Recipe {
    private int $id;
    private string $title;
    private string $description;
    private $cooking_time;
    private $preparation_time;
    private $serves;
    private $url_image;
    private Database $db;

    public function __construct(Database $conn) {
        $this->db = $conn;
    }

    public function getId() {
        return $this->id;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getCookingTime() {
        return $this->cooking_time;
    }

    public function getPreparationTime() {
        return $this->preparation_time;
    }

    public function getServes() {
        return $this->serves;
    }

    public function getUrlImage() {
        return $this->url_image;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function setCookingTime($cooking_time) {
        $this->cooking_time = $cooking_time;
    }

    public function setPreparationTime($preparation_time) {
        $this->preparation_time = $preparation_time;
    }

    public function setServes($serves) {
        $this->serves = $serves;
    }

    public function setUrlImage($url_image) {
        $this->url_image = $url_image;
    }

    final public function getRecipe($id) {
        try {
            $this->db->query("SELECT * FROM recipes WHERE id = :id");
            return $this->db->single([$id]);
        } catch (PDOException $e) {
            throw new PDOException("Error, no recipe here was found. " . $e->getMessage());
        } 
    }

    final public function getAllRecipes() {
        try {
            $this->db->query("SELECT * FROM recipes");
            return $this->db->resultSet();
        } catch (PDOException $e) {
            throw new PDOException("Error, no recipe was found. " . $e->getMessage());
        }
    }

    final public function createRecipe(){
        try {
            $this->db->query("INSERT INTO recipes (title, description, preparation_time, cooking_time, serves, creation_date, user_id) VALUES (?, ?, ?, ?, ?, NOW(), ?)");
            $this->db->execute([$this->title, $this->description, $this->preparation_time, $this->cooking_time, $this->serves, $this->user_id]);
            return true;
        } catch (PDOException $e) {
            throw new PDOException("Error, no recipe were created. " . $e->getMessage());
        }
    }

    
    final public function deleteRecipe($id){
        try {
            $this->db->query("DELETE FROM recipes WHERE id = :id");
            $this->db->execute([':id' => $id]); // Corrected to use associative array
            return true;
        } catch (PDOException $e) {
            throw new PDOException("Error, no recipe were deleted. " . $e->getMessage());
        }
    }

    final public function updateRecipe($id){
        try {
            $this->db->query("UPDATE recipes SET title = ?, description = ?, preparation_time = ?, cooking_time = ?, serves = ? WHERE id = :id");
            $this->db->execute([$this->title, $this->description, $this->preparation_time, $this->cooking_time, $this->serves, $id]);
            return true;
        } catch (PDOException $e) {
            throw new PDOException("Error, no recipe were updated" . $e->getMessage());
        }
    }

    final public function getMainRecipes(){
        try {
            $this->db->query("SELECT * FROM recipes ORDER BY creation_date DESC LIMIT 6");
            return $this->db->resultSet();
        } catch (PDOException $e) {
            throw new PDOException("Error, no recipe was found. " . $e->getMessage());
        }        
    }
}
<?php
namespace src\app\services;

use src\app\models\Recipe;
use src\app\models\Database;
use PDOException;
use PDO;

class RecipeService {
    private Database $db;

    public function __construct(Database $db) {
        $this->db = $db;
    }

    final public function getById(int $id): Recipe {
        try {
            $this->db->query("SELECT * FROM recipes WHERE id = :id");
            return $this->db->single([$id]);
        } catch (PDOException $e) {
            throw new PDOException("Error, no recipe here was found. " . $e->getMessage());
        } 
    }

    final public function getAll(): array{
        try {
            $this->db->query("SELECT * FROM recipes");
            return $this->db->resultSet();
        } catch (PDOException $e) {
            throw new PDOException("Error, no recipe was found. " . $e->getMessage());
        }
    }

    final public function create(Recipe $data): bool {
        try {
            $this->db->query("INSERT INTO recipes (title, description, preparation_time, cooking_time, serves, creation_date, user_id) VALUES (?, ?, ?, ?, ?, NOW(), ?)");
            $this->db->execute([$data->title, $data->description, $data->preparation_time, $data->cooking_time, $data->serves, $data->user_id]);
            return true;
        } catch (PDOException $e) {
            throw new PDOException("Error, no recipe were created. " . $e->getMessage());
        }
    }

    
    final public function delete(int $id): bool {
        try {
            $this->db->query("DELETE FROM recipes WHERE id = :id");
            $this->db->execute([':id' => $id]); // Corrected to use associative array
            return true;
        } catch (PDOException $e) {
            throw new PDOException("Error, no recipe were deleted. " . $e->getMessage());
        }
    }

    final public function update(int $id, Recipe $data): bool {
        try {
            $this->db->query("UPDATE recipes SET title = ?, description = ?, preparation_time = ?, cooking_time = ?, serves = ? WHERE id = :id");
            $this->db->execute([$data->title, $data->description, $data->preparation_time, $data->cooking_time, $data->serves, $id]);
            return true;
        } catch (PDOException $e) {
            throw new PDOException("Error, no recipe were updated" . $e->getMessage());
        }
    }

    final public function getLimitOrderByCreateDate(int $limit): array {
        try {
            $this->db->query("SELECT * FROM recipes ORDER BY creation_date DESC LIMIT ?");
            return $this->db->resultSet([$limit]);
        } catch (PDOException $e) {
            throw new PDOException("Error, no recipe was found. " . $e->getMessage());
        }
    }

    public final function filterByTitleOrDescription(string $data): Array {
        $searchResults = [];

        try  {
            $data = '%' . $data . '%';
            $this->db->query("SELECT recipes.id, title, description, cooking_time, preparation_time, serves, images.url_image FROM recipes LEFT JOIN images ON recipes.id = images.recipe_id WHERE recipes.title LIKE ? OR recipes.description LIKE ?");
            $results = $this->db->resultSet([$data, $data]);

            foreach($results as $row) {
                $recipe = new Recipe();
                $recipe
                    ->setId($row['id'])
                    ->setTitle($row["title"])
                    ->setDescription($row["description"])
                    ->setCookingTime($row["cooking_time"])
                    ->setPreparationTime($row["preparation_time"])
                    ->setServes($row["serves"])
                    ->setUrlImage($row["url_image"]);

                    $searchResults[] = $recipe;
            }
        } catch (PDOException $e) {
            throw new PDOException("Error, no recipe was found. " . $e->getMessage());
        }

        return $searchResults;
    }
}

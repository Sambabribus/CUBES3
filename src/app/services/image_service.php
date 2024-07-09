<?php

namespace src\app\services;

use DateTime;
use Exception;
use src\FileManager;
use src\app\models\Recipe;
use src\app\models\Image;
use src\app\models\Database;
use PDOException;

class ImageService
{
    public const DIR_PATH = "uploads/";

    private Database $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    final public function getById(int $id): Image
    {
        try {
            $this->db->query("SELECT * FROM image WHERE id = :id");
            $imageResult = $this->db->single([$id]);
            $output = new Image();
            $output
                ->setId($imageResult["id"])
                ->setFileName($imageResult["file_name"])
                ->setCreationDate(new DateTime($imageResult["creation_date"]))
                ->setExtension($imageResult["extension"])
                ->setMimeType($imageResult["mime_type"])
                ->setRecipeId($imageResult["recipe_id"]);

            return $output;
        } catch (PDOException $e) {
            throw new PDOException(
                "Error, no image was found. " . $e->getMessage()
            );
        }
    }

    final public function post(int $recipe_id, string $file_name, string $tmp_file_name, string $extension, string $mime_type): ?Image
    {
        try {
            // BDD -> Chck si fichier exist
            // Si existe, return false ou autre (throw)
            // Sinon, enregistre le fichier + suite de la query
            $this->db->query("SELECT count(id) FROM image WHERE file_name = :file_name");
            // If file does not exists if database, write it and add it to database 
            if ($this->db->single([$file_name])["count(id)"] == 0) {
                $filecontent = file_get_contents($tmp_file_name);
                $file_path = FileManager::rootDirectory() . ImageService::DIR_PATH . $file_name . "." . $extension;
                $myfile = fopen($file_path, "w");
                fwrite($myfile, $filecontent);
                fclose($myfile);

                $this->db->query("INSERT INTO image (recipe_id, file_name, extension, mime_type) VALUES (?, ?, ?, ?)");
                $this->db->execute([$recipe_id, $file_name, $extension, $mime_type]);

                $insertedImageId = $this->db->lastInsertId();
                $this->db->query("SELECT * FROM image WHERE id = :id");
                $imageResult = $this->db->single([$insertedImageId]);
                $output = new Image();
                $output
                    ->setId($imageResult["id"])
                    ->setFileName($imageResult["file_name"])
                    ->setCreationDate(new DateTime($imageResult["creation_date"]))
                    ->setExtension($imageResult["extension"])
                    ->setMimeType($imageResult["mime_type"])
                    ->setRecipeId($imageResult["recipe_id"]);
                return $output;
            } else {
                return null;
            }
        } catch (PDOException $e) {
            throw new PDOException(
                "Error, no image was uploaded. " . $e->getMessage()
            );
        }
    }

    /**
     * Get Image instances with their Content
     * @return array<Image>
     */
    final public function getByRecipeId(int $recipe_id): array 
    {
        try {
            $this->db->query("SELECT * FROM image WHERE recipe_id = :recipe_id");
            $images = $this->db->resultSet([$recipe_id]);

            $output = [];

            foreach($images as $row) {
                $image = new Image();
                $image
                    ->setId($row["id"])
                    ->setFileName($row["file_name"])
                    ->setCreationDate(new DateTime($row["creation_date"]))
                    ->setExtension($row["extension"])
                    ->setMimeType($row["mime_type"])
                    ->setRecipeId($row["recipe_id"]);

                $output[] = $image;
            }

            return $output;
        } catch (PDOException $e) {
            throw new PDOException(
                "Error, no image was uploaded. " . $e->getMessage()
            );
        }
    }

    final public function delete(int $id): bool
    {
        return false;
    }
}
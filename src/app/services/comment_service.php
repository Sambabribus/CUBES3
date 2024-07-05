<?php
namespace src\app\services;

require_once '../app/models/user.php';
require_once '../app/models/database.php';
require_once '../app/models/comment.php';

use src\app\models\Recipe;
use src\app\models\Database;
use src\app\models\Comment;
use PDOException;
use src\app\models\User;

class comment_service {

    private Database $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function get_comment_by_recipe_id(int $recipe_id, int $limit): ?array
    {
        $comResults = [];
        try {
            $this->db->query("SELECT * FROM comment WHERE recipe_id_comment = :recipe_id ORDER BY creat_date_comment DESC LIMIT :limit");
            $results = $this->db->resultSet([$recipe_id, $limit]);

            foreach ($results as $row) {
                $comment = new Comment();
                $comment
                    ->setcomComment($row["com_comment"])
                    ->setUserIdComment($row["user_id_comment"])
                    ->setRecipeIdComment($row["recipe_id_comment"]);
            
                    $comResults[] = $comment;
                }
        } catch (PDOException $e) {
            throw new PDOException("Error, no comment was found. " . $e->getMessage());
        }
        return $comResults;
    }

    public function post_comment(Comment $data, $user_id, $recipe_id): bool{
        try {
            $this->db->query("INSERT INTO comment (user_id_comment, recipe_id_comment, com_comment) VALUES (?, ?, ?)");
            $this->db->execute([$user_id, $recipe_id, $data->getcomComment()]);
            return true;
        }   catch (PDOException $e) {
            throw new PDOException("No Comment was created". $e->getMessage());
        }
    }

    public function delete_comment($id_comment) {
        try {
            $this->db->query("DELETE FROM comment WHERE id_comment = :id");
            $this->db->execute([$id_comment]);
            return true;
        } catch (PDOException $e) {
            throw new PDOException("". $e->getMessage());
        }
    }

    public function update_comment(Comment $data, $id_comment) {
        try {
            $this->db->query("UPDATE comment SET com_comment = ? WHERE id_comment = :id");
            $this->db->execute([$data->com_comment,$id_comment]);
            return true;
        } catch (PDOException $e) {
            throw new PDOException("". $e->getMessage());
        }
    }
}
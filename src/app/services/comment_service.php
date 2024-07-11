<?php

#region Imports
// Définit l'espace de noms pour le service de commentaires et importe les dépendances nécessaires.
namespace src\app\services;
require_once "../app/models/user.php";
require_once "../app/models/database.php";
require_once "../app/models/comment.php";
use src\app\models\Recipe;
use src\app\models\Database;
use src\app\models\Comment;
use PDOException;
use src\app\models\User;
#endregion

class comment_service
{
    #region Properties
    // Propriété pour la base de données.
    private Database $db;
    #endregion

    #region Constructor
    public function __construct(Database $db)
    {
        $this->db = $db;
    }
    #endregion

    #region Get Comments by Recipe ID
    /**
     * Fonction pour obtenir les commentaires par identifiant de recette.
     * @return array<Comment>
     */
    public function get_comment_by_recipe_id(int $recipe_id, int $limit): ?array
    {
        $comResults = [];
        try {
            $this->db->query(
                "SELECT * FROM comment WHERE recipe_id_comment = :recipe_id ORDER BY creat_date_comment DESC LIMIT :limit"
            );
            $results = $this->db->resultSet([$recipe_id, $limit]);

            foreach ($results as $row) {
                $comment = new Comment();
                $comment
                    ->setIdCom($row["id_comment"])
                    ->setUserIdComment($row["user_id_comment"])
                    ->setRecipeIdComment($row["recipe_id_comment"])
                    ->setcomComment($row["com_comment"]);

                $comResults[] = $comment;
            }
        } catch (PDOException $e) {
            throw new PDOException(
                "Error, no comment was found. " . $e->getMessage()
            );
        }
        return $comResults;
    }
    #endregion

    #region Post Comment
    // Fonction pour poster un commentaire.
    public function post_comment(Comment $data, $user_id, $recipe_id): bool
    {
        try {
            $this->db->query(
                "INSERT INTO comment (user_id_comment, recipe_id_comment, com_comment) VALUES (?, ?, ?)"
            );
            $this->db->execute([$user_id, $recipe_id, $data->getcomComment()]);
            return true;
        } catch (PDOException $e) {
            throw new PDOException("No Comment was created" . $e->getMessage());
        }
    }
    #endregion

    #region Delete Comment
    // Fonction pour supprimer un commentaire.
    public function delete_comment($id_comment)
    {
        try {
            $this->db->query("DELETE FROM comment WHERE id_comment = :id");
            $this->db->execute([$id_comment]);
            return true;
        } catch (PDOException $e) {
            throw new PDOException("" . $e->getMessage());
        }
    }
    #endregion

    #region Update Comment
    // Fonction pour mettre à jour un commentaire.
    public function update_comment(Comment $data, $id_comment)
    {
        try {
            $this->db->query(
                "UPDATE comment SET com_comment = ? WHERE id_comment = :id"
            );
            $this->db->execute([$data->com_comment, $id_comment]);
            return true;
        } catch (PDOException $e) {
            throw new PDOException("" . $e->getMessage());
        }
    }
    #endregion
}

<?php
#region Setup and Imports
// Définition de l'espace de noms pour le modèle Comment et importation de l'autoloader Composer.
namespace src\app\models;
require __DIR__ . "/../../../vendor/autoload.php";
#endregion

class Comment
{
    #region Properties
    // Déclaration des propriétés privées pour le modèle Comment.
    private int $id;
    private int $user_id;
    private int $recipe_id;
    private string $creation_date;
    private string $content;
    #endregion

    #region ID Comment Accessors
    // Accesseurs pour l'ID du commentaire.
    public function getIdCom(): int
    {
        return $this->id;
    }
    public function setIdCom(int $id): Comment
    {
        $this->id = $id;
        return $this; // Retourne l'instance pour permettre le chaînage des méthodes.
    }
    #endregion

    #region User ID Comment Accessors
    // Accesseurs pour l'ID de l'utilisateur.
    public function getUserIdComment(): int
    {
        return $this->user_id;
    }
    public function setUserIdComment(int $user_id): Comment
    {
        $this->user_id = $user_id;
        return $this;
    }
    #endregion

    #region Recipe ID Comment Accessors
    // Accesseurs pour l'ID de la recette.
    public function getRecipeIdComment(): int
    {
        return $this->recipe_id;
    }
    public function setRecipeIdComment(int $recipe_id): Comment
    {
        $this->recipe_id = $recipe_id;
        return $this;
    }
    #endregion

    #region Create Date Comment Accessors
    // Accesseurs pour la date de création du commentaire.
    public function getcreatDateComment(): string
    {
        return $this->creation_date;
    }
    public function setcreatDateComment(string $creation_date): Comment
    {
        $this->creation_date = $creation_date;
        return $this;
    }
    #endregion

    #region Comment Accessors
    // Accesseurs pour le contenu du commentaire.
    public function getcomComment(): string
    {
        return $this->content;
    }
    public function setcomComment(string $content): Comment
    {
        $this->content = $content;
        return $this;
    }
    #endregion
}

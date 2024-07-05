<?php
#region Setup and Imports
// Définition de l'espace de noms pour le modèle Comment et importation de l'autoloader Composer.
namespace src\app\models;
require '../../vendor/autoload.php';
#endregion

class Comment {
    #region Properties
    // Déclaration des propriétés privées pour le modèle Comment.
    private int $id_comment;
    private int $user_id_comment;
    private int $recipe_id_comment;
    private string $creat_date_comment;
    private string $com_comment;
    #endregion

    #region ID Comment Accessors
    // Accesseurs pour l'ID du commentaire.
    public function getIdCom(): int {
        return $this->id_comment;
    }
    public function setIdCom(int $id_comment): Comment {
        $this->id_comment = $id_comment;
        return $this; // Retourne l'instance pour permettre le chaînage des méthodes.
    }
    #endregion

    #region User ID Comment Accessors
    // Accesseurs pour l'ID de l'utilisateur.
    public function getUserIdComment(): int {
        return $this->user_id_comment;
    }
    public function setUserIdComment(int $user_id_comment): Comment {
        $this->user_id_comment = $user_id_comment;
        return $this; 
    }
    #endregion

    #region Recipe ID Comment Accessors
    // Accesseurs pour l'ID de la recette.
    public function getRecipeIdComment(): int {
        return $this->recipe_id_comment;
    }
    public function setRecipeIdComment(int $recipe_id_comment): Comment {
        $this->recipe_id_comment = $recipe_id_comment;
        return $this; 
    }
    #endregion

    #region Create Date Comment Accessors
    // Accesseurs pour la date de création du commentaire.
    public function getcreatDateComment(): string {
        return $this->creat_date_comment;
    }
    public function setcreatDateComment(string $creat_date_comment): Comment {
        $this->creat_date_comment = $creat_date_comment;
        return $this; 
    }
    #endregion

    #region Comment Accessors
    // Accesseurs pour le contenu du commentaire.
    public function getcomComment(): string {
        return $this->com_comment;
    }
    public function setcomComment(string $com_comment): Comment {
        $this->com_comment = $com_comment;
        return $this; 
    }
    #endregion
}
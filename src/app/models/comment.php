<?php

#region Setup and Imports
namespace src\app\models;

require '../../vendor/autoload.php';
#endregion

class Comment {
    #region Properties
    private int $id_comment;
    private int $user_id_comment;
    private int $recipe_id_comment;
    private string $creat_date_comment;
    private string $com_comment;
    #endregion

    #region ID Comment Accessors
    public function getIdCom(): int {
        return $this->id_comment;
    }

    public function setIdCom(int $id_comment): Comment {
        $this->id_comment = $id_comment;
        return $this;
    }
    #endregion

    #region User ID Comment Accessors
    public function getUserIdComment(): int {
        return $this->user_id_comment;
    }

    public function setUserIdComment(int $user_id_comment): Comment {
        $this->user_id_comment = $user_id_comment;
        return $this;
    }
    #endregion

    #region Recipe ID Comment Accessors
    public function getRecipeIdComment(): int {
        return $this->recipe_id_comment;
    }

    public function setRecipeIdComment(int $recipe_id_comment): Comment {
        $this->recipe_id_comment = $recipe_id_comment;
        return $this;
    }
    #endregion

    #region Create Date Comment Accessors
    public function getcreatDateComment(): string {
        return $this->creat_date_comment;
    }

    public function setcreatDateComment(string $creat_date_comment): Comment {
        $this->creat_date_comment = $creat_date_comment;
        return $this;
    }
    #endregion

    #region Comment Accessors
    public function getcomComment(): string {
        return $this->com_comment;
    }

    public function setcomComment(string $com_comment): Comment {
        $this->com_comment = $com_comment;
        return $this;
    }
    #endregion
}

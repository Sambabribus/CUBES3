<?php

#region Namespace and Imports
namespace src\app\controllers;
require_once "../app/models/database.php";
require_once "../app/models/image.php";
require_once "../app/services/image_service.php";
use src\app\models\Database;
use src\app\models\Image;
use src\app\services\ImageService;
#endregion

class image_controller
{
    #region Properties
    private ImageService $imageService;
    #endregion

    #region Constructor
    public function __construct()
    {
        $database = new Database();
        $this->imageService = new ImageService($database);
    }
    #endregion

    #region Post Image
    public function post(
        int $recipe_id,
        string $file_name,
        string $tmp_file_name,
        string $extension,
        string $mime_type
    ): ?Image {
        return $this->imageService->post(
            $recipe_id,
            $file_name,
            $tmp_file_name,
            $extension,
            $mime_type
        );
    }
    #endregion

    #region Get By Recipe ID
    public function getByRecipeId(int $int): array
    {
        return $this->imageService->getByRecipeId($int);
    }
    #endregion
}

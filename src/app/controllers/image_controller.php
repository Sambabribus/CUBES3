<?php

namespace src\app\controllers;
require_once "../app/models/database.php";
require_once "../app/models/image.php";
require_once "../app/services/image_service.php";
use src\app\models\Database;
use src\app\models\Image;
use src\app\services\ImageService;

class image_controller
{
    private ImageService $imageService;

    public function __construct()
    {
        $database = new Database();
        $this->imageService = new ImageService($database);
    }

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

    /**
     * Get Image instances with their Content
     * @return array<Image>
     */
    public function getByRecipeId(int $int): array
    {
        return $this->imageService->getByRecipeId($int);
    }
}

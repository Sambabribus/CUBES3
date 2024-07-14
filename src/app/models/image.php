<?php

#region Namespace and Imports
namespace src\app\models;
use DateTime;
use src\app\services\ImageService;
use src\FileManager;
require __DIR__ . "/../../../vendor/autoload.php";
#endregion

class Image
{
    #region Properties
    private int $id;

    private int $recipe_id;

    private string $extension;

    private string $file_name;

    private string $mime_type;

    private DateTime $creation_date;
    #endregion

    #region Getters and Setters ID
    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): Image
    {
        $this->id = $id;
        return $this;
    }
    #endregion

    #region Getters and Setters Recipe ID

    public function getRecipeId(): int
    {
        return $this->recipe_id;
    }

    public function setRecipeId(int $recipe_id): Image
    {
        $this->recipe_id = $recipe_id;
        return $this;
    }
    #endregion

    #region Getters and Setters Extension

    public function getExtension(): string
    {
        return $this->extension;
    }

    public function setExtension(string $extension): Image
    {
        $this->extension = $extension;
        return $this;
    }
    #endregion

    #region Getters and Setters File Name

    public function getFileName(): string
    {
        return $this->file_name;
    }

    public function setFileName(string $file_name): Image
    {
        $this->file_name = $file_name;
        return $this;
    }
    #endregion

    #region Getters and Setters Mime Type

    public function getMimeType(): string
    {
        return $this->mime_type;
    }

    public function setMimeType(string $mime_type): Image
    {
        $this->mime_type = $mime_type;
        return $this;
    }
    #endregion

    #region Getters and Setters Creation Date

    public function getCreationDate(): DateTime
    {
        return $this->creation_date;
    }

    public function setCreationDate(DateTime $creation_date): Image
    {
        $this->creation_date = $creation_date;
        return $this;
    }
    #endregion

    #region Get File Path
    public function getFilePath()
    {
        return FileManager::rootDirectory() .
            ImageService::DIR_PATH .
            $this->file_name .
            "." .
            $this->extension;
    }
    #endregion
}

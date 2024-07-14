<?php

#region Namespace and Imports
namespace src\app\models;
require __DIR__ . "/../../../vendor/autoload.php";
#endregion

// Définition de la classe Recipe.
class Recipe
{
    #region Properties
    private int $id;
    private string $title;
    private string $description;
    private float $cook_time;
    private float $prep_time;
    private int $serves;
    private array $images;
    private ?int $user_id;
    #endregion

    #region ID Accessors
    // Méthodes pour obtenir et définir l'ID de la recette.
    public function getId(): int
    {
        return $this->id;
    }
    public function setId(int $id): Recipe
    {
        $this->id = $id;
        return $this;
    }
    #endregion

    #region Title Accessors
    // Méthodes pour obtenir et définir le titre de la recette.
    public function getTitle(): string
    {
        return $this->title;
    }
    public function setTitle(string $title): Recipe
    {
        $this->title = $title;
        return $this;
    }
    #endregion

    #region Description Accessors
    // Méthodes pour obtenir et définir la description de la recette.
    public function getDescription(): string
    {
        return $this->description;
    }
    public function setDescription(string $description): Recipe
    {
        $this->description = $description;
        return $this;
    }
    #endregion

    #region Cooking Time Accessors
    // Méthodes pour obtenir et définir le temps de cuisson de la recette.
    public function getCookingTime(): float
    {
        return $this->cook_time;
    }
    public function setCookingTime(float $cook_time): Recipe
    {
        $this->cook_time = $cook_time;
        return $this;
    }
    #endregion

    #region Preparation Time Accessors
    // Méthodes pour obtenir et définir le temps de préparation de la recette.
    public function getPreparationTime(): float
    {
        return $this->prep_time;
    }
    public function setPreparationTime(float $prep_time): Recipe
    {
        $this->prep_time = $prep_time;
        return $this;
    }
    #endregion

    #region Serves Accessors
    // Méthodes pour obtenir et définir le nombre de portions de la recette.
    public function getServes(): int
    {
        return $this->serves;
    }
    public function setServes(int $serves): Recipe
    {
        $this->serves = $serves;
        return $this;
    }
    #endregion

    #region URL Image Accessors
    /**
     * Méthodes pour obtenir et définir l'URL de l'image de la recette.
     * @return array<Image>
     */
    public function getImages(): array
    {
        return $this->images;
    }
    /**
     * Set image of Recipe
     * @param array<Image>
     */
    public function setImages(array $images): Recipe
    {
        $this->images = $images;
        return $this;
    }
    #endregion

    #region UserID Accessors
    public function getUserId(): ?int
    {
        return $this->user_id;
    }

    public function setUserId(?int $user_id): Recipe
    {
        $this->user_id = $user_id;
        return $this;
    }
    #endregion
}

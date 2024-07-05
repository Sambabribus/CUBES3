<?php

#region Namespace and Imports
namespace src\app\models;
require "../../vendor/autoload.php";
#endregion

// Définition de la classe Recipe.
class Recipe
{
    #region Properties
    private int $id;
    private string $title;
    private string $description;
    private float $cooking_time;
    private float $preparation_time;
    private int $serves;
    private string $url_image;
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
        return $this->cooking_time;
    }
    public function setCookingTime(float $cooking_time): Recipe
    {
        $this->cooking_time = $cooking_time;
        return $this;
    }
    #endregion

    #region Preparation Time Accessors
    // Méthodes pour obtenir et définir le temps de préparation de la recette.
    public function getPreparationTime(): float
    {
        return $this->preparation_time;
    }
    public function setPreparationTime(float $preparation_time): Recipe
    {
        $this->preparation_time = $preparation_time;
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
    // Méthodes pour obtenir et définir l'URL de l'image de la recette.
    public function getUrlImage(): string
    {
        return $this->url_image;
    }
    public function setUrlImage(string $url_image): Recipe
    {
        $this->url_image = $url_image;
        return $this;
    }
    #endregion
}

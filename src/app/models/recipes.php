<?php
namespace src\app\models;

use PDOException;

class Recipe {
    //region properties
    private int $id;
    private string $title;
    private string $description;
    private float $cooking_time;
    private float $preparation_time;
    private int $serves;
    private string $url_image;
    //endregion

    //region constructor
    public function __construct() {}
    //endregion

    //region id
    public function getId(): int {
        return $this->id;
    }
    public function setId(int $id): Recipe {
        $this->id = $id;

        return $this;
    }
    //endregion

    //region title
    public function getTitle(): string {
        return $this->title;
    }
    public function setTitle(string $title): Recipe {
        $this->title = $title;

        return $this;
    }
    //endregion

    //region description
    public function getDescription(): string {
        return $this->description;
    }
    public function setDescription(string $description): Recipe {
        $this->description = $description;

        return $this;
    }
    //endregion

    //region cooking_time
    public function getCookingTime(): float {
        return $this->cooking_time;
    }
    public function setCookingTime(float $cooking_time): Recipe {
        $this->cooking_time = $cooking_time;

        return $this;
    }
    //endregion

    //region preparation_time
    public function getPreparationTime(): float {
        return $this->preparation_time;
    }
    public function setPreparationTime(float $preparation_time): Recipe {
        $this->preparation_time = $preparation_time;

        return $this;
    }
    //endregion

    //region serves
    public function getServes(): int {
        return $this->serves;
    }
    public function setServes(int $serves): Recipe {
        $this->serves = $serves;

        return $this;
    }
    //endregion

    //region url_image
    public function getUrlImage(): string {
        return $this->url_image;
    }
    public function setUrlImage(string $url_image): Recipe {
        $this->url_image = $url_image;

        return $this;
    }
    //endregion
}
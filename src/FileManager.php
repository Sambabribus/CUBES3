<?php

namespace src;
require "../../vendor/autoload.php";

class FileManager
{
    public static function rootDirectory()
    {
        return dirname(__DIR__, 1) . "/";
    }
}

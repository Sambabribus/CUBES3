<?php

class ResponseHelper
{
    public static function sendResponse($status, $data)
    {
        http_response_code($status);
        echo json_encode($data);
        exit;
    }
}

<?php
function sendResponse($status, $data, $message = '')
{
    header("Content-Type: application/json");
    http_response_code($status);
    echo json_encode([
        'status' => $status,
        'data' => $data,
        'message' => $message
    ]);
}

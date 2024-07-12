<?php

require_once __DIR__ . '/../models/Comment.php';
require_once __DIR__ . '/../helpers/ResponseHelper.php';

class CommentController
{
    private $db;
    private $requestMethod;
    private $commentId;

    public function __construct($db, $requestMethod, $commentId)
    {
        $this->db = $db;
        $this->requestMethod = $requestMethod;
        $this->commentId = $commentId;
    }

    public function processRequest()
    {
        switch ($this->requestMethod) {
            case 'GET':
                if ($this->commentId) {
                    $this->getComment($this->commentId);
                } else {
                    $this->getComments();
                }
                break;
            case 'POST':
                $this->createComment();
                break;
            case 'PUT':
                $this->updateComment($this->commentId);
                break;
            case 'DELETE':
                $this->deleteComment($this->commentId);
                break;
            default:
                header("HTTP/1.1 405 Method Not Allowed");
                echo json_encode(['message' => 'Method Not Allowed']);
                break;
        }
    }

    private function getComments()
    {
        $comments = Comment::getAll($this->db);
        ResponseHelper::sendResponse(200, $comments);
    }

    private function getComment($id)
    {
        $comment = Comment::getById($this->db, $id);
        if ($comment) {
            ResponseHelper::sendResponse(200, $comment);
        } else {
            ResponseHelper::sendResponse(404, ['message' => 'Comment not found']);
        }
    }

    private function createComment()
    {
        $data = json_decode(file_get_contents("php://input"), true);
        if (Comment::create($this->db, $data)) {
            ResponseHelper::sendResponse(201, ['message' => 'Comment created']);
        } else {
            ResponseHelper::sendResponse(500, ['message' => 'Internal Server Error']);
        }
    }

    private function updateComment($id)
    {
        $data = json_decode(file_get_contents("php://input"), true);
        if (Comment::update($this->db, $id, $data)) {
            ResponseHelper::sendResponse(200, ['message' => 'Comment updated']);
        } else {
            ResponseHelper::sendResponse(500, ['message' => 'Internal Server Error']);
        }
    }

    private function deleteComment($id)
    {
        if (Comment::delete($this->db, $id)) {
            ResponseHelper::sendResponse(200, ['message' => 'Comment deleted']);
        } else {
            ResponseHelper::sendResponse(500, ['message' => 'Internal Server Error']);
        }
    }
}

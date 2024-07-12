<?php

require_once __DIR__ . '/../config/config.php';

class Comment
{

    private static function connect()
    {
        $config = require __DIR__ . '/../config/config.php';

        if (!isset($config['db'])) {
            throw new Exception('Database configuration not found');
        }

        $dbConfig = $config['db'];

        $pdo = new PDO('mysql:host=' . $dbConfig['host'] . ';dbname=' . $dbConfig['dbname'], $dbConfig['user'], $dbConfig['password']);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    }

    public static function getAll($db)
    {
        $query = 'SELECT * FROM comments';
        $stmt = $db->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getById($db, $id)
    {
        $query = 'SELECT * FROM comments WHERE id = ?';
        $stmt = $db->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function create($db, $data)
    {
        $query = 'INSERT INTO comments (user_id, recipe_id, content) VALUES (?, ?, ?)';
        $stmt = $db->prepare($query);
        return $stmt->execute([$data['user_id'], $data['recipe_id'], $data['content']]);
    }

    public static function update($db, $id, $data)
    {
        $query = 'UPDATE comments SET user_id = ?, recipe_id = ?, content = ? WHERE id = ?';
        $stmt = $db->prepare($query);
        return $stmt->execute([$data['user_id'], $data['recipe_id'], $data['content'], $id]);
    }

    public static function delete($db, $id)
    {
        $query = 'DELETE FROM comments WHERE id = ?';
        $stmt = $db->prepare($query);
        return $stmt->execute([$id]);
    }
}

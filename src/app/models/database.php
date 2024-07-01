<?php

namespace src\app\models;

use PDO;
use PDOException;
use PDOStatement;

class Database {
    private string $host = 'localhost';
    private string $user = 'root';
    private string $pass = '';
    private string $name = 'eco_cook';
    private string $port = '3306';
    private string $charset = 'utf8mb4';

    private ?PDOStatement $stmt = null;
    public PDO $conn;

    public function __construct() {
        $dsn = 'mysql:host=' . $this->host . ';port=' . $this->port . ';dbname=' . $this->name . ";charset=" . $this->charset;
        $options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_PERSISTENT => true,];

        try {
            $this->conn = new PDO($dsn, $this->user, $this->pass, $options);
        } catch (PDOException $e) {
            die('Error: ' . $e->getMessage());
        }
    }

    final public function execute(array $args = []): bool {
        return $this->stmt->execute($args);
    }

    final public function resultSet(array $args = []): array|false {
        $this->execute($args);
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    final public function query(string $sql): void {
        $this->stmt = $this->conn->prepare($sql);
    }
    
    final public function single(array $args = []): mixed {
        $this->execute($args);
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }

    final public function rowCount(): int {
        return $this->stmt->rowCount();
    }

}
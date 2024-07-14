<?php
#region Namespace and Imports
// Définit l'espace de noms pour le modèle et importe les classes PDO nécessaires pour la gestion de la base de données.
namespace src\app\models;
use PDO;
use PDOException;
use PDOStatement;
#endregion

class Database
{
    #region Properties
    private string $host = "localhost";
    private string $user = "root";
    private string $pass = "";
    private string $name = "eco_cook";
    private string $port = "3306";
    private string $charset = "utf8mb4";
    private ?PDOStatement $stmt = null;
    public PDO $conn;
    #endregion

    #region Constructor
    // Constructeur qui initialise la connexion à la base de données avec les paramètres fournis.
    public function __construct()
    {
        $dsn =
            "mysql:host=" .
            $this->host .
            ";port=" .
            $this->port .
            ";dbname=" .
            $this->name .
            ";charset=" .
            $this->charset;
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_PERSISTENT => true,
        ];

        try {
            $this->conn = new PDO($dsn, $this->user, $this->pass, $options);
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    }
    #endregion

    #region Execute Method
    // Exécute une déclaration préparée avec les arguments fournis.
    final public function execute(array $args = []): bool
    {
        return $this->stmt->execute($args);
    }
    #endregion

    #region ResultSet Method
    // Exécute une déclaration préparée et retourne un ensemble de résultats.
    final public function resultSet(array $args = []): array
    {
        $this->execute($args);
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    #endregion

    #region Query Method
    // Prépare une déclaration SQL pour l'exécution.
    final public function query(string $sql): void
    {
        $this->stmt = $this->conn->prepare($sql);
    }
    #endregion

    #region Single Method
    // Exécute une déclaration préparée et retourne un seul enregistrement.
    final public function single(array $args = []): array
    {
        $this->execute($args);
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }
    #endregion

    #region RowCount Method
    // Retourne le nombre de lignes affectées par la dernière déclaration SQL.
    final public function rowCount(): int
    {
        return $this->stmt->rowCount();
    }
    #endregion

    #region LastInsertId Method
    final public function lastInsertId(string $name = null): string
    {
        return $this->conn->lastInsertId($name);
    }
    #endregion
}

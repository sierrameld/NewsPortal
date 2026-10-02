<?php
class Database {
    private ?PDO $conn = null;
    private string $host     = 'db';
    private string $user     = 'root';
    private string $password = 'root';
    private string $baseName = 'NewsPortal';

    public function __construct() {
        $this->connect();
    }

    public function __destruct() {
        $this->disconnect();
    }

    public function connect(): PDO {
        if (!$this->conn) {
            try {
                $this->conn = new PDO(
                    'mysql:host=' . $this->host . ';dbname=' . $this->baseName . ';charset=utf8mb4',
                    $this->user,
                    $this->password,
                    [
                        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    ]
                );
            } catch (PDOException $e) {
                die('Connection failed ' . $e->getMessage());
            }
        }
        return $this->conn;
    }

    public function disconnect(): void {
        $this->conn = null;
    }

    // Одна запись (или false, если ничего не нашлось)
    public function getOne(string $query, array $params = []) {
        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);
        return $stmt->fetch();
    }

    // Все записи массивом
    public function getAll(string $query, array $params = []): array {
        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    // INSERT, UPDATE, DELETE. Возвращает число затронутых строк
    public function executeRun(string $query, array $params = []): int {
        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);
        return $stmt->rowCount();
    }
}

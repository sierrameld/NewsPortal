<?php
// Класс для работы с базой. Хост "db" это имя сервиса из docker-compose.yml
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
                        PDO::ATTR_EMULATE_PREPARES   => false, // настоящие подготовленные запросы на стороне MySQL
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

    // Подготовить запрос и подставить параметры.
    // Числа идут как INT, обычный текст как строка, а двоичные данные (картинки) как LOB.
    private function run(string $query, array $params): PDOStatement {
        $stmt = $this->conn->prepare($query);
        $i = 1;
        foreach ($params as $value) {
            if (is_int($value)) {
                $type = PDO::PARAM_INT;
            } elseif (is_null($value)) {
                $type = PDO::PARAM_NULL;
            } elseif (is_string($value) && !mb_check_encoding($value, 'UTF-8')) {
                $type = PDO::PARAM_LOB;   // не текст, значит байты картинки
            } else {
                $type = PDO::PARAM_STR;
            }
            $stmt->bindValue($i++, $value, $type);
        }
        $stmt->execute();
        return $stmt;
    }

    // Одна запись (или false, если ничего не нашлось)
    public function getOne(string $query, array $params = []) {
        return $this->run($query, $params)->fetch();
    }

    // Все записи массивом
    public function getAll(string $query, array $params = []): array {
        return $this->run($query, $params)->fetchAll();
    }

    // INSERT, UPDATE, DELETE. Возвращает число затронутых строк
    public function executeRun(string $query, array $params = []): int {
        return $this->run($query, $params)->rowCount();
    }
}

<?php
class DataBase {
    private PDO $connection;

    public function __construct() {
        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';
        $this->connection = new PDO($dsn, DB_USER, DB_PASSWORD, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ]);
    }

    public function execute(string $sql, array $values = []) {
        $statement = $this->connection->prepare($sql);
        $statement->execute($values);
        return $statement;
    }

    public function insert(string $sql, array $values = []): int {
        $this->execute($sql, $values);
        return (int)$this->connection->lastInsertId();
    }

    public function select(string $sql, array $values = []): array {
        return $this->execute($sql, $values)->fetchAll();
    }

    public function selectOne(string $sql, array $values = []): ?array {
        $result = $this->execute($sql, $values)->fetch();
        return $result ?: null;
    }
}

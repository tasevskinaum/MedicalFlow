<?php

namespace Core;

use PDO;
use PDOException;

class Database
{
    private ?PDO $connection = null;

    protected function getConnection(): PDO
    {
        if ($this->connection === null) {
            try {
                $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";

                $this->connection = new PDO($dsn, DB_USERNAME, DB_PASSWORD, [
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                ]);
            } catch (PDOException $e) {
                throw new \Exception("Database connection failed: " . $e->getMessage(), (int) $e->getCode());
            }
        }

        return $this->connection;
    }

    protected function query(string $query, array $params = []): \PDOStatement
    {
        $statement = $this->getConnection()->prepare($query);

        if (!$statement) {
            throw new \Exception("Failed to prepare the SQL query.");
        }

        $result = $statement->execute($params);

        if (!$result) {
            throw new \Exception("Query execution failed.");
        }

        return $statement;
    }
}

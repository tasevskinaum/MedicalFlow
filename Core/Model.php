<?php

namespace Core;

class Model extends Database
{
    protected static string $table;
    protected static string $primaryKey = 'id';
    protected array $fillable = [];
    protected array $guarded = [];
    protected array $queryConditions = [];
    protected array $groupBy = [];
    protected array $excludedColumns = [];

    public function __construct(array $attributes = [])
    {
        foreach ($attributes as $key => $value) {
            $this->{$key} = $value;
        }
    }

    public static function queryBuilder(): static
    {
        return new static();
    }

    public function __get($key)
    {
        return $this->{$key} ?? null;
    }

    public function __set($key, $value)
    {
        if (in_array($key, $this->fillable) && !in_array($key, $this->guarded)) {
            $this->{$key} = $value;
        }
    }

    public static function find($value): ?static
    {
        $table = static::$table;
        $primaryKey = static::$primaryKey;

        $query = "SELECT * FROM {$table} WHERE {$primaryKey} = :value LIMIT 1";
        $result = (new static())->query($query, ['value' => $value])->fetch();

        return $result ? new static($result) : null;
    }

    public static function all(): array
    {
        $table = static::$table;

        $query = "SELECT * FROM {$table}";
        $results = (new static())->query($query)->fetchAll();

        return array_map(fn($result) => new static($result), $results);
    }

    public function save()
    {
        $table = static::$table;

        $attributes = array_filter(get_object_vars($this), function ($key) {
            return in_array($key, $this->fillable) && !in_array($key, $this->guarded);
        }, ARRAY_FILTER_USE_KEY);

        if (empty($attributes)) {
            throw new \Exception('No valid attributes to save.');
        }

        $columns = implode(', ', array_keys($attributes));
        $placeholders = implode(', ', array_map(fn($key) => ":{$key}", array_keys($attributes)));

        $this->query("INSERT INTO {$table} ({$columns}) VALUES ({$placeholders})", $attributes);

        return static::find($this->getConnection()->lastInsertId());
    }

    public function update(array $data): bool
    {
        $table = static::$table;
        $primaryKey = static::$primaryKey;

        if (!isset($this->{$primaryKey})) {
            throw new \Exception("Primary key value not set for update.");
        }

        $data = array_filter($data, function ($key) {
            return in_array($key, $this->fillable) && !in_array($key, $this->guarded);
        }, ARRAY_FILTER_USE_KEY);

        if (empty($data)) {
            throw new \Exception('No valid attributes to update.');
        }

        $columns = implode(', ', array_map(fn($key) => "{$key} = :{$key}", array_keys($data)));

        $query = "UPDATE {$table} SET {$columns} WHERE {$primaryKey} = :id";
        $data['id'] = $this->{$primaryKey};

        return $this->query($query, $data)->rowCount() > 0;
    }

    public function delete(): bool
    {
        $table = static::$table;
        $primaryKey = static::$primaryKey;

        if (!isset($this->{$primaryKey})) {
            throw new \Exception("Primary key value not set for deletion.");
        }

        $query = "DELETE FROM {$table} WHERE {$primaryKey} = :id";
        return $this->query($query, ['id' => $this->{$primaryKey}])->rowCount() > 0;
    }

    public function where(string $column, string $operator, $value): static
    {
        $this->queryConditions[] = [
            'column' => $column,
            'operator' => $operator,
            'value' => $value
        ];
        return $this;
    }

    public static function orderBy(string $column, string $direction = 'ASC'): array
    {
        $table = static::$table;

        $query = "SELECT * FROM {$table} ORDER BY {$column} {$direction}";
        $results = (new static())->query($query)->fetchAll();

        return array_map(fn($result) => new static($result), $results);
    }

    public static function limit(int $limit): array
    {
        $table = static::$table;

        $query = "SELECT * FROM {$table} LIMIT {$limit}";
        $results = (new static())->query($query)->fetchAll();

        return array_map(fn($result) => new static($result), $results);
    }

    public static function count(): int
    {
        $table = static::$table;

        $query = "SELECT COUNT(*) FROM {$table}";
        $result = (new static())->query($query)->fetchColumn();

        return (int) $result;
    }

    public static function whereLimit(string $column, string $operator, $value, int $limit): array
    {
        $table = static::$table;

        $query = "SELECT * FROM {$table} WHERE {$column} {$operator} :value LIMIT {$limit}";
        $results = (new static())->query($query, ['value' => $value])->fetchAll();

        return array_map(fn($result) => new static($result), $results);
    }

    public function get(): array
    {
        $table = static::$table;
        $query = "SELECT * FROM {$table}";

        if (!empty($this->queryConditions)) {
            $whereClauses = array_map(fn($condition) => "{$condition['column']} {$condition['operator']} :{$condition['column']}", $this->queryConditions);
            $query .= " WHERE " . implode(" AND ", $whereClauses);
        }

        if (!empty($this->groupBy)) {
            $query .= " GROUP BY " . implode(', ', $this->groupBy);
        }

        $params = [];
        foreach ($this->queryConditions as $condition) {
            $params[$condition['column']] = $condition['value'];
        }

        $results = $this->query($query, $params)->fetchAll();

        if (!empty($this->excludedColumns)) {
            $results = array_map(function ($result) {
                return array_diff_key($result, array_flip($this->excludedColumns));
            }, $results);
        }

        return array_map(fn($result) => new static($result), $results);
    }

    public function first(): ?static
    {
        $results = $this->get();
        return $results[0] ?? null;
    }

    public function groupBy(string $column): static
    {
        $this->groupBy[] = $column;
        return $this;
    }

    public function except(array $columns): static
    {
        $this->excludedColumns = $columns;
        return $this;
    }
}

<?php

namespace Core;

class Model extends Database
{
    protected static string $table; // Table name
    protected static string $primaryKey = 'id'; // Primary key column name
    protected array $fillable = []; // Fields that can be mass assigned
    protected array $guarded = []; // Fields that cannot be mass assigned

    public function __construct(array $attributes = [])
    {
        // Initialize attributes dynamically
        foreach ($attributes as $key => $value) {
            $this->{$key} = $value;
        }
    }

    // Magic getter for dynamic attributes
    public function __get($key)
    {
        return $this->{$key} ?? null;
    }

    // Magic setter for dynamic attributes
    public function __set($key, $value)
    {
        // Only set the value if the property is fillable and not guarded
        if (in_array($key, $this->fillable) && !in_array($key, $this->guarded)) {
            $this->{$key} = $value;
        }
    }

    // Find a record by primary key
    public static function find($value): ?static
    {
        $table = static::$table;
        $primaryKey = static::$primaryKey;

        $query = "SELECT * FROM {$table} WHERE {$primaryKey} = :value LIMIT 1";
        $result = (new static())->query($query, ['value' => $value])->fetch();

        return $result ? new static($result) : null;
    }

    // Get all records
    public static function all(): array
    {
        $table = static::$table;

        $query = "SELECT * FROM {$table}";
        $results = (new static())->query($query)->fetchAll();

        return array_map(fn($result) => new static($result), $results);
    }

    // Save a new record (create)
    public function save(): bool
    {
        $table = static::$table;

        // Filter the attributes based on $fillable and $guarded
        $attributes = get_object_vars($this);

        // Filter based on fillable and guarded properties
        $attributes = array_filter($attributes, function ($key) {
            return in_array($key, $this->fillable) && !in_array($key, $this->guarded);
        }, ARRAY_FILTER_USE_KEY);

        if (empty($attributes)) {
            throw new \Exception('No valid attributes to save.');
        }

        $columns = implode(', ', array_keys($attributes));
        $placeholders = implode(', ', array_map(fn($key) => ":{$key}", array_keys($attributes)));

        // Prepare and execute the query
        $query = "INSERT INTO {$table} ({$columns}) VALUES ({$placeholders})";
        return $this->query($query, $attributes)->rowCount() > 0;
    }

    // Update an existing record
    public function update(array $data): bool
    {
        $table = static::$table;
        $primaryKey = static::$primaryKey;

        if (!isset($this->{$primaryKey})) {
            throw new \Exception("Primary key value not set for update.");
        }

        // Filter the update data based on fillable and guarded
        $data = array_filter($data, function ($key) {
            return in_array($key, $this->fillable) && !in_array($key, $this->guarded);
        }, ARRAY_FILTER_USE_KEY);

        if (empty($data)) {
            throw new \Exception('No valid attributes to update.');
        }

        $columns = implode(', ', array_map(fn($key) => "{$key} = :{$key}", array_keys($data)));

        // Prepare and execute the query
        $query = "UPDATE {$table} SET {$columns} WHERE {$primaryKey} = :id";
        $data['id'] = $this->{$primaryKey}; // Bind primary key value

        return $this->query($query, $data)->rowCount() > 0;
    }

    // Delete the current record
    public function delete(): bool
    {
        $table = static::$table;
        $primaryKey = static::$primaryKey;

        if (!isset($this->{$primaryKey})) {
            throw new \Exception("Primary key value not set for deletion.");
        }

        // Prepare and execute the delete query
        $query = "DELETE FROM {$table} WHERE {$primaryKey} = :id";
        return $this->query($query, ['id' => $this->{$primaryKey}])->rowCount() > 0;
    }

    // Where method for querying with conditions
    public static function where(string $column, string $operator, $value): array
    {
        $table = static::$table;

        // Prepare the query with the condition
        $query = "SELECT * FROM {$table} WHERE {$column} {$operator} :value";
        $results = (new static())->query($query, ['value' => $value])->fetchAll();

        // Return an array of Model instances
        return array_map(fn($result) => new static($result), $results);
    }

    // Order by a specific column
    public static function orderBy(string $column, string $direction = 'ASC'): array
    {
        $table = static::$table;

        $query = "SELECT * FROM {$table} ORDER BY {$column} {$direction}";
        $results = (new static())->query($query)->fetchAll();

        return array_map(fn($result) => new static($result), $results);
    }

    // Limit the number of records
    public static function limit(int $limit): array
    {
        $table = static::$table;

        $query = "SELECT * FROM {$table} LIMIT {$limit}";
        $results = (new static())->query($query)->fetchAll();

        return array_map(fn($result) => new static($result), $results);
    }

    // Count the number of records
    public static function count(): int
    {
        $table = static::$table;

        $query = "SELECT COUNT(*) FROM {$table}";
        $result = (new static())->query($query)->fetchColumn();

        return (int) $result;
    }

    // Get records with a specific condition and limit
    public static function whereLimit(string $column, string $operator, $value, int $limit): array
    {
        $table = static::$table;

        // Prepare the query with condition and limit
        $query = "SELECT * FROM {$table} WHERE {$column} {$operator} :value LIMIT {$limit}";
        $results = (new static())->query($query, ['value' => $value])->fetchAll();

        return array_map(fn($result) => new static($result), $results);
    }
}

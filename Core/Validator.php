<?php

namespace Core;

class Validator extends Database
{
    protected array $data;
    protected array $rules;
    protected array $errors = [];

    public function __construct(array $data, array $rules)
    {
        $this->data = $data;
        $this->rules = $rules;
    }

    public function validate(): bool
    {
        foreach ($this->rules as $field => $rules) {
            $rules = explode('|', $rules);
            foreach ($rules as $rule) {
                $this->applyRule($field, $rule);
            }
        }

        if (!empty($this->errors)) {
            Session::set('validation_errors', $this->errors);
            Session::setOldInput($this->data);
        }

        return empty($this->errors);
    }

    protected function applyRule(string $field, string $rule): void
    {
        [$ruleName, $param] = $this->parseRule($rule);

        $value = $this->data[$field] ?? null;

        switch ($ruleName) {
            case 'required':
                if (empty($value)) {
                    $this->addError($field, "{$field} is required.");
                }
                break;
            case 'email':
                if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->addError($field, "{$field} must be a valid email address.");
                }
                break;
            case 'min':
                if (strlen($value) < (int) $param) {
                    $this->addError($field, "{$field} must be at least {$param} characters.");
                }
                break;
            case 'max':
                if (strlen($value) > (int) $param) {
                    $this->addError($field, "{$field} must not exceed {$param} characters.");
                }
                break;
            case 'numeric':
                if (!is_numeric($value)) {
                    $this->addError($field, "{$field} must be a numeric value.");
                }
                break;
            case 'confirmed':
                $confirmationField = "{$field}_confirmation";
                if (($this->data[$confirmationField] ?? null) !== $value) {
                    $this->addError($field, "{$field} confirmation does not match.");
                }
                break;
            case 'exists':
                if (!$this->exists($param, $value)) {
                    $this->addError($field, "{$field} does not exist.");
                }
                break;
            case 'unique':
                [$table, $column, $exceptId] = array_pad(explode(',', $param), 3, null);
                if ($this->unique($table, $column, $value, $exceptId)) {
                    $this->addError($field, "{$field} must be unique.");
                }
                break;

            case 'alpha':
                if (!ctype_alpha($value)) {
                    $this->addError($field, "{$field} must contain only alphabetic characters.");
                }
                break;

            case 'alpha_num':
                if (!ctype_alnum($value)) {
                    $this->addError($field, "{$field} must contain only alphanumeric characters.");
                }
                break;

            case 'in':
                $options = explode(',', $param);
                if (!in_array($value, $options)) {
                    $this->addError($field, "{$field} must be one of: " . implode(', ', $options));
                }
                break;

            case 'not_in':
                $options = explode(',', $param);
                if (in_array($value, $options)) {
                    $this->addError($field, "{$field} must not be one of: " . implode(', ', $options));
                }
                break;

            case 'date':
                if (!strtotime($value)) {
                    $this->addError($field, "{$field} must be a valid date.");
                }
                break;

            case 'after':
                if (strtotime($value) <= strtotime($param)) {
                    $this->addError($field, "{$field} must be a date after {$param}.");
                }
                break;

            case 'before':
                if (strtotime($value) >= strtotime($param)) {
                    $this->addError($field, "{$field} must be a date before {$param}.");
                }
                break;
            case 'regex':
                if (!preg_match("/{$param}/", $value)) {
                    $this->addError($field, "{$field} format is invalid.");
                }
                break;
            default:
                throw new \Exception("Validation rule {$ruleName} is not supported.");
        }
    }

    protected function parseRule(string $rule): array
    {
        $parts = explode(':', $rule);
        return [$parts[0], $parts[1] ?? null];
    }

    protected function addError(string $field, string $message): void
    {
        $this->errors[$field][] = $message;
    }

    public function exists(string $table, $value): bool
    {
        $query = "SELECT COUNT(*) FROM {$table} WHERE {$table}.id = :value";
        $statement = $this->query($query, ['value' => $value]);

        return $statement->fetchColumn() > 0;
    }

    public function unique(string $table, string $column, $value, int $excludeId = null): bool
    {
        $query = "SELECT COUNT(*) FROM {$table} WHERE {$column} = :value";
        if ($excludeId) {
            $query .= " AND id != :excludeId";
        }

        $params = ['value' => $value];
        if ($excludeId) {
            $params['excludeId'] = $excludeId;
        }

        $statement = $this->query($query, $params);

        return $statement->fetchColumn() > 0;
    }


    public static function errors(): array
    {
        return Session::pull('validation_errors', []);
    }

    public static function error(string $field): ?string
    {
        $errors = Session::get('validation_errors', []);

        $error = $errors[$field][0] ?? null;

        if ($error) {
            unset($errors[$field]);
            Session::set('validation_errors', $errors);
        }

        return $error;
    }
}

<?php

namespace Core;

class Request
{
    private array $post;
    private array $get;
    private array $body;
    private array $server;

    public function __construct()
    {
        $this->post = $_POST;
        $this->get = $_GET;
        $this->server = $_SERVER;
        $this->body = $this->parseBody();
    }

    public function post(string $key, $default = null)
    {
        return $this->post[$key] ?? $default;
    }

    public function get(string $key, $default = null)
    {
        return $this->get[$key] ?? $default;
    }

    public function body(string $key, $default = null)
    {
        return $this->body[$key] ?? $default;
    }

    private function parseBody(): array
    {
        $method = $this->method();

        if (in_array($method, ['PUT', 'DELETE', 'PATCH'])) {
            parse_str(file_get_contents('php://input'), $body);
            return $body;
        }

        return [];
    }

    public function method(): string
    {
        return strtoupper($this->server['REQUEST_METHOD'] ?? 'GET');
    }

    public function uri(): string
    {
        return parse_url($this->server['REQUEST_URI'], PHP_URL_PATH) ?? '/';
    }

    public function __get(string $key)
    {
        return $this->post[$key] ?? $this->get[$key] ?? $this->body[$key] ?? null;
    }

    public function has(string $key): bool
    {
        return isset($this->post[$key]) || isset($this->get[$key]) || isset($this->body[$key]);
    }
}

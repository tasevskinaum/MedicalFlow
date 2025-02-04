<?php

function view(string $view, array $data = []): void
{
    extract($data);

    $viewPath = BASE_PATH . '/resources/views/' . str_replace('.', DIRECTORY_SEPARATOR, $view) . '.view.php';

    if (!file_exists($viewPath)) {
        http_response_code(404);
        exit("View file not found: " . htmlspecialchars($viewPath));
    }

    include $viewPath;
}

function dd($var): void
{
    echo '<pre>';
    print_r($var);
    echo '</pre>';
    exit();
}

function redirect(string $url): void
{
    header("Location: $url");
    exit;
}

function auth()
{
    return new class {
        public function check(): bool
        {
            $user = \Core\Session::get('user');
            return $user && isset($user->id);
        }

        public function user(): ?\App\Http\Models\User
        {
            $user = \Core\Session::get('user');
            $userId = $user ? $user->id : null;

            if ($userId) {
                return \App\Http\Models\User::find($userId);
            }
            return null;
        }

        public function __get(string $property)
        {
            $user = $this->user();
            return $user ? $user->{$property} : null;
        }
    };
}

function old(string $key, $default = null)
{
    return \Core\Session::getOldInput($key, $default);
}

function error(string $field): ?string
{
    return \Core\Validator::error($field);
}

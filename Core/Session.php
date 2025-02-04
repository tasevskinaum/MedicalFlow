<?php

namespace Core;

class Session
{
    public static function start(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        // self::cleanupFlashMessages();
        // self::cleanupOldInput();
    }

    public static function set(string $key, $value): void
    {
        $_SESSION[$key] = $value;
    }

    public static function get(string $key, $default = null)
    {
        return $_SESSION[$key] ?? $default;
    }

    public static function has(string $key): bool
    {
        return isset($_SESSION[$key]);
    }

    public static function remove(string $key): void
    {
        if (self::has($key)) {
            unset($_SESSION[$key]);
        }
    }

    public static function destroy(): void
    {
        session_start();
        session_unset();
        session_destroy();
    }

    public static function flash(string $key, $value): void
    {
        self::set($key, $value);
        self::set("__flash__{$key}", true);
    }

    public static function getFlash(string $key, $default = null)
    {
        if (self::has("__flash__{$key}")) {
            $value = self::get($key, $default);
            self::remove($key);
            self::remove("__flash__{$key}");
            return $value;
        }

        return $default;
    }

    public static function setOldInput(array $input): void
    {
        self::set('_old_input', $input);
    }

    public static function getOldInput(string $key, $default = null)
    {
        $oldInput = self::get('_old_input', []);
        $value = $oldInput[$key] ?? $default;

        if (isset($oldInput[$key])) {
            unset($oldInput[$key]);
            self::set('_old_input', $oldInput);
        }

        return $value;
    }

    public static function pullOldInput(): array
    {
        $oldInput = self::get('_old_input', []);
        self::clearOldInput();
        return $oldInput;
    }

    public static function clearOldInput(): void
    {
        self::remove('_old_input');
    }

    public static function pull(string $key, $default = null)
    {
        $value = self::get($key, $default);
        self::remove($key);
        return $value;
    }

    protected static function cleanupFlashMessages(): void
    {
        foreach ($_SESSION as $key => $value) {
            if (str_starts_with($key, '__flash__')) {
                $flashKey = substr($key, 9);
                self::remove($flashKey);
                self::remove($key);
            }
        }
    }

    protected static function cleanupOldInput(): void
    {
        if (self::has('_old_input')) {
            self::remove('_old_input');
        }
    }
}

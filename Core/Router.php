<?php

namespace Core;

use ReflectionMethod;

class Router
{
    private static array $routes = [];

    public static function get(string $uri, string $controller, string $function, array $middleware = []): void
    {
        self::loadRoute($uri, 'GET', $controller, $function, $middleware);
    }

    public static function post(string $uri, string $controller, string $function, array $middleware = []): void
    {
        self::loadRoute($uri, 'POST', $controller, $function, $middleware);
    }

    public static function delete(string $uri, string $controller, string $function, array $middleware = []): void
    {
        self::loadRoute($uri, 'DELETE', $controller, $function, $middleware);
    }

    private static function loadRoute(string $uri, string $method, string $controller, string $function, array $middleware = []): void
    {
        $uri = trim($uri, '/');
        self::$routes[$method][] = [
            'URI' => $uri,
            'CONTROLLER' => $controller,
            'FUNCTION' => $function,
            'MIDDLEWARE' => $middleware,
        ];
    }

    public static function route(string $uri, string $method): void
    {
        $uri = trim($uri, '/');
        $routeMatch = null;
        $routeParams = [];

        foreach (self::$routes[$method] ?? [] as $route) {
            $routePattern = preg_replace('/\{[a-zA-Z0-9_]+\}/', '([a-zA-Z0-9_]+)', $route['URI']);
            $routePattern = '/^' . str_replace('/', '\/', $routePattern) . '$/';

            if (preg_match($routePattern, $uri, $matches)) {
                $routeMatch = $route;
                array_shift($matches); // Remove the full match
                $routeParams = $matches;
                break;
            }
        }

        if (!$routeMatch) {
            dd('Route does not exist');
        }

        $request = new \Core\Request();
        $middlewareStack = $routeMatch['MIDDLEWARE'];

        $next = function ($request) use ($routeMatch, $routeParams) {
            $controllerClass = $routeMatch['CONTROLLER'];
            if (!class_exists($controllerClass)) {
                dd('Controller not found');
            }

            $controller = new $controllerClass();
            $function = $routeMatch['FUNCTION'];

            if (!method_exists($controller, $function)) {
                dd('Function not found');
            }

            $reflection = new ReflectionMethod($controller, $function);
            $parameters = $reflection->getParameters();
            $args = [];

            foreach ($parameters as $param) {
                $paramType = $param->getType();

                if ($paramType && !$paramType->isBuiltin()) {
                    $paramClass = $paramType->getName();
                    if ($paramClass === \Core\Request::class) {
                        $args[] = $request;
                    } elseif (is_subclass_of($paramClass, \Core\Model::class)) {
                        $modelId = array_shift($routeParams);
                        $model = $paramClass::find($modelId);

                        if (!$model) {
                            dd("Model not found for ID: {$modelId}");
                        }
                        $args[] = $model;
                    } else {
                        dd("Cannot resolve dependency: {$paramClass}");
                    }
                } elseif (!empty($routeParams)) {
                    $args[] = array_shift($routeParams);
                }
            }

            call_user_func_array([$controller, $function], $args);
        };

        // Build the middleware chain
        foreach (array_reverse($middlewareStack) as $middleware) {
            $next = function ($request) use ($middleware, $next) {
                $middlewareInstance = new $middleware();
                $middlewareInstance->handle($request, $next);
            };
        }

        // Execute the middleware chain
        $next($request);
    }
}

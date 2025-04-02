<?php

namespace Core\Middleware;

abstract class BaseMiddleware implements MiddlewareInterface
{
    abstract public function handle($request, callable $next);
}

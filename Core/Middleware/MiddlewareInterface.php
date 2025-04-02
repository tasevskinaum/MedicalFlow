<?php

namespace Core\Middleware;

interface MiddlewareInterface
{
    public function handle($request, callable $next);
}

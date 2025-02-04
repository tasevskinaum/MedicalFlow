<?php

use Core\Router;
use Core\Session;

require_once './vendor/autoload.php';

Session::start();

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '';

$method = $_POST['_method'] ?? $_SERVER['REQUEST_METHOD'];

Router::route($uri, $method);

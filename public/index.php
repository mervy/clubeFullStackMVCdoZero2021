<?php

use Throwable;
use Naplanum\MVC\library\Router;

session_start();

ini_set("display_errors", true);

require "../vendor/autoload.php";

try {
    $route = new Router;
    $route->add('/', 'GET', 'HomeController::index');
    $route->add('/teste', 'GET', 'HomeController::teste');
    $route->add('/blog', 'GET', 'BlogController::index');
    $route->add('/contact', 'GET', 'ContactController::index');
    $route->init();
} catch (Throwable $th) {
    formatException($th);
}
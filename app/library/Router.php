<?php

namespace Naplanum\MVC\library;

class Router
{
    private array $routes = [];

    public function add(
        string $uri,
        string $request,
        string $controller
    ) {
        $this->routes[] = new Route($uri, $request, $controller);
    }
    public function init()
    {
        foreach ($this->routes as $route) {
            if ($route->match($route)) return (new BaseController)->call($route);
        }

        return (new BaseController)->call(new Route('/404', 'GET', 'NotFoundController::index'));
    }
}

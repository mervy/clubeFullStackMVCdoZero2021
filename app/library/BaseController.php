<?php

namespace Naplanum\MVC\library;

use Exception;

class BaseController
{
    public function call(Route $route)
    {
        $controller = $route->controller;
        if (!str_contains($controller, '::')) {
            throw new Exception("A double colon is required for the controller {$controller} name");
        }

        [$controller, $action] = explode('::', $controller);

        $controllerInstance = "Naplanum\\MVC\\controllers\\" . $controller;

        if (!class_exists($controllerInstance)) {
            throw new Exception("Controller {$controller} does not exist");
        }

        $controller = new $controllerInstance;

        if (!method_exists($controller, $action)) {
            throw new Exception("Action {$action} does not exist");
        }

        call_user_func_array([$controller, $action], []);
    }
}
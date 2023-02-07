<?php

namespace Naplanum\MVC\library;

use Exception;
use League\Plates\Engine;

class View
{

    public static function render(string $view, array $data = [])
    {
        $path = dirname(__FILE__, 3);
        $filePath = $path . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR;

        if (!file_exists($filePath . $view . '.php')) {
            throw new Exception("View {$view} des not exist");
        }
        $templates = new Engine($filePath);
        echo $templates->render($view, $data);
    }
}
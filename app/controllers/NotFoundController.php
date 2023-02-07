<?php

namespace Naplanum\MVC\controllers;

use Naplanum\MVC\library\View;

class NotFoundController
{

    public function index()
    {
        View::render('error404');
    }
}

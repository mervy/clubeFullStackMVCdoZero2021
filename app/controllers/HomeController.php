<?php

namespace Naplanum\MVC\controllers;

use Naplanum\MVC\library\View;

class HomeController
{

    public function index()
    {
        View::render('home');
    }
    public function teste()
    {

        echo "teste do HomeController";
        View::render('home');
    }
}

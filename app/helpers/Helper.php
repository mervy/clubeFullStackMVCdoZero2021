<?php

function setInitialErrorsPhp()
{
    error_reporting(E_ALL);
    ini_set("display_errors", 1);
}

function formatException(Throwable $throw)
{
    echo "Erro no arquivo <strong>{$throw->getFile()}</strong><br> 
            na linha <strong>{$throw->getLine()}</strong><br>
                com a mensagem <strong>{$throw->getMessage()}</strong>";
}

function dd($var, $type)
{
    echo "<pre>";
    $typp = match ($type) {
        'v' => var_dump($var),
        'p' => print_r($var)
    };
    echo "</pre>";
}
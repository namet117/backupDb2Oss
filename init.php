<?php

define('ROOT_DIR', str_replace('', '/', __DIR__) . '/');

function autoload($class)
{
    $filename = ROOT_DIR . str_replace('\\', '/', $class) . '.php';
    if (file_exists($filename)) {
        require $filename;
    }
}

function E($msg, $code = 0)
{
    throw new \Exception($msg, $code);
}

spl_autoload_register('autoload');
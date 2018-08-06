<?php
/**
 * Created by PhpStorm.
 * User: namet117<namet117@163.com>
 * DateTime: 2018/8/7 00:24
 */

require './vendor/autoload.php';

define('ROOT_DIR', __DIR__ . '/');

function autoload($class)
{
    $filename = ROOT_DIR . '/' . str_replace('\\', '/', $class) . '.php';
    if (file_exists($filename)) {
        require $filename;
    }
}

spl_autoload_register('autoload');

$run = new App\Run();
$run->exec();

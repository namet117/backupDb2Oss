<?php
/**
 * Created by PhpStorm.
 * User: namet117<namet117@163.com>
 * DateTime: 2018/8/7 00:33
 */

namespace App;


use Lib\DB;

class Run
{
    public function exec()
    {
        $config = require ROOT_DIR . 'config.php';

        $db = new DB($config);
    }
}
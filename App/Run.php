<?php
/**
 * Created by PhpStorm.
 * User: namet117<namet117@163.com>
 * DateTime: 2018/8/7 00:33
 */

namespace App;

use Lib\Oss;
use Exception;

class Run
{
    private $_path;
    private $_config;
    private $_filename;
    private $_fullpath;

    public function exec()
    {
        try {
             $this->_getSqlDataPath();

             $this->_getConfig();

             $this->_makeData();

            $this->_upload();

            $msg = 'Upload success';
        } catch (Exception $e) {
            $msg = $e->getMessage();
        }

        echo $msg, "\n";
    }

    private function _getSqlDataPath()
    {
        $this->_path = ROOT_DIR . 'data/';
        if (!is_writeable(ROOT_DIR)) {
            E(ROOT_DIR . ' is unwriteable! ');
        }
        if (!file_exists($this->_path) && !mkdir($this->_path)) {
            E($this->_path . ' create failed! ');
        }
    }

    private function _getConfig()
    {
        if (!file_exists(ROOT_DIR . 'config.php')) {
            E('config.php does not exists in ' . ROOT_DIR);
        }
        $this->_config = require ROOT_DIR . 'config.php';
    }

    private function _makeData()
    {
        echo date('Y-m-d H:i:s') . '::::';

        $db = $this->_config['db'];
        $db['port'] = empty($db['port']) ? '3306' : strval(intval($db['port']));
        $db_str = empty($db['db'])
            ? '-A'
            : ('-B ' . (is_array($db['db']) ? implode(' ', $db['db']) : str_replace(',', ' ', $db['db'])));
        $this->_filename = "{$db['host']}-" . date('YmdHis') . '.sql.gz';
        $this->_fullpath = $this->_path . $this->_filename;

        $command = "mysqldump -h{$db['host']} -u{$db['user']} -p{$db['password']} -P{$db['port']} --skip-lock-tables ";
        $command .= "{$db_str} | gzip > {$this->_fullpath}";

        $result = 0;
        $out = system($command, $result);

        if ($result !== 0) {
            file_exists($this->_fullpath) && unlink($this->_fullpath);
            E('make sql data file failed');
        }
    }

    private function _upload()
    {
        Oss::getInstance()->config($this->_config['oss'])->upload('193.112.3.129-20180807131633.sql.gz', 'data/193.112.3.129-20180807131633.sql.gz');
    }
}

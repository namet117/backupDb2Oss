<?php
namespace Lib;

use OSS\Core\OssException;
use OSS\OssClient;

class Oss
{
    private static $_instance = null;
    private $_config = array();

    private function __construct(){}
    private function __clone(){}

    public static function getInstance()
    {
        if (!self::$_instance) {
            self::$_instance = new self;
        }

        return self::$_instance;
    }

    public function config($config)
    {
        $this->_config = $config;
        $keys = array('id', 'secret', 'bucket', 'endpoint');
        foreach ($keys as $key) {
            empty($this->_config[$key]) && E('OSS config :' . $key . ' must be filled');
        }

        return $this;
    }

    public function upload($filename, $filepath)
    {
        try {
            $client = new OssClient($this->_config['id'], $this->_config['secret'], $this->_config['endpoint']);
            $client->uploadFile($this->_config['bucket'], $filename, $filepath);
        } catch (OssException $e) {
            E($e->getMessage());
        }
    }
}

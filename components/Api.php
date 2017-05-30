<?php

namespace yiix\components;

use common\models\SystemSetting;
use yiix\components\api\ChunkApi;
use yiix\components\api\ResourceApi;

class Api
{
    /**
     * @var ResourceApi
     */
    public $resource = null;

    /**
     * @var ChunkApi
     */
    public $chunk = null;

    private static $instance = null;

    /**
     * @return bool|string
     */
    public function getCachePath()
    {
        return \Yii::getAlias("@frontend/runtime/cache");
    }

    /**
     * @param $name
     * @return mixed
     */
    public function getConfig($name)
    {
        return SystemSetting::getValue($name);
    }

    public static function instance()
    {
        if (self::$instance == null) {
            self::$instance = new self;
            self::$instance->init();
        }
        return self::$instance;
    }

    private function init()
    {
        $this->resource = ResourceApi::instance();
        $this->chunk = ChunkApi::instance();
    }

    private function __construct() {}
    private function __clone() {}
    private function __wakeup() {}
}
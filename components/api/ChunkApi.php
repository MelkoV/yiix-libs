<?php

namespace yiix\components\api;

use common\models\SiteChunk;

class ChunkApi
{
    private static $instance = null;

    /**
     * @param $name
     * @return null|string
     */
    public function get($name)
    {
        $model = SiteChunk::find()->where(["name" => $name])->one();
        return $model ? $model->content : null;
    }

    public static function instance()
    {
        if (self::$instance == null) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    private function __construct() {}
    private function __clone() {}
    private function __wakeup() {}
}
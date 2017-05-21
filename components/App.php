<?php

namespace yiix\components;

use yiix\components\modx\AdapterEvo;
use yiix\components\modx\Modx;

class App extends \melkov\components\App
{
    const ROLE_PUBLISHER = "publisher";
    const ROLE_EDITOR = "editor";

    const SCENARIO_TRANSFER = "transfer";

    private static $_adapter = null;

    public static function getAdapter()
    {
        if (!self::$_adapter) {
            if (\Yii::$app->modx->version == Modx::EVO) {
                self::$_adapter = new AdapterEvo();
            }
        }
        return self::$_adapter;
    }
}
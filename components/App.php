<?php

namespace yiix\components;

class App extends \melkov\components\App
{
    const ROLE_PUBLISHER = "publisher";
    const ROLE_EDITOR = "editor";

    const DIR_ASC = "ASC";
    const DIR_DESC = "DESK";

    const SCENARIO_TRANSFER = "transfer";

    public static function modx()
    {
        return \Yii::$app->modx;
    }

    public static function api()
    {
        return Api::instance();
    }
}
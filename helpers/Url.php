<?php

namespace yiix\helpers;

class Url
{

    public static function getFrontendUrl()
    {
        if (!\Yii::$app->request) {
            return null;
        }
        $name = explode(".", \Yii::$app->request->serverName);
        if (!$name) {
            return null;
        }
        array_shift($name);
        return "http://" . implode(".", $name);
    }

}
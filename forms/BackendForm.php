<?php

namespace yiix\forms;

use yii\bootstrap\ActiveForm;

class BackendForm extends ActiveForm
{

    public static function begin($config = [])
    {
        if (!isset($config["options"])) {
            $config["options"] = [];
        }
        if (!isset($config["options"]["class"])) {
            $config["options"]["class"] = "";
        }
        $config["options"]["class"] = trim($config["options"]["class"] . " yiix-form");
        return parent::begin($config);
    }
}
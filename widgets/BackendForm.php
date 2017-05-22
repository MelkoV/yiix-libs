<?php

namespace yiix\widgets;

use yii\bootstrap\ActiveForm;

class BackendForm extends ActiveForm
{

    public $fieldClass = 'yiix\widgets\BackendActiveField';

    public static function begin($config = [], $modelName = "")
    {
        if (!isset($config["options"])) {
            $config["options"] = [];
        }
        if (!isset($config["options"]["class"])) {
            $config["options"]["class"] = "";
        }
        $config["options"]["class"] = trim($config["options"]["class"] . " yiix-form");
        $model = explode("\\", $modelName);
        $config["options"]["data-model"] = strtolower(array_pop($model));
        return parent::begin($config);
    }

    /**
     * @inheritdoc
     * @return \yiix\widgets\BackendActiveField the created ActiveField object
     */
    public function field($model, $attribute, $options = [])
    {
        return parent::field($model, $attribute, $options);
    }
}
<?php

namespace yiix\models;

use Yii;
use \yiix\models\base\SystemSetting as BaseSystemSetting;

/**
 * This is the model class for table "system_setting".
 */
class SystemSetting extends BaseSystemSetting
{

    public function rules()
    {
        return array_merge(parent::rules(), [

        ]);
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [

        ]);
    }

    public function attributeDescriptions()
    {
        return [

        ];
    }

}

<?php

namespace yiix\models;

use Yii;
use \yiix\models\base\SystemEvent as BaseSystemEvent;

/**
 * This is the model class for table "system_event".
 */
class SystemEvent extends BaseSystemEvent
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

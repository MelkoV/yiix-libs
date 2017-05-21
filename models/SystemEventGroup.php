<?php

namespace yiix\models;

use Yii;
use \yiix\models\base\SystemEventGroup as BaseSystemEventGroup;

/**
 * This is the model class for table "system_event_group".
 */
class SystemEventGroup extends BaseSystemEventGroup
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

<?php

namespace yiix\models;

use Yii;
use \yiix\models\base\AuthRule as BaseAuthRule;

/**
 * This is the model class for table "auth_rule".
 */
class AuthRule extends BaseAuthRule
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

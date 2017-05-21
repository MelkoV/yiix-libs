<?php

namespace yiix\models;

use Yii;
use \yiix\models\base\AuthItemChild as BaseAuthItemChild;

/**
 * This is the model class for table "auth_item_child".
 */
class AuthItemChild extends BaseAuthItemChild
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

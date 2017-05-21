<?php

namespace yiix\models;

use Yii;
use \yiix\models\base\SiteKeyword as BaseSiteKeyword;

/**
 * This is the model class for table "site_keyword".
 */
class SiteKeyword extends BaseSiteKeyword
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

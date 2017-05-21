<?php

namespace yiix\models;

use Yii;
use \yiix\models\base\SiteModule as BaseSiteModule;

/**
 * This is the model class for table "site_module".
 */
class SiteModule extends BaseSiteModule
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

<?php

namespace yiix\models;

use Yii;
use \yiix\models\base\SitePlugin as BaseSitePlugin;

/**
 * This is the model class for table "site_plugin".
 */
class SitePlugin extends BaseSitePlugin
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

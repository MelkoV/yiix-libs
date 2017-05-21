<?php

namespace yiix\models;

use Yii;
use \yiix\models\base\SitePluginEvent as BaseSitePluginEvent;

/**
 * This is the model class for table "site_plugin_event".
 */
class SitePluginEvent extends BaseSitePluginEvent
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

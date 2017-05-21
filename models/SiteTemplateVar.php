<?php

namespace yiix\models;

use Yii;
use \yiix\models\base\SiteTemplateVar as BaseSiteTemplateVar;

/**
 * This is the model class for table "site_template_var".
 */
class SiteTemplateVar extends BaseSiteTemplateVar
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

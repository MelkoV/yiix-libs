<?php

namespace yiix\models;

use Yii;
use \yiix\models\base\SiteTemplateVarTemplate as BaseSiteTemplateVarTemplate;

/**
 * This is the model class for table "site_template_var_template".
 */
class SiteTemplateVarTemplate extends BaseSiteTemplateVarTemplate
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

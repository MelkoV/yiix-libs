<?php

namespace yiix\models;

use Yii;
use \yiix\models\base\SiteTemplateVarType as BaseSiteTemplateVarType;

/**
 * This is the model class for table "site_template_var_type".
 */
class SiteTemplateVarType extends BaseSiteTemplateVarType
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

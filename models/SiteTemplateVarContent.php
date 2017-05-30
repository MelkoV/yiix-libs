<?php

namespace yiix\models;

use Yii;
use \yiix\models\base\SiteTemplateVarContent as BaseSiteTemplateVarContent;

/**
 * This is the model class for table "site_template_var_content".
 */
class SiteTemplateVarContent extends BaseSiteTemplateVarContent
{

    public $name;

    public function rules()
    {
        return array_merge(parent::rules(), [
            ["name", "safe"],
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

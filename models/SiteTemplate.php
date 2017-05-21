<?php

namespace yiix\models;

use Yii;
use \yiix\models\base\SiteTemplate as BaseSiteTemplate;

/**
 * This is the model class for table "site_template".
 */
class SiteTemplate extends BaseSiteTemplate
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

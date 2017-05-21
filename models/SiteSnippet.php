<?php

namespace yiix\models;

use Yii;
use \yiix\models\base\SiteSnippet as BaseSiteSnippet;

/**
 * This is the model class for table "site_snippet".
 */
class SiteSnippet extends BaseSiteSnippet
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

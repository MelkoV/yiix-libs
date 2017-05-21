<?php

namespace yiix\models;

use Yii;
use \yiix\models\base\SiteMetaTag as BaseSiteMetaTag;

/**
 * This is the model class for table "site_meta_tag".
 */
class SiteMetaTag extends BaseSiteMetaTag
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

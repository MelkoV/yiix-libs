<?php

namespace yiix\models;

use Yii;
use \yiix\models\base\SiteContentMetaTag as BaseSiteContentMetaTag;

/**
 * This is the model class for table "site_content_meta_tag".
 */
class SiteContentMetaTag extends BaseSiteContentMetaTag
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

<?php

namespace yiix\models;

use common\components\App;
use Yii;
use \yiix\models\base\SiteChunk as BaseSiteChunk;

/**
 * This is the model class for table "site_chunk".
 */
class SiteChunk extends BaseSiteChunk
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
            "name" => "<b>". App::modx()->getAdapter()->getChunkName($this->name) . "</b><br />Название чанка",
        ];
    }

}

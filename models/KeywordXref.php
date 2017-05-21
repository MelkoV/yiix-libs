<?php

namespace yiix\models;

use Yii;
use \yiix\models\base\KeywordXref as BaseKeywordXref;

/**
 * This is the model class for table "keyword_xref".
 */
class KeywordXref extends BaseKeywordXref
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

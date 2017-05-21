<?php

namespace yiix\models;

use Yii;
use \yiix\models\base\DocumentGroupName as BaseDocumentGroupName;

/**
 * This is the model class for table "document_group_name".
 */
class DocumentGroupName extends BaseDocumentGroupName
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

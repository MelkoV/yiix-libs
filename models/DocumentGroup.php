<?php

namespace yiix\models;

use Yii;
use \yiix\models\base\DocumentGroup as BaseDocumentGroup;

/**
 * This is the model class for table "document_group".
 */
class DocumentGroup extends BaseDocumentGroup
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

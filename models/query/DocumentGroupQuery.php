<?php

namespace yiix\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\DocumentGroup]].
 *
 * @see \common\models\DocumentGroup
 */
class DocumentGroupQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return \common\models\DocumentGroup[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\DocumentGroup|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}

<?php

namespace yiix\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\KeywordXref]].
 *
 * @see \common\models\KeywordXref
 */
class KeywordXrefQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return \common\models\KeywordXref[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\KeywordXref|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}

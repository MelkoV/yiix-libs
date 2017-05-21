<?php

namespace yiix\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\SystemEventGroup]].
 *
 * @see \common\models\SystemEventGroup
 */
class SystemEventGroupQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return \common\models\SystemEventGroup[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\SystemEventGroup|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}

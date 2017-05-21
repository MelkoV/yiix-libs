<?php

namespace yiix\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\SystemEvent]].
 *
 * @see \common\models\SystemEvent
 */
class SystemEventQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return \common\models\SystemEvent[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\SystemEvent|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}

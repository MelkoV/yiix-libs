<?php

namespace yiix\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\SiteModule]].
 *
 * @see \common\models\SiteModule
 */
class SiteModuleQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return \common\models\SiteModule[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\SiteModule|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}

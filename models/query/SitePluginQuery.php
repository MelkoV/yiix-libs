<?php

namespace yiix\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\SitePlugin]].
 *
 * @see \common\models\SitePlugin
 */
class SitePluginQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return \common\models\SitePlugin[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\SitePlugin|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}

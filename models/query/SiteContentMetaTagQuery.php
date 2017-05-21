<?php

namespace yiix\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\SiteContentMetaTag]].
 *
 * @see \common\models\SiteContentMetaTag
 */
class SiteContentMetaTagQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return \common\models\SiteContentMetaTag[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\SiteContentMetaTag|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}

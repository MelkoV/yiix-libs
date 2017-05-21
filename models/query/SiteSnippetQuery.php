<?php

namespace yiix\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\SiteSnippet]].
 *
 * @see \common\models\SiteSnippet
 */
class SiteSnippetQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return \common\models\SiteSnippet[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\SiteSnippet|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}

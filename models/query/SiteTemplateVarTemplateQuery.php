<?php

namespace yiix\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\SiteTemplateVarTemplate]].
 *
 * @see \common\models\SiteTemplateVarTemplate
 */
class SiteTemplateVarTemplateQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return \common\models\SiteTemplateVarTemplate[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\SiteTemplateVarTemplate|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}

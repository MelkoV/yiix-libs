<?php

namespace yiix\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\SiteTemplateVar]].
 *
 * @see \common\models\SiteTemplateVar
 */
class SiteTemplateVarQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return \common\models\SiteTemplateVar[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\SiteTemplateVar|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function forTemplate($id)
    {
        $this->innerJoin("{{%site_template_var_template}} vt", "vt.template_var_id = [[id]]");
        $this->andWhere("vt.template_id = :id", ["id" => $id]);
        return $this;
    }
}

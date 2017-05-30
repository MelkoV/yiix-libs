<?php

namespace yiix\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\SiteTemplateVarContent]].
 *
 * @see \common\models\SiteTemplateVarContent
 */
class SiteTemplateVarContentQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    public function forContent($contentId, $name)
    {
        $name = is_array($name) ? $name : [$name];
        $this->select("{{%site_template_var_content}}.*, {{%site_template_var}}.name");
        $this->innerJoin("{{%site_template_var}}", "{{%site_template_var}}.id = template_var_id");
        $this->andWhere(["{{%site_template_var}}.name" => $name]);
        $this->andWhere(["content_id" => $contentId]);
        return $this;
    }

    /**
     * @inheritdoc
     * @return \common\models\SiteTemplateVarContent[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\SiteTemplateVarContent|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}

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

    public function forContent($contentId, $name)
    {
        $name = is_array($name) ? $name : [$name];
        $this->select("{{%site_template_var_content}}.value, {{%site_template_var}}.*, {{%site_template_var_type}}.name as type_name");
        $this->innerJoin("{{%site_template_var_type}}", "{{%site_template_var_type}}.id = {{%site_template_var}}.type_id");
        $this->leftJoin("{{%site_template_var_content}}", "({{%site_template_var_content}}.template_var_id = {{%site_template_var}}.id AND {{%site_template_var_content}}.content_id = :content)", ["content" => $contentId]);
        $this->andWhere(["{{%site_template_var}}.name" => $name]);
//        $this->andWhere(["{{%site_template_var_content}}.content_id" => $contentId]);
        return $this;
    }

    public function forTemplate($id)
    {
        $this->innerJoin("{{%site_template_var_template}} vt", "vt.template_var_id = [[id]]");
        $this->andWhere("vt.template_id = :id", ["id" => $id]);
        return $this;
    }
}

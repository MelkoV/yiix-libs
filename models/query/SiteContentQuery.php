<?php

namespace yiix\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\SiteContent]].
 *
 * @see \common\models\SiteContent
 */
class SiteContentQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return \common\models\SiteContent[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\SiteContent|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function withChildCount()
    {
        $this->select("*, (SELECT COUNT(*) FROM {{%site_content}} c2 WHERE c2.parent_id = {{%site_content}}.id) as child_count");
        return $this;
    }

    public function parent($id = null)
    {
        if (!$id) {
            $this->andWhere("parent_id IS NULL");
        } else {
            $this->andWhere(["parent_id" => $id]);
        }
        return $this;
    }

    /**
     * @param string $column
     * @return $this
     */
    public function sort($column = "menu_index")
    {
        $this->orderBy($column);
        return $this;
    }
}

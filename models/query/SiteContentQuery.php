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

    public function active()
    {
        return $this->published()->deleted();
    }

    public function published($published = true)
    {
        if ($published === null) {
            return $this;
        }
        $time = time();
        if ($published) {
            $this->andWhere("[[published]] = :published OR ([[pub_date]] > 0 AND [[pub_date]] < :time)",
                ["published" => $published, "time" => $time]);
            $this->andWhere("[[un_pub_date]] = 0 OR [[un_pub_date]] > :time", ["time" => $time]);
        } else {
            $this->andWhere("[[published]] = :published OR ([[pub_date]] > 0 AND [[pub_date]] > :time) 
                OR ([[un_pub_date]] > 0 AND [[un_pub_date]] < :time)",
                ["published" => $published, "time" => $time]);
        }
        return $this;
    }

    /**
     * @param bool $deleted
     * @return $this
     */
    public function deleted($deleted = false)
    {
        if ($deleted === null) {
            return $this;
        }
        $this->andWhere(["deleted" => $deleted]);
        return $this;
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

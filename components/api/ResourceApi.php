<?php

namespace yiix\components\api;

use common\components\App;
use common\models\SiteContent;

class ResourceApi
{
    private static $instance = null;

    /**
     * @param $id
     * @param bool $published
     * @param bool $deleted
     * @return SiteContent|null
     */
    public function get($id, $published = true, $deleted = false)
    {
        return SiteContent::find()->published($published)->deleted($deleted)->andWhere(["id" => $id])->one();
    }

    /**
     * @param null $parentId
     * @param null $published
     * @param null $deleted
     * @param string $sort
     * @param string $dir
     * @param string|array $where
     * @param null $limit
     * @return SiteContent[]
     */
    public function getChildren($parentId = null, $published = null, $deleted = null, $sort = "menu_index", $dir = App::DIR_ASC, $where = "", $limit = null)
    {
        // todo with TV values
        $finder = SiteContent::find()->parent($parentId)->published($published)->deleted($deleted);
        if ($where) {
            $finder->andWhere($where);
        }
        if ($limit) {
            $finder->limit($limit);
        }
        return $finder->orderBy("[[" . $sort . "]] " . $dir)->all();
    }

    /**
     * @param null $parentId
     * @param int $depth
     * @param array $children
     * @param bool $published
     * @param bool $deleted
     * @param string $sort
     * @param string $dir
     * @return array
     */
    public function getChildIds($parentId = null, $depth = 10, $children = [], $published = null, $deleted = null, $sort = "menu_index", $dir = App::DIR_ASC)
    {
        $ids = [];
        foreach ($this->getChildren($parentId, $published, $deleted, $sort, $dir) as $model) {
            /** @var SiteContent $model */
            $key = $model->alias ? $model->getFullAlias() : "id";
            $children[$key] = $model->id;
            $ids[] = $model->id;
        }
        $depth--;
        return ($depth < 1 || !$ids) ? $children : $this->getChildIds($ids, $depth, $children, $published, $deleted, $sort, $dir);
    }

    public static function instance()
    {
        if (self::$instance == null) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    private function __construct() {}
    private function __clone() {}
    private function __wakeup() {}
}
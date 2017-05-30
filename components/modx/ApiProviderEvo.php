<?php

namespace yiix\components\modx;

use common\components\App;
use yii\helpers\ArrayHelper;

class ApiProviderEvo
{
    private static $instance = null;

    public function addEventListener($evtName, $pluginName)
    {
        //todo; return boolean
    }

    public function changeWebUserPassword($oldPwd, $newPwd)
    {
        //todo; return true or string error
    }

    public function clearCache($type = "")
    {
        // todo; return bool; ignore type
    }

    public function getActiveChildren($id, $sort = "menuindex", $dir = App::DIR_ASC, $fields = "id, pagetitle, description, parent, alias, menutitle")
    {
        return $this->getChildren($id, $sort, $dir, $fields, true, false);
    }

    public function getAllChildren($id, $sort = "menuindex", $dir = App::DIR_ASC, $fields = "id, pagetitle, description, parent, alias, menutitle")
    {
        return $this->getChildren($id, $sort, $dir, $fields);
    }

    public function getCachePath()
    {
        return App::api()->getCachePath();
    }

    public function getChildIds($id, $depth = 10, $children = [])
    {
        return App::api()->resource->getChildIds($id, $depth, $children);
    }

    public function getChunk($name)
    {
        return App::api()->chunk->get($name);
    }

    public function getConfig($name)
    {
        return App::api()->getConfig(App::modx()->getAdapter()->mapSettingName($name));
    }

    public function getDocument($id, $fields = "*", $published = true, $deleted = false)
    {
        $select = $fields == "*" ? [] : App::modx()->getAdapter()->mapFields("site_content", explode(",", $fields));
        $model = App::api()->resource->get($id, $published, $deleted);
        return $model ? $model->asArray($select, [], true) : [];
    }

    public function getDocumentChildren($id, $published = true, $deleted = false, $fields = "*", $where = "", $sort = "menuindex", $dir = App::DIR_ASC, $limit = null)
    {
        return $this->getChildren($id, $sort, $dir, $fields, $published, $deleted, $where, $limit);
    }

    public function getDocumentChildrenTVarOutput($id, $fields = "", $published = true, $sort = "menuindex", $dir = App::DIR_ASC)
    {
        return $this->getChildren($id, $sort, $dir, $fields, $published, false, "", null, true);
    }

    public function getDocumentChildrenTVars($id, $fields = [], $published = true, $sort = "menuindex", $dir = App::DIR_ASC, $tvFields = "*", $tvSort = "rank", $tvDir = App::DIR_ASC)
    {
        return $this->getChildrenTv($id, $sort, $dir, $fields, $published, null, "", null, $tvFields, $tvSort, $tvDir);
    }


    public static function instance()
    {
        if (self::$instance == null) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    private function getChildren($id, $sort = "menuindex", $dir = App::DIR_ASC, $fields = "id, pagetitle, description, parent, alias, menutitle", $published = null, $deleted = null, $where = "", $limit = null, $asAssoc = false)
    {
        $sort = App::modx()->getAdapter()->mapField("site_content", $sort);
        $select = $fields == "*" ? null : App::modx()->getAdapter()->mapFields("site_content", explode(",", $fields));
        $result = [];
        if ($where) {
            $tr = [];
            foreach (App::modx()->getAdapter()->getMap("site_content") as $adapt => $orig) {
                $tr[$adapt] = "[[".$orig."]]";
            }
            $where = strtr($where, $tr);
        }
        foreach (App::api()->resource->getChildren($id, $published, $deleted, $sort, $dir, $where, $limit) as $model) {
            $attrs = $select;
            if ($select) {
                $tv = [];

                foreach ($attrs as $k => $attr) {
                    if (!$model->hasAttribute($attr)) {
                        $tv[] = $attr;
                        unset($attrs[$k]);
                    }
                }
                if ($tv) {
                    $model->loadTv($tv);
                }
            }
            $result[] = $model->asArray($attrs, [], true, $asAssoc);
        }
        if (!$asAssoc) {
            return $result;
        }
        $data = [];
        foreach ($result as  $d) {
            $data = ArrayHelper::merge($data, $d);
        }
        return $data;
    }

    private function getChildrenTv($id, $sort = "menuindex", $dir = App::DIR_ASC, $fields = [], $published = null, $deleted = null, $where = "", $limit = null, $tvFields = "*", $tvSort = "rank", $tvDir = App::DIR_ASC)
    {
        $sort = App::modx()->getAdapter()->mapField("site_content", $sort);
        $select = App::modx()->getAdapter()->mapFields("site_content", $fields);
        $selectTv = $tvFields == "*" ? null : App::modx()->getAdapter()->mapFields("site_template_var", explode(",", $tvFields));

        $result = [];
        if ($where) {
            $tr = [];
            foreach (App::modx()->getAdapter()->getMap("site_content") as $adapt => $orig) {
                $tr[$adapt] = "[[".$orig."]]";
            }
            $where = strtr($where, $tr);
        }
        foreach (App::api()->resource->getChildren($id, $published, $deleted, $sort, $dir, $where, $limit) as $model) {
            $attrs = $select;
            if ($select) {
                $tv = [];

                foreach ($attrs as $k => $attr) {
                    if (!$model->hasAttribute($attr)) {
                        $tv[] = $attr;
                        unset($attrs[$k]);
                    }
                }
                if ($tv) {
                    $model->loadTv($tv, $tvSort, $tvDir);
                }
            }
            $result[] = $model->asTvArray($attrs, [], true, $selectTv, [], true);
        }
        return $result;
    }

    private function __construct() {}
    private function __clone() {}
    private function __wakeup() {}
}
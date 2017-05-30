<?php

namespace yiix\components\modx\base;

use melkov\components\helpers\ArrayHelper;

abstract class Adapter
{
    private $fieldMap = [
        "site_content" => [
            "createdby" => "created_by", "editedby" => "edited_by", "deletedby" => "deleted_by",
            "publishedby" => "published_by", "template" => "template_id", "contentType" => "content_type",
            "pagetitle" => "page_title", "longtitle" => "long_title", "unpub_date" => "un_pub_date",
            "isfolder" => "is_folder", "introtext" => "intro_text", "richtext" => "rich_text",
            "menuindex" => "menu_index", "createdon" => "created_on", "editedon" => "edited_on",
            "deletedon" => "deleted_on", "publishedon" => "published_on", "menutitle" => "menu_title",
            "privateweb" => "private_web", "privatemgr" => "private_mgr", "hidemenu" => "hide_menu",
            "parent" => "parent_id"
        ],
        "site_template_var" => [
            "category" => "category_id", "type" => "type_name"
        ],
    ];

    private $backFieldMap = [];

    public function getMap($table)
    {
        return $this->fieldMap[$table];
    }

    public function mapField($table, $field)
    {
        return (isset($this->fieldMap[$table]) && isset($this->fieldMap[$table][$field])) ?
            $this->fieldMap[$table][$field] : $field;
    }

    public function mapFields($table, array $fields)
    {
        $result = [];
        foreach ($fields as $field) {
            $result[] = $this->mapField($table, trim($field));
        }
        return $result;
    }

    public function mapAllFields($table)
    {
        return array_values($this->fieldMap[$table]);
    }

    public function backMapFields($table, array $fields)
    {
        $result = [];
        $isAssoc = ArrayHelper::isAssociative($fields);
        foreach ($fields as $k => $v) {
            if ($isAssoc) {
                $result[$this->backMapField($table, trim($k))] = $v;
            } else {
                $result[] = $this->backMapField($table, trim($v));
            }
        }
        return $result;
    }

    public function backMapField($table, $field)
    {
        if (!isset($this->backFieldMap[$table])) {
            $this->fillBackFieldMap($table);
        }
        return (isset($this->backFieldMap[$table]) && isset($this->backFieldMap[$table][$field])) ?
            $this->backFieldMap[$table][$field] : $field;
    }

    private function fillBackFieldMap($table)
    {
        $this->backFieldMap[$table] = array();
        if (isset($this->fieldMap[$table])) {
            $this->backFieldMap[$table] = array_flip($this->fieldMap[$table]);
        }
    }

    abstract public function getResourceField($name);
    abstract public function getSnippetName($name);
    abstract public function getChunkName($name);
    abstract public function mapSettingName($name);
}
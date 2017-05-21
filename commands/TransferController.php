<?php

namespace yiix\commands;

use common\components\App;
use common\models\SiteTemplateVarType;
use common\models\SystemEventGroup;
use common\models\SystemSetting;
use common\models\User;
use yii\console\Controller;

class TransferController extends Controller
{

    private $user = [];
    private $role = [];
    private $content = [];
    private $smodule = [];
    private $event = [];
    private $eventGroup = [];
    private $tvType = [];
    private $parents = [];


    /**
     * Transfer DB data from ModX Evo to YiiX
     */
    public function actionEvo()
    {
        echo "\nStart transfer from ModX Evo to YiiX\n";

        $transaction = \Yii::$app->db->beginTransaction();

        $defaultAdminId = null;

        echo "Users...";
        $defaultRole = \Yii::$app->authManager->getRole(App::ROLE_USER);
        foreach (\Yii::$app->dbModx->createCommand("SELECT * FROM {{%user_roles}}")->queryAll() as $record) {
            switch ($record["name"]) {
                case "Editor":
                    $role = \Yii::$app->authManager->getRole(App::ROLE_EDITOR);
                    $role->description = $record["description"];
                    \Yii::$app->authManager->update(App::ROLE_EDITOR, $role);
                    break;
                case "Publisher":
                    $role = \Yii::$app->authManager->getRole(App::ROLE_PUBLISHER);
                    $role->description = $record["description"];
                    \Yii::$app->authManager->update(App::ROLE_PUBLISHER, $role);
                    break;
                case "Administrator":
                    $role = \Yii::$app->authManager->getRole(App::ROLE_ADMIN);
                    $role->description = $record["description"];
                    \Yii::$app->authManager->update(App::ROLE_ADMIN, $role);
                    break;
                default:
                    $role = $defaultRole;
                    break;
            }
            $this->role[$record["id"]] = $role;
        }
        foreach (\Yii::$app->dbModx->createCommand("SELECT u.*, m.username, m.password FROM {{%user_attributes}} u JOIN {{%manager_users}} m ON m.id = u.id")->queryAll() as $record) {
            $record["password_hash"] = $record["password"];
            $record["name"] = $record["fullname"];
            $record["mobile_phone"] = $record["mobilephone"];
            $model = new User();
            $model->setAttributes($record);
            $model->generateAuthKey();
            $model->save();
            $this->user[$record["id"]] = $model->id;
            if ($record["role"] && isset($this->role[$record["role"]])) {
                \Yii::$app->authManager->assign($this->role[$record["role"]], $model->id);
                if ($this->role[$record["role"]]->name == App::ROLE_ADMIN && !$defaultAdminId) {
                    $defaultAdminId = $model->id;
                }
            }

        }
        echo " OK\n";

        echo "Categories...";
        foreach (\Yii::$app->dbModx->createCommand("SELECT * FROM {{%categories}}")->queryAll() as $record) {
            $data = $this->format($record, ["category" => "name"]);
            \Yii::$app->db->createCommand()->insert("{{%category}}", $data)->execute();
        }
        echo " OK\n";

        echo "Site templates...";
        foreach (\Yii::$app->dbModx->createCommand("SELECT * FROM {{%site_templates}}")->queryAll() as $record) {
            $record["category_id"] = $record["category"] ? : null;
            $data = $this->format($record, ["templatename" => "name", "template_type" => "type"], ["category"]);
            \Yii::$app->db->createCommand()->insert("{{%site_template}}", $data)->execute();
        }
        echo " OK\n";

        echo "Site content...";
        foreach (\Yii::$app->dbModx->createCommand("SELECT * FROM {{%site_content}}")->queryAll() as $record) {
            if ($record["parent"]) {
                $this->parents[$record["id"]] = $record["parent"];
            }
            $record["created_by"] = ($record["createdby"] && isset($this->user[$record["createdby"]])) ? $this->user[$record["createdby"]] : $defaultAdminId;
            $record["edited_by"] = ($record["editedby"] && isset($this->user[$record["editedby"]])) ? $this->user[$record["editedby"]] : null;
            $record["deleted_by"] = ($record["deletedby"] && isset($this->user[$record["deletedby"]])) ? $this->user[$record["deletedby"]] : null;
            $record["published_by"] = ($record["publishedby"] && isset($this->user[$record["publishedby"]])) ? $this->user[$record["publishedby"]] : null;

            $data = $this->format($record, [
                "template" => "template_id", "contentType" => "content_type", "pagetitle" => "page_title",
                "longtitle" => "long_title", "unpub_date" => "un_pub_date", "isfolder" => "is_folder",
                "introtext" => "intro_text", "richtext" => "rich_text", "menuindex" => "menu_index",
                "createdon" => "created_on", "editedon" => "edited_on", "deletedon" => "deleted_on",
                "publishedon" => "published_on", "menutitle" => "menu_title", "privateweb" => "private_web",
                "privatemgr" => "private_mgr", "hidemenu" => "hide_menu"
                ], ["createdby", "editedby", "deletedby", "publishedby", "parent", "donthit", "haskeywords",
                "hasmetatags"]);

            \Yii::$app->db->createCommand()->insert("{{%site_content}}", $data)->execute();
            $this->content[$record["id"]] = $record["id"];
        }
        foreach ($this->parents as $child => $parent) {
            if (isset($this->content[$child]) && isset($this->content[$parent])) {
                \Yii::$app->db->createCommand()->update("{{%site_content}}", ["parent_id" => $this->content[$parent]], "id = :id", [":id" => $this->content[$child]])->execute();
            }
        }
        echo " OK\n";

        echo "Site chunks...";
        foreach (\Yii::$app->dbModx->createCommand("SELECT * FROM {{%site_htmlsnippets}}")->queryAll() as $record) {
            $record["category_id"] = $record["category"] ? : null;
            $data = $this->format($record, ["snippet" => "content"], ["category", "editor_name", "cache_type"]);
            \Yii::$app->db->createCommand()->insert("{{%site_chunk}}", $data)->execute();
        }
        echo " OK\n";

        echo "Site modules...";
        foreach (\Yii::$app->dbModx->createCommand("SELECT * FROM {{%site_modules}}")->queryAll() as $record) {
            $record["category_id"] = $record["category"] ? : null;

            $data = $this->format($record, ["createdon" => "created_on", "editedon" => "edited_on",
                "enable_sharedparams" => "enable_shared_params", "modulecode" => "code"], ["category", "wrap",
                "enable_resource", "resourcefile", "properties"]);
            \Yii::$app->db->createCommand()->insert("{{%site_module}}", $data)->execute();
            if ($record["guid"]) {
                $this->smodule[$record["guid"]] = $record["id"];
            }
        }
        echo " OK\n";

        echo "Site plugins...";
        foreach (\Yii::$app->dbModx->createCommand("SELECT * FROM {{%site_plugins}}")->queryAll() as $record) {
            $record["category_id"] = $record["category"] ? : null;
            $record["module_id"] = ($record["moduleguid"] && isset($this->smodule[$record["moduleguid"]])) ? $this->smodule[$record["moduleguid"]] : null;
            $record["code"] = $record["plugincode"];
            $data = $this->format($record, ["plugincode" => "code"], ["category", "moduleguid", "cache_type"]);
            \Yii::$app->db->createCommand()->insert("{{%site_plugin}}", $data)->execute();
        }
        echo " OK\n";

        echo "System events...";
        foreach (\Yii::$app->dbModx->createCommand("SELECT * FROM {{%system_eventnames}}")->queryAll() as $record) {
            $record["group_id"] = null;
            if ($record["groupname"]) {
                if (isset($this->eventGroup[$record["groupname"]])) {
                    $record["group_id"] = $this->eventGroup[$record["groupname"]];
                } else {
                    $group = new SystemEventGroup();
                    $group->name = $record["groupname"];
                    $group->save();
                    $this->eventGroup[$record["groupname"]] = $record["group_id"] = $group->id;
                }
            }
            \Yii::$app->db->createCommand()->insert("{{%system_event}}", $this->format($record, [], ["groupname"]))->execute();
            $this->event[$record["id"]] = $record["id"];
        }
        echo " OK\n";

        echo "Site plugin events...";
        foreach (\Yii::$app->dbModx->createCommand("SELECT * FROM {{%site_plugin_events}}")->queryAll() as $record) {
            $data = $this->format($record, ["pluginid" => "plugin_id", "evtid" => "event_id"]);
            \Yii::$app->db->createCommand()->insert("{{%site_plugin_event}}", $data)->execute();
        }
        echo " OK\n";

        echo "Site snippets...";
        foreach (\Yii::$app->dbModx->createCommand("SELECT * FROM {{%site_snippets}}")->queryAll() as $record) {
            $record["category_id"] = $record["category"] ? : null;
            $record["module_id"] = ($record["moduleguid"] && isset($this->smodule[$record["moduleguid"]])) ? $this->smodule[$record["moduleguid"]] : null;
            $record["code"] = $record["snippet"];
            $data = $this->format($record, ["snippet" => "code"], ["category", "moduleguid", "cache_type"]);
            \Yii::$app->db->createCommand()->insert("{{%site_snippet}}", $data)->execute();
        }
        echo " OK\n";

        echo "Site template vars...";
        foreach (\Yii::$app->dbModx->createCommand("SELECT * FROM {{%site_tmplvars}}")->queryAll() as $record) {
            $record["type_id"] = null;
            if ($record["type"]) {
                $record["type"] = ucfirst(trim($record["type"]));
                if (isset($this->tvType[$record["type"]])) {
                    $record["type_id"] = $this->tvType[$record["type"]];
                } else {
                    $group = new SiteTemplateVarType();
                    $group->name = $record["type"];
                    $group->save();
                    $this->tvType[$record["type"]] = $record["type_id"] = $group->id;
                }
            }
            $record["category_id"] = $record["category"] ? : null;
            $data = $this->format($record, [], ["category", "type"]);
            \Yii::$app->db->createCommand()->insert("{{%site_template_var}}", $data)->execute();
        }
        echo " OK\n";

        echo "Site template var contents...";
        foreach (\Yii::$app->dbModx->createCommand("SELECT * FROM {{%site_tmplvar_contentvalues}}")->queryAll() as $record) {
            $data = $this->format($record, ["tmplvarid" => "template_var_id", "contentid" => "content_id"]);
            \Yii::$app->db->createCommand()->insert("{{%site_template_var_content}}", $data)->execute();
        }
        echo " OK\n";

        echo "Site template var templates...";
        foreach (\Yii::$app->dbModx->createCommand("SELECT * FROM {{%site_tmplvar_templates}}")->queryAll() as $record) {
            $data = $this->format($record, ["tmplvarid" => "template_var_id", "templateid" => "template_id"]);
            \Yii::$app->db->createCommand()->insert("{{%site_template_var_template}}", $data)->execute();
        }
        echo " OK\n";

        echo "System settings...";
        foreach (\Yii::$app->dbModx->createCommand("SELECT * FROM {{%system_settings}}")->queryAll() as $record) {
            $record["name"] = $record["setting_name"];
            $record["value"] = $record["setting_value"];
            $model = new SystemSetting();
            $model->setAttributes($record);
            $model->save();
        }
        echo " OK\n";

        echo "Document groups...";
        foreach (\Yii::$app->dbModx->createCommand("SELECT * FROM {{%documentgroup_names}}")->queryAll() as $record) {
            $data = $this->format($record, ["private_memgroup" => "private_mem_group", "private_webgroup" => "private_web_group"]);
            \Yii::$app->db->createCommand()->insert("{{%document_group_name}}", $data)->execute();
        }
        foreach (\Yii::$app->dbModx->createCommand("SELECT * FROM {{%document_groups}}")->queryAll() as $record) {
            $data = $this->format($record, ["document_group" => "document_group_id", "document" => "document_id"]);
            \Yii::$app->db->createCommand()->insert("{{%document_group}}", $data)->execute();
        }
        echo " OK\n";

        echo "Site keywords...";
        foreach (\Yii::$app->dbModx->createCommand("SELECT * FROM {{%site_keywords}}")->queryAll() as $record) {
            \Yii::$app->db->createCommand()->insert("{{%site_keyword}}", $record)->execute();
        }
        foreach (\Yii::$app->dbModx->createCommand("SELECT * FROM {{%keyword_xref}}")->queryAll() as $record) {
            \Yii::$app->db->createCommand()->insert("{{%keyword_xref}}", $record)->execute();
        }
        echo " OK\n";

        echo "Site content meta tags...";
        foreach (\Yii::$app->dbModx->createCommand("SELECT * FROM {{%site_metatags}}")->queryAll() as $record) {
            $data = $this->format($record, ["tag_value" => "value"]);
            \Yii::$app->db->createCommand()->insert("{{%site_meta_tag}}", $data)->execute();
        }
        foreach (\Yii::$app->dbModx->createCommand("SELECT * FROM {{%site_content_metatags}}")->queryAll() as $record) {
            $data = $this->format($record, ["metatag_id" => "meta_tag_id"]);
            \Yii::$app->db->createCommand()->insert("{{%site_content_meta_tag}}", $data)->execute();
        }
        echo " OK\n";

        $this->loadCustomTables();

        $transaction->commit();
    }



    /**
     * @param $data
     * @param $replace
     * @param array $exclude
     * @return array
     */
    private function format($data, $replace, $exclude = [])
    {
        $newData = [];
        foreach ($data as $k => $v) {
            if (in_array($k, $exclude)) {
                continue;
            }
            if (isset($replace[$k])) {
                $k = $replace[$k];
            }
            $newData[$k] = $v;
        }
        return $newData;
    }

    private function loadCustomTables()
    {
        echo "\nStart custom tables...\n\n";
        $exclude = ["active_users", "active_user_locks", "active_user_sessions", "categories", "documentgroup_names",
            "document_groups", "event_log", "keyword_xref", "manager_log", "manager_users", "membergroup_access",
            "membergroup_names", "member_groups", "site_content", "site_content_metatags", "site_htmlsnippets",
            "site_keywords", "site_metatags", "site_modules", "site_module_access", "site_module_depobj",
            "site_plugins", "site_plugin_events", "site_snippets", "site_templates", "site_tmplvars", "site_tmplvar_access",
            "site_tmplvar_contentvalues", "site_tmplvar_templates", "system_eventnames", "system_settings", "user_attributes",
            "user_messages", "user_roles", "user_settings", "webgroup_access", "webgroup_names", "web_groups",
            "web_users", "web_user_attributes", "web_user_settings"];
        $tableOptions = null;
        if (\Yii::$app->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        foreach (\Yii::$app->dbModx->getSchema()->tableNames as $tableName) {
            $fullTableName = $tableName;
            if (\Yii::$app->dbModx->tablePrefix) {
                if (strpos($tableName, \Yii::$app->dbModx->tablePrefix) === 0) {
                    $tableName = substr($tableName, strlen(\Yii::$app->dbModx->tablePrefix));
                } else {
                    continue;
                }
            }
            if (in_array($tableName, $exclude)) {
                continue;
            }
            echo $tableName . "... ";
            $columns = [];
            $pkLoad = false;
            $schema = \Yii::$app->dbModx->getTableSchema($fullTableName);

            foreach ($schema->columns as $name => $column) {
                if ($column->autoIncrement && $column->isPrimaryKey) {
                    $type = "pk";
                    $pkLoad = true;
                } else {
                    $type = $column->type;
                    // fixme fix for easy2_comments ip_address
                    if ($type == "char") {
                        $type = "char(16)";
                    }
                    if (!$column->allowNull) {
                        $type .= " NOT NULL";
                    }
                    if ($column->defaultValue) {
                        // fixme fix for easy2_comments dates
                        if ($column->type != "datetime") {
                            $val = $column->defaultValue;
                            if ($column->phpType == "string") {
                                $val = "'" . $val . "'";
                            }
                            $type .= " DEFAULT " . $val;
                        }
                    }
                }
                $columns[$name] = $type;
            }
            \Yii::$app->db->createCommand()->createTable("{{%".$tableName."}}", $columns, $tableOptions)->execute();
            if ($schema->primaryKey && !$pkLoad) {
                \Yii::$app->db->createCommand()->addPrimaryKey($tableName, "{{%".$tableName."}}", $schema->primaryKey);
            }
            foreach (\Yii::$app->dbModx->createCommand("SELECT * FROM {{%".$tableName."}}")->queryAll() as $record) {
                \Yii::$app->db->createCommand()->insert("{{%".$tableName."}}", $record)->execute();
            }
            echo "OK\n";
        }
    }

}
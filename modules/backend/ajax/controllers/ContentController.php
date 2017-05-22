<?php

namespace yiix\modules\backend\ajax\controllers;

use backend\components\Controller;
use common\models\SiteContent;
use common\models\SiteTemplateVarContent;
use melkov\components\CurrentUser;

class ContentController extends Controller
{
//    public $layout = "//empty";

    public function actionList($parent = null, $modal = false)
    {
        if ($modal && $modal == "true") {
            $modal = true;
        } else {
            $modal = false;
        }
        return ["html" => $this->renderPartial("//elements/resources", ["parent" => $parent, "forModal" => $modal])];
    }

    public function actionView($id)
    {
        $model = SiteContent::findOne($id);
        $oldParent = $model->parent_id;
        $oldTmpl = $model->template_id;
        if ($model->load(\Yii::$app->request->post())) {
            if (!$model->parent_id) {
                $model->parent_id = null;
            }
            // todo сделать нормально и красиво
            $dates = ["published_on", "pub_date", "un_pub_date"];
            foreach ($dates as $date) {
                if ($model->$date) {
                    $model->$date = strtotime($model->$date);
                } else {
                    $model->$date = 0;
                }
            }
            $actions = [];

            if ($model->isAttributeChanged("page_title")) {
                $actions[] = ["action" => "update_page_title", "value" => $model->page_title];
            }
            if ($model->validate() && $model->save()) {
                if (isset($_POST["SiteContent"]["tv"])) {
                    if (is_array($_POST["SiteContent"]["tv"])) {
                        foreach ($_POST["SiteContent"]["tv"] as $varId => $value) {
                            $model->setTvValue($varId, $value);
                        }
                    }
                }

                if ($model->parent_id != $oldParent) {
                    $tree = "";
                    $forId = null;
                    foreach ($model->getAllParentIds() as $pid) {
                        $tree = $this->renderPartial("//elements/resources", ["parent" => $pid, "child" => $tree, "childFor" => $forId]);
                        $forId = $pid;
                    }
                    $actions[] = ["action" => "update_tree_list", "value" => $tree];
                }
                if ($model->template_id != $oldTmpl) {
                    $actions[] = ["action" => "routing", "value" => "/content/view/" . $model->id];
                }
                return ["success" => true, "actions" => $actions, "success_message" => "Документ \"".$model->page_title."\" успешно обновлен"];
            } else {
                return ["success" => false, "errors" => $model->getErrors()];
            }
        }
        return [
            "title" => $model->page_title,
            "html" => $this->renderPartial("//content/form", ["model" => $model])
        ];
    }

    public function actionNew()
    {
        $model = new SiteContent();
        $model->page_title = "Новый документ";
        $model->menu_index = 0;

        if ($model->load(\Yii::$app->request->post())) {
            $model->created_on = time();
            $model->created_by = CurrentUser::getId();
            if (!$model->parent_id) {
                $model->parent_id = null;
            }
            // todo сделать нормально и красиво
            $dates = ["published_on", "pub_date", "un_pub_date"];
            foreach ($dates as $date) {
                if ($model->$date) {
                    $model->$date = strtotime($model->$date);
                } else {
                    $model->$date = 0;
                }
            }
            $actions = [];


            if ($model->validate() && $model->save()) {

                    $tree = "";
                    $forId = null;
                    foreach ($model->getAllParentIds() as $pid) {
                        $tree = $this->renderPartial("//elements/resources", ["parent" => $pid, "child" => $tree, "childFor" => $forId]);
                        $forId = $pid;
                    }
                    $actions[] = ["action" => "update_tree_list", "value" => $tree];
                    $actions[] = ["action" => "routing", "value" => "/content/view/" . $model->id];

                if (isset($_POST["SiteContent"]["tv"])) {
                    if (is_array($_POST["SiteContent"]["tv"])) {
                        foreach ($_POST["SiteContent"]["tv"] as $varId => $value) {
                            $model->setTvValue($varId, $value);
                        }
                    }
                }

                return ["success" => true, "actions" => $actions, "success_message" => "Документ \"".$model->page_title."\" успешно создан"];
            } else {
                return ["success" => false, "errors" => $model->getErrors()];
            }
        }
        return [
            "title" => $model->page_title,
            "html" => $this->renderPartial("//content/form", ["model" => $model])
        ];
    }
}
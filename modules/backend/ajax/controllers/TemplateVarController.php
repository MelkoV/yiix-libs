<?php

namespace yiix\modules\backend\ajax\controllers;

use backend\components\Controller;
use common\models\SiteTemplateVar;
use common\models\SiteTemplateVarTemplate;

class TemplateVarController extends Controller
{
//    public $layout = "//empty";

    public function actionList()
    {
        return ["html" => $this->renderPartial("//elements/templates")];
    }

    public function actionView($id)
    {
        $model = SiteTemplateVar::findOne($id);
        if ($model->load(\Yii::$app->request->post())) {

            $actions = [];

            if ($model->isAttributeChanged("name")) {
                $actions[] = ["action" => "update_page_title", "value" => $model->name];
            }
            if ($model->validate() && $model->save()) {
                if (isset($_POST["SiteTemplateVar"]["templates"])) {
                    SiteTemplateVarTemplate::deleteAll(["template_var_id" => $model->id]);
                    if (is_array($_POST["SiteTemplateVar"]["templates"])) {
                        foreach ($_POST["SiteTemplateVar"]["templates"] as $tmpl) {
                            \Yii::$app->db->createCommand()->insert("{{%site_template_var_template}}", ["template_id" => $tmpl, "template_var_id" => $model->id])->execute();
                        }
                    }
                }

                $actions[] = ["action" => "update_template_var_list", "value" => $this->renderPartial("//elements/template_vars")];
                return ["success" => true, "actions" => $actions, "success_message" => "Параметр \"".$model->name."\" успешно обновлен"];
            } else {
                return ["success" => false, "errors" => $model->getErrors()];
            }
        }
        return [
            "title" => $model->name,
            "html" => $this->renderPartial("//template-var/form", ["model" => $model])
        ];
    }

    public function actionNew()
    {
        $model = new SiteTemplateVar();
        $model->name = "Новый параметр";

        if ($model->load(\Yii::$app->request->post())) {
            $actions = [];


            if ($model->validate() && $model->save()) {
                if (isset($_POST["SiteTemplateVar"]["templates"])) {
//                    SiteTemplateVarTemplate::deleteAll(["template_var_id" => $model->id]);
                    if (is_array($_POST["SiteTemplateVar"]["templates"])) {
                        foreach ($_POST["SiteTemplateVar"]["templates"] as $tmpl) {
                            \Yii::$app->db->createCommand()->insert("{{%site_template_var_template}}", ["template_id" => $tmpl, "template_var_id" => $model->id])->execute();
                        }
                    }
                }

                $actions[] = ["action" => "update_template_var_list", "value" => $this->renderPartial("//elements/template_vars")];


                $actions[] = ["action" => "routing", "value" => "/template-var/view/" . $model->id];

                return ["success" => true, "actions" => $actions, "success_message" => "Параметр \"".$model->name."\" успешно создан"];
            } else {
                return ["success" => false, "errors" => $model->getErrors()];
            }
        }
        return [
            "title" => $model->name,
            "html" => $this->renderPartial("//template-var/form", ["model" => $model])
        ];
    }
}
<?php

namespace yiix\modules\backend\ajax\controllers;

use backend\components\Controller;
use common\models\SiteTemplate;
use melkov\components\CurrentUser;

class TemplateController extends Controller
{
//    public $layout = "//empty";

    public function actionList()
    {
        return ["html" => $this->renderPartial("//elements/templates")];
    }

    public function actionView($id)
    {
        $model = SiteTemplate::findOne($id);
        if ($model->load(\Yii::$app->request->post())) {

            $actions = [];

            if ($model->isAttributeChanged("name")) {
                $actions[] = ["action" => "update_page_title", "value" => $model->name];
            }
            if ($model->validate() && $model->save()) {
                $actions[] = ["action" => "update_template_list", "value" => $this->renderPartial("//elements/templates")];
                return ["success" => true, "actions" => $actions, "success_message" => "Шаблон \"".$model->name."\" успешно обновлен"];
            } else {
                return ["success" => false, "errors" => $model->getErrors()];
            }
        }
        return [
            "title" => $model->name,
            "html" => $this->renderPartial("//template/form", ["model" => $model])
        ];
    }

    public function actionNew()
    {
        $model = new SiteTemplate();
        $model->name = "Новый шаблон";

        if ($model->load(\Yii::$app->request->post())) {
           $actions = [];


            if ($model->validate() && $model->save()) {


                $actions[] = ["action" => "update_template_list", "value" => $this->renderPartial("//elements/templates")];


                $actions[] = ["action" => "routing", "value" => "/template/view/" . $model->id];

                return ["success" => true, "actions" => $actions, "success_message" => "Шаблон \"".$model->name."\" успешно создан"];
            } else {
                return ["success" => false, "errors" => $model->getErrors()];
            }
        }
        return [
            "title" => $model->name,
            "html" => $this->renderPartial("//template/form", ["model" => $model])
        ];
    }
}
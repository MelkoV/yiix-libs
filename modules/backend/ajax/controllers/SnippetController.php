<?php

namespace yiix\modules\backend\ajax\controllers;

use backend\components\Controller;
use common\models\SiteSnippet;

class SnippetController extends Controller
{
//    public $layout = "//empty";

    public function actionList()
    {
        return ["html" => $this->renderPartial("//elements/templates")];
    }

    public function actionView($id)
    {
        $model = SiteSnippet::findOne($id);
        if ($model->load(\Yii::$app->request->post())) {

            $actions = [];

            if ($model->isAttributeChanged("name")) {
                $actions[] = ["action" => "update_page_title", "value" => $model->name];
            }
            if ($model->validate() && $model->save()) {
                $actions[] = ["action" => "update_snippet_list", "value" => $this->renderPartial("//elements/snippets")];
                return ["success" => true, "actions" => $actions, "success_message" => "Сниппет \"".$model->name."\" успешно обновлен"];
            } else {
                return ["success" => false, "errors" => $model->getErrors()];
            }
        }
        return [
            "title" => $model->name,
            "html" => $this->renderPartial("//snippet/form", ["model" => $model])
        ];
    }

    public function actionNew()
    {
        $model = new SiteSnippet();
        $model->name = "Новый сниппет";

        if ($model->load(\Yii::$app->request->post())) {
            $actions = [];


            if ($model->validate() && $model->save()) {


                $actions[] = ["action" => "update_snippet_list", "value" => $this->renderPartial("//elements/snippets")];


                $actions[] = ["action" => "routing", "value" => "/snippet/view/" . $model->id];

                return ["success" => true, "actions" => $actions, "success_message" => "Сниппет \"".$model->name."\" успешно создан"];
            } else {
                return ["success" => false, "errors" => $model->getErrors()];
            }
        }
        return [
            "title" => $model->name,
            "html" => $this->renderPartial("//snippet/form", ["model" => $model])
        ];
    }
}
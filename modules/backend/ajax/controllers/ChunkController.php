<?php

namespace yiix\modules\backend\ajax\controllers;

use backend\components\Controller;
use common\models\SiteChunk;

class ChunkController extends Controller
{
//    public $layout = "//empty";

    public function actionList()
    {
        return ["html" => $this->renderPartial("//elements/templates")];
    }

    public function actionView($id)
    {
        $model = SiteChunk::findOne($id);
        if ($model->load(\Yii::$app->request->post())) {

            $actions = [];

            if ($model->isAttributeChanged("name")) {
                $actions[] = ["action" => "update_page_title", "value" => $model->name];
            }
            if ($model->validate() && $model->save()) {
                $actions[] = ["action" => "update_chunk_list", "value" => $this->renderPartial("//elements/chunks")];
                return ["success" => true, "actions" => $actions, "success_message" => "Чанк \"".$model->name."\" успешно обновлен"];
            } else {
                return ["success" => false, "errors" => $model->getErrors()];
            }
        }
        return [
            "title" => $model->name,
            "html" => $this->renderPartial("//chunk/form", ["model" => $model])
        ];
    }

    public function actionNew()
    {
        $model = new SiteChunk();
        $model->name = "Новый чанк";

        if ($model->load(\Yii::$app->request->post())) {
            $actions = [];


            if ($model->validate() && $model->save()) {


                $actions[] = ["action" => "update_chunk_list", "value" => $this->renderPartial("//elements/chunks")];


                $actions[] = ["action" => "routing", "value" => "/chunk/view/" . $model->id];

                return ["success" => true, "actions" => $actions, "success_message" => "Чанк \"".$model->name."\" успешно создан"];
            } else {
                return ["success" => false, "errors" => $model->getErrors()];
            }
        }
        return [
            "title" => $model->name,
            "html" => $this->renderPartial("//chunk/form", ["model" => $model])
        ];
    }
}
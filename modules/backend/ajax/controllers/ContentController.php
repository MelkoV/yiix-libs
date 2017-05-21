<?php

namespace yiix\modules\backend\ajax\controllers;

use backend\components\Controller;
use common\models\SiteContent;

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
        return [
            "title" => $model->page_title,
            "html" => $this->renderPartial("//content/form", ["model" => $model])
        ];
    }
}
<?php

namespace yiix\models;

use common\components\App;
use common\models\SiteTemplateVarContent as CommonVarContent;
use Yii;
use \yiix\models\base\SiteTemplateVar as BaseSiteTemplateVar;

/**
 * This is the model class for table "site_template_var".
 */
class SiteTemplateVar extends BaseSiteTemplateVar
{

    public $value = null;
    public $type_name = null;

    public function rules()
    {
        return array_merge(parent::rules(), [
            [["value", "type_name"], "safe"],
        ]);
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [

        ]);
    }

    public function attributeDescriptions()
    {
        return [
            "caption" => "<b>Заголовок</b><br />Будет отображаться в списке TV документа",
            "name" => "<b>". App::modx()->getAdapter()->getResourceField($this->name) . "</b><br />Название параметра",
        ];
    }

    /**
     * @param $id
     * @return string
     */
    public function getValueForContent($id)
    {
        $value = CommonVarContent::find()->where(["content_id" => $id, "template_var_id" => $this->id])->one();
        return $value ? $value->value : $this->default_text;
    }

}

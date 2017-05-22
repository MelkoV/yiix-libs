<?php

namespace yiix\models;

use common\components\App;
use common\models\SiteTemplateVar as CommonTemplateVar;
use common\models\SiteTemplateVarContent as CommonTemplateVarContent;
use Yii;
use \yiix\models\base\SiteContent as BaseSiteContent;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "site_content".
 */
class SiteContent extends BaseSiteContent
{

    const TYPE_DOCUMENT = "document";
    const TYPE_REFERENCE = "reference";

    const CONTENT_TYPE_HTML = "text/html";

    const CONTENT_DISPO_INLINE = 0;
    const CONTENT_DISPO_ATTACHMENT = 1;

    public $child_count = 0;

    /**
     * @param null $parent
     * @return SiteContent[]
     */
    public static function getLevel($parent = null)
    {
        return SiteContent::find()->withChildCount()->parent($parent)->sort()->all();
    }

    public function rules()
    {
        return array_merge(parent::rules(), [
            ["page_title", "required"],
            ["child_count", "safe"],
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
            "page_title" => "<b>". App::getAdapter()->getResourceField("page_title") . "</b><br />Имя/заголовок ресурса",
            "alias" => "<b>". App::getAdapter()->getResourceField("alias") . "</b><br />Псевдоним ресурса позволяет обращаться к ресурсу через Дружественные URL",
            "cacheable" => "<b>". App::getAdapter()->getResourceField("cacheable") . "</b><br />Не используется в YiiX",
            "is_folder" => "<b>". App::getAdapter()->getResourceField("is_folder") . "</b><br />Включение этой опции позволяет ресурсу быть контейнером для других ресурсов",
            "content_dispo" => "<b>". App::getAdapter()->getResourceField("content_dispo") . "</b><br />Параметр определяет, как браузер будет обрабатывать содержимое",
            "content_type" => "<b>". App::getAdapter()->getResourceField("content_type") . "</b><br />Выберите тип содержимого ресурса",
            "deleted" => "<b>". App::getAdapter()->getResourceField("deleted") . "</b><br />",
            "hide_menu" => "<b>". App::getAdapter()->getResourceField("hide_menu") . "</b><br />",
            "intro_text" => "<b>". App::getAdapter()->getResourceField("intro_text") . "</b><br />Краткое описание ресурса",
            "link_attributes" => "<b>". App::getAdapter()->getResourceField("intro_text") . "</b><br />Здесь Вы можете указать атрибуты ссылки",
            "long_title" => "<b>". App::getAdapter()->getResourceField("long_title") . "</b><br />Здесь Вы можете ввести расширенный заголовок",
            "menu_index" => "<b>". App::getAdapter()->getResourceField("menu_index") . "</b><br />Порядковый номер ресурса в меню",
            "menu_title" => "<b>". App::getAdapter()->getResourceField("menu_title") . "</b><br />Краткий заголовок ресурса в меню",
            "parent_id" => "<b>". App::getAdapter()->getResourceField("parent_id") . "</b><br />Идентификатор родительского ресурса",
            "pub_date" => "<b>". App::getAdapter()->getResourceField("pub_date") . "</b><br />Ресурс будет опубликован по наступлению этой даты",
            "un_pub_date" => "<b>". App::getAdapter()->getResourceField("un_pub_date") . "</b><br />Ресурс будет снят с публикации по наступлению этой даты",
            "published_on" => "<b>". App::getAdapter()->getResourceField("published_on") . "</b><br />Когда был опубликован ресурс",
            "rich_text" => "<b>". App::getAdapter()->getResourceField("rich_text") . "</b><br />",
            "searchable" => "<b>". App::getAdapter()->getResourceField("searchable") . "</b><br />",
            "template_id" => "<b>". App::getAdapter()->getResourceField("template_id") . "</b><br />",
            "type" => "<b>". App::getAdapter()->getResourceField("type") . "</b><br />",
            "published" => "<b>". App::getAdapter()->getResourceField("published") . "</b><br />",
            "description" => "<b>". App::getAdapter()->getResourceField("description") . "</b><br />",
        ];
    }

    public function getAllParentIds()
    {
        $parents = $this->getParentId($this, []);
        return $parents;
    }

    public function getAvailableTVs()
    {
        return CommonTemplateVar::find()->forTemplate($this->template_id)->all();
    }

    public function setTvValue($tv, $value)
    {
        $vModel = CommonTemplateVarContent::find()->where(["content_id" =>  $this->id, "template_var_id" => $tv])->one();
        if (!$vModel) {
            $vModel = new SiteTemplateVarContent();
            $vModel->template_var_id = $tv;
            $vModel->content_id = $this->id;
        }
        $vModel->value = $value;
        $vModel->save();
    }

    public function behaviors()
    {
        if ($this->getScenario() == App::SCENARIO_TRANSFER) {
            return [];
        }
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_on',
                'updatedAtAttribute' => 'edited_on',
                'value' => time(),
            ],
        ];
    }

    private function getParentId($model, $ids)
    {
        $ids[] = $model->parent_id;
        if ($model->parent) {
            return $this->getParentId($model->parent, $ids);
        } else {
            return $ids;
        }
    }

}

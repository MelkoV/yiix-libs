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
     * @var CommonTemplateVar[]
     */
    public $tv = [];

    /**
     * @param null $parent
     * @return SiteContent[]
     */
    public static function getLevel($parent = null)
    {
        return SiteContent::find()->withChildCount()->parent($parent)->sort()->all();
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

    public function getFullAlias()
    {
        // todo
        return "/" . $this->alias;
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

    public function loadTv($tv, $sort = "rank", $dir = App::DIR_ASC)
    {
        $tv = is_array($tv) ? $tv : [$tv];
        $find = array_flip($tv);
        foreach (CommonTemplateVar::find()->forContent($this->id, $tv)->orderBy($sort . " " . $dir)->all() as $value) {
            $this->tv[] = $value;
            unset($find[$value->name]);
        }
        foreach (array_keys($find) as $k) {
            $value = new CommonTemplateVar();
            $value->name = $k;
            $this->tv[] = $value;
        }
    }

    /**
     * @param array $names
     * @param array $except
     * @param bool $withMapping
     * @param bool $asAssoc
     * @param string $assocKey
     * @return array
     */
    public function asArray($names = [], $except = [], $withMapping = false, $asAssoc = false, $assocKey = "id")
    {
        $names = $names ?: null;

        $result = $withMapping ?
            App::modx()->getAdapter()->backMapFields("site_content", $this->getAttributes($names, $except)) :
            $this->getAttributes($names, $except);
        foreach ($this->tv as $tv) {
            $result[$tv->name] = $tv->value;
        }
        if (!$asAssoc) {
            return $result;
        }

        return [$this->$assocKey => $result];
    }

    public function asTvArray($names = [], $except = [], $withMapping = false, $tvNames = [], $tvExcept = [], $tvWithMapping = false)
    {
        $names = $names ?: null;
        $tvNames = $tvNames ?: null;

        $result = [];
        foreach ($this->tv as $tv) {
            if (!$tvNames) {
                $tvNames = array_keys($tv->getAttributes());
                $tvNames[] = "type_name";
            }
            $res = $tvWithMapping ?
                App::modx()->getAdapter()->backMapFields("site_template_var", $tv->getAttributes($tvNames, $tvExcept)) :
                $tv->getAttributes($tvNames, $tvExcept);
            $k = $tvWithMapping ? App::modx()->getAdapter()->backMapField("site_template_var", "value") : "value";
            $result[] = array_merge($res, [$k => $tv->value]);
        }
        foreach ($this->getAttributes($names, $except) as $k => $v) {
            $result[] = [
                "name" => $withMapping ? App::modx()->getAdapter()->backMapField("site_content", $k) : $k,
                "value" => $v
            ];
        }
        return $result;
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

    public function attributeDescriptions()
    {
        return [
            "page_title" => "<b>". App::modx()->getAdapter()->getResourceField("page_title") . "</b><br />Имя/заголовок ресурса",
            "alias" => "<b>". App::modx()->getAdapter()->getResourceField("alias") . "</b><br />Псевдоним ресурса позволяет обращаться к ресурсу через Дружественные URL",
            "cacheable" => "<b>". App::modx()->getAdapter()->getResourceField("cacheable") . "</b><br />Не используется в YiiX",
            "is_folder" => "<b>". App::modx()->getAdapter()->getResourceField("is_folder") . "</b><br />Включение этой опции позволяет ресурсу быть контейнером для других ресурсов",
            "content_dispo" => "<b>". App::modx()->getAdapter()->getResourceField("content_dispo") . "</b><br />Параметр определяет, как браузер будет обрабатывать содержимое",
            "content_type" => "<b>". App::modx()->getAdapter()->getResourceField("content_type") . "</b><br />Выберите тип содержимого ресурса",
            "deleted" => "<b>". App::modx()->getAdapter()->getResourceField("deleted") . "</b><br />",
            "hide_menu" => "<b>". App::modx()->getAdapter()->getResourceField("hide_menu") . "</b><br />",
            "intro_text" => "<b>". App::modx()->getAdapter()->getResourceField("intro_text") . "</b><br />Краткое описание ресурса",
            "link_attributes" => "<b>". App::modx()->getAdapter()->getResourceField("intro_text") . "</b><br />Здесь Вы можете указать атрибуты ссылки",
            "long_title" => "<b>". App::modx()->getAdapter()->getResourceField("long_title") . "</b><br />Здесь Вы можете ввести расширенный заголовок",
            "menu_index" => "<b>". App::modx()->getAdapter()->getResourceField("menu_index") . "</b><br />Порядковый номер ресурса в меню",
            "menu_title" => "<b>". App::modx()->getAdapter()->getResourceField("menu_title") . "</b><br />Краткий заголовок ресурса в меню",
            "parent_id" => "<b>". App::modx()->getAdapter()->getResourceField("parent_id") . "</b><br />Идентификатор родительского ресурса",
            "pub_date" => "<b>". App::modx()->getAdapter()->getResourceField("pub_date") . "</b><br />Ресурс будет опубликован по наступлению этой даты",
            "un_pub_date" => "<b>". App::modx()->getAdapter()->getResourceField("un_pub_date") . "</b><br />Ресурс будет снят с публикации по наступлению этой даты",
            "published_on" => "<b>". App::modx()->getAdapter()->getResourceField("published_on") . "</b><br />Когда был опубликован ресурс",
            "rich_text" => "<b>". App::modx()->getAdapter()->getResourceField("rich_text") . "</b><br />",
            "searchable" => "<b>". App::modx()->getAdapter()->getResourceField("searchable") . "</b><br />",
            "template_id" => "<b>". App::modx()->getAdapter()->getResourceField("template_id") . "</b><br />",
            "type" => "<b>". App::modx()->getAdapter()->getResourceField("type") . "</b><br />",
            "published" => "<b>". App::modx()->getAdapter()->getResourceField("published") . "</b><br />",
            "description" => "<b>". App::modx()->getAdapter()->getResourceField("description") . "</b><br />",
        ];
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

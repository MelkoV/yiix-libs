<?php

namespace yiix\models;

use common\components\App;
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
        ];
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

}

<?php

namespace yiix\models;

use Yii;
use \yiix\models\base\SystemSetting as BaseSystemSetting;

/**
 * This is the model class for table "system_setting".
 */
class SystemSetting extends BaseSystemSetting
{

    const DEFAULT_TEMPLATE = "default_template";
    const EMAIL_SENDER = "emailsender";
    const EMAIL_SUBJECT = "emailsubject";
    const ERROR_PAGE = "error_page";
    const FRIENDLY_ALIAS_URLS = "friendly_alias_urls";
    const FRIENDLY_URLS = "friendly_urls";
    const FRIENDLY_URL_SUFFIX = "friendly_url_suffix";
    const CHARSET = "modx_charset";
    const PUBLISH_DEFAULT = "publish_default";
    const SITE_NAME = "site_name";
    const SITE_START = "site_start";
    const SITE_STATUS = "site_status";
    const SITE_UNAVAILABLE_MESSAGE = "site_unavailable_message";
    const SITE_UNAVAILABLE_PAGE = "site_unavailable_page";

    private static $map = [];

    public function rules()
    {
        return array_merge(parent::rules(), [

        ]);
    }

    public static function getValue($key)
    {
        if (!isset(self::$map[$key])) {
            $model = self::find()->where(["name" => $key])->one();
            if (!$model) {
                self::$map[$key] = null;
            } else {
                self::$map[$key] = $model->value;
            }
        }
        return self::$map[$key];
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [

        ]);
    }

    public function attributeDescriptions()
    {
        return [

        ];
    }

}

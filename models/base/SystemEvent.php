<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace yiix\models\base;

use Yii;

/**
 * This is the base-model class for table "system_event".
 *
 * @property integer $id
 * @property string $name
 * @property integer $service
 * @property integer $group_id
 *
 * @property \common\models\SitePluginEvent[] $sitePluginEvents
 * @property \common\models\SitePlugin[] $plugins
 * @property \common\models\SystemEventGroup $group
 * @property string $aliasModel
 */
abstract class SystemEvent extends \melkov\db\ActiveRecord 
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%system_event}}';
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'trim', 'skipOnEmpty' => true],
            [['name'], 'required'],
            [['service', 'group_id'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['name'], 'unique'],
            [['group_id'], 'exist', 'skipOnError' => true, 'targetClass' => \common\models\SystemEventGroup::className(), 'targetAttribute' => ['group_id' => 'id']]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('label', 'ID'),
            'name' => Yii::t('label', 'Name'),
            'service' => Yii::t('label', 'Service'),
            'group_id' => Yii::t('label', 'Group ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSitePluginEvents()
    {
        return $this->hasMany(\common\models\SitePluginEvent::className(), ['event_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlugins()
    {
        return $this->hasMany(\common\models\SitePlugin::className(), ['id' => 'plugin_id'])->viaTable('yiix_site_plugin_event', ['event_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroup()
    {
        return $this->hasOne(\common\models\SystemEventGroup::className(), ['id' => 'group_id']);
    }


    
    /**
     * @inheritdoc
     * @return \common\models\query\SystemEventQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\SystemEventQuery(get_called_class());
    }


}

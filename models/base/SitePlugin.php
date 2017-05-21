<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace yiix\models\base;

use Yii;

/**
 * This is the base-model class for table "site_plugin".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property integer $editor_type
 * @property integer $category_id
 * @property integer $disabled
 * @property integer $locked
 * @property string $code
 * @property string $properties
 * @property integer $module_id
 *
 * @property \common\models\Category $category
 * @property \common\models\SiteModule $module
 * @property \common\models\SitePluginEvent[] $sitePluginEvents
 * @property \common\models\SystemEvent[] $events
 * @property string $aliasModel
 */
abstract class SitePlugin extends \melkov\db\ActiveRecord 
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%site_plugin}}';
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'description'], 'trim', 'skipOnEmpty' => true],
            [['name'], 'required'],
            [['editor_type', 'category_id', 'disabled', 'locked', 'module_id'], 'integer'],
            [['code', 'properties'], 'string'],
            [['name'], 'string', 'max' => 50],
            [['description'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => \common\models\Category::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['module_id'], 'exist', 'skipOnError' => true, 'targetClass' => \common\models\SiteModule::className(), 'targetAttribute' => ['module_id' => 'id']]
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
            'description' => Yii::t('label', 'Description'),
            'editor_type' => Yii::t('label', 'Editor Type'),
            'category_id' => Yii::t('label', 'Category ID'),
            'disabled' => Yii::t('label', 'Disabled'),
            'locked' => Yii::t('label', 'Locked'),
            'code' => Yii::t('label', 'Code'),
            'properties' => Yii::t('label', 'Properties'),
            'module_id' => Yii::t('label', 'Module ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(\common\models\Category::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModule()
    {
        return $this->hasOne(\common\models\SiteModule::className(), ['id' => 'module_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSitePluginEvents()
    {
        return $this->hasMany(\common\models\SitePluginEvent::className(), ['plugin_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvents()
    {
        return $this->hasMany(\common\models\SystemEvent::className(), ['id' => 'event_id'])->viaTable('yiix_site_plugin_event', ['plugin_id' => 'id']);
    }


    
    /**
     * @inheritdoc
     * @return \common\models\query\SitePluginQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\SitePluginQuery(get_called_class());
    }


}
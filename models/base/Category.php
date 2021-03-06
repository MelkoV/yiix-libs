<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace yiix\models\base;

use Yii;

/**
 * This is the base-model class for table "category".
 *
 * @property integer $id
 * @property string $name
 *
 * @property \common\models\SiteChunk[] $siteChunks
 * @property \common\models\SiteModule[] $siteModules
 * @property \common\models\SitePlugin[] $sitePlugins
 * @property \common\models\SiteSnippet[] $siteSnippets
 * @property \common\models\SiteTemplate[] $siteTemplates
 * @property \common\models\SiteTemplateVar[] $siteTemplateVars
 * @property string $aliasModel
 */
abstract class Category extends \melkov\db\ActiveRecord 
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%category}}';
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'trim', 'skipOnEmpty' => true],
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['name'], 'unique']
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSiteChunks()
    {
        return $this->hasMany(\common\models\SiteChunk::className(), ['category_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSiteModules()
    {
        return $this->hasMany(\common\models\SiteModule::className(), ['category_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSitePlugins()
    {
        return $this->hasMany(\common\models\SitePlugin::className(), ['category_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSiteSnippets()
    {
        return $this->hasMany(\common\models\SiteSnippet::className(), ['category_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSiteTemplates()
    {
        return $this->hasMany(\common\models\SiteTemplate::className(), ['category_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSiteTemplateVars()
    {
        return $this->hasMany(\common\models\SiteTemplateVar::className(), ['category_id' => 'id']);
    }


    
    /**
     * @inheritdoc
     * @return \common\models\query\CategoryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\CategoryQuery(get_called_class());
    }


}

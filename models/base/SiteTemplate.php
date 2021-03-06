<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace yiix\models\base;

use Yii;

/**
 * This is the base-model class for table "site_template".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property integer $editor_type
 * @property integer $category_id
 * @property string $icon
 * @property integer $type
 * @property string $content
 * @property integer $locked
 * @property integer $selectable
 *
 * @property \common\models\SiteContent[] $siteContents
 * @property \common\models\Category $category
 * @property \common\models\SiteTemplateVarTemplate[] $siteTemplateVarTemplates
 * @property \common\models\SiteTemplateVar[] $templateVars
 * @property string $aliasModel
 */
abstract class SiteTemplate extends \melkov\db\ActiveRecord 
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%site_template}}';
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'description', 'icon'], 'trim', 'skipOnEmpty' => true],
            [['name'], 'required'],
            [['editor_type', 'category_id', 'type', 'locked', 'selectable'], 'integer'],
            [['content'], 'string'],
            [['name'], 'string', 'max' => 50],
            [['description', 'icon'], 'string', 'max' => 255],
            [['name'], 'unique'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => \common\models\Category::className(), 'targetAttribute' => ['category_id' => 'id']]
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
            'icon' => Yii::t('label', 'Icon'),
            'type' => Yii::t('label', 'Type'),
            'content' => Yii::t('label', 'Content'),
            'locked' => Yii::t('label', 'Locked'),
            'selectable' => Yii::t('label', 'Selectable'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSiteContents()
    {
        return $this->hasMany(\common\models\SiteContent::className(), ['template_id' => 'id']);
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
    public function getSiteTemplateVarTemplates()
    {
        return $this->hasMany(\common\models\SiteTemplateVarTemplate::className(), ['template_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTemplateVars()
    {
        return $this->hasMany(\common\models\SiteTemplateVar::className(), ['id' => 'template_var_id'])->viaTable('yiix_site_template_var_template', ['template_id' => 'id']);
    }


    
    /**
     * @inheritdoc
     * @return \common\models\query\SiteTemplateQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\SiteTemplateQuery(get_called_class());
    }


}

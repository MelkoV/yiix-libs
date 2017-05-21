<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace yiix\models\base;

use Yii;

/**
 * This is the base-model class for table "system_event_group".
 *
 * @property integer $id
 * @property string $name
 *
 * @property \common\models\SystemEvent[] $systemEvents
 * @property string $aliasModel
 */
abstract class SystemEventGroup extends \melkov\db\ActiveRecord 
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%system_event_group}}';
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'trim', 'skipOnEmpty' => true],
            [['name'], 'required'],
            [['name'], 'string', 'max' => 50],
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
    public function getSystemEvents()
    {
        return $this->hasMany(\common\models\SystemEvent::className(), ['group_id' => 'id']);
    }


    
    /**
     * @inheritdoc
     * @return \common\models\query\SystemEventGroupQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\SystemEventGroupQuery(get_called_class());
    }


}

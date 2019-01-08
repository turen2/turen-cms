<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace common\models\cms;

use Yii;

/**
 * This is the model class for table "{{%cms_tag_assign}}".
 *
 * @property string $class
 * @property string $item_id
 * @property string $tag_id
 */
class TagAssign extends \common\components\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%cms_tag_assign}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['item_id', 'tag_id'], 'integer'],
            [['class'], 'string', 'max' => 128],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'class' => Yii::t('app', 'Class'),
            'item_id' => Yii::t('app', 'Item ID'),
            'tag_id' => Yii::t('app', 'Tag ID'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return TagAssignQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TagAssignQuery(get_called_class());
    }
}

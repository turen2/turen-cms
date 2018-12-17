<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace app\models\tool;

use Yii;
use yii\helpers\ArrayHelper;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%tool_notify_from}}".
 *
 * @property int $fr_id
 * @property string $fr_title 来源名称
 * @property string $fr_comment 来源备注
 * @property int $fr_is_default 是否为默认
 */
class NotifyFrom extends \app\models\base\Tool
{
	public $keyword;
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%tool_notify_from}}';
    }
    
    /**
     * 为联表操作做准备
     * {@inheritDoc}
     * @see \yii\db\ActiveRecord::attributes()
     */
    public function attributes()
    {
        return ArrayHelper::merge(parent::attributes(), []);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        //静态默认值由规则来赋值
        //[['status'], 'default', 'value' => self::STATUS_ON],
        //[['hits'], 'default', 'value' => Yii::$app->params['config.hits']],
        return [
            [['fr_title'], 'required'],
            [['fr_is_default'], 'integer'],
            [['fr_title'], 'string', 'max' => 35],
            [['fr_comment'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'fr_id' => 'ID',
            'fr_title' => '来源名称',
            'fr_comment' => '来源备注',
            'fr_is_default' => '设为默认',
        ];
    }

    /**
     * @inheritdoc
     * @return NotifyFromQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new NotifyFromQuery(get_called_class());
    }
}

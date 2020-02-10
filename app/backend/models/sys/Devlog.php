<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace backend\models\sys;

use Yii;
use yii\helpers\ArrayHelper;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\AttributeBehavior;
use backend\behaviors\InsertLangBehavior;
use backend\widgets\laydate\LaydateBehavior;

/**
 * This is the model class for table "{{%sys_devlog}}".
 *
 * @property string $log_id
 * @property string $log_name 更新描述
 * @property string $log_code 更新编码，与v版本号有关V+T
 * @property string $log_note 更新详情
 * @property string $log_time 更新时间，手动选择，用于展示
 * @property string $created_at 实际增加时间
 */
class Devlog extends \yii\db\ActiveRecord
{
	public $keyword;
	
	public function behaviors()
	{
	    return [
	        'timemap' => [
	            'class' => TimestampBehavior::class,
	            'createdAtAttribute' => 'created_at',
	            'updatedAtAttribute' => false
	        ],
	        'logtime' => [
	            'class' => LaydateBehavior::class,
	            'timeAttribute' => 'log_time',
	        ],
	    ];
	}

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%sys_devlog}}';
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
        return [
            [['log_name', 'log_code', 'log_note'], 'required'],
            [['created_at'], 'integer'],
            [['log_name'], 'string', 'max' => 50],
            [['log_code'], 'string', 'max' => 50],
            [['log_time'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'log_id' => '日志ID',
            'log_name' => '日志简述',
            'log_code' => '日志编码',
            'log_note' => '详情',
            'log_time' => '开发时间',
            'created_at' => '创建时间',
        ];
    }

    /**
     * @inheritdoc
     * @return DevlogQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new DevlogQuery(get_called_class());
    }
}

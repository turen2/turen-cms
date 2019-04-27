<?php

namespace app\models\user;

use Yii;
use yii\helpers\ArrayHelper;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use app\behaviors\InsertLangBehavior;
use app\behaviors\OrderDefaultBehavior;

/**
 * This is the model class for table "{{%user_feedback_type}}".
 *
 * @property string $fkt_id
 * @property string $fkt_form_name 表单显示名
 * @property int $fkt_form_show 是否显示在提交表单
 * @property string $fkt_list_name 展示列表标题
 * @property int $fkt_list_show 是否展示在展示列表
 * @property string $lang 多语言
 * @property string $orderid 排序
 * @property int $status 启用状态
 * @property int $is_default 是否为默认组
 * @property string $created_at 创建时间
 * @property string $updated_at 更新时间
 */
class FeedbackType extends \app\models\base\User
{
    //是否展示常量
    const SHOW_YES = 1;
    const SHOW_NO = 0;

	public $keyword;
	
	public function behaviors()
	{
	    return [
	        'timemap' => [
	            'class' => TimestampBehavior::class,
	            'createdAtAttribute' => 'created_at',
	            'updatedAtAttribute' => 'updated_at'
	        ],
	        'insertlang' => [//自动填充多站点和多语言
	            'class' => InsertLangBehavior::class,
	            'insertLangAttribute' => 'lang',
	        ],
	        'defaultOrderid' => [
	            'class' => OrderDefaultBehavior::class,
            ],
	    ];
	}

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_feedback_type}}';
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
            [['fkt_form_show', 'fkt_list_show', 'orderid', 'status', 'is_default', 'created_at', 'updated_at'], 'integer'],
            [['fkt_form_name', 'fkt_list_name', 'lang'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'fkt_id' => 'ID',
            'fkt_form_name' => '表单显示名称',
            'fkt_form_show' => '在表单中显示',
            'fkt_list_name' => '列表显示名称',
            'fkt_list_show' => '在列表中显示',
            'lang' => '多语言',
            'orderid' => '排序',
            'status' => '启用状态',
            'is_default' => '是否为默认',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
        ];
    }

    /**
     * @inheritdoc
     * @return FeedbackTypeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new FeedbackTypeQuery(get_called_class());
    }
}

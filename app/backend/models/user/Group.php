<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace backend\models\user;

use Yii;
use yii\helpers\ArrayHelper;
use yii\db\ActiveRecord;
use backend\behaviors\InsertLangBehavior;
use backend\behaviors\OrderDefaultBehavior;

/**
 * This is the model class for table "{{%user_group}}".
 *
 * @property int $ug_id 用户组id
 * @property string $ug_name 用户组名称
 * @property string $orderid 排序
 * @property string $lang 多语言
 * @property int $is_default 默认
 */
class Group extends \backend\models\base\User
{
	public $keyword;
	
	public function behaviors()
	{
	    return [
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
        return '{{%user_group}}';
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
            [['ug_name'], 'required'],
            [['orderid'], 'integer'],
            [['ug_name'], 'string', 'max' => 50],
            [['is_default'], 'string', 'max' => 1],
            [['lang'], 'string', 'max' => 8],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ug_id' => 'ID',
            'ug_name' => '用户组名称',
            'orderid' => '排序',
            'lang' => '多语言',
            'is_default' => '是否默认',
        ];
    }

    /**
     * @inheritdoc
     * @return GroupQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new GroupQuery(get_called_class());
    }
}

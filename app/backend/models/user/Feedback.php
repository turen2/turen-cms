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
use yii\behaviors\TimestampBehavior;
use backend\behaviors\InsertLangBehavior;
use backend\behaviors\OrderDefaultBehavior;
use backend\widgets\laydate\LaydateBehavior;

/**
 * This is the model class for table "{{%user_feedback}}".
 *
 * @property string $fk_id 留言id
 * @property string $fk_user_id 关联用户id
 * @property string $fk_nickname 用户昵称
 * @property string $fk_contact 联系方式
 * @property string $fk_content 留言内容
 * @property int $fk_show 是否置顶在前台展示
 * @property int $fk_type_id
 * @property string $fk_ip 留言IP
 * @property string $fk_review 回复内容
 * @property string $fk_retime 回复时间
 * @property int $fk_sms 是否自动给用户发短信
 * @property int $fk_email 是否自动给用户发邮件
 * @property string $lang 多语言
 * @property string $orderid 排列排序
 * @property string $created_at 创建时间
 * @property string $updated_at 更新时间
 */
class Feedback extends \backend\models\base\User
{
    //是否发送
    const SEND_YES = 1;
    const SEND_NO = 0;

    //是否前台顶置
    const HOT_TOP = 1;
    const NOT_HOT_TOP = 0;

	public $keyword;
	
	public function behaviors()
	{
	    return [
	        'timemap' => [
	            'class' => TimestampBehavior::class,
	            'createdAtAttribute' => 'created_at',
	            'updatedAtAttribute' => 'updated_at'
	        ],
            'posttime' => [
                'class' => LaydateBehavior::class,
                'timeAttribute' => 'fk_retime',
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
        return '{{%user_feedback}}';
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
            [['fk_nickname', 'fk_type_id', 'fk_content', 'fk_review'], 'required'],
            [['fk_user_id', 'fk_show', 'fk_type_id', 'fk_retime', 'fk_sms', 'fk_email', 'orderid', 'created_at', 'updated_at'], 'integer'],
            [['fk_nickname', 'fk_contact', 'fk_ip', 'lang'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'fk_id' => 'ID',
            'fk_user_id' => '关联用户',
            'fk_nickname' => '用户昵称',
            'fk_contact' => '联系方式',
            'fk_content' => '用户提问内容',
            'fk_show' => '在前台置顶',
            'fk_type_id' => '反馈类型',
            'fk_ip' => '留言IP',
            'fk_review' => '回复内容',
            'fk_retime' => '回复时间',
            'fk_sms' => '给用户发短信',
            'fk_email' => '给用户发邮件',
            'lang' => '多语言',
            'orderid' => '排列',
            'created_at' => '提交时间',
            'updated_at' => '更新时间',
        ];
    }

    /**
     * 一对一
     * @return \yii\db\ActiveQuery
     */
    public function getFeedbackType()
    {
        return $this->hasOne(FeedbackType::class, ['fkt_id' => 'fk_type_id']);
    }

    /**
     * 一对一
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['user_id' => 'fk_user_id']);
    }

    /**
     * @inheritdoc
     * @return FeedbackQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new FeedbackQuery(get_called_class());
    }
}

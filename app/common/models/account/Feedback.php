<?php

namespace common\models\account;

use Yii;
use yii\behaviors\TimestampBehavior;

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
 * @property int $fk_sms 是否自动给客户发短信
 * @property int $fk_email 是否自动给客户发邮件
 * @property string $lang 多语言
 * @property string $orderid 排列排序
 * @property string $created_at 创建时间
 * @property string $updated_at 更新时间
 */
class Feedback extends \common\components\ActiveRecord
{
    const HOT_TOP = 1;//在前台顶置显示
    const NOT_HOT_TOP = 0;

    public function behaviors()
    {
        return [
            'timemap' => [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at'
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user_feedback}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fk_user_id', 'fk_show', 'fk_type_id', 'fk_retime', 'fk_sms', 'fk_email', 'orderid', 'created_at', 'updated_at'], 'integer'],
            [['fk_content', 'fk_review'], 'string'],
            [['fk_type_id', 'fk_ip', 'fk_review', 'fk_retime'], 'required'],
            [['fk_nickname'], 'string', 'max' => 30],
            [['fk_contact', 'fk_ip'], 'string', 'max' => 50],
            [['lang'], 'string', 'max' => 8],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'fk_id' => 'ID',
            'fk_user_id' => '关联用户',
            'fk_nickname' => '用户昵称',
            'fk_contact' => '联系方式',
            'fk_content' => '留言内容',
            'fk_show' => '在前台置顶',
            'fk_type_id' => '关联反馈类型',
            'fk_ip' => '留言IP',
            'fk_review' => '回复内容',
            'fk_retime' => '回复时间',
            'fk_sms' => '给客户发短信',
            'fk_email' => '给客户发邮件',
            'lang' => '多语言',
            'orderid' => '排列排序',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
        ];
    }

    /**
     * {@inheritdoc}
     * @return FeedbackQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new FeedbackQuery(get_called_class());
    }
}

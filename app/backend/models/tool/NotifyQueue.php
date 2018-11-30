<?php

namespace app\models\tool;

use Yii;
use yii\helpers\ArrayHelper;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%tool_notify_queue}}".
 *
 * @property string $nq_id
 * @property string $nq_nu_id 准备发送消息的用户
 * @property string $nq_ng_id 用户对应的发送组
 * @property int $nq_is_email 是否发邮件
 * @property int $nq_is_notify 是否发站内信
 * @property int $nq_is_sms 是否发短信
 * @property string $nq_email_send_time 邮件发送时间
 * @property string $nq_email_arrive_time 邮件到达时间
 * @property string $nq_notify_send_time 通知发送时间
 * @property string $nq_notify_arrive_time 通知到达时间
 * @property string $nq_sms_send_time 短信发送时间
 * @property string $nq_sms_arrive_time 短信到达时间
 * @property int $nq_status 启用禁用
 */
class NotifyQueue extends \app\models\base\Tool
{
	public $keyword;
	
	public function behaviors()
	{
	    return [];
	}

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%tool_notify_queue}}';
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
            [['nq_id', 'nq_nu_id', 'nq_ng_id'], 'required'],
            [['nq_id', 'nq_nu_id', 'nq_ng_id', 'nq_is_email', 'nq_is_notify', 'nq_is_sms', 'nq_email_send_time', 'nq_email_arrive_time', 'nq_notify_send_time', 'nq_notify_arrive_time', 'nq_sms_send_time', 'nq_sms_arrive_time', 'nq_status'], 'integer'],
            [['nq_id'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'nq_id' => 'ID',
            'nq_nu_id' => '准备发送消息的用户',
            'nq_ng_id' => '用户对应的发送组',
            'nq_is_email' => '是否发邮件',
            'nq_is_notify' => '是否发站内信',
            'nq_is_sms' => '是否发短信',
            'nq_email_send_time' => '邮件发送时间',
            'nq_email_arrive_time' => '邮件到达时间',
            'nq_notify_send_time' => '通知发送时间',
            'nq_notify_arrive_time' => '通知到达时间',
            'nq_sms_send_time' => '短信发送时间',
            'nq_sms_arrive_time' => '短信到达时间',
        ];
    }
    
    /**
     * 一对一
     * @return \yii\db\ActiveQuery
     */
    function getNotifyGroup() {
        return $this->hasOne(NotifyGroup::class, ['ng_id' => 'nq_ng_id']);
    }
    
    /**
     * 一对一
     * @return \yii\db\ActiveQuery
     */
    function getNotifyUser() {
        return $this->hasOne(NotifyUser::class, ['nu_id' => 'nq_nu_id']);
    }

    /**
     * @inheritdoc
     * @return NotifyQueueQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new NotifyQueueQuery(get_called_class());
    }
}

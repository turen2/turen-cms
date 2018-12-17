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

/**
 * This is the model class for table "{{%tool_notify_sms_queue}}".
 *
 * @property string $nq_sms_id
 * @property string $nq_nu_id 准备发送消息的用户
 * @property string $nq_ng_id 用户对应的发送组
 * @property int $nq_user_id 用户ID
 * @property int $nq_phone 手机号码
 * @property string $nq_sms_send_time 短信发送时间
 * @property string $nq_sms_arrive_time 短信到达时间
 */
class NotifySmsQueue extends \app\models\base\Tool
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
        return '{{%tool_notify_sms_queue}}';
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
            [['nq_sms_id', 'nq_nu_id', 'nq_ng_id'], 'required'],
            [['nq_sms_id', 'nq_nu_id', 'nq_ng_id', 'nq_user_id', 'nq_phone', 'nq_sms_send_time', 'nq_sms_arrive_time'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'nq_sms_id' => 'ID',
            'nq_nu_id' => '消息用户',
            'nq_ng_id' => '所属队列',
            'nq_user_id' => '用户',
            'nq_phone' => '手机号码',
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
     * @return NotifySmsQueueQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new NotifySmsQueueQuery(get_called_class());
    }
}

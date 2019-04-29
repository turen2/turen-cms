<?php

namespace common\models\account;

use Yii;

/**
 * This is the model class for table "{{%user_ticket}}".
 *
 * @property string $t_id ID
 * @property string $t_ticket_num 工单号
 * @property string $t_title 工单标题
 * @property string $t_content 工单互动内容（数组序列化）
 * @property string $t_relate_id 关联对象，服务单id/预约单id
 * @property string $t_phone 手机通知
 * @property string $t_email 邮件通知
 * @property string $t_user_id 工作所属
 * @property int $t_status 工单状态，1待处理，2有新回复，3待回复，4待您评价，5已关闭
 * @property int $t_star 结单星级
 * @property int $t_is_finish 结单是否解决
 * @property string $t_finish_comment 结单评价
 * @property int $finished_at 完成时间
 * @property string $lang 多语言
 * @property int $created_at 创建时间
 * @property int $udpated_at 更新时间
 */
class Ticket extends \common\components\ActiveRecord
{
    //工单状态，1待处理，2有新回复，3待回复，4待您评价，5已关闭'
    const TICKET_STATUS_WAIT = 1;
    const TICKET_STATUS_NEWREVIEW = 2;
    const TICKET_STATUS_WAITREVIEW = 3;
    const TICKET_STATUS_WAITCOMMENT = 4;
    const TICKET_STATUS_CLOSE = 5;

    //是否解决问题
    const TICKET_YES = 1;
    const TICKET_NO = 0;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user_ticket}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['t_title'], 'required'],
            [['t_relate_id', 't_user_id', 't_status', 't_star', 't_is_finish', 'finished_at', 'created_at', 'udpated_at'], 'integer'],
            [['t_ticket_num'], 'string', 'max' => 20],
            [['t_title', 't_finish_comment'], 'string', 'max' => 200],
            [['t_phone'], 'string', 'max' => 11],
            [['t_email'], 'string', 'max' => 30],
            [['t_content', 'lang'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            't_id' => 'ID',
            't_ticket_num' => '工单号',
            't_title' => '工单主题',
            't_content' => '工单互动内容',//（数组序列化）
            't_relate_id' => '关联对象',//，服务单id/预约单id',
            't_phone' => '手机通知',
            't_email' => '邮件通知',
            't_user_id' => '工单所属',
            't_status' => '工单状态',//，1待处理，2有新回复，3待回复，4待您评价，5已关闭
            't_star' => '星级',
            't_is_finish' => '是否解决',
            't_finish_comment' => '评价',
            'finished_at' => '结单时间',
            'lang' => '多语言',
            'created_at' => '创建时间',
            'udpated_at' => '更新时间',
        ];
    }

    /**
     * 状态名称列表
     * @return array
     */
    public static function StatusList()
    {
        //工单状态，1待处理，2有新回复，3待回复，4待您评价，5已关闭'
        return [
            static::TICKET_STATUS_WAIT => '待处理',
            static::TICKET_STATUS_NEWREVIEW => '有新回复',
            static::TICKET_STATUS_WAITREVIEW => '待回复',
            static::TICKET_STATUS_WAITCOMMENT => '待您评论',
            static::TICKET_STATUS_CLOSE => '已关闭',
        ];
    }

    /**
     * 通过状态返回名称
     * @param $status
     * @return mixed|string
     */
    public static function StatusName($status)
    {
        $statuses = static::StatusList();
        return isset($statuses[$status])?$statuses[$status]:'未设置';
    }

    /**
     * {@inheritdoc}
     * @return TicketQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TicketQuery(get_called_class());
    }
}

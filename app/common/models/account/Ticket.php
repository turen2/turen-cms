<?php

namespace common\models\account;

use Yii;
use yii\behaviors\TimestampBehavior;
use common\helpers\Util;
use common\behaviors\InsertLangBehavior;

/**
 * This is the model class for table "{{%user_ticket}}".
 *
 * @property string $t_id ID
 * @property string $t_ticket_num 工单号
 * @property string $t_title 工单标题
 * @property string $t_files 主题文件
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
 * @property int $updated_at 更新时间
 */
class Ticket extends \common\components\ActiveRecord
{
    //工单状态，1待处理，2有新回复，3待回复，4待您评价，5已关闭
    const TICKET_STATUS_WAIT = 1;
    const TICKET_STATUS_NEWREVIEW = 2;
    const TICKET_STATUS_WAITREVIEW = 3;
    const TICKET_STATUS_WAITCOMMENT = 4;
    const TICKET_STATUS_CLOSE = 5;

    //是否解决问题
    const TICKET_YES = 1;
    const TICKET_NO = 0;

    //交互类型
    const TICKET_TYPE_USER = 'user';
    const TICKET_TYPE_ADMIN = 'admin';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user_ticket}}';
    }

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
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['t_title', 't_relate_id'], 'required'],
            [['t_user_id', 't_relate_id', 't_status', 't_star', 't_is_finish', 'finished_at', 'created_at', 'updated_at'], 'integer'],
            [['t_ticket_num'], 'string', 'max' => 20],
            [['t_title', 't_finish_comment'], 'string', 'max' => 200],
            [['t_phone'], 'string', 'max' => 11],
            [['t_email'], 'string', 'max' => 30],
            [['t_phone'], 'match', 'pattern' => '/^[1][3578][0-9]{9}$/', 'message' => '手机号码格式错误'],
            [['t_email'], 'email'],
            [['t_content', 't_files', 'lang'], 'string'],
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
            't_files' => '主题相关文件',
            't_content' => '工单互动内容',//（数组序列化）
            't_relate_id' => '服务单号',//，服务单id/预约单id',
            't_phone' => '手机通知[可选]',
            't_email' => '邮件通知[可选]',
            't_user_id' => '工单所属',
            't_status' => '工单状态',//，1待处理，2有新回复，3待回复，4待您评价，5已关闭
            't_star' => '星级',
            't_is_finish' => '是否解决',
            't_finish_comment' => '评价',
            'finished_at' => '结单时间',
            'lang' => '多语言',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
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
     * 保存之后的操作
     * @param bool $insert
     * @param array $changedAttributes
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        if(empty($this->t_ticket_num)) {
            self::updateAll([
                't_ticket_num' => Util::GenerateSimpleOrderNumber('GD', $this->t_id),
                't_user_id' => Yii::$app->getUser()->getId(),
            ], [
                't_id' => $this->t_id,
            ]);
        }
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

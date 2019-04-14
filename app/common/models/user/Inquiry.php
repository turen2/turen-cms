<?php

namespace common\models\user;

use Yii;

/**
 * This is the model class for table "{{%user_inquiry}}".
 *
 * @property string $ui_id 留言id
 * @property string $ui_title 预约标题
 * @property string $ui_content 预约内容
 * @property string $user_id 关系用户
 * @property string $ui_ipaddress 来源地址
 * @property string $ui_browser 客户端信息
 * @property string $ui_answer 回应
 * @property string $ui_remark 备注（给自己看的）
 * @property int $ui_type 类型：1首页预约，2价格计算器预约，3业务详情预约
 * @property int $ui_state 处理状态：0未处理，1待处理，2已处理
 * @property string $ui_submit_time 预约提交时间
 * @property string $ui_answer_time 回应时间
 * @property string $ui_remark_time 备注时间
 */
class Inquiry extends \common\components\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user_inquiry}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ui_title', 'ui_content', 'ui_ipaddress', 'ui_browser', 'ui_answer', 'ui_remark'], 'required'],
            [['user_id', 'ui_type', 'ui_state', 'ui_submit_time', 'ui_answer_time', 'ui_remark_time'], 'integer'],
            [['ui_browser', 'ui_answer', 'ui_remark'], 'string'],
            [['ui_title'], 'string', 'max' => 30],
            [['ui_content'], 'string', 'max' => 50],
            [['ui_ipaddress'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ui_id' => 'id',
            'ui_title' => '预约标题',
            'ui_content' => '预约内容',
            'user_id' => '用户',
            'ui_ipaddress' => '来源',
            'ui_browser' => '客户端',
            'ui_answer' => '回复',
            'ui_remark' => '备忘录',
            'ui_type' => '预约类型',
            'ui_state' => '处理状态',
            'ui_submit_time' => '提交时间',
            'ui_answer_time' => '回复时间',
            'ui_remark_time' => '备忘时间',
        ];
    }

    /**
     * {@inheritdoc}
     * @return InquiryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new InquiryQuery(get_called_class());
    }
}

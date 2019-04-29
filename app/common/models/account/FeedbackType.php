<?php

namespace common\models\account;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%user_feedback_type}}".
 *
 * @property string $fkt_id
 * @property string $fkt_form_name feedback类型名
 * @property int $fkt_form_show 是否显示在提交表单
 * @property string $fkt_list_name 展示列表标题
 * @property int $fkt_list_show 是否展示在展示列表
 * @property string $lang 多语言
 * @property string $orderid 排序
 * @property int $status 启用状态
 * @property int $is_default 是否为默认
 * @property string $created_at 创建时间
 * @property string $updated_at 更新时间
 */
class FeedbackType extends \common\components\ActiveRecord
{
    //是否展示
    const SHOW_YES = 1;
    const SHOW_NO = 0;

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
        return '{{%user_feedback_type}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fkt_form_show', 'fkt_list_show', 'orderid', 'status', 'is_default', 'created_at', 'updated_at'], 'integer'],
            [['fkt_form_name', 'fkt_list_name'], 'string', 'max' => 50],
            [['lang'], 'string', 'max' => 8],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'fkt_id' => 'ID',
            'fkt_form_name' => '表单展示标题',
            'fkt_form_show' => '是否在表单展示',
            'fkt_list_name' => '列表展示标题',
            'fkt_list_show' => '是否在列表展示',
            'lang' => '多语言',
            'orderid' => '排序',
            'status' => '启用状态',
            'is_default' => '是否为默认',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
        ];
    }

    /**
     * {@inheritdoc}
     * @return FeedbackTypeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new FeedbackTypeQuery(get_called_class());
    }
}

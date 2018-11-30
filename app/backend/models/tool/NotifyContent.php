<?php

namespace app\models\tool;

use Yii;
use yii\helpers\ArrayHelper;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%tool_notify_content}}".
 *
 * @property string $nc_id
 * @property string $nc_title 内容标题
 * @property string $nc_notify_content 站内通知内容
 * @property string $nc_notify_data 消息通知替换数据
 * @property string $nc_email_content 邮件通知内容
 * @property string $nc_email_data 邮件内容替换数据
 * @property string $nc_sms_tcode 短信模板code
 * @property string $nc_sms_data 短信内容替换数据
 * @property string $nc_sms_sign 短信签名
 * @property string $nc_sms_ext 短信拓展符
 * @property string $nc_sms_outid 短信outid
 * @property int $nc_status 是否启用
 * @property string $created_at 添加时间
 * @property string $updated_at 修改时间
 */
class NotifyContent extends \app\models\base\Tool
{
	public $keyword;
	
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
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%tool_notify_content}}';
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
            [['nc_title'], 'required'],
            [['nc_id', 'nc_status', 'created_at', 'updated_at'], 'integer'],
            [['nc_notify_content', 'nc_email_content'], 'string'],
            [['nc_title'], 'string', 'max' => 100],
            [['nc_notify_data', 'nc_email_data', 'nc_sms_data'], 'string', 'max' => 255],
            [['nc_sms_tcode', 'nc_sms_ext', 'nc_sms_outid'], 'string', 'max' => 30],
            [['nc_sms_sign'], 'string', 'max' => 40],
            [['nc_id'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'nc_id' => 'ID',
            'nc_title' => '标题',
            'nc_notify_content' => '站内通知',
            'nc_notify_data' => '站内数据',
            'nc_email_content' => '邮件通知',
            'nc_email_data' => '邮件数据',
            'nc_sms_tcode' => '短信模板编码',
            'nc_sms_data' => '短信数据',
            'nc_sms_sign' => '短信签名',
            'nc_sms_ext' => '短信拓展符',
            'nc_sms_outid' => '短信Outid',
            'nc_status' => '是否启用',
            'created_at' => '添加时间',
            'updated_at' => '修改时间',
        ];
    }

    /**
     * @inheritdoc
     * @return NotifyContentQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new NotifyContentQuery(get_called_class());
    }
}

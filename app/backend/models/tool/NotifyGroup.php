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
use app\widgets\datetimepicker\DatetimePickerBehavior;

/**
 * This is the model class for table "{{%tool_notify_group}}".
 *
 * @property string $ng_id
 * @property string $ng_title 发送组标题
 * @property string $ng_comment 发送组备注
 * @property int $ng_nc_id 关联内容
 * @property string $ng_count 待发送总是
 * @property string $ng_send_count 已发总量
 * @property string $ng_clock_time 定时发送时间，为0时表示马上执行
 * @property int $ng_status 发送状态 0暂停中或无效/1发送中
 */
class NotifyGroup extends \app\models\base\Tool
{
	public $keyword;
	
	public $type_1;
	public $type_2;
	public $type_3;
	
	public function behaviors()
	{
	    return [
	        'clockTime' => [
	            'class' => DatetimePickerBehavior::class,
	            'timeAttribute' => 'ng_clock_time',
	            'fomat' => 'Y-m-d H:i:s',
	        ],
	    ];
	}

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%tool_notify_group}}';
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
        return [
            [['ng_title', 'ng_nc_id'], 'required'],
            [['ng_id', 'ng_count', 'ng_clock_time', 'ng_send_count', 'ng_status'], 'integer'],
            [['ng_comment'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ng_id' => 'ID',
            'ng_title' => ' 队列标题',
            'ng_comment' => '队列备注',
            'ng_nc_id' => '发送内容',
            'ng_count' => '发送总量',
            'ng_send_count' => '已发量',
            'ng_clock_time' => '定时发送',
            'ng_status' => '发送状态',
        ];
    }
    
    /**
     * 发送状态
     */
    public function sendStatus()
    {
        if($this->ng_send_count == $this->ng_count) {
            return '<i style="color: ;" class="fa fa-check-circle-o"></i>';//已经完成
        }
        
        if(empty($this->ng_clock_time)) {
            return $this->ng_status?'<i style="color: #ed5565;" class="fa fa-play-circle-o"></i>':'<i style="color: #f8ac59;" class="fa fa-ban"></i>';//发送和暂停
        } else {
            if($this->ng_status) {
                return ($this->ng_clock_time < time())?'<i style="color: #1ab394;" class="fa fa-clock-o"></i>':'<i style="color: #1c84c6;" class="fa fa-play-circle-o"></i>';
            } else {
                return '<i style="color: #1c84c6;" class="fa fa-ban"></i>';
            }
        }
    }
    
    /**
     * 一对一
     * @return \yii\db\ActiveQuery
     */
    function getNotifyContent() {
        return $this->hasOne(NotifyContent::class, ['nc_id' => 'ng_nc_id']);
    }

    /**
     * @inheritdoc
     * @return NotifyGroupQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new NotifyGroupQuery(get_called_class());
    }
}

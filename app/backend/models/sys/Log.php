<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace app\models\sys;

use Yii;
use yii\helpers\ArrayHelper;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use app\behaviors\InsertLangBehavior;

/**
 * This is the model class for table "{{%sys_log}}".
 *
 * @property int $log_id
 * @property string $admin_id 管理员id
 * @property string $username 管理员名
 * @property string $route 操作的路由
 * @property string $name 记录详情
 * @property string $method 操作方法
 * @property string $get_data get数据
 * @property string $post_data 改变的数据
 * @property string $ip 操作IP地址
 * @property string $agent
 * @property string $md5
 * @property string $created_at 创建时间
 * @property string $lang 多语言
 */
class Log extends \app\models\base\Sys
{
	public $keyword;
	
	public function behaviors()
	{
	    return [
	        'timemap' => [
	            'class' => TimestampBehavior::class,
	            'createdAtAttribute' => 'created_at',
	            'updatedAtAttribute' => false,
	        ],
	        'insertLang' => [//自动填充多站点和多语言
	            'class' => InsertLangBehavior::class,
	            'insertLangAttribute' => 'lang',
	        ],
	    ];
	}

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%sys_log}}';
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
            [['log_id', 'get_data', 'post_data', 'ip', 'agent', 'created_at'], 'required'],
            [['log_id', 'admin_id'], 'integer'],
            [['get_data', 'post_data', 'agent'], 'string'],
            [['username'], 'string', 'max' => 80],
            [['route'], 'string', 'max' => 100],
            [['name'], 'string', 'max' => 150],
            [['method'], 'string', 'max' => 10],
            [['lang'], 'string', 'max' => 8],
            [['ip', 'created_at'], 'string', 'max' => 50],
            [['md5'], 'string', 'max' => 32],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'log_id' => '日志ID',
            'admin_id' => '管理员',
            'username' => '管理员名称',
            'route' => '路由名称',
            'name' => '记录详情',
            'method' => '操作方法',
            'get_data' => 'GET数据',
            'post_data' => 'POST数据',
            'ip' => 'IP地址',
            'agent' => 'Agent',
            'md5' => 'Md5',
            'created_at' => '创建时间',
            'lang' => '多语言',
        ];
    }

    /**
     * @inheritdoc
     * @return LogQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new LogQuery(get_called_class());
    }
}

<?php

namespace app\models\user;

use Yii;
use yii\helpers\ArrayHelper;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use app\widgets\laydate\LaydateBehavior;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property string $user_id 用户id
 * @property string $username 用户名
 * @property string $email 电子邮件
 * @property string $mobile 手机
 * @property string $password 密码
 * @property int $level_id 会员等级
 * @property int $ug_id 会员组
 * @property string $avatar 头像
 * @property int $sex 性别
 * @property string $company 公司名称
 * @property string $trade 行业
 * @property string $license 公司执照
 * @property string $telephone 公司固定电话
 * @property string $intro 备注说明
 * @property string $address_prov 通信地址_省
 * @property string $address_city 通信地址_市
 * @property string $address_country 通信地址_区
 * @property string $address 通信地址
 * @property string $zipcode 邮编
 * @property string $point 积分
 * @property string $reg_time 注册时间
 * @property string $reg_ip 注册IP
 * @property string $login_time 登录时间
 * @property string $login_ip 登录IP
 * @property string $qq_id 绑定QQ
 * @property string $weibo_id 绑定微博
 * @property string $wx_id 绑定微信
 * @property string $status 用户状态
 */
class User extends \app\models\base\User
{
	public $keyword;
	
	public function behaviors()
	{
	    return [
	        'regtime' => [
	            'class' => LaydateBehavior::class,
	            'timeAttribute' => 'reg_time',
	        ],
	    ];
	}

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
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
            [['username'], 'required'],
            [['level_id', 'ug_id', 'sex', 'point', 'login_time', 'status'], 'integer'],
            [['intro', 'username', 'password', 'qq_id', 'weibo_id', 'wx_id', 'email', 'mobile', 'telephone', 'reg_ip', 'login_ip', 'avatar', 'company', 'address', 'trade', 'address_prov', 'address_city', 'zipcode', 'license', 'address_country'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => '用户id',
            'username' => '用户名',
            'email' => '电子邮件',
            'mobile' => '手机',
            'password' => '密码',
            'level_id' => '会员等级',
            'ug_id' => '会员组',
            'avatar' => '头像',
            'sex' => '性别',
            'company' => '公司名称',
            'trade' => '行业',
            'license' => '公司执照',
            'telephone' => '公司固定电话',
            'intro' => '备注说明',
            'address_prov' => '省份',
            'address_city' => '市级',
            'address_country' => '地区',
            'address' => '地址详情',
            'zipcode' => '邮编',
            'point' => '积分',
            'reg_ip' => '注册IP',
            'login_ip' => '登录IP',
            'qq_id' => '绑定QQ',
            'weibo_id' => '绑定微博',
            'wx_id' => '绑定微信',
            'status' => '用户状态',
            'login_time' => '登录时间',
            'reg_time' => '注册时间',
        ];
    }
    
    /**
     * 一对一，对应会员组
     */
    public function getGroup()
    {
        return $this->hasOne(Group::class, ['ug_id' => 'ug_id']);
    }
    
    /**
     * 一对一，对应会员等级
     */
    public function getLevel()
    {
        return $this->hasOne(Level::class, ['level_id' => 'level_id']);
    }

    /**
     * @inheritdoc
     * @return UserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserQuery(get_called_class());
    }
}

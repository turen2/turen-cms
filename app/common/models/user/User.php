<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace common\models\user;

use Yii;
use yii\base\NotSupportedException;
use yii\web\IdentityInterface;
use common\components\ActiveRecord;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property string $user_id 用户id
 * @property string $username 用户名
 * @property string $email 电子邮件
 * @property string $phone 手机
 * @property string $password 密码
 * @property string $password_hash 密文
 * @property string $password_reset_token 改密码token
 * @property string $auth_key
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
 * @property string $reg_ip 注册IP
 * @property string $login_ip 登录IP
 * @property string $qq_id 绑定QQ
 * @property string $weibo_id 绑定微博
 * @property string $wx_id 绑定微信
 * @property int $status 状态，1为正常，0为黑名单
 * @property int $delstate 删除状态
 * @property string $deltime 删除时间
 * @property string $login_time 登录时间
 * @property string $reg_time 注册时间
 */
class User extends ActiveRecord implements IdentityInterface
{
    const USER_PHONE_MODE = 1;//仅手机验证模型
    const USER_EMAIL_MODE = 2;//仅邮箱验证模型

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['level_id', 'ug_id', 'sex', 'point', 'status', 'delstate', 'deltime', 'reg_time'], 'integer'],
            [['intro'], 'string'],
            [['username', 'password', 'qq_id', 'weibo_id', 'wx_id'], 'string', 'max' => 32],
            [['email'], 'string', 'max' => 40],
            [['phone', 'telephone', 'reg_ip', 'login_ip'], 'string', 'max' => 20],
            [['avatar', 'company', 'address'], 'string', 'max' => 100],
            [['trade', 'address_prov', 'address_city', 'zipcode'], 'string', 'max' => 10],
            [['license'], 'string', 'max' => 150],
            [['address_country'], 'string', 'max' => 15],
            [['password_hash', 'password_reset_token', 'auth_key'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'user_id' => '用户id',
            'username' => '用户名',
            'email' => '电子邮件',
            'phone' => '手机',
            'password' => '密码',
            'password_hash' => '密文',
            'password_reset_token' => '改密码token',
            'auth_key' => '',
            'level_id' => '会员等级',
            'ug_id' => '会员组',
            'avatar' => '头像',
            'sex' => '性别',
            'company' => '公司名称',
            'trade' => '行业',
            'license' => '公司执照',
            'telephone' => '公司固定电话',
            'intro' => '备注说明',
            'address_prov' => '通信地址_省',
            'address_city' => '通信地址_市',
            'address_country' => '通信地址_区',
            'address' => '通信地址',
            'zipcode' => '邮编',
            'point' => '积分',
            'reg_ip' => '注册IP',
            'login_ip' => '登录IP',
            'qq_id' => '绑定QQ',
            'weibo_id' => '绑定微博',
            'wx_id' => '绑定微信',
            'status' => '状态，1为正常，0为黑名单',
            'delstate' => '删除状态',
            'deltime' => '删除时间',
            'login_time' => '登录时间',
            'reg_time' => '注册时间',
        ];
    }

    public static function findIdentity($id)
    {
        return static::findOne(['user_id' => $id, 'status' => static::STATUS_ON]);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        //基于token的登录
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * 手机号码获取用户模型
     * @param $phone
     * @return User|null
     */
    public static function findByPhone($phone)
    {
        return static::findOne(['status' => static::STATUS_ON, 'phone' => $phone]);
    }

    /**
     * 邮箱码获取用户模型
     * @param $email
     * @return User|null
     */
    public static function findByEmail($email)
    {
        //echo User::find()->where(['status' => static::STATUS_ON, 'email' => $email])->createCommand()->getRawSql();exit;
        return static::findOne(['status' => static::STATUS_ON, 'email' => $email]);
    }

    /**
     * 用户名获取用户模型
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['status' => static::STATUS_ON, 'username' => $username]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => static::STATUS_ON,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }
        $expire = Yii::$app->params['config.userPasswordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int) end($parts);

        return $timestamp + $expire >= time();
    }

    public function getId()
    {
        return $this->getPrimaryKey();
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * 验证密码
     * @param string $password
     * @return boolean
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    /**
     * {@inheritdoc}
     * @return UserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserQuery(get_called_class());
    }
}

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
 * @property string $weixin_id 绑定微信
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
            [['username', 'password', 'qq_id', 'weibo_id', 'weixin_id'], 'string', 'max' => 32],
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
            'weixin_id' => '绑定微信',
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
     * 手机号码/用户名获取用户模型
     * @param $phone
     * @return User|null
     */
    public static function findByPhone($phone)
    {
        //['and', 'type=1', ['or', 'id=1', 'id=2']]
        return static::find()->where(['and', 'status='.static::STATUS_ON, ['or', 'phone='.Yii::$app->db->quoteValue($phone), 'username='.Yii::$app->db->quoteValue($phone)]])->one();
    }

    /**
     * 邮箱码/用户名获取用户模型
     * @param $email
     * @return User|null
     */
    public static function findByEmail($email)
    {
        return static::find()->where(['and', 'status='.static::STATUS_ON, ['or', 'email='.Yii::$app->db->quoteValue($email), 'username='.Yii::$app->db->quoteValue($email)]])->one();
    }

    /**
     * Finds user by password reset token
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
     * 绑定第三方登录注册的数据
     * @param integer $id
     * @param array $openid
     * @param array $userInfo
     * @return void|boolean
     */
    public static function BindAuthData($id, $openid, $userInfo)
    {
        if($id == 'weibo') {//微博
            $model = new Weibo();
            $model->uid = $userInfo['id'];
            $model->screen_name = $userInfo['screen_name'];
            $model->name = $userInfo['name'];
            $model->province = intval($userInfo['province']);
            $model->city = intval($userInfo['city']);
            $model->location = $userInfo['location'];
            $model->description = $userInfo['description'];
            $model->profile_image_url = $userInfo['profile_image_url'];
            $model->profile_url = $userInfo['profile_url'];
            $model->gender = $userInfo['gender'];
            $model->verified = intval($userInfo['verified']);
            $model->avatar_large = $userInfo['avatar_large'];
            $model->avatar_hd = $userInfo['avatar_hd'];
            $model->save(false);
        } elseif($id == 'qq') {//扣扣
            $model = new Qq();
            $model->uid = $openid;
            $model->nickname = $userInfo['nickname'];
            $model->gender = $userInfo['gender'];
            $model->province = $userInfo['province'];
            $model->city = $userInfo['city'];
            $model->year = $userInfo['year'];
            $model->figureurl = $userInfo['figureurl'];
            $model->figureurl_1 = $userInfo['figureurl_1'];
            $model->figureurl_2 = $userInfo['figureurl_2'];
            $model->figureurl_qq_1 = $userInfo['figureurl_qq_1'];
            $model->figureurl_qq_2 = $userInfo['figureurl_qq_2'];
            $model->save(false);
        } elseif($id == 'wx') {//微信

        } else {
            return ;//后续加上
        }

        return true;
    }

    /**
     * 返回指定的第三方绑定数据
     * @param string $id
     * @param string $openid
     * @return NULL| Model
     */
    public static function FindAuthData($id, $openid)
    {
        $model = null;
        if($id == 'weibo') {//微博
            $model = Weibo::findOne(['uid' => $openid]);
        } elseif($id == 'qq') {//扣扣
            $model = Qq::findOne(['uid' => $openid]);
        } elseif($id == 'wx') {//微信

        } else {
            //后续加上
        }

        return $model;
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
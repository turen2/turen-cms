<?php
/**
 * @link http://www.juwanfang.com/
 * @copyright Copyright (c) 聚万方CMS
 * @author developer qq:980522557
 */
namespace app\models\sys;

use Yii;
use yii\web\IdentityInterface;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;
use yii\helpers\StringHelper;

/**
 * This is the model class for table "ss_admin".
 *
 * @property int $id 信息id
 * @property string $username 用户名
 * @property string $password 密码
 * @property string $nickname 昵称
 * @property int $question 登录提问
 * @property string $answer 登录回答
 * @property string $loginip 登录IP
 * @property string $logintime 登录时间
 * @property string $role_id 角色
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $phone 手机号码
 * @property int $status
 * @property int $favorite_menu
 * @property string $created_at
 * @property string $updated_at
 */
class Admin extends \app\models\base\Sys implements IdentityInterface
{
    public $keyword;
    public $password;
    public $repassword;
    
    private static $_roleModels = false;
    
    public function init()
    {
        parent::init();
        
        if(empty(self::$_roleModels)) {
            self::$_roleModels = Role::find()->all();
        }
    }
    
    /**
     * 联表后产生的本模型之外的字段信息
     * {@inheritDoc}
     * @see \yii\db\ActiveRecord::attributes()
     */
    public function attributes()
    {
        return array_merge(parent::attributes(), []);
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%sys_admin}}';
    }
    
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'phone'], 'required'],//必填
            ['username', 'string', 'min' => 2, 'max' => 16],//用户名要求
            ['password', 'string', 'min' => 6],//密码要求
            [['username'], 'unique'],//在当前站点是唯一//'targetClass' => '\app\models\sys\Admin'
            
            [['repassword', 'favorite_menu'], 'string'],
            [['phone'], 'string', 'max' => 30],
            ['phone','match','pattern'=>'/^[1][3578][0-9]{9}$/'],
            [['password', 'username', 'nickname', 'auth_key'], 'string', 'max' => 32],
            [['answer'], 'string', 'max' => 50],
            [['loginip'], 'string', 'max' => 20],
            ['status', 'in', 'range' => [self::STATUS_OFF, self::STATUS_ON]],
            [['status', 'created_at', 'updated_at', 'question', 'logintime', 'role_id'], 'integer'],
            [['password_hash', 'password_reset_token'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '信息id',
            'username' => '用户名',
            'password' => '密码',
            'repassword' => '确认密码',
            'nickname' => '昵称',
            'question' => '登录提问',
            'answer' => '登录回答',
            'loginip' => '登录IP',
            'logintime' => '登录时间',
            'phone' => '手机号码',
            'status' => '审核',
            'favorite_menu' => '快捷菜单',
            'role_id' => '管理角色',
            'created_at' => '添加时间',
            'updated_at' => '修改时间',
        ];
    }
    
    /**
     * 验证之前
     * {@inheritDoc}
     * @see \yii\base\Model::beforeValidate()
     */
    public function beforeValidate()
    {
        parent::beforeValidate();
        
        //新的必须填写密码
        if($this->isNewRecord) {
            if(empty($this->password)) {
                $this->addError('password', '密码必须填写。');
                return false;
            }
        }
        
        //安全问题成对出现
        if((!empty($this->question) && empty($this->answer)) || (empty($this->question) && !empty($this->answer))) {
            $this->addError('question', '安全问题和答案必须同时设置。');
            return false;
        }
        
        //密码和确认密码必须相同
        if($this->password != $this->repassword) {
            $this->addError('password', '密码和确认密码必须相同。');
            return false;
        }
        
        //正式生成hash密码
        if(!empty($this->password)) {
            $this->setPassword($this->password);
            $this->generateAuthKey();
        }
    
        return true;
    }
    
    public function getRoleName()
    {
        if($this->isFounder()) {
            return '【创始人】';
        }
        
        if(self::$_roleModels) {
            $roles = ArrayHelper::map(self::$_roleModels, 'role_id', 'role_name');
            return isset($roles[$this->role_id])?$roles[$this->role_id]:'未知';
        } else {
            return '未知';
        }
    }
    
    /*
     * 是否为创始人
     */
    public function isFounder()
    {
        return in_array($this->id, Yii::$app->params['config.founderList']);
    }
    
    /**
     * 检测访问权限
     * @return \yii\db\ActiveQuery
     */
    public function checkAccess($route)
    {
        //创始人
        if($this->isFounder()) {
            return true;
        }
        
        //登录后无条件权限
        foreach (Yii::$app->params['config.loginNotAccessRoute'] as $pattern) {
            if (StringHelper::matchWildcard($pattern, $route)) {
                return true;
            }
        }
        
        //管理者登录后，后台配置的权限检测
        if(self::$_roleModels) {
            foreach (self::$_roleModels as $roleModel) {
                if($roleModel->role_id == $this->role_id) {
                    return $roleModel->checkPerm($route);
                }
            }
        }
        
        return false;
    }
    
    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => static::STATUS_ON]);
    }
    
    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        //基于token的登录
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }
    
    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => static::STATUS_ON]);
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
    
    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }
    
    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }
    
    /**
     * @inheritdoc
     */
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
     * 验证安全问题
     * @param number $questionId
     * @param string $value
     * @return boolean
     */
    public function validateQuestion($questionId, $value)
    {
        if(empty($this->question)) {
            return true;
        }
        
        if($this->question == $questionId && $this->answer == $value) {
            return true;
        }
        
        return false;
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
     * @inheritdoc
     * @return AdminQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AdminQuery(get_called_class());
    }
}

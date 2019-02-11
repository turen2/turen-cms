<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace common\models\user;

use Yii;
use yii\base\Model;

/**
 * Login form
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;
    public $verifyCode;
    public $phone;
    
    public $verifyName;//统一的凭证，包括用户名、邮箱、手机号
    
    private $_user;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // name and password are both required
            [['password', 'verifyName', 'verifyCode'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
            ['verifyCode', 'captcha',
                'skipOnEmpty' => false,
                'caseSensitive' => false,
                'captchaAction' => 'account/user/captcha',
            ],
            [['verifyName', 'password', 'verifyCode'], 'trim']
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return array(
            'username' => '用户名',
            'password' => '用户密码',
            'rememberMe' => '下次自动登录',
            'verifyCode' => '验证码',
            'email' => '邮箱',
            'phone' => '手机号码',
            'verifyName' => '用户名/邮箱/手机号',
        );
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect name or password.');
            }
        }
    }

    /**
     * Logs in a user using the provided name and password.
     *
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        } else {
            return false;
        }
    }

    /**
     * Finds user by [[name]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::findByVerifyName($this->verifyName);
        }

        return $this->_user;
    }
}

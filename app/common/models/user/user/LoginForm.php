<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace common\models\user\user;

use Yii;
use yii\base\Model;
use common\models\user\User;

/**
 * Login form
 */
class LoginForm extends Model
{
    public $email;//邮箱
    public $password;
    public $rememberMe = true;
    public $verifyCode;
    private $_user;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = [
            [['password', 'verifyCode'], 'required'],
            ['rememberMe', 'boolean'],
            ['password', 'validatePassword'],
            [['password', 'verifyCode'], 'trim'],
            ['verifyCode', 'captcha',
                'skipOnEmpty' => false,
                'caseSensitive' => false,
                'captchaAction' => 'account/user/captcha',
            ],
        ];

        $rules[] = ['email', 'required'];
        $rules[] = ['email', 'string', 'min' => 5];
        $rules[] = ['email', 'email'];

        return $rules;
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        $labels = [
            'email' => '用户邮箱',
            'password' => '用户密码',
            'rememberMe' => '下次自动登录',
            'verifyCode' => '验证码',
        ];

        return $labels;
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
                $this->addError($attribute, '请输入正确的账号或密码！');
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
     * Finds user by [[email]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            !empty($this->email) && $this->_user = User::findByEmail($this->email);
        }

        return $this->_user;
    }
}
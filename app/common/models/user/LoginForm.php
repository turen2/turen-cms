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
    public $email;//邮箱
    public $phone;//手机号
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

        if(Yii::$app->params['config_login_mode'] == User::USER_PHONE_MODE) {
            $rules[] = ['phone', 'required'];
            $rules[] = ['phone', 'string', 'min' => 6, 'max' => 20];
            $rules[] = ['phone','match','pattern'=>'/^[1][3578][0-9]{9}$/'];
        } elseif(Yii::$app->params['config_login_mode'] == User::USER_EMAIL_MODE) {
            $rules[] = ['email', 'required'];
            $rules[] = ['email', 'string', 'min' => 5];
            $rules[] = ['email', 'email'];
        }

        return $rules;
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        $labels = [
            'email' => '用户邮箱',
            'phone' => '手机号码',
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
                $this->addError($attribute, '请输入正确的用户名或密码！');
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
            if(Yii::$app->params['config_login_mode'] == User::USER_PHONE_MODE) {
                $this->_user = User::findByPhone($this->phone);
            } elseif(Yii::$app->params['config_login_mode'] == User::USER_EMAIL_MODE) {
                $this->_user = User::findByEmail($this->email);
            }
        }

        return $this->_user;
    }
}
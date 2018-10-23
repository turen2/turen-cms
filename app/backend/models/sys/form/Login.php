<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace app\models\sys\form;

use Yii;
use yii\base\Model;
use app\models\sys\Admin;
use yii\web\User;

/**
 * Login form
 */
class Login extends Model
{
    public $username;
    public $password;
    public $verifyCode;
    public $questionId;//问题id
    public $answer;//问题答案
    public $rememberMe = true;
    
    private $_user = false;
    
    public function init()
    {
        parent::init();
        
        //登录之前获取上次登录的时间，即上次登录时间
        Yii::$app->user->on(User::EVENT_BEFORE_LOGIN, function($event) {
            //更新登录后的相关数据
            $identity = $event->identity;
            
            $ip = Yii::$app->getRequest()->getUserIP();
            $identity->loginip = in_array($ip, ['::1', 'localhost'])?'127.0.0.1':$ip;
            $identity->logintime = $identity->updated_at;
            $identity->updated_at = time();
            $identity->save(false);
        });
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'password', 'verifyCode'], 'required'],
            ['verifyCode', 'captcha',
                'skipOnEmpty' => false,
                'caseSensitive' => false,
                'captchaAction' => 'site/admin/captcha',
            ],
            ['rememberMe', 'boolean'],
            ['questionId', 'number'],
            
            ['password', 'validatePassword'],
            ['answer', 'validateQuestion'],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => '账号名称',
            'password' => '账号密码',
            'verifyCode' => '数字验证码',
            'questionId' => '安全问题',
            'answer' => '答案',
            'rememberMe' => '是否需要自动登录',
        ];
    }

    /**
     * 验证密码
     * @param string $attribute
     * @param [] $params
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, '无法验证用户名或密码');
            }
        }
    }

    /**
     * 验证安全问题
     * @param string $attribute
     * @param [] $params
     */
    public function validateQuestion($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validateQuestion($this->questionId, $this->answer)) {
                $this->addError($attribute, '您的安全问题答案错误');
            }
        }
    }
    
    /**
     * Logs in a user using the provided username and password.
     *
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->getUser()->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);//记住一个月
        } else {
            return false;
        }
    }

    /**
     * Finds user by [[username]]
     *
     * @return Admin|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = Admin::findByUsername($this->username);
        }

        return $this->_user;
    }
}

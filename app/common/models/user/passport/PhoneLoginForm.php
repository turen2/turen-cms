<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace common\models\user\passport;

use common\phonecode\PhoneCodeValidator;
use Yii;
use yii\base\Model;
use common\models\user\User;
use yii\validators\Validator;

/**
 * phoneLogin form
 */
class PhoneLoginForm extends Model
{
    public $phone;//手机号
    public $phoneCode;//手机验证码
    public $rememberMe = true;

    public $verifyCode;
    private $_user;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = [
            [['phone', 'phoneCode'], 'required'],
            [['phone', 'phoneCode'], 'trim'],
            ['phone', 'match','pattern'=>'/^[1][3578][0-9]{9}$/'],
            ['rememberMe', 'boolean'],
            ['phoneCode', PhoneCodeValidator::class],//自定义验证器

            //图形验证码，不需要再验证
//            ['verifyCode', 'captcha',
//                'skipOnEmpty' => false,
//                'caseSensitive' => false,
//                'captchaAction' => 'account/passport/captcha',
//            ],
        ];

        return $rules;
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        $labels = [
            'phone' => '手机号码',
            'phoneCode' => '手机验证码',
            'rememberMe' => '下次自动登录',
            'verifyCode' => '图形验证码',
        ];

        return $labels;
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
            !empty($this->phone) && $this->_user = User::findByPhone($this->phone);
        }

        return $this->_user;
    }
}
<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace common\models\user\passport;

use Yii;
use yii\base\Model;
use common\models\user\User;
use common\phonecode\PhoneCodeValidator;

/**
 * Forget form
 */
class ForgetForm extends Model
{
    public $phone;
    public $phoneCode;//手机验证码
    public $verifyCode;//验证码

    private $_user;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['phone', 'phoneCode'], 'required'],
            ['phone', 'trim'],
            ['phone', 'match','pattern'=>'/^[1][3578][0-9]{9}$/'],
            ['phone', 'exist',
                'targetClass' => User::class,
                'filter' => ['status' => User::STATUS_ON],
                'message' => '您输入的手机号码有误，请重试。',
            ],
            ['phoneCode', PhoneCodeValidator::class],//自定义验证器

//            ['verifyCode', 'captcha',
//                'skipOnEmpty' => false,
//                'caseSensitive' => false,
//                'captchaAction' => 'account/user/captcha',
//            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        $labels = [
            'phone' => '手机号码',
            'phoneCode' => '手机验证码',
            'verifyCode' => '图形验证码',
        ];

        return $labels;
    }

    /**
     * 生成一个临时token码，用于修改密码之前的认证工作
     * @return bool
     */
    public function generateToken()
    {
        /* @var $user User */
        $user = $this->getUser();

        if (!$user) {
            return false;
        }

        if (!User::isPasswordResetTokenValid($user->password_reset_token)) {
            $user->generatePasswordResetToken();
            if (!$user->save(false)) {
                return false;
            }
        }

        return $user->password_reset_token;
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
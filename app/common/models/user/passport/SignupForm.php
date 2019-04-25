<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace common\models\user\passport;

use Yii;
use yii\base\Model;
use yii\validators\CompareValidator;
use common\models\user\User;
use common\phonecode\PhoneCodeValidator;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $phone;//电话
    public $password;//密码
    public $rePassword;//重复密码
    public $verifyCode;//验证码
    public $phoneCode;//验证码
    public $agreeProtocol = 1;//同意协议

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = [
            [['phone', 'password', 'rePassword', 'verifyCode', 'agreeProtocol'], 'required'],
            ['phone', 'unique', 'targetClass' => '\common\models\user\User'],
            ['phone', 'match','pattern'=>'/^[1][3578][0-9]{9}$/'],
            [['password', 'rePassword'], 'string', 'min' => 6],
            ['rePassword','compare','compareAttribute'=>'password'],
            ['agreeProtocol', 'compare', 'compareValue' => 1, 'type' => CompareValidator::TYPE_NUMBER, 'message' => '必须同意用户协议'],
            ['phoneCode', PhoneCodeValidator::class, 'phoneAttribute' => 'phone'],//自定义验证器

//            ['verifyCode', 'captcha',
//                'skipOnEmpty' => false,
//                'caseSensitive' => false,
//                'captchaAction' => 'account/user/captcha',
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
            'password' => '输入密码',
            'rePassword' => '确认密码',
            'verifyCode' => '图形验证码',
            'phoneCode' => '手机验证码',
            'agreeProtocol' => '我已阅读并同意"'.Yii::$app->params['config_site_name'].'"的',
        ];

        return $labels;
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            //var_dump($this->getErrors());exit;
            return null;
        }
        
        $user = new User();//['scenario' => 'register']
        $user->username = $this->phone;
        $user->phone = $this->phone;
        $user->reg_time = time();
        $user->status = User::STATUS_ON;
        $user->setPassword($this->password);
        $user->generateAuthKey();

        return $user->save() ? $user : null;
    }
}

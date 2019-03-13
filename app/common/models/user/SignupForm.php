<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace common\models\user;

use Yii;
use yii\base\Model;
use yii\helpers\Url;
use yii\validators\CompareValidator;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $phone;//电话
    public $email;//邮箱
    public $password;//密码
    public $rePassword;//重复密码
    public $verifyCode;//验证码
    public $agreeProtocol = 1;//同意协议

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = [
            [['password', 'rePassword', 'verifyCode', 'agreeProtocol'], 'required'],
            [['password', 'rePassword'], 'string', 'min' => 6],
            ['agreeProtocol', 'compare', 'compareValue' => 1, 'type' => CompareValidator::TYPE_NUMBER, 'message' => '必须同意用户协议'],
            ['verifyCode', 'captcha',
                'skipOnEmpty' => false,
                'caseSensitive' => false,
                'captchaAction' => 'account/user/captcha',
            ],
        ];

        if(Yii::$app->params['config_login_mode'] == User::USER_PHONE_MODE) {
            $rules[] = ['phone', 'required'];
            $rules[] = ['phone', 'unique', 'targetClass' => '\common\models\user\User'];
            $rules[] = ['phone', 'string', 'min' => 6, 'max' => 20];
            $rules[] = ['phone','match','pattern'=>'/^[1][3578][0-9]{9}$/'];
        } elseif(Yii::$app->params['config_login_mode'] == User::USER_EMAIL_MODE) {
            $rules[] = ['email', 'required'];
            $rules[] = ['email', 'unique', 'targetClass' => '\common\models\user\User'];
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
            'phone' => '手机号码',
            'email' => '用户邮箱',
            'password' => '输入密码',
            'rePassword' => '确认密码',
            'verifyCode' => '验证码',
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
        if(Yii::$app->params['config_login_mode'] == User::USER_PHONE_MODE) {
            $user->username = $this->phone;
            $user->phone = $this->phone;
        } elseif(Yii::$app->params['config_login_mode'] == User::USER_EMAIL_MODE) {
            $user->username = $this->email;
            $user->email = $this->email;
        }
        $user->reg_time = time();
        $user->status = User::STATUS_ON;
        $user->setPassword($this->password);
        $user->generateAuthKey();

        return $user->save() ? $user : null;
    }
}

<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace common\models\user;

use Yii;
use yii\base\Model;
use common\models\user\User;

/**
 * Password reset request form
 */
class PasswordResetRequestPhoneForm extends Model
{
    public $phone;
    public $verifyCode;//手机验证码

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['phone', 'verifyCode'], 'trim'],
            [['phone', 'verifyCode'], 'required'],
            [['phone', 'verifyCode'], 'number'],
            ['phone','match','pattern'=>'/^[1][3578][0-9]{9}$/'],
            ['phone', 'exist',
                'targetClass' => '\common\models\user\User',
                'filter' => ['status' => Merchant::STATUS_ACTIVE],
                'message' => '手机号码有误或请尝试注册新用户！'
            ],
            ['verifyCode', 'validateVerifyCod'],
        ];
    }
    
    public function validateVerifyCod($attribute)
    {
        $result = Yii::$app->sms->validate($this->$attribute);
        if(!$result) {
            $this->addError($attribute, '手机验证码错误，请重新验证！');
        }
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'phone' => Yii::t('merchant', 'Phone'),
            'verifyCode' => Yii::t('merchant', 'Phone Code'),
        ];
    }

    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return bool whether the email was send
     */
    public function sendEmail()
    {
        /* @var $user User */
        $user = Merchant::findOne([
            'status' => Merchant::STATUS_ACTIVE,
            'email' => $this->email,
        ]);

        if (!$user) {
            return false;
        }
        
        if (!Merchant::isPasswordResetTokenValid($user->password_reset_token)) {
            $user->generatePasswordResetToken();
            if (!$user->save()) {
                return false;
            }
        }
        
        return Yii::$app->mailer->compose(
                ['html' => 'passwordResetToken-html', 'text' => 'passwordResetToken-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($this->email)
            ->setSubject('Password reset for ' . Yii::$app->name)
            ->send();
    }
}

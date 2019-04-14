<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace common\models\com;

use Yii;
use yii\base\Model;

/**
 * VerifyConsult form
 */
class VerifyConsult extends Model
{
    public $verifyCode;//数字验证码
    public $phone;//手机号
    public $phoneCode;//手机动态码

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = [
            [['verifyCode', 'phone', 'phoneCode'], 'required'],
            [['verifyCode', 'phone', 'phoneCode'], 'trim'],
            ['verifyCode', 'captcha',
                'skipOnEmpty' => false,
                'caseSensitive' => false,
                'captchaAction' => 'site/captcha',
            ],
            //加个手机验证码
        ];

        return $rules;
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePhoneCode($attribute, $params)
    {
        if (!$this->hasErrors()) {
            //
        }
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        $labels = [
            'phone' => '手机号码',
            'verifyCode' => '手机验证码',
            'phoneCode' => '手机动态码',
        ];

        return $labels;
    }
}
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
 * Password reset form
 */
class VerifyCodeForm extends Model
{
    public $verifyCode;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['verifyCode', 'required'],
            ['verifyCode', 'captcha',
                'skipOnEmpty' => false,
                'caseSensitive' => false,
                'captchaAction' => 'account/user/captcha',
            ],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'verifyCode' => '验证码',
        ];
    }
}

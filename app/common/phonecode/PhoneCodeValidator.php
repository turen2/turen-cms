<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */

namespace common\phonecode;

use Yii;
use yii\validators\Validator;
use common\actions\ValidateCaptchaAction;

class PhoneCodeValidator extends Validator
{
    /**
     * 发验证码的手机号对应的属性
     */
    public $phoneAttribute;

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        if ($this->message === null) {
            $this->message = Yii::t('app', '{attribute}错误或已过期');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function validateAttribute($model, $attribute)
    {
        //验证通过
        $session = Yii::$app->getSession();
        //验证码
        $sessionCode = $session->get(PhoneCodeAction::PHONE_CODE_PARAM);
        if($model->{$this->phoneAttribute} != $sessionCode['phone']) {
            $this->addError($model, $attribute, '手机号码验证前后必须相同');
        }
        if($model->{$attribute} != $sessionCode['code']) {
            $this->addError($model, $attribute, $this->message);
        }
        if((time() - $sessionCode['t']) > PhoneCodeAction::PHONE_CODE_VALID_TIME) {
            $this->addError($model, $attribute, $this->message);
        }

        //清理旧验证码
        if(empty($model->getErrors())) {
            $session->remove(ValidateCaptchaAction::VERIFY_CODE_PARAM);
            $session->remove(PhoneCodeAction::PHONE_CODE_PARAM);
        }
    }
}

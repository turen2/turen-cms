<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */

namespace common\phonecode;

use Yii;
use yii\validators\Validator;

class PhoneCodeValidator extends Validator
{
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
        if($model->{$attribute} != $sessionCode['code']) {
            $this->addError($model, $attribute, $this->message);
        }
        if((time() - $sessionCode['t']) > PhoneCodeAction::PHONE_CODE_VALID_TIME) {
            $this->addError($model, $attribute, $this->message);
        }

        //清理老验证码
        if(empty($model->getErrors())) {
            $session->remove(PhoneCodeAction::VERIFY_CODE_PARAM);
            $session->remove(PhoneCodeAction::PHONE_CODE_PARAM);
        }
    }
}

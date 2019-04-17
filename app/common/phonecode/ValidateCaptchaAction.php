<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace common\phonecode;

use Yii;
use yii\base\Action;
use yii\base\InvalidConfigException;

class ValidateCaptchaAction extends Action
{
    public $verifycode;
    public $captchaAction;
    public $skipOnEmpty = false;
    public $caseSensitive = false;

    public function init()
    {
        parent::init();

        if (empty($this->verifycode) || empty($this->captchaAction)) {
            throw new InvalidConfigException(self::class . '参数配置有误');
        }
    }

    public function run()
    {
        $captcha = $this->createCaptchaAction();
        $valid = $captcha->validate($this->verifycode, $this->caseSensitive);
        $session = Yii::$app->getSession();
        if($valid) {
            //记录到phonecode中，以便通过短信发送前检验
            $session->set(PhoneCodeAction::VERIFY_CODE_PARAM, $this->verifycode);
            $this->controller->asJson([
                'state' => true,
                'code' => 200,
                'msg' => '图形验证码验证成功',
            ]);
        } else {
            $this->controller->asJson([
                'state' => false,
                'code' => 200,
                'msg' => '图形验证码验证失败',
            ]);
        }
    }

    public function createCaptchaAction()
    {
        $ca = Yii::$app->createController($this->captchaAction);
        if ($ca !== false) {
            /* @var $controller \yii\base\Controller */
            list($controller, $actionID) = $ca;
            $action = $controller->createAction($actionID);
            if ($action !== null) {
                return $action;
            }
        }
        throw new InvalidConfigException('Invalid CAPTCHA action ID: ' . $this->captchaAction);
    }
}

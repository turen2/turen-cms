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
use common\helpers\Util;
use console\queue\AlismsJob;
use common\actions\ValidateCaptchaAction;

class PhoneCodeAction extends Action
{
    const PHONE_CODE_PARAM = 'PhoneCode9494FSKh54';
    const PHONE_CODE_VALID_TIME = 100;//验证码有效时间
    const PHONE_MATCH_PATTERN = '/^[1][35678][0-9]{9}$/';

    public $verifycode;//上一次的图形验证码，为false时，不验证
    public $phone;//手机号码
    public $maxNum = 6;//数字验证码最大多少位
    public $signTemplate;//短信签名模板

    public function init()
    {
        parent::init();

        if(empty($this->maxNum) || empty($this->phone) || empty($this->signTemplate)) {
            throw new InvalidConfigException(self::class.'参数配置有误');
        }
    }

    public function run()
    {
        $session = Yii::$app->getSession();
        if($this->verifycode !== false) {
            $oldVerifyCode = $session->get(ValidateCaptchaAction::VERIFY_CODE_PARAM, null);
            if(empty($oldVerifyCode) || ($oldVerifyCode != $this->verifycode)) {
                return $this->controller->asJson([
                    'state' => false,
                    'code' => 200,
                    'msg' => '图形验证码验证错误',
                ]);
            }
        }

        if(!preg_match(self::PHONE_MATCH_PATTERN, $this->phone)) {
            return $this->controller->asJson([
                'state' => false,
                'code' => 200,
                'msg' => '手机号码格式有误',
            ]);
        }

        //发短信
        $code = Util::GeneratePhoneCode(6);
        $phoneCode = [
            'phone' => $this->phone,
            'code' => $code,
            't' => time(),
        ];

        //设计验证码会话，且发短信加入队列任务
        $session->set(self::PHONE_CODE_PARAM, $phoneCode);//必须是对应手机号码的验证码！
        //测试
        //file_put_contents('D:\xampp\aaa.txt', $code);
        //push到短信发送队列
        $signTemplate = Yii::$app->params[trim($this->signTemplate)];

        Yii::$app->smsQueue->ttr(10);
        Yii::$app->smsQueue->delay(0);
        Yii::$app->smsQueue->priority(98);
        Yii::$app->smsQueue->push(new AlismsJob([
            'phoneNumber' => $this->phone,
            'signName' => $signTemplate['signName'],
            'templateCode' => $signTemplate['templateCode'],
            'templateParams' => ['code' => $code],
        ]));

        $this->controller->asJson([
            'state' => true,
            'code' => 200,
            'msg' => '验证码已经发送',//返回验证码
        ]);
    }
}

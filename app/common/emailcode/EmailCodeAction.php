<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace common\emailcode;

use Yii;
use yii\base\Action;
use yii\base\InvalidConfigException;
use common\helpers\Util;
use console\queue\SmtpMailJob;
use common\helpers\ImageHelper;
use common\actions\ValidateCaptchaAction;

class EmailCodeAction extends Action
{
    const EMAIL_CODE_PARAM = 'EmailCode9494FSKh54';
    const EMAIL_CODE_VALID_TIME = 300;//验证码有效时间/5分钟
    const EMAIL_MATCH_PATTERN = '/^[a-zA-Z0-9!#$%&\'*+\\/=?^_`{|}~-]+(?:\.[a-zA-Z0-9!#$%&\'*+\\/=?^_`{|}~-]+)*@(?:[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?\.)+[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?$/';

    public $verifycode;//上一次的图形验证码，为false时，不验证
    public $email;//邮箱
    public $maxNum = 6;//数字验证码最大多少位

    public function init()
    {
        parent::init();

        if(empty($this->maxNum) || empty($this->email)) {
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

        if(!preg_match(self::EMAIL_MATCH_PATTERN, $this->email)) {
            return $this->controller->asJson([
                'state' => false,
                'code' => 200,
                'msg' => '邮箱格式有误',
            ]);
        }

        //发邮件
        $code = Util::GeneratePhoneCode(6);
        $emailCode = [
            'email' => $this->email,
            'code' => $code,
            't' => time(),
        ];

        //设计验证码会话，且发短信加入队列任务
        $session->set(self::EMAIL_CODE_PARAM, $emailCode);//必须是对应邮箱的验证码！
        $userModel = Yii::$app->getUser()->getIdentity();//尝试使用用户信息
        //测试
        //file_put_contents('D:\xampp\aaa.txt', $code);
        //设置重试间隔时间、延迟时间、优先级。
        Yii::$app->mailQueue->ttr(10);
        Yii::$app->mailQueue->delay(0);
        Yii::$app->mailQueue->priority(100);

        Yii::$app->mailQueue->push(new SmtpMailJob([
            'template' => GLOBAL_LANG.'/emailcode',//语言标识模板名称
            'params' => [
                'logo' => empty(Yii::$app->params['config_frontend_logo'])?ImageHelper::getNopic():Yii::$app->aliyunoss->getObjectUrl(Yii::$app->params['config_frontend_logo'], true),
                'code' => $code,
                'username' => empty($userModel)?$this->email:$userModel->username,
                'sitename' => Yii::$app->params['config_site_name'],
            ],
            'sendTo' => $this->email,
            'from' => [Yii::$app->params['config.supportEmail'] => Yii::$app->params['config_site_name']],
            'subject' => '邮件验证码 -- ' . Yii::$app->params['config_site_name'],
        ]));

        $this->controller->asJson([
            'state' => true,
            'code' => 200,
            'msg' => '验证码已经发送',//返回验证码
        ]);
    }
}

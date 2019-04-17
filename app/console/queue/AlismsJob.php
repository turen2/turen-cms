<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace console\queue;

use Yii;
use yii\base\BaseObject;
use yii\base\InvalidConfigException;
use yii\log\Logger;

/**
 * Class AlismsJob.
 */
class AlismsJob extends BaseObject implements \yii\queue\JobInterface
{
    public $phoneNumber;
    public $signName;
    public $templateCode;
    public $templateParams = [];

    public function init()
    {
        parent::init();

        if(empty($this->phoneNumber) || empty($this->signName) || empty($this->templateCode) || empty($this->templateParams)) {
            throw new InvalidConfigException(self::class.'参数配置错误');
        }
    }

    /**
     * 短信单条发送
     * @inheritdoc
     */
    public function execute($queue)
    {
        try {
            //验证码：Yii::$app->sms->sendSms('13725514524', '小铃铛科技', 'SMS_91980004', ['code' => '123456']);
            $response = Yii::$app->sms->sendSms($this->phoneNumber, $this->signName, $this->templateCode, $this->templateParams);
            //file_put_contents('D:\xampp\aaa.txt', $response);
            if($response->Code == 'OK') {
                return true;
            } else {
                Yii::getLogger()->log($response, Logger::LEVEL_WARNING, 'console');
            }
        } catch (\Exception $e) {
            //file_put_contents('D:\xampp\aaa.txt', $e->getMessage());
            Yii::getLogger()->log($e->getMessage(), Logger::LEVEL_WARNING, 'console');
        }
    }
}



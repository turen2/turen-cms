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
use yii\console\Exception;
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
            //验证码：Yii::$app->sms->sendSms('13725514524', '亚桥机械租赁', 'SMS_178575122', ['code' => '123456']); // 验证码${code}，您正在登录，若非本人操作，请勿泄露。
            $response = Yii::$app->sms->sendSms($this->phoneNumber, $this->signName, $this->templateCode, $this->templateParams);
            //file_put_contents('D:\xampp\aaa.txt', $response);
            if($response->Code == 'OK') {
                return true;
            } else {
                throw new Exception('阿里云发送短信失败，内容：'.print_r([$this->phoneNumber, $this->signName, $this->templateCode, $this->templateParams], true));
                // Yii::getLogger()->log($response, Logger::LEVEL_WARNING, 'console');
            }
        } catch (\Exception $e) {
            // Yii::getLogger()->log($e->getMessage(), Logger::LEVEL_WARNING, 'console');
            throw $e;
        }
    }
}



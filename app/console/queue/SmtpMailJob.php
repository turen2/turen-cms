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
 * Class SmtpMailJob.
 */
class SmtpMailJob extends BaseObject implements \yii\queue\JobInterface
{
    /**
     * 使用的邮件模板，注意带语言标识
     * @var string
     */
    public $template;

    /**
     * 传入的参数
     * @var array
     */
    public $params = [];

    /**
     * 发送对象邮箱
     * `[email => name]`.
     * @var string|array
     */
    public $sendTo;

    /**
     * 邮箱来源说明
     * `[email => name]`.
     * @var string|array
     */
    public $from;

    /**
     * 邮件标题
     * @var string
     */
    public $subject;

    public function init()
    {
        parent::init();

        //检验相关参数
        if(empty($this->template) || empty($this->sendTo) || empty($this->from) || empty($this->subject)) {
            throw new InvalidConfigException(self::class.'发邮件参数配置有误。');
        }
    }

    /**
     * @inheritdoc
     */
    public function execute($queue)
    {
        //邮件发送
        try {
            Yii::$app->mailer
                ->compose(['html' => $this->template.'-html', 'text' => $this->template.'-text'], ['params' => $this->params])
                ->setFrom($this->from)
                ->setTo($this->sendTo)
                //->setReplyTo(['test@qq.com' => '测试标题'])//默认回复地址
                ->setSubject($this->subject)
                ->send();
        } catch (\Exception $e) {
            Yii::getLogger()->log($e->getMessage(), Logger::LEVEL_WARNING, 'console');
        }
    }
}



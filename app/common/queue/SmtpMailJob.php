<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace common\queue;

use Yii;
use yii\base\BaseObject;

/**
 * Class SmtpMailJob.
 */
class SmtpMailJob extends BaseObject implements \yii\queue\JobInterface
{
    /**
     * 使用的邮件模板
     * @var string
     */
    public $template = '';

    /**
     * 传入的参数
     * @var string
     */
    public $params = '';

    /**
     * 发送对象邮箱
     * @var string
     */
    public $sendTo = '';

    /**
     * 邮件标题
     * @var string
     */
    public $subject = '';

    public function init()
    {
        parent::init();

        //检验相关参数

    }

    /**
     * @inheritdoc
     */
    public function execute($queue)
    {
        //邮件发送
        try {
            Yii::$app->mailer
                ->compose(['html' => $this->template.'-html', 'text' => $this->template.'-text'], ['data' => $this->params])
                ->setFrom([Yii::$app->params['config.supportEmail'] => Yii::$app->params['config_site_name']])
                ->setTo($this->sendTo)
                ->setSubject($this->subject.' - ' . Yii::$app->params['config_site_name'])
                ->send();
        } catch (\Exception $e) {
            return false;
        }

        /*
        $mail= Yii::$app->mailer->compose($this->template, $this->data);
        $mail->setTo($this->sendTo);
        $mail->setSubject($this->subject.'-'.Yii::$app->name);
        if($mail->send()) {
            //成功
        } else {
            //失败
        }
        */
    }
}



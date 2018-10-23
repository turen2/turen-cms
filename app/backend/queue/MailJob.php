<?php

namespace backend\queue;//队列全局调用，这里必须使用全局空间

use Yii;

/**
 * Class MailJob.
 */
class MailJob extends \yii\base\Object implements \yii\queue\RetryableJob
{
    public $template = '';//string
    
    public $data = [];//array
    
    public $sendTo = '';//一次只发一个，方便监控
    
    public $subject= '';//string
    
    /**
     * @inheritdoc
     */
    public function execute($queue)
    {
        //邮件发送
        $mail= Yii::$app->mailer->compose($this->template, $this->data);
        $mail->setTo($this->sendTo);
        $mail->setSubject($this->subject.'-'.Yii::$app->name);
        if($mail->send()) {
            //成功
        } else {
            //失败
        }
    }

    /**
     * 延迟时间
     * @inheritdoc
     */
    public function getTtr()
    {
        return 10;
    }

    /**
     * 重试次数
     * @inheritdoc
     */
    public function canRetry($attempt, $error)
    {
        return $attempt < 4;//一共可尝试三次
    }
}



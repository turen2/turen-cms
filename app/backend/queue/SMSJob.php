<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace app\queue;

/**
 * Class SMSJob.
 */
class SMSJob extends \yii\base\Object implements \zhuravljov\yii\queue\Job
{
    public $title;

    public $content;

    public $mobile;

    /**
     * @inheritdoc
     */
    public function execute($queue)
    {
        //业务逻辑
    }
}



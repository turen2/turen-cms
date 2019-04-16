<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace console\queue;

use yii\base\BaseObject;

/**
 * Class AlismsJob.
 */
class AlismsJob extends BaseObject implements \yii\queue\JobInterface
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



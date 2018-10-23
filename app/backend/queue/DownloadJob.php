<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace app\queue;

use yii\base\Object;

class DownloadJob extends Object implements \zhuravljov\yii\queue\Job
{
    public $url;
    public $file;
    
    //execute
    public function execute($queue)
    {
        file_put_contents($this->file.basename($this->url), file_get_contents($this->url));
    }
}
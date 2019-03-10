<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace app\modules\account;

use Yii;

/**
 * account module definition class
 */
class Module extends \yii\base\Module
{
    public $layout = '/main';

    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\account\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();


        // custom initialization code goes here
    }

}

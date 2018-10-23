<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace app\modules\site;

/**
 * site module definition class
 */
class Module extends \app\components\Module
{
    /**
     * @inheritdoc
     */
    //默认命名空间和路由在main配置文件中已经配置过了，这里也可以覆盖
    //public $controllerNamespace = 'app\modules\shop\controllers';
    //public $defaultRoute = 'home';
    
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
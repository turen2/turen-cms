<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace backend\modules\sys;

/**
 * sys module definition class
 */
class Module extends \backend\components\Module
{
    /**
     * @inheritdoc
     */
    //默认命名空间和路由在main配置文件中已经配置过了，这里也可以覆盖
    //public $controllerNamespace = 'backend\modules\site\controllers';
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
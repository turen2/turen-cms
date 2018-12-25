<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace app\modules\web;

use Yii;

/**
 * web module definition class
 */
class Module extends \yii\base\Module
{
    public $defaultRoute = 'site/home';
    
    public $layout = 'main';
    
    public $controllerNamespace = 'app\\modules\\web\\controllers';

}

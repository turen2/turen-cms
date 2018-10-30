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
    /**
     * @inheritdoc
     */
    //public $defaultRoute = 'web/site/home';
    
    /**
     * @inheritdoc
     */
    //public $controllerNamespace = 'app\modules\web\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        
        //当前为web模板
        Yii::$app->errorHandler->errorAction = 'web/site/error';
        // custom initialization code goes here
    }
}

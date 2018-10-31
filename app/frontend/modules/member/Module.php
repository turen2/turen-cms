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
    
//     public $controllerNamespace = 'app\\modules\\web\\controllers';
//     public $viewPath = '@app/themes/classic/web/views';
//     public $layoutPath = '@app/themes/classic/web/layouts';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        //模板切换
        $this->setViewPath('@app/themes/'.GLOBAL_TEMPLATE_CODE.'/web/views');
        $this->setLayoutPath('@app/themes/'.GLOBAL_TEMPLATE_CODE.'/web/layouts');
        
        //特殊处理widget模板
        Yii::$app->view->theme->setBasePath('@app/themes/'.GLOBAL_TEMPLATE_CODE);
        Yii::$app->view->theme->setBaseUrl('@app/themes/'.GLOBAL_TEMPLATE_CODE);
        
        Yii::$app->view->theme->pathMap = [
            '@app/modules/web/widgets' => '@app/themes/'.GLOBAL_TEMPLATE_CODE.'/web/widgets',
        ];

        //当前为web模板
        Yii::$app->errorHandler->errorAction = 'web/site/error';
        // custom initialization code goes here
    }
}

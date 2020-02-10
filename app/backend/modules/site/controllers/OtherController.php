<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace backend\modules\site\controllers;

use yii\web\ErrorAction;
//use yii\helpers\VarDumper;

class OtherController extends \backend\components\Controller
{
    public function actions()
    {
        //$handler = Yii::$app->errorHandler;
        //VarDumper::dump($handler, 10, true);
        
        return [
            'error' => [
                //此提醒是面向用户的：
                //非debug或者是用户异常时有效，以正常的路由执行来显示错误【用户异常即http请求过程中与用户操作相关的所有http异常】
                'class' => ErrorAction::class,
                'layout' => '/error-main',
                'view' => 'user_error',//不论什么类型的异常，使用统一的显示界面，为的是界面友好
                
                'defaultName' => '未知异常',
                'defaultMessage' => '请联系管理员或开发者及时修复。',
            ],
        ];
    }
    
    //维护模式
    public function actionOffline()
    {
        return $this->render('offline');
    }
}
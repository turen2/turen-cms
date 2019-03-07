<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
//站点通用控制器
namespace app\controllers;

use Yii;
use app\components\Controller;
use app\widgets\phonecode\PhoneCodePopAction;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        $params = Yii::$app->getRequest()->queryParams;
        return [
            //错误界面
            'error' => [
                'class' => 'yii\web\ErrorAction',
                'layout' => '/main-banjia',
                'view' => 'error',
            ],
            //获取手机验证码
            'phone-code' => [
                'class' => PhoneCodePopAction::class,
                'phone' => $params['phone'],
                'maxNum' => 6,
            ],
        ];
    }
}

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
use common\helpers\Util;

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
        $phone = Yii::$app->getRequest()->get('phone');
        return [
            //错误界面
            'error' => [
                'class' => 'yii\web\ErrorAction',
                'layout' => 'main',
                'view' => 'error',
            ],
            //获取手机验证码//问答验证
            'phone-code' => [
                'class' => PhoneCodePopAction::class,
                'phone' => $phone,
                'maxNum' => 6,
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'width' => 100,
                'height' => 42,
                'padding' => 4,
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
                'minLength' => 4,
                'maxLength' => 4,
                'transparent' => true,
                'backColor' => 0xFFFFFF,
                'foreColor' => 0xFF6F20,
                'fontFile' => '@app/web/fonts/WishfulWaves.ttf',
            ],
        ];
    }

     public function actionIpAddress()
     {
         $this->asJson([
             'state' => true,
             'msg' => Util::IPAddess(),
         ]);
     }
}

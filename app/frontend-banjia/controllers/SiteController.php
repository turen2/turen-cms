<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
//站点通用控制器
namespace app\controllers;

use common\helpers\Util;
use common\models\com\VerifyConsult;
use Yii;
use app\components\Controller;
use app\widgets\phonecode\PhoneCodePopAction;
use yii\web\Response;
use yii\widgets\ActiveForm;

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
                'class' => 'yii\captcha\PhoneCodeAction',
                'width' => 100,
                'height' => 42,
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

    /**
     * 全局手机验证码
     */
    /*
     public function actionPhoneVerifyCode()
     {
         $model = new VerifyConsult();
         if ($model->load(Yii::$app->request->post()) && $model->validate()) {

             //验证成功，录入数据到咨询订单系统

             return $this->asJson([
                 'state' => true,
                 'code' => '200',
                 'result' => '',
             ]);
         } else {
             if($model->hasErrors()) {
                 Yii::$app->response->format = Response::FORMAT_JSON;
                 return ActiveForm::validate($model);
             }

             return $this->renderAjax('_phone_verify', [
                 'model' => $model,
             ]);
         }
     }
    */
}

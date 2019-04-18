<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace app\controllers;

use console\queue\AlismsJob;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use common\helpers\Util;
use common\models\user\Inquiry;
use console\queue\SmtpMailJob;
use app\components\Controller;

/**
 * Home controller for the `banjia` module
 */
class HomeController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'call-price' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Renders the default view for the module
     * @return string
     */
    public function actionDefault()
    {
        //echo Yii::$app->getViewPath();exit;

        //var_dump(Yii::$app->getView()->theme->pathMap);exit;

        return $this->render('default');
    }

    /**
     * 首页询价
     * @return \yii\web\Response
     */
    public function actionCallPrice()
    {
        $area = Yii::$app->request->post('area');
        $type = Yii::$app->request->post('type');
        $phone = Yii::$app->request->post('phone');

        //录入到系统
        $content = Json::encode([
            '电话' => $phone,
            '位置' => $area,
            '业务类型' => $type,
        ]);

        $address = Util::IPAddess();
        if(!Inquiry::find()->where(['ui_content' => $content])->exists()) {
            $model = new Inquiry();
            $model->ui_title = '从'.$area.'来的'.$type;
            $model->ui_content = $content;
            $model->user_id = Yii::$app->getUser()->getId();
            $model->ui_ipaddress = $address['location'];
            $model->ui_browser = Yii::$app->getRequest()->userAgent;
            $model->ui_type = Inquiry::INQUIRY_TYPE_QUICK;//快捷预约
            $model->ui_state = Inquiry::INQUIRY_STATE_NOTHING;//待处理
            $model->ui_submit_time = time();
            $model->save(false);

            //邮件通知队列
            foreach (explode("\r\n", Yii::$app->params['config_email_notify_online_call_price']) as $sendTo) {
                $sendTo = trim($sendTo);
                if(!empty($sendTo)) {
                    Yii::$app->jialebangMailQueue->push(new SmtpMailJob([
                        'template' => GLOBAL_LANG.'/notify',//语言标识模板名称
                        'params' => [
                            '电话' => $phone,
                            '位置' => $area,
                            '业务类型' => $type,
                        ],
                        'sendTo' => $sendTo,
                        'from' => [Yii::$app->params['config.supportEmail'] => Yii::$app->params['config_site_name']],
                        'subject' => '有新的快捷预约 - ' . Yii::$app->params['config_site_name'],
                    ]));
                }
            }

            //短信通知队列
            //有新预约订单了，用户：${name}，地址：${address}，电话：${phone}，业务：${event}，请及时处理以免造成损失。
            $signTemplate = Yii::$app->params['call_price_notify'];
            foreach (explode("\r\n", Yii::$app->params['config_sms_notify_online_call_price']) as $sendTo) {
                $sendTo = trim($sendTo);
                if(!empty($sendTo)) {
                    Yii::$app->jialebangSmsQueue->push(new AlismsJob([
                        'phoneNumber' => $sendTo,
                        'signName' => $signTemplate['signName'],
                        'templateCode' => $signTemplate['templateCode'],
                        'templateParams' => [
                            'name' => '未知',
                            'address' => $area,
                            'phone' => $phone,
                            'event' => $type,
                        ],
                    ]));
                }
            }
        }

        return $this->asJson([
            'state' => true,
            'msg' => '',
        ]);
    }
}
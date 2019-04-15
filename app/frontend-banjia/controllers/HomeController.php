<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace app\controllers;

use common\helpers\Util;
use common\models\user\Inquiry;
use Yii;
use app\components\Controller;
use yii\filters\VerbFilter;
use yii\helpers\Json;

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
        }

        //通知队列


        return $this->asJson([
            'state' => true,
            'msg' => '',
        ]);
    }
}

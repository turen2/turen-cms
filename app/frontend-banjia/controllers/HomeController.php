<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace app\controllers;

use Yii;
use yii\filters\VerbFilter;
use common\models\user\Inquiry;
use app\components\Controller;
use common\models\shop\Product;

/**
 * Home controller for the `banjia` module
 */
class HomeController extends Controller
{
    const INQUIRY_REQUEST_CACHE_KEY = 'inquiry_request_cache_key';

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
        $productList = Product::find()->active()->orderBy(['orderid' => SORT_DESC])->all();
        return $this->render('default', [
            'productList' => $productList,
        ]);
    }

    /**
     * 首页询价
     * @return \yii\web\Response
     */
    public function actionCallPrice()
    {
        $area = Yii::$app->request->post('area');
        $productId = Yii::$app->request->post('type');//对应的是服务产品
        $phone = Yii::$app->request->post('phone');

        //请求缓存
        $contentMd5 = md5($area.$productId.$phone.Yii::$app->request->getUserIP().Yii::$app->request->getUserAgent());//填写资料+ip+客户端
        $inquiryCache = Yii::$app->cache->get(self::INQUIRY_REQUEST_CACHE_KEY);
        $tt = microtime(true)*1000 - $inquiryCache['t'];
        if($inquiryCache && (($inquiryCache['md5'] == $contentMd5) && ($tt < 7000))) {//毫秒,间隔超过7秒，可以重复提交
            //nothing
        } else {
            $data = [
                'area' => $area,
                'phone' => $phone,
                'productId' => $productId,
            ];
            //创建快捷预约服务单
            Inquiry::CreateInquiryOrder($data, Inquiry::INQUIRY_TYPE_QUICK, true);//创建预约单
        }

        Yii::$app->cache->set(self::INQUIRY_REQUEST_CACHE_KEY, [
            't' => microtime(true)*1000,//访止高频率恶意请求
            'md5' => $contentMd5,//不记录刷新动作
        ]);

        return $this->asJson([
            'state' => true,
            'msg' => $tt,
        ]);
    }
}
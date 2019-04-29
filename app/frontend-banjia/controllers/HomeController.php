<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace app\controllers;

use Yii;
use yii\filters\VerbFilter;
use common\models\account\Inquiry;
use app\components\Controller;
use common\models\shop\Product;
use common\models\com\FeedbackForm;

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
                    'feedback' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * @return array
     */
    public function actions()
    {
        return [
            //生成图片验证码
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'width' => 60,
                'height' => 34,
                'padding' => 2,
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
     * 首页快捷预约
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

    /**
     * 全局问题反馈
     * @return \yii\web\Response
     */
    public function actionFeedback()
    {
        $state = true;
        $msg = '反馈已成功';

        $model = new FeedbackForm();
        if($model->load(Yii::$app->getRequest()->post()) && $model->validate()) {
            //提交内容
            FeedbackForm::SubmitFeedback($model);
        } else {//验证失败
            $state = false;
            $msg = $model->getErrors();
        }

        return $this->asJson([
            'state' => $state,
            'msg' => $msg,
        ]);
    }
}
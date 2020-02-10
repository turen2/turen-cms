<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace app\controllers;

use Yii;
use common\models\account\Inquiry;

class OnlineController extends \app\components\Controller
{
    const INQUIRY_REQUEST_CACHE_KEY = 'inquiry_request_cache_key';

    public function actionPrice()
    {
        if(Yii::$app->getRequest()->isPost) {
            $service = Yii::$app->request->post('service', '来自手机网站');
            $name = Yii::$app->request->post('name');
            $phone = Yii::$app->request->post('phone');

            //请求缓存
            $contentMd5 = md5($service.$name.$phone.Yii::$app->request->getUserIP().Yii::$app->request->getUserAgent());//填写资料+ip+客户端
            $inquiryCache = Yii::$app->cache->get(self::INQUIRY_REQUEST_CACHE_KEY);
            $tt = microtime(true)*1000 - $inquiryCache['t'];
            if($inquiryCache && (($inquiryCache['md5'] == $contentMd5) && ($tt < 7000))) {//毫秒,间隔超过7秒，可以重复提交
                //nothing
            } else {
                $data = [
                    'service' => $service,
                    'name' => $name,
                    'phone' => $phone,
                ];
                //创建快捷预约服务单
                Inquiry::CreateInquiryOrder($data, true);//创建预约单
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

        return $this->render('price');
    }
}

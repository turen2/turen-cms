<?php
/**
 * 银豹订单同步功能
 *//**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace console\controllers;

use Yii;
use yii\helpers\Json;
use yii\httpclient\Client;
use yii\httpclient\CurlTransport;
use common\models\merchant\Merchant;
use console\components\Controller;
use common\models\merchant\OfflineOrder;
use common\models\merchant\OfflineOrderItem;
use common\models\merchant\OfflineOrderDay;
use common\models\merchant\OfflineOrderSync;

class PospalController extends \console\components\Controller
{
    /**
     * sync order by sunsult 银豹订单同步
     * @param string $date 日期 yyyy-mm-dd
     * @param integer $crontab 手动还是自动，true为自动
     * @param integer $userId 
     * @return number 返回的结果，0表示正常
     * 注意：时间间隔不能超过一天24小时，而且每次传递的参数不能跨天
     */
    public function actionSyncOrder($date = '', $crontab = true, $userId = '')
    {
        set_time_limit(0);
        $service = 'pospal-api2/openapi/v1/ticketOpenApi/queryTicketPages';//分页获取订单服务
        
        //默认当天
        $startTime = date('Y-m-d').' 00:00:01';//当天凌晨
        $endTime = date('Y-m-d H:i:s');//当前时间
        //指定同步日期
        if(!empty($date) ) {
            $startTime = $date.' 00:00:01';//凌晨
            $endTime = $date.' 23:59:59';//凌晨
        }
        
        //权益加盟商户和特约商户有门店
        if($userId) {
            $models = Merchant::find()->where(['merchant_type' => [Merchant::MERCHANT_TYPE_2, Merchant::MERCHANT_TYPE_4]])->andWhere(['id' => $userId])->active()->all();
        } else {
            $models = Merchant::find()->where(['merchant_type' => [Merchant::MERCHANT_TYPE_2, Merchant::MERCHANT_TYPE_4]])->active()->all();
        }
        
        //支付方式
        $wxpays = Yii::$app->params['online_payments']['wxpay'];
        $alipays = Yii::$app->params['online_payments']['alipay'];
        $cashs = Yii::$app->params['online_payments']['cash'];//现金
        $yues = Yii::$app->params['online_payments']['yue'];//会员余额，即储值卡
        $banks = Yii::$app->params['online_payments']['bank'];//银行刷卡【不全】
        
        foreach ($models as $model) {//遍历商户
            if(!empty($model->merchantStore)) {//有门店
                foreach ($model->merchantStore as $key => $merchantStore) {//遍历门店
                    if($merchantStore->status && !empty($merchantStore->app_url) && !empty($merchantStore->app_id) && !empty($merchantStore->app_key)) {//显示状态
                        
                        //echo $merchantStore->id."\n";
                        //continue;
                        
                        $url = $merchantStore->app_url.$service;
                        $appKey = trim($merchantStore->app_key);
                        $appId = trim($merchantStore->app_id);
                        
                        $queryNextPage = true;
                        $postBackParameter = null;
                        do {
                            //请求体
                            $jsonData = Json::encode([
                                'appId' => $appId,
                                'startTime' => $startTime,
                                'endTime' => $endTime,
                                'postBackParameter' => $postBackParameter,//第一次进来是null
                            ]);
                            $signature = strtoupper(md5($appKey.$jsonData));
                            $time = time();
                            $readSyncStartTime = microtime(true);
                            $response = $this->httpsRequest($url, $jsonData, $signature, $time);
                            $readSyncTime = number_format((microtime(true) - $readSyncStartTime) * 1000 + 1);//单位ms
                            
                            //响应验证
                            $header = $response->getHeaders();
                            $content = $response->getContent();
                            if($header->get('data-signature') == strtoupper(md5($appKey.$content))) {
                                $result = Json::decode($content);
                                if(strtolower($result['status']) == 'success') {
                                    //创建当天日结记录
                                    $day = date('Y-m-d', strtotime($startTime));
                                    $offlineOrderDayModel = OfflineOrderDay::findOne(['day' => $day, 'merchant_store_id' => $merchantStore->id]);
                                    if(empty($offlineOrderDayModel)) {
                                        $offlineOrderDayModel = new OfflineOrderDay();
                                        $offlineOrderDayModel->name = date('Y年m月d日', strtotime($startTime)).' 同步订单';//.($crontab?'(定时同步)':'(手动同步)');
                                        $offlineOrderDayModel->day = $day;
                                        $offlineOrderDayModel->merchant_id = $model->id;
                                        $offlineOrderDayModel->merchant_store_id = $merchantStore->id;
                                        $offlineOrderDayModel->save(false);
                                    }
                                    
                                    //创建同步记录
                                    $offlineOrderSyncModel = new OfflineOrderSync();
                                    $offlineOrderSyncModel->name = '';
                                    $offlineOrderSyncModel->start_time = strtotime($startTime);
                                    $offlineOrderSyncModel->end_time = strtotime($endTime);
                                    $offlineOrderSyncModel->offline_order_day_id = $offlineOrderDayModel->id;
                                    $offlineOrderSyncModel->save(false);
                                    $offlineOrderSyncModel->name = ($crontab?'定时同步':'手动同步').'，第'.$offlineOrderSyncModel->id.'期';
                                    $offlineOrderSyncModel->save(false);
                                    
                                    //批量高效导入
                                    $orderModel = new OfflineOrder;//收银单
                                    $orderItemModel = new OfflineOrderItem;//订单项目详情
                                    foreach($result['data']['result'] as $order)
                                    {
                                        if(OfflineOrder::find()->where(['sn' => $order['sn'], 'merchant_id' => $model->id])->exists()) {
                                            continue;//已经存在就不新增
                                        }
                                        $_orderModel = clone $orderModel;
                                        $attributes['sn'] = $order['sn'];
                                        $attributes['cashierUid'] = number_format($order['cashierUid'], 0, '', '');
                                        $attributes['customerUid'] = number_format($order['customerUid'], 0, '', '');
                                        $attributes['totalProfit'] = $order['totalProfit'];
                                        $attributes['totalAmount'] = $order['totalAmount'];
                                        $attributes['rounding'] = $order['rounding'];
                                        $attributes['ticketType'] = $order['ticketType'];
                                        $attributes['invalid'] = $order['invalid'];
                                        $attributes['discount'] = $order['discount'];
                                        $attributes['add_time'] = strtotime($order['datetime']);//转化为时间戳
                                        $attributes['payments'] = $order['payments'];//直接上数组
                                        
                                        //支付转换
                                        $wxpayTotal = 0;
                                        $alipayTotal = 0;
                                        $cashTotal = 0;
                                        $yueTotal = 0;
                                        $bankTotal = 0;
                                        $otherpayTotal = 0;
                                        foreach ($order['payments'] as $payment) {
                                            if(in_array($payment['code'], $wxpays)) {
                                                $wxpayTotal += $payment['amount'];
                                            } elseif(in_array($payment['code'], $alipays)) {
                                                $alipayTotal += $payment['amount'];
                                            } elseif(in_array($payment['code'], $cashs)) {
                                                $cashTotal += $payment['amount'];
                                            } elseif(in_array($payment['code'], $yues)) {
                                                $yueTotal += $payment['amount'];
                                            } elseif(in_array($payment['code'], $banks)) {
                                                $bankTotal += $payment['amount'];
                                            } else {
                                                $otherpayTotal += $payment['amount'];
                                            }
                                        }
                                        
                                        $attributes['wxpay'] = $wxpayTotal;
                                        $attributes['alipay'] = $alipayTotal;
                                        $attributes['cash'] = $cashTotal;
                                        $attributes['yue'] = $yueTotal;
                                        $attributes['bank'] = $bankTotal;
                                        $attributes['otherpay'] = $otherpayTotal;
                                        
                                        $attributes['order_note'] = $crontab?'自动':'手动';
                                        $attributes['merchant_id'] = $model->id;
                                        $attributes['merchant_store_id'] = $merchantStore->id;
                                        $attributes['request_time'] = $readSyncTime;//请求时间，ms
                                        $attributes['offline_order_day_id'] = $offlineOrderSyncModel->offline_order_day_id;
                                        $attributes['offline_order_sync_id'] = $offlineOrderSyncModel->id;
                                        $_orderModel->setAttributes($attributes);
                                        $_orderModel->save(false);
                                        
                                        foreach ($order['items'] as $item) {
                                            $_orderItemModel = clone $orderItemModel;
                                            $attributes['offline_order_id'] = $_orderModel->id;//收银订单id
                                            $attributes['name'] = $item['name'];
                                            $attributes['buyPrice'] = $item['buyPrice'];
                                            $attributes['sellPrice'] = $item['sellPrice'];
                                            $attributes['customerPrice'] = $item['customerPrice'];
                                            $attributes['quantity'] = $item['quantity'];
                                            $attributes['discount'] = $item['discount'];
                                            $attributes['customerDiscount'] = $item['customerDiscount'];
                                            $attributes['totalAmount'] = $item['totalAmount'];
                                            $attributes['totalProfit'] = $item['totalProfit'];
                                            $attributes['isCustomerDiscount'] = $item['isCustomerDiscount'];
                                            $attributes['productUid'] = number_format($item['productUid'], 0, '', '');
                                            $attributes['ticketitemattributes'] = $item['ticketitemattributes'];//直接上数组
                                            $_orderItemModel->setAttributes($attributes);
                                            $_orderItemModel->save(false);
                                        }
                                    }
                                    
                                    
                                    //是否进行下一页查询。
                                    $postBackParameter = $result['data']['postBackParameter'];
                                    $wantQuerySize = $result['data']['pageSize'];
                                    $realQuerySize = count($result['data']['result']);
                                    if($realQuerySize < $wantQuerySize) {
                                        $queryNextPage = false;
                                    }
                                } elseif(strtolower($result['status']) == 'error') {
                                    //请求错误，写入日志
                                    //@runtime/logs/app.log
                                    $msg = implode(',', $result['messages']).self::getPospalError($result['errorCode']);
                                    Yii::error($msg, Controller::CONSOLE_LOG);
                                    break;
                                }
                            } else {
                                //非法请求
                                Yii::error('银豹非法请求，请检查。', Controller::CONSOLE_LOG);
                                break;
                            }
                        } while ($queryNextPage);
                    } else {
                        //nothing
                    }
                }
            } else {
                //nothing
            }
        }
        
        return 0;//执行完成，返回0
    }
    
    /**
     * 
     * @param string $url
     * @param string $jsonData
     * @param string $signature
     * @param integer $time
     * @return \yii\httpclient\Response
     */
    protected function httpsRequest($url, $jsonData, $signature, $time)
    {
        $client = new Client();
        $client->setTransport(CurlTransport::className());//curl
        
        $request = $client->createRequest();
        $request->setOptions([
            'sslVerifyPeer' => false,
        ])->setMethod('post')->setUrl($url)->setHeaders([
            'User-Agent' => 'openApi',
            'Content-Type' => 'application/json; charset=utf-8',
            'accept-encoding' => 'gzip,deflate',
            'time-stamp' => $time,
            'data-signature' => $signature
        ])->setContent($jsonData);
        
        return $request->send();
    }
    
    /**
     * 银豹系统错误
     * @param integer $code
     * @return string
     */
    protected static function getPospalError($code)
    {
        $errors = [
            '0' => '未知错误',
            
            '1001' => '收银员不存在',
            '1002' => '收银员工号与密码不匹配',
            
            '1011' => '用户名或密码错误',
            '1012' => '请输入用户名、密码',
            '1013' => '该用户不存在',
            '1014' => '该账号已存在',
            '1015' => '账号不能为空',
            '1016' => '账号长度不得小于6位',
            '1017' => '账号长度不得大于32位',
            '1018' => '账号包含无效字符，应为数字、字母、下划线、或@组成',
            
            '1021' => '密码不正确',
            '1022' => '密码不能为空',
            '1023' => '密码长度不得小于6位',
            '1024' => '密码长度不得大于32位',
            '1025' => '密码包含无效字符',
            
            '1031' => '请求头中没传消息签名',
            '1032' => '消息体与消息签名不匹配',
            '1033' => '校验消息签名时出错',
            '1034' => 'appId错误，根据所传的appId找不到对应的用户',
            
            '1091' => '邮箱不能为空',
            '1092' => '邮箱格式不正确',
            '1093' => '该邮箱已存在',
            '1094' => '联系电话不能为空',
            '1095' => '公司名称不能为空',
            '1096' => '联系地址不能为空',
            '1097' => '联系地址格式不正确',
            '1098' => '注册用户失败',
            
            '2001' => '次卡剩余次数不足',
            '2002' => '次卡不存在',
            '2011' => '添加会员信息失败',
            '2012' => '会员已存，不允许重复添加',
            '2013' => '修改会员信息失败',
            '2015' => '会员不存在',
            '2016' => '没有权限修改会员',
            
            '3001' => '优惠券无效',
            '3002' => '优惠券已停用',
            '3003' => '优惠券号不足',
            '3004' => '优惠券号已经存在',
            
            '4001' => '您尚未开通我的店铺，可前往官网（pospal.cn）开通使用',
            '4002' => '我的店铺已过期，可前往官网（pospal.cn）续费使用',
            
            '9001' => '只能在规则时间内使用',
            '9002' => '抱歉，您当前使用的收银软件版本太低，请下载安装最新版本，再登录您的账号继续使用',
            
            '9003' => '请求参数错误',
            '9004' => '您所使用的版本太旧，请更升级到最新版本',
        ];
        
        $msg = '';
        if(isset($errors[$code])) {
            $msg = $errors[$code];
        }
        return $msg;
    }
    
    protected function httpsRequest2($url, $data, $signature)
    {
        $time = time();
        $curl = curl_init();// 启动一个CURL会话
        // 设置HTTP头
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            "User-Agent: openApi",
            "Content-Type: application/json; charset=utf-8",
            "accept-encoding: gzip,deflate",
            "time-stamp: ".$time,
            "data-signature: ".$signature
        ));
        curl_setopt($curl, CURLOPT_URL, $url);         // 要访问的地址
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2); // 从证书中检查SSL加密算法是否存在
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);		// Post提交的数据包
        //curl_setopt($curl, CURLOPT_PROXY,'127.0.0.1:8888');//设置代理服务器,此处用的是fiddler，可以抓包分析发送与接收的数据
        curl_setopt($curl, CURLOPT_POST, 1);		// 发送一个常规的Post请求
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);// 获取的信息以文件流的形式返回
        
        $output = curl_exec($curl); // 执行操作
        if (curl_errno($curl)) {
            echo 'Errno'.curl_error($curl);//捕抓异常
        }
        
        curl_close($curl); // 隐藏CURL会话
        
        return $output; // 返回数据
    }
    
//     public function options($actionID)
//     {
        
//     }
    
//     public function optionAliases()
//     {
        
//     }
}

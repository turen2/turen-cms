<?php
/**
 * 银豹订单同步功能
 *//**
 * @link http://www.juwanfang.com/
 * @copyright Copyright (c) 聚万方CMS
 * @author developer qq:980522557
 */
namespace console\controllers;

use Yii;
use console\components\Controller;
use common\models\merchant\OfflineOrder;

class ModifyController extends \console\components\Controller
{
    public function actionTestOrderError()
    {
        set_time_limit(0);
        
        $models = OfflineOrder::find()->all();
        foreach ($models as $model) {
            $total = $model['alipay'] + $model['wxpay'] + $model['bank'] + $model['yue'] + $model['cash'] + $model['otherpay'];
            if(number_format($model['totalAmount'], 2) != number_format($total, 2) || $model['otherpay']) {
                //echo number_format($model['totalAmount'], 2).' '.number_format($total, 2)."\r\n";
                echo 'error:store_id为'.$model['merchant_store_id'].' '.$model['totalAmount'].' != '.$model['alipay'].' + '.$model['wxpay'].' + '.$model['bank'].' + '.$model['yue'].' + '.$model['cash'].' + '.$model['otherpay']."\r\n";
            }
        }
    }
    
    public function actionUpdateOfflineOrder()
    {
        set_time_limit(0);
        
        //支付方式
        $wxpays = Yii::$app->params['online_payments']['wxpay'];
        $alipays = Yii::$app->params['online_payments']['alipay'];
        $cashs = Yii::$app->params['online_payments']['cash'];//现金
        $yues = Yii::$app->params['online_payments']['yue'];//会员余额，即储值卡
        $banks = Yii::$app->params['online_payments']['bank'];//银行刷卡【不全】
        
        $models = OfflineOrder::find()->all();
        
        foreach ($models as $order) {
            $attributes = [];
            $payments = $order['payments'];//直接上数组
            
            if($payments) {
                //支付转换
                $total = 0;
                $attributes['otherpay'] = 0;//其它支付先赋值为0
                foreach ($payments as $payment) {
                    if(in_array($payment['code'], $wxpays)) {
//                         if(!isset($attributes['wxpay'])) {
//                             $attributes['wxpay'] = 0;
//                         }
//                         $attributes['wxpay'] += $payment['amount'];
                        $total += $payment['amount'];
                    } elseif(in_array($payment['code'], $alipays)) {
//                         if(!isset($attributes['alipay'])) {
//                             $attributes['alipay'] = 0;
//                         }
//                         $attributes['alipay'] += $payment['amount'];
                        $total += $payment['amount'];
                    } elseif(in_array($payment['code'], $cashs)) {
                        if(!isset($attributes['cash'])) {
                            $attributes['cash'] = 0;
                        }
                        $attributes['cash'] += $payment['amount'];
                        $total += $payment['amount'];
                    } elseif(in_array($payment['code'], $yues)) {
                        if(!isset($attributes['yue'])) {
                            $attributes['yue'] = 0;
                        }
                        $attributes['yue'] += $payment['amount'];
                        $total += $payment['amount'];
                    } elseif(in_array($payment['code'], $banks)) {
                        if(!isset($attributes['bank'])) {
                            $attributes['bank'] = 0;
                        }
                        $attributes['bank'] += $payment['amount'];
                        $total += $payment['amount'];
                    } else {
                        if(!isset($attributes['otherpay'])) {
                            $attributes['otherpay'] = 0;
                        }
                        $attributes['otherpay'] += $payment['amount'];
                        $total += $payment['amount'];
                    }
                }
                
                if(number_format($order['totalAmount'], 2) != number_format($total, 2)) {
                    echo 'error:'.$order['id'].' '.$order['totalAmount'].' != '.$total."\r\n";
                } else {
                    
                    //if($attributes['otherpay'])
                    //print_r($attributes);
//                     if(OfflineOrder::updateAll($attributes, 'id='.$order->id)) {
//                         echo 'success'."\r\n";
//                     }
                }
            }
        }
    }
}


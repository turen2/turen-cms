<?php
/**
 * 库存同步功能
 *//**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace console\controllers;

use Yii;
use common\models\catalog\Product;
use yii\db\Query;
use common\models\tools\StockSyncCycle;
use common\models\tools\StockSyncLog;
use yii\helpers\ArrayHelper;

class StockController extends \console\components\Controller
{
    protected $notStock = [];
    
    //初始化获取忽略的编码
    public function init()
    {
        parent::init();
        
        //物料忽略
        ArrayHelper::merge($this->notStock, [
            'WL.WL5009',
            'WL.WL7001',
            'WL.WL6014',
            'WL.WL7003',
            'WL.WL6007',
            'WL.WL5005',
            'WL.WL6013',
            'WL.WL6008',
            'WL.WL6002',
            'WL.WL6009',
            'WL.WL1008',
            'WL.WL1004',
            'WL.WL6004',
            'WL.WL6003',
            'WL.WL6012',
            'WL.WL7002',
            'WL.WL6011',
            'WL.WL6010'
        ]);
        
        //错误资料忽略
        ArrayHelper::merge($this->notStock, [
            
        ]);
        
        //特殊商品忽略
        ArrayHelper::merge($this->notStock, [
            
        ]);
    }
    
    /**
     * sync stock by sunsult 同步库存
     */
    public function actionSync($crontab = true)
    {
        set_time_limit (0);
        $redis = Yii::$app->redis;
        
        //先急速获取，尽量减少冲突，匹配所有key
        $data = [];
        $readStockStartTime = microtime(true);
        foreach ($redis->keys('*') as $key) {
            if(!empty($key)) {
                $data[trim($key)] = $redis->get($key)*1;//前者key去空格，后者key不能去
            }
        }
        $readStockTime = number_format((microtime(true) - $readStockStartTime) * 1000 + 1);//单位ms
        
        //入库并记录日志
        $query = (new Query())->select('*')->from('s_product');
        $keys = array_keys($data);
        $transaction = Yii::$app->getDb()->beginTransaction();
        try {
            $stockSyncCycleModel = new StockSyncCycle();
            $stockSyncCycleModel->name = '';//
            if($stockSyncCycleModel->save(false)) {
                $stockSyncCycleModel->name = ($crontab?'定时同步':'手动同步').'，第'.$stockSyncCycleModel->id.'期';
                $stockSyncCycleModel->save(false);
                
                $notKeys = [];
                foreach ($keys as $key) {
                    $productModel = Product::findOne(['product_code' => $key]);
                    if($productModel) {
                        if($productModel->status != Product::STATUS_FORBID && !in_array($productModel->product_code, $this->notStock)) {
                            $stock = $data[$productModel->product_code];
                            
                            $stockSyncLogModel = new StockSyncLog();
                            $stockSyncLogModel->sync_before = $productModel->stock;//原库存值
                            $stockSyncLogModel->sync_after = $stock;//现库存值
                            $stockSyncLogModel->maybe_result = '同步成功';
                            $stockSyncLogModel->product_name = $productModel->name;
                            $stockSyncLogModel->sku = $productModel->sku;
                            $stockSyncLogModel->product_code = $productModel->product_code;
                            $stockSyncLogModel->stock_sync_cycle_id = $stockSyncCycleModel->id;//周期
                            $stockSyncLogModel->save(false);
                            
                            /**********附加功能*********/
                            //商品在k3中有
                            $pData = [];
                            //库存
                            $pData['stock'] = $stock;
                            //上下架【无库存，不需要自动下架，可以是售磬】
                            //$pData['status'] = ($stock > 0)?1:0;
                            
                            $approvalStatus = null;//保持原状
                            
                            //编辑状态，位置越往下，越优先
                            if(empty($productModel->brand_id)) {//品牌
                                $approvalStatus = Product::APPROVAL_STATUS_6;
                            }
                            if(empty($productModel->sku)) {//SKU
                                $approvalStatus = Product::APPROVAL_STATUS_10;
                            }
                            if(strlen($productModel->description) < 80) {//详情
                                $approvalStatus = Product::APPROVAL_STATUS_5;
                            }
                            if(empty($productModel->picarr)) {//主图
                                $approvalStatus = Product::APPROVAL_STATUS_4;
                            }
                            if(empty($productModel->ship_id)) {//配送
                                $approvalStatus = Product::APPROVAL_STATUS_8;
                            }
                            if(empty($productModel->weight)) {//重量
                                $approvalStatus = Product::APPROVAL_STATUS_7;
                            }
                            if(empty($productModel->market_price)) {//标准零售价
                                $approvalStatus = Product::APPROVAL_STATUS_9;
                            }
                            
                            //数据错了，强制下架【！！】
                            if(!is_null($approvalStatus)) {
                                $pData['status'] = in_array($approvalStatus, [
                                    Product::APPROVAL_STATUS_9,//无零售价
                                    Product::APPROVAL_STATUS_7,//无重量
                                    Product::APPROVAL_STATUS_8,//无配送
                                    Product::APPROVAL_STATUS_4,//无主图
                                ])?0:1;
                            } else {
                                //数据对了，保持原状即可
                                if(in_array($productModel->approval_status, [
                                    Product::APPROVAL_STATUS_1,
                                    Product::APPROVAL_STATUS_2,
                                    Product::APPROVAL_STATUS_3
                                ])) {
                                    $approvalStatus = $productModel->approval_status;
                                } else {//编辑之后数据对了，但是状态还是问题状态，此时进入审核
                                    $approvalStatus = Product::APPROVAL_STATUS_2;
                                }
                            }
                            
                            $pData['approval_status'] = $approvalStatus;
                            
                            //打日志
//                             if(in_array($productModel->product_code, ['MH.1005', 'FB.5522', 'AA.1001'])) {
//                                 Yii::warning($productModel->attributes, 'sotock_log');
//                             }
                            
                            if(!empty($pData)) {
                                //没有失败的几率
                                Product::updateAll($pData, ['id' => $productModel->id]);
                            }
                        } else {
                            //nothing如果禁用，则不用什么！！！
                        }
                    } else {
                        //k3库存有，管理中心没有
                        //没有同步数据过来
                        //追加到一个缓存中
                        $notKeys[] = $key;
                    }
                }
                
                //追加到缓存中
                Yii::$app->cache->set(Product::CACHE_KEY_NOT_STOCK, $notKeys);//注意：此缓存同时要在多个应用中共用
            }
            
            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
        
        //var_dump(Yii::$app->cache->get(Product::CACHE_KEY_NOT_STOCK));
        
        //echo $readStockTime.'ms';
        
        return 0;//执行完成，返回0
    }
    
//     public function options($actionID)
//     {
        
//     }
    
//     public function optionAliases()
//     {
        
//     }
}

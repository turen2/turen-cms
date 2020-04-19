<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace backend\modules\site\controllers;

use Yii;
use yii\db\Query;
use backend\models\sys\Log;
use backend\models\site\Lnk;

class HomeController extends \backend\components\Controller
{
    public function init()
    {
        parent::init();
        
        //nothing
    }
    
    /**
     * 平时测试用的
     */
    public function actionTest()
    {
        //单条短信
        //Yii::$app->sms->sendSms('13725514524', '豹品淘', 'SMS_91980004', ['code' => '1234']);
        
        //多条短信
        //Yii::$app->sms->sendBatchSms(['13725514524', '18589080024'], ['豹品淘', '豹品淘'], [['code' => '1234'], ['code' => '4321']], 'SMS_91980004');
        
        //消息接口查阅短信状态报告返回结果
//         Yii::$app->msg->receiveMsg('SmsReport', 'Alicom-Queue-1918237367517277-SmsReport', function($message) {
//             print_r($message);
//             return false;
//         });
        
        //消息接口查阅短信服务上行返回结果
//         Yii::$app->msg->receiveMsg('SmsUp', 'Alicom-Queue-1918237367517277-SmsUp', function($message) {
//             print_r($message);
//             return false;
//         });
    }
    
    // iframe大框架
    public function actionIndex()
    {
        Yii::$app->layout = 'iframe-main';//当前模块使用指定布局

        return $this->render('index');
    }
    
    // 默认主内容
    public function actionDefault()
    {
        $lnkModels = Lnk::find()->orderBy('orderid DESC')->all();//快捷方式
        $logModels = Log::find()->orderBy('created_at DESC')->limit(3)->all();//操作日志
        
        return $this->render('default', [
            'lnkModels' => $lnkModels,
            'logModels' => $logModels,
        ]);
    }
    
    /*** ajax初始化 ***/
    public function actionMail()
    {
        return [
            'state' => false,
            'msg' => ''
        ];
        
        $channel = 'queue_mail_channel';
        
        //Yii::$app->queue->tableName//队列表
        
        // pushed_at 加入队列
        // reserved_at 发送中，保留
        // attempt 发送的次数（如果超过次数，同样会done），暂时就大于1即为失败!
        // done_at 完成时间
        
        //等待发送
        $c1 = (new Query())
            ->from(Yii::$app->queue->tableName)
            ->andWhere(['channel' => $channel, 'reserved_at' => null, 'attempt' => null, 'done_at' => null])->count('id', Yii::$app->db);
        
        //正在发送（保留）
        $c2 = (new Query())
            ->from(Yii::$app->queue->tableName)
            ->andWhere(['channel' => $channel, 'reserved_at' => null])
            ->andWhere(['not' ,['done_at' => null]])->count('id', Yii::$app->db);
        
        //已经发送，暂时定为发送一次成功
        $c3 = (new Query())
            ->from(Yii::$app->queue->tableName)
            ->andWhere(['channel' => $channel, 'attempt' => 1])
            ->andWhere(['not' ,['reserved_at' => null, 'done_at' => null]])->count('id', Yii::$app->db);
        
        //已经发送，暂时定为发送一次成功
        $c4 = (new Query())
            ->from(Yii::$app->queue->tableName)
            ->andWhere(['channel' => $channel])->andWhere(['>', 'attempt', 1])
            ->andWhere(['not' ,['reserved_at' => null, 'done_at' => null]])->count('id', Yii::$app->db);
        
        return $this->asJson([
            'state' => true,
            'msg' => [
                ['value' => $c1, 'name' => '等待发送'],
                ['value' => $c2, 'name' => '正在发送'],
                ['value' => $c3, 'name' => '已经发送'],
                ['value' => $c4, 'name' => '邮件滞留']
            ]
        ]);
    }
}

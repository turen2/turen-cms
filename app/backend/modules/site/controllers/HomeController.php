<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace app\modules\site\controllers;

use Yii;
use yii\web\Response;
use yii\db\Query;
use app\models\sys\Log;
use app\models\sys\Devlog;
use app\models\site\Lnk;
use app\models\site\Help;

class HomeController extends \app\components\Controller
{
    public function init()
    {
        parent::init();
        
        //nothing
    }
    
    // iframe大框架
    public function actionIndex()
    {
        Yii::$app->layout = 'iframe-main';//当前模块使用指定布局
        
        return $this->render('index');
    }
    
    // 左侧主菜单
    public function actionMenu()
    {
        $identify = '';//不同身份不同菜单
        
        Yii::$app->layout = 'menu-main';//使用单独的菜单布局
        
        return $this->render('menu', ['identify' => $identify]);
    }
    
    // 默认主内容
    public function actionDefault()
    {
        $lnkModels = Lnk::find()->orderBy('orderid DESC')->all();//快捷方式
        $logModels = Log::find()->orderBy('created_at DESC')->limit(3)->all();//操作日志
        $devLogModels = Devlog::find()->orderBy('created_at DESC')->limit(5)->all();//更新日志
        $helpModels = Help::find()->orderBy('created_at DESC')->limit(5)->all();//更新日志
        
        return $this->render('default', [
            'lnkModels' => $lnkModels,
            'logModels' => $logModels,
            'devLogModels' => $devLogModels,
            'helpModels' => $helpModels,
        ]);
    }
    
    
    
    
    
    
    
    
    
    
    /*** ajax初始化 ***/
    public function actionMail()
    {
        return [
            'state' => false,
            'msg' => ''
        ];
        
        Yii::$app->getResponse()->format = Response::FORMAT_JSON;
        
        $channel = 'merchant_channel';//商户通道
        
        //Yii::$app->queue->tableName//商户队列表
        
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
        
        return [
            'state' => true,
            'msg' => [
                ['value' => $c1, 'name' => '等待发送'],
                ['value' => $c2, 'name' => '正在发送'],
                ['value' => $c3, 'name' => '已经发送'],
                ['value' => $c4, 'name' => '邮件滞留']
            ]
        ];
    }
}

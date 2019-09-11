<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace app\modules\account\controllers;

use Yii;
use yii\filters\VerbFilter;
use common\models\account\Msg;
use common\models\account\MsgSearch;
use yii\web\NotFoundHttpException;

/**
 * 消息中心
 * Class MsgController
 * @package app\modules\account\controllers
 */
class MsgController extends \app\components\Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                    'read' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * 消息列表展示
     * @return string
     */
    public function actionList()
    {
        $params = [];
        $params['MsgSearch']['msg_type'] = Yii::$app->getRequest()->get('type', null);

        $searchModel = new MsgSearch();
        $dataProvider = $searchModel->search($params);

        return $this->render('list', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * ajax消息详情
     * @param $id
     * @return string
     */
    public function actionDetail($id)
    {
        $model = $this->findModel($id);

        //设置为已读
        Yii::$app->getDb()->createCommand()->update(Msg::tableName(), [
            'msg_readtime' => time(),
        ], [
            'msg_user_id' => Yii::$app->getUser()->getId(),
            'msg_id' => $id,
        ])->execute();

        return $this->renderAjax('detail', [
            'model' => $model,
        ]);
    }

    /**
     * 批量删除操作
     * @return \yii\web\Response
     * @throws \yii\db\Exception
     */
    public function actionDelete()
    {
        $post = Yii::$app->getRequest()->post('checkid');
        Yii::$app->getDb()->createCommand()->update(Msg::tableName(), [
            'msg_deltime' => time(),
        ], [
            'msg_user_id' => Yii::$app->getUser()->getId(),
            'msg_id' => $post,
        ])->execute();

        return $this->asJson([
            'state' => true,
            'code' => 200,
            'msg' => '删除成功',
        ]);
    }

    /**
     * 批量设置为已读
     * @return \yii\web\Response
     * @throws \yii\db\Exception
     */
    public function actionRead()
    {
        $post = Yii::$app->getRequest()->post('checkid');
        Yii::$app->getDb()->createCommand()->update(Msg::tableName(), [
            'msg_readtime' => time(),
        ], [
            'msg_user_id' => Yii::$app->getUser()->getId(),
            'msg_id' => $post,
        ])->execute();

        return $this->asJson([
            'state' => true,
            'code' => 200,
            'msg' => '设置已读成功',
        ]);
    }

    /**
     * 返回一个指定模型
     * @param $id
     * @return Msg|null
     * @throws NotFoundHttpException
     */
    public function findModel($id)
    {
        if($model = Msg::findOne(['msg_id' => $id])) {
            return $model;
        } else {
            throw new NotFoundHttpException('请求页面不存在！');
        }
    }

    /**
     * 测试
     */
    /*
    public function actionCreate()
    {
        //$content, $type ,$userId, $lang
        //反馈消息
        $type = Msg::MSG_TYPE_FEEDBACK;
        $content = ['question' => '问题反馈问题反馈问题反馈问题反馈问题反馈', 'answer' => '问题回答问题回答问题回答问题回答问题回答问题回答问题回答问题回答'];
        $userId = Yii::$app->getUser()->getId();
        $lang = 'zh-CN';
        Msg::SendMsg($type, $content, $userId, $lang);

        //优惠消息
        $type = Msg::MSG_TYPE_DISCOUNT;
        $content = ['content' => '优惠消息优惠消息优惠消息<a href="">优惠消息</a>优惠消息优惠消息优惠消息优惠消息优惠消息'];
        Msg::SendMsg($type, $content, $userId, $lang);

        echo '添加成功';
    }
    */
}
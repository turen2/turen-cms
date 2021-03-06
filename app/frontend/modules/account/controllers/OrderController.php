<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace frontend\modules\account\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use common\models\account\InquirySearch;
use common\models\account\Inquiry;

/**
 * 服务订单管理
 * Class OrderController
 * @package app\modules\account\controllers
 */
class OrderController extends \frontend\components\Controller
{
    /**
     * 服务订单列表
     * @return string
     */
    public function actionList()
    {
        $searchModel = new InquirySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('list', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * ajax返回详情
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionDetail($id)
    {
        $model = $this->findModel($id);
        return $this->renderAjax('detail', [
            'model' => $model,
        ]);
    }

    /**
     * 返回一个指定模型
     * @param $id
     * @return Inquiry|null
     * @throws NotFoundHttpException
     */
    public function findModel($id)
    {
        if($model = Inquiry::findOne(['ui_id' => $id])) {
            return $model;
        } else {
            throw new NotFoundHttpException('请求页面不存在！');
        }
    }
}
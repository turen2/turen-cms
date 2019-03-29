<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace app\controllers;

use common\models\shop\Product;
use yii\web\NotFoundHttpException;

class ServiceController extends \app\components\Controller
{
    /**
     * 服务详情
     * @return string
     */
    public function actionDetail($slug)
    {
        $curModel = $this->findModel($slug);
        $models = Product::find()->active()->orderBy(['orderid' => SORT_DESC])->all();
        return $this->render('detail', [
            'curModel' => $curModel,
            'models' => $models,
            'slug' => $slug,
        ]);
    }

    /**
     * 生成咨询单，并发短信，邮件，微信通知等
     * @return string
     */
    public function actionConsult()
    {
        return $this->render('consult');
    }

    protected function findModel($slug)
    {
        $model = Product::find()->active()->where(['slug' => $slug])->one();
        if (!is_null($model)) {
            return $model;
        } else {
            throw new NotFoundHttpException('请求页面不存在！');
        }
    }
}
